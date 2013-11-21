<?php
//include_once 'include/config.php';
class Content {
	
	public $contentID;  			// assigned at create
	public $contentName;		// name given to content
	public $contentDescription;		// description given to content
	public $contentKeywords;				// comma delimited list
	public $contentType;		// file type
	public $fileLocation;			// name of stored file
	
	//Database connect

	public function __construct() {
		$db = new DB_Class();

		
	}
	// Returns an array of file types: typeID and typeName
	public function get_content_types() {
		$arr = array();
		$result = mysql_query("SELECT * FROM tbl_contentTypes")
				or die("Could not connect: " . mysql_error());
		
		for ($i = 0; $i < mysql_num_fields($result); ++$i) {
 			$arr[0][$i] = mysql_field_name($result,$i);
 		}
 		
		$i = 1;
		while($row=mysql_fetch_array($result)){
			$j = 0;
			for ($j = 0; $j < mysql_num_fields($result); ++$j) {
				$arr[$i][mysql_field_name($result,$j)] = $row[mysql_field_name($result,$j)];
				}
			++$i;
		}
		return $arr;
 	}
 	
public function get_contentTypeByID($id) {
	
	$result = mysql_query("SELECT * FROM tbl_contentTypes where typeID = $id")
		or die("Could not connect: " . mysql_error());
	
	while($row=mysql_fetch_array($result)){
		return $row['typeFormat'];
	}
}	
public function get_contentIDByType($type) {

	//echo "fetching ID with type $type <br>";
	$result = mysql_query("SELECT * FROM tbl_contentTypes where typeFormat = '$type'")
	or die("get_contentIDByType failed: " . mysql_error());
	
	while($row=mysql_fetch_array($result)) {
		return $row['typeID'];
	}
	
	}

 	// Returns an array of content
public function get_content($sort,$dir)
 	{
 		// Returns a 3-D array with the following:
 		// ID, Name, Description, Keywords, TypeID, Format, CreatedDate, CreatedByID, CreatedByName, 
 		// UpdatedDate, UpdatedByID, UpdatedByName, OwnedByID, OwnedByName, FileName
 		
 		
 		$sql = "SELECT contentID as 'ID', contentName as 'Name', contentDescription as 'Description', contentKeywords as 'Keywords', contentType as 'TypeID', t5.typeFormat as 'Format', 
				createdDate as 'CreatedDate', createdBy as 'CreatedByID', concat(t2.userFirstName, ' ', t2.userLastName) as 'CreatedByName', updatedDate as 'UpdatedDate', 
				updatedBy as 'UpdatedByID', concat(t3.userFirstName, ' ', t3.userLastName) as 'UpdatedByName', fileLocation as 'FileName', canEdit as 'OwnedByID', concat(t4.userFirstName, ' ', t4.userLastName) as 'OwnedByName',
 				fileLocation as 'FileName', cdnID 
				FROM tbl_content as t1
				LEFT JOIN tbl_user as t2 on t1.createdBy = t2.userID
				LEFT JOIN tbl_user as t3 on t1.updatedBy = t3.userID
				LEFT JOIN tbl_user as t4 on t1.canEdit = t4.userID
				LEFT JOIN tbl_contentTypes as t5 on t1.contentType = t5.typeID ";
		
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
 	
 	public function get_contentByID($id)
 	{
 		
 		$sql = "SELECT * 
 				FROM tbl_content
 				WHERE contentID = $id";
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
 	
 	// Returns an array of content ID to Campaign ID mapping
 	public function get_contentToCampaigns()
 	{
 		$arr = array();
 		$result = mysql_query("SELECT * FROM tbl_contentToCampaigns")
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
 	// Returns an array of CDN values
 	public function get_CDN()
 	{
 		$arr = array();
 		$result = mysql_query("SELECT * FROM tbl_CDN")
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

 	public function add_content($uid,$name,$desc,$kw,$type,$loc)
 	{

 		$sql = "INSERT INTO `tbl_content`
 		(contentName, contentDescription, contentKeywords, contentType, createdDate, createdBy, updatedDate, updatedBy, fileLocation, canEdit)
 		VALUES ('$name','$desc','$kw','$type',NOW(),'$uid',NOW(),'$uid','$loc','$uid')";

		mysql_query($sql) 
			OR die(mysql_error());
	}

 	public function update_content($uid,$cid,$name,$desc,$kw,$type)
 	{
 		$sql = "UPDATE `tbl_content`
 				SET 
 				contentName = '$name',
 				contentDescription = '$desc', 
 				contentKeywords = '$kw',
 				contentType = '$type',
 				updatedDate = NOW(),
 				updatedBy = '$uid'		
 				WHERE contentID = '$cid'";
 				
 		mysql_query($sql)
 			OR die(mysql_error());
 	}
 	
 	public function delete_content($cid)
 	{
 		$sql = "DELETE FROM `tbl_content`
 				WHERE contentID = '$cid'";
 		
 		mysql_query($sql)
 		OR die(mysql_error());
 		
 	}
 	
 	public function add_toCDN($cid, $uid, $loc)
 	{

 		$sql = "INSERT INTO `tbl_CDN`
 				(contentID, publishedBy, publishedDate, url)
 				VALUES ('$cid', '$uid', NOW(),'$loc')";
 		
 		mysql_query($sql)
 		OR die(mysql_error());
 		
 	}
 	
 	public function remove_fromCDN($cid)
 	{
 		$sql = "DELETE FROM `tbl_CDN`
 				WHERE contentID = '$cid'";
 			
 		mysql_query($sql)
 		OR die(mysql_error());
 	}
 	
 	public function get_CDNByContentID($cid)
 	{
 		$result = mysql_query("SELECT *
 				FROM `tbl_CDN`
 				WHERE contentID = '$cid'")
 		
 		or die("Could not connect: " . mysql_error());
 		
 		return mysql_fetch_array($result);

 	}
 	
 	public function lock_content($cid,$uid)
 	{
 		// This function updates the canEdit field. The field will contain either a user id or null if it is assigned to
 		// more than one email.
 		echo "Locking content " . $cid . "<br>";
 		$sql = "SELECT distinct count(emailID) as num
 				FROM `tbl_email`
 				WHERE emailHTML = '$cid'";
 		$data = mysql_query($sql)
 			OR die(mysql_error());
 		$row = mysql_fetch_assoc($data);
 		$count = $row['num'];
 		echo "html count is $count<br>";
 		
 		$count_text = "SELECT distinct count(emailID) as num
 				FROM `tbl_email`
 				WHERE emailText = '$cid'";
 		
 		$data = mysql_query($sql)
 			OR die(mysql_error());
 		$row = mysql_fetch_assoc($data);
 		$count += $row['num'];
 		echo "Total count is $count<br>";
 		
 		$sql = "UPDATE `tbl_content`
 				SET canEdit = ";
 		if ($count > 1) {
 			$sql .= 'null';
 		}
 		else {
 			$sql .= $uid;
 		}
 		$sql .= " WHERE contentID = '$cid'";
 		
 		mysql_query($sql)
 			OR die(mysql_error());
 			
 	}
 	
 	public function unlock_content($cid,$uid)
 	{
 	} 	
	
}
?>