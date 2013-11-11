<html>
 <body>



<?php
	session_start();
	include_once 'include/content_functions.php';

	$content = new Content();
	$types = $content->get_content_types();
	
	echo "<table border=1>";
	for ($i = 0; $i < count($types); ++$i) {
		echo "<tr>";
		foreach($types[$i] as $key => $value) {
			echo "<td>$value</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	
 ?> 





 </body>
 </html> 
