<?php

$to = "dssmwise@gmail.com";
 $subject = "EMVI Registration";
 $txt = "Thank you! \n\nYou have successfully requested access to the EMVI tool.\n\n\n\n Your username is ".$userEMailAddress." . \n";
 $txt =	$txt.  "You can log at http://www.ubno.com/EMVI/ once your account is approved\n\n";
 
 $txt = $txt. "If you experiance problems logging into the site please contact\n\nDavid Wise\n540-663-4059\nDSSMWise@gmail.com.";
 $headers = "From: Administrator@emvi.com";
 
mail($to,$subject,$txt,$headers);




?>
