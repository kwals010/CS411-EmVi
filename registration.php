 <?php
session_start();
/* METRO UI TEMPLATE v4.b1
/*
/* Copyright 2013 Thomas Verelst, http://metro-webdesign.info
/* Do not redistribute or sell this template, nor claim this is your own work. 
/* Donation required when using this. */

require_once('inc/defaults.php');
require_once('admin/config.php');
require_once('config/general.php');
require_once('config/layout.php');
require_once('config/pages.php');
require_once('config/mobile.php');

require_once('inc/detectdevice.php');

/* TILE INITS */
require_once('inc/init.php');
require_once('inc/tilefunctions.php');


/* FILES*/
$cssFiles = array( /* Add your css files to this array */
	'css/layout.css',
	'css/nav.css',
	'css/tiles.css',
	'themes/'.$theme.'/theme.css',	
);
$jsFiles = array( /* Add your js files to this array */
	'js/functions.js',
	'js/main.js',	
);

/* PLUGIN SYSTEM */
require_once("inc/plugins.php");
foreach(glob("plugins/" . "*") as $folder){
	if(is_dir($folder) && !in_array($folder, $disabledPluginsDesktop)){
		if(file_exists($folder."/plugin.js")){
			$jsPluginsArray[] = $folder."/plugin.js";		
		}
		if(file_exists($folder."/plugin.css")){
			$cssPluginsArray[] = $folder."/plugin.css";		
		}
		if(file_exists($folder."/desktop.js")){
			$jsPluginsArray[] = $folder."/desktop.js";		
		}
		if(file_exists($folder."/desktop.css")){
			$cssPluginsArray[] = $folder."/desktop.css";		
		}
		if(file_exists($folder."/plugin.php")){
			include($folder."/plugin.php");
		}
	}
}

triggerEvent("beforeDoctype");
?>
<!DOCTYPE html>
<?php
triggerEvent("afterDoctype");


if(file_exists('themes/'.$theme.'/theme.js')){
	$jsFiles[] = 'themes/'.$theme.'/theme.js';
}
if(file_exists('themes/'.$theme.'/theme.php')){
	require_once('themes/'.$theme.'/theme.php');
}

triggerEvent("fileInclude");

