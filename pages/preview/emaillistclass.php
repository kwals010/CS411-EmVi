<?php

class EmailList
{
	private $campaignID;
	public $emailList = array();

	function __construct($campaignID) {
		$this->campaignID = $campaignID;
		include("../../config/DB_Connect.php");
		session_start();

		$result = mysql_query("SELECT testEmailAddress FROM tbl_testEmailList WHERE campaignID = $this->campaignID");
		while ($row = mysql_fetch_assoc($result)) {
			$this->emailList[] = $row["testEmailAddress"];
		}
	}

	function add_email($email) {
		mysql_query("INSERT INTO tbl_testEmailList (campaignID, testEmailAddress) VALUES ($this->campaignID, '$email')");
		$this->emailList[] = $email;
	}

	function send_email() {
		require '../../PHPMailer/PHPMailerAutoload.php';

		//Create a new PHPMailer instance
		$mail = new PHPMailer();
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 2;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = 'smtp.gmail.com';
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;
		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = "username@gmail.com";
		//Password to use for SMTP authentication
		$mail->Password = "password";
		//Set who the message is to be sent from
		$mail->setFrom('cdashiel@gmail.com.com', 'Chris Dashiell');
		//Set an alternative reply-to address
		$mail->addReplyTo('cdashiel@gmail.com', 'Chris Dashiell');
		//Set the subject line
		$mail->Subject = 'PHPMailer GMail SMTP test';
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		$mail->addAttachment('images/phpmailer_mini.gif');

		foreach ($this->emailList as $emailAddress)
			echo $emailAddress;
			$mail->addAddress($emailAddress);
			//send the message, check for errors
			if (!$mail->send()) {
			    echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
			    echo "Message sent!";
			}
		}
}

?>