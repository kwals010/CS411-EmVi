<h1>Campaign View</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("an_example");


include_once '../../pages/user/userclass.php';

session_start();
$uid = $_SESSION['ID'];
$campaign = $_GET['ID'];

if (isset($_POST['approve'])){
	echo "campaign has been approved";
	include '../../config/DB_Class.php';
	include_once '../../pages/workflow/workflowclass.php';
	include_once '../../config/general.php';
	$myReview = new Workflow();
	$myReview->set_approved($_POST['campaignID'], $uid, $_POST['revComment']);
	header('Location: '.$siteUrl.'member.php#!/reviewtasks');

}

if (isset($_POST['reject'])){
	echo "campaign has been approved";
	include '../../config/DB_Class.php';
	include_once '../../pages/workflow/workflowclass.php';
	include_once '../../config/general.php';
	$myReview = new Workflow();
	$myReview->set_reject($_POST['campaignID'], $uid, $_POST['revComment']);
	header('Location: '.$siteUrl.'member.php#!/reviewtasks');

}


?>

<h2>Review Decision</h2>
<form name="decision" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input name="campaignID" type="hidden" value="<?php echo $campaign; ?>"/>
<table>
<tr>
	<td>Comments</td>
	<td><textarea name="revComment" style="width: 472px; height: 261px"></textarea>
</td>
</tr>
<tr>

<td><input name="approve" type="submit" value="Approve" style="width: 68px; height: 26px"/></td>
<td><input name="reject" type="submit" value="Reject" style="width: 68px; height: 26px" /></td>
</tr>
</table>


</form>
