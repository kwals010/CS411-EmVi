<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>Preview Email</h1>
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

$me = new User();
$me = $me->withID($uid);
$em = new Email();
$email = $em->get_emailByID($eid);
?>
<script type="text/javascript">
function validateForm()
 {
 var addr=document.forms["sEmail"]["emails"].value;

 if (addr==null || addr=="")
 {
   alert("Email field cannot be blank.");
   return false;
 }
 }
</script>

<?php
if (!empty($_POST)) {

	$em->send_emails($eid, $_POST["emails"]);
	// Redirect the landing page back to the content main page
	header('Location: '. $siteUrl . 'member.php#!/email');

}


echo "From: " . $email[emailFromName] . " &lt;" . $email[emailFromAddress] . "&gt;<br>";
echo "Subject: " . $email[emailSubject] . "<br><br>";
?>
<form name="sEmail" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'] . "?ID=" . $eid;?>">
<table width="400px">
<tr>
<td>Test Addresses (comma separated):</td><td><input type="text" name="emails" value="<?php echo $me->userEMailAddress; ?>" /></td>
</tr><tr>
<td></td><td><input type="submit" value="Send"></td>
</tr>

</table>
<?php 
// Get HTML content to display
$con = new Content();
$html = $con->get_contentByID($email[emailHTML]);
$text = $con->get_contentByID($email[emailText]);
echo '<br><table align="left" cellpadding="0" cellspacing="0" width="300">
		<tr><td align="left">HTML:</td><td align="left">Text:</td></tr>
		<tr><td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.html" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.png' . '" width="200"></a></td>
		<td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.txt" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.png' . '" width="200"></a></td></tr>
		</table>';

?>

