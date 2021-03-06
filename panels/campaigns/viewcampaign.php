<h1>Campaign View</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("an_example");
include '../../config/DB_Class.php';

include_once '../../pages/campaigns/campaignclass.php';

include_once '../../pages/user/userclass.php';
include_once '../../pages/content/contentclass.php';
include_once '../../pages/email/emailclass.php';
include_once '../../config/general.php';

session_start();
$uid = $_SESSION['ID'];
$campaignID = $_GET['ID'];
$user = new User();
$userAddress = $user->withID($uid);

$cam = new Campaign();

$reviewers = $cam->get_reviewers($campaignID);
$archiveComm = $cam->get_archiveComment($campaignID);




?>
<script type="text/javascript">
function sentNotify(){
	alert('Preview successfully sent. Please preview in your mailbox.');

}

</script>




<fieldset name="Group1">
				<legend>Attached Emails</legend>
<?php
$emailArray = $cam->get_attachedEmail($campaignID);
$em = new Email();
if (isset($_GET['eid'])){
	$em->send_emails($_GET['eid'],$user->userEMailAddress);
	echo "<script> sentNotify() </script>";
}
if (isset($_GET['all'])){
	while ($email = mysql_fetch_assoc($emailArray)){
		$eid = $email['emailID'];
		$em->send_emails($eid,$user->userEMailAddress);
	}
	echo "<script> sentNotify() </script>";
}
mysql_data_seek($emailArray,0);
echo "<a href=\"panels/campaigns/viewcampaign.php?ID=".$campaignID."&all=True\">Send preview for all attached email to ".$user->userEMailAddress."</a><br>";
while ($email = mysql_fetch_assoc($emailArray)){
	$eid = $email['emailID'];
	
	
	$email = $em->get_emailByID($eid);
	echo "<div style=\"border: medium none black; overflow: auto; width: 1200px;background-color:gray \">";
	echo "Name: $email[emailName]<br>
		Description: $email[emailDescription]<br>
		From Name: $email[emailFromName]<br>
		From Address: $email[emailFromAddress]<br>
		Subject: $email[emailSubject]<br>";
	
	// Get HTML content to display
	$con = new Content();
	$html = $con->get_contentByID($email[emailHTML]);
	$text = $con->get_contentByID($email[emailText]);
	echo '<br><table align="left" cellpadding="0" cellspacing="0" width="800">
			<tr><td align="left">HTML:</td><td align="left">Text:</td></tr>
			<tr><td align="left">
				<a href="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.html" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $html[fileLocation] . '.png' . '" width="400"></a></td>
			<td align="left">
				<a href="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.txt" target="_blank"><img src="' . $siteUrl . 'content/upload/' . $text[fileLocation] . '.png' . '" width="400"></a></td></tr>
			<tr><td align="left">Keywords: ' . $email[emailKeywords] . '</td></tr>
			<tr><td><br><a href=\"panels/campaigns/viewcampaign.php?ID='.$campaignID.'&all=True\">Send preview for all attached email to '.$user->userEMailAddress.'</a>
				</td></tr>
			</table>';
			
		echo "</div>";	
		echo "<hr />";
}
?>
</fieldset>

<fieldset name="Group1">
				<legend>Reviewers</legend>
<?php
$reviewers = $cam->get_reviewers($campaignID);
?>
<table>
	<tbody class="tablebody">
		
			<?php
			While ($assignRev = mysql_fetch_assoc($reviewers)){
				
				
				echo "<tr>";
				echo	"<td class=\"tablebody\">".$assignRev['userLastName']. ", ".$assignRev['userFirstName'] ."</td>";
				echo "</tr>";
				
			}
			 mysql_data_seek($reviewers,0);
			?>
		</tbody>
	</table>





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
				
				if ($cam->get_reviewerComment($assignRev['reviewerID'], $campaignID) != ""){
				echo "<tr>";
				echo	"<td class=\"tablebody\">".$assignRev['userLastName']. ", ".$assignRev['userFirstName'] ."</td>";
				echo	"<td class=\"tablebody\">".$cam->get_reviewerComment($assignRev['reviewerID'], $campaignID )."</td>";
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

</fieldset>