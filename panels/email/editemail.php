<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<h1>Edit Email</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("editcontent");

include_once '../../pages/email/emailclass.php';
include_once '../../pages/content/contentclass.php';
include_once '../../pages/user/userclass.php';
include_once '../../config/general.php';

session_start();

// Get the user ID out of the session
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

?>

<form name="eEmail" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width="450px"><tr>
<td>Email name</td>
<td><input type="text" name="name" value="<?php echo $email[emailName]; ?>" /></td>
</tr>
<tr>
<td>Email description</td>
<td><input type="text" name="description" value="<?php echo $email[emailDescription]; ?>" /></td>
</tr>
<tr>
<td valign="top">Email keywords</td>
<td><textarea rows="3" cols="20" name="keywords"><?php echo $email[emailKeywords]; ?></textarea></td>
</tr>
<tr>
<td>From name</td>
<td><input type="text" name="from_name" value="<?php echo $email[emailFromName]; ?>" /></td
</tr>
<tr>
<td>From address</td>
<td><input type="text" name="from_address" value="<?php echo $email[emailFromAddress]; ?>" /></td
</tr>
<tr>
<td>Subject line</td>
<td><input type="text" name="subject" value="<?php echo $email[emailSubject]; ?>" /></td
</tr>
</table></form>