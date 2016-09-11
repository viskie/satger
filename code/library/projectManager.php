<?

//for Project management

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)

{

	header("location: index.php");

	exit();

}



require_once('Config.php');



class ProjectManager extends commonObject

{		

		function getAllProjects($show='1')

		{

			if($show == 0)

				$arr_orders =  getData("SELECT project_id, project_name,client_biz_name,start_date,expected_end_date,end_date, project_cost_INR, project_cost_dollar, project_expense,projects.remarks,is_active FROM `projects`,`clients` where  projects.client=clients.client_id ORDER BY projects.start_date DESC");

			elseif($show == 1)

				$arr_orders =  getData("SELECT project_id, project_name,client_biz_name,start_date,expected_end_date,end_date, project_cost_INR, project_cost_dollar, project_expense,projects.remarks,is_active FROM `projects`,`clients` where is_active=1 and projects.client=clients.client_id ORDER BY projects.start_date DESC");

			elseif($show == 2)

				$arr_orders =  getData("SELECT project_id, project_name,client_biz_name,start_date,expected_end_date,end_date, project_cost_INR, project_cost_dollar, project_expense,projects.remarks,is_active FROM `projects`,`clients` where is_active=0 and projects.client=clients.client_id ORDER BY projects.start_date DESC");

			return $arr_orders;

		}

		

		function get_allcounts()

		{

			$arr_counts = array();

			$all = getOne("SELECT COUNT(project_id) AS CNT From projects WHERE 1");

			$arr_counts['all'] = $all;

			$active = getOne("SELECT COUNT(project_id) AS CNT From projects WHERE is_active = 1");

			$arr_counts['active'] = $active;

			$trash = getOne("SELECT COUNT(project_id) AS CNT From projects WHERE is_active = 0");

			$arr_counts['trash'] = $trash;

			return $arr_counts;

			

		}

		

		function restore_project($id)

		{

			$change_data = array (

									'is_active' => 1,							

									); 

			$change_data['project_id'] = $id;

			$updateQry=$this->getUpdateDataString($change_data,"projects","project_id");

			updateData($updateQry);

			

		}

	

		/*function getAllProjects()

		{

			//return $resultSet = getData("SELECT project_id, project_name,client_biz_name,DATE_FORMAT(`start_date`,'%d-%m-%Y')as start_date,DATE_FORMAT(`expected_end_date`,'%d-%m-%Y')as expected_end_date,DATE_FORMAT(`end_date`,'%d-%m-%Y')as end_date, project_cost_INR, project_cost_dollar, project_expense FROM `projects`,`clients` where is_active=1 and projects.client=clients.client_id");

			return $resultSet = getData("SELECT project_id, project_name,client_biz_name,start_date,expected_end_date,end_date, project_cost_INR, project_cost_dollar, project_expense,projects.remarks FROM `projects`,`clients` where is_active=1 and projects.client=clients.client_id ORDER BY projects.start_date DESC");

		}*/

		

		function getProjectVariables()

		{

			$varArray['project_name'] = $_REQUEST['project_name'];

			$varArray['client'] = $_REQUEST['client'];

			$varArray['start_date'] = $_REQUEST['start_alt'];

			$varArray['expected_end_date'] = $_REQUEST['expected_end_alt'];

			$varArray['end_date'] = $_REQUEST['end_alt'];

			$varArray['project_cost_INR'] = $_REQUEST['project_cost_INR'];

			$varArray['project_cost_dollar'] = $_REQUEST['project_cost_dollar'];

			$varArray['project_expense'] = $_REQUEST['project_expense'];

			$varArray['remarks'] = $_REQUEST['remarks'];

			$varArray['project_category_id'] = $_REQUEST['project_category_id'];
			
			$varArray['employee_id'] = $_REQUEST['employee_id'];


			return $varArray;

		}

		

		function insertProject($projectArray)

		{

			$insertQry = $this->getInsertDataString($projectArray, 'projects');

			updateData($insertQry);

			return mysql_insert_id();

		}

		

	function getProjectDetails($project_id)
	{
		return $resultSet = getRow("select projects.*,client_biz_name, project_category_name, employee_name from  projects LEFT JOIN clients ON projects.client=clients.client_id LEFT JOIN project_category ON projects.project_category_id=project_category.project_category_id LEFT JOIN employee ON projects.employee_id=employee.employee_id where project_id='".$project_id."'");
	}
	
	function getManagerOfProject($project_id)
	{
		return getOne("select employee_id from projects where project_id='".$project_id."'");	
	}

	

	function updateUsingId($projectArray)

	{

			$updateQry=$this->getUpdateDataString($projectArray,"projects","project_id");

			updateData($updateQry);

	}

	

	//To delete a row in projects table using project_id. 

	function deleteUsingId($project_id){

		updateData("UPDATE `projects` SET `is_active`=0 WHERE `project_id`='".$project_id."'");

	}



}



?>

