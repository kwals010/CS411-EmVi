<h1>Send Campaign for Review</h1>
<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcampaign");


session_start();
$uid = $_SESSION['ID'];
if (isset($_GET['ID'])){
$campaignID = $_GET['ID'];
}else if(isset($_POST['cid'])){
$campaignID = $_POST['cid'];
}
include '../../config/DB_Class.php';

include_once '../../pages/campaigns/campaignclass.php';
include_once '../../config/general.php';
$con = new Campaign();
$stat = $con->get_statusIDByName('In Review');
$reviewers = $con->get_reviewers($campaignID);
if (isset($_POST['Submit'])){
		$thisCampaign = $con ->get_campaignByID($campaignID);

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		
	

		
		// multiple recipients
	$con->set_inreviewStatus($campaignID, $stat);
	 $to = "";

	While ($assignRev = mysql_fetch_assoc($reviewers)){
		if ($to == ""){
			$to = $assignRev['userEmailAddress'];
			$headers .= 'To: '.$assignRev['userFirstName'].' <'.$assignRev['userEMailAddress'].'>' . "\r\n";

		}else{
			$to = $to . ", " . $assignRev['userEmailAddress'];
			$headers .= ', '.$assignRev['userFirstName'].' <'.$assignRev['userEMailAddress'].'>' . "\r\n";
		}

	}
		$headers .= 'From: EmVi Administratorr <Admin@EmVi.com>' . "\r\n";
	
$random_hash = md5(date('r', time())); 

// subject
$subject = 'EmVi Reviewer For \''.$thisCampaign['campaignName'].'\'';

// message
$message = '
<html>
<head>
  <title>EmVi Reviewer</title>
</head>
<body>
<p><img style="float: left; height: 189px; opacity: 0.9; width: 390px;" src="http://www.cs.odu.edu/~411orang/img/email-marketing.png" alt="" /></p>
<div style="background: #eee; border: 1px solid #ccc; padding: 5px 10px;">
<p>&nbsp;</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<strong><span style="color: #999966; font-size: 72px;">EmVi</span></strong></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><span style="font-size: large; color: #999966;">&nbsp;</span></p>
</div>
<p>&nbsp;</p>
<p><span style="color: #999966;"><span style="font-size: 36px;"><strong>Hello Review Team,</strong></span></span></p>
<p><span style="color: #999966;"><span style="font-size: 28px;"><strong>You have been assigned as a reviewer for the \''.$thisCampaign['campaignName'].'\' campaign. Please login at your earliest convenience to evaluate the campaign. Thank you for utilizing EmVi for all of your campaign creation needs. &nbsp;</strong></span></span></p>
<p><span style="color: #999966; font-size: x-large;">&nbsp;</span></p>
<p><span style="font-size: xx-large;"><strong><span style="color: #999966;">Sincerely,</span></strong></span></p>
<p><span style="font-size: xx-large;"><strong><span style="color: #999966;">EmVi Team</span></strong></span></p>
<p><span style="color: #999966; font-size: x-large;"><strong>&nbsp;</strong></span></p>
<div style="background: #eee; border: 1px solid #ccc; padding: 5px 10px;">
<p style="text-align: right;"><strong><em>&nbsp;Create Flawless Campaigns with EmVi</em></strong></p>
</div></body>
</html>

';



// Mail it
mail($to, $subject, $message, $headers);

 	

	header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');

}else if (isset($_POST['Cancel'])){
	header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');
}

mysql_data_seek($reviewers ,0);


?>
<p>Sending a campaign on for review will prevent you from making any further changes to the campaign unitl the review proccess is complete.</p>

<h5>Your selected reviewers are:</h5>
<table>
	<tbody class="tablebody">
		
			<?php
			While ($assignRev = mysql_fetch_assoc($reviewers)){
				
				
				echo "<tr>";
				echo	"<td class=\"tablebody\">".$assignRev['userLastName']. ", ".$assignRev['userFirstName'] ."</td>";
				echo "</tr>";
				
			}
			?>
		</tbody>
	</table>
	
<h5>Are you sure you want to submit this campaign for review?</h5>
<form name="sendReview" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input name="cid" type="hidden" value="<?php echo $_GET['ID']; ?>"/>
<input name="Submit" type="submit" value="Submit" />
<input name="Cancel" type="submit" value="Cancel" />
</form>
