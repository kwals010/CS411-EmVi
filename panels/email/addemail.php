<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>Add Email</h1>
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
$email = new Email();
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
	$etxt = $_POST["text_content"];
	$ehtml = $_POST["html_content"];
	
	// Function that will update the canEdit field on the content
	$con->lock_content($ehtml, $uid);
	$con->lock_content($etxt, $uid);
	// Function to write data to the DB is public function add_email($uid,$name,$desc,$kw,$fname,$subj,$faddress,$txt,$html)
	$email->add_email($uid, mysql_real_escape_string($ename), mysql_real_escape_string($edesc), mysql_real_escape_string($kw), mysql_real_escape_string($efname), mysql_real_escape_string($esubj), $efaddr, $etxt, $ehtml);
	//echo $etxt . ' ' . $ehtml . '<br>';	
		
	// Redirect the landing page back to the content main page
	header('Location: '. $siteUrl . 'member.php#!/email');
}
?>


<fieldset name="Group1"><legend>Email Properties</legend>
<form name="aEmail" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'];?>">

<table width="450px"><tr>
		<td>Email name</td>
		<td><input type="text" name="name" /></td>
	</tr>
	<tr>
		<td>Email description</td>
		<td><input type="text" name="description" /></td>
	</tr>
	<tr>
		<td>Email keywords</td>
		<td><textarea rows="3" cols="20" name="keywords">(comma delimited)</textarea></td>
	</tr>
		<tr>
		<td>From name</td>
		<td><input type="text" name="from_name" /></td
	</tr>
		<tr>
		<td>From address</td>
		<td><input type="text" name="from_address" /></td
	</tr>
		<tr>
		<td>Subject line</td>
		<td><input type="text" name="subject" /></td
	</tr>	
	<tr>
		<td>Select text content</td>
		<td>
			<select name="text_content">
			<?php 
			 foreach($tcon as $key=>$value)
			 {
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
		<td><input type="submit" value="Add Email"></td>
	</tr>
</table>
</form></fieldset>
<?php 


?>
