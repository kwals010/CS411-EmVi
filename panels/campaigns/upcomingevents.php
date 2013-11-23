<style type="text/css">
.tableheaders {
	width:140px;
	font-weight: normal;
	font-size: small;
	color: #FAF6F6;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	background-color: #990000;
	text-align: center;

}
.tablebody {
	width: 110px;
	font-weight: normal;
	font-size: small;
	color: #000000;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	background-color: #C0C0C0;
	text-align: center;

}


</style>
<h1>Upcoming Events</h1>
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
		<tr><th class=\"tableheaders\">Campaign Name</th><th class=\"tableheaders\">Campaign Launch Date</th></tr>";
while($row = mysql_fetch_assoc($query)){ 
	echo "<tr><td class=\"tablebody\" width=\"320px\">".$row['campaignName'] . "</td><td class=\"tablebody\"> " . date("m/d/Y", strtotime($row['launchDate']))."</td></tr>";
		
		
	
	
	
}
echo "</table>";


