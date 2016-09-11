<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class SupplierManager extends commonObject
{
	public $db_fields;
	function SupplierManager()
	{
		$this->db_fields = array();	
	}	
	
	function getSupplierDetailsById($supplierId)
	{
		return $resultSet = getRow("SELECT * FROM `supplier` where supplier_id=".$supplierId);	
	}
	
	function getAllSuppliers($value=0)
	{
		if($value == 1)
			return $resultSet = getData("SELECT * FROM `supplier` where 1");
		else if($value == 2)
			return $resultSet = getData("SELECT * FROM `supplier` where is_active=0");	
		else
			return $resultSet = getData("SELECT * FROM `supplier` where is_active=1");		
	}
	
	function get_allcounts()
	{
		$arr_counts = array();
		$all = getOne("SELECT COUNT(supplier_id) AS CNT From supplier WHERE1");
		$arr_counts['all'] = $all;
		$active = getOne("SELECT COUNT(supplier_id) AS CNT From supplier WHERE is_active = 1");
		$arr_counts['active'] = $active;
		$trash = getOne("SELECT COUNT(supplier_id) AS CNT From supplier WHERE is_active = 0 ");
		$arr_counts['deleted'] = $trash;
		return $arr_counts;
		
	}
	
	function restoreSupplier($supplier_id)
	{
		updateData("UPDATE supplier SET is_active=1 WHERE supplier_id=".$supplier_id);	
	}
	
	function getSupplierVariables()
	{
		$this->db_fields['supplier_name'] = $_REQUEST['supplier_name'];
		$this->db_fields['email'] = $_REQUEST['email'];
		$this->db_fields['address'] = $_REQUEST['address'];
		$this->db_fields['city'] = $_REQUEST['city'];
		$this->db_fields['state'] = $_REQUEST['state'];
		$this->db_fields['country'] = $_REQUEST['country'];
		$this->db_fields['zip'] = $_REQUEST['zip'];	
		$this->db_fields['phone1'] = $_REQUEST['phone1'];
		if(isset($_REQUEST['phone2'])){
			$this->db_fields['phone2'] = $_REQUEST['phone2'];
		}
		$this->db_fields['currency'] = $_REQUEST['currency'];
	}
	
}
?>