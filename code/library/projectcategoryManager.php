<?

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

//require_once('Config.php');

class CategoryManager extends commonObject
{
	function getAllProjectCategories($show='1')
		{
			if($show == 0)
				$arr_orders =  getData("select * from `project_category` ");
			elseif($show == 1)
				$arr_orders =  getData("select * from `project_category` where is_active=1");
			elseif($show == 2)
				$arr_orders =  getData("select * from `project_category` where is_active=0");
			return $arr_orders;
		}
		
		function get_allcounts()
		{
			$arr_counts = array();
			$all = getOne("SELECT COUNT(project_category_id) AS CNT From project_category WHERE 1");
			$arr_counts['all'] = $all;
			$active = getOne("SELECT COUNT(project_category_id) AS CNT From project_category WHERE is_active = 1");
			$arr_counts['active'] = $active;
			$trash = getOne("SELECT COUNT(project_category_id) AS CNT From project_category WHERE is_active = 0");
			$arr_counts['trash'] = $trash;
			return $arr_counts;
			
		}
		
		function restore_project_category($id)
		{
			$change_data = array (
									'is_active' => 1,							
									); 
			$change_data['project_category_id'] = $id;
			$updateQry=$this->getUpdateDataString($change_data,"project_category","project_category_id");
			updateData($updateQry);
			
		}
	
	/*function getAllProjectCategories(){	
		return $resultSet = getData("SELECT * FROM `project_category` WHERE is_active =1");
	}*/
	
	function getAllPaymentCategories($show='1')
		{
			if($show == 0)
				$arr_orders =  getData("select * from `payment_category` ");
			elseif($show == 1)
				$arr_orders =  getData("select * from `payment_category` where is_active=1");
			elseif($show == 2)
				$arr_orders =  getData("select * from `payment_category` where is_active=0");
			return $arr_orders;
		}
		
		function get_allcounts()
		{
			$arr_counts = array();
			$all = getOne("SELECT COUNT(pc_id) AS CNT From payment_category WHERE 1");
			$arr_counts['all'] = $all;
			$active = getOne("SELECT COUNT(pc_id) AS CNT From payment_category WHERE is_active = 1");
			$arr_counts['active'] = $active;
			$trash = getOne("SELECT COUNT(pc_id) AS CNT From payment_category WHERE is_active = 0");
			$arr_counts['trash'] = $trash;
			return $arr_counts;
			
		}
		
		function restore_project_category($id)
		{
			$change_data = array (
									'is_active' => 1,							
									); 
			$change_data['project_category_id'] = $id;
			$updateQry=$this->getUpdateDataString($change_data,"project_category","project_category_id");
			updateData($updateQry);
			
		}
	
	/*function getAllPaymentCategories(){
		return getData("select * from `payment_category` where is_active=1");
	}*/
	
	function getAllPaymentCategoriesOfType($type){
		return getData("select * from `payment_category` where is_active=1 AND type='".$type."'");
	}
	
	//To get all the details of project category using project_category_id
	function getProjectCategoryDetails($project_category_id)
	{
		return $resultSet = getRow("select * from  `project_category` where is_active =1 AND project_category_id='".$project_category_id."'");
	}
	
	function getPaymentCategoryDetails($payment_category_id)
	{
		return $resultSet = getRow("select * from  `payment_category` where is_active =1 AND pc_id='".$payment_category_id."'");
	}

	//To get name of particular project category using project_category_id
	function getProjectCategoryNameUsingId($project_category_id){
		return $resultSet = getOne("select project_category_name from `project_category` where is_active =1 AND project_category_id='".$project_category_id."'");
	}

	//To get name of particular `project_category`using `project_category_id
	function getProjectCategoryIdUsingName($project_category_name){
		return $resultSet = getOne("select project_category_id from project_category where is_active =1 AND project_category_name='".$project_category_name."'");
	}

	
	//To restrict duplicate in project category.
	function isProjectCategoryExist($project_category_name,$project_category_id=0){
		$query="select * from project_category where project_category_name='".$project_category_name."' and is_active=1";
		if($project_category_id!=0){
			$query.=" AND project_category_id!=".$project_category_id;
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	//To restrict duplicate in Payment category.
	function isPaymentCategoryExist($payment_category_name,$payment_category_id=0){
		$query="select * from payment_category where name='".$payment_category_name."' and is_active=1";
		if($payment_category_id!=0){
			$query.=" AND pc_id!=".$payment_category_id;
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	//To update a row in users table using user_id. 
	function updateUsingId($dataArray){
		$updateQry=$this->getUpdateDataString($dataArray,"project_category","project_category_id");
		updateData($updateQry);
	}
	
	
	
	//To delete a row in project_category table using project_category_id. 
	function deleteUsingId($project_category_id){
		updateData("UPDATE `project_category` SET `is_active`=0 WHERE `project_category_id`='".$project_category_id."'");
	}
		
	function insertProjectCategory($varArray)
	{
		$insertQry = $this->getInsertDataString($varArray, 'project_category');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	function getProjectCategoryVariables()
	{
		$varArray['project_category_name'] = $_REQUEST['project_category_name'];
			
		return $varArray;
	}
	
	function getPaymentCategoryVariables(){
		$varArray['name'] = $_REQUEST['payment_category_name'];
		$varArray['type'] = $_REQUEST['payment_category_type'];	
		return $varArray;
	}
} 
?>
