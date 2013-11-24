<?php

class Workflow {

	public function __construct() {
		$db = new DB_Class();
	}
	
	
	/*Get all open campaigns that are open and assigned to currently logged on user */
	public function get_myOpenWork($id){ 
	
		

		$query = mysql_query("SELECT `campaignID`, `campaignName`, `launchDate`, `wfStatusName`, `updatedDate`, `canEdit`, `userFirstName`, `userLastName`, `campaignDescription` FROM tbl_campaigns 
		left join tbl_user on updatedBy = userID 
		left join tbl_wfStatus on campaignStatus = wfStatusID 
		WHERE updatedBy = '".$id."'");
		if (!$query) {    
				die("Query to show fields from table failed workflow.php Line 19");
		}
		return $query;

		
 	}
 	
 	
	public function get_myOpenReviews($id){ 
		
		

		$query = mysql_query("SELECT * FROM `tbl_reviewers` t1
		left join tbl_user as t2 on `t1`.`reviewerID`=`t2`.`userID`
		left join tbl_campaigns as t3 on `t1`.`campaignID`= `t3`.`campaignID` WHERE reviewerID = '".$id."' and isComplete = 0 and canEdit = 0");
		if (!$query) {    
				die("Query to show fields from table failed workflow.php Line 36");
		}
		return $query;

		
 	}

	/*Get all open campaigns that are open for all users*/
	public function get_allOpenWork(){ 

 	}
 	
 	public function set_approved($campaign, $uid, $comment){
 	
 		//Set this reviewers responce to approved and complete.  Record comments.
 		$date = $date = date('Y-m-d H:i:s');
 		$sql = "UPDATE `tbl_reviewers` SET `isComplete`=1,`reviewResult`=1, reviewComments = '".$comment."', commentDate = '".$date."' WHERE `campaignID` = ".$campaign." and `reviewerID` = ".$uid."";
 		$res = mysql_query($sql) 
			OR die(mysql_error());
		
		//check to see if last reviewer.  If they are then the campaign is set back to edit mode for rejected and approved awaiting deploymnet mode for approved
		if ($this->set_isreviewComplete($campaign)){
			if($this->set_isreviewApproved($campaign)){
				//Set campaign status to approved
				$sql = "UPDATE `tbl_campaigns` SET `campaignStatus`= 4 ,`canEdit`= 0 WHERE `campaignID` = ".$campaign." ";
	
			 		$res = mysql_query($sql) 
						OR die(mysql_error());
					
					//copy comments from this revision to archive comments table
					$copyComment = "INSERT INTO `tbl_commentArchive` (`campaignID`, `reviewerID`,  `reviewResult`, `comment`, `commentDate`) SELECT `campaignID`, `reviewerID`, `reviewResult`, `reviewComments`, `CommentDate`  FROM `tbl_reviewers` WHERE `campaignID` = ".$campaign."";
						$copy = mysql_query($copyComment) 
							OR die(mysql_error());

			
				
			}else{
				//Set campaigh status to edit and canEdit = to updatedBy
				$sql = "UPDATE `tbl_campaigns` SET `campaignStatus`= 2 ,`canEdit`= `updatedBy` WHERE `campaignID` = ".$campaign." ";
	
			 		$res = mysql_query($sql) 
						OR die(mysql_error());

					//copy comments from this revision to archive comments table
					$copyComment = "INSERT INTO `tbl_commentArchive` (`campaignID`, `reviewerID`,  `reviewResult`, `comment`, `commentDate`) SELECT `campaignID`, `reviewerID`, `reviewResult`, `reviewComments`, `CommentDate`  FROM `tbl_reviewers` WHERE `campaignID` = ".$campaign."";
						$copy = mysql_query($copyComment) 
							OR die(mysql_error());

			}
		}

 	}
 	
	public function set_reject($campaign, $uid, $comment){

		$date = $date = date('Y-m-d H:i:s');
 		//Set this reviewers responce to rejected and complete and record any comments
 		$sql = "UPDATE `tbl_reviewers` SET `isComplete`=1,`reviewResult`=0, reviewComments = '".$comment."', commentDate = '".$date."' WHERE `campaignID` = ".$campaign." and `reviewerID` = ".$uid."";
 		$res = mysql_query($sql) 
			OR die(mysql_error());
			
		//check to see if last reviewer.  If they are then the campaign is set back to edit mode for rejected and approved awaiting deploymnet mode for approved
			if ($this->set_isreviewComplete($campaign)){
				if($this->set_isreviewApproved($campaign)){
					//Set campaign status to approved
					$sql = "UPDATE `tbl_campaigns` SET `campaignStatus`= 4 ,`canEdit`= 0 WHERE `campaignID` = ".$campaign." ";
 		
				 		$res = mysql_query($sql) 
							OR die(mysql_error());
					//copy comments from this revision to archive comments table
					$copyComment = "INSERT INTO `tbl_commentArchive` (`campaignID`, `reviewerID`,  `reviewResult`, `comment`, `commentDate`) SELECT `campaignID`, `reviewerID`, `reviewResult`, `reviewComments`, `CommentDate`  FROM `tbl_reviewers` WHERE `campaignID` = ".$campaign."";
						$copy = mysql_query($copyComment) 
							OR die(mysql_error());

					
				}else{
					//Set campaigh status to edit and canEdit = to updatedBy
					$sql = "UPDATE `tbl_campaigns` SET `campaignStatus`= 2 ,`canEdit`= `updatedBy` WHERE `campaignID` = ".$campaign." ";
 		
				 		$res = mysql_query($sql) 
							OR die(mysql_error());
							
					//copy comments from this revision to archive comments table
					$copyComment = "INSERT INTO `tbl_commentArchive` (`campaignID`, `reviewerID`,  `reviewResult`, `comment`, `commentDate`) SELECT `campaignID`, `reviewerID`, `reviewResult`, `reviewComments`, `CommentDate`  FROM `tbl_reviewers` WHERE `campaignID` = ".$campaign."";
						$copy = mysql_query($copyComment) 
							OR die(mysql_error());

						
				}
				
			}
			


 	}
 	
 	public function set_isreviewComplete($cid){
 		
 		$sql = "SELECT isComplete FROM `tbl_reviewers` WHERE `campaignID` = ".$cid." order by `reviewOrder` asc";
 		
 		$res = mysql_query($sql) 
			OR die(mysql_error());
			while ($row = mysql_fetch_assoc($res)){
				if ($row['isComplete'] == 0){
					return false;
				}
				
			}
			return true;

 	}
 	
 	public function set_isreviewApproved($cid){
 		
 		$sql = "SELECT reviewResult FROM `tbl_reviewers` WHERE `campaignID` = ".$cid." order by `reviewOrder` asc";
 		
 		$res = mysql_query($sql) 
			OR die(mysql_error());
			while ($row = mysql_fetch_assoc($res)){
				if ($row['reviewResult'] == 0){
					return false;
				}
				
			}
			return true;

 	}

 	
 	

	

}
?>
