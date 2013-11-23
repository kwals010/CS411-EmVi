<?php
$subNav = array(
	"Accounts ; admin/accountmaint.php ; #F98408;",
	// "CDN setup ; admin/cdnsetup.php ; #F98408;",
	"Site Config ; admin/siteconfig.php ; #F98408;",
);

set_include_path("../");
include("../../inc/essentials.php");
include("../user/userclass.php");

 
$edit = new User();
if(isset($_POST['UID'])){
$edit = $edit->withID($_POST['UID']);
}
$bot = true;
$page = "account";
$reqUrl = "accountmaint.php";
if (isset($_GET['msgID'])){
	
	include '../user/messageclass.php';
	$inform = new message();
	$inform->printMessage($_GET['msgID']);
}

?>
<script>
$mainNav.set("administration") // this line colors the top button main nav with the text "home"
</script>
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



<h1>User Maintenance</h1>
<a href="panels/user/adduser.php">
<img alt="New_Campaign_Button" src="img/add_new_user_button.png" height="31" width="197"></a>

<h2> Modify user account information</h2>
<table bgcolor= #D28A1E style=" color: navy">
		<thead>
			<tr>
			<th class="tableheaders">Name</th>
			<th class="tableheaders">UserName</th>
			<th class="tableheaders">Edit</th>
			</tr>
		
		</thead>
<?php 
	// Connects to your Database 
	include ("../../config/DB_Connect.php");

	//$orderBy = array('`User`.`UID`', '`User`.`FName`', '`User`.`MI`', '`User`.`LName`', '`User`.`username`', '`User`.`EMail`', '`User`.`LocID`', '`User`.`PhNum`', '`User`.`Status`', '`User`.`Rights`'); 
 
	$order = "`tbl_user`.`userID`"; 
	//if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) { 
   	//	$order = $_GET['orderBy'];
   		
	//} 
 
	$query = mysql_query("SELECT userID, userLastName, userFirstName, userEMailAddress FROM tbl_user WHERE 1 ORDER BY userLastName");
	if (!$query) {    
		die("Query to show fields from table failed accountmaint.php Line 78");
	}
	?>
<?php
	// printing table rows
	while($row = mysql_fetch_assoc($query)){ 
		?>
		
		<tr>
			<td class="tablebody">
				<p><?php echo $row['userLastName'].", ".$row['userFirstName'];?></p>
			</td>
			<td class="tablebody">
				<?php echo $row['userEMailAddress'] ?>
			</td>
			<td class="tablebody">
				<a href="panels/user/useredit.php?ID=<?php echo $row['userID'] ?>">EDIT</a>
			</td>
		</tr>
		
	    
		
<?php
	}
	
	mysql_free_result($query);
	?>
   </table>