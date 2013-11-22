<?php
	$subNav = array(
		"Accounts ; admin/accountmaint.php ; #F98408;",
		"CDN setup ; admin/cdnsetup.php ; #F98408;",
		"Site Config ; admin/siteconfig.php ; #F98408;",
	
	);
	
	set_include_path("../");
	include("../../inc/essentials.php");
	//include_once '../../config/DB_Connect.php';
	include_once '../../config/general.php';
?>
<script>
	$mainNav.set("administration") // this line colors the top button main nav with the text "home"
</script>
<h1 class="margin-t-0">EmVi Configuration Page</h1>
<hr>
<fieldset name="PasswordReq">
	<legend>Password Requirements</legend>
			
<?php
		include_once '../../config/DB_Connect.php';
		$passLength = mysql_query("SELECT `configBlockCode` FROM `tbl_siteConfig` WHERE `configObject`='passLength'")or die(mysql_error());
	
		$passReq = mysql_query("SELECT `configBlockCode` FROM `tbl_siteConfig` WHERE `configObject`='passReq'")or die(mysql_error());
	
		$passLength = mysql_fetch_assoc($passLength);
		$passReq = mysql_fetch_assoc($passReq);
					
?>
			
			 
	<form name="siteEdit" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		
		<p>Password must meet <select name="passReq">
<?php 
			for ($i = 0; $i < 6; ++$i){
			if ($i == $passReq['configBlockCode']){
					echo "<option value=\"".$i."\" selected>".$i."</option>";
				}else{
					echo "<option value=\"".$i."\">".$i."</option>";
				}

			}
?>
						
		
		</select> of the requirements below!<br>
		1.) Password must be at least 
		<select name="passLength">
			<?php 
			for ($i = 4; $i < 24; ++$i){
				if ($i == $passLength['configBlockCode']){
					echo "<option value=".$i." selected>".$i."</option>";
				}else{
					echo "<option value=".$i.">".$i."</option>";
				}
			}
			?>
		
		</select> characters long.<br>
		2.) One uppercase letter<br>
		3.) One lowercase letter<br>
		4.) One number<br>
		5.) One special character</p>
		<input name="Apply" type="submit" value="Apply" /><br>
		<input name="Disable" type="submit" value="Disable Password Restrictions" />
	</form>

</fieldset>

<fieldset name="SiteAdmin">
		<legend>Site Admin</legend>
				
		<form name="Administrator" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<label id="Label1">Select a site administrator from the site</label>
			<select name="adminID">
			<?php
				$sql ="SELECT `userID`, `userFirstName`, `userLastName` FROM `tbl_user` WHERE `userRole` = 1 ORDER BY `userLastName` ASC";
				$admin = mysql_query($sql)or die(mysql_error());
				$current = mysql_fetch_assoc(mysql_query("SELECT `configBlockCode` FROM `tbl_siteConfig` WHERE `configObject`='adminUserID'"));
				while($row = mysql_fetch_assoc($admin)){
					if($current['configBlockCode'] == $row['userID']){
						echo "<option value=\"".$row['userID']."\" selected=\"selected\">".$row['userLastName'].", ".$row['userFirstName']."</option>";
					}else{
						echo "<option value=\"".$row['userID']."\">".$row['userLastName'].", ".$row['userFirstName']."</option>";
					}
				}

			?>
					
				</select>
			<p>This person will be used for notifications.  If there are problems with the tool<br> or accounts this is the person that will be contacted.</p>
			<input name="Administrator" type="submit" value="Save" />
		</form>			
				
</fieldset>
<fieldset name="SiteURL">
		<legend>Site URL configuration</legend>
		<form name="URL" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<label id="Label1">Please enter the site URL.</label>
			<?php $currentURL = mysql_fetch_assoc(mysql_query("SELECT `configBlockCode` FROM `tbl_siteConfig` WHERE `configObject`='siteURL'"));?>
			<input name="siteURL" type="text" value="<?php echo $currentURL['configBlockCode'];  ?>"/>
			<p>(ex. WWW.Somtething.com)</p>
			<input name="URL" type="submit" value="Save" />
		</form>			
				
</fieldset>
<fieldset name="SiteURL">
		<legend>Content URL configuration</legend>
		<form name="URL" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<label id="Label1">Please enter the location of content upload folder.</label>
			<?php $currentURL = mysql_fetch_assoc(mysql_query("SELECT `configBlockCode` FROM `tbl_siteConfig` WHERE `configObject`='filesLocation'"));?>
			<input name="contentURL" type="text" value="<?php echo $currentURL['configBlockCode'];  ?>"/>
			<p>(ex. /var/www/emvi/content/upload/)</p>
			<input name="contentURL" type="submit" value="Save" />
		</form>			
				
</fieldset>




<?php 
	if (isset($_POST['Apply'])){
		
		
		$passLength ="UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`=".$_POST['passLength']." WHERE `configObject`='passLength'";
		$passReq = "UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`=".$_POST['passReq']." WHERE `configObject`='passReq'";
		mysql_query($passLength)or die(mysql_error());
		mysql_query($passReq)or die(mysql_error());
		header('Location: '.$siteUrl.'member.php#!/siteconfig');
	
		
	}
	if (isset($_POST['Disable'])){
		
		
		$passLength ="UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`=0 WHERE `configObject`='passLength'";
		$passReq = "UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`=0 WHERE `configObject`='passReq'";
		mysql_query($passLength)or die(mysql_error());
		mysql_query($passReq)or die(mysql_error());
		header('Location: '.$siteUrl.'member.php#!/siteconfig');
	
	
	}
	if (isset($_POST['Administrator'])){
		
		
		$Administrator ="UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`='".$_POST['adminID']."' WHERE `configObject`='adminUserID'";
		mysql_query($Administrator )or die(mysql_error());
		header('Location: '.$siteUrl.'member.php#!/siteconfig');
	
	
	}
	if (isset($_POST['URL'])){
		
		
		$Administrator ="UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`='".$_POST['siteURL']."' WHERE `configObject`='siteURL'";
		mysql_query($Administrator )or die(mysql_error());
		header('Location: '.$siteUrl.'member.php#!/siteconfig');
	
	
	}

	if (isset($_POST['contentURL'])){
		
		
		$Administrator ="UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`='".$_POST['contentURL']."' WHERE `configObject`='filesLocation'";
		mysql_query($Administrator )or die(mysql_error());
		header('Location: '.$siteUrl.'member.php#!/siteconfig');
	
	
	}


?>

