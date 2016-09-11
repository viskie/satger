<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class WarehouseManager extends commonObject
{
	public $db_fields;
	function WarehouseManager()
	{
		$this->db_fields = array();	
	}
	
	function getWarehouseDetailsById($warehouseId)
	{
		return $resultSet = getRow("SELECT * FROM `warehouse` where warehouse_id=".$warehouseId);	
	}
	function getWarehouseVariables()
	{
		$this->db_fields['warehouse_code'] = $_REQUEST['warehouse_code'];
		$this->db_fields['name'] = $_REQUEST['name'];
		$this->db_fields['address'] = $_REQUEST['address'];
		$this->db_fields['city'] = $_REQUEST['city'];
		$this->db_fields['state'] = $_REQUEST['state'];
		$this->db_fields['country'] = $_REQUEST['country'];
		$this->db_fields['zip'] = $_REQUEST['zip'];	
		if(isset($_REQUEST['note'])){
			$this->db_fields['note'] = $_REQUEST['note'];
		}
		$this->db_fields['franchise_id'] = $_POST['franchise_id'];
	}
	
	function getAllWarehouses($value=0)
	{
		if($value == 1)
			return $resultSet = getData("SELECT * FROM `warehouse` where 1");
		else if($value == 2)
			return $resultSet = getData("SELECT * FROM `warehouse` where is_active=0");
		else
			return $resultSet = getData("SELECT * FROM `warehouse` where is_active=1");
	}
	
	function get_allcounts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(warehouse_id) AS CNT From warehouse WHERE 1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(warehouse_id) AS CNT From warehouse WHERE is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(warehouse_id) AS CNT From warehouse WHERE is_active = 0 ");
		$arr_counts['deleted'] = $trash;
		return $arr_counts;
		
	}
	
	function restoreWarehouse($warehouse_id)
	{
		updateData("UPDATE warehouse SET is_active=1 WHERE warehouse_id=".$warehouse_id);
	}
}
?>