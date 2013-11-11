<?php
session_start();
error_reporting(0);

function usercheck(){
	
	if ($_SESSION['loggedout'] == 'yes') {
		include_once 'general.php'; 
		header('Location: '.$siteUrl.''); 
	    
	} 
	if (isset($_GET["error"]))
		$error = $_GET["error"];

	//checks cookies to make sure they are logged in 
	$FName = '';
 	$LName = '';
 	$PhNum = '';
 	$EMail = '';
 
 	if(isset($_SESSION['ID'])) { 
	 	$UID = $_SESSION['ID']; 
 		$pass = $_SESSION['Key_my_site']; 
 	 	$check = mysql_query("SELECT * FROM tbl_user WHERE userID = '$UID'")or die(mysql_error()); 
 	 		
 		while($info = mysql_fetch_array( $check )) { 
 			foreach ($info as $cell){
 				if ($cell == $info ['FName']) $FName = $cell;
 				if ($cell == $info ['LName']) $LName = $cell;
				if ($cell == $info ['PhNum']) $PhNum = $cell;
				if ($cell == $info ['EMail']) $EMail= $cell;
				//if ($pass != $info['pass']) { 	
					//header("Location: index.php"); 
 				//}//otherwise they are shown the Member area	 
 				//else { 
 			
 				//} 
 			}
 			//if the cookie has the wrong password, they are taken to the login page 
 		} 
 	} else 
 	//if the cookie does not exist, they are taken to the login screen 
 	{			 
 		include_once 'general.php';
 		header('Location: '.$siteUrl.''); 
 	} 

}

function sanitizeText($text){
	$text= str_replace("<", "&lt;", $text);
	$text= str_replace(">", "&gt;", $text);
	$text= str_replace("\"", "&quot;", $text);
	$text= str_replace("'", "&#039;", $text);
	$text = addslashes($text);
	return $text;
}
function unsanitizeTest($text){
	$text = stripcslashes($text);
	$text= str_replace("&lt;", "<", $text);
	$text= str_replace("&gt;", ">", $text);
	$text= str_replace("&quot;", "\"", $text);
	$text= str_replace("&#039;", "'", $text);
	
	return $text;

}
function sanitizeNum($Num){
	$Num= str_replace("<", "", $Num);
	$Num= str_replace(">", "", $Num);
	$Num= str_replace("\"", "", $Num);
	$Num= str_replace("'", "", $Num);
	return $Num;
}

function check_password($str){
		include_once 'DB_Connect.php';
		$passLength = mysql_query("SELECT * FROM `tbl_siteConfig` WHERE `configObject` = 'passLength' and `configEnable`= '1'")
		or die(mysql_error());
		$passComplex = mysql_query("SELECT * FROM `tbl_siteConfig` WHERE `configObject` = 'passReq' and `configEnable`= '1'")
		or die(mysql_error());

		
		$passLength = mysql_fetch_assoc($passLength);
		$passComplex = mysql_fetch_assoc($passComplex);
		
		//return eval($pverify['configBlockCode']);	
		$regexs = array(
	                 '/[0-9]+/',  // Numbers
	                 '/[a-z]+/',  // Lower Case Letters
	                 '/[A-Z]+/',  // Upper Case Letters
	                 '/[!@#$%^&*()-+=,.<>?]+/',  // Your list of allowable symbols.
	   	);
			
		$matchCount = 0;
		
		if (strlen($str) >= $passLength['configBlockCode']){
			$matchCount++;

			/*return false;
		}else{
			$matchCount++;
*/			
		}
	
		for ($i = 0; $i < sizeof($regexs); $i++) {
	
	   		if (preg_match ($regexs[$i], $str)){
	   		 	$matchCount++;
	        		
	    	}
	    }
		
		if ($matchCount < $passComplex['configBlockCode']){
			return false;
		}else{
			return true;
		}
	} 


