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
include_once '../../pages/include/config.php';

include_once '../../pages/campaigns/campaignclass.php';
include_once '../../config/general.php';
$con = new Campaign();
$stat = $con->get_statusIDByName('In Review');
$reviewers = $con->get_reviewers($campaignID);
if (isset($_POST['Submit'])){

	$con->set_inreviewStatus($campaignID, $stat);
	 $to = "";

	While ($assignRev = mysql_fetch_assoc($reviewers)){
		if ($to == ""){
			$to = $assignRev['userEmailAddress'];
		}else{
			$to = $to . ", " . $assignRev['userEmailAddress'];

		}

	}
		
 		$subject = "You have been selected as a Campaign reviewer for ... ";
 		$txt = "You have been selected as a reviewer for the ... campaign.  You will now be able to see this task in you work area in the EmVi tool.";
 		$headers = "From: Administrator@emvi.com";
 
		mail($to,$subject,$txt,$headers);
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
