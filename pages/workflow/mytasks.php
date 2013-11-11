
<head>
<style type="text/css">
.tableheaders {
	width:140px;
	font-weight: normal;
	font-size: small;
	color: #FAF6F6;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	background-color: #000080;
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
</head>

<?php

$subNav = array(
	"My campaign Tasks ; workflow/mytasks.php ; #F98408;",
	"My Review Tasks ; workflow/reviewtasks.php ; #F98408;",
	
);

set_include_path("../");
include("../../inc/essentials.php");
include_once 'workflowclass.php';
session_start();
$uid = $_SESSION['ID'];

$myWork = new Workflow();
$workQuery = $myWork->get_myOpenWork($uid);
$count = mysql_num_rows($workQuery);
?>
<script>
$mainNav.set("Home"); // this line colors the top button main nav with the text "home"
</script>

<h1>My Work</h1>
<p>You have <?php echo $count; ?> open campaigns!</p>

<table>
	<thead style="border-bottom:thick; border-bottom-color:black; border-bottom-width:thick; border:thick; border-bottom-style:solid; border-color: #000000;">
		<tr >
			<th class="tableheaders"><strong>Campaign Name</strong></th>
			<th class="tableheaders"><strong>Launch Date</strong></th>
			<th class="tableheaders"><strong>Status</strong></th>
			<th class="tableheaders"><strong>Last Update</strong></th>
			<th class="tableheaders"><strong>Updated By</strong></th>
			<th class="tableheaders"><strong>Description</strong></th>
			<th class="tableheaders">&nbsp;</th>
			<th class="tableheaders">&nbsp;</th>
			<th class="tableheaders">&nbsp;</th>
			<th class="tableheaders">Review</th>
			<th class="tableheaders">&nbsp;</th>
		</tr>
		
	</thead>
	
	<tbody>
		
<?php
		while ($row = mysql_fetch_assoc($workQuery)){
		echo "<tr>";
		echo "<td class=\"tablebody\">".$row['campaignName']."</td>";
		echo "<td class=\"tablebody\">".date("m/d/Y", strtotime($row['launchDate']))."</td>";
		echo "<td class=\"tablebody\">".$row['wfStatusName']."</td>";
		echo "<td class=\"tablebody\">".date("m/d/Y g:i a", strtotime($row['launchDate']))."</td>";
		echo "<td class=\"tablebody\">".$row['userFirstName']." ".$row['userLastName']."</td>";
		echo "<td class=\"tablebody\">".$row['campaignDescription']."</td>";
		echo "<td class=\"tablebody\"><a href=\"panels/campaigns/viewcampaign.php?ID=".$row['campaignID']."\">View</a></td>";
		if ($row['wfStatusName'] == "In Review" || $row['canEdit'] == 0){
		echo "<td class=\"tablebody\"></td>";
		}else{
		echo "<td class=\"tablebody\"><a href=\"panels/campaigns/editcampaign.php?ID=".$row['campaignID']."&page=a\">Edit</a></td>";
		}
		echo "<td class=\"tablebody\">Clone</td>";
		if ($row['wfStatusName'] == "In Review"){
		echo "<td class=\"tablebody\"><a href=\"panels/workflow/recallreview.php?ID=".$row['campaignID']."\">Recall</a><br></td>";
		}else if($row['wfStatusName'] == "Approved"){
		echo "<td class=\"tablebody\"><a href=\"panels/workflow/recallreview.php?ID=".$row['campaignID']."\">Recall</a></td>";
		}else{
		echo "<td class=\"tablebody\"><a href=\"panels/workflow/sendreview.php?ID=".$row['campaignID']."\">Send<br>for review</a></td>";

		}
		echo "<td class=\"tablebody\"><a href=\"panels/workflow/wfreassign.php?ID=".$row['campaignID']."\">Reassign</a></td>";
		echo "</tr>";

		}
?>
		
		
	</tbody>

</table>

