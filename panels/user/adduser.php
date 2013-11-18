<h1>Add New User</h1>

<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("useredit");


include("../../pages/user/userclass.php");

 
$newUser = new User();


?>
<form name="userform" method="post" action="../<?php echo $_SERVER['PHP_SELF'];?>">
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

<tr><td>  </td></tr>
<tr><td>  </td></tr>
<tr>
<td valign="top">
<h3>Set Password</h3>
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

  <input type="submit" Name="Add" value="Add">
  
  </td>
</tr>
</table>
</form>

<?php 


	// Connects to your Database 
	include '../../config/DB_Connect.php';
	include '../../config/functions.php';
	include_once '../../config/general.php';
	//Message class used to retrieve any messages sent to this page.			
	$error = false;
	//This code runs if the form has been submitted
	if (isset($_POST['Add'])) { 

		//This makes sure they did not leave any fields blank
		if (!$_POST['userFirstName'] | !$_POST['userLastName'] | !$_POST['userEMailAddress'] | !$_POST['password'] | !$_POST['cpassword'] ) {
	 		$error = true;
	 		header('Location: '.$siteUrl.'member.php#!/account?msgID=407');		
			}
		// checks to see if usernames is an email address and if the username is in use
	 	if (!check_email_address($_POST['userEMailAddress'])){
	 		$error = true;
	 		header('Location: '.$siteUrl.'member.php#!/account?msgID=405');
	 		}
	 	if (!get_magic_quotes_gpc()) {
	 		$_POST['userEMailAddress'] = addslashes($_POST['userEMailAddress']);
	 		}
	
		$check = mysql_query("SELECT userEMailAddress FROM tbl_user WHERE userEMailAddress = '".$_POST['userEMailAddress']."'") 
			or die(mysql_error());
		$check2 = mysql_num_rows($check);
	
	 	//if the name exists it gives an error
	 	if ($check2 != 0) {
	 		$error = true;
	 		header('Location: '.$siteUrl.'member.php#!/account?msgID=408');
	 		}
	
		// this makes sure both passwords entered match and are of proper length and complexity
	 	if (!check_password($_POST['password'])){
	 		$error = true;
	 		header('Location: '.$siteUrl.'member.php#!/account?msgID=404');
	 	 	}
	 	if ($_POST['password'] != $_POST['cpassword']) {
	 		$error = true;
	 		header('Location: '.$siteUrl.'member.php#!/account?msgID=406');
	 	 	}
	
	 	// here we encrypt the password and add slashes if needed
	 	$_POST['password'] = md5($_POST['password']);
	 	if (!get_magic_quotes_gpc()) {
	 		$_POST['password'] = addslashes($_POST['password']);
	 		$_POST['userEMailAddress'] = addslashes($_POST['userEMailAddress']);
			}
		
		$accountStat = 1;
		if ($_POST['userAccountStatus'] == "on"){
		$accountStat = 0;
		}else{
		$accountStat = 1;
		}
		$role = 0;
		if ($_POST['userRole'] == "User"){
		$role = 0;
		}else{
		$role = 1;
		}


	 
		 
		// now we insert it into the database
	  	if ($error == false){
	 	$insert = "INSERT INTO tbl_user (userFirstName, userLastName, userEMailAddress, userPhoneNumber, userPassword, userAccountStatus, userRole)
	 			VALUES ('".mysql_real_escape_string($_POST['userFirstName'])."', '".mysql_real_escape_string($_POST['userLastName'])."', '".mysql_real_escape_string($_POST['userEMailAddress'])."', 
	 			'".mysql_real_escape_string($_POST['userPhoneNumber'])."', '".mysql_real_escape_string($_POST['password'])."', '".$accountStat."', '".$role."')";
	 	$add_member = mysql_query($insert) or die(mysql_error());
	 	
	 	$msgID = $newUser->user_add();
	 	}else{
	 	$msgID = 409;
	 	}
		 /*$to = "".$_POST['userEMailAddress']."";
		 $subject = "EMVI Registration";
		 $txt = "Thank you! \n\nYou have successfully requested access to the EMVI tool.\n\n\n\n Your username is ".$userEMailAddress." . \n";
		 $txt =	$txt.  "You can log at http://www.ubno.com/EMVI/ once your account is approved\n\n";
		 
		 $txt = $txt. "If you experiance problems logging into the site please contact\n\nDavid Wise\n540-663-4059\nDSSMWise@gmail.com.";
		 $headers = "From: Admin@emvious.com";
		 
		mail($to,$subject,$txt,$headers);
		
				$error = 'Thank You for registering for access.  Your account request is being verified!  You will be notified at the E-Mail address the you registered with this account once the account has been verified.';
		*/		
		
	
	
		header('Location: '.$siteUrl.'member.php#!/account?msgID='.$msgID);		
		
	} 
 
	
	/*if(isset($_POST['Add']))
	{
		$newUser->userFirstName = $_POST['userFirstName'];
		$newUser->userLastName = $_POST['userLastName'];
		$newUser->userEMailAddress = $_POST['userEMailAddress'];
		$newUser->userPhoneNumber = $_POST['userPhoneNumber'];
		if ($_POST['userAccountStatus'] == "on"){
		$newUser->userAccountStatus = 0;
		}else{
		$newUser->userAccountStatus = 1;
		}
		if ($_POST['userRole'] == "User"){
		$newUser->userRole = 0;
		}else{
		$newUser->userRole = 1;
		}
		$msgID = $newUser->user_add();
		//$newUser->user_change_password($_POST['password'], $_POST['cpassword']);

		include_once '../../config/general.php';	
		header('Location: '.$siteUrl.'member.php#!/account?msgID='.$msgID);
		
	}
*/	

 
?>

