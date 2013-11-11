<?php

$subNav = array(
	"All Campaigns ; campaigns/campaigns.php ; #F98408;",
	"My Campaigns ; campaigns/mycampaigns.php ; #F98408;",
	"Add Campaign ; ../panels/campaigns/addcampaign.php ; #F98408;", 
);

set_include_path("../");
include("../../inc/essentials.php");
include_once 'campaignclass.php';
session_start();
$uid = $_SESSION['ID'];

?>
<script>
$mainNav.set("Campaigns"); // this line colors the top button main nav with the text "home"
</script>

<?php

if(!isset($_GET['orderBy'])) {
	$orderby = 'ID';
	$dir = 'ASC';
}
else {
	$orderby = $_GET['orderBy'];
	$dir = $_GET['dir'];
}

$campaign = new Campaign();
$types = $campaign->get_campaign($orderby,$dir);
// Function returns the following beginning in row 1:
// ID, Name, Description, Keywords, TypeID, Format, CreatedDate, CreatedByID, CreatedByName, 
// UpdatedDate, UpdatedByID, UpdatedByName, OwnedByID, OwnedByName, FileName

$contentList = '';
for ($i = 1; $i < count($types); ++$i) {
		$contentList .= '<tr><td>'. htmlentities($types[$i]['Name']) . '</td>
		<td>' . htmlentities($types[$i]['Status']) . '</td>
		<td>' . htmlentities($types[$i]['Description']) . '</td>
		<td>' . htmlentities($types[$i]['Keywords']) . '</td>
		<td>' . date("m/d/Y g:i a", strtotime($types[$i]['CreatedDate'])) . '</td>
		<td>' . htmlentities($types[$i]['CreatedByName']) . '</td>
		<td>' . date("m/d/Y g:i a", strtotime($types[$i]['LaunchDate'])) . '</td>
		<td>';
	if ($types[$i]['CreatedByID'] == $uid) {
		$contentList .= '<a href="panels/campaigns/viewcampaign.php?ID='.$types[$i]['ID'].'">View</a>';
	}
	$contentList .=	'</td><td>';
	if ($types[$i]['CreatedByID'] == $uid) {
		$contentList .= '<a href="panels/campaigns/editcampaign.php?ID='.$types[$i]['ID'].'">Edit</a>';
	}
	$contentList .= '</td>	
		<td>Clone</td>
		<td>';
	if ($types[$i]['CreatedByID'] == $uid) {
		$contentList .= 'Delete';
	}	
	$contentList .= '</td>
		<td>';
	if ($types[$i]['cdnID'] == '') {
		if ($types[$i]['CreatedByID'] == $uid) {
			$contentList .= '<a href="panels/content/managecdn.php?ID='.$types[$i]['ID'].'">Publish</a>';
		}
	}
	else {	
		$contentList .= '<a href="panels/content/managecdn.php?ID='.$types[$i]['ID'].'">CDN Properties</a>';
	}
	$contentList .= '</td></tr>';
}


//DISPLAY THE CONFERENCE REGISTRANTS
echo '<table width = "100%" cellpadding="3" cellspacing="1" border="1">';
echo '<tr>';
if (strtolower($orderby) == 'name' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=Name&dir=desc" style="text-decoration:none;">Campaign Name</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=Name&dir=asc" style="text-decoration:none;">Campaign Name</td>';
}
if (strtolower($orderby) == 'status' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=status&dir=desc" style="text-decoration:none;">Status</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=status&dir=asc" style="text-decoration:none;">Status</td>';
}
if (strtolower($orderby) == 'description' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=Description&dir=desc" style="text-decoration:none;">Description</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=Description&dir=asc" style="text-decoration:none;">Description</td>';
}
if (strtolower($orderby) == 'keywords' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=Keywords&dir=desc" style="text-decoration:none;">Keywords</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=Keywords&dir=asc" style="text-decoration:none;">Keywords</td>';
}
if (strtolower($orderby) == 'CreatedDate' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=CreatedDate&dir=desc" style="text-decoration:none;">Created On</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=CreatedDate&dir=asc" style="text-decoration:none;">Created On</td>';
}
if (strtolower($orderby) == 'CreatedByName' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=CreatedByName&dir=desc" style="text-decoration:none;">Created By</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=CreatedByName&dir=asc" style="text-decoration:none;">Created By</td>';
}
if (strtolower($orderby) == 'LaunchDate' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=LaunchDate&dir=desc" style="text-decoration:none;">Launch Date</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/campaigns/campaigns.php?orderBy=LaunchDate&dir=asc" style="text-decoration:none;">Launch Date</td>';
}
echo '<td style="min-width:50px;font-weight:bold"></td>';
echo '<td style="min-width:50px;font-weight:bold"></td>';
echo '<td style="min-width:50px;font-weight:bold"></td>';
echo '<td style="min-width:50px;font-weight:bold"></td>';
echo '<td style="min-width:50px;font-weight:bold"></td>';
echo '</tr>';
echo $contentList;
echo '</table>';

?>
<p>
<a href="panels/campaigns/addcampaign.php">Add new content</a>
</p>


