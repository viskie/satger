<?

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

//require_once('Config.php');

class SettingManager extends commonObject
{
		function updateConfigValue($value,$modified_by,$modified_date)
		{
			$query = "UPDATE settings set config_value='".$value."',modified_by='".$modified_by."',modified_date='".$modified_date."' where config_name='financial_month'";
			$result = mysql_query($query) or die(mysql_error());
		}
		
		function getDefaultFinancialMonth()
		{
			return getOne("SELECT config_value FROM settings WHERE config_name='financial_month'");	
		}
		
		function getSickLeaveSetting()
		{
			return getOne("SELECT config_value FROM settings WHERE config_name='sick_leaves'");		
		}
		
		function getCasualLeaveSetting()
		{
			return getOne("SELECT config_value FROM settings WHERE config_name='casual_leaves'");		
		}
		
		function getPaidLeaveSetting()
		{
			return getOne("SELECT config_value FROM settings WHERE config_name='paid_leaves'");		
		}
		
		function updateSickLeaveSettings($value,$modified_by,$modified_date)
		{
			$query = "UPDATE settings set config_value='".$value."',modified_by='".$modified_by."',modified_date='".$modified_date."' where config_name='sick_leaves'";
			$result = mysql_query($query) or die(mysql_error());	
		}
		
		function updateCasualLeaveSettings($value,$modified_by,$modified_date)
		{
			$query = "UPDATE settings set config_value='".$value."',modified_by='".$modified_by."',modified_date='".$modified_date."' where config_name='casual_leaves'";
			$result = mysql_query($query) or die(mysql_error());	
		}
		
		function updatePaidLeaveSettings($value,$modified_by,$modified_date)
		{
			$query = "UPDATE settings set config_value='".$value."',modified_by='".$modified_by."',modified_date='".$modified_date."' where config_name='paid_leaves'";
			$result = mysql_query($query) or die(mysql_error());	
		}
		
		function getFinancialStartMonth()
		{
				return getOne("SELECT config_value FROM settings WHERE config_name='financial_start_month'");
		}
		
		function get_allgroups()
		{
			$arr_groups =  getData("SELECT group_id, group_name From user_groups WHERE is_active = 1");
			return ($arr_groups);
		}
						
