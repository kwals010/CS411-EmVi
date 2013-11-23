<h1>Edit User Account</h1>
<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
showSidebar("useredit");


include("../../pages/user/userclass.php");
include("../../config/general.php");
 
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
						
				 	// multiple recipients
				$to  = $_POST['userEMailAddress']; // note the comma
				$random_hash = md5(date('r', time())); 
				
				// subject
				$subject = 'EmVi Account Deactivation';
				
				// message
				$message = '
				<html>
				<head>
				  <title>EmVi Account Deactivation</title>
				</head>
				<body>
				<p><img style="float: left; height: 189px; opacity: 0.9; width: 390px;" src="http://www.cs.odu.edu/~411orang/img/email-marketing.png" alt="" /></p>
				<div style="background: #eee; border: 1px solid #ccc; padding: 5px 10px;">
				<p>&nbsp;</p>
				<p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<strong><span style="color: #999966; font-size: 72px;">EmVi</span></strong></p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				</div>
				<p><span style="color: #999966; font-size: large;">&nbsp;</span></p>
				<p><span style="color: #999966;"><span style="font-size: 36px;"><strong>Hello '.$_POST['userFirstName'].',</strong></span></span></p>
				<p><span style="color: #999966;"><span style="font-size: 28px;"><strong>This is a short message just letting you know that we have deactivated your EmVi account as requested. If you decide that you would like to utilize EmVi\'s services again feel free to visit us at </strong></span></span><strong><span style="font-size: 28px;"><a href="'.$siteUrl.'"><span style="color: #999966;">'.$siteUrl.'</span></a><span style="color: #999966;">. We have provided information below, just to give you a&nbsp;</span></span></strong><strong><span style="font-size: 28px;"><span style="color: #999966;">quick recap of&nbsp;what EmVi can do!</span></span></strong></p>
				<p><span style="font-size: xx-large;"><strong><span style="color: #999966;">Sincerely,</span></strong></span></p>
				<p><strong style="font-size: xx-large;"><span style="color: #999966;">EmVi Team</span></strong></p>
				<div style="background: #eee; border: 1px solid #ccc; padding: 5px 10px;">
				<p><strong><span style="font-size: 16px;">EmVi is a tool that will allow you to easily create&nbsp;Email Campaigns.</span>&nbsp;</strong><span style="font-size: 16px;">No download&nbsp;required, just login to the site and upload your content to begin creating campaigns.</span></p>
				<p><strong><span style="font-size: 16px;">EmVi gives you the ability to manage campaigns.&nbsp;</span></strong><span style="font-size: 16px;">With EmVi you can assign contributers to your campaign and set up an approval process to ensure your campaigns have been thoroughly looked over before publishing them.</span></p>
				<p><strong><span style="font-size: 16px;">EmVi allows you to reuse content.&nbsp;</span></strong><span style="font-size: 16px;">Content is not specific to any one campaign, you can easily reuse the same content or edit it and resave it as different content.</span></p>
				<p><span style="font-size: 16px;"><strong>EmVi provides you with campaign previews. </strong>With the push of a button you can send out previews of your campaign to an email recipients list.&nbsp;</span></p>
				<p><span style="font-size: 16px;"><strong>EmVi lets you quickly edit content. </strong>No need to correct and reupload content, with EmVI you can hot edit content in the environment.</span></p>
				<p><span style="font-size: 16px;"><strong>EmVi lets you publish images to the CDN. </strong>Easily publish campaign images to the Rackspace CDN from the EmVi environment.</span></p>
				<p><span style="font-size: 16px;"><strong>EmVi lets you do a keyword search when browsing for content. </strong>Tired of scrolling through content looking for what you need? Thankfully EmVi provides you with a built in search function.&nbsp;</span></p>
				</div>
				<div style="background: #cc6666; border: 1px solid #ccc; padding: 5px 10px;">
				<p style="text-align: right;">Create Flawless Campaigns with EmVi</p>
				</div>
				</body>
				</html>';
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers .= 'To: '.$_POST['userFirstName'].' <'.$_POST['userEMailAddress'].'>' . "\r\n";
				$headers .= 'From: EmVi Administratorr <Admin@EmVi.com>' . "\r\n";
				
				//$headers .= 'Cc: dssmwise@gmail.com' . "\r\n";
				
				// Mail it
				mail($to, $subject, $message, $headers);
				
				 	
				
			}else{
				
						
				 	// multiple recipients
				$to  = $_POST['userEMailAddress']; // note the comma
				$random_hash = md5(date('r', time())); 
				
				// subject
				$subject = 'EmVi Account Activation';
				
				// message
				$message = '
				<html>
				<head>
				  <title>EmVi Account Activation</title>
				</head>
				<body>
				<p><img style="float: left; height: 189px; opacity: 0.9; width: 390px;" src="http://www.cs.odu.edu/~411orang/img/email-marketing.png" alt="" /></p>
				<div style="background: #eee; border: 1px solid #ccc; padding: 5px 10px;">
				<p>&nbsp;</p>
				<p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<strong><span style="color: #999966; font-size: 72px;">EmVi</span></strong></p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				</div>
				<p><span style="color: #999966; font-size: large;">&nbsp;</span></p>
				<p><span style="color: #999966;"><span style="font-size: 36px;"><strong>Hello '.$_POST['userFirstName'].',</strong></span></span></p>
				<p><span style="color: #999966;"><span style="font-size: 28px;"><strong>This is a short message just letting you know that we have activated your EmVi account as requested. You can login to use EmVi anytime at&nbsp;</strong></span></span><strong><span style="font-size: 28px;"><a href="'.$siteUrl.'"><span style="color: #999966;">'.$siteUrl.'</span></a><span style="color: #999966;">. We have provided information below, just to give you a&nbsp;</span></span></strong><strong><span style="font-size: 28px;"><span style="color: #999966;">quick run through of&nbsp;what EmVi can do for you!</span></span></strong></p>
				<p><span style="font-size: xx-large;"><strong><span style="color: #999966;">Sincerely,</span></strong></span></p>
				<p><strong style="font-size: xx-large;"><span style="color: #999966;">EmVi Team</span></strong></p>
				<div style="background: #eee; border: 1px solid #ccc; padding: 5px 10px;">
				<p><strong><span style="font-size: 16px;">EmVi is a tool that will allow you to easily create&nbsp;Email Campaigns.</span>&nbsp;</strong><span style="font-size: 16px;">No download&nbsp;required, just login to the site and upload your content to begin creating campaigns.</span></p>
				<p><strong><span style="font-size: 16px;">EmVi gives you the ability to manage campaigns.&nbsp;</span></strong><span style="font-size: 16px;">With EmVi you can assign contributers to your campaign and set up an approval process to ensure your campaigns have been thoroughly looked over before publishing them.</span></p>
				<p><strong><span style="font-size: 16px;">EmVi allows you to reuse content.&nbsp;</span></strong><span style="font-size: 16px;">Content is not specific to any one campaign, you can easily reuse the same content or edit it and resave it as different content.</span></p>
				<p><span style="font-size: 16px;"><strong>EmVi provides you with campaign previews. </strong>With the push of a button you can send out previews of your campaign to an email recipients list.&nbsp;</span></p>
				<p><span style="font-size: 16px;"><strong>EmVi lets you quickly edit content. </strong>No need to correct and reupload content, with EmVI you can hot edit content in the environment.</span></p>
				<p><span style="font-size: 16px;"><strong>EmVi lets you publish images to the CDN. </strong>Easily publish campaign images to the Rackspace CDN from the EmVi environment.</span></p>
				<p><span style="font-size: 16px;"><strong>EmVi lets you do a keyword search when browsing for content. </strong>Tired of scrolling through content looking for what you need? Thankfully EmVi provides you with a built in search function.&nbsp;</span></p>
				</div>
				<div style="background: #cc6666; border: 1px solid #ccc; padding: 5px 10px;">
				<p style="text-align: right;">Create Flawless Campaigns with EmVi</p>
				</div>
				</body>
				</html>';
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers .= 'To: '.$_POST['userFirstName'].' <'.$_POST['userEMailAddress'].'>' . "\r\n";
				$headers .= 'From: EmVi Administratorr <Admin@EmVi.com>' . "\r\n";
				
				//$headers .= 'Cc: dssmwise@gmail.com' . "\r\n";
				
				// Mail it
				mail($to, $subject, $message, $headers);
				
				 	

			}
		}
	
	
		$edit->userFirstName = mysql_real_escape_string($_POST['userFirstName']);
		$edit->userLastName = mysql_real_escape_string($_POST['userLastName']);
		$edit->userEMailAddress = mysql_real_escape_string($_POST['userEMailAddress']);
		$edit->userPhoneNumber = mysql_real_escape_string($_POST['userPhoneNumber']);
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
