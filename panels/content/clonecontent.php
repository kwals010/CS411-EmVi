<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>Clone Content</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("editcontent");

include_once '../../config/general.php';
include_once '../../config/DB_Class.php';
include_once '../../pages/content/contentclass.php';
include_once '../../pages/user/userclass.php';

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
$newfileloc = uniqid();
?>

<script type="text/javascript">
function validateForm()
 {
 var name=document.forms["aContent"]["name"].value;
 var desc=document.forms["aContent"]["description"].value;
 var type=document.forms["aContent"]["type"].value;
 var fup = document.getElementById('file');
 var fileName = fup.value;
 var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
 if (name==null || name=="")
 {
   alert("Content name cannot be blank.");
   return false;
 }
 else if (desc==null || desc=="")
 {
 alert("Content description cannot be blank.");
 return false;
 }
 else if (ext == null || ext =="")
 {
	 //return true;
 }
 else if (ext.toLowerCase() != type.toLowerCase())
 {
 	 alert("Selected content file format ("+type+")\ndoes not match the file extension ("+ext+").\nPlease select a different format or file.");
 	 return false;
 }
}
</script>

<?php 

// This section handles the page submission and the saving of data to the database
if (!empty($_POST)) {

	echo $_POST["name"] . "<br>" . $_POST["description"] . "<br>" . $_POST["keywords"] . "<br>";
	
	// Copy the files to the new location
	$cmd = 'cp ' . $filesLocation . $fileloc . '.' . $ftypename . ' ' . $filesLocation . $newfileloc . '.' . $ftypename;
	exec($cmd,$output,$ret);
	if ($ret){
		echo "Error copying " . $fileloc . $ftypename . " to " . $newfileloc . $ftypename . "<br>";
		die;
	}
	if ($ftypename == 'txt' || $ftypename == 'html')
	{
		$cmd = 'cp ' . $filesLocation . $fileloc . '.png ' . $filesLocation . $newfileloc . '.png';
		exec($cmd,$output,$ret);
		if ($ret){
			echo "Error copying " . $fileloc .".png to " . $newfileloc .".png<br>";
			die;
		}
	}
	
	// Function to write data to the DB is public function add_content($uid,$name,$desc,$kw,$type,$loc)
	$con->add_content($uid,$_POST["name"],$_POST["description"],$_POST["keywords"],$ftypeID,$newfileloc);
	
	
	
	// Redirect the landing page back to the content main page
	header('Location: '. $siteUrl . 'member.php#!/content');
	
}
?>



<form name="aContent" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'] . "?ID=" . $cid;?>">
<table width="450px"><tr>
		<td>Content name:</td>
		<td><input type="text" name="name" value="<?php echo $content['contentName'];?>" /></td>
	</tr>
	<tr>
		<td>Content description:</td>
		<td><input type="text" name="description" value="<?php echo $content['contentDescription'];?>" /></td>
	</tr>
	<tr>
	<td>Content keywords</td>
	<td><textarea rows="3" cols="20" name="keywords"><?php echo $content['contentKeywords'];?></textarea>
	</td>
	</tr>
	<tr>
	<td></td>
	<td><input type="submit" value="Save"></td>
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
