<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
 
include 'cdn/vendor/autoload.php';
include 'cdn/CDN.php';
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
$contentPath = 	$filesLocation . $fname . '.' . $type;
$cdnprops = $con->get_CDNByContentID($content['contentID']);
$hasEmails = $con->get_EmailByContentID($cid);
$hasCampaigns = $con->get_CampaignByContentID($cid);

if ($cdnprops['cdnID'] == null) {
	echo '<h1>Publish Content</h1>';
} 
else {
	echo '<h1>CDN Details</h1>';
}
?>

<script type="text/javascript">
<!--
function validateForm() {
	var name=document.forms["pContent"]["name"].value;
	var r;
	if (name == 'add') {
		r=confirm("Really Publish <?php echo $content['contentName']; ?>?");
	}
	else if (name == 'remove') {
		r=confirm("Really Remove <?php echo $content['contentName']; ?>?");
	}
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
// This section handles the page submission and the saving of data to the database
if (!empty($_POST)) {

	if ($_POST['name'] == 'add') {


	$url = exec('php -f cdn/posttocdn.php url=' . $contentPath);
	
	echo "Published to " . $url . "<br>";
	
	$con->add_toCDN($cid, $uid, mysql_real_escape_string($url));

	}
	else if ($_POST['name'] == 'remove') {

	$url = exec('php -f cdn/posttocdn.php content=' . $fname . '.' . $type);
	
	$con->remove_fromCDN($cid);
	}
	
	// Redirect the landing page back to the content main page
	header('Location: '. $siteUrl . 'member.php#!/content');
	
}



if ($type == 'html' || $type == 'txt') {
	$ext = 'png';
}
else {
	$ext = $type;
}
?>
<fieldset name="Group1">
<legend>Content Properties</legend>
<?php 
echo 'Name: ' . $content['contentName'] . '<br>
	 Description: ' .$content['contentDescription'].'<br>';
if ($cdnprops['cdnID'] != null) {
echo '<a href="' . $cdnprops['url'] . '" target="_blank">CDN URL</a> (Right-click to copy)<br><br>';
}
// PUBLISH CONTENT OPTION
if ($cdnprops['cdnID'] == null) {
?>
	 <form name="pContent" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'] . "?ID=" . $cid;?>">
<table width="450px">
	<tr>
		<td colspan="2" width="85">Warning! Publishing this content will make it accessible to the world.
		</td>
	</tr>
<tr>
		<td><input type="hidden" name="name" value="add"></td>
		<td><input type="submit" value="Publish To CDN"></td>
	</tr>	

</table>
</form>
<?php
}
// Conditions for delete: $uid is owner + $cid not attached to email+ $cid not attached to campaign
else if ($uid == $content['canEdit'] && $hasEmails[emailID] == '' && $hasCampaigns == '') {
?>
<form name="pContent" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'] . "?ID=" . $cid;?>">
<table width="450px">
<tr>
<td colspan="2" width="85">Warning! This will remove the content from the CDN.
</td>
</tr>
<tr>
<td><input type="hidden" name="name" value="remove"></td>
<td><input type="submit" value="Remove"></td>
</tr>

</table>
</form>
 <?php 
}	
echo '</fieldset><fieldset name="Group1"><legend>Content File</legend><table><tr><td align="center"><img src="' . $siteUrl . 'content/upload/' . $fname . '.' . $ext . '" width="250">
		</td></tr>
		</table></fieldset>';





?>