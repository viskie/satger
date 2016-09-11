<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class InventoryManager extends commonObject
{
	public $db_fields;
	function InventoryManager()
	{
		$this->db_fields = array();	
	}
	
	function getAllInventories($show='1')
		{
			if($show == 0)
				$arr_orders =  getData("SELECT I.*,product_name,name
			FROM `inventory` I LEFT JOIN `products` P ON I.product_id=P.product_id
			LEFT JOIN `warehouse` W ON I.warehouse_id=W.warehouse_id ");
			elseif($show == 1)
				$arr_orders =  getData("SELECT I.*,product_name,name
			FROM `inventory` I LEFT JOIN `products` P ON I.product_id=P.product_id
			LEFT JOIN `warehouse` W ON I.warehouse_id=W.warehouse_id where I.is_active=1");
			elseif($show == 2)
				$arr_orders =  getData("SELECT I.*,product_name,name
			FROM `inventory` I LEFT JOIN `products` P ON I.product_id=P.product_id
			LEFT JOIN `warehouse` W ON I.warehouse_id=W.warehouse_id where I.is_active=0");
			return $arr_orders;
		}
		
		function get_allcounts()
		{
			$arr_counts = array();
			$all = getOne("SELECT COUNT(inventory_id) AS CNT From inventory WHERE 1");
			$arr_counts['all'] = $all;
			$active = getOne("SELECT COUNT(inventory_id) AS CNT From inventory WHERE is_active = 1");
			$arr_counts['active'] = $active;
			$trash = getOne("SELECT COUNT(inventory_id) AS CNT From inventory WHERE is_active = 0");
			$arr_counts['trash'] = $trash;
			return $arr_counts;
			
		}
		
		function restore_inventory($id)
		{
			$change_data = array (
									'is_active' => 1,							
									); 
			$change_data['inventory_id'] = $id;
			$updateQry=$this->getUpdateDataString($change_data,"inventory","inventory_id");
			updateData($updateQry);
			
		}
	
	/*function getAllInventories()
		{
			return $resultSet = getData("SELECT I.*,product_name,name
			FROM `inventory` I LEFT JOIN `products` P ON I.product_id=P.product_id
			LEFT JOIN `warehouse` W ON I.warehouse_id=W.warehouse_id where I.is_active=1");
		}*/
		
	function getInventoryVariables()
	{
		$varArray['product_id'] = $_REQUEST['product_id'];
		$varArray['warehouse_id'] = $_REQUEST['warehouse_id'];
		$varArray['basic_cost'] = $_REQUEST['basic_cost'];	
		$varArray['units'] = $_REQUEST['units'];	
		$varArray['remarks'] = $_REQUEST['remarks'];	
		
		return $varArray;
	}
	
	function getProductsOfWarehouse($warehouse_id){
		return $resultSet = getData("SELECT DISTINCT(p.product_id),p.product_name FROM `inventory` i LEFT JOIN `products` p ON i.product_id=p.product_id WHERE i.`units`>0 AND i.`warehouse_id`='".$warehouse_id."'");
	}
	
	function getInventoryById($inventoryId)
	{
		return $resultSet = getRow("select * from  `inventory` where is_active =1 AND inventory_id='".$inventoryId."'");
	}
	
	/* */
	function insertProduct($array_records,$warehouse_id)
	{
		updateData("insert into inventory (product_id,warehouse_id,basic_cost,units,added_by,added_date) values ('".$array_records['product_id']."','".$warehouse_id."','".$array_records['unit_cost']."','".$array_records['quantity']."','".$_SESSION['user_id']."','date')");
	}
	
	function updateProduct($array_records,$warehouse_id,$val)
	{
		if($val == 0){
		updateData("update inventory set units=units+".$array_records['quantity'].",modified_by='".$_SESSION['user_id']."',modified_date='date' where product_id='".$array_records['product_id']."' and warehouse_id='".$warehouse_id."'");
		}
		else
		{
			updateData("update inventory set units=units-".$array_records['quantity'].",modified_by='".$_SESSION['user_id']."',modified_date='date' where product_id='".$array_records['product_id']."' and warehouse_id='".$warehouse_id."'");	
		}
	}
}
?>