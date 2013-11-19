<?php 

// Connects to your Database 
	include 'config/DB_Connect.php';
	$con = mysql_connect(HOST,USER,PASSWORD);
	if (!$con)
	   {
		   die('Could not connect: ' . mysql_error());
	   }
 	mysql_select_db(DATABASE, $con);
 	session_start();
 	
 	if ($_SESSION['lAttempts'] > 0){
 		$_SESSION['lAttempts'] = $_SESSION['lAttempts'];
 	}else{
 		$_SESSION['lAttempts'] = 0;
 	}
 	
 	
 //Checks if there is a login cookie
 	if(isset($_SESSION['ID_my_site']))

 //if there is, it logs you in and directes you to the members page
	{ 
		$username = $_SESSION['ID_my_site']; 
		$pass = $_SESSION['Key_my_site'];
		$check = mysql_query("SELECT * FROM tbl_user WHERE userEMailAddress = '$username'")or die(mysql_error());
		while($info = mysql_fetch_array( $check )) 	
	 		{
		 		if ($pass != $info['userPassword ']) 
 				{
 				}
 				else
 				{
 					header("Location: members.php");
 				}
			}
	}

//if the login form is submitted 
	if (isset($_POST['submit'])) 
		{ 
// if form has been submitted
// makes sure they filled it in
			if(!$_POST['username'] | !$_POST['pass'])
				{
					$error = '<h3>You did not fill in a required field.</h3>';
					header("Location: index.php?error=".$error."");

 				}
// checks it against the database

			if (!get_magic_quotes_gpc()) 
				{
					$_POST['email'] = addslashes($_POST['email']);
 				}
 			$check = mysql_query("SELECT * FROM tbl_user WHERE userEMailAddress = '".mysql_real_escape_string($_POST['username'])."'")or die(mysql_error());

 //Gives error if user dosen't exist
 			$check2 = mysql_num_rows($check);
 			if ($check2 == 0) 
 				{
 					$error = '<h3>That user does not exist in our database. Click the link below to register.</h3>';
					header("Location: index.php?error=".$error."");
 				}
 			while($info = mysql_fetch_array( $check )) 	
 				{
 					$_POST['pass'] = stripslashes($_POST['pass']);
					$info['userPassword '] = stripslashes($info['userPassword ']);
					$_POST['pass'] = md5($_POST['pass']);

//gives error if the password is wrong
					if ($info['userAccountStatus'] != 1)
						{
							$error = '<h3>Account has not yet been enabled. Please try again later.</h3>';
							header("Location: index.php?error=".$error."");
						}
				 	else if ($_POST['pass'] != $info['userPassword']) 
				 		{
				 			$_SESSION['lAttempts'] = $_SESSION['lAttempts'] + 1;
				 			if ($_SESSION['lAttempts'] == 5){
				 				//function to lock account
				 				mysql_query("UPDATE tbl_user SET userAccountStatus = 0 WHERE userEMailAddress = '".mysql_real_escape_string($_POST['username'])."'")or die(mysql_error());

				 				
				 				$error = '<h3>Your account has been locked.  Please contact the site admin for assistance.</h3>';
				 			}else{
					 			$error = '<h3>Incorrect password, please try again. Attempt: '.$_SESSION['lAttempts'].'</h3>';
							}
							header("Location: index.php?error=".$error."");

 						}
					else 
						{ 
//Set Session Veriables for Access rights
 							 
							$_SESSION['loggedout'] = 'no';
							$_SESSION['LVL'] = $info['userRole'];
							$_SESSION['ID'] = $info['userID']; 
 
// if login is ok then we add a cookie 
							$_POST['username'] = stripslashes($_POST['username']); 
							$hour = time() + 3600;
							$_SESSION['ID_my_site'] =  $_POST['username'];
							$_SESSION['Key_my_site'] = $_POST['pass'];
							/*setcookie(ID_my_site, $_POST['username'], $hour); 
							setcookie(Key_my_site, $_POST['pass'], $hour);	 
*/ 
//then redirect them to the members area 
							$update_date = date("Y-m-d H:i:s");
							mysql_query("UPDATE tbl_user SET lastLogonDate = '$update_date' WHERE userEMailAddress = '".mysql_real_escape_string($_POST['username'])."'")or die(mysql_error());
							$_SESSION['lAttempts'] = 0;

							header("Location: member.php"); 
 						} 
 				} 
		} 
	else 
		{	 
// if they are not logged in 
 		} 
 
?>