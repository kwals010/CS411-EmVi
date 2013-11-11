<?php
$subNav = array(
	"Search ; search/search.php ; #F98408;",
	"Search Campaign ; search/searchCampaign.php ; #F98408;",
	"Search Emails ; search/searchEmail.php ; #F98408;",
	"Search Content ; search/searchContent.php ; #F98408;",

);

set_include_path("../");
include("../../inc/essentials.php");


?>
<script>
$mainNav.set("Search") // this line colors the top button main nav with the text "home"
</script>
<h1 class="margin-t-0">Emil Search</h1>


 <form name="aContent" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>">
 <table width="450px">
 
 	<tr>
		<td>Search for email:</td>
		<td><select name="field">
 		<option value="">Select a field:</option>
 		<option value="1">Owner</option>
 		<option value="2">Name</option>
 		<option value="3">ID</option>
 		<option value="4">Key Word</option>
 		<option value="4">Created By</option>
 		<option value="4">Updated By</option>

 		</select>
 		</td>
	</tr>
 	<tr>
		<td>Value:</td>
		<td><input type="text" name="value" /></td>
	</tr>
	
	
	
		</table>
 <input name="Submit1" type="submit" value="Search" />
 </form>


<?php

if (isset($_POST['Submit1'])){
	
session_start();
$uid = $_SESSION['ID'];


include("../../config/DB_Connect.php");
include("../../pages/user/userclass.php");
include("../../pages/content/contentclass.php");


  		$result = mysql_query("SELECT * FROM tbl_user WHERE userFirstName = '".$_POST['Owner']."'");
if (!$result) {    
				die("Query to show fields from table failed userclass.php Line 58");
		}


 echo $_POST['users'];

 echo "<table border='1'>
 <tr>
 <th>Firstname</th>
 <th>Lastname</th>
 <th>Age</th>
 <th>Hometown</th>
 <th>Job</th>
 </tr>";

 while($row = mysql_fetch_assoc($result))
   {
   echo "<tr>";
   echo "<td>" . $row['userFirstName'] . "</td>";
   echo "<td>" . $row['userLastName'] . "</td>";
   echo "<td>" . $row['userPhoneNumber'] . "</td>";
   echo "<td>" . $row['userEMailAddress'] . "</td>";
   echo "<td>" . $row['userID'] . "</td>";
   echo "</tr>";
   }
 
echo "</table>";
}

 ?> 