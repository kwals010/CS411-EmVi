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
include_once '../../pages/include/config.php';

include_once '../../pages/campaigns/campaignclass.php';
include_once '../../config/general.php';
$con = new Campaign();
$stat = $con->get_statusIDByName('Edit');

if (isset($_POST['Submit'])){

	$con->set_recallreviewStatus($campaignID, $stat);
	header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');

}else if (isset($_POST['Cancel'])){
	header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');
}


$reviewers = $con->get_reviewers($campaignID);
?>
<p>Recalling the campaign will set it back in edit mode and stop the review 
proccess.</p>

<h5>Your selected reviewers that will lose sight of this campaign are:</h5>
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
	
<h5>Are you sure you want to recall this campaign?</h5>
<form name="sendReview" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input name="cid" type="hidden" value="<?php echo $_GET['ID']; ?>"/>
<input name="Submit" type="submit" value="Submit" />
<input name="Cancel" type="submit" value="Cancel" />
</form>
