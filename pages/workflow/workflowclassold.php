<?php


class Workflow
{
	public $campaignID;  //Id for selected campaign
	public $campaignStatus;		//current status of campaign
	
	/*this constructor profides a way create an instance of the currently logged on user*/
	function _construct() {
    	include("../../config/DB_Connect.php");
		session_start(); 

		$query = mysql_query("SELECT * FROM `tbl_campaign` WHERE canEdit = '".$_SESSION['ID']."'");
		if (!$query) {    
				die("Query to show fields from table failed userclass.php line 20");
		}
		$work = mysql_fetch_assoc($query);

		
		$this->userID = $work['userID'];
		$this->userAccountStatus = $work['userAccountStatus'];
		
	}
	
	/*withID($id) provides a way to create an instance of another user of the system if you have 
	the userID*/
	public static function withID( $id ) {
    	$instance = new self();
    	$instance->loadByID( $id );
    	return $instance;
    }
	
	/*withRow( array $row ) provides a way to create an instance of another user of the system if 
	you have the users row from the user table*/
    public static function withRow( array $row ) {
    	$instance = new self();
    	$instance->fill( $row );
    	return $instance;
    	
    }

    protected function loadByID( $id ) {
    	include("../../config/DB_Connect.php");
		

		$query = mysql_query("SELECT * FROM tbl_user WHERE userID = '".$id."'");
		if (!$query) {    
				die("Query to show fields from table failed userclass.php Line 58");
		}
		$user = mysql_fetch_assoc($query);

    	
    	$this->fill( $user );
    }

    protected function fill( array $work ) {
    	
    	$this->campaignID = $work['userID'];
		$this->campaignStatus = $work['userAccountStatus'];
		
    }

	
	/*Update user info in the database */
	public function workflow_update(){ 
  		
  		include("../../config/DB_Connect.php");
  		include '../../config/functions.php';

  		if (!check_email_address($_POST['userEMailAddress'])){
 		return 405;
 		}


  		mysql_query("UPDATE tbl_user SET userFirstName = '".$this->userFirstName."', userLastName = '".$this->userLastName."', userEMailAddress = '".$this->userEMailAddress."', userPhoneNumber = '".$this->userPhoneNumber."', userAccountStatus = '".$this->userAccountStatus."', userRole = '".$this->userRole."' WHERE userID = '".$this->userID."'")or die(mysql_error());
  		return 701;
  			
	}

	/*Get all open campaigns that are open and assigned to currently logged on user */
	public function get_myOpenWork($id){ 
		include("../../config/DB_Connect.php");
		

		$query = mysql_query("SELECT `campaignID`, `campaignName`, `launchDate`, `wfStatusName`, `updatedDate`, `canEdit`, `userFirstName`, `userLastName`, `campaignDescription` FROM tbl_campaigns 
left join tbl_user on updatedBy = userID 
left join tbl_wfStatus on campaignStatus = wfStatusID 
WHERE canEdit = '".$id."'");
		if (!$query) {    
				die("Query to show fields from table failed userclass.php Line 58");
		}
		return $query;

		
 	}
	public function get_myOpenReviews($id){ 
		include("../../config/DB_Connect.php");
		

		$query = mysql_query("SELECT * FROM `tbl_reviewers` t1
left join tbl_user as t2 on `t1`.`reviewerID`=`t2`.`userID`
left join tbl_campaigns as t3 on `t1`.`campaignID`= `t3`.`campaignID` WHERE reviewerID = '".$id."'");
		if (!$query) {    
				die("Query to show fields from table failed userclass.php Line 58");
		}
		return $query;

		
 	}

	/*Get all open campaigns that are open for all users*/
	public function get_allOpenWork(){ 

 	}
	
	

}

?>