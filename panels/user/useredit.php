<h1>Edit User Account</h1>
<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
showSidebar("useredit");


include("../../pages/user/userclass.php");

 
$edit = new User();
$edit = $edit->withID($_GET['ID']);

?>
<script type="text/javascript">
<!--
function validateForm() {
	var r=confirm("Are you sure you want to remove <?php echo $edit->userFirstName; ?> <?php echo $edit->userLastName; ?>'s account?");
	if (r) {
		return true;
	 }
	 else {
	   return false;
	 } 
 }
//--> 
</script>


<form name="userform" method="post" action="../<?php echo $_SERVER['PHP_SELF']."?ID=".$_GET['ID'];?>">
<table width="450px">
<tr>
<td valign="top">
<h3>Account Info</h3>
</td>
</tr>

<tr>

 <td valign="top">
  <label for="userFirstName">First Name *</label>
 </td>
 <td valign="top">
  <input  type="text" name="userFirstName" maxlength="50" size="30" value="<?php echo $edit->userFirstName; ?>">
 </td>
</tr>
 
<tr>
 <td valign="top"">
  <label for="userLastName">Last Name *</label>
 </td>
 <td valign="top">
  <input  type="text" name="userLastName" maxlength="50" size="30" value="<?php echo $edit->userLastName; ?>">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="userEMailAddress">Email Address *</label>
 </td>
 <td valign="top">
  <input  type="text" name="userEMailAddress" maxlength="80" size="30" value="<?php echo $edit->userEMailAddress; ?>">
 </td>
 
</tr>
<tr>
 <td valign="top">
  <label for="userPhoneNumber">Telephone Number</label>
 </td>
 <td valign="top">
  <input  type="text" name="userPhoneNumber" maxlength="30" size="30" value="<?php echo $edit->userPhoneNumber; ?>">
 </td>
</tr>

<tr>
 <td valign="top">
  <label for="userRole">User Role</label>
 </td>
 <td valign="top">
 	<?php 
 		if ($edit->userRole == 0){
 		echo "<select name=\"userRole\" value=\"User\"><option>User</option><option>Administrator</option>" ;
 		}else{
 		echo "<select name=\"userRole\" value=\"Administrator\"><option>Administrator</option><option>User</option></select>";
 		}
 	?>
 </td>
</tr>


<tr>
 <td valign="top">
  <label for="userAccountStatus">Account Locked</label>
 </td>
 <td valign="top">
  <?php 
 
  if($edit->userAccountStatus==0)
  	{ 
  		echo "<input  type=\"checkbox\" name=\"userAccountStatus\" value=\"on\" checked>"; 
  	}else{
		echo "<input  type=\"checkbox\" name=\"userAccountStatus\" value\"off\">";  	
	} 
  
  ?>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input name="case" type="hidden" value="userform">

  <input type="submit" Name="Update" value="Update">
  <input type="submit" name="Remove" onclick="return validateForm()" value="Remove">
  </td>
</tr>
</table>
</form>

<form name="cPassword" method="post" action="../<?php echo $_SERVER['PHP_SELF']."?ID=".$_GET['ID'];?>">
<table width="450px">
<tr>

<tr><td>  </td></tr>
<tr><td>  </td></tr>
<tr>
<td valign="top">
<h3>Change Password</h3>
</td>
</tr>
<tr>
 <td valign="top">
  <label for="password">Password</label>
 </td>
 <td valign="top">
  <input  type="password" name="password">
 </td>
 
</tr>
<tr>
 <td valign="top">
  <label for="cpassword">Confirm Password</label>
 </td>
 <td valign="top">
  <input  type="password" name="cpassword">
 </td>
 
</tr>

<tr>
 <td colspan="2" style="text-align:center">
  <input name="case" type="hidden" value="userform">

  <input type="submit" Name="cPassword" value="Change Password">
  
  </td>
</tr>
</table>
</form>


<?php
	
	if(isset($_POST['Update']))
	{
	
	if ($_POST['userAccountStatus'] == "on"){
		$accountStatus = 0;
		}else{
		$accountStatus = 1;
		}
		
	
		if ($edit->userAccountStatus != $accountStatus){
			if ($accountStatus == 0){
				$to = $_POST['userEMailAddress'];
 				$subject = "EMVI Account Status";
 				$txt = "Test disabled";
 				$headers = "From: Administrator@emvi.com";
 
				mail($to,$subject,$txt,$headers);
				
			}else{
				
				$to = $_POST['userEMailAddress'];
 				$subject = "EMVI Account Status";
 				$txt = "Test Enabled";
 				$headers = "From: Administrator@emvi.com";
 
				mail($to,$subject,$txt,$headers);

			}
		}
	
	
		$edit->userFirstName = $_POST['userFirstName'];
		$edit->userLastName = $_POST['userLastName'];
		$edit->userEMailAddress = $_POST['userEMailAddress'];
		$edit->userPhoneNumber = $_POST['userPhoneNumber'];
		$edit->userAccountStatus = $accountStatus;

		/*if ($_POST['userAccountStatus'] == "on"){
		$edit->userAccountStatus = 0;
		}else{
		$edit->userAccountStatus = 1;
		}
*/		if ($_POST['userRole'] == "User"){
		$edit->userRole = 0;
		}else{
		$edit->userRole = 1;
		}
		$msgID = $edit->user_update();

		include_once '../../config/general.php';	
		header('Location: '.$siteUrl.'member.php#!/account?msgID='.$msgID);
		
	}
	if(isset($_POST['Remove'])){
		$msgID = $edit->userRemove();

		include_once '../../config/general.php';	
		header('Location: '.$siteUrl.'member.php#!/account?msgID='.$msgID);

	}
	if(isset($_POST['cPassword'])){
		$msgID = $edit->user_change_password($_POST['password'], $_POST['cpassword']);

		include_once '../../config/general.php';	
		header('Location: '.$siteUrl.'member.php#!/account?msgID='.$msgID);

	}


?>