require_once("inc/compress.php");
require_once("inc/seo.php");
?>
<?php // if(strpos($_SERVER['HTTP_USER_AGENT'],"Version/4.0")!=false&&strpos($_SERVER['HTTP_USER_AGENT'],"Android")!=false&&strpos($_SERVER['HTTP_USER_AGENT'],"AppleWebKit/")!=false){}?>
<html>
<head>
	<?php triggerEvent("headStart");?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="<?php echo $siteMetaDesc;?>"/>
    <meta name="keywords" content="<?php echo $siteMetaKeywords;?>"/>
    <link rel="icon" type="image/ico" href="<?php echo $favicon_url;?>"/>
    <meta name="viewport" content="width=1024,initial-scale=1.00, minimum-scale=1.00">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo $siteTitle;?></title> 
    <META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
    <?php
	
    /*FONT*/
    if($googleFontURL != ""){?>
    	<link href='<?php echo $googleFontURL?>' rel='stylesheet' type='text/css'>
		<?php
	}

	/*CSS*/
	echo $css;
	include_once("inc/css.php");
	
	/*GA*/
	if($googleAnalyticsCode != ""){
		?><script type='text/javascript'>var _gaq = _gaq || [];_gaq.push(['_setAccount', '<?php echo $googleAnalyticsCode?>']);_gaq.push(['_trackPageview']);(function(){var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script><?php
	}
	?> 
    <!--[if lt IE 9]>
    <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js/html5.js">
	<![endif]-->
	<!--[if gte IE 9]>
    <script src="http://code.jquery.com/jquery-2.0.0b2.js"></script>
    <script src="js/html5.js">
	<![endif]-->
    <!--[if !IE]>
    <script src="http://code.jquery.com/jquery-2.0.0b2.js"></script>
	<![endif]-->

    <script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery191.js"><\/script>')</script> 
    <script type="text/javascript" language="javascript" src="js/plugins.js"></script>
	<?php
	/*JS */
	include("inc/phptojs.php");
	if(!$bot){
		echo $js;
	}

    triggerEvent("headEnd");
	?>
    <noscript><style>#tileContainer{display:block}</style></noscript>
	
</head>
<body class="full <?php echo $device?>">
<?php
triggerEvent("bodyBegin");

/*BG image*/
if($bgImage!=""){
	echo "<img src='".$bgImage."' id='bgImage'/>";
}
?>
<header>
	<div id="headerWrapper">
		<div id="headerCenter">
			<div id="headerTitles">
				<h1><a href="<?php if($bot){echo "index.php";}?>#!"><?php echo $siteName?></a></h1>
		   		<h2><?php echo $siteDesc;?></h2>
		    </div>
		    <form action="logon.php" method="post"> 
 				<table border="0" align="center" style="width: 202px"> 
 					<tr><td colspan=2 class="auto-style3"></td></tr> 
 					<tr><td class="auto-style3">Username:</td><td class="auto-style3"> 
 					<input type="text" name="username" maxlength="50" style="width: 128px"> 
 					</td></tr> 
 					<tr><td class="auto-style3">Password:</td><td class="auto-style3"> 
 					<input type="password" name="pass" maxlength="50" style="width: 128px"> 
 					</td></tr> 
 					<tr><td colspan="2" class="auto-style3"> 
 					<input type="submit" name="submit" value="Login"> 
 					</td></tr> 
 				</table> 
 			</form> 
		</div>
    </div>
    <?php triggerEvent("headerEnd");?>
</header>

			
<div id="wrapper">
	<div id="centerWrapper">
  		
				<?php 


 // Connects to your Database 
//include 'config/DB_Connect.php';
include 'config/functions.php';
//Message class used to retrieve any messages sent to this page.			

$msgID = array (0,1,2,3,4);

//mysql_select_db(DATABASE, $con);
//echo "test";
 //This code runs if the form has been submitted
 if (isset($_POST['submit'])) { 

 //This makes sure they did not leave any fields blank
 if (!$_POST['userFirstName'] | !$_POST['userLastName'] | !$_POST['userEMailAddress'] | !$_POST['pass'] | !$_POST['pass2'] ) {
 		$msgID[0]=407; 		
 		//die('You did not complete all of the required fields. Please go back and complete all fields in the form.  Thank you!');
 	}
 // checks to see if usernames is an email address and if the username is in use
 	if (!check_email_address(mysql_real_escape_string($_POST['userEMailAddress']))){
 		$msgID[1]=405; 
 		//die('A valid e-mail address was not entered.  Please enter a valid email address and resubmit.');
 	}
 	if (!get_magic_quotes_gpc()) {
 		$_POST['userEMailAddress'] = addslashes($_POST['userEMailAddress']);
 	}

 $check = mysql_query("SELECT userEMailAddress FROM tbl_user WHERE userEMailAddress = '".mysql_real_escape_string($_POST['userEMailAddress'])."'") 
or die(mysql_error());
 $check2 = mysql_num_rows($check);

 //if the name exists it gives an error
 if ($check2 != 0) {
 		$msgID[2]=408; 
 		//die('Sorry, the username '.$_POST['userEMailAddress'].' is already in use.');
 				}

 // this makes sure both passwords entered match and are of proper length and complexity
 	if (!check_password(mysql_real_escape_string($_POST['pass']))){
 		$msgID[3]=404; 
 		//die('Your password does ot meet the minumum requiremetns posted on the registration page.  Please resubmit.');
 	}
 	if ($_POST['pass'] != $_POST['pass2']) {
 		$msgID[4]=406; 
 		//die('Your passwords did not match. ');
 	}

 	// here we encrypt the password and add slashes if needed
 	$_POST['pass'] = md5($_POST['pass']);
 	if (!get_magic_quotes_gpc()) {
 		$_POST['pass'] = addslashes($_POST['pass']);
 		$_POST['userEMailAddress'] = addslashes($_POST['userEMailAddress']);
 			}
	
 
	 
  // now we insert it into the database
  	if (($msgID[0] == 0) && ($msgID[1] == 1) && ($msgID[2] == 2) && ($msgID[3] == 3) && ($msgID[4] == 4)){
 	$insert = "INSERT INTO tbl_user (userFirstName, userLastName, userEMailAddress, userPhoneNumber, userPassword)
 			VALUES ('".mysql_real_escape_string($_POST['userFirstName'])."', '".mysql_real_escape_string($_POST['userLastName'])."', '".mysql_real_escape_string($_POST['userEMailAddress'])."', 
 			'".mysql_real_escape_string($_POST['userPhoneNumber'])."', '".$_POST['pass']."')";
 	$add_member = mysql_query($insert) or die(mysql_error());
 	$msgID[0] = 700;
 	
 	//Get site admin and site url from DB to use in email notification.  These will be set using the site administraion functions.
 	$current = mysql_fetch_assoc(mysql_query("SELECT `configBlockCode` FROM `tbl_siteConfig` WHERE `configObject`='adminUserID'"));

 	$sql =mysql_query("SELECT * FROM `tbl_user` WHERE `userID` = ".$current['configBlockCode']."")or die(mysql_error());
		$admin = mysql_fetch_assoc($sql);
		
 	// multiple recipients
$to  = $_POST['userEMailAddress']; // note the comma
$random_hash = md5(date('r', time())); 

// subject
$subject = 'EmVi Registration Confirmation';

// message
$message = '
<html>
<head>
  <title>EmVi Registration Confirmation</title>
</head>
<body>
<div style="background: #eee; border: 1px solid #ccc; padding: 5px 10px;">
<p>&nbsp;</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<strong><span style="color: #999966; font-size: 72px;">EmVi</span></strong></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><span style="font-size: large; color: #999966;">&nbsp;</span></p>
</div>
<p><img style="float: left; height: 189px; opacity: 0.9; width: 390px;" src="http://www.cs.odu.edu/~411orang/img/email-marketing.png" alt="" /></p>

<p>&nbsp;</p>
<p><span style="color: #999966;"><span style="font-size: 36px;"><strong>Hello '.$_POST['userFirstName'].',</strong></span></span></p>
<p><span style="color: #999966;"><span style="font-size: 28px;"><strong>Welcome to EmVi and thank you for registering for our services!! We know that you will not be dissappointed with your decision to utilize EmVi for all of your campaign creation needs.</strong>&nbsp;</span></span><strong><span style="font-size: 28px;"><span style="color: #999966;">Once you receive your activation email you can login to your account anytime by going to&nbsp;</span><a href="'.$siteUrl.'"><span style="color: #999966;">'.$siteUrl.'</span></a><span style="color: #999966;">.&nbsp;</span></span></strong></p>
<p><span style="color: #999966; font-size: x-large;">&nbsp;</span></p>
<p><span style="font-size: xx-large;"><strong><span style="color: #999966;">Sincerely,</span></strong></span></p>
<p><span style="font-size: xx-large;"><strong><span style="color: #999966;">EmVi Team</span></strong></span></p>
<p><span style="color: #999966; font-size: x-large;"><strong>&nbsp;</strong></span></p>
<div style="background: #eee; border: 1px solid #ccc; padding: 5px 10px;">
<p style="text-align: right;"><strong><em>&nbsp;Create Flawless Campaigns with EmVi</em></strong></p>
</div>
</body>
</html>

';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$_POST['userFirstName'].' <'.$_POST['userEMailAddress'].'>' . "\r\n";
$headers .= 'From: EmVi Administratorr <Admin@EmVi.com>' . "\r\n";

//$headers .= 'Cc: dssmwise@gmail.com' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);

 	
 	/* $to = $_POST['userEMailAddress'];
 	$subject = "EmVi Registration";
 	$txt = "Thank you! \n\nYou have successfully requested access to the EMVI tool.\n\n\n\n Your username is ".mysql_real_escape_string($_POST['userEMailAddress'])." . \n";
 	$txt =	$txt.  "You will receive another email once your account has been approved.";
 
 	$txt = $txt. "If you experiance problems logging into the site or have questions about your account please contact\n\n".$admin['userFirstName']." ".$admin['userLastName']."\n".$admin['userEMailAddress']."\n".$admin['userPhoneNumber'].".";
 	$headers = "From: Admin@emvious.com";
 
	mail($to,$subject,$txt,$headers);

*/ 	
 	unset($_POST['userFirstName']);
 	unset($_POST['userLastName']);
 	unset($_POST['userEMailAddress']);
 	unset($_POST['userPhoneNumber']);
 	}
 	
 	
 	
 

	
		
	
?>
<p style="font-size: 16px">
<?php
include 'pages/user/messageclass.php';
$inform = new message();
$max = sizeof($msgID);
 for ($i=0; $i<$max; $i++) {
  	if ($msgID[$i] > 100){ 
    echo "(Message ".$msgID[$i]."): ";
    $inform->printMessage($msgID[$i]);
 
	echo "<br /><br />";
	}
 }
	
			
			
?>
</p>
<?php			

 } 
 
 ?>

 
			
			<h1>Registration Page</h1>

 <form action="../<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
 <table border="0">
 	<tbody class="auto-style1">
<tr><td>First Name:*</td><td>
	<input type="text" name="userFirstName" maxlength="60" value="<?php echo $_POST['userFirstName']; ?>">
	</td></tr>
<tr><td>Last Name:*</td><td>
 <input type="text" name="userLastName" maxlength="60" value="<?php echo $_POST['userLastName']; ?>">
 </td></tr>
<tr><td>Email Address:*</td><td>
 <input type="text" name="userEMailAddress" maxlength="60" value="<?php echo $_POST['userEMailAddress']; ?>">
 </td></tr>
<tr><td>Phone Number:</td><td>
 <input type="text" name="userPhoneNumber" maxlength="60" value="<?php echo $_POST['userPhoneNumber']; ?>">
 </td></tr>
 <tr><td>Password:*</td><td>
 <input type="password" name="pass" maxlength="20">
 </td></tr>
 <tr><td>Confirm Password:*</td><td>
 <input type="password" name="pass2" maxlength="20">
 </td></tr>
 <input name="enabled" type="hidden" value="0"/>
 <tr><th colspan=2><input type="submit" name="submit" value="Register"></th></tr> </table>
 </form>
<a href="panels/registrationHelp.php">Registration Help</a>

        </div> 	    
	</div>
       
    
	<footer>
		<?php 
		echo $siteFooter; 
		triggerEvent("siteFooter");
		?>
    </footer>
    <?php triggerEvent("wrapperEnd");?>

<div id="catchScroll"></div>
<?php if(isset($_SESSION['username']) && $_SESSION['username'] == $username){?>
	<div id="adminPanel">
	<ul id="adminHovered">
	<li><a href="" target="_blank" id="adminEditButton">Edit this page</a></li>
	<li><a href="admin/logout.php" id="logoutButton">Logout</a></li>
	</ul>
	<a href="admin/" id="adminText">Welcome admin</a>
	</div>
	<?php
}
if($device=='mobileOnDesktop'){
	?>
	<a id="mobileOnDesktop" href="mobile.php">Go to mobile site</a>
    <?php
}
?>
<?php triggerEvent("bodyEnd");?>
</body>
</html>