		function save_permission($arr_data)
		{			
			$arr_groups = get_allgroups();
			$empty_table = "TRUNCATE TABLE `user_permissions`";
			mysql_query($empty_table);
			
			for($i=0; $i<count($arr_groups); $i++)
			{
				$groupid = $arr_groups[$i]['group_id'];
				if(isset($arr_data["page_$groupid"]))
				{
					$insert_data = array();
					$insert_data['group_id'] = $groupid;
					foreach($arr_data["page_$groupid"] as $k=>$v)
					{	
						if(isset($arr_data["function_".$groupid.'_'.$v]))
						{
							$insert_data['page_id'] = $v;
							foreach($arr_data["function_".$groupid.'_'.$v] as $k1=>$v1)
							{
								if(isset($arr_data["subfunction_".$groupid.'_'.$v.'_'.$v1]))
								{
									$insert_data['function_id'] = $v1;
									foreach($arr_data["subfunction_".$groupid.'_'.$v.'_'.$v1] as $k3=>$v3)
									{
										$insert_data['sub_function_id'] = $v3;
										$insert_data['view_perm'] = 1;
										$insert_data['add_perm'] = 0;
										$insert_data['edit_perm'] = 0;
										$insert_data['delete_perm'] = 0;
										$insert_data['restore_perm'] = 0;
										if(isset($arr_data["subfunction_".$groupid.'_'.$v.'_'.$v1.'_'.$v3]))
										{											
											foreach($arr_data["subfunction_".$groupid.'_'.$v.'_'.$v1.'_'.$v3] as $k4=>$v4)
											{
												if($v4 == 'add')
													$insert_data['add_perm'] = 1;
												elseif($v4 == 'edit')
													$insert_data['edit_perm'] = 1;
												elseif($v4 == 'delete')
													$insert_data['delete_perm'] = 1;
												elseif($v4 == 'restore')
													$insert_data['restore_perm'] = 1;												
											}
										}																			
										$insert_data['is_active'] = 1;
										/*$check_exist = getData("select permission_id from user_permissions WHERE group_id = '".$insert_data['group_id']."' and page_id = '".$insert_data['page_id']."' and function_id = '".$insert_data['function_id']."' and sub_function_id = '".$insert_data['sub_function_id']."'");
										
										if(count($check_exist) > 0)
										{
											$insert_data['permission_id'] = $check_exist[0]["permission_id"];
											$updateQry=$this->getUpdateDataString($insert_data,"user_permissions",'permission_id');
											updateData($updateQry);
										}
										else
										{*/
											$insertQry = getInsertDataString($insert_data, 'user_permissions');
											updateData($insertQry);		
										//}
									}
									
								}
							}
						}
					}
				}
			}		
			
		}
		
		
		function get_allpriority($show_status=1)
		{
			if($show_status == 0)
				$arr_priority = getData("select * from priority WHERE 1  ORDER BY priority_order ASC");
			elseif($show_status == 1)
				$arr_priority = getData("select * from priority WHERE is_active=1  ORDER BY priority_order ASC");
			elseif($show_status == 2)
				$arr_priority = getData("select * from priority WHERE is_active=0  ORDER BY priority_order ASC"); 
			return($arr_priority);		
		}
		function get_all_prioritycounts()
		{
			$arr_counts = array();
			$all = getOne("SELECT COUNT(id) AS CNT From priority WHERE 1");
			$arr_counts['all'] = $all;
			$active = getOne("SELECT COUNT(id) AS CNT From priority WHERE is_active = 1");
			$arr_counts['active'] = $active;
			$trash = getOne("SELECT COUNT(id) AS CNT From priority WHERE is_active = 0");
			$arr_counts['trash'] = $trash;
			return $arr_counts;
		}
		function get_prioritydata($id)
		{
			return getRow("select * from priority WHERE id= '".$id."'"); 
		}
		function is_OrderExists($order,$priority_id='')
		{
			$query="select * from priority where priority_order='".$order."'";
			if($priority_id!=''){
				$query.=" AND id!=".$priority_id;
			}
			$resultSet = getData($query); 
			if(sizeof($resultSet)>0){
				return true;
			}else{
				return false;
			}
		}
		function save_priority($arr_data)
		{	
			$insert_data = array(
							'value' => $arr_data['value'],
							'priority_order' => $arr_data['priority_order'],																									
							'is_active' => 1
							);
			if($arr_data['edit_id'] != "")
			{	
				$insert_data['modified_by'] = $arr_data['added_by'];
				$insert_data['modified_date'] = $arr_data['added_date'];
				$insert_data['id'] = $arr_data['edit_id'];
				$updateQry=$this->getUpdateDataString($insert_data,"priority","id");
				updateData($updateQry);				
			}
			else
			{
				$insert_data['added_by'] = $arr_data['added_by'];
				$insert_data['added_date'] = $arr_data['added_date'];
				//echo "<pre>"; print_r($insert_data); exit;				
				$insertQry = getInsertDataString($insert_data, 'priority');					
				updateData($insertQry);				
			}			
		}
		function delete_priority($edit_id)
		{
			$change_data = array (
								'is_active' => 0,							
								); 
			$change_data['id'] = $edit_id;
			$updateQry=$this->getUpdateDataString($change_data,"priority","id");
			updateData($updateQry);
		}
		function restore_status($edit_id)
		{
			$change_data = array (
								'is_active' => 1,							
								); 
			$change_data['id'] = $edit_id;
			$updateQry=$this->getUpdateDataString($change_data,"priority","id");
			updateData($updateQry);
		}
		
		// candidate position
		function getAllPositions($show='1')

		{

			if($show == 0)

				$arr_orders =  getData("select * from `candidate_position` ");

			elseif($show == 1)

				$arr_orders =  getData("select * from `candidate_position` where is_active=1");

			elseif($show == 2)

				$arr_orders =  getData("select * from `candidate_position` where is_active=0");

			return $arr_orders;

		}

		

		function get_all_counts_positions()

