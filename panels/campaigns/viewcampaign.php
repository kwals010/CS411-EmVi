
<head>
<style type="text/css">
.tableheaders {
	width:140px;
	font-weight: normal;
	font-size: small;
	color: #FAF6F6;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	background-color: #117CF8;
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




<h1>Campaign View</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("an_example");

include_once '../../pages/user/userclass.php';

session_start();
$uid = $_SESSION['ID'];
$campaignID = $_GET['ID'];

include_once '../../pages/campaigns/campaignclass.php';
$con = new Campaign();

$reviewers = $con->get_reviewers($campaignID);
$archiveComm = $con->get_archiveComment($campaignID);
?>

<div style="border-style: solid; border: medium; border-color: black;">


<h5>Preview Campaign</h5>
<h5>Reviewers</h5>
<h5>Other stuff to allow approval to happen</h5>

<h5>Current Review Comments</h5>
	<table>
	
		<thead class="tableheaders">
			<tr>
				<th class="tableheaders">Reviewer</th>
				<th class="tableheaders">Comments</th>
				<th class="tableheaders">Decision</th>
				<th class="tableheaders">Date</th>
			</tr>	
		</thead>
		<tbody class="tablebody">
		
			
			<?php
			While ($assignRev = mysql_fetch_assoc($reviewers)){
				
				if ($con->get_reviewerComment($assignRev['reviewerID'], $campaignID) != ""){
				echo "<tr>";
				echo	"<td class=\"tablebody\">".$assignRev['userLastName']. ", ".$assignRev['userFirstName'] ."</td>";
				echo	"<td class=\"tablebody\">".$con->get_reviewerComment($assignRev['reviewerID'], $campaignID )."</td>";
				echo	"<td class=\"tablebody\">";
				if ($assignRev['reviewResult'] == 1){
					echo "Approved";
				}else{
					echo "Rejected";
				}
				echo "</td>";
				echo	"<td class=\"tablebody\">".$assignRev['commentDate'] ."</td>";

				echo "</tr>";
				}
			}
			?>
		</tbody>
	</table>


<h5>Previous Review Comments</h5>
	<table>
	
		<thead class="tableheaders">
			<tr>
				<th class="tableheaders">Reviewer</th>
				<th class="tableheaders">Comments</th>
				<th class="tableheaders">Decision</th>
				<th class="tableheaders">Date</th>
			</tr>	
		</thead>
		<tbody class="tablebody">
		
			
			<?php
			While ($oldCom = mysql_fetch_assoc($archiveComm)){
				
				if ($oldCom['comment'] != ""){
				echo "<tr>";
				echo	"<td class=\"tablebody\">".$oldCom['userLastName']. ", ".$oldCom['userFirstName'] ."</td>";
				echo	"<td class=\"tablebody\">".$oldCom['comment'] ."</td>";
				echo	"<td class=\"tablebody\">";
				if ($oldCom['reviewResult'] == 1){
					echo "Approved";
				}else{
					echo "Rejected";
				}
				echo "</td>";

				echo	"<td class=\"tablebody\">".$oldCom['commentDate'] ."</td>";

				echo "</tr>";
				}
			}
			?>
		</tbody>
	</table>

</div>