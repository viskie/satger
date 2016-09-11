<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class FranchiseManager extends commonObject
{
	public $db_fields;
	function FranchiseManager()
	{
		$this->db_fields = array();
		$this->table_name = "franchise";	
	}
	
	function isFranchiseExists($franchise_code,$franchise_id=0)
	{
		$query="select * from `".$this->table_name."` where franchise_code='".$franchise_code."' and is_active=1";
		if($franchise_id!=0){
			$query.=" AND franchise_id!=".$franchise_id;
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return false;
		}else{
			return true;
		}
	}
	
	function insertFranchiseInUser($franchiseVariables)
	{
		$insertId = updateData("INSERT INTO `users` (franchise_id,user_group,user_name,user_password,name,user_email,user_phone,added_by,added_date)values ('".$franchiseVariables['franchise_id']."',".franchise_admin_grpid.",'".$franchiseVariables['franchise_username']."','".sha1($franchiseVariables['franchise_password'])."','".$franchiseVariables['franchise_name']."','".$franchiseVariables['email']."',".$franchiseVariables['phone_main'].",".$franchiseVariables['added_by'].",'".$franchiseVariables['added_date']."');");
		return mysql_insert_id();	
	}
	
	function updateFranchiseInUser($franchiseVariables)
	{
		updateData("UPDATE users SET user_name='".$franchiseVariables['franchise_username']."', name='".$franchiseVariables['franchise_name']."', user_email='".$franchiseVariables['email']."', user_phone=".$franchiseVariables['phone_main'].",modified_by=".$franchiseVariables['modified_by'].",modified_date='".$franchiseVariables['modified_date']."' where franchise_id = ".$franchiseVariables['franchise_id']."");		
		//exit;
	}
	
	function getFranchiseVariables()
	{
		$this->db_fields['franchise_code'] = $_POST['franchise_code'];
		$this->db_fields['franchise_name'] = $_POST['franchise_name'];
		$this->db_fields['franchise_region'] = $_POST['franchise_region'];
		$this->db_fields['franchise_type'] = $_POST['franchise_type'];
		$this->db_fields['address'] = $_POST['address'];
		$this->db_fields['city'] = $_POST['city'];
		$this->db_fields['state'] = $_POST['state'];
		$this->db_fields['country'] = $_POST['country'];
		$this->db_fields['zip'] = $_POST['zip'];
		$this->db_fields['phone_main'] = $_POST['phone_main'];
		$this->db_fields['phone_tollfree'] = $_POST['phone_tollfree'];
		$this->db_fields['fax'] = $_POST['fax'];
		$this->db_fields['email'] = $_POST['email'];
		$this->db_fields['owner'] = $_POST['owner'];
	}
	
	function get_all_counts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(franchise_id) AS CNT From `".$this->table_name."` WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(franchise_id) AS CNT From `".$this->table_name."` WHERE is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(franchise_id) AS CNT From `".$this->table_name."` WHERE is_active = 0");
		$arr_counts['trash'] = $trash;
		return $arr_counts;
		
	}
	
	function get_franchises($show='1')
	{
		if($show == 0)
			$arr_status = getData("select * from `".$this->table_name."`");
		elseif($show == 1)
			$arr_status = getData("select * from `".$this->table_name."` WHERE is_active=1");
		elseif($show == 2)
			$arr_status = getData("select * from `".$this->table_name."` WHERE is_active=0");
		return($arr_status);
	}
	
	function getFranchiseUserName($franchise_id)
	{
		return $resultSet = getOne("select user_name from users where is_active =1 AND franchise_id='".$franchise_id."'");	
	}
	function get_fixed_franchise($user_id)
	{
		return getRow("SELECT `franchise_id`,`franchise_name` FROM `franchise` where `franchise_id` in (select franchise_id from users where user_id='".$user_id."')");
	}
}
?>