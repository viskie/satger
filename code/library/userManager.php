<?
//Vishak Nair - 25/08/2012
//for user management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
require_once('Config.php');
class UserManager extends commonObject
{
	//to get all the users.
	/*function getAllUsers()
	{
		$userGroup = array();
		$userGroup = $_SESSION['user_group'];
		//print_r($userGroup);exit;
		$first = true;
		$user_groups = "";
		foreach($userGroup as $key=>$value)
		{
			if(!$first)
				$user_groups.= ", ";
			else
				$first = false;
				
			$user_groups.= $value;	
			
		}
		//var_dump($user_groups);exit;
		return $resultSet = getData("SELECT * FROM `users` WHERE is_active =1 AND `user_id` in (SELECT `user_id` FROM `user_group_permissions` WHERE `group_id` IN (".$user_groups.") AND is_active=1) group by users.user_id");
	}*/
	
	public $db_fields;
	function UserManager()
	{
		$this->table_name = "users";
		$this->db_fields = array();	
	}
	
	
	function getAll($table_name=false){
		return $resultSet = getData("SELECT * FROM `".$this->table_name."` WHERE user_group<>31 and is_active =1");
	}
	
	function getAllUsers($table_name,$value){
		if($value == 1)
			return $resultSet = getData("SELECT * FROM `".$this->table_name."` WHERE user_group<>31 order by is_active desc");
		else		
			return $resultSet = getData("SELECT * FROM `".$this->table_name."` WHERE user_group<>31 and is_active =0");
	}
	
