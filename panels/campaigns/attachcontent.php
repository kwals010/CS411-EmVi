<h1>Attach Content</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("an_example");

include_once '../../pages/content/contentclass.php';
include_once '../../pages/user/userclass.php';

session_start();
$uid = $_SESSION['ID'];

?>
<fieldset name="Group1">
				<legend>Attach Email</legend>
				
			</fieldset>

<fieldset name="Group1">
				<legend>Attach Content</legend>
				
			</fieldset>
