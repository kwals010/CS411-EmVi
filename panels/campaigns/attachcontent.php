<h1>Attach Emails</h1>
<?php
set_include_path("../");

/*Include sidebar */
//include("../../inc/sidebar.php");
//showSidebar("an_example");
include '../../config/DB_Class.php';

include_once '../../config/general.php';
include_once '../../pages/campaigns/campaignclass.php';


session_start();
$uid = $_SESSION['ID'];
$con = new Campaign();

if (isset($_POST['Attach'])){

	$attachEmail = $_POST['emails'];
	
	for($i = 0; sizeof($attachEmail) > $i; $i++){
		echo $attachEmail[$i];	
		$con->attachContent($_POST['campaignID'], $attachEmail[$i]);
		echo "Test";
	} 
header('Location: '.$siteUrl.'member.php#!/campaigns');
}



?>

<p>Please select form the list the emails that you would like to attach to this campaign.  Multiple <br>
emails can be selected by holding down the CTRL key while selecting.</p>
<fieldset name="Group1">
				<legend>Attach Email</legend>
				<form name="addEmail" method="post" action="<?php echo $_SERVER['PHP_SELF']."?ID=".$_GET['ID'];?>">
				
					<select name="emails[]" multiple="multiple" style="height:242px">
					<?php
						include_once '../../pages/email/emailclass.php';
						$emailList = new Email();
						$emailList = $emailList->get_email("Name","asc");
						$currentAttached = $con->get_attachedEmail($_GET['ID']);
						
						for ($i = 1; $i < count($emailList); ++$i) {
							$found = false;
							while($row = mysql_fetch_assoc($currentAttached )){
								
								if ($row['emailID'] == $emailList[$i]['ID']){
									//echo "<option value=\"".$emailList[$i]['ID']."\" selected=\"selected\">".$emailList[$i]['Name']."</option>";
									$found = true;
								}
							}
							mysql_data_seek($currentAttached,0);
							if ($found == false){
							echo "<option value=\"".$emailList[$i]['ID']."\">".$emailList[$i]['Name']."</option>";
							}
						}

						
						
					?>
					</select>
					<input name="campaignID" type="hidden" value="<?php echo $_GET['ID']; ?>" />
					<input name="Attach" type="submit" value="Attach" />
				</form>
			</fieldset>
			<fieldset name="Group1">
				<legend>Already Attached to this campaign</legend>
			<form name="removeEmail" method="post" action="<?php echo $_SERVER['PHP_SELF']."?ID=".$_GET['ID'];?>">

			<input name="campaignID" type="hidden" value="<?php echo $_GET['ID']; ?>" />
			<table>
			<tr><td>Email Name</td><td>Remove</td></tr>
			
			<?php
					
						
						
						for ($i = 1; $i < count($emailList); ++$i) {
							$found = false;
							while($row = mysql_fetch_assoc($currentAttached )){
								
								if ($row['emailID'] == $emailList[$i]['ID']){
									
									echo "<tr><td>".$emailList[$i]['Name']."</td><td><input name=\"".$emailList[$i]['ID']."\" type=\"checkbox\" /></td></tr>";
									$found = true;
								}
							}
							mysql_data_seek($currentAttached,0);
							
						}
							
						
						
					?>
					<tr><td></td><td><input name="Remove" type="submit" value="Remove Selected" /></td></tr>

			</table>
			</form>
			</fieldset>
			
			
			<?php
			
				if(isset($_POST['Remove'])){
					
					while($row = mysql_fetch_assoc($currentAttached)){
						if ($_POST[''.$row['emailID'].''] == 'on'){
							$con->detach_emailFromCampaign($_POST['campaignID'], $row['emailID']);		
						}
					}
					header('Location: '.$siteUrl.'member.php#!/campaigns');					
				}
			?>
			