function check_email_address($email) {
	  // First, we check that there's one @ symbol, 
	  // and that the lengths are right.
	  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
	    // Email invalid because wrong number of characters 
	    // in one section or wrong number of @ symbols.
	    return false;
	  }
	  // Split it into sections to make life easier
	  $email_array = explode("@", $email);
	  $local_array = explode(".", $email_array[0]);
	  for ($i = 0; $i < sizeof($local_array); $i++) {
	    if
	(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
	?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
	$local_array[$i])) {
	      return false;
	    }
	  }
	  // Check if domain is IP. If not, 
	  // it should be valid domain name
	  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
	    $domain_array = explode(".", $email_array[1]);
	    if (sizeof($domain_array) < 2) {
	        return false; // Not enough parts to domain
	    }
	    for ($i = 0; $i < sizeof($domain_array); $i++) {
	      if
	(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
	?([A-Za-z0-9]+))$",
	$domain_array[$i])) {
	        return false;
	      }
	    }
	  }
	  return true;
	}


    /**
    *
    * @Create dropdown of years
    *
    * @param int $start_year
    *
    * @param int $end_year
    *
    * @param string $id The name and id of the select object
    *
    * @param int $selected
    *
    * @return string
    *
    */
    function createYears($start_year, $end_year, $id='year_select', $selected=null)
    {

        /*** the current year ***/
        $selected = is_null($selected) ? date('Y') : $selected;

        /*** range of years ***/
        $r = range($start_year, $end_year);

        /*** create the select ***/
        $select = '<select name="'.$id.'" id="'.$id.'">';
        foreach( $r as $year )
        {
            $select .= "<option value=\"$year\"";
            $select .= ($year==$selected) ? ' selected="selected"' : '';
            $select .= ">$year</option>\n";
        }
        $select .= '</select>';
        return $select;
    }

    /*
    *
    * @Create dropdown list of months
    *
    * @param string $id The name and id of the select object
    *
    * @param int $selected
    *
    * @return string
    *
    */
    function createMonths($id='month_select', $selected=null)
    {
        /*** array of months ***/
        $months = array(
                1=>'January',
                2=>'February',
                3=>'March',
                4=>'April',
                5=>'May',
                6=>'June',
                7=>'July',
                8=>'August',
                9=>'September',
                10=>'October',
                11=>'November',
                12=>'December');

        /*** current month ***/
        $selected = is_null($selected) ? date('m') : $selected;

        $select = '<select name="'.$id.'" id="'.$id.'">'."\n";
        foreach($months as $key=>$mon)
        {
            $select .= "<option value=\"$key\"";
            $select .= ($key==$selected) ? ' selected="selected"' : '';
            $select .= ">$mon</option>\n";
        }
        $select .= '</select>';
        return $select;
    }


    /**
    *
    * @Create dropdown list of days
    *
    * @param string $id The name and id of the select object
    *
    * @param int $selected
    *
    * @return string
    *
    */
    function createDays($id='day_select', $selected=null)
    {
        /*** range of days ***/
        $r = range(1, 31);

        /*** current day ***/
        $selected = is_null($selected) ? date('d') : $selected;

        $select = "<select name=\"$id\" id=\"$id\">\n";
        foreach ($r as $day)
        {
            $select .= "<option value=\"$day\"";
            $select .= ($day==$selected) ? ' selected="selected"' : '';
            $select .= ">$day</option>\n";
        }
        $select .= '</select>';
        return $select;
    }


    /**
    *
    * @create dropdown list of hours
    *
    * @param string $id The name and id of the select object
    *
    * @param int $selected
    *
    * @return string
    *
    */
    function createHours($id='hours_select', $selected=null)
    {
        /*** range of hours ***/
        $r = range(1, 12);

        /*** current hour ***/
        $selected = is_null($selected) ? date('h') : $selected;

        $select = "<select name=\"$id\" id=\"$id\">\n";
        foreach ($r as $hour)
        {
            $select .= "<option value=\"$hour\"";
            $select .= ($hour==$selected) ? ' selected="selected"' : '';
            $select .= ">$hour</option>\n";
        }
        $select .= '</select>';
        return $select;
    }

    /**
    *
    * @create dropdown list of minutes
    *
    * @param string $id The name and id of the select object
    *
    * @param int $selected
    *
    * @return string
    *
    */
    function createMinutes($id='minute_select', $selected=null)
    {
        /*** array of mins ***/
        $minutes = array(0, 15, 30, 45);

    $selected = in_array($selected, $minutes) ? $selected : 0;

        $select = "<select name=\"$id\" id=\"$id\">\n";
        foreach($minutes as $min)
        {
            $select .= "<option value=\"$min\"";
            $select .= ($min==$selected) ? ' selected="selected"' : '';
            $select .= ">".str_pad($min, 2, '0')."</option>\n";
        }
        $select .= '</select>';
        return $select;
    }

    /**
    *
    * @create a dropdown list of AM or PM
    *
    * @param string $id The name and id of the select object
    *
    * @param string $selected
    *
    * @return string
    *
    */
    function createAmPm($id='select_ampm', $selected=null)
    {
        $r = array('AM', 'PM');

    /*** set the select minute ***/
        $selected = is_null($selected) ? date('A') : strtoupper($selected);

        $select = "<select name=\"$id\" id=\"$id\">\n";
        foreach($r as $ampm)
        {
            $select .= "<option value=\"$t\"";
            $select .= ($ampm==$selected) ? ' selected="selected"' : '';
            $select .= ">$ampm</option>\n";
        }
        $select .= '</select>';
        return $select;
    }

?>