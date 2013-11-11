<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>View Email</h1>
<?php 
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcontent");

include_once '../../pages/content/contentclass.php';
include_once '../../pages/email/emailclass.php';
include_once '../../pages/user/userclass.php';
include_once '../../config/general.php';

session_start();

$uid = $_SESSION['ID'];
$eid = $_GET['ID'];

$em = new Email();
$email = $em->get_emailByID($eid);

echo "Name: $email[emailName]<br>
	Description: $email[emailDescription]<br>
	From Name: $email[emailFromName]<br>
	From Address: $email[emailFromAddress]<br>
	Subject: $email[emailSubject]<br>";

// Get HTML content to display
$con = new Content();
$html = $con->get_contentByID($email[emailHTML]);
$text = $con->get_contentByID($email[emailText]);
echo '<br><table align="left" cellpadding="0" cellspacing="0" width="300">
		<tr><td align="left">HTML:</td><td align="left">Text:</td></tr>
		<tr><td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.html" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.png' . '" width="150"></a></td>
		<td align="left">
			<a href="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.txt" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.png' . '" width="150"></a></td></tr>
		<tr><td align="left">Keywords: ' . $email[emailKeywords] . '</td></tr>
		</table>';








?>