	function get_allcounts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(user_id) AS CNT From users WHERE user_group<>31");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(user_id) AS CNT From users WHERE is_active = 1 AND user_group<>31");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(user_id) AS CNT From users WHERE is_active = 0 AND user_group<>31");
		$arr_counts['deleted'] = $trash;
		return $arr_counts;
		
	}
	
	//
	function restoreUsers($user_id){
		updateData("UPDATE users SET is_active=1 WHERE user_id=".$user_id);
	}
	
	//To get all the details of perticular user using user_id
	function getUserDetails($user_id)
	{
		return $resultSet = getRow("select * from  users where is_active =1 AND user_id='".$user_id."'");
	}
	
	//To get all the details of perticular user using user_id
	function getUserPassword($user_id)
	{
		return $resultSet = getOne("select `user_password` from  users where is_active =1 AND user_id='".$user_id."'");
	}
	//To get name of perticular user using user_id
	function getUserNameUsingId($user_id){
		return $resultSet = getOne("select user_name from users where is_active =1 AND user_id='".$user_id."'");
	}
	//To get name of perticular user using user_id
	function getUserIdUsingName($user_name){
		return $resultSet = getOne("select user_id from users where is_active =1 AND user_name='".$user_name."'");
	}
	function getAllPermissionedGroupsOfGroup($user_id){
		$resultSet=getData("SELECT `group_id` FROM `user_group_permissions` WHERE `user_id`=".$user_id);
		//echo ("SELECT `group_id` FROM `user_group_permissions` WHERE `user_id`=".$user_id);exit;
		$permissionedGroups=array();
		for($i=0;$i<count($resultSet);$i++){
			$permissionedGroups[]=$resultSet[$i]['group_id'];
		}
		return $permissionedGroups;	
	}
	
	function getUsersOfGroup($group_id){
		return getData("SELECT `name`,`user_email`,`user_phone`, ug.group_name FROM user_groups ug left join `users` u on u.user_group=ug.group_id where u.user_group=".$group_id);
		//echo("SELECT `name`,`user_email`,`user_phone` FROM `users` WHERE `user_group`=".$group_id); exit;
	}
	//To restrict duplicate in users.
	function isUserExist($user_name,$user_id=0){
		$query="select * from users where user_name='".$user_name."'";
		if($user_id!=0){
			$query.=" AND user_id!=".$user_id;
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
		$updateQry=getUpdateDataString($dataArray,"users","user_id");
		updateData($updateQry);
	}
	
	//Vishak Nair
	function updateEmployeeInUser($employeeVariables)
	{
		updateData("UPDATE users SET user_name='".$employeeVariables['employee_user_name']."', name='".$employeeVariables['employee_name']."', user_email='".$employeeVariables['company_email']."', user_phone=".$employeeVariables['phone_number'].",modified_by=".$employeeVariables['modified_by'].",modified_date='".$employeeVariables['modified_date']."' where user_id = ".$employeeVariables['user_id']."");	
		
		//exit;
	}
	
	function setPassword($newPassword,$user_id){
		updateData("UPDATE `users` SET `user_password`=sha1('".$newPassword."') WHERE is_active =1 AND `user_id`=".$user_id);
	}
	
	function setLanguage($newLanguage,$user_id){
		updateData("UPDATE `users` SET `preferred_language`='".$newLanguage."' WHERE is_active =1 AND `user_id`=".$user_id);
	}
	
	//To delete a row in users table using user_id. 
	function deleteUsingId($user_id){
		updateData("UPDATE `users` SET `is_active`=false WHERE `user_id`='".$user_id."'");
	}
		
	function insertUser($varArray)
	{
		$insertQry = getInsertDataString($varArray, 'users');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	//Vishak Nair
	function insertEmployeeInUsers($employeeVariables)
	{	
		$insertId = updateData("INSERT INTO `users` (user_group,user_name,user_password,name,user_email,user_phone,added_by,added_date)values (31,'".$employeeVariables['employee_user_name']."','".sha1($employeeVariables['employee_password'])."','".$employeeVariables['employee_name']."','".$employeeVariables['personal_email']."',".$employeeVariables['phone_number'].",".$employeeVariables['added_by'].",'".$employeeVariables['added_date']."');");
		return mysql_insert_id();
	}
	
	function getUserVariables()
	{
		$this->db_fields['user_group'] = $_REQUEST['user_group'];
		if(isset($_REQUEST['user_name'])){
			$this->db_fields['user_name'] = $_REQUEST['user_name'];
		}
		$this->db_fields['user_password'] = $_REQUEST['user_password'];
		$this->db_fields['name'] = $_REQUEST['name'];
    	$this->db_fields['user_email'] = $_REQUEST['user_email'];
		$this->db_fields['user_phone'] = $_REQUEST['user_phone'];
	
		//return $varArray;
	}
	
	//To get password of franchise from user table
	function getFranchisePassword($franchise_id)
	{
		return $resultSet = getOne("select `user_password` from  `".$this->table_name."` where is_active =1 AND franchise_id='".$franchise_id."'");
	}
	
	//Vishak Nair - 04/09/2012
	//To get the branch permission for user.
/*	function getAllPermissionedBranchesOfUser($user_id){
		$resultSet=getData("SELECT `branch_id` FROM `user_permissions_on_company` WHERE `user_id`=".$user_id);
		$permissionedBranches=array();
		for($i=0;$i<count($resultSet);$i++){
			$permissionedBranches[]=$resultSet[$i]['branch_id'];
		}
		return $permissionedBranches;
	}*/
	
	
	//Vishak Nair - 04/09/2012
	//To set the branch permission for user.
/*	function setBranchPermissionsForUser($user_id,$branchArray){
		$first=true;
		updateData("DELETE FROM `user_permissions_on_company` WHERE `user_id`='".$user_id."'");
		updateData("DELETE FROM `user_permissions_on_original_company` WHERE `user_id`='".$user_id."'");
		if(count($branchArray)>0){
			$companyArray=getData("Select Distinct(`company_id`) from company_details where branch_id in (".implode(',',$branchArray).")");
			$query="INSERT INTO `user_permissions_on_original_company`(`user_id`, `company_id`) VALUES ";
			foreach($companyArray as $company){
				if(!$first){
					$query.=", ";
				}else{
					$first=false;
				}
				$query.="('".$user_id."','".$company['company_id']."')";				
			}
			updateData($query);
			
			$first=TRUE;
			$query="INSERT INTO `user_permissions_on_company`(`user_id`, `branch_id`) VALUES ";
			foreach($branchArray as $branchToAdd){
				if(!$first){
					$query.=", ";
				}else{
					$first=false;
				}
				$query.="('".$user_id."','".$branchToAdd."')";
			}
			updateData($query);
		}
		updateData("OPTIMIZE TABLE `user_permissions_on_original_company`");//To delete the data files related to the deleted records.
		updateData("OPTIMIZE TABLE `user_permissions_on_company`");//To delete the data files related to the deleted records.
	}*/
	
} 
?>
