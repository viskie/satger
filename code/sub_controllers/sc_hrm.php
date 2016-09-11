<?php
require_once('library/employeeManager.php');
$employeeObject= new EmployeeManager();
require_once('library/userManager.php');
$userObject= new UserManager();
require_once('library/groupManager.php');
$groupObject= new GroupManager();
require_once('library/categoryManager.php');
$categoryObject= new CategoryManager();
require_once('library/projectManager.php');
$projectObject= new ProjectManager();
require_once('library/accountsManager.php');
$accountsObject= new accountsManager();
require_once('library/settingManager.php');
$SettingObject= new SettingManager();
require_once('library/loginManager.php');
extract($_POST);
	switch($function)
		{
			case "view_employees":
			case "view":
			        if(isset($show_status))
					$show_status = $show_status;
					else
					$show_status = 1;
					$data['allEmployees'] = $employeeObject->getAllEmployees($show_status);
					$data['rec_counts'] = $employeeObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_employees.php";
			break;
			
			case "restore_employee" :
					
					$employeeObject->restore_employee($edit_id);
					$data['allEmployees'] = $employeeObject->getAllEmployees($show_status);
					$data['rec_counts'] = $employeeObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('employee','restore');
					$page = "manage_employees.php";	
			break;
			
			case "show_add_employee":
				$data['allEmployees']=$employeeObject->getAllEmployees();
				$page = "add_edit_employee.php";
			break;	
			
			case "add_employee":
						
						$employeeVariables = $employeeObject->getEmployeeVariables();
						
						if(!$employeeObject->isEmployeeExist($employeeVariables['employee_user_name'])){
						
							$employeeVariables['added_by']=$_SESSION['user_id'];
							$employeeVariables['added_date']=date('Y-m-d H:i:s');
							
							$employeeVariables['employee_password'] = $_REQUEST['employee_password'];
							$user_id = $userObject->insertEmployeeInUsers($employeeVariables);
							
							//print_r($employeeVariables); 
							//exit;
							unset($employeeVariables['employee_user_name']);
							unset($employeeVariables['employee_password']);
							$employee_id=$employeeObject->insertEmployee($employeeVariables);
							$employeeObject->addUserId($user_id,$employee_id);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('employee','add');
							$page = "manage_employees.php";
						
						}else{
							$is_exist = true;
							$data['allEmployees'] = $employeeObject->getAllEmployees();
							$data['employeeDetails'] = $employeeVariables;
							$notificationArray['type'] = 'Failed';
							$notificationArray['message'] =  showmsg('employee','dup','username'); 
							$page="add_edit_employee.php";
						}
						if(isset($show_status))
							$show_status = $show_status;
						else
							$show_status = 1;
						$data['allEmployees'] = $employeeObject->getAllEmployees($show_status);
						$data['rec_counts'] = $employeeObject->get_allcounts();
						$data['current_show'] = $show_status;
			break;
			
			case "edit_employee":
				
				$data['allEmployees'] = $employeeObject->getAllEmployees(1);
				$employee_Id = $_REQUEST['edit_id'];
				$employee_Details=$employeeObject->getEmployeeDetails($employee_Id);
				$employee_user_name = $employeeObject->getEmployeeUserName($employee_Details['user_id']);
				$data['employeeDetails'] = $employee_Details;
				$data['employeeDetails']['employee_user_name'] = $employee_user_name;
				$page = "add_edit_employee.php";
				
				
			break;
			
			case "edit_employee_entry":
				//echo "<pre>"; print_r($_REQUEST);
					$employeeVariables = $employeeObject->getEmployeeVariables();
					$employeeVariables['employee_id']=$_REQUEST['edit_id'];
					$employeeVariables['user_id']=$_REQUEST['user_id'];
					if(!$employeeObject->isEmployeeExist($employeeVariables['employee_user_name'],$employeeVariables['user_id'])){
						
						$employeeVariables['modified_by']=$_SESSION['user_id'];
						$employeeVariables['modified_date']=date('Y-m-d H:i:s');
						$userObject->updateEmployeeInUser($employeeVariables);
						unset($employeeVariables['employee_user_name']);
						$employeeObject->updateUsingId($employeeVariables);
						
						$previousPass=$userObject->getUserPassword($employeeVariables['user_id']);
						$sha1_currentpass=sha1($_REQUEST['employee_password']);
						if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
							$userObject->setPassword($previousPass,$_REQUEST['user_id']);
						}
						
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('employee','update');
						$page="manage_employees.php";
					}else{
						
						$data['employeeDetails'] = $employeeVariables;
						$is_exist = true;
						$is_edit = true;
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('employee','dup','username');
						$page="add_edit_employee.php";
						
					}
					if(isset($show_status))
							$show_status = $show_status;
						else
							$show_status = 1;
						$data['allEmployees'] = $employeeObject->getAllEmployees($show_status);
						$data['rec_counts'] = $employeeObject->get_allcounts();
						$data['current_show'] = $show_status;
			
			break;
			
			case "delete_employee":
			
					$employee_id=$_REQUEST['edit_id'];
					$employeeObject->deleteUsingId($employee_id);
					//$data['allEmployees'] = $employeeObject->getAllEmployees();
					
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('employee','delete');
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allEmployees'] = $employeeObject->getAllEmployees($show_status);
					$data['rec_counts'] = $employeeObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page="manage_employees.php";
			
			break;
			
			/**** Reimbursement CRUD ****/
			
			case "view_reimbursement":
				$data['allReimbursements'] = $employeeObject->getAllReimbursements();
				$page='manage_reimbursement.php';
			break;
			
			case "show_add_reimbursement" :
				$data['catdetails'] = $accountsObject->getAllExpenseCategories(1);
				$data['empdetails'] = $employeeObject->getAllEmployees();
				$data['prodetails'] = $projectObject->getAllProjects();
				$page = "add_edit_reimbursement.php";
			break;
			
			case "add_reimbursement":
				$employeeObject->getReimbursementVariables();
				$reimbursementVariables = $employeeObject->db_fields;
				
				$reimbursementVariables['paid_by']=$_SESSION['user_id'];
				$reimbursementVariables['added_by']=$_SESSION['user_id'];
				$reimbursementVariables['added_date']=date('Y-m-d H:i:s');
				
				/**  entry to payments table ***/
				
				$payments1=array();
				$payments1['payment_type']='Expense';
				$payments1['category_id']=$reimbursementVariables['category_id'];
				$payments1['project_id']=$reimbursementVariables['project_id'];
				$payments1['employee_id']=$reimbursementVariables['employee_id'];
				$payments1['amount_usd']=$reimbursementVariables['amount_usd'];
				$payments1['conversion_rate']=$reimbursementVariables['conversion_rate'];
				$payments1['amount']=$reimbursementVariables['amount'];
				$payments1['payment_date']=$reimbursementVariables['paid_date'];
				$payments1['remarks']=$reimbursementVariables['remarks'];
				$payments1['added_by']=$reimbursementVariables['added_by'];
				$payments1['added_date']=date('Y-m-d H:i:s');
				
				$payments2=array();
				$category = $employeeObject->getDueReimbursementCategory();
				$payments2['payment_type']='Income';
				$payments2['category_id']=$category;
				$payments2['project_id']=$reimbursementVariables['project_id'];
				$payments2['employee_id']=$reimbursementVariables['employee_id'];
				$payments2['amount_usd']=$reimbursementVariables['amount_usd'];
				$payments2['conversion_rate']=$reimbursementVariables['conversion_rate'];
				$payments2['amount']=$reimbursementVariables['amount'];
				$payments2['payment_date']=$reimbursementVariables['paid_date'];
				$payments2['remarks']=$reimbursementVariables['remarks'];
				$payments2['added_by']=$reimbursementVariables['added_by'];
				$payments2['added_date']=date('Y-m-d H:i:s');
				
				$expenseInserted = $employeeObject->insert($payments1,'payments');
				$incomeInserted = $employeeObject->insert($payments2,'payments');
				
				$reimbursementIdInserted = $employeeObject->insert($reimbursementVariables,'reimbursement');
				$data['allReimbursements'] = $employeeObject->getAllReimbursements();
				$page = "manage_reimbursement.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Reimbursement','add');
			break;
			
			case "edit_reimbursement":
				$data['catdetails'] = $accountsObject->getAllExpenseCategories(0);
				$data['empdetails'] = $employeeObject->getAllEmployees();
				$data['prodetails'] = $projectObject->getAllProjects();
				$reimbursementId = $_REQUEST['edit_id'];				
				$reimbursementDetails = $employeeObject->getReimbursementDetails($reimbursementId);
			    $data['reimbursementDetails'] = $reimbursementDetails;
				$data['reimbursementDetails']['reimbursement_id'] = $reimbursementId;
				$page="add_edit_reimbursement.php";
			break;
			
			case "edit_reimbursement_entry":
				$employeeObject->getReimbursementVariables();
				$reimbursementVariables = $employeeObject->db_fields;
				$reimbursementVariables['reimbursement_id'] = $_REQUEST['edit_id'];
				
				$reimbursementVariables['modified_by']=$_SESSION['user_id'];
				$reimbursementVariables['modified_date']=date('Y-m-d H:i:s');
				
				$employeeObject->update($reimbursementVariables,"reimbursement","reimbursement_id");
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Reimbursement','update');
				$page="manage_reimbursement.php";
				$data['allReimbursements'] = $employeeObject->getAllReimbursements();
			break;
			
			case "delete_reimbursement":
				$reimbursement_id=$_REQUEST['edit_id'];
				$employeeObject->delete($reimbursement_id,'reimbursement','reimbursement_id');
				$data['allReimbursements'] = $employeeObject->getAllReimbursements();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Reimbursement','delete');
				$page="manage_reimbursement.php";
			break;
			
			case "paid_reimbursement":
			
				$reimbursement_id=$_REQUEST['edit_id'];				
				$reimbursementDetails = $employeeObject->getReimbursementDetails($reimbursement_id);
			    //$data['reimbursementDetails'] = $reimbursementDetails;
			
				$payments1=array();
				$payments1['payment_type']='Expense';
				$payments1['category_id']=$employeeObject->getReimbursementCategory();
				$payments1['project_id']=$reimbursementDetails['project_id'];
				$payments1['employee_id']=$reimbursementDetails['employee_id'];
				$payments1['amount_usd']=$reimbursementDetails['amount_usd'];
				$payments1['conversion_rate']=$reimbursementDetails['conversion_rate'];
				$payments1['amount']=$reimbursementDetails['amount'];
				$payments1['payment_date']=$reimbursementDetails['paid_date'];
				$payments1['remarks']=$reimbursementDetails['remarks'];
				$payments1['added_by']=$reimbursementDetails['added_by'];
				$payments1['added_date']=date('Y-m-d H:i:s');
				
				$expenseInserted = $employeeObject->insert($payments1,'payments');
				
				$employeeObject->delete($reimbursement_id,'reimbursement','reimbursement_id');
				$data['allReimbursements'] = $employeeObject->getAllReimbursements();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = $arr_msg['reimbursement']['paid'];
				$page="manage_reimbursement.php";
			break;
			/**** End Of reimbursement CRUD ****/
			
			/*** Attendance ***/
			
			case "mark_attendance":
				$data['latest'] = $employeeObject->getLatestRecord($_SESSION['user_id']);
				$data['user_details'] = $employeeObject->getUserLoginDetails($data['latest']['attendance_id']);
				$data['logInVariables'] = $employeeObject->getLogInVariables();
				$page = "manage_attendance.php";
			break;
			
			case "log_in":
			$data['logInVariables'] = $employeeObject->getLogInVariables();
			if(!$employeeObject->isUserLogin($_SESSION['user_id']))
			{
			$attendanceInserted = $employeeObject->insert($data['logInVariables'],'attendance');
			$notificationArray['type'] = 'Success';
			$notificationArray['message'] = $arr_msg['attendance']['login']; 
			}
			else
			{
				$notificationArray['type'] = 'Failed';
				$notificationArray['message'] = $arr_msg['attendance']['loggedin'];
			}
			$data['latest'] = $employeeObject->getLatestRecord($_SESSION['user_id']);
			$data['user_details'] = $employeeObject->getUserLoginDetails($data['latest']['attendance_id']);
			$page = "manage_attendance.php";
			break;
			
			case "save_inNotes":
			$data['latest'] = $employeeObject->getLatestRecord($_SESSION['user_id']);
			$data['latest']['in_notes'] = $_REQUEST['in_notes'];
			//var_dump($data['latest']);exit;
			$employeeObject->update($data['latest'],'attendance','attendance_id');
			$notificationArray['type'] = 'Success';
			$notificationArray['message'] = $arr_msg['attendance']['innote_save'];
			$data['latest'] = $employeeObject->getLatestRecord($_SESSION['user_id']);
			$data['user_details'] = $employeeObject->getUserLoginDetails($data['latest']['attendance_id']);
			$page = "manage_attendance.php";
			break;
			
			case "log_out":
			$data['logInVariables'] = $employeeObject->getLogInVariables();
			$data['latest'] = $employeeObject->getLatestRecord($_SESSION['user_id']);
			$seconds = getDateTimeDiff(date('Y-m-d H:i:s'),($data['latest']['in_time']));
			$hours = (int)($seconds/3600);
			if($hours > 10)
			{$data['logInVariables']['approved'] = 0;
			}
			$data['logInVariables']['attendance_id'] = $data['latest']['attendance_id'];
			if($data['latest']['out_time'] == '0000-00-00 00:00:00')
			{
				$employeeObject->update($data['logInVariables'],'attendance','attendance_id');
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = $arr_msg['attendance']['logout']; 
			}
			else
			{
				$notificationArray['type'] = 'Failed';
				$notificationArray['message'] = $arr_msg['attendance']['loggedout'];
			}
			$data['latest'] = $employeeObject->getLatestRecord($_SESSION['user_id']);
			$data['user_details'] = $employeeObject->getUserLoginDetails($data['latest']['attendance_id']);
			$page = "manage_attendance.php";
			break;
			
			case "update_notes":
			//var_dump($_REQUEST);exit;
			$data['latest'] = $employeeObject->getLatestRecord($_SESSION['user_id']);
			if($_REQUEST['login_text']!='' || $_REQUEST['logout_text']!='')
			{
				if($_REQUEST['login_text']!='')
				{
					$data1['in_notes'] = $_REQUEST['login_text'];
				}
				if($_REQUEST['logout_text']!='')
				{
					$data1['out_notes'] = $_REQUEST['logout_text'];
				}
				//$data['user_id'] = $_SESSION['user_id'];
				$data1['attendance_id'] = $data['latest']['attendance_id'];
				$employeeObject->update($data1,'attendance','attendance_id');
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = $arr_msg['attendance']['note_update'];
			}
			else
			{
				$notificationArray['type'] = 'Failed';
				$notificationArray['message'] = $arr_msg['attendance']['put_ note']; 
			}
			$data['latest'] = $employeeObject->getLatestRecord($_SESSION['user_id']);
			$data['user_details'] = $employeeObject->getUserLoginDetails($data['latest']['attendance_id']);
			$page = "manage_attendance.php";
			break;
			
			case "reports":
			$user_string = '';
			$data['users'] = $employeeObject->getAllUsers();
			$date = new DateTime();
				$date->sub(new DateInterval('P30D'));
				
				$start_date=$date->format('Y-m-d');
				$end_date=date('Y-m-d');
				
				
				if(isset($_REQUEST['is_post_back']) && $_REQUEST['is_post_back']=="TRUE"){
					if(isset($_REQUEST['start_date']) && $_REQUEST['start_date']!=''){
						$start_date=$_REQUEST['start_date'];
						$data['start_date']=$start_date;
					}
					if(isset($_REQUEST['end_date']) && $_REQUEST['start_date']!=''){
						$end_date=$_REQUEST['end_date'];
						$data['end_date']=$end_date;
					}
					
						$alignment = $_REQUEST['alignment'];
					
					if(!isset($_REQUEST['users']))
					{
						$user_string='null';
						$_REQUEST['users']=array();
					}
					else
					{
						foreach($_REQUEST['users'] as $key=>$val)
						{
							$user_string.=$val.",";
						}
					}
					 $user_string = trim($user_string,",");
					 $data['requested_users'] = $_REQUEST['users'];
					 $data['user_names'] = $employeeObject->getUserNames($user_string);
					 //var_dump($data['user_names']);exit;
					 $period = new DatePeriod(
						 new DateTime($start_date),
						 new DateInterval('P1D'),
						 new DateTime($end_date)
					);
					 $dates = array();
					 //var_dump($period);exit;
					 foreach($period as $dt)
					 {
						 array_push($dates,$dt->format('Y-m-d'));
					 }
					 array_push($dates,$end_date);
					 
					 
					 $data['dates'] = $dates;
					 //var_dump($data['dates']);exit;
					 
					 if(count($data['requested_users'])==0)
					 {
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = $arr_msg['attendance']['selemployee'];
					 }
					 
					else	 
					{if($_REQUEST['alignment'] == 'Horizontal')
							 {
							  $data['UsersLoginDetails'] = $employeeObject->getUsersLoginDetailsByUsers($start_date,$end_date,$user_string);
							  $data['alignment'] = 'Horizontal';
							 }
							 if($_REQUEST['alignment'] == 'Vertical')
							 {
								 $data['UsersLoginDetails'] = $employeeObject->getUsersLoginDetailsByInDate($start_date,$end_date,$user_string);
								 $data['UserwiseSeconds'] = $employeeObject->getTotalSecondsUserwise($start_date,$end_date,$user_string);
								 $data['alignment'] = 'Vertical';
							 }
							//var_dump($data['UsersLoginDetails']);exit;
					}
				}
				
			
			$page='manage_reports.php';
			break;
			
			case "my_report":
			$date = new DateTime();
				$date->sub(new DateInterval('P30D'));
				
				$start_date=$date->format('Y-m-d');
				$end_date=date('Y-m-d');
				
				
				if(isset($_REQUEST['is_post_back']) && $_REQUEST['is_post_back']=="TRUE"){
					if(isset($_REQUEST['start_date']) && $_REQUEST['start_date']!=''){
						$start_date=$_REQUEST['start_date'];
						$data['start_date']=$start_date;
					}
					if(isset($_REQUEST['end_date']) && $_REQUEST['start_date']!=''){
						$end_date=$_REQUEST['end_date'];
						$data['end_date']=$end_date;
					}
					
				}
				$data['report_details'] = $employeeObject->getReportDetails($start_date,$end_date,$_SESSION['user_id']);
				//var_dump($data['report_details']);exit;
				
			$page='my_report.php';
			break;
			
			case "approve_attendance":
			
				if(in_array($_SESSION['user_main_group'],$SUPER_LEVEL_ACCESS))
				{
					$data['nonApprovedAttendance'] = $employeeObject->getNonApproved(0);		
				}
				else{
					$data['nonApprovedAttendance'] = $employeeObject->getNonApproved($_SESSION['user_id']);	
				}
			//$data['nonApprovedAttendance'] = $employeeObject->getNonApproved($_SESSION['user_id']);
			$data['sickLeave'] = $SettingObject->getSickLeaveSetting();
			$data['casualLeave'] = $SettingObject->getCasualLeaveSetting();
			$data['paidLeave'] = $SettingObject->getPaidLeaveSetting();
			$data['leaveDetails'] = $employeeObject->getAllLeaves(0);
			$page = 'approve_attendance.php';
			break;
			
			case "update_approve":
			$approve = array();
			$attendance_id = $_REQUEST['edit_id'];
			$approve['attendance_id'] = $attendance_id;
			$approve['approved'] = 1;
			$employeeObject->update($approve,'attendance','attendance_id');
			if(in_array($_SESSION['user_main_group'],$SUPER_LEVEL_ACCESS))
				{
					$data['nonApprovedAttendance'] = $employeeObject->getNonApproved(0);		
				}
				else{
					$data['nonApprovedAttendance'] = $employeeObject->getNonApproved($_SESSION['user_id']);	
				}
			//$data['nonApprovedAttendance'] = $employeeObject->getNonApproved($_SESSION['user_id']);
			$page = 'approve_attendance.php';
			
			break;
			
			case "show_update_time":
			$data['attendance_id'] = $_REQUEST['edit_id'];
			$page = 'edit_time.php';
			break;
			
			case "update_time":
			//var_dump($_REQUEST['out_time']);exit;
			$data['attendance_id'] = $_REQUEST['edit_id'];
			$data['out_time'] = $_REQUEST['out_time'];
			$data['approved'] = 1;
			$employeeObject->update($data,'attendance','attendance_id');
			if(in_array($_SESSION['user_main_group'],$SUPER_LEVEL_ACCESS))
				{
					$data['nonApprovedAttendance'] = $employeeObject->getNonApproved(0);		
				}
				else{
					$data['nonApprovedAttendance'] = $employeeObject->getNonApproved($_SESSION['user_id']);	
				}
			//$data['nonApprovedAttendance'] = $employeeObject->getNonApproved($_SESSION['user_id']);
			$page = 'approve_attendance.php';
			break;
			/*** end of Attendance ***/
			
			/**** Apply for leave cases****/
			case "apply_for_leave":
				$page = "view_apply_leave.php";
			break;
			
			case "add_apply_leave":
				$employeeObject->getApplyLeaveVariables();
				$applyLeaveVariables = $employeeObject->db_fields;
				//print_r($applyLeaveVariables); exit;
				$from_day = strtotime($applyLeaveVariables['from_date']);
				$to_day = strtotime($applyLeaveVariables['to_date']);
				if(($from_day-$to_day) < 0)
				{
					$applyLeaveVariables['user_id']=$_SESSION['user_id'];
					$applyLeaveVariables['added_by']=$_SESSION['user_id'];
					$applyLeaveVariables['added_date']=date('Y-m-d H:i:s');
					
					$insertId = $employeeObject->insert($applyLeaveVariables,'applied_leaves');
					$applyLeaveVariables['current_leave_id'] = $insertId;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = $arr_msg['leave']['apply']; 
					$data['applyLeaveDetails'] = $employeeObject->getAllLeavesOfEmployee($applyLeaveVariables['user_id']);
					$page="manage_apply_leave.php";
				}else{
					$is_exist = true;
					$data['applyLeaveVariables'] = $applyLeaveVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['leave']['date_valid']; 
					$page = "view_apply_leave.php";
				}
				
				
			break;
			
			case"view_applied_leaves":
				$data['applyLeaveDetails'] = $employeeObject->getAllLeavesOfEmployee($_SESSION['user_id']);
				$page="manage_apply_leave.php";
			break;
			
			case "edit_apply_leave":
				$edit_id = $_REQUEST['edit_id'];
				$applyLeaveVariables = $employeeObject->getAppliedLeaveDetails($edit_id);
				$data['applyLeaveVariables'] = $applyLeaveVariables;
				$page="view_apply_leave.php";
			break;
			case "edit_applied_leave_entry":
				$employeeObject->getApplyLeaveVariables();
				$applyLeaveVariables = $employeeObject->db_fields;
				$from_day = strtotime($applyLeaveVariables['from_date']);
				$to_day = strtotime($applyLeaveVariables['to_date']);
				if(($from_day-$to_day) < 0)
				{
					$applyLeaveVariables['applied_leave_id'] = $_REQUEST['edit_id'];
					$applyLeaveVariables['modified_by']=$_SESSION['user_id'];
					$applyLeaveVariables['modified_date']=date('Y-m-d H:i:s');
					
					$employeeObject->update($applyLeaveVariables,'applied_leaves','applied_leave_id');
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Leave','update');
					$data['applyLeaveDetails'] = $employeeObject->getAllLeavesOfEmployee($_SESSION['user_id']);
					$page="manage_apply_leave.php";
				}else{
					$is_exist = true;
					$data['applyLeaveVariables'] = $applyLeaveVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['leave']['date_valid']; 
					$page = "view_apply_leave.php";	
				}
			break;
			
			case "delete_applied_leave":
				$applied_leave_id=$_REQUEST['edit_id'];
				$employeeObject->delete($applied_leave_id,'applied_leaves','applied_leave_id');
				$data['applyLeaveDetails'] = $employeeObject->getAllLeavesOfEmployee($_SESSION['user_id']);
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Leave','delete'); 
				$page="manage_apply_leave.php";
			break;
			
			case "view_approve_leaves":
				$user_id = $_SESSION['user_id'];
				if(in_array($_SESSION['user_main_group'],$SUPER_LEVEL_ACCESS))
				{
					$data['leaveDetails'] = $employeeObject->getAllLeaves(0);		
				}
				else{
					$data['leaveDetails'] = $employeeObject->getAllLeaves($user_id);	
				}
				$data['sickLeave'] = $SettingObject->getSickLeaveSetting();
				$data['casualLeave'] = $SettingObject->getCasualLeaveSetting();
				$data['paidLeave'] = $SettingObject->getPaidLeaveSetting();
				$page="manage_approve_leave.php";
			break;
			
			case "approve_applied_leave_ajax":
				$employee_id = $_REQUEST['leave_id'];
				$employeeObject->approvedAppliedLeaveOfEmployee($employee_id);
				$page="";
			break;
			case "reject_applied_leave_ajax":
				$employee_id = $_REQUEST['leave_id'];
				$reject_reason = $_POST['reject_reason'];
				$employeeObject->rejectAppliedLeaveOfEmployee($employee_id,htmlspecialchars($reject_reason));
				$page="";
			break;
			
			case "view_leaves_management":
				$sickLeave = $SettingObject->getSickLeaveSetting();
				$casualLeave = $SettingObject->getCasualLeaveSetting();
				$paidLeave = $SettingObject->getPaidLeaveSetting();
				$financial_start_month = $SettingObject->getFinancialStartMonth();
				$all_leaves_taken = $employeeObject->getAllLeaveTakenTillNow();
				
				$user_id = $_SESSION['user_id'];
				if(in_array($_SESSION['user_main_group'],$SUPER_LEVEL_ACCESS)){
					$allEmployee = $employeeObject->getAllEmployeeWithJoiningDate(0);
				}else{
					$allEmployee = $employeeObject->getAllEmployeeWithJoiningDate($user_id);
				}
				
				$financial_start_day="0000-00-00";
				if($financial_start_month < date('m')){
					$total_months = date('m') - $financial_start_month;
					$financial_start_day=date('Y')."-".$financial_start_month.'-01';
				}
				else
				{
					$total_months = date_diff(new DateTime(date('Y-m-d')),new DateTime((date('Y')-1)."-$financial_start_month-01"));
					$total_months=$total_months->m;
					$financial_start_day=(date('Y')-1)."-".$financial_start_month.'-01';
				}
				
				$allowed_sick_leave = $total_months*($sickLeave/12);// multiply this with (allowed leaves/12)
				//$allowed_casual_leave = $total_months*($casualLeave/12);
				$allowed_paid_leave = $total_months*($paidLeave/12);
				
				$timestamp_fm=strtotime($financial_start_day);
				$timestamp_cm=strtotime(date('Y-m-d'));
				
				$available_leaves_array = array();
				$all_leaves_taken_new = array();
				foreach($all_leaves_taken as $leave_taken){
					$all_leaves_taken_new[$leave_taken['user_id']][$leave_taken['leave_type']] = $leave_taken['leaves_taken'];
				}
				//print_r($all_leaves_taken_new); exit;
				foreach($allEmployee as $employee)
				{
					$timestamp_jm=strtotime($employee['joining_date']);
					$remaining_sick_leave = $allowed_sick_leave;
					$allowed_casual_leave = date_diff(new DateTime(date('Y-m-d')),new DateTime($employee['joining_date']));
					$allowed_casual_leave = $allowed_casual_leave->m;
					$remaining_casual_leave = $allowed_casual_leave;
					$remaining_paid_leave = $allowed_paid_leave;
					
					if($timestamp_jm<$timestamp_cm && $timestamp_jm>$timestamp_fm){
						$joining_month=substr($employee['joining_date'],5,2);
						if(substr($employee['joining_date'],-2)!=='01'){
							$joining_month=intval($joining_month)+1;
						}
						if($joining_month > $financial_start_month){
							$months_between = date_diff(new DateTime((date('Y'))."-$financial_start_month-01"),new DateTime($employee['joining_date']));
							$months_between = $months_between->m;
						}
						else{	
							$months_between = $financial_start_month - substr($employee['joining_date'],5,2);
						}
						
						$remaining_sick_leave = $allowed_sick_leave - $months_between;
						$remaining_casual_leave = $allowed_casual_leave;
						$remaining_paid_leave = $allowed_paid_leave - $months_between;
						//echo $employee['user_id']."[".$remaining_casual_leave."]";
					}
					//echo $employee['employee_name'];//exit;
					if(array_key_exists($employee['user_id'],$all_leaves_taken_new)){
						foreach($all_leaves_taken_new as $key=>$value)
						{
							if($employee['user_id'] == $key)
							{
								if(isset($value['sick'])){
									$available_leaves_array[$employee['employee_name']]['sick'] = $remaining_sick_leave - $value['sick'];
								}
								else
									$available_leaves_array[$employee['employee_name']]['sick'] = $allowed_sick_leave;
									
								if(isset($value['casual'])){
									$available_leaves_array[$employee['employee_name']]['casual'] = $remaining_casual_leave - $value['casual'];
								}
								else
									$available_leaves_array[$employee['employee_name']]['casual'] = $allowed_casual_leave;
									
								if(isset($value['paid'])){	
									$available_leaves_array[$employee['employee_name']]['paid'] = $remaining_paid_leave - $value['paid'];
								}
								else
									$available_leaves_array[$employee['employee_name']]['paid'] = $allowed_paid_leave;
							}
						}
					}
					else
					{
						$available_leaves_array[$employee['employee_name']]['sick'] = $allowed_sick_leave;
						$available_leaves_array[$employee['employee_name']]['casual'] = $allowed_casual_leave;
						$available_leaves_array[$employee['employee_name']]['paid'] = $allowed_paid_leave;	
					}
				}
				//print_r($available_leaves_array); exit;
				//$data['allowed_sick_leave'] = $allowed_sick_leave;
				//$data['allowed_casual_leave'] = $allowed_casual_leave; 
				//$data['allowed_paid_leave'] = $allowed_paid_leave;
				$data['available_leaves_array'] = $available_leaves_array;
				$page="manage_available_leaves.php";
			break;
			/**** End of apply for leave cases ****/
			
			case "manage_my_profile":
				$data['profile_details']=$userObject->getRecordById('user_id',$_SESSION['user_id']);
				$page="manage_my_profile.php";
			break;
			
			case "save_my_profile":
				$userObject->getUserVariables();
				$userVariables = $userObject->db_fields;
				$userVariables['user_id']=$_SESSION['user_id'];
				unset($userVariables['user_group']);
				
				$userPassword=$userVariables['user_password'];
				unset($userVariables['user_password']);
				$previousPass=$userObject->getUserPassword($userVariables['user_id']);
				$userVariables['modified_by']=$_SESSION['user_id'];
				$userVariables['modified_date']=date('Y-m-d H:i:s');
				$userObject->update($userVariables,'users','user_id');
				
				if(!(sha1($userPassword)===$previousPass)  && !(sha1($userPassword)===sha1('********'))){
					$userObject->setPassword($userPassword,$userVariables['user_id']);
				}
				$user_name = $userObject->getUserNameUsingId($_SESSION['user_id']);
				$userVariables['user_name'] = $user_name;
				setUserDetails($userVariables); // Update the seeion. Method is defined in loginManager.
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Profile Details','update');
				$data['profile_details']=$userVariables;
				$page="manage_my_profile.php";
			break;
			
			/*
				Candidates cases...
			*/
			case "view_candidates":
				$status = '0';
				$position = '0';
				
				if(isset($show_status))
						$show_status = $show_status;
				else
					$show_status = 1;
				$data['allCandidates'] = $employeeObject->getAllCandidates($show_status);
				$data['rec_counts'] = $employeeObject->candidate_counts();
				$data['allposition'] = $employeeObject->getAllpositions();
				$data['allstatus'] = $employeeObject->getAllstatus();
				$data['priority'] = $employeeObject->getHeighestPriority();
				
				if(isset($_REQUEST['is_post_back']) && $_REQUEST['is_post_back']=="TRUE"){
					
					if(isset($_REQUEST['status'])){
						$status = $_REQUEST['status'];
						$data['status']=$status;
					}
					if(isset($_REQUEST['position'])){
						$position = $_REQUEST['position'];
						$data['position']=$position;
					}
					$data['allCandidates'] = $employeeObject->getAllCandidates($show_status,$status,$position);
				}
				
				$data['current_show'] = $show_status;
				$page = "manage_candidates.php";
			break;
			
			case "show_add_candidate":				
				$data['allposition'] = $employeeObject->getAllpositions();
				$data['allstatus'] = $employeeObject->getAllstatus();
				$page = "add_edit_candidate.php";
			break;
			
						
			case "add_candidate":
				$upload_dir = "uploads";
				if(!is_dir($upload_dir."/resumes")){
					mkdir($upload_dir."/resumes");
				}
				
				$result = $employeeObject->getAutoIncrement();  /* This will return AUTO_INCREMENT value */
				//$allowedExts = array("pdf", "doc", "docx");
			    $file_name = explode(".", $_FILES["resume"]["name"]);
				$_FILES["resume"]["name"] = $file_name[0]."_".$result['Auto_increment'].".".$file_name[1];
				if(!(move_uploaded_file($_FILES["resume"]["tmp_name"], $upload_dir."/resumes/".$_FILES["resume"]["name"]))){
					
				}
				$employeeVariables = $employeeObject->getCandidateVariables();
				$employeeVariables['added_by'] = $_SESSION['user_id'];
				$employeeVariables['added_date'] = date('Y-m-d H:i:s');
				$employeeVariables['resume'] = $_FILES["resume"]["name"];
				$candidateIdInserted = $employeeObject->insertCandidate($employeeVariables);
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allCandidates'] = $employeeObject->getAllCandidates($show_status);
				$data['rec_counts'] = $employeeObject->candidate_counts();
				$data['allposition'] = $employeeObject->getAllpositions();
				$data['allstatus'] = $employeeObject->getAllstatus();
				$data['current_show'] = $show_status;
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('candidate','add');
				$page = "manage_candidates.php";					
			break;
			
			case "edit_candidate":	
					
				$data['allposition'] = $employeeObject->getAllpositions();
				$data['allstatus'] = $employeeObject->getAllstatus();
				$candidateId = $_REQUEST['edit_id'];				
				$candidateDetails = $employeeObject->getCandidateDetails($candidateId);
			    $data['candidateDetails'] = $candidateDetails;			
				$page = "add_edit_candidate.php";
			break;
			
			
			case "edit_candidate_entry":
				$old_resume = $_POST['old_resume'];
				
				$upload_dir = "uploads";
				if(!is_dir($upload_dir."/resumes")){
					mkdir($upload_dir."/resumes");
				}
				$employeeVariables = $employeeObject->getCandidateVariables();
				$employeeVariables['id'] = $_REQUEST['edit_id'];
				$employeeVariables['modified_by']=$_SESSION['user_id'];
				$employeeVariables['modified_date']=date('Y-m-d H:i:s');
				
				if($_FILES['resume']['name'] != ''){
					$file_name = explode(".", $_FILES["resume"]["name"]);
					$_FILES["resume"]["name"] = $file_name[0]."_".$employeeVariables['id'].".".$file_name[1];
					if($_FILES["resume"]["name"] != $old_resume){
						$employeeVariables['resume'] = $_FILES["resume"]["name"];
						unlink($upload_dir."/resumes/".$old_resume);
						if(!(move_uploaded_file($_FILES["resume"]["tmp_name"], $upload_dir."/resumes/".$_FILES["resume"]["name"]))){
						}
					}
				}
				
				$employeeObject->candidate_updateUsingId($employeeVariables);
				if(isset($show_status))
				$show_status = $show_status;
				else
					$show_status = 1;
				$data['allCandidates'] = $employeeObject->getAllCandidates($show_status);
				$data['rec_counts'] = $employeeObject->candidate_counts();
				$data['allposition'] = $employeeObject->getAllpositions();
				$data['allstatus'] = $employeeObject->getAllstatus();
				$data['current_show'] = $show_status;
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('candidate','update');
				$page = "manage_candidates.php";							
			break;
			
			case "delete_candidate":				
					$project_id=$_REQUEST['edit_id'];
					$employeeObject->candidate_deleteUsingId($project_id);
					if(isset($show_status))
					$show_status = $show_status;
					else
						$show_status = 1;
					$data['allCandidates'] = $employeeObject->getAllCandidates($show_status);
					$data['rec_counts'] = $employeeObject->candidate_counts();
					$data['allposition'] = $employeeObject->getAllpositions();
					$data['allstatus'] = $employeeObject->getAllstatus();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('candidate','delete');
					$page = "manage_candidates.php";	
			break;
			
			case "restore_candidate" :					
					$employeeObject->restore_candidate($edit_id);
					$data['allCandidates'] = $employeeObject->getAllCandidates($show_status);
					$data['rec_counts'] = $employeeObject->candidate_counts();
					$data['allposition'] = $employeeObject->getAllpositions();
					$data['allstatus'] = $employeeObject->getAllstatus();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('candidate','restore');
					$page = "manage_candidates.php";	
			break;
			
			case "change_priority":
				$id = $_POST['id'];
				$current_val = $_POST['current_val'];
				$employeeObject->updateCandidatePriority($id,$current_val);
				exit;
			break;
			
			case "download_resume":
				$file_name = $_POST['edit_id'];
				$file = "uploads/resumes/".$file_name;
				$mime_type = array("doc"=>"application/msword", "docx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.document", "pdf"=>"application/pdf");
				if (file_exists($file)) {
					header('Content-Description: File Transfer');
					header('Content-Type:' .$mime_type);
					header('Content-Disposition: attachment; filename='.basename($file));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					ob_clean();
					flush();
					readfile($file);
					exit;
				}
				exit;
		}
?>