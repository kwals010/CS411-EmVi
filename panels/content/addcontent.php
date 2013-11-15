<h1>Add Content</h1>
<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcontent");
include_once '../../content/include/config.php';
include_once '../../pages/content/contentclass.php';
include_once '../../pages/user/userclass.php';
include_once '../../config/general.php';

session_start();

$uid = $_SESSION['ID'];
$con = new Content();
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

	$ftype = $_POST["type"];
	$fname = uniqid();
	while (file_exists($filesLocation . $fname . "." . $ftype)) {
		$fname = uniqid();
	}
	
	// check keywords. If the default string was left in the box, zero it out
	if ($_POST["keywords"] == '(comma delimited)'){
		$kw = '';
	}
	else {
		$kw = $_POST["keywords"];
	}
		
	if ($_FILES["file"]["error"] > 0) {
		echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	}
	else if ($_FILES["file"]["size"] > 0) {
		//list($fname,$temp) = split('\.', $_FILES["file"]["name"]);
		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		echo "Type: " . $_FILES["file"]["type"] . "<br>";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
		move_uploaded_file($_FILES["file"]["tmp_name"],
			$filesLocation . $fname . "." . $ftype);
		echo "Stored in: " . $fname . "." . $ftype;
	}
	
	if (!file_exists($filesLocation . $fname . "." . $ftype)) {
		// Creates a blank file.
		$temp = $filesLocation . $fname . "." . $ftype;
		$file = fopen($temp, 'w') or die("can't open file");
		fclose($file);
	}

	// Function to write data to the DB is public function add_content($uid,$name,$desc,$kw,$type,$loc)
	$con->add_content($uid,$_POST["name"],$_POST["description"],$kw,$con->get_contentIDByType($ftype),$fname);
	// Run conversion using imagemagick to generate thumbnail for html files
	if ($ftype == 'html')
	{
		$convertopdf = 'xvfb-run --server-args="-screen 0, 800x600x24" wkhtmltopdf ' . $filesLocation . $fname . '.' . $ftype . ' ' . $filesLocation . $fname . '.pdf';
		$convertopng = 'convert ' . $filesLocation . $fname . '.pdf[0] ' . $filesLocation . $fname . '.png';
		exec($convertopdf,$output,$ret);
		if ($ret) {
			echo "Error fetching screen dump for $fname\n";
			die;
		}
		exec($convertopng,$output,$ret);
		if ($ret){
			echo "Error converting $fname to png\n";
			die;
		}
		exec('rm ' . $filesLocation . $fname . '.pdf',$output,$ret);
		if ($ret){
			echo "Error deleting $fname pdf file\n";
			die;
		}
		
	}
	else if ($ftype == 'txt')
	{
		// First, make an HTML page with the content in it
		$file = '/var/www/emvi/content/upload/'. $fname . '.html';
		$fcontent = "<pre>" . file_get_contents($filesLocation. $fname . '.txt') . "</pre>";
		file_put_contents($file,$fcontent);
		
		$convertopdf = 'xvfb-run --server-args="-screen 0, 800x600x24" wkhtmltopdf ' . $filesLocation . $fname . '.html ' . $filesLocation . $fname . '.pdf';
		$convertopng = 'convert ' . $filesLocation . $fname . '.pdf[0] ' . $filesLocation . $fname . '.png';
		exec($convertopdf,$output,$ret);
		if ($ret) {
			echo "Error fetching screen dump for $file\n";
			die;
		}
		exec($convertopng,$output,$ret);
		if ($ret){
		echo "Error converting $fname to png\n";
		die;
		}
		exec('rm ' . $filesLocation . $fname . '.pdf',$output,$ret);
		if ($ret){
			echo "Error deleting $fname pdf file\n";
			die;
		}
		
	}
		
		// Redirect the landing page back to the content main page
		header('Location: '. $siteUrl . 'member.php#!/content');
}
?>

<form name="aContent" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width="450px"><tr>
		<td>Content name:</td>
		<td><input type="text" name="name" /></td>
	</tr>
	<tr>
		<td>Content description:</td>
		<td><input type="text" name="description" /></td>
	</tr>
	<tr>
		<td>Content file format:</td>
		<td>
		<select name="type">
<?php 
 $types = $con->get_content_types();
 $skip = 0;
 foreach($types as $t)
 {
 	if ($skip > 0)	
 		echo "<option name=\"type\" value=\"". $t['typeFormat'] . "\">". $t['typeFormat'] ."</option>";
 	++$skip;
 }
?>
		</select>
		</td>
	</tr>
	<tr>
	<td>Content keywords</td>
	<td><textarea rows="3" cols="20" name="keywords">(comma delimited)</textarea>
	</td>
	</tr>
	
	<tr>
		<td>Upload file:</td>
		<td><input type="file" name="file" id="file"></td>
		</tr>
		<tr>
		<td></td>
		<td><input type="submit" value="Add"></td>
		</tr>
		</table>
</form>  
