
<html>
<head>
<title>Title of the document</title>
</head>

<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require 'emaillistclass.php';
$email_list = new EmailList(1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Add emails
	if (isset($_POST["email"])) {
		$email_list->add_email($_POST["email"]);
	}

	// Send emails
	else if (isset($_POST["action"])) {
		$email_list->send_email();
		echo "Emails Sent!";
	}

}

// Print list of emails
foreach ($email_list->emailList as $address) {
	echo "$address<br>";
}

?>
<form action="" method="POST">
	Email: <input type="text" name="email">
	<input type="submit" value="add">
</form><br>

<form action="" method="POST">
	<input type="submit" name="action" value="send">
</form>

</body>
</html>
