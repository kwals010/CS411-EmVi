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
 ?>

