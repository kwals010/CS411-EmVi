<?php 

// Connects to your Database 
	include 'config/DB_Connect.php';
	$con = mysql_connect(HOST,USER,PASSWORD);
	if (!$con)
	   {
		   die('Could not connect: ' . mysql_error());
	   }
 	mysql_select_db(DATABASE, $con);
 
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
					$error = 'You did not fill in a required field.';
					header("Location: index.php?error=".$error."");

 				}
// checks it against the database

			if (!get_magic_quotes_gpc()) 
				{
					$_POST['email'] = addslashes($_POST['email']);
 				}
 			$check = mysql_query("SELECT * FROM tbl_user WHERE userEMailAddress = '".$_POST['username']."'")or die(mysql_error());

 //Gives error if user dosen't exist
 			$check2 = mysql_num_rows($check);
 			if ($check2 == 0) 
 				{
 					$error = 'That user does not exist in our database. <a href=add.php>Click Here to Register</a>';
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
							$error = 'Account has not yet been enabled. Please try again later.';
							header("Location: index.php?error=".$error."");
						}
				 	else if ($_POST['pass'] != $info['userPassword']) 
				 		{
					 		$error = 'Incorrect password, please try again.';
							header("Location: index.php?error=".$error."");

 						}
					else 
						{ 
//Set Session Veriables for Access rights
 							session_start(); 
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
							mysql_query("UPDATE tbl_user SET lastLogonDate = '$update_date' WHERE userEMailAddress = '".$_POST['username']."'")or die(mysql_error());

							header("Location: member.php"); 
 						} 
 				} 
		} 
	else 
		{	 
// if they are not logged in 
 		} 
 
?>