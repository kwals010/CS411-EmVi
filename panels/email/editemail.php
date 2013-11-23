<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>Edit Email</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("editcontent");

include_once '../../config/DB_Class.php';
include_once '../../pages/email/emailclass.php';
include_once '../../pages/content/contentclass.php';
include_once '../../pages/user/userclass.php';
include_once '../../config/general.php';

session_start();

// Get the user ID out of the session
$uid = $_SESSION['ID'];

// Get the email out of the url
$eid = $_GET['ID'];
if ($eid == null || $eid == '')
{
	echo "No parameter ID = provided in URL<br>";
	die;
}

$em = new Email();
$email = $em->get_emailByID($eid);

// Get content for content files in dropdown
$con = new Content();
$content = $con->get_content('ID','ASC');


foreach ($content as $c) {
	if ($c['Format'] == 'txt') {
		// Array of text content
		$tcon[$c['ID']] = $c['Name'];
	}
	else if ($c['Format'] == 'html') {
		// Array of html content
		$hcon[$c['ID']] = $c['Name'];
	}
	else {
		// Array of image content
		$icon[$c['ID']] = $c['Name'];
	}

	$hcon[0] = '--No Change--';
	$tcon[0] = '--No Change--';

}

?>
<script type="text/javascript">
function validateForm()
 {
 var name=document.forms["eEmail"]["name"].value;
 var desc=document.forms["eEmail"]["description"].value;
 var from=document.forms["eEmail"]["from_name"].value;
 var addr=document.forms["eEmail"]["from_address"].value;
 var subj=document.forms["eEmail"]["subject"].value;
 if (name==null || name=="")
 {
   alert("Email name cannot be blank.");
   return false;
 }
 else if (desc==null || desc=="")
 {
 alert("Email description cannot be blank.");
 return false;
 }
 else if (from == null || from =="")
 {
	 alert("From name cannot be blank.");
	 return false;
 } else if (addr == null || addr =="")
 {
	 alert("From address cannot be blank.");
	 return false;
 }
 else if (subj == null || subj =="")
 {
	 alert("Subject line cannot be blank.");
	 return false;
 }
}
</script>

<?php 

// This section handles the page submission and the saving of data to the database
if (!empty($_POST)) {
 echo "Hello World!";
 
 
 echo $_POST["name"] . "<br>" . $_POST["description"] . "<br>" . $_POST["keywords"] . "<br>";
 
 	if ($_POST["text_content"] != '0') {
		$txt = $_POST["text_content"];
	} else {
		$txt = $email[emailText];
	}
	if ($_POST["html_content"] != '0') {
		$html = $_POST["html_content"];
	} else {
		$html = $email[emailHTML];
	}
 
 $em->update_email($uid,$eid,mysql_real_escape_string($_POST["name"]),mysql_real_escape_string($_POST["description"]),mysql_real_escape_string($_POST["keywords"]),mysql_real_escape_string($_POST["from_name"]),mysql_real_escape_string($_POST["subject"]),mysql_real_escape_string($_POST["from_address"]),$txt,$html);

 // Need to add unlock and lock functions here
 
 
 // Redirect the landing page back to the content main page
 header('Location: '. $siteUrl . 'member.php#!/email');
 
}

?>


<form name="eEmail" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'] . "?ID=$eid";?>">
<fieldset name="Group1"><legend>Email Properties</legend>
<table width="450px"><tr>
<td>Email name</td>
<td><input type="text" name="name" value="<?php echo $email[emailName]; ?>" /></td>
</tr>
<tr>
<td>Email description</td>
<td><input type="text" name="description" value="<?php echo $email[emailDescription]; ?>" /></td>
</tr>
<tr>
<td valign="top">Email keywords</td>
<td><textarea rows="3" cols="20" name="keywords"><?php echo $email[emailKeywords]; ?></textarea></td>
</tr>
<tr>
<td>From name</td>
<td><input type="text" name="from_name" value="<?php echo $email[emailFromName]; ?>" /></td>
</tr>
<tr>
<td>From address</td>
<td><input type="text" name="from_address" value="<?php echo $email[emailFromAddress]; ?>" /></td>
</tr>
<tr>
<td>Subject line</td>
<td><input type="text" name="subject" value="<?php echo $email[emailSubject]; ?>" /></td>
</tr>
</table></fieldset>
<fieldset name="Group1"><legend>Email Content</legend>
<table width="450px"><tr>
		<td>Select text content</td>
		<td>
			<select name="text_content">
			<?php 
			 foreach($tcon as $key=>$value) {
			 		echo "<option name=\"type\" value=\"". $key . "\">". $value ."</option>";
			 }
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Select html content</td>
		<td>
			<select name="html_content">
			<?php 
			 foreach($hcon as $key=>$value)
			 {
			 		echo "<option name=\"type\" value=\"". $key . "\">". $value ."</option>";
			 }
			?>
			</select>
		</td>
	</tr>
		<tr>
		<td></td>
		<td><input type="submit" value="Update Email"></td>
	</tr>
</table></form>
<?php $html = $con->get_contentByID($email[emailHTML]);
$text = $con->get_contentByID($email[emailText]);
	echo '<br><table align="left" cellpadding="0" cellspacing="0" width="300">
		<tr><td align="left">HTML:</td><td align="left">Text:</td></tr>
		<tr><td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.html" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.png' . '" width="200"></a></td>
		<td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.txt" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.png' . '" width="200"></a></td></tr>
		<tr><td align="left">Keywords: ' . $email[emailKeywords] . '</td></tr>
		</table></fieldset>';
			?>