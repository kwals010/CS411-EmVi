
<?php  

	session_start(); 
	$_SESSION['loggedout'] = 'yes';	
 $past = time() - 4000; 
 //this makes the time in the past to destroy the cookie 
 setcookie(ID_my_site, gone, $past); 
 setcookie(Key_my_site, gone, $past); 
 	include_once '../../config/general.php';
	header('Location: '.$siteUrl.''); 
 ?> 