		{

			$arr_counts = array();

			$all = getOne("SELECT COUNT(position_id) AS CNT From candidate_position WHERE 1");

			$arr_counts['all'] = $all;

			$active = getOne("SELECT COUNT(position_id) AS CNT From candidate_position WHERE is_active = 1");

			$arr_counts['active'] = $active;

			$trash = getOne("SELECT COUNT(position_id) AS CNT From candidate_position WHERE is_active = 0");

			$arr_counts['trash'] = $trash;

			return $arr_counts;

			

		}

		

		function restore_position($id)

		{

			$change_data = array (

									'is_active' => 1,							

									); 

			$change_data['position_id'] = $id;

			$updateQry=$this->getUpdateDataString($change_data,"candidate_position","position_id");

			updateData($updateQry);

			

		}
		function getPositionDetails($position_id)

		{
	
			return $resultSet = getRow("select * from  `candidate_position` where is_active =1 AND position_id='".$position_id."'");
	
		}
		function isPositionExist($position_name,$position_id=0)
		{

			$query="select * from candidate_position where position_name='".$position_name."' and is_active=1";
	
			if($position_id!=0){
	
				$query.=" AND position_id!=".$position_id;
	
			}
	
			$resultSet = getData($query);
	
			if(sizeof($resultSet)>0){
	
				return true;
	
			}else{
	
				return false;
	
			}
	
		}
		
		function insertPosition($varArray)

	{	$insertQry = $this->getInsertDataString($varArray, 'candidate_position');

		updateData($insertQry);

		return mysql_insert_id();

	}

	function getPositionVariables()

	{	$varArray['position_name'] = $_REQUEST['position_name'];
		return $varArray;

	}
	
	// candidate status
	
	function getAllCandidateStatus($show='1')

		{

			if($show == 0)

				$arr_orders =  getData("select * from `candidate_status` ");

			elseif($show == 1)

				$arr_orders =  getData("select * from `candidate_status` where is_active=1");

			elseif($show == 2)

				$arr_orders =  getData("select * from `candidate_status` where is_active=0");

			return $arr_orders;

		}

		

		function get_all_counts_CandidateStatus()

		{

			$arr_counts = array();

			$all = getOne("SELECT COUNT(status_id) AS CNT From candidate_status WHERE 1");

			$arr_counts['all'] = $all;

			$active = getOne("SELECT COUNT(status_id) AS CNT From candidate_status WHERE is_active = 1");

			$arr_counts['active'] = $active;

			$trash = getOne("SELECT COUNT(status_id) AS CNT From candidate_status WHERE is_active = 0");

			$arr_counts['trash'] = $trash;

			return $arr_counts;

			

		}

		

		function restore_CandidateStatus($id)

		{

			$change_data = array (

									'is_active' => 1,							

									); 

			$change_data['status_id'] = $id;

			$updateQry=$this->getUpdateDataString($change_data,"candidate_status","status_id");

			updateData($updateQry);

			

		}
		function getCandidateStatusDetails($status_id)

		{
	
			return $resultSet = getRow("select * from  `candidate_status` where is_active =1 AND status_id='".$status_id."'");
	
		}
		function isCandidateStatusExist($status_name,$status_id=0)
		{

			$query="select * from candidate_status where status_name='".$status_name."' and is_active=1";
	
			if($status_id!=0){
	
				$query.=" AND status_id!=".$status_id;
	
			}
	
			$resultSet = getData($query);
	
			if(sizeof($resultSet)>0){
	
				return true;
	
			}else{
	
				return false;
	
			}
	
		}
		
		function insertCandidateStatus($varArray)

	{	$insertQry = $this->getInsertDataString($varArray, 'candidate_status');

		updateData($insertQry);

		return mysql_insert_id();

	}

	function getCandidateStatusVariables()

	{	$varArray['status_name'] = $_REQUEST['status_name'];
		return $varArray;

	}
		
	function updateUsingId($dataArray,$table,$field_name)
	{

		$updateQry=$this->getUpdateDataString($dataArray,$table,$field_name);
	
		updateData($updateQry);

	}
	function deleteUsingId($field_name,$field_value,$table){

		updateData("UPDATE ".$table." SET `is_active`=0 WHERE ".$field_name."='".$field_value."'");

	}

	


}
?>