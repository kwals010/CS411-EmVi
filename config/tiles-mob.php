<?php
/*FOR MOBILE SITE */
/* All tiles on the homepage are configured here, be sure to check the tutorials/docs on http://metro-webdesign.info */

/* GROUP 0 */

$tile[] = array("type"=>"simple","group"=>0,"x"=>0,"y"=>0,'width'=>2,'height'=>1,"background"=>"#509601","url"=>"welcome.php",
"title"=>"Click me there is more!","text"=>"Welcome to EmVi! The home of the Marketing Email Viewer.");


/* GROUP 1*/

$tile[] = array("type"=>"slide","group"=>1,"x"=>0,"y"=>0,'width'=>2,'height'=>1,"background"=>"#333","url"=>"new_campaign.php",
	"text"=>"<h3>New Campaign</h3>","img"=>"img/New_Campaign.jpg","imgSize"=>1,
	"slidePercent"=>0.40,
	"slideDir"=>"left", // can be up, down, left or right
	"doSlideText"=>true,"doSlideLabel"=>true,
	"labelText"=>"New Campaign","labelColor"=>"#00BFFF","labelPosition"=>"top",
);

$tile[] = array("type"=>"slide","group"=>1,"x"=>0,"y"=>1,'width'=>2,'height'=>1,"background"=>"#333","url"=>"new_campaign.php",
	"text"=>"<h3>My Tasks</h3>","img"=>"img/New_Campaign.jpg","imgSize"=>1,
	"slidePercent"=>0.40,
	"slideDir"=>"left", // can be up, down, left or right
	"doSlideText"=>true,"doSlideLabel"=>true,
	"labelText"=>"My Tasks","labelColor"=>"#00BFFF","labelPosition"=>"top",
);

/* GROUP 2 */
$tile[] = array("type"=>"simple","group"=>2,"x"=>0,"y"=>0,'width'=>2,'height'=>1,"background"=>"#509601","url"=>"members.php",
"title"=>"Members","text"=>"This is the link to member area!.");


/* GROUP 3 */

include("DB_Connect.php");
session_start(); 

$query = mysql_query("SELECT * FROM tbl_user WHERE userID = '".$_SESSION['ID']."'");
	if (!$query) {    
		die("Query to show fields from table failed tiles-mob.php Line 39");
	}
$user = mysql_fetch_assoc($query);

if ($user['userRole'] == 1){
	
$tile[] = array("type"=>"simple","group"=>3,"x"=>0,"y"=>0,'width'=>2,'height'=>1,"background"=>"#509601","url"=>"admins.php",
"title"=>"Administration","text"=>"This is the link to Administration area!.");
}

/* GROUP 4 */
$tile[] = array("type"=>"img","group"=>4,"x"=>0,"y"=>0,'width'=>1,'height'=>1,"background"=>"#0F6D32","url"=>"help.php",
	"img"=>"img/img3.jpg","desc"=>"Click here for help!",
	"showDescAlways"=>true,"imgWidth"=>2,"imgHeight"=>1,
	"labelText"=>"Img Tile","labelColor"=>"#509601","labelPosition"=>"bottom", "classes"=>"noClick");
	
$tile[] = array("type"=>"slide","group"=>4,"x"=>1,"y"=>0,'width'=>2,'height'=>1,"background"=>"#FE2E64","url"=>"about.php",
	"text"=>"<h3>About EmVi</h3>","img"=>"img/metro_slide_300x150_2.png","imgSize"=>1,
	"slidePercent"=>0.50,
	"slideDir"=>"left", // can be up, down, left or right
	"doSlideText"=>false,"doSlideLabel"=>false,
	"labelText"=>"Other direction slide","labelColor"=>"#CC1A46","labelPosition"=>"top"
	
);

$tile[] = array("type"=>"simple","group"=>4,"x"=>1,"y"=>1,'width'=>1,'height'=>1,"background"=>"#509601","url"=>"",
"title"=>"Desktop","text"=>"Click here to go to the desktop version of this site","classes"=>"goToFull");


?> 