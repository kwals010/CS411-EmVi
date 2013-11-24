<h1>Recall Campaign</h1>
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
$stat = $con->get_statusIDByName('Edit');

if (isset($_POST['Submit'])){
	$page = $_POST['page'];
	$con->set_recallreviewStatus($campaignID, $stat);
	//header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');
	if ($page == 'a'){
		header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');
		}else{
		header('Location: '.$siteUrl.'member.php#!/campaigns');
	}

}else if (isset($_POST['Cancel'])){
	$page = $_POST['page'];
	//header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');
	if ($page == 'a'){
		header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');
		}else{
		header('Location: '.$siteUrl.'member.php#!/campaigns');
	}
}


$reviewers = $con->get_reviewers($campaignID);
?>
<fieldset name="Group1">
				<legend>Recall Campaign</legend>
<p>Recalling the campaign will set it back in edit mode and<br>
   stop the review 
proccess.</p>

<h5>Your selected reviewers who will lose<br>
    sight of this campaign are:</h5>
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
	
<h5>Are you sure you want to recall this<br>
    campaign?</h5>
<form name="sendReview" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input name="cid" type="hidden" value="<?php echo $_GET['ID']; ?>"/>
<input type="hidden" name="page" value="<?php echo $_GET['page'];?>" />

<input name="Submit" type="submit" value="Recall Campaign" />
<input name="Cancel" type="submit" value="Cancel" />
</form>
</fieldset>
