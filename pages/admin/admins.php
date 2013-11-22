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
<h1 class="margin-t-0">Administration</h1>
<hr>
<h3>Administration Page</h3>
<p> This is the Administrators landing page.  From here the andministrator witll have full control of accounts 
and any other system wide settings such as the configuration of the CDN, email sender interface and others.