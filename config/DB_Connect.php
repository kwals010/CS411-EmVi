<?php

define("HOST", "localhost"); // The host you want to connect to.
define("USER", "EMVI"); // The database username.
define("PASSWORD", "cs410orange"); // The database password. 
define("DATABASE", "EMVIDEV"); // The database name.

$con = mysql_connect(HOST,USER,PASSWORD);
 if (!$con)
   {
   die('Could not connect: ' . mysql_error());
   }
mysql_select_db(DATABASE, $con);
 
//$mysql = new mysql(HOST, USER, PASSWORD, DATABASE);

/*
class DB_Class
{
	function __construct()
	{
		$connection = mysql_connect(HOST, USER, PASSWORD) or
		die('Oops connection error -> ' . mysql_error());
		mysql_select_db(DATABASE, $connection)
		or die('Database error -> ' . mysql_error());
	}
}
*/
 ?>

