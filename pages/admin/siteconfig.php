<?php
$subNav = array(
	"Administration ; admin/admins.php ; #F98408;",
	"Accounts ; admin/accountmaint.php ; #F98408;",
	"CDN setup ; admin/cdnsetup.php ; #F98408;",
	"Site Config ; admin/siteconfig.php ; #F98408;",

);

set_include_path("../");
include("../../inc/essentials.php");
?>
<script>
$mainNav.set("administration") // this line colors the top button main nav with the text "home"
</script>
<h1 class="margin-t-0">EmVi Configuration Page</h1>
<hr>
<h3>Password Requirements</h3>

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


<?php 
if (isset($_POST['Apply'])){
	include_once '../../config/DB_Connect.php';
	
	$passLength ="UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`=".$_POST['passLength']." WHERE `configObject`='passLength'";
	$passReq = "UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`=".$_POST['passReq']." WHERE `configObject`='passReq'";
	mysql_query($passLength)or die(mysql_error());
	mysql_query($passReq)or die(mysql_error());
	include_once '../../config/general.php';
	header('Location: '.$siteUrl.'member.php#!/siteconfig');

	
}
if (isset($_POST['Disable'])){
	include_once '../../config/DB_Connect.php';
	
	$passLength ="UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`=0 WHERE `configObject`='passLength'";
	$passReq = "UPDATE `tbl_siteConfig` SET `configEnable`=1,`configBlockCode`=0 WHERE `configObject`='passReq'";
	mysql_query($passLength)or die(mysql_error());
	mysql_query($passReq)or die(mysql_error());
	include_once '../../config/general.php';
	header('Location: '.$siteUrl.'member.php#!/siteconfig');


}


?>

