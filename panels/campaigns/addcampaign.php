<h1>Add Campaign</h1>
<?php
set_include_path("../");

/*Include sidebar */
include("../../inc/sidebar.php");
//showSidebar("addcampaign");

include_once '../../pages/campaigns/campaignclass.php';
include_once '../../pages/user/userclass.php';
include_once '../../config/general.php';
include_once '../../config/functions.php';
session_start();

$uid = $_SESSION['ID'];
$con = new Campaign();
?>

<script type="text/javascript">
function validateForm()
 {
 var name=document.forms["aContent"]["name"].value;
 var desc=document.forms["aContent"]["description"].value;
 var type=document.forms["aContent"]["status"].value;
 
 if (name==null || name=="")
 {
   alert("Content name cannot be blank.");
   return false;
 }
 else if (desc==null || desc=="")
 {
 alert("Content description cannot be blank.");
 return false;
 }
}
</script>



<?php 

// This section handles the page submission and the saving of data to the database
if (!empty($_POST)) {
	

		
		// check keywords. If the default string was left in the box, zero it out
		if ($_POST["keywords"] == '(comma delimited)'){
			$kw = '';
		}
		else {
			$kw = $_POST["keywords"];
		}
		//echo  "year = ".$_POST['start_year']." Month = ".$_POST['start_month']." Day = ".$_POST['start_day'];
		//echo "Status = ". $_POST['status'];
		$ldate = $_POST['start_year']."-".$_POST['start_month']."-".$_POST['start_day'];
		$ldate=date("Y-m-d",strtotime($ldate));
		echo $ldate;
		// Function to write data to the DB is public function add_content($uid,$name,$desc,$kw,$type,$loc)
		$con->add_campaign($uid,$_POST["name"],$_POST["description"],$kw,$con->get_statusIDByName('NEW'),$ldate);
		// Redirect the landing page back to the content main page
		header('Location: '.$siteUrl.'member.php#!/campaigns');
		
}
?>

<form name="aContent" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table width="450px"><tr>
		<td>Campaign name:</td>
		<td><input type="text" name="name" /></td>
	</tr>
	<tr>
		<td>Campaign description:</td>
		<td><input type="text" name="description" /></td>
	</tr>
	<tr>
	<td>Content keywords</td>
	<td><textarea rows="3" cols="20" name="keywords">(comma delimited)</textarea>
	</td>
	</tr>
	<tr>
		<td>Campaign Launch Date:</td>
<!--		<td><input type="text" name="lDate" id="datepicker"/></td>-->
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
		<td></td>
		<td><input type="submit" value="Add"></td>
		</tr>
		</table>
</form>



