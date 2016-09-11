<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//require_once('Config.php');
class EmployeeManager extends commonObject
{
	
	function getAllCandidates($show='1',$status='0',$postion='0')
	{
		$where='';
		if($show!='0' ||$status!='0' || $postion!='0'){
			$where = " WHERE ";	
		}
		
		if($show != '0'){
			if($show == 1)
				$where.= "candidates.is_active=1";	
			if($show == 2)
				$where.= "candidates.is_active=0";		
		}
		
		if($status != '0'){
			if(strpos($where,'candidates.is_active')!==FALSE){
				$where.=" AND ";
			}	
			$where .= "candidates.status=".$status;	
		}
		
		if($postion != '0'){
			if(strpos($where,'candidates.status')!==FALSE || strpos($where,'candidates.is_active')!==FALSE){
				$where.=" AND ";
			}
			$where .= "candidates.position=".$postion;	
		}
		
		if($show == 0)
			$arr_orders =  getData("SELECT candidates.*, STATUS.status_name, POSITION.position_name From candidates LEFT JOIN (SELECT status_id,status_name FROM candidate_status) AS STATUS ON candidates.status =STATUS.status_id LEFT JOIN (SELECT position_id, position_name FROM candidate_position) AS POSITION ON candidates.position = POSITION.position_id ".$where." order by is_active DESC");
		elseif($show == 1)
			$arr_orders =  getData("SELECT candidates.*, STATUS.status_name, POSITION.position_name From candidates LEFT JOIN (SELECT status_id,status_name FROM candidate_status) AS STATUS ON candidates.status =STATUS.status_id LEFT JOIN (SELECT position_id, position_name FROM candidate_position) AS POSITION ON candidates.position = POSITION.position_id ".$where);
		elseif($show == 2)
			$arr_orders =  getData("SELECT candidates.*, STATUS.status_name, POSITION.position_name From candidates LEFT JOIN (SELECT status_id,status_name FROM candidate_status) AS STATUS ON candidates.status =STATUS.status_id LEFT JOIN (SELECT position_id, position_name FROM candidate_position) AS POSITION ON candidates.position = POSITION.position_id ".$where);
		return $arr_orders;
	}
	
