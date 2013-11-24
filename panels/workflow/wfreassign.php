<h1>Reassign Campaign</h1>
<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcampaign");


if (isset($_POST['Reassign'])){
include '../../config/DB_Class.php';


	include_once '../../pages/campaigns/campaignclass.php';
	include_once '../../config/general.php';
	
	echo "Reassigning campaign ". $_POST['campaignID'] ." to " . $_POST['assignTo'];
	$con = new Campaign();
	$newOwner = $con->set_NewOwner($_POST['campaignID'], $_POST['assignTo']);
	$page = $_POST['page'];

	if ($page == 'a'){
		header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');
		}else{
		header('Location: '.$siteUrl.'member.php#!/campaigns');
	}

}
?>


<fieldset name="Group1">
				<legend>Reassign Campaign</legend>
				<p>This action will assign a new owner to the campaign.</p>
<h5>Select a new owner</h5>
<form name="reassign" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<select name="assignTo" >
		<option value="none">No Selection</option>

<?php 

	//echo "Test";
	include_once '../../pages/user/userclass.php';
	//echo "Test";
	$allusers = new User();
 $list = $allusers->get_allusers();
 
 //print_r($list);
	
 while ($user = mysql_fetch_assoc($list))
 {
 		if ($user['userID'] != $uid){
 			
 				echo "<option value =\"".$user['userID']."\">". $user['userLastName'] . ", " . $user['userFirstName'] ."  (".$user['userEMailAddress'].")</option>";
 			
 		}
 }
 mysql_data_seek($list ,0);
?>
		</select>
<input name="campaignID" type="hidden" value="<?php echo $_GET['ID']; ?>"/>
<input type="hidden" name="page" value="<?php echo $_GET['page'];?>" />

<input name="Reassign" type="submit" value="Reassign" />
</form>

</fieldset>

