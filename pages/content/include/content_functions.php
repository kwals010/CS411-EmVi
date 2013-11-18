<?php
include_once 'config.php';
class Content
{
	//Database connect
	public function __construct()
	{
		$db = new DB_Class();
	}
	// Returns an array of file types: typeID and typeName
	public function get_content_types()
	{
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
 	// Returns an array of content
 	public function get_content()
 	{
 		$arr = array();
 		$result = mysql_query("SELECT tbl_content.contentID as 'ID', tbl_content.contentName as 'Name', tbl_content.contentDescription as 'Description',
 				tbl_content.contentKeywords as 'Keywords', CONCAT(tbl_user.userFirstName, ' ', tbl_user.userLastName) as 'Created By',
 				tbl_contentTypes.typeName as 'Type', tbl_content.createdDate as 'Created Date',
 				tbl_content.fileLocation as 'File Location' FROM tbl_content
				LEFT JOIN tbl_user ON tbl_content.createdBy = tbl_user.userID 
				LEFT JOIN tbl_contentTypes ON tbl_content.contentType = tbl_contentTypes.typeID
 				LEFT JOIN tbl_contentToCDN ON tbl_content.contentID = tbl_contentToCDN.cdnID")
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
 	// Returns an array of content ID to CDN ID mappings
 	public function get_contentToCDN()
 	{
 		$arr = array();
 		$result = mysql_query("SELECT * FROM tbl_contentToCDN")
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

	
}
?>