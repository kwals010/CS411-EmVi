<?php
include 'config/DB_Connect.php';
session_start(); 

$query = mysql_query("SELECT * FROM tbl_user WHERE userID = '".$_SESSION['ID']."' and userRole = 1");
	if (!$query) {    
		die("Query to show fields from table failed admin/config.php Line 5");
	}
$user = mysql_fetch_assoc($query);


$username= $user['userEMailAddress'];
$password= "password";
?>