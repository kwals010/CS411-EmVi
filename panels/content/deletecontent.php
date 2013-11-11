<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>Delete Content</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("editcontent");

include_once '../../pages/content/contentclass.php';
include_once '../../pages/user/userclass.php';
include_once '../../config/general.php';

session_start();

// Get the user ID out of the session
$uid = $_SESSION['ID'];

// Get the content out of the url
$cid = $_GET['ID'];
if ($cid == null || $cid == '')
{
	echo "No parameter ID = provided in URL<br>";
	die;
}

$con = new Content();
$content = $con->get_contentByID($_GET['ID']);

$ftypeID = $content['contentType'];
$ftypename = $con->get_contentTypeByID($ftypeID);
$fileloc = $content['fileLocation'];
//echo $filesLocation . $fileloc . "." . $ftypename . "<br>";

?>

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
// This section handles the page submission and the saving of data to the database
if (!empty($_POST)) {

	echo 'Hello world!';
	
	exec('rm -f ' . $filesLocation . $fileloc . '.' . $ftypename,$output,$ret);
	/* Turned off so that if file doesn't exist it's okay
	if ($ret){
		echo "Error deleting " . $filesLocation . $fileloc . "." . $ftypename . "<br>";
		die;
	} */
	if ($ftypename == 'txt' || $ftypename == 'html') {
		exec('rm ' . $filesLocation . $fileloc . '.png',$output,$ret);
/*
		if ($ret){
			echo "Error deleting " . $fileloc . ".png<br>";
			die;
		} */
	}
	
	$con->delete_content($cid);
	// Redirect the landing page back to the content main page
	header('Location: '. $siteUrl . 'member.php#!/content');

}
?>
<?php 
echo 'Name: ' . $content['contentName'] . '<br>
	 Description: ' .$content['contentDescription'].'<br>';
?>
<form name="aContent" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'] . "?ID=" . $cid;?>">
<table width="450px">
	<tr>
		<td><input type="hidden" name="cid" value="<?php echo $cid;?>"></td>
		<td><input type="submit" value="Delete"></td>
	</tr>	
	<tr>
		<td colspan="2" width="85">Warning! Deleting content will remove all files<br>
	associated with the content. It cannot be undone.
		</td>
	</tr>
</table>
<?php	
	echo '<table><tr><td align="center">';
	echo '<a href="content/upload/' . $fileloc . '.' . $ftypename . '" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $fileloc . '.';
	if ($ftypename == 'txt' || $ftypename == 'html') {
		echo 'png';
	}
	else {
		echo $ftypename;
	}
	echo '" width="250"></a>';
	echo '</td></tr></table>';
		
?>
		
</form>