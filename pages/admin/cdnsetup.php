<?php
$subNav = array(
	"Accounts ; admin/accountmaint.php ; #F98408;",
	"CDN setup ; admin/cdnsetup.php ; #F98408;",
	"Site Config ; admin/siteconfig.php ; #F98408;",
);

set_include_path("../");
include("../../inc/essentials.php");
?>
<script>
$mainNav.set("administration") // this line colors the top button main nav with the text "home"
</script>
<h1 class="margin-t-0">CDN Setup</h1>
<hr>
<h3>CDN Setup page</h3>
<p> This page will handle the site configuration for the CDN setup and connection.