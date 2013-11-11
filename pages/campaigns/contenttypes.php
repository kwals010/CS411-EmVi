<?php
$subNav = array(
	"Content ; content/content.php ; #F98408;",
	"ContentTypes ; content/contentTypes.php ; #F98408;",
	"ContentToCampaign ; content/contentToCampaigns.php ; #F98408;",
	"ContentToCDN ; content/contentToCDN.php ; #F98408;",
);

set_include_path("../");
include("../../inc/essentials.php");
?>
<script>
$mainNav.set("content") // this line colors the top button main nav with the text "home"
</script>


<html>
 <body>



<?php
	session_start();
	include_once 'contentclass.php';

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
