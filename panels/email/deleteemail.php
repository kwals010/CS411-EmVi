<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>Delete Email</h1>
<script type="text/javascript">
<!--
function validateForm() {
	var r=confirm("Really Delete <?php echo $content['contentName']; ?>?");
	if (r) {
		return true;
	 }
	 else {
	   return false;
	 } 
 }
//--> 
</script>
<?php 
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcontent");

include_once '../../config/DB_Class.php';
include_once '../../pages/content/contentclass.php';
include_once '../../pages/email/emailclass.php';
include_once '../../pages/user/userclass.php';
include_once '../../config/general.php';

session_start();

$uid = $_SESSION['ID'];
$eid = $_GET['ID'];

$em = new Email();
$email = $em->get_emailByID($eid);

// This section handles the page submission and the saving of data to the database
if (!empty($_POST)) {

	$em->delete_email($_POST["eid"]);
	// Redirect the landing page back to the content main page
	header('Location: '. $siteUrl . 'member.php#!/email');

}


echo '<fieldset name="Group1"><legend>Email Properties</legend>
	Name: ' . $email[emailName] . '<br>
	Description: ' . $email[emailDescription] . '<br>';
?>
<form name="dEmail" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'] . "?ID=" . $eid;?>">
<table width="450px">
<tr>
<td colspan="2" width="85">Warning! Deleting email will not remove the underlying content<br>
associated with it. All content files will remain untouched.
</td>
</tr>
<tr>
<td><input type="hidden" name="eid" value="<?php echo $eid;?>"></td>
<td><input type="submit" value="Delete Email"></td>
</tr>
</table></fieldset>
<?php 
// Get HTML content to display
$con = new Content();
$html = $con->get_contentByID($email[emailHTML]);
$text = $con->get_contentByID($email[emailText]);
echo '<br><fieldset name="Group1"><legend>Email Content</legend><table align="left" cellpadding="0" cellspacing="0" width="300">
		<tr><td align="left">HTML:</td><td align="left">Text:</td></tr>
		<tr><td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.html" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.png' . '" width="200"></a></td>
		<td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.txt" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.png' . '" width="200"></a></td></tr>
		</table></field>';
