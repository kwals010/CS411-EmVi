<?php
session_start();
include_once 'include/content_functions.php';

$content = new Content();
$types = $content->get_content();

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



<br>
<h2>Create New Content</h2>
<form action="content_create.php" method="post">
<table border=1><tr>
	<td>Name</td>
	<td>Description</td>
	<td>Keywords</td>
	<td>Type</td>
	<td>Campaign</td></tr>
	<tr><td><input type="text" name="name"></td>
	<td><input type="text" name="description"></td>
	<td><input type="text" name="keywords"></td>
	<td><input type="text" name="type"></td>
	<td><input type="text" name="campaign"</td>
	</tr></table> 

 <input type="submit">
 </form>
