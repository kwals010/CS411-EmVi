<h1>Clone Campaign</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("editcontent");
include '../../config/DB_Class.php';


include_once '../../pages/campaigns/campaignclass.php';
//include_once '../../pages/workflow/workflowclass.php';
include_once '../../pages/user/userclass.php';
include_once '../../config/general.php';
include_once '../../config/functions.php';

session_start();

$con = new Campaign();
//$review = new Workflow();
if (isset($_GET['ID'])){
$campaign = $con->get_campaignByID($_GET['ID']);
$reviewers = $con->get_reviewers($_GET['ID']);
}
if (isset($_POST['campaignID'])){
$campaign = $con->get_campaignByID($_POST['campaignID']);
$reviewers = $con->get_reviewers($_POST['campaignID']);
}
$uid = $_SESSION['ID'];

?>

<script type="text/javascript">
function validateForm()
 {
 var name=document.forms["aCampaign"]["name"].value;
 var desc=document.forms["aCampaign"]["description"].value;
 
 if (name==null || name=="")
 {
   alert("Campaign name cannot be blank.");
   return false;
 }
 else if (desc==null || desc=="")
 {
 alert("Campaign description cannot be blank.");
 return false;
 }
 
}


</script>

<?php 

// This section handles the page submission and the saving of data to the database
	if (!empty($_POST)) {
	// check to ensure that file type chosen is the same as file type of the file

		// check keywords. If the default string was left in the box, zero it out
		if ($_POST["keywords"] == '(comma delimited)'){
			$kw = '';
		}
		else {
			$kw = $_POST["keywords"];
		}
		$page = $_POST['page'];
		$ldate = $_POST['start_year']."-".$_POST['start_month']."-".$_POST['start_day'];
		$ldate=date("Y-m-d",strtotime($ldate));
		echo $ldate;

		// Function to write data to the DB is public function edit_campaign($cid,$uid,$name,$desc,$kw,$status,$ldate)
		$con->add_campaign($uid,$_POST["name"],$_POST["description"],$kw,$con->get_statusIDByName($_POST["status"]),$ldate);
		
				
		

		// Redirect the landing page back to the content main page
		if ($page == 'a'){
		header('Location: '.$siteUrl.'member.php#!/url=workflow/mytasks.php');
		}else{
		header('Location: '.$siteUrl.'member.php#!/campaigns');

		}
	}	

?>
<div style="overflow:auto">
<form name="aCampaign" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width="450px"><tr>
		<td>Content name:</td>
		<td><input type="text" name="name" value="<?php echo $campaign['campaignName'];?>" /></td>
		</tr>
	<tr>
		<td>Content description:</td>
		<td><input type="text" name="description" value="<?php echo $campaign['campaignDescription'];?>" /></td>
		
	</tr>
	<tr>
	<td>Content keywords</td>
	<td><textarea rows="3" cols="20" name="keywords" value="<?php echo $campaign['campaignKeywords'];?>"><?php 
	if ($campaign['campaignKeywords'] != ""){
		echo $campaign['campaignKeywords'];
	}else{
		echo "(comma delimited)";
	}
	?>
	</textarea>
	</td>
	</tr>
	<tr>
		<td>Campaign Launch Date:</td>
		<td><table>
				<tr><td>Year</td><td>Month</td><td>Day</td></tr>
				<tr>
				<td><?php echo createYears(2000, 2030, 'start_year', date("Y")) ?></td>
				
				<td><?php echo createMonths('start_month', date("m")); ?></td>
				
				<td><?php echo createDays('start_day', date("d")); ?></td>
				
				</tr>
				
				</table>
		</td>
	</tr>
	
	<tr>
		<td>Campaign Status:</td>
		<td>
		<select name="status" value="New">
<?php 
 $types = $con->get_campaign_status();
 $skip = 0;
 $cStatus = $con->get_campaignStatusByID($campaign['campaignStatus']);
 foreach($types as $t)
 {
 	if ($skip > 0)
 		{
 		echo "<option>". $t['wfStatusName'] ."</option>";
}
 		++$skip;
 }
?>
		</select>
		</td>
	</tr>
	
	
	


	
		<tr>
		<td></td>
		<input type="hidden" name="page" value="<?php echo $_GET['page'];?>" />

		<input type="hidden" name="campaignID" value="<?php echo $_GET['ID'];?>" />
		<td><input type="submit" value="Clone"></td>
		</tr>
		</table>
</form>

</div>
