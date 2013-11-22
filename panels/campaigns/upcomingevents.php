<h1>Upcomming Events</h1>
<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcampaign");
include ("../../config/DB_Connect.php");


$sql = "SELECT `campaignName`, `launchDate` FROM `tbl_campaigns` WHERE 1 order by `launchDate` asc limit 9 ";
$query = mysql_query($sql);
if (!$query) {    
				die("Query to show fields from table failed tiles.php line 57");
		}

$upcomming = array();

echo "<table style='color:#FFFFFF; font-size:15px'>
		<tr><th>Campaign Name</th><th>Campaign Launch Date</th></tr>";
while($row = mysql_fetch_assoc($query)){ 
	echo "<tr><td class=\"None\" width=\"320px\">".$row['campaignName'] . "</td><td class=\"None\"> " . date("m/d/Y", strtotime($row['launchDate']))."</td></tr>";
		
		
	
	
	
}
echo "</table>";


