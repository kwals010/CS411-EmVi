<h1>Reassign Campaign</h1>
<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcampaign");

?>

<h5>Select a new owner</h5>
<form>
<select name="Reviewer1" >
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
 			
 				echo "<option value =\"".$user['userID']."\">". $user['userLastName'] . ", " . $user['userFirstName'] . "</option>";
 			
 		}
 }
 mysql_data_seek($list ,0);
?>
		</select>

</form>



<p>Uae this page to reassign a campaign to a new owner.</p>