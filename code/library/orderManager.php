<?php

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

class OrderManager extends commonObject
{
	function get_allstatus($show='1')
	{
		if($show == 0)
			$arr_status = getData("SELECT * From status WHERE 1 ORDER BY status_order ASC");
		elseif($show == 1)
			$arr_status = getData("SELECT * From status WHERE is_active=1 ORDER BY status_order ASC");
		elseif($show == 2)
			$arr_status = getData("SELECT * From status WHERE is_active=0 ORDER BY status_order ASC");
		return ($arr_status);
	}
	
	function insertstatus($data, $edit_id='')
	{		
		$insert_data = array (
							'name' => $data['txtstatus'],
							'status_order'	=> $data['txtorder'],
							'modified_date' => date("Y-m-d H:i:s"),
							'modified_by' => $data['userid']
							);
		if(isset($data['is_trash']) && ($data['is_trash'] == 1))
			$insert_data['is_active'] = 0;	
		else				 	
			$insert_data['is_active'] = 1;		
				
		if($edit_id != "")
		{
			$check_exist = getData('SELECT * From status WHERE name="'.$data['txtstatus'].'" and id NOT IN ("'.$edit_id.'")');
			$check_order_exist = getData("SELECT * From status WHERE  status_order=".$data['txtorder'].' and id NOT IN ("'.$edit_id.'")');
			if(count($check_exist)>0 && count($check_order_exist)>0)
			{
				return "both_exist";
			}
			elseif(count($check_exist)>0)
			{
				return "name_exist";
			}
			elseif(count($check_order_exist)>0)
			{
				return "order_exist";
			}
			$insert_data['id'] = $edit_id;
			$updateQry=$this->getUpdateDataString($insert_data,"status","id");
			updateData($updateQry);
			return "update";
		}
		else
		{
			$check_exist = getData('SELECT * From status WHERE name="'.$data['txtstatus'].'"');
			$check_order_exist = getData("SELECT * From status WHERE status_order=".$data['txtorder']);
			if(count($check_exist)>0 && count($check_order_exist)>0)
			{
				return "both_exist";
			}
			elseif(count($check_exist)>0)
			{
				return "name_exist";
			}
			elseif(count($check_order_exist)>0)
			{
				return "order_exist";
			}
			$insert_data['added_date'] = date("Y-m-d H:i:s");
			$insert_data['added_by'] = $data['userid'];
			$insertQry = getInsertDataString($insert_data, 'status');
			updateData($insertQry);
			return "insert";			
		}
	}
	function get_statusdata($edit_id)
	{
		$arr_status = getData("SELECT * From status WHERE id =".$edit_id);
		return ($arr_status);	
	}
	function delete_status($edit_id,$is_trash='')
	{
		if($is_trash == 1)
		{
			$delquery = "DELETE FROM status WHERE id =".$edit_id;
			updateData($delquery);			
		}
		else
		{
			$change_data = array (
								'is_active' => 0,							
								); 
			$change_data['id'] = $edit_id;
			$updateQry=$this->getUpdateDataString($change_data,"status","id");
			updateData($updateQry);
		}
	}
	function get_all_statuscounts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(id) AS CNT From status WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(id) AS CNT From status WHERE is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(id) AS CNT From status WHERE is_active = 0");
		$arr_counts['trash'] = $trash;
		return $arr_counts;
		
	}
	function restore_status($id)
	{
		$change_data = array (
								'is_active' => 1,							
								); 
		$change_data['id'] = $id;
		$updateQry=$this->getUpdateDataString($change_data,"status","id");
		updateData($updateQry);		
	}
	function get_allgroups()
	{
		$arr_groups =  getData("SELECT group_id, group_name From user_groups WHERE is_active = 1");
		return ($arr_groups);
	}
	function get_allOrders($show='0')
	{
		if($show == 0)
			$arr_orders =  getData("SELECT * From sales_order WHERE 1 order by is_active DESC");
		elseif($show == 1)
			$arr_orders =  getData("SELECT * From sales_order WHERE is_active = 1");
		elseif($show == 2)
			$arr_orders =  getData("SELECT * From sales_order WHERE is_active = 0");
		return $arr_orders;
	}
	function get_allcounts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(order_id) AS CNT From sales_order WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(order_id) AS CNT From sales_order WHERE is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(order_id) AS CNT From sales_order WHERE is_active = 0");
		$arr_counts['trash'] = $trash;
		return $arr_counts;
		
	}
	
	function get_userstatus($userid)
	{	//echo $userid;
		$grp_id = getData("SELECT user_group From users WHERE user_id =".$userid);
		//echo ($grp_id);
		$arr_status =  getData("SELECT PERM.status_id, STATUS.name From (SELECT user_group From users WHERE user_id =".$userid.") AS USER LEFT JOIN (SELECT status_id, group_id FROM status_permissions WHERE status_category = 'order') AS PERM ON USER.user_group = PERM.group_id LEFT JOIN (SELECT name, id FROM status WHERE 1) AS STATUS ON STATUS.id = PERM.status_id  WHERE 1");
		return $arr_status;
	}
	function save_order($arr_data)
	{	
		
		$insert_data = array(
						'reciept_no' => $arr_data['txtreciept_no'],
						'warehouse_id' 	=> $arr_data['warehouse_id'],
						'client_id' => $arr_data['client'],
						'order_date' => $arr_data['txtorderdate_alt'],
						'tax' => $arr_data['tax'],
						'discount' => $arr_data['discount'],
						'total_invoice_amount' => $arr_data['total_invoice_amount'],						
						'is_active' => 1
						);
		if($arr_data['show_status'] == 2)
			$insert_data['is_active'] = 0;
		else
			$insert_data['is_active'] = 1;
		if(isset($arr_data['selstatus']))
			$insert_data['status_id'] = $arr_data['selstatus'];
		else
		{
			$get_statusid = getOne("SELECT ID FROM status WHERE name = 'New'");	
			$insert_data['status_id'] = $get_statusid;
		}
		if(isset($arr_data['edit_id']) && ($arr_data['edit_id'] != ""))
		{	
			$insert_data['order_id'] = $arr_data['edit_id'];
			$updateQry=$this->getUpdateDataString($insert_data,"sales_order","order_id");
			updateData($updateQry);
			
			$delquery = "DELETE FROM order_details WHERE order_id =".$arr_data['edit_id'];
			updateData($delquery);
			for($i=0; $i<count($arr_data['product_id']); $i++)
			{
				$insert_detail_data = array(
						'order_id' => $arr_data['edit_id'],
						'product_id' 	=> $arr_data['product_id'][$i],
						'quantity' => $arr_data['quantity'][$i],
						'unit_cost' => $arr_data['unit_cost'][$i],
						'total_cost' => $arr_data['total_cost'][$i],
						'is_active' => 1,						
						);
				$insertQry = getInsertDataString($insert_detail_data, 'order_details');
				updateData($insertQry);
			}
		}
		else
		{
			$insertQry = getInsertDataString($insert_data, 'sales_order');
			updateData($insertQry);
			$insert_id = mysql_insert_id();
			for($i=0; $i<count($arr_data['product_id']); $i++)
			{
				$insert_detail_data = array(
						'order_id' => $insert_id,
						'product_id' 	=> $arr_data['product_id'][$i],
						'quantity' => $arr_data['quantity'][$i],
						'unit_cost' => $arr_data['unit_cost'][$i],
						'total_cost' => $arr_data['total_cost'][$i],
						'is_active' => 1,						
						);
				$insertQry = getInsertDataString($insert_detail_data, 'order_details');
				updateData($insertQry);
			}
		}
		
	}
	function isRecieptExist($reciept_no,$order_id=0){
			$query="select * from sales_order where reciept_no='".$reciept_no."'";
			if($order_id!=0){
				$query.=" AND order_id!=".$order_id;
			}
			$resultSet = getData($query);
			if(sizeof($resultSet)>0){
				return true;
			}else{
				return false;
			}
		}
	function delete_order($id,$is_trash='')
	{
		if($is_trash == 1)
		{
			$delquery = "DELETE FROM sales_order WHERE order_id =".$id;
			updateData($delquery);
			$delquery = "DELETE FROM sales_order WHERE order_id =".$id;
			updateData($delquery);
		}
		else
		{
			$change_data = array (
								'is_active' => 0,							
								); 
			$change_data['order_id'] = $id;
			$updateQry=$this->getUpdateDataString($change_data,"sales_order","order_id");
			updateData($updateQry);
			$updateQry=$this->getUpdateDataString($change_data,"order_details","order_id");
			updateData($updateQry);
		}
	}
	function restore_order($id)
	{
		$change_data = array (
								'is_active' => 1,							
								); 
		$change_data['order_id'] = $id;
		$updateQry=$this->getUpdateDataString($change_data,"sales_order","order_id");
		updateData($updateQry);
		$updateQry=$this->getUpdateDataString($change_data,"order_details","order_id");
		updateData($updateQry);
	}
	function get_orderdata($id,$from_table='')
	{
		if($from_table == 'details')
			$order_data =  getData("SELECT ORDERDET.*, PROD.product_name From order_details AS ORDERDET LEFT JOIN (SELECT product_name, product_id FROM  products) AS PROD ON ORDERDET.product_id = PROD.product_id WHERE ORDERDET.order_id=".$id." ");
		else
			$order_data =  getData("SELECT * From sales_order WHERE order_id=".$id);
		
		return $order_data;
	}
	
	
	// Queries related functions
	function selectQuery($tbTable,$tbFields,$tbCondition="",$tbShowQuery="")
	{
		$result_arr = array();
		if($tbCondition != "")
		{
			$sql = "SELECT ".$tbFields." From ".$tbTable." WHERE ".$tbCondition."";
			
		}else
		{
			$sql = "SELECT ".$tbFields." From ".$tbTable."";
		} 
		if($tbShowQuery==1)
		{
			return $sql;
		}
		$result = $this->myQuery($sql);
		while($record = mysql_fetch_assoc($result))
		{
			$result_arr[] = $record;
		}
		return $result_arr;
		
	}
	function insertQuery($tbTable,$data,$tbCondition="")
	{
		$cnt=count($data);
		if($cnt>0)
		{
			$str = "";
			foreach($data as $key => $values)
			{
				$str.= "`".$key."`='".$values."'";
				$cnt = $cnt-1;
				if($cnt-1>=0)
				{
					$str.= ",";
				}
			}
			$sql = "INSERT INTO  ".$tbTable." SET ".$str."";	//echo $sql; exit;
			if($err = $this->myQuery($sql))
			{
				return mysql_insert_id();
			}else{
				return false;
			}
			
		}else
		{
			echo "data array is empty";
		}
		echo $sql;
	}
	function updateQuery($tbTable,$data,$tbCondition="")
	{
		$cnt=count($data);
		if($cnt>0)
		{
			$str = "";
			foreach($data as $key => $values)
			{
				$str.= "`".$key."`='".$values."'";
				$cnt = $cnt-1;
				if($cnt-1>=0)
				{
					$str.= ",";
				}
			}
			if($tbCondition != "")
			{
				$sql = "UPDATE ".$tbTable." SET ".$str." WHERE ".$tbCondition."";
			}else
			{
				$sql = "UPDATE ".$tbTable." SET ".$str."";
			}
			$this->myQuery($sql);
			return mysql_affected_rows();	
		}else
		{
			echo "data array is empty";
		}
	}
	function deleteQuery($tbTable,$tbCondition="")
	{
		if($tbCondition!="")
		{
			$isThere = $this->selectQuery($tbTable,'*',$tbCondition);
			if(count($isThere)>0)
			{
				$sql = "DELETE FROM ".$tbTable." WHERE ".$tbCondition."";
				$this->myQuery($sql);
				return mysql_affected_rows();	
			}
		}else
		{
			/*************Uncomment this code *************************
				$sql = "DELETE FROM ".$tbTable."";
				$this->myQuery($sql);
				return mysql_affected_rows();	
			**************/
		}	
	}
	function myQuery($sql)
	{
	
		if($result = mysql_query($sql))
		{
			return $result;
		}else
		{
			return false;
			//echo mysql_error();
			exit;
		}
	}
	function multi_in_array($needle, $haystack, $strict = false) 
	{
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && multi_in_array($needle, $item, $strict))) {
				return true;
			}
		}
    	return false; 	
	} 
	
	
} 
?>
