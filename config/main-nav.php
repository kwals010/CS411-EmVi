<a rel="group0">
	<img src="img/icons/work.png" alt="My Work"/>
	Work
</a>
<a rel="group1">
	<img src="img/icons/content.png" alt="Campaign"/>
	Campaigns
 </a>
<a rel="group2">
	<img src="img/icons/campaign.png" alt="Emails"/>
	 Emails
</a>	
<a rel="group3">
	<img src="img/icons/search.png" alt="Search"/>
	Search
</a>
<a rel="group4">
	<img src="img/icons/account.png" alt="My Account"/>
	My Account
</a>
<a rel="group5">
	<img src="img/icons/help.png" alt="Help"/>
	Help
</a>


<?php
include("DB_Connect.php");
session_start(); 

$query = mysql_query("SELECT * FROM tbl_user WHERE userID = '".$_SESSION['ID']."'");
	if (!$query) {    
		die("Query to show fields from table failed main-nav.php line 18");
	}
$user = mysql_fetch_assoc($query);

if ($user['userRole'] == 1){
	echo "<a rel=\"group6\">";
		echo "<img src=\"img/icons/AdminIcon.jpg\" alt=\"Administration\"/>";
		echo "Administration";
	echo "</a>";
} 
?>

<a class="links" id="Logout" href="../emvi/pages/user/logoff.php" ><img src="img/icons/unlocked32.png" alt="Help"/>Logout</a>

