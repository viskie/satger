<?php
	require_once('cron_config.php');
	
	$query = "select employee_id,employee_name from employee where is_active=1 and employee_status=1";
	$employee_id = mysql_query($query);
	
	$from="updates@satger.com";
	$reply_to="vishak@satger.com";
	$subject = 'Updates['.date('d-m-Y').']';
	$to="vishak@satger.com,aroon@satger.com";
	//$to="Vishak Nair.c@satger.com";
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $reply_to . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$message1 = ''; /* message for admin mail */
	$width_style = "";
	function formatDateTime($date)
	{
		if($date=="0000-00-00 00:00:00"){
			return "-";
		}else{
			return date("d-M-Y h:i A", strtotime($date));
		}
	}
	
	while($id = mysql_fetch_array($employee_id,MYSQL_ASSOC))
	{
		$query3 = "select company_email from employee where employee_id='".$id['employee_id']."'";
		$result = mysql_query($query3);
		$data = mysql_fetch_array($result,MYSQL_ASSOC);
		$employee_email = $data['company_email'];
		
		$query4 = "select distinct(employee_id) from task where manager_id='".$id['employee_id']."' and task_status!=999";
		$result1 = mysql_query($query4);
		$count = mysql_num_rows($result1); 
		$message2 = ''; /* message for project manager mail */
		if($count > 0){
			while($tasks = mysql_fetch_array($result1,MYSQL_ASSOC))
			{
				$message2 .=  get_all_task($tasks['employee_id'],$id['employee_id']);
			}
			$manager_subject = 'Team Task['.date('d-m-Y').']';
			mail($employee_email,$manager_subject,$message2,$headers); /* mail to manager */
		}
		
		$message =  get_all_task($id['employee_id']);
		$message1 .= $message;
		$employee_subject = 'My Task['.date('d-m-Y').']';
		//$employee_email = "Vishak Nair.c@satger.com";
		mail($employee_email,$employee_subject,$message,$headers); /* mail to employee */
		//exit;
	}
	//echo $message1;
	function get_all_task($emp_id,$mag_id=0)
	{
		$condition = '';
		if($mag_id != 0)
		{
			$condition .= "AND TASK.`manager_id`='".$mag_id."'";
		}
		$message = ''; /* message for employee mail */
		$task_query = "SELECT TASK.*,  PROJECTS.PROJECT_NAME, MANAGER.MANAGER_NAME, EMPLOYEE.EMP_NAME, TASK_STATUS.TASK_STATUS_NAME from task AS TASK 
								LEFT JOIN (SELECT employee_id, employee_name AS EMP_NAME FROM employee WHERE 1) as EMPLOYEE 
								ON TASK.employee_id = EMPLOYEE.employee_id LEFT JOIN
								(SELECT employee_id, employee_name AS MANAGER_NAME FROM  employee  WHERE 1) as MANAGER 
								ON TASK.manager_id = MANAGER .employee_id LEFT JOIN 
								(SELECT project_id,project_name as PROJECT_NAME FROM projects WHERE 1) as PROJECTS 
								ON TASK.project_id = PROJECTS.project_id  LEFT JOIN
								(SELECT task_status_id,task_status_name as TASK_STATUS_NAME FROM task_status WHERE 1) as TASK_STATUS
								ON TASK.task_status = TASK_STATUS.task_status_id WHERE TASK.`employee_id`='".$emp_id."' AND TASK.is_active=1 ".$condition."";
			$task_details = mysql_query($task_query);
			$new_task_assign = array();
			$ongoing_task = array();
			$completed_task_today = array();
			
			$query2 = "select employee_name from employee where employee_id='".$emp_id."'";
			$result = mysql_query($query2);
			$data = mysql_fetch_array($result,MYSQL_ASSOC);
			$employee_name = $data['employee_name'];
			
			$message .= "<table border=1 cellspacing='0' cellpadding='1px' style='border-collapse: collapse;margin-top: 15px;margin:10px 0;width:100%'>";
			//$message .= "<span style='font-size: 17px;font-weight: bold;'>".$employee_name."</span>";
			$message .= "<tr style='background-color: rgb(219, 219, 219);font-weight: bold'><td colspan=7 style='padding:7px 21px 7px 7px;'>".$employee_name."</td></tr>";
			if($task_details != ''){
				while($task = mysql_fetch_array($task_details,MYSQL_ASSOC))
				{
					if($task['task_status'] == 1)
					{
						$new_task_assign[] = $task;	
					}
					if($task['task_status'] != 1 && $task['task_status'] != 999)
					{
						$ongoing_task[] = $task;
					}
					if($task['task_status'] == 999 && substr($task['actual_complition_date'],0,10) == date('Y-m-d')){
						$completed_task_today[] = $task;	
					}
				}
			}
			
			
			if(count($new_task_assign)){
				$message .= "<tr style='border-top: 1px solid black'><td colspan='7' style='padding:7px 21px 7px 7px;font-size: 16;font-weight: bold;color: #238BFC'>New Task Assigned</td>";
				$message .= "</tr><tr style='border-top: 1px solid #DDD;'><th style='border-right: 1px solid #DDD;max-width: 100px'>Project name</th><th style='border-right: 1px solid #DDD'>Title</th><th style='border-right: 1px solid #DDD;max-width: 200px;'>Description</th><th style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>Assigned Date</th><th style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>Start Date</th><th style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>Expected Completion Date</th><th style='max-width:160px;'>Remarks</th></tr>";
				foreach($new_task_assign as $single_task)
				{
					$message .= "<tr style='border-top: 1px solid #DDD'><td style='border-right: 1px solid #DDD;width:1px;max-width: 100px;'>".$single_task['PROJECT_NAME']."</td><td style='border-right: 1px solid #DDD'>".$single_task['title']."</td><td style='max-width: 200px;border-right: 1px solid #DDD'>".$single_task['task_details']."</td><td style='border-right: 1px solid #DDD;;max-width: 80px;text-align:center;'>".formatDateTime($single_task['assigned_date'])."</td><td style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>".formatDateTime($single_task['start_date'])."</td><td style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>".formatDateTime($single_task['expected_complition_date'])."</td><td style='max-width:160px;'>".$single_task['remark']."</td></tr>";
				}
			}else{
				$message .= "<tr><td colspan='1' style='padding:7px 21px 7px 7px;font-size: 16;font-weight: bold;color: #238BFC;border-top: 1px solid black;border-right: 1px solid #DDD;'>New Task Assigned</td>";
				$message .= "<td colspan='6' style='text-align: center;border-top: 1px solid black'>No Task Found</td></tr>";	
			}
			
			
			if(count($ongoing_task)){
				$message .= "<tr><td colspan='7'  style='padding:7px 21px 7px 7px;font-size: 16;font-weight: bold;color: #238BFC;border-top: 1px solid black'>Ongoing Task</td>";
				$message .= "</tr><tr style='border-top: 1px solid #DDD'><th style='border-right: 1px solid #DDD;max-width: 100px;'>Project name</th><th style='border-right: 1px solid #DDD'>Title</th><th style='border-right: 1px solid #DDD;max-width: 200px;'>Description</th><th style='border-right: 1px solid #DDD;;max-width: 80px;text-align:center;'>Assigned Date</th><th style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>Start Date</th><th style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>Expected Completion Date</th><th style='max-width:160px;'>Remarks</th></tr>";
				foreach($ongoing_task as $single_task)
				{
					$on_hold = '';
					if($single_task['task_status'] == 4)
						$on_hold = '<br><span style="color:#FF0606;">(Task on hold)</samp>';
					$message .= "<tr style='border-top: 1px solid #DDD'><td style='border-right: 1px solid #DDD;;max-width: 100px'>".$single_task['PROJECT_NAME']."</td><td style='border-right: 1px solid #DDD'>".$single_task['title']." ".$on_hold."</td><td style='max-width: 200px;border-right: 1px solid #DDD;'>".$single_task['task_details']."</td><td style='border-right: 1px solid #DDD;;max-width: 80px;text-align:center;'>".formatDateTime($single_task['assigned_date'])."</td><td style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>".formatDateTime($single_task['start_date'])."</td><td style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>".formatDateTime($single_task['expected_complition_date'])."</td><td style='max-width:160px;'>".$single_task['remark']."</td></tr>";
				}
			}else{
				$message .= "<tr><td colspan='1'  style='padding:7px 21px 7px 7px;font-size: 16;font-weight: bold;color: #238BFC;border-top: 1px solid black;border-right: 1px solid #DDD;'>Ongoing Task</td>";
				$message .= "<td colspan='6' style='text-align: center;border-top: 1px solid black;'>No Task Found</td></tr>";	
			}
			
			
			if(count($completed_task_today)){
				$message .= "<tr><td colspan='7'  style='padding:7px 21px 7px 7px;font-size: 16;font-weight: bold;color: #238BFC;border-top: 1px solid black'>Task Completed Today</td>";
				$message .= "</tr><tr style='border-top: 1px solid #DDD'><th style='border-right: 1px solid #DDD;max-width: 100px;'>Project name</th><th style='border-right: 1px solid #DDD'>Title</th><th style='border-right: 1px solid #DDD;max-width: 200px;'>Description</th><th style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>Assigned Date</th><th style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>Start Date</th><th style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>Expected Completion Date</th><th style='max-width:160px;'>Remarks</th></tr>";
				foreach($completed_task_today as $single_task)
				{
					$message .= "<tr style='border-top: 1px solid #DDD'><td style='border-right: 1px solid #DDD;max-width: 100px;'>".$single_task['PROJECT_NAME']."</td><td style='border-right: 1px solid #DDD'>".$single_task['title']."</td><td style='max-width: 200px;border-right: 1px solid #DDD'>".$single_task['task_details']."</td><td style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>".formatDateTime($single_task['assigned_date'])."</td><td style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>".formatDateTime($single_task['start_date'])."</td><td style='border-right: 1px solid #DDD;max-width: 80px;text-align:center;'>".formatDateTime($single_task['expected_complition_date'])."</td><td style='max-width:160px;'>".$single_task['remark']."</td></tr>";
				}
			}else{
				$message .= "<tr><td colspan='1'  style='padding:7px 21px 7px 7px;font-size: 16;font-weight: bold;color: #238BFC;border-top: 1px solid black;border-right: 1px solid #DDD;'>Task Completed Today</td>";
				$message .= "<td colspan='6' style='text-align: center;border-top: 1px solid black;'>No Task Found</td></tr>";	
			}
			$message .= "</table>";
			return $message;
	}
	
	mail($to,$subject,$message1,$headers); /* mail to admin */
?>