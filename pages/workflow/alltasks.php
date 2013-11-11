<?php

$subNav = array(
	"My Tasks ; workflow/mytasks.php ; #F98408;",
	"All Tasks ; workflow/alltasks.php ; #F98408;",
	
);

set_include_path("../");
include("../../inc/essentials.php");
include_once 'workflowclass.php';
session_start();
$uid = $_SESSION['ID'];

?>
<script>
$mainNav.set("Home"); // this line colors the top button main nav with the text "home"
</script>
