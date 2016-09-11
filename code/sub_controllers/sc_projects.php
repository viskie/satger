<?php
require_once('library/userManager.php');
$userObject= new UserManager();
require_once('library/groupManager.php');
$groupObject= new GroupManager();
require_once('library/projectManager.php');
$projectObject = new ProjectManager();
require_once('library/clientManager.php');
$clientObject = new ClientManager();
require_once('library/accountsManager.php');
$acntObject = new AccountsManager();
require_once('library/categoryManager.php');
$categoryObject= new CategoryManager();
require_once('library/taskManager.php');
$taskObject= new TaskManager();
require_once('library/employeeManager.php');
$employeeObject= new EmployeeManager();

extract($_POST);
	switch($function){
			case "view":
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allProjects'] = $projectObject->getAllprojects($show_status);
					$data['projectcategoryDetails'] = $categoryObject->getAllProjectCategories(1);
					$data['rec_counts'] = $projectObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_projects.php";
			break;
			
			case "restore_project" :
					
					$projectObject->restore_project($edit_id);
					$data['allProjects'] = $projectObject->getAllprojects($show_status);
					$data['projectcategoryDetails'] = $categoryObject->getAllProjectCategories(1);
					$data['rec_counts'] = $projectObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('project','restore');
					$page = "manage_projects.php";	
			break;
			
			case "view_project":
					$data['clientDetails'] = $clientObject->getAllClients();
				
				$projectId = $_REQUEST['edit_id'];				
				$projectDetails = $projectObject->getProjectDetails($projectId);
				
				$incomePaymentDetails = $acntObject->getIncomePaymentById($projectId);
				$expensePaymentDetails = $acntObject->getExpensePaymentById($projectId);
				$data['incomePaymentDetails'] = $incomePaymentDetails;
				$data['expensePaymentDetails'] = $expensePaymentDetails;
				
			   $data['projectDetails'] = $projectDetails;				
				if($data['projectDetails']['project_cost_dollar']==='0'){
					$data['projectDetails']['project_cost_dollar']='';
				}
				if($data['projectDetails']['project_expense']==='0'){
					$data['projectDetails']['project_expense']='';
				}
				$page="add_edit_projects.php";
			break;
			
			case "show_add_project":
				$data['clientDetails'] = $clientObject->getAllClients(1);
				$data['projectcategoryDetails'] = $categoryObject->getAllProjectCategories(1);
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				$page = "add_edit_projects.php";
			break;
			
			case "add_project":
				$projectVariables = $projectObject->getProjectVariables();
				$projectVariables['added_by']=$_SESSION['user_id'];
				$projectVariables['added_date']=date('Y-m-d H:i:s');
				$projectIdInserted = $projectObject->insertProject($projectVariables);
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allProjects'] = $projectObject->getAllprojects($show_status);
					$data['rec_counts'] = $projectObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('project','add');
					$page = "manage_projects.php";								
					
			break;
			
			case "edit_project":
			
				$data['clientDetails'] = $clientObject->getAllClients(0);
				$data['projectcategoryDetails'] = $categoryObject->getAllProjectCategories(0);
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				$projectId = $_REQUEST['edit_id'];				
				$projectDetails = $projectObject->getProjectDetails($projectId);
			   $data['projectDetails'] = $projectDetails;				
				if($data['projectDetails']['project_cost_dollar']==='0'){
					$data['projectDetails']['project_cost_dollar']='';
				}
				if($data['projectDetails']['project_expense']==='0'){
					$data['projectDetails']['project_expense']='';
				}
//				echo "<pre>";print_r($data['projectDetails']);exit;			
				$page="add_edit_projects.php";
			break;
			
			
			case "edit_project_entry":
			
						$projectVariables = $projectObject->getProjectVariables();
						$projectVariables['project_id'] = $_REQUEST['edit_id'];
						$projectVariables['modified_by']=$_SESSION['user_id'];
						$projectVariables['modified_date']=date('Y-m-d H:i:s');
						$projectObject->updateUsingId($projectVariables);
						if(isset($show_status))
						$show_status = $show_status;
						else
							$show_status = 1;
						$data['allProjects'] = $projectObject->getAllprojects($show_status);
						$data['rec_counts'] = $projectObject->get_allcounts();
						$data['current_show'] = $show_status;
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('project','update');
						$page = "manage_projects.php";	
						
			break;
			
			case "delete_project":	
				
					$project_id=$_REQUEST['edit_id'];
					$projectObject->deleteUsingId($project_id);
					if(isset($show_status))
					$show_status = $show_status;
					else
						$show_status = 1;
					$data['allProjects'] = $projectObject->getAllprojects($show_status);
					$data['rec_counts'] = $projectObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('project','delete');
					$page="manage_projects.php";		
			break;
			
			/***** Cases of task management *******/
			case "view_task":
			case "view_team_task":
				$manager_id = '0';
				$task_status = '0';
				$date_to = '0000-00-00 00:00:00';
				$date_from = '0000-00-00 00:00:00';
				
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				
				if($_SESSION['user_main_group'] == 1){
					$employee_id = 0;
				}else{
					$employee_id = $employeeObject->getEmployeeIdUsingUserId($_SESSION['user_id']);
				}
				
				$is_employee_manager = $employeeObject->isEmployeeManager($employee_id);
				if($is_employee_manager == true)
					$data['is_employee_manager'] = 1;
				
				if($function == "view_task"){
					$data['task_function'] = 1;
					if($_SESSION['user_main_group'] == 1)
						$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,FALSE);
					else	
						$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,FALSE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,FALSE);	
				}else if($function == "view_team_task"){
					$data['task_function'] = 2;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,TRUE);	
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,TRUE);
				}
				//echo "<pre>";
				//print_r($data['allTasks']); exit;
				if(isset($_REQUEST['is_post_back']) && $_REQUEST['is_post_back']=="TRUE"){
					
					if($function == "view_team_task"){
						$manager_id = $employee_id;	
						$employee_id = 0;
					}
					//echo "---".$manager_id;exit;
					if(isset($_REQUEST['manager'])){
						$manager_id	= $_REQUEST['manager'];
						$data['manager_id']=$manager_id;
						$data['all_emp_of_manager'] = $employeeObject->getAllEmployeeOfManager($manager_id);
					}
					if(isset($_REQUEST['all_employee'])){
						$employee_id = $_REQUEST['all_employee'];
						$data['employee_id']=$employee_id;
					}
					if(isset($_REQUEST['task_status'])){
						$task_status = $_REQUEST['task_status'];
						$data['task_status']=$task_status;
					}
					if(isset($_REQUEST['from_assign']) && $_REQUEST['from_assign']!=''){
						$date_from=$_REQUEST['from_assign'];
						$data['date_from']=$date_from;
					}
					if(isset($_REQUEST['to_assign']) && $_REQUEST['to_assign']!=''){
						$date_to=$_REQUEST['to_assign'];
						$data['date_to']=$date_to;
					}
					
					$data['allTasks'] = $taskObject->getAllTasks($show_status,$manager_id,$employee_id,$task_status,$date_from,$date_to);
				}
				
				$data['all_managers'] = $employeeObject->getAllManager();
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus();
				
				$page = "manage_tasks.php";
			break;
			
			case "show_add_task":
				//print_r($_REQUEST);exit;
				$data['task_function'] = $_REQUEST['task_function'];
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				$data['allProjects'] = $projectObject->getAllProjects();
				$other = array('project_id'=>'-1','project_name'=>'Other');
				array_push($data['allProjects'],$other);
				//echo "<pre>"; print_r($data['allProjects']); exit;
				$data['all_managers'] = $employeeObject->getAllManager();
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus();
				$page = "add_edit_task.php";
			break;
			
			case "add_team_task":
			case "add_task":
				$taskObject->getTaskVariables();
				$taskVariables = $taskObject->db_fields;
				$taskVariables['added_by']=$_SESSION['user_id'];
				$taskVariables['added_date']=date('Y-m-d H:i:s');
				$taskVariables['task_status']=1;
				//print_r($taskVariables); exit;
				if($_SESSION['user_main_group'] == 1){
					$employee_id = 0;
				}else{
					$employee_id = $employeeObject->getEmployeeIdUsingUserId($_SESSION['user_id']);
				}
				//$employee_id = 1;
				$is_employee_manager = $employeeObject->isEmployeeManager($employee_id);
				if($is_employee_manager == true)
					$data['is_employee_manager'] = 1;
				
				if($taskVariables['project_id'] != '-1'){
					$taskVariables['manager_id'] = $projectObject->getManagerOfProject($taskVariables['project_id']);
				}else{
					$taskVariables['manager_id'] = $_POST['manager_id'];	
				}
				
				$task_id = $taskObject->insert($taskVariables,'task');
				if($task_id != 0) // return 0 if the insert query does not generate an AUTO_INCREMENT value
				{
					$user_name = $employeeObject->getEmployeeNameUsingUesrId($_SESSION['user_id']);
					$email_id = $taskObject->getEmailIdOfEmployee($taskVariables['employee_id']);
					$insertedTaskDetails = $taskObject->getInsertedTaskDetails($task_id);
					//print_r($insertedTaskDetails); exit;
					$from="admin@satger.com";
					$reply_to="admin@satger.com";
					$subject = $insertedTaskDetails['PROJECT_NAME'].' task : ';
					if(strlen($insertedTaskDetails['title']) > 20){
						$subject .= substr($insertedTaskDetails['title'],0,20);
						$subject .= '...';
					}else{
						$subject .= $insertedTaskDetails['title'];
					}
					$to=$email_id;
					//echo $subject; exit;
					
					$field_array = array('Manager','Employee','Assigned Date','Start Date','Expected Complition Date','Actual Complition Date','Status','Title','Task Details','Remark','Priority');
					if($insertedTaskDetails['task_priority'] == 1)
						$insertedTaskDetails['task_priority'] = "Urgent";
					if($insertedTaskDetails['task_priority'] == 2)
						$insertedTaskDetails['task_priority'] = "High";
					if($insertedTaskDetails['task_priority'] == 3)
						$insertedTaskDetails['task_priority'] = "Moderate";
					if($insertedTaskDetails['task_priority'] == 4)
						$insertedTaskDetails['task_priority'] = "Low";
					$data_array = array($insertedTaskDetails['MANAGER_NAME'],$insertedTaskDetails['EMP_NAME'],$insertedTaskDetails['assigned_date'],$insertedTaskDetails['start_date'],$insertedTaskDetails['expected_complition_date'],$insertedTaskDetails['actual_complition_date'],$insertedTaskDetails['TASK_STATUS_NAME'],$insertedTaskDetails['title'],$insertedTaskDetails['task_details'],$insertedTaskDetails['remark'],$insertedTaskDetails['task_priority']);
					
					sendMail($from,$reply_to,$to,$subject,$field_array,$data_array,$function,$user_name);
				}
				
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus();
				//$data['rec_counts'] = $taskObject->get_all_taskcounts($employee_id);
				$data['all_managers'] = $employeeObject->getAllManager();
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('task','add');
				
				if($function == "add_task"){
					$data['task_function'] = 1;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,FALSE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,FALSE);
				}else if($function == "add_team_task"){
					$data['task_function'] = 2;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,TRUE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,TRUE);
				}
				$page="manage_tasks.php";
			break;
			
			case "edit_task":
				//print_r($_REQUEST); exit;
				$data['task_function'] = $_REQUEST['task_function'];
				$task_id = $_REQUEST['edit_id'];
				$taskDetails = $taskObject->getTaskById($task_id);
				$data['taskDetails'] = $taskDetails;
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				
				$data['allProjects'] = $projectObject->getAllProjects();
				$other = array('project_id'=>'-1','project_name'=>'Other');
				array_push($data['allProjects'],$other);
				
				$data['all_managers'] = $employeeObject->getAllManager();
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus();
				$data['emp_of_managers'] = $employeeObject->getAllEmployeeOfManager($taskDetails['manager_id']);
				//print_r($taskDetails);exit;
				$page = "add_edit_task.php";
			break;
			
			case "edit_task_entry":
			case "edit_team_task_entry":
				//print_r($_REQUEST); exit;
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
					
				$task_id = $_REQUEST['edit_id'];
				$old_task_status = $taskObject->getOldTaskStatus($task_id);
				$taskObject->getTaskVariables();
				$taskVariables = $taskObject->db_fields;
				
				$taskVariables['task_id'] = $task_id;
				$taskVariables['modified_by']=$_SESSION['user_id'];
				$taskVariables['modified_date']=date('Y-m-d H:i:s');
				$taskVariables['manager_id'] = $taskObject->getManagerIdFromTaskId($task_id);
				$taskVariables['project_id'] = $taskObject->getProjectIdFromTaskId($task_id);
				//print_r($taskVariables);exit;
				if($_SESSION['user_main_group'] == 1){
					$employee_id = 0;
				}else{
					$employee_id = $employeeObject->getEmployeeIdUsingUserId($_SESSION['user_id']);
				}
				//$employee_id = 1;
				$is_employee_manager = $employeeObject->isEmployeeManager($employee_id);
				if($is_employee_manager == true)
					$data['is_employee_manager'] = 1;
					
				$taskObject->update($taskVariables,"task","task_id");
				//print_r($taskDetails);echo"----";print_r($taskVariables);
				/* below if checkes wether task status get changed or not. If changed then send mail to manager */
				$taskDetails = $taskObject->getInsertedTaskDetails($task_id);
				if($old_task_status != $taskVariables['task_status']){
					$user_name = $employeeObject->getEmployeeNameUsingUesrId($_SESSION['user_id']);
					$email_id = $taskObject->getEmailIdOfEmployee($taskVariables['manager_id']);
					$from="admin@satger.com";
					$reply_to="admin@satger.com";
					$subject = $taskDetails['PROJECT_NAME'].' task : ';
					if(strlen($taskDetails['title']) > 20){
						$subject .= substr($taskDetails['title'],0,20);
						$subject .= '...';
					}else{
						$subject .= $taskDetails['title'];	
					}
					$to=$email_id;
					
					$field_array = array('Manager','Employee','Assigned Date','Start Date','Expected Complition Date','Actual Complition Date','Status','Title','Task Details','Remark','Priority');
					if($taskDetails['task_priority'] == 1)
						$taskDetails['task_priority'] =  "Urgent";
					if($taskDetails['task_priority'] == 2)
						$taskDetails['task_priority'] =  "High";
					if($taskDetails['task_priority'] == 3)
						$taskDetails['task_priority'] =  "Moderate";
					if($taskDetails['task_priority'] == 4)
						$taskDetails['task_priority'] =  "Low";
					$data_array = array($taskDetails['MANAGER_NAME'],$taskDetails['EMP_NAME'],$taskDetails['assigned_date'],$taskDetails['start_date'],$taskDetails['expected_complition_date'],$taskDetails['actual_complition_date'],$taskDetails['TASK_STATUS_NAME'],$taskDetails['title'],$taskDetails['task_details'],$taskDetails['remark'],$taskDetails['task_priority']);
					
					sendMail($from,$reply_to,$to,$subject,$field_array,$data_array,$function,$user_name);	
				}
				
				$data['all_managers'] = $employeeObject->getAllManager();
				//$data['rec_counts'] = $taskObject->get_all_taskcounts($employee_id);
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus();
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('task','update');
				
				if($function == "edit_task_entry"){
					$data['task_function'] = 1;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,FALSE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,FALSE);
				}else if($function == "edit_team_task_entry"){
					
					$data['task_function'] = 2;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,TRUE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,TRUE);
				}
				$page = "manage_tasks.php";
			break;
			
			case "delete_task":
			case "delete_team_task":
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				
				if($_SESSION['user_main_group'] == 1){
					$employee_id = 0;
				}else{
					$employee_id = $employeeObject->getEmployeeIdUsingUserId($_SESSION['user_id']);
				}
				//$employee_id = 1;
				$is_employee_manager = $employeeObject->isEmployeeManager($employee_id);
				if($is_employee_manager == true)
					$data['is_employee_manager'] = 1;
						
				$task_id=$_REQUEST['edit_id'];
				$taskObject->delete($task_id,'task','task_id');
				//$data['rec_counts'] = $taskObject->get_all_taskcounts($employee_id);
				$data['all_managers'] = $employeeObject->getAllManager();
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('task','delete'); 
				if($function == "delete_task"){
					$data['task_function'] = 1;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,FALSE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,FALSE);
				}else if($function == "delete_team_task"){
					$data['task_function'] = 2;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,TRUE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,TRUE);
				}
				$page="manage_tasks.php";
			break;
			
			case "restore_task" :
			case "restore_team_task":
				if($_SESSION['user_main_group'] == 1){
					$employee_id = 0;
				}else{
					$employee_id = $employeeObject->getEmployeeIdUsingUserId($_SESSION['user_id']);
				}
				//$employee_id = 1;
				$is_employee_manager = $employeeObject->isEmployeeManager($employee_id);
				if($is_employee_manager == true)
					$data['is_employee_manager'] = 1;
					
				$task_id=$_REQUEST['edit_id'];
				$taskObject->restore_task($task_id);
				$show_status = 1;
				
				//$data['rec_counts'] = $taskObject->get_all_taskcounts($employee_id);
				$data['all_managers'] = $employeeObject->getAllManager();
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('task','restore');
				if($function == "restore_task"){
					$data['task_function'] = 1;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,FALSE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,FALSE);
				}else if($function == "restore_team_task"){
					$data['task_function'] = 2;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,TRUE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,TRUE);
				}
				$page = "manage_tasks.php";	
			break;
			
			
			case "mark_as_complete":
			case "mark_as_complete_team":
				if($_SESSION['user_main_group'] == 1){
					$employee_id = 0;
				}else{
					$employee_id = $employeeObject->getEmployeeIdUsingUserId($_SESSION['user_id']);
				}
				//$employee_id = 1;
				$is_employee_manager = $employeeObject->isEmployeeManager($employee_id);
				if($is_employee_manager == true)
					$data['is_employee_manager'] = 1;
					
				$task_id = $_REQUEST['edit_id'];
				$taskObject->markAsCompleteTask($task_id);
				
				$taskDetails = $taskObject->getInsertedTaskDetails($task_id);
				$email_id = $taskObject->getEmailIdOfEmployee($taskDetails['manager_id']);
				$user_name = $employeeObject->getEmployeeNameUsingUesrId($_SESSION['user_id']);
				$from="admin@satger.com";
				$reply_to="admin@satger.com";
				$subject = $taskDetails['PROJECT_NAME'].' task : ';
				if(strlen($taskDetails['title']) > 20){
					$subject .= substr($taskDetails['title'],0,20);
					$subject .= '...';
				}else{
					$subject .= $taskDetails['title'];	
				}
				$to=$email_id;
				
				$field_array = array('Manager','Employee','Assigned Date','Start Date','Expected Complition Date','Actual Complition Date','Status','Title','Task Details','Remark','Priority');
				
				if($taskDetails['task_priority'] == 1)
					$taskDetails['task_priority'] =  "Urgent";
				if($taskDetails['task_priority'] == 2)
					$taskDetails['task_priority'] =  "High";
				if($taskDetails['task_priority'] == 3)
					$taskDetails['task_priority'] = "Moderate";
				if($taskDetails['task_priority'] == 4)
					$taskDetails['task_priority'] =  "Low";
				$data_array = array($taskDetails['MANAGER_NAME'],$taskDetails['EMP_NAME'],$taskDetails['assigned_date'],$taskDetails['start_date'],$taskDetails['expected_complition_date'],$taskDetails['actual_complition_date'],$taskDetails['TASK_STATUS_NAME'],$taskDetails['title'],$taskDetails['task_details'],$taskDetails['remark'],$taskDetails['task_priority']);
				
				sendMail($from,$reply_to,$to,$subject,$field_array,$data_array,$function,$user_name);
				
				if($_SESSION['user_main_group'] == 1)
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,FALSE);
				else
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,FALSE);
				//$data['rec_counts'] = $taskObject->get_all_taskcounts($employee_id);
				$data['all_managers'] = $employeeObject->getAllManager();
				$data['allEmployees'] = $employeeObject->getAllCurrentEmployee();
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = "Task completed!";
				if($function == "mark_as_complete"){
					$data['task_function'] = 1;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,FALSE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,FALSE);
				}else if($function == "mark_as_complete_team"){
					$data['task_function'] = 2;
					$data['allTasks'] = $taskObject->getAllActiveTasks($show_status,$employee_id,TRUE);
					$data['rec_counts'] = $taskObject->get_all_taskcounts($show_status,$employee_id,TRUE);
				}
				$page = "manage_tasks.php";	
			break;
			
			case "mark_as_complete_ajax":
				$task_id = $_POST['task_id'];
				$task_status_id = $_POST['task_status_id'];
				if($task_status_id == 999){
					$taskObject->markAsCompleteTask($task_id); // while editing any task if task status changes to "Task Completed"
				}else{
					$taskObject->changeStatusOfTask($task_id);
				}
				exit;
			break;
			/***** END cases of task management *******/
		}
?>
