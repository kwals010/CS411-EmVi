<?php
$subNav = array(
	"Administration ; admin/admins.php ; #F98408;",
	"Accounts ; admin/accountmaint.php ; #F98408;",
	"CDN setup ; admin/cdnsetup.php ; #F98408;",
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



<h1>User Maintenance</h1>
<a href="panels/user/adduser.php">
<img alt="New_Campaign_Button" src="img/add_new_user_button.png" height="31" width="197"></a>

<h2> Modify user account information</h2>

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
		<table bgcolor= #D28A1E style=" color: navy">
		<tr>
			<td bgcolor= #3366CC style="border: medium solid #000000; min-width:100px; color:white; text-align: center; vertical-align: middle;">
				<p><?php echo $row['userLastName'].", ".$row['userFirstName'];?></p>
			</td>
			<td bgcolor= #3366CC style="border: medium solid #000000; min-width:200px; color:white; text-align: center; vertical-align: middle;">
				<?php echo $row['userEMailAddress'] ?>
			</td>
			<td bgcolor= #3366CC style="border: medium solid #000000; min-width:100px; color:white; text-align: center; vertical-align: middle;">
				<a href="panels/user/useredit.php?ID=<?php echo $row['userID'] ?>">EDIT</a>
			</td>
		</tr>
		
	    </table>
		
<?php
	}
	
	mysql_free_result($query);
	?>
   