	function candidate_counts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(id) AS CNT From candidates WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(id) AS CNT From candidates WHERE is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(id) AS CNT From candidates WHERE is_active = 0");
		$arr_counts['trash'] = $trash;
		return $arr_counts;		
	}
	function getCandidateVariables()
	{
		$varArray['name'] = $_REQUEST['name'];
		$varArray['interview_date_time'] = $_REQUEST['interview_date_time'];
		$varArray['interviewed_by'] = $_REQUEST['interviewed_by'];
		$varArray['position'] = $_REQUEST['position'];
		$varArray['experience'] = $_REQUEST['experience'];
		$varArray['previous_company'] = $_REQUEST['previous_company'];
		$varArray['phone_number'] = $_REQUEST['phone_number'];
		$varArray['reference'] = $_REQUEST['reference'];
		$varArray['current_ctc'] = $_REQUEST['current_ctc'];
		$varArray['expected_ctc'] = $_REQUEST['expected_ctc'];
		$varArray['notice_period'] = $_REQUEST['notice_period'];		
		$varArray['email'] = $_REQUEST['email'];
		$varArray['score'] = $_REQUEST['score'];
		$varArray['remarks'] = $_REQUEST['remarks'];
		$varArray['status'] = $_REQUEST['status'];
		//$varArray['resume'] = $_REQUEST['resume'];
		return $varArray;
	}
	function insertCandidate($candidateArray)
	{
		$insertQry = $this->getInsertDataString($candidateArray, 'candidates');
		updateData($insertQry);
		return mysql_insert_id();
	}
	function getCandidateDetails($candidate_id)
	{
		return $resultSet = getRow("select * from  candidates where id='".$candidate_id."'");
	}
	function updateCandidatePriority($id,$current_val){
		updateData("UPDATE `candidates` SET `priority`='".$current_val."' WHERE id='".$id."'");	
	}
	function getHeighestPriority(){
		return getOne("SELECT max(`priority`) FROM `candidates` WHERE 1");
	}
	function candidate_updateUsingId($candidateArray)
	{
			$updateQry=$this->getUpdateDataString($candidateArray,"candidates","id");
			updateData($updateQry);
	}
	function candidate_deleteUsingId($candidate_id)
	{
		updateData("UPDATE `candidates` SET `is_active`=0 WHERE id='".$candidate_id."'");
	}
	function restore_candidate($id)
	{
		$change_data = array (
								'is_active' => 1,							
								); 
		$change_data['id'] = $id;
		$updateQry=$this->getUpdateDataString($change_data,"candidates","id");
		updateData($updateQry);
	}
	function getAllpositions()
	{
		$arr_positions =  getData("SELECT * From candidate_position WHERE is_active = 1");
		return $arr_positions;
	}
	function getAllstatus()
	{
		$arr_status =  getData("SELECT * From candidate_status WHERE is_active = 1");
		return $arr_status;
	}
	
	function getAutoIncrement(){
		$result =  getData("SHOW TABLE STATUS LIKE 'candidates'");
		return $result[0];
	}
	
	function getAllEmployees($show='1')
		{
			if($show == 0)
				$arr_orders =  getData("SELECT * From employee WHERE 1 order by is_active DESC");
			elseif($show == 1)
				$arr_orders =  getData("SELECT * From employee WHERE is_active = 1");
			elseif($show == 2)
				$arr_orders =  getData("SELECT * From employee WHERE is_active = 0");
			return $arr_orders;
		}
		function getAllCurrentEmployee()
		{
			$resultSet =  getData("SELECT * From employee WHERE is_active=1 and employee_status=1");
			return $resultSet;
		}
		function get_allcounts()
		{
			$arr_counts = array();
			$all = getOne("SELECT COUNT(employee_id) AS CNT From employee WHERE 1");
			$arr_counts['all'] = $all;
			$active = getOne("SELECT COUNT(employee_id) AS CNT From employee WHERE is_active = 1");
			$arr_counts['active'] = $active;
			$trash = getOne("SELECT COUNT(employee_id) AS CNT From employee WHERE is_active = 0");
			$arr_counts['trash'] = $trash;
			return $arr_counts;
			
		}
		
		function restore_employee($id)
		{
			$change_data = array (
									'is_active' => 1,							
									); 
			$change_data['employee_id'] = $id;
			$updateQry=$this->getUpdateDataString($change_data,"employee","employee_id");
			updateData($updateQry);
			
		}
	/*function getAllEmployees(){
		
		return $resultSet = getData("SELECT * FROM `employee` WHERE is_active =1");
		
	}*/
	
	//To get all the details of employee using employee_id
	function getEmployeeDetails($employee_id)
	{
		return $resultSet = getRow("select * from  `employee` where is_active =1 AND employee_id='".$employee_id."'");
	}
	
	
	function getAllManager(){
		$resultSet = getData("select distinct(manager_id) from employee where 1");
		foreach($resultSet as $key=>$value){
			$manager_id[] = $value['manager_id'];	
		}
		return getData("select * from employee where employee_id in (".implode(",", $manager_id).") and is_active=1");
	}
	
	function getAllEmployeeOfManager($manager_id){
		return getData("select * from employee where manager_id='".$manager_id."' and is_active=1");
	}
	//To get name of particular employee using employee_id
	function getEmployeeNameUsingId($employee_id){
		return $resultSet = getOne("select employee_name from `employee` where is_active =1 AND employee_id='".$employee_id."'");
	}
	function getEmployeeNameUsingUesrId($user_id){
		return $resultSet = getOne("select name from `users` where is_active =1 AND user_id='".$user_id."'");
	}
	//To get name of particular employee using employee_id
	function getEmployeeIdUsingName($employee_name){
		return $resultSet = getOne("select employee_id from employee where is_active =1 AND employee_name='".$employee_name."'");
	}
	
	function getEmployeeUserName($employee_Id)
	{
		return $resultSet = getOne("select user_name from users where is_active =1 AND user_id='".$employee_Id."'");
	}
	
	function getEmployeeIdUsingUserId($user_id)
	{
		return getOne("select employee_id from employee where user_id='".$user_id."'");
	}
	
	function isEmployeeManager($employee_id)
	{
		$query="select employee_id from projects where employee_id='".$employee_id."'";
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}	
	}
	//To restrict duplicate in employee.
	function isEmployeeExist($employee_user_name,$employee_id=0){
		$query="select * from users where user_name='".$employee_user_name."' and is_active=1";
		if($employee_id!=0){
			$query.=" AND user_id!=".$employee_id;
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	//To update a row in employee table using employee_id. 
	function updateUsingId($dataArray){
		$updateQry=$this->getUpdateDataString($dataArray,"employee","employee_id");
		updateData($updateQry);
	}
	
	//This will add user id in employee table.
	function addUserId($user_id,$employee_id)
	{
		updateData("UPDATE `employee` SET `user_id`='".$user_id."' WHERE `employee_id`='".$employee_id."'");	
	}
	
	//To delete a row in employee table using employee_id. 
	function deleteUsingId($employee_id){
		updateData("UPDATE `employee` SET `is_active`=0 WHERE `employee_id`='".$employee_id."'");
	}
		
	function insertEmployee($varArray)
	{
		$insertQry = $this->getInsertDataString($varArray, 'employee');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	function getEmployeeVariables()
	{
		$varArray['employee_name'] = $_REQUEST['employee_name'];
		$varArray['employee_user_name'] = $_REQUEST['employee_user_name'];
		$varArray['date_of_birth'] = $_REQUEST['dob_alt'];
		$varArray['per_address'] = $_REQUEST['per_address'];	
		$varArray['cur_address'] = $_REQUEST['cur_address'];	
		$varArray['phone_number'] = $_REQUEST['phone_number'];	
		$varArray['current_salary'] = $_REQUEST['current_salary'];	
		$varArray['joining_date'] = $_REQUEST['jd_alt'];	
		$varArray['designation'] = $_REQUEST['designation'];	
		$varArray['personal_email'] = $_REQUEST['personal_email'];	
		$varArray['company_email'] = $_REQUEST['company_email'];	
		$varArray['manager_id'] = $_REQUEST['manager_id'];
		$varArray['employee_status'] = $_REQUEST['employee_status'];
		return $varArray;
	}
	
	
	function getAllReimbursements()
	{
		return getData("Select ee.*,c.name as category_name,emp.employee_name as employee_name from reimbursement ee LEFT OUTER JOIN `payment_category` c ON ee.category_id=c.pc_id LEFT OUTER JOIN employee emp ON ee.employee_id=emp.employee_id where ee.is_active=1 order by paid_date DESC");
	}
	
	function getReimbursementVariables()
	{
		$this->db_fields['category_id'] = $_REQUEST['category_id'];
		if(isset($_REQUEST['employee']))
			$this->db_fields['employee_id'] = $_REQUEST['employee'];
		$this->db_fields['amount_usd'] = $_REQUEST['amount_usd'];
		$this->db_fields['conversion_rate'] = $_REQUEST['conversion_rate'];
		$this->db_fields['amount'] = $_REQUEST['amount_inr'];
		$this->db_fields['paid_date'] = $_REQUEST['paid_date_alt'];
		$this->db_fields['remarks'] = $_REQUEST['remark'];	
		$this->db_fields['project_id'] = $_REQUEST['project'];	
	}
	
	
	function getReimbursementDetails($ReimbursementId)
	{
		return $resultSet = getRow("select * from  reimbursement where reimbursement_id='".$ReimbursementId."'");	
	}
	
	function getDueReimbursementCategory()
	{
		return getOne("select pc_id from payment_category where name='due reimbursement'");
	}
	
	function getReimbursementCategory()
	{
		return getOne("select pc_id from payment_category where name='reimbursement'");
	}
	
	function getLatestRecord($userId)
	{
		return getRow("select * from attendance where user_id='".$userId."' order by in_time desc");
	}
	function getUserLoginDetails($attendance_id)
	{
		return getRow("select * from attendance where attendance_id='".$attendance_id."'");
	}
	function getLogInVariables()
	{	global $function;
		//var_dump($_REQUEST);exit;
		$varArray['user_id'] =  $_SESSION['user_id'];
		if($function=='log_in')
		{
			$varArray['in_time'] = date('Y-m-d H:i:s');
			$varArray['in_notes'] = $_REQUEST['notes'];
		}
		if($function=='log_out')
		{
			$varArray['out_time'] = date('Y-m-d H:i:s');
			$varArray['out_notes'] = $_REQUEST['notes'];
			$varArray['in_notes'] = $_REQUEST['in_notes'];
		}
		$varArray['ip_address'] = $_SERVER["REMOTE_ADDR"];
		return $varArray;
		
	}
	function isUserLogin($userId)
	{
		//echo "select attendance_id from attendance where user_id='".$userId."' and DATE_FORMAT(attendance.in_time, '%Y-%m-%d') = CURDATE()"; exit;
		$resultSet = getData("select attendance_id from attendance where user_id='".$userId."' and DATE_FORMAT(attendance.in_time, '%Y-%m-%d') = CURDATE()");
		//echo "hii ".sizeof($resultSet);exit;
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	function getAllUsers()
	{
		return getData("select user_id,name from users where is_active=1");
	}
	
	function getReportDetails($start_date,$end_date,$userId)
	{
		//echo "select * from attendance where DATE_FORMAT(attendance.in_time, '%Y-%m-%d') between '".$start_date."' and '".$end_date."' and user_id='".$userId."'"; exit;
		return getData("select * from attendance where DATE_FORMAT(attendance.in_time, '%Y-%m-%d') between '".$start_date."' and '".$end_date."' and user_id='".$userId."'");
	}
	
	function getUsersLoginDetailsByUsers($start_date,$end_date,$user_string)
	{
		
		return getData("select A.*,name,TIMESTAMPDIFF(SECOND,`in_time`,`out_time`) as seconds,TIME(`in_time`) AS in_time_only,TIME(`out_time`) AS out_time_only from attendance as A LEFT JOIN users as U ON A.user_id=U.user_id where A.user_id in (".$user_string.") and DATE_FORMAT(A.in_time, '%Y-%m-%d') between '".$start_date."' and '".$end_date."' order by A.user_id");
	}
	function getUsersLoginDetailsByInDate($start_date,$end_date,$user_string)
	{
		return getData("select A.*,name,TIMESTAMPDIFF(SECOND,`in_time`,`out_time`) as seconds,TIME(`in_time`) AS in_time_only,TIME(`out_time`) AS out_time_only from attendance as A LEFT JOIN users as U ON A.user_id=U.user_id where A.user_id in (".$user_string.") and DATE_FORMAT(A.in_time, '%Y-%m-%d') between '".$start_date."' and '".$end_date."' order by DATE_FORMAT(A.in_time, '%Y-%m-%d')");
	}
	
	function getUserNames($user_string)
	{
		return getData("select name from users where user_id in (".$user_string.")");
	}
	
	function getTotalSecondsUserwise($start_date,$end_date,$user_string)
	{
	return getData("select A.*,name,sum(TIMESTAMPDIFF(SECOND,`in_time`,`out_time`)) as seconds from attendance as A LEFT JOIN users as U ON A.user_id=U.user_id where A.user_id in (".$user_string.") and DATE_FORMAT(A.in_time, '%Y-%m-%d') between '".$start_date."' and '".$end_date."' group by A.user_id order by DATE_FORMAT(A.in_time, '%Y-%m-%d')");
	
	} 
	
	function getNonApproved($userId)
	{
		if($userId == 0)
		{	return getData("select A.*,TIMESTAMPDIFF(SECOND,`in_time`,`out_time`) as seconds ,name from attendance as A LEFT JOIN users as U ON A.user_id=U.user_id where approved=0");		}
		else
		{   return getData("select A.*,TIMESTAMPDIFF(SECOND,`in_time`,`out_time`) as seconds ,name from attendance as A LEFT JOIN users as U ON A.user_id=U.user_id where approved=0 and A.user_id in (select user_id from employee where manager_id='".$userId."')");
		}
	}
	
	function getApplyLeaveVariables()
	{
		$this->db_fields['leave_type'] = $_REQUEST['leave_type'];
		$this->db_fields['from_date'] = $_REQUEST['leave_start_date'];
		$this->db_fields['to_date'] = $_REQUEST['leave_to_date'];
		$this->db_fields['leave_reason'] = $_REQUEST['leave_reason'];	
	}
	
	function getAllLeavesOfEmployee($employee_id)
	{
		return $resultSet = getData("SELECT * FROM applied_leaves WHERE is_active=1 AND user_id='".$employee_id."' ORDER BY from_date");
	}
	
	function getAppliedLeaveDetails($applied_leave_id)
	{
		return $resultSet = getRow("SELECT * FROM applied_leaves WHERE applied_leave_id=".$applied_leave_id);
	}
	
	function getAllLeaves($user_id)
	{
		if($user_id == 0)
			return $resultSet = getData("SELECT al.*,e.`employee_name` FROM `employee` as e,`applied_leaves` as al WHERE al.to_date>current_date() AND e.user_id=al.user_id order by leave_status");	
		else
			return $resultSet = getData("SELECT al.*,e.`employee_name` FROM `employee` as e,`applied_leaves` as al WHERE al.to_date>current_date() AND e.user_id=al.user_id AND e.manager_id='".$user_id."' order by leave_status");		
	}
	
	function approvedAppliedLeaveOfEmployee($employee_id)
	{
		updateData("UPDATE applied_leaves SET leave_status=1 WHERE applied_leave_id='".$employee_id."'");
	}
	
	function rejectAppliedLeaveOfEmployee($employee_id,$reject_reason)
	{
		updateData("UPDATE applied_leaves SET leave_status=2 , rejection_reason='".addslashes($reject_reason)."' WHERE applied_leave_id='".$employee_id."'");	
	}
	
	function getAllEmployeeWithJoiningDate($user_id)
	{
		if($user_id == 0)
			return $resultSet = getData("SELECT employee_id,user_id,employee_name,joining_date FROM employee where is_active =1 ORDER BY joining_date desc");	
		else	
			return $resultSet = getData("SELECT employee_id,user_id,employee_name,joining_date FROM employee WHERE is_active =1 AND manager_id='".$user_id."' ORDER BY joining_date desc");	
	}
	
	function getAllLeaveTakenTillNow()
	{
		return $resultSet = getData("SELECT user_id,leave_type,sum(datediff(`to_date`,`from_date`))+COUNT(`user_id`) AS leaves_taken FROM `applied_leaves` WHERE leave_status=1 group by user_id,leave_type");	
	}
} 
?>
