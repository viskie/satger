<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

//require_once('Config.php');

class TaskManager extends commonObject
{
	public $db_fields;
	function TaskManager()
	{
		//$this->table_name = "task";
		$this->db_fields = array();	
	}
	
	function getAllTasks($show_status='1',$manager_id='0',$employee_id='0',$task_status='0',$date_from='0000-00-00 00:00:00',$date_to='0000-00-00 00:00:00')
	{
		//echo "mi".$manager_id."---ei".$employee_id."---task_stat:".$task_status;
		$where="";
		if($show_status !='0' || $manager_id != '0' || $employee_id != '0' || $task_status != '0' || $date_from != '0000-00-00 00:00:00' || $date_to != '0000-00-00 00:00:00'){
			$where = "WHERE ";	
		}
		
		if($show_status != '0'){
			if($show_status == 1)
				$where.= "TASK.is_active=1";	
			if($show_status == 2)
				$where.= "TASK.is_active=0";		
		}
		
		if($date_from!='0000-00-00 00:00:00' && $date_to!='0000-00-00 00:00:00'){
			if(strpos($where,'TASK.is_active')!==FALSE){
				$where.=" AND ";
			}
			$where.="TASK.assigned_date BETWEEN '".$date_from."' AND '".$date_to."'";
		}else if($date_from!='0000-00-00 00:00:00' && $date_to=='0000-00-00 00:00:00'){
			if(strpos($where,'TASK.is_active')!==FALSE){
				$where.=" AND ";
			}
			$where.="TASK.assigned_date > '".$date_from."'";
		}else if($date_from=='0000-00-00 00:00:00' && $date_to!='0000-00-00 00:00:00'){
			if(strpos($where,'TASK.is_active')!==FALSE){
				$where.=" AND ";
			}
			$where.="TASK.assigned_date < '".$date_to."'";
		}
		
		if($manager_id != '0'){
			if(strpos($where,'TASK.assigned_date')!==FALSE || strpos($where,'TASK.is_active')!==FALSE){
				$where.=" AND ";
			}
			$where.="TASK.manager_id='".$manager_id."'";
		}
		
		if($employee_id != '0'){
			if(strpos($where,'TASK.assigned_date')!==FALSE || strpos($where,'TASK.manager_id')!==FALSE || strpos($where,'TASK.is_active')!==FALSE){
				$where.=" AND ";
			}
			$where.="TASK.employee_id='".$employee_id."'";
		}
		
		if($task_status != '0'){
			if(strpos($where,'TASK.assigned_date')!==FALSE || strpos($where,'TASK.manager_id')!==FALSE || strpos($where,'TASK.employee_id')!==FALSE ||strpos($where,'TASK.is_active')!==FALSE){
				$where.=" AND ";
			}
			$where.="TASK.task_status='".$task_status."'";
		}
		//echo $where; exit;
		if($show_status == 0){
			$resultSet = getData("SELECT TASK.*,  PROJECTS.PROJECT_NAME, MANAGER.MANAGER_NAME, EMPLOYEE.EMP_NAME, TASK_STATUS.TASK_STATUS_NAME from task AS TASK 
								LEFT JOIN (SELECT employee_id, employee_name AS EMP_NAME FROM employee WHERE 1) as EMPLOYEE 
								ON TASK.employee_id = EMPLOYEE.employee_id LEFT JOIN 
								(SELECT employee_id, employee_name AS MANAGER_NAME FROM  employee  WHERE 1) as MANAGER 
								ON TASK.manager_id = MANAGER .employee_id LEFT JOIN  
								(SELECT project_id,project_name as PROJECT_NAME FROM projects WHERE 1) as PROJECTS 
								ON TASK.project_id = PROJECTS.project_id  LEFT JOIN
								(SELECT task_status_id,task_status_name as TASK_STATUS_NAME FROM task_status WHERE 1) as TASK_STATUS
								ON TASK.task_status = TASK_STATUS.task_status_id ".$where." ORDER BY TASK.assigned_date desc");
							
	
		}else if($show_status == 1){
			$resultSet = getData("SELECT TASK.*,  PROJECTS.PROJECT_NAME, MANAGER.MANAGER_NAME, EMPLOYEE.EMP_NAME, TASK_STATUS.TASK_STATUS_NAME from task AS TASK 
								LEFT JOIN (SELECT employee_id, employee_name AS EMP_NAME FROM employee WHERE 1) as EMPLOYEE 
								ON TASK.employee_id = EMPLOYEE.employee_id LEFT JOIN 
								(SELECT employee_id, employee_name AS MANAGER_NAME FROM  employee  WHERE 1) as MANAGER 
								ON TASK.manager_id = MANAGER .employee_id LEFT JOIN  
								(SELECT project_id,project_name as PROJECT_NAME FROM projects WHERE 1) as PROJECTS 
								ON TASK.project_id = PROJECTS.project_id  LEFT JOIN
								(SELECT task_status_id,task_status_name as TASK_STATUS_NAME FROM task_status WHERE 1) as TASK_STATUS
								ON TASK.task_status = TASK_STATUS.task_status_id ".$where." ORDER BY TASK.assigned_date desc");
			
		}else if($show_status == 2){
			$resultSet = getData("SELECT TASK.*,  PROJECTS.PROJECT_NAME, MANAGER.MANAGER_NAME, EMPLOYEE.EMP_NAME, TASK_STATUS.TASK_STATUS_NAME from task AS TASK 
								LEFT JOIN (SELECT employee_id, employee_name AS EMP_NAME FROM employee WHERE 1) as EMPLOYEE 
								ON TASK.employee_id = EMPLOYEE.employee_id LEFT JOIN 
								(SELECT employee_id, employee_name AS MANAGER_NAME FROM  employee  WHERE 1) as MANAGER 
								ON TASK.manager_id = MANAGER .employee_id LEFT JOIN  
								(SELECT project_id,project_name as PROJECT_NAME FROM projects WHERE 1) as PROJECTS 
								ON TASK.project_id = PROJECTS.project_id  LEFT JOIN
								(SELECT task_status_id,task_status_name as TASK_STATUS_NAME FROM task_status WHERE 1) as TASK_STATUS
								ON TASK.task_status = TASK_STATUS.task_status_id ".$where." ORDER BY TASK.assigned_date desc");
			
		}
		return $resultSet;
	}
	
	function getAllActiveTasks($show_status='1',$employee_id,$is_manager)
	{
		if($employee_id != 0){
			if($is_manager == TRUE)
				$condition = ' AND TASK.manager_id ='.$employee_id;
			if($is_manager == FALSE)
				$condition = ' AND TASK.employee_id ='.$employee_id;
		}else{
			$condition = '';
		}
		
		if($show_status == 0){
			$resultSet = getData("SELECT TASK.*,  PROJECTS.PROJECT_NAME, MANAGER.MANAGER_NAME, EMPLOYEE.EMP_NAME, TASK_STATUS.TASK_STATUS_NAME from task AS TASK 
								LEFT JOIN (SELECT employee_id, employee_name AS EMP_NAME FROM employee WHERE 1) as EMPLOYEE 
								ON TASK.employee_id = EMPLOYEE.employee_id LEFT JOIN 
								(SELECT employee_id, employee_name AS MANAGER_NAME FROM  employee  WHERE 1) as MANAGER
								ON TASK.manager_id = MANAGER .employee_id LEFT JOIN
								(SELECT project_id,project_name as PROJECT_NAME FROM projects WHERE 1) as PROJECTS 
								ON TASK.project_id = PROJECTS.project_id  LEFT JOIN
								(SELECT task_status_id,task_status_name as TASK_STATUS_NAME FROM task_status WHERE 1) as TASK_STATUS
								ON TASK.task_status = TASK_STATUS.task_status_id WHERE TASK.actual_complition_date='0000-00-00 00:00:00' ".$condition." ORDER BY assigned_date desc");
		}else if($show_status == 1){
			$resultSet = getData("SELECT TASK.*,  PROJECTS.PROJECT_NAME, MANAGER.MANAGER_NAME, EMPLOYEE.EMP_NAME, TASK_STATUS.TASK_STATUS_NAME from task AS TASK 
								LEFT JOIN (SELECT employee_id, employee_name AS EMP_NAME FROM employee WHERE 1) as EMPLOYEE 
								ON TASK.employee_id = EMPLOYEE.employee_id LEFT JOIN 
								(SELECT employee_id, employee_name AS MANAGER_NAME FROM  employee  WHERE 1) as MANAGER 
								ON TASK.manager_id = MANAGER .employee_id LEFT JOIN  
								(SELECT project_id,project_name as PROJECT_NAME FROM projects WHERE 1) as PROJECTS 
								ON TASK.project_id = PROJECTS.project_id  LEFT JOIN
								(SELECT task_status_id,task_status_name as TASK_STATUS_NAME FROM task_status WHERE 1) as TASK_STATUS
								ON TASK.task_status = TASK_STATUS.task_status_id
								WHERE TASK.actual_complition_date='0000-00-00 00:00:00' AND TASK.is_active=1 ".$condition." ORDER BY assigned_date desc");
								
		}else if($show_status == 2){
			$resultSet = getData("SELECT TASK.*,  PROJECTS.PROJECT_NAME, MANAGER.MANAGER_NAME, EMPLOYEE.EMP_NAME, TASK_STATUS.TASK_STATUS_NAME from task AS TASK 
								LEFT JOIN (SELECT employee_id, employee_name AS EMP_NAME FROM employee WHERE 1) as EMPLOYEE 
								ON TASK.employee_id = EMPLOYEE.employee_id LEFT JOIN 
								(SELECT employee_id, employee_name AS MANAGER_NAME FROM  employee  WHERE 1) as MANAGER 
								ON TASK.manager_id = MANAGER .employee_id LEFT JOIN  
								(SELECT project_id,project_name as PROJECT_NAME FROM projects WHERE 1) as PROJECTS 
								ON TASK.project_id = PROJECTS.project_id  LEFT JOIN
								(SELECT task_status_id,task_status_name as TASK_STATUS_NAME FROM task_status WHERE 1) as TASK_STATUS
								ON TASK.task_status = TASK_STATUS.task_status_id 
								WHERE TASK.actual_complition_date='0000-00-00 00:00:00' AND TASK.is_active=0 ".$condition." ORDER BY assigned_date desc");
		}
		return $resultSet;
	}
	
	function getInsertedTaskDetails($task_id){
		$resultSet = getRow("SELECT TASK.*,  PROJECTS.PROJECT_NAME, MANAGER.MANAGER_NAME, EMPLOYEE.EMP_NAME, TASK_STATUS.TASK_STATUS_NAME from task AS TASK 
								LEFT JOIN (SELECT employee_id, employee_name AS EMP_NAME FROM employee WHERE 1) as EMPLOYEE 
								ON TASK.employee_id = EMPLOYEE.employee_id LEFT JOIN
								(SELECT employee_id, employee_name AS MANAGER_NAME FROM employee  WHERE 1) as MANAGER 
								ON TASK.manager_id = MANAGER .employee_id LEFT JOIN
								(SELECT project_id,project_name as PROJECT_NAME FROM projects WHERE 1) as PROJECTS 
								ON TASK.project_id = PROJECTS.project_id  LEFT JOIN
								(SELECT task_status_id,task_status_name as TASK_STATUS_NAME FROM task_status WHERE 1) as TASK_STATUS
								ON TASK.task_status = TASK_STATUS.task_status_id WHERE TASK.task_id='".$task_id."'");
		return $resultSet;
	}
	
	function get_all_taskcounts($show_status='1',$employee_id,$is_manager)
	{
		if($employee_id != 0){
			if($is_manager == TRUE)
				$condition = ' AND manager_id ='.$employee_id;
			if($is_manager == FALSE)
				$condition = ' AND employee_id ='.$employee_id;
		}else{
			$condition = '';
		}
				
		$arr_counts = array();
		$all = getOne("SELECT COUNT(task_id) AS CNT From task WHERE 1 and actual_complition_date='0000-00-00 00:00:00' ".$condition."");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(task_id) AS CNT From task WHERE is_active = 1 AND actual_complition_date='0000-00-00 00:00:00' ".$condition."");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(task_id) AS CNT From task WHERE is_active = 0 AND actual_complition_date='0000-00-00 00:00:00' ".$condition."");
		$arr_counts['trash'] = $trash;
		return $arr_counts;
	}
	
	/*function get_all_taskcounts($employee_id,$function='')
	{
		$condition = '';
		
		if($employee_id != 0)
			$condition = ' employee_id='.$employee_id;
		
		if($function!='')
		{
			if(strpos($condition,'employee_id')!==FALSE){
				$condition.=" AND ";
			}
			if($function == "view_task")
				$condition.="actual_complition_date='0000-00-00 00:00:00' ";
		}
		
		if ($condition == '')
			$condition = '1';
					
		$arr_counts = array();
		$all = getOne("SELECT COUNT(task_id) AS CNT From task WHERE ".$condition."");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(task_id) AS CNT From task WHERE  ".$condition." AND is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(task_id) AS CNT From task WHERE ".$condition." AND is_active = 0 ");
		$arr_counts['trash'] = $trash;
		return $arr_counts;
		
	}*/
	
	/* to maitain auto increament we need to fetch 2nd last */
	function getSecondLastInsertedId(){
		return getOne("SELECT `task_status_id` FROM `task_status` order by `task_status_id` desc limit 1,1");	
	}
	
	function getTaskById($task_id)
	{
		$resultSet = getRow("select task.*, employee_name from task left join employee on task.manager_id=employee.employee_id where task_id='".$task_id."' and task.is_active=1");
		return $resultSet;	
	}
	
	function getEmailIdOfEmployee($employee_id)
	{
		return getOne("select company_email from employee where employee_id='".$employee_id."'");
	}
	
	function getManagerIdFromTaskId($task_id)
	{
		return getOne("select manager_id from task where task_id='".$task_id."'");	
	}
	
	function getProjectIdFromTaskId($task_id)
	{
		return getOne("select project_id from task where task_id='".$task_id."'");	
	}
	function getOldTaskStatus($task_id)
	{
		return getOne("select task_status from task where task_id='".$task_id."'");		
	}
	function restore_task($id)
	{
		$change_data = array (
								'is_active' => 1,							
								); 
		$change_data['task_id'] = $id;
		$updateQry=$this->getUpdateDataString($change_data,"task","task_id");
		updateData($updateQry);
		
	}
	
	function markAsCompleteTask($task_id)
	{
		updateData("UPDATE task SET task_status='999', actual_complition_date=NOW() WHERE task_id='".$task_id."'");	
	}
	
	function changeStatusOfTask($task_id)
	{
		updateData("UPDATE task SET actual_complition_date='0000-00-00 00:00:00' WHERE task_id='".$task_id."'");	
	}
	
	function getTaskVariables()
	{
		if(isset($_POST['project']))
			$this->db_fields['project_id'] = $_POST['project'];
		//$this->db_fields['manager_id'] = $_POST['manager_id'];
		$this->db_fields['employee_id'] = $_POST['employee_id'];
		$this->db_fields['assigned_date'] = $_POST['assigned_date'];
		$this->db_fields['start_date'] = $_POST['task_start_date'];
		$this->db_fields['expected_complition_date'] = $_POST['expected_complition_date'];
		//$this->db_fields['actual_complition_date'] = $_POST['actual_complition_date'];
		if(isset($_POST['task_status']))
			$this->db_fields['task_status'] = $_POST['task_status'];
		$this->db_fields['title'] = $_POST['title'];
		$this->db_fields['task_details'] = $_POST['task'];
		$this->db_fields['remark'] = $_POST['remark'];
		$this->db_fields['task_priority'] = $_POST['task_priority'];
	}
	
	function getAllTaskStatus($show_status='1')
	{
		if($show_status == 0)
			$arr_orders =  getData("select * from `task_status` ");
		elseif($show_status == 1)
			$arr_orders =  getData("select * from `task_status` where is_active=1");
		elseif($show_status == 2)
			$arr_orders =  getData("select * from `task_status` where is_active=0");
		return $arr_orders;	
	}
	
	function get_allcounts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(task_status_id) AS CNT From task_status WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(task_status_id) AS CNT From task_status WHERE is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(task_status_id) AS CNT From task_status WHERE is_active = 0");
		$arr_counts['trash'] = $trash;
		return $arr_counts;
		
	}
	
	function insertTaskStatus($varArray)
	{
		$insertQry = $this->getInsertDataString($varArray, 'task_status');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	//To restrict duplicate in task status.
	function isTaskStatusExist($task_status_name,$task_status_id=0){
		$query="select * from task_status where task_status_name='".$task_status_name."' and is_active=1";
		if($task_status_id!=0){
			$query.=" AND task_status_id!=".$task_status_id;
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	function getTaskStatusDetails($task_status_id)
	{
		return $resultSet = getRow("select * from  `task_status` where is_active =1 AND task_status_id='".$task_status_id."'");
	}
	
	function updateUsingId($dataArray){
		$updateQry=$this->getUpdateDataString($dataArray,"task_status","task_status_id");
		updateData($updateQry);
	}
	
	function deleteUsingId($task_status_id){
		updateData("UPDATE `task_status` SET `is_active`=0 WHERE `task_status_id`='".$task_status_id."'");
	}
	
	function restore_task_status($id)
	{
		$change_data = array (
								'is_active' => 1,							
								); 
		$change_data['task_status_id'] = $id;
		$updateQry=$this->getUpdateDataString($change_data,"task_status","task_status_id");
		updateData($updateQry);
		
	}
	
	function getTaskStatusVariables()
	{
		$varArray['task_status_name'] = $_REQUEST['task_status_name'];
		return $varArray;
	}
}
?>