<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>View Content</h1>
<?php 
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcontent");

include_once '../../config/general.php';
include_once '../../config/DB_Class.php';
include_once '../../pages/content/contentclass.php';
include_once '../../pages/user/userclass.php';


session_start();

$uid = $_SESSION['ID'];
$cid = $_GET['ID'];

//echo "User is $uid<br>";
//echo "Content is $cid<br>";

$con = new Content();
$content = $con->get_contentByID($cid);
$fname = $content['fileLocation'];
$type = $con->get_contentTypeByID($content['contentType']);


if ($type == 'html' || $type == 'txt') {
	$ext = 'png';
}
else {
	$ext = $type;
}
echo '<fieldset name="Group1"><legend>Content Properties</legend>';
echo 'Name: ' . $content['contentName'] . '<br>
	 Description: ' .$content['contentDescription'].'<br>';
echo 'Keywords: ' . $content['contentKeywords'].'<br>';

echo '</fieldset><fieldset name="Group1"><legend>Content File</legend>';
echo '<table><tr><td align="center"><img src="' . $siteUrl . 'content/upload/' . $fname . '.' . $ext . '" width="250">
		</td></tr>
		<tr><td align="left">
		<a href="content/upload/' . $content['fileLocation'] . '.' . $type . '" target="_blank">View Full Size</a> (Right click to save)
		</table>';	
echo '</fieldset>';	



?>