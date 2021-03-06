<?php

$subNav = array(
	"All Email ; content/email.php ; #F98408;",
	"My Email ; content/myemail.php ; #F98408;",
	"Add Email ; ../panels/content/addemail.php ; #F98408;", 
);

set_include_path("../");
include("../../inc/essentials.php");
include_once 'contentclass.php';
session_start();
$uid = $_SESSION['ID'];

?>
<script>
$mainNav.set("content"); // this line colors the top button main nav with the text "home"
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

$content = new Content();
$types = $content->get_content($orderby,$dir);
// Function returns the following beginning in row 1:
// ID, Name, Description, Keywords, TypeID, Format, CreatedDate, CreatedByID, CreatedByName, 
// UpdatedDate, UpdatedByID, UpdatedByName, OwnedByID, OwnedByName, FileName

$contentList = '';
for ($i = 1; $i < count($types); ++$i) {
		$contentList .= '<tr><td>'. htmlentities($types[$i]['Name']) . '</td>
		<td>' . htmlentities($types[$i]['Format']) . '</td>
		<td>' . htmlentities($types[$i]['Description']) . '</td>
		<td>' . htmlentities($types[$i]['Keywords']) . '</td>
		<td>' . date("m/d/Y g:i a", strtotime($types[$i]['UpdatedDate'])) . '</td>
		<td>' . htmlentities($types[$i]['OwnedByName']) . '</td>
		<td>';
	if ($types[$i]['FileName'] != '') {
		$contentList .= '<a href="content/upload/'. $types[$i]['FileName'] .'" target="_blank">View</a>';
	}
	$contentList .=	'</td><td>';
	if ($types[$i]['OwnedByID'] == $uid) {
		$contentList .= '<a href="panels/content/editcontent.php?ID='.$types[$i]['ID'].'">Edit</a>';
	}
	$contentList .= '</td>	
		<td>Clone</td>
		<td>';
	if ($types[$i]['OwnedByID'] == $uid) {
		$contentList .= 'Delete';
	}	
	$contentList .= '</td>
		<td>';
	if ($types[$i]['cdnID'] == '') {
		if ($types[$i]['OwnedByID'] == $uid) {
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
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=Name&dir=desc" style="text-decoration:none;">Content Name</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=Name&dir=asc" style="text-decoration:none;">Content Name</td>';
}
if (strtolower($orderby) == 'format' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=Format&dir=desc" style="text-decoration:none;">Format</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=Format&dir=asc" style="text-decoration:none;">Format</td>';
}
if (strtolower($orderby) == 'description' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=Description&dir=desc" style="text-decoration:none;">Description</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=Description&dir=asc" style="text-decoration:none;">Description</td>';
}
if (strtolower($orderby) == 'keywords' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=Keywords&dir=desc" style="text-decoration:none;">Keywords</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=Keywords&dir=asc" style="text-decoration:none;">Keywords</td>';
}
if (strtolower($orderby) == 'updatedate' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=UpdatedDate&dir=desc" style="text-decoration:none;">Last Updated</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=UpdatedDate&dir=asc" style="text-decoration:none;">Last Updated</td>';
}
if (strtolower($orderby) == 'ownedby' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=OwnedByName&dir=desc" style="text-decoration:none;">Locked By</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/content/content.php?orderBy=OwnedByName&dir=asc" style="text-decoration:none;">Locked By</td>';
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
<a href="../content/panels/content/addcontent.php">Add new content</a>
</p>

