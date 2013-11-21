
<h1>Send campaign to complete.</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("an_example");
include_once '../../pages/user/userclass.php';
include_once '../../config/DB_Class.php';
include_once '../../pages/campaigns/campaignclass.php';
include_once '../../pages/email/emailclass.php';
include_once '../../pages/content/contentclass.php';
include_once '../../config/general.php';


session_start();
$uid = $_SESSION['ID'];

$cam = new Campaign();
$camp = $cam->get_campaignByID($_GET['ID']);
//print_r($camp);
$campaignOwner = new User();
$userload = $campaignOwner->withID($camp['updatedBy']);


if (isset($_POST['markComplete'])){

//Need to cahnge the status of the campaign here.
$cam->update_status($_GET['ID'],5);

}
?>
<script type="text/javascript">
function sentNotify(){
	alert('Client preview successfully sent. Please preview in your mailbox.');

}

</script>

<fieldset name="Campaign Owner">
				<legend>Campaign Owner</legend>
				<table>
				<tr><td width="70px">Name: </td><td><?php echo $userload->userFirstName ." ". $userload->userFirstName; ?></td></tr>
				<tr><td width="70px">Email: </td><td><?php echo $userload->userEMailAddress; ?></td></tr>
				<tr><td width="70px">Phone: </td><td><?php echo $userload->userPhoneNumber; ?></td></tr>
				
				
				</table>
			</fieldset>
			
<fieldset name="Campaign Info">
				<legend>Campaign Info</legend>
				<table>
				<tr><td width="150px">Campaign Name: </td><td><?php echo $camp['campaignName']; ?></td></tr>
				<tr><td width="150px">Campaign Description: </td><td><?php echo $camp['campaignDescription']; ?></td></tr>
				<tr><td width="150px">Launch Date: </td><td><?php echo $camp['launchDate']; ?></td></tr>
				
				
				</table>

			</fieldset>
			
<fieldset name="Emails">
				<legend>Emails</legend>
				<?php
$emailArray = $cam->get_attachedEmail($_GET['ID']);
$em = new Email();
if (isset($_GET['eid'])){
	$em->send_emails($_GET['eid'],$campaignOwner->userEMailAddress);
	echo "<script> sentNotify() </script>";
}
mysql_data_seek($emailArray,0);

while ($email = mysql_fetch_assoc($emailArray)){
	$eid = $email['emailID'];
	
	
	$email = $em->get_emailByID($eid);
	echo "<div>";
	echo "Name: $email[emailName]<br>
		Description: $email[emailDescription]<br>
		From Name: $email[emailFromName]<br>
		From Address: $email[emailFromAddress]<br>
		Subject: $email[emailSubject]<br>";
	
	// Get HTML content to display
	$con = new Content();
	$html = $con->get_contentByID($email[emailHTML]);
	$text = $con->get_contentByID($email[emailText]);
	echo '<br><table>
			<tr><td >Right click and select save target as to download the content<td><tr>
			<tr><td>HTML:</td></tr>
			<tr><td>
				<a href="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.html" target="_blank">' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.html' . '</a></td></tr>
			<tr><td>Text:</td></tr>
			<tr><td>
				<a href="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.txt" target="_blank">' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.txt' . '</a></td></tr>
			<tr><td>Or you can send yourself an email to forward on by clicking the link below.</tr>
			<tr><td><a href="panels/campaigns/sendtocomplete.php?ID='.$_GET['ID'].'&eid='.$eid.'">Send Client Preview</a></td></tr>
			</table>';
			
		echo "</div>";	
		echo "<hr />";
}
?>

			</fieldset>
			
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?ID='.$_GET['ID'];?>">
			<label id="Label1">To set the status of this campaign to complete, click below.<br></label>
			<input name="markComplete" type="submit" value="Send to Complete" />
			</form>
			