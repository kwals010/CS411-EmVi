<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>Clone Email</h1>
<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcontent");

include_once '../../config/DB_Class.php';
include_once '../../pages/email/emailclass.php';
include_once '../../pages/content/contentclass.php';
include_once '../../pages/user/userclass.php';
include_once '../../config/general.php';

session_start();

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

}
?>


<script type="text/javascript">
function validateForm()
 {
 var name=document.forms["aEmail"]["name"].value;
 var desc=document.forms["aEmail"]["description"].value;
 var fname=document.forms["aEmail"]["from_name"].value;
 var faddr=document.forms["aEmail"]["from_address"].value;
 var subj=document.forms["aEmail"]["subject"].value;

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
 else if (fname == null || fname =="")
 {
	 alert("From name cannot be blank.");
	 return false;
 }
 else if (faddr == null || faddr =="")
 {
	 alert("From address cannot be blank.");
	 return false;
 }
 else if (subj == null || subj =="")
 {
	 alert("Subject cannot be blank.");
	 return false;
 }
}
</script>

<?php 
// This section handles the page submission and the saving of data to the database
if (!empty($_POST)) {
	$ename = $_POST["name"];
	$edesc = $_POST["description"];
	// check keywords. If the default string was left in the box, zero it out
	if ($_POST["keywords"] == '(comma delimited)'){
		$kw = '';
	}
	else {
		$kw = $_POST["keywords"];
	}
	$efname = $_POST["from_name"];
	$efaddr= $_POST["from_address"];
	$esubj = $_POST["subject"];
	$etxt = $email[emailText];
	$ehtml = $email[emailHTML];
	

	// Function to write data to the DB is public function add_email($uid,$name,$desc,$kw,$fname,$subj,$faddress,$txt,$html)
	$em->add_email($uid, mysql_real_escape_string($ename), mysql_real_escape_string($edesc), mysql_real_escape_string($kw), mysql_real_escape_string($efname), mysql_real_escape_string($esubj), $efaddr, $email[emailText], $email[emailHTML]);
	//echo $etxt . ' ' . $ehtml . '<br>';	
	// Function that will update the canEdit field on the content
	$con->lock_content($etxt,$uid);
	$con->lock_content($ehtml,$uid);		
	// Redirect the landing page back to the content main page
	header('Location: '. $siteUrl . 'member.php#!/email');
}
?>



<form name="aEmail" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'] . "?ID=$eid";?>">
<fieldset name="Group1"><legend>Email Properties</legend>
<table width="450px"><tr>
		<td>Email name</td>
		<td><input type="text" name="name" value="<?php echo $email[emailName]; ?>"/></td>
	</tr>
	<tr>
		<td>Email description</td>
		<td><input type="text" name="description" value="<?php echo $email[emailDescription]; ?>"/></td>
	</tr>
	<tr>
		<td>Email keywords</td>
		<td><textarea rows="3" cols="20" name="keywords"><?php echo $email[emailKeywords]; ?></textarea></td>
	</tr>
		<tr>
		<td>From name</td>
		<td><input type="text" name="from_name" value="<?php echo $email[emailFromName]; ?>"/></td
	</tr>
		<tr>
		<td>From address</td>
		<td><input type="text" name="from_address" value="<?php echo $email[emailFromAddress]; ?>"/></td
	</tr>
		<tr>
		<td>Subject line</td>
		<td><input type="text" name="subject" value="<?php echo $email[emailSubject]; ?>"/></td
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Save Copy"></td>
	</tr>
</table></fieldset>
</form>
<?php 
	$html = $con->get_contentByID($email[emailHTML]);
	$text = $con->get_contentByID($email[emailText]);
	echo '<fieldset name="Group1"><legend>Email Content</legend><table align="left" cellpadding="0" cellspacing="0" width="300">
		<tr><td align="left">HTML:</td><td align="left">Text:</td></tr>
		<tr><td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.html" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.png' . '" width="200"></a></td>
		<td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.txt" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.png' . '" width="200"></a></td></tr>
		</table></fieldset>';
			?>