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
include_once '../../pages/campaigns/campaignclass.php';
include_once '../../config/general.php';
$con = new Campaign();
$stat = $con->get_statusIDByName('In Review');

if (isset($_POST['Submit'])){

	$con->set_inreviewStatus($campaignID, $stat);
	header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');

}else if (isset($_POST['Cancel'])){
	header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');
}


$reviewers = $con->get_reviewers($campaignID);
?>
<p>Recall</p>

	
<h5>Are you sure you want to recall this campaign and place it back in Edit mode?</h5>
<form name="sendReview" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input name="cid" type="hidden" value="<?php echo $_GET['ID']; ?>"/>
<input name="Submit" type="submit" value="Submit" />
<input name="Cancel" type="submit" value="Cancel" />
</form>
