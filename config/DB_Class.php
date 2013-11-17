<?php
<<<<<<< HEAD
define("HOST", "localhost"); // The host you want to connect to.
define("USER", "EMVI"); // The database username.
define("PASSWORD", "cs410orange"); // The database password.
define("DATABASE", "EMVIDEV"); // The database name.
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
?>
=======

define("HOST", "localhost"); // The host you want to connect to.
define("USER", "EMVI"); // The database username.
define("PASSWORD", "cs410orange"); // The database password. 
define("DATABASE", "EMVIDEV"); // The database name.


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

 ?>

>>>>>>> d22fa841f2070b2efcabdf5ca3a526eacf161427
