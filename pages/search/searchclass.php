<?php


class Search
{
	
	
	/*this constructor profides a way create an instance of the currently logged on user*/
	function _construct() {
    	
		
	}
	
	/*withID($id) provides a way to create an instance of another user of the system if you have 
	the userID*/
	public function find($type, $field, $word ) {
    	include("../../config/DB_Connect.php");
		

		$query = mysql_query("SELECT * FROM ".$type." WHERE ".$field." = '".$word."'");
		if (!$query) {    
				die("Query to show fields from table failed userclass.php Line 58");
		}
		//$found = mysql_fetch_assoc($query);
		
		if (mysql_num_rows($query) < 1){
			echo "There is no content in the system that matches your search.";
			echo "</br></br>";
			echo "You searched ".$field." for ".$word;
			
		}else{
		$this->printTable($query);
		}
    	
    }
	
	
    public function printTable($f,$type,$field,$word) {
    
    
    
    	/*echo "<table>";
    		while ($found = mysql_fetch_assoc($f)){
    		echo "<tr>";
    			echo "<td>".$found['contentID']."</td>";
    			echo "<td>".$found['contentName']."</td>";
				echo "<td>".$found['contentDescription']."</td>";
				echo "<td>".$found['contentType']."</td>";
				echo "<td>".$found['createdDate']."</td>";
				echo "<td>".$found['updatedDate']."</td>";
    		echo "</tr>";
    		}
    	echo "</table>";
*/    	
    	session_start();
$uid = $_SESSION['ID'];

    	
  




// Function returns the following beginning in row 1:
// ID, Name, Description, Keywords, TypeID, Format, CreatedDate, CreatedByID, CreatedByName, 
// UpdatedDate, UpdatedByID, UpdatedByName, OwnedByID, OwnedByName, FileName

$contentList = '';
for ($i = 1; $i < count($f); ++$i) {
		$contentList .= '<tr><td>'. htmlentities($f[$i]['Name']) . '</td>
		<td>' . htmlentities($f[$i]['Format']) . '</td>
		<td>' . htmlentities($f[$i]['Description']) . '</td>
		<td>' . htmlentities($f[$i]['Keywords']) . '</td>
		<td>' . date("m/d/Y g:i a", strtotime($f[$i]['UpdatedDate'])) . '</td>
		<td>' . htmlentities($f[$i]['OwnedByName']) . '</td>
		<td>';
	if ($f[$i]['FileName'] != '') {
		$contentList .= '<a href="content/upload/'. $f[$i]['FileName'] .'" target="_blank">View</a>';
	}
	$contentList .=	'</td><td>';
	if ($f[$i]['OwnedByID'] == $uid) {
		if ($type == 'tbl_email'){
			$contentList .= '<a href="panels/email/editemail.php?ID='.$f[$i]['ID'].'">Edit</a>';
		}else if($type == 'tbl_content'){
			$contentList .= '<a href="panels/content/editcontent.php?ID='.$f[$i]['ID'].'">Edit</a>';
		}else if($type == 'tbl_campaign'){
			$contentList .= '<a href="panels/campaigns/editcampaign.php?ID='.$f[$i]['ID'].'">Edit</a>';
		}
		
	}
	$contentList .= '</td>	
		<td>Clone</td>
		<td>';
	if ($f[$i]['OwnedByID'] == $uid) {
		$contentList .= 'Delete';
	}	
	$contentList .= '</td>
		</tr>';
}



    	//DISPLAY THE CONFERENCE REGISTRANTS
echo '<table width = "100%" cellpadding="3" cellspacing="1" border="1">';
echo '<tr>';
if (strtolower($orderby) == 'name' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=Name&dir=desc" style="text-decoration:none;">Content Name</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=Name&dir=asc" style="text-decoration:none;">Content Name</td>';
}
if (strtolower($orderby) == 'format' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=Format&dir=desc" style="text-decoration:none;">Format</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=Format&dir=asc" style="text-decoration:none;">Format</td>';
}
if (strtolower($orderby) == 'description' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=Description&dir=desc" style="text-decoration:none;">Description</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=Description&dir=asc" style="text-decoration:none;">Description</td>';
}
if (strtolower($orderby) == 'keywords' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=Keywords&dir=desc" style="text-decoration:none;">Keywords</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=Keywords&dir=asc" style="text-decoration:none;">Keywords</td>';
}
if (strtolower($orderby) == 'updatedate' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=UpdatedDate&dir=desc" style="text-decoration:none;">Last Updated</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=UpdatedDate&dir=asc" style="text-decoration:none;">Last Updated</td>';
}
if (strtolower($orderby) == 'ownedby' && strtolower($dir) == 'asc') {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=OwnedByName&dir=desc" style="text-decoration:none;">Locked By</td>';
} else {
	echo '<td style="min-width:100px;font-weight:bold;"><a href="member.php#!/search/searchcontent.php?Type='.$type.'&Field='.$field.'&Value='.$word.'&orderBy=OwnedByName&dir=asc" style="text-decoration:none;">Locked By</td>';
}
echo '<td style="min-width:50px;font-weight:bold"></td>';
echo '<td style="min-width:50px;font-weight:bold"></td>';
echo '<td style="min-width:50px;font-weight:bold"></td>';
echo '<td style="min-width:50px;font-weight:bold"></td>';
echo '</tr>';
echo $contentList;
echo '</table>';

    	
    	
    
    
    }
	public function get_content($type,$field,$word,$sort,$dir)
 	{
 	include("../../config/DB_Connect.php");
 	
 	if($sort == NULL) {
	$orderby = 'ID';
	$dir = 'ASC';
}
else {
	$orderby = $sort;
	$dir = $dir;
}


 		// Returns a 3-D array with the following:
 		// ID, Name, Description, Keywords, TypeID, Format, CreatedDate, CreatedByID, CreatedByName, 
 		// UpdatedDate, UpdatedByID, UpdatedByName, OwnedByID, OwnedByName, FileName
 		
 		if ($type == tbl_content){
	 		$sql = "SELECT contentID as 'ID', contentName as 'Name', contentDescription as 'Description', contentKeywords as 'Keywords', contentType as 'TypeID', t5.typeFormat as 'Format', createdDate as 'CreatedDate', createdBy as 'CreatedByID', concat(t2.userFirstName, ' ', t2.userLastName) as 'CreatedByName', updatedDate as 'UpdatedDate', updatedBy as 'UpdatedByID', concat(t3.userFirstName, ' ', t3.userLastName) as 'UpdatedByName', fileLocation as 'FileName', canEdit as 'OwnedByID', concat(t4.userFirstName, ' ', t4.userLastName) as 'OwnedByName',
fileLocation as 'FileName' FROM tbl_content as t1 LEFT JOIN tbl_user as t2 on t1.createdBy = t2.userID LEFT JOIN tbl_user as t3 on t1.updatedBy = t3.userID LEFT JOIN tbl_user as t4 on t1.canEdit = t4.userID LEFT JOIN tbl_contentTypes as t5 on t1.contentType = t5.typeFormat";
			
	 		//$sql .= "";
	 		
	 		$sql .= " ORDER BY $orderby $dir";
	 		
 		}	 	 
		//echo $sql;
 		$arr = array();
 		$result = mysql_query($sql)
		 		or die("Could not connect: " . mysql_error());

 		for ($i = 0; $i < mysql_num_fields($result); ++$i) {
 			$arr[0][$i] = mysql_field_name($result,$i);
 		}
 		
		$i = 1;
		while($row=mysql_fetch_array($result)){
			if (strpos(strtolower($row[$field]),strtolower($word)) !== false) {
			

 			for ($j = 0; $j < mysql_num_fields($result); ++$j) {
 					
	 				$arr[$i][mysql_field_name($result,$j)] = $row[mysql_field_name($result,$j)];
					}
				++$i;
				}
			
		}
		//print_r($arr);
		echo "You searched for ".$field." with the value of ".$word.".";
		$this->printTable($arr,$type,$field,$word);
		

		return $arr;

 	}
 	
 	

public function get_email($type,$field,$word,$sort,$dir)
 	{
 	
 	include("../../config/DB_Connect.php");
 	
 	if($sort == NULL) {
		$orderby = 'ID';
		$dir = 'ASC';
	}else {
		$orderby = $sort;
		$dir = $dir;
	}
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
		
 		$sql .= " ORDER BY $orderby $dir";		 	 

 		$arr = array();
 		$result = mysql_query($sql)
		 		or die("Could not connect: " . mysql_error());

 		for ($i = 0; $i < mysql_num_fields($result); ++$i) {
 			$arr[0][$i] = mysql_field_name($result,$i);
 		}
 		
		$i = 1;
		while($row=mysql_fetch_array($result)){
			if (strpos(strtolower($row[$field]),strtolower($word)) !== false) {
			

 			for ($j = 0; $j < mysql_num_fields($result); ++$j) {
 					
	 				$arr[$i][mysql_field_name($result,$j)] = $row[mysql_field_name($result,$j)];
					}
				++$i;
				}
			
		}
		
		echo "You searched for ".$field." with the value of ".$word.".";
		$this->printTable($arr,$type,$field,$word);
		

		return $arr;

 	}
	
 	
 	public function get_campaign($type,$field,$word,$sort,$dir)
 	{
 		// Returns a 3-D array with the following:
 		// ID, Name, Description, Keywords, TypeID, Format, CreatedDate, CreatedByID, CreatedByName, 
 		// UpdatedDate, UpdatedByID, UpdatedByName, OwnedByID, OwnedByName, FileName
 		include("../../config/DB_Connect.php");
 	
 	if($sort == NULL) {
		$orderby = 'ID';
		$dir = 'ASC';
	}else {
		$orderby = $sort;
		$dir = $dir;
	}

 		
 		$sql = "SELECT campaignID as 'ID', campaignName as 'Name', campaignDescription as 'Description', campaignKeywords as 'Keywords', campaignStatus as 'StatusID', t3.wfStatusName as 'Status', 
				CreatedDate as 'CreatedDate', launchDate as 'LaunchDate', createdBy as 'CreatedByID', concat(t2.userFirstName, ' ', t2.userLastName) as 'CreatedByName', canEdit
				FROM tbl_campaigns as t1
				LEFT JOIN tbl_user as t2 on t1.createdBy= t2.userID
				LEFT JOIN tbl_wfStatus as t3 on t1.campaignStatus = t3.wfStatusID ";
		
 		$sql .= "ORDER BY $orderby $dir";		 	 

 		$arr = array();
 		$result = mysql_query($sql)
		 		or die("Could not connect: " . mysql_error());

 		for ($i = 0; $i < mysql_num_fields($result); ++$i) {
 			$arr[0][$i] = mysql_field_name($result,$i);
 		}
 		
		$i = 1;
		while($row=mysql_fetch_array($result)){
			if (strpos(strtolower($row[$field]),strtolower($word)) !== false) {
			

 			for ($j = 0; $j < mysql_num_fields($result); ++$j) {
 					
	 				$arr[$i][mysql_field_name($result,$j)] = $row[mysql_field_name($result,$j)];
					}
				++$i;
				}
			
		}
		
		echo "You searched for ".$field." with the value of ".$word.".";
		$this->printTable($arr,$type,$field,$word);
		

		return $arr;

 	}



	
	


}

?>
