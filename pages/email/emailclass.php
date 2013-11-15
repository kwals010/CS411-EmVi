<?php
//include_once '../content/include/config.php';
class Email {
	
	public $emailID;
	public $emailName;
	public $emailDescription;
	public $emailKeywords;
	public $emailHTML;
	public $emailText;
	public $emailSubject;
	public $emailFromName;
	public $emailFromAddress;
	
	//Database connect

	public function __construct() {
		$db = new DB_Class();
		
	}

 	// Returns an array of content
public function get_email($sort,$dir)
 	{
 		// Returns a 3-D array with the following:
 		// ID, Name, Description, Keywords, HTMLContentID, TextContentID, Subject, FromName, FromAddress,
 		// CreatedDate, CreatedByID, CreatedByName, UpdatedDate, UpdatedByID, UpdatedByName, OwnedByID, OwnedByName
 		
 		$sql = "SELECT emailID as 'ID', emailName as 'Name', emailDescription as 'Description', emailKeywords as 'Keywords', 
 				emailHTML as 'HTMLContentID', emailText as 'TextContentID', emailSubject as 'Subject', emailFromName as 'FromName', 
 				emailFromAddress as 'FromAddress', createdDate as 'CreatedDate', createdBy as 'CreatedByID', 
 				concat(t2.userFirstName, ' ', t2.userLastName) as 'CreatedByName', updatedDate as 'UpdatedDate', 
				updatedBy as 'UpdatedByID', concat(t3.userFirstName, ' ', t3.userLastName) as 'UpdatedByName', 
 				canEdit as 'OwnedByID', concat(t4.userFirstName, ' ', t4.userLastName) as 'OwnedByName' 
				FROM tbl_email as t1
				LEFT JOIN tbl_user as t2 on t1.createdBy = t2.userID
				LEFT JOIN tbl_user as t3 on t1.updatedBy = t3.userID
				LEFT JOIN tbl_user as t4 on t1.canEdit = t4.userID ";
		
 		$sql .= "ORDER BY $sort $dir";		 	 

 		$arr = array();
 		$result = mysql_query($sql)
		 		or die("Could not connect: " . mysql_error());

 		for ($i = 0; $i < mysql_num_fields($result); ++$i) {
 			$arr[0][$i] = mysql_field_name($result,$i);
 		}
 		
		$i = 1;
		while($row=mysql_fetch_array($result)){
 			for ($j = 0; $j < mysql_num_fields($result); ++$j) {
	 				$arr[$i][mysql_field_name($result,$j)] = $row[mysql_field_name($result,$j)];
				}
			++$i;
		}
		return $arr;

 	}
 	
 	public function add_email($uid,$name,$desc,$kw,$fname,$subj,$faddress,$txt,$html) 
 	{
 		
 		$sql = "INSERT INTO `tbl_email`
 			    (emailName, emailDescription, emailKeywords, emailHTML, emailText, emailSubject, emailFromName, emailFromAddress, createdDate, createdBy, updatedDate, updatedBy, canEdit)
				 VALUES ('$name','$desc','$kw','$html','$txt','$subj','$fname','$faddress',NOW(),'$uid',NOW(),'$uid','$uid')";
		mysql_query($sql) 
			OR die(mysql_error());
		
		
 	}
 	
 	public function get_emailByID($id)
 	{
 			
 		$sql = "SELECT *
 				FROM tbl_email
 				WHERE emailID = $id";
 		
 		$result = mysql_query($sql)
 			or die("Could not connect: " . mysql_error());
 			
 		$arr = array();
 		while($row=mysql_fetch_assoc($result)){
 			foreach ($row as $key=>$value) {
 				$arr[$key] = $value;
 				//echo $key ."=>".$value."<br>";
 			}
 		}
 		return $arr;
 	}
 
	
}
?>