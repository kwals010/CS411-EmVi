<?php


class Message
{

	public $text = ""; //used to hold the objects message
	public $code = ""; //used to hold the objects message code

	function _construct() {
		$text = "no message retrieved";
		$code = 0;
	}

	function getMessage($number){
		include("../../config/DB_Connect.php");
		$query = mysql_query("SELECT * FROM tbl_messages WHERE msgCode = ".$number."");
		if (!$query) {    
				die("Query to show fields from table failed Messageclass.php Line 17");
		}
		$row = mysql_fetch_assoc($query);
		$this->code = $number;
		$this->text = $row['msgText'];
		

	}
	
	public function printMessage($number){
	
		$this->getMessage($number);
		echo $this->text;
	}

}

?>
