<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class PurchaseManager extends commonObject
{
	public $db_fields;
		function PurchaseManager()
		{
			$this->db_fields = array();	
		}
		
		function getAllPurchase()
		{
			return $resultSet = getData("SELECT * FROM `purchase` where is_active='1'");
		}
		
		function getPurchaseById($purchase_id)
		{
			return $resultSet = getRow("select * from  purchase where purchase_id='".$purchase_id."'");
		}
		
		function getPurchaseDetailsById($purchase_id)
		{
			return $resultSet = getData("select * from  purchase_details where purchase_id='".$purchase_id."'");
		}
		
		function getPurchaseVariables()
		{
			$this->db_fields['reciept_no'] = $_REQUEST['reciept_no'];
			$this->db_fields['warehouse_id'] = $_REQUEST['warehouse_id'];
			$this->db_fields['supplier_id'] = $_REQUEST['supplier_id'];
			$this->db_fields['purchase_date'] = $_REQUEST['purchase_date'];
			$this->db_fields['tax'] = $_REQUEST['tax'];
			$this->db_fields['discount'] = $_REQUEST['discount'];
			$this->db_fields['total_invoice_amount'] = $_REQUEST['total_invoice_amount'];
			
			//return $varArray;
		}
		
		function getPurchaseDetailsVariables()
		{	 $varArray=array();
			 $varArray['product_id'] = $_REQUEST['product_id'];
			 $varArray['quantity'] = $_REQUEST['quantity'];
			 $varArray['unit_cost'] = $_REQUEST['unit_cost'];
			 $varArray['total_cost'] = $_REQUEST['total_cost'];
			
			
			return $varArray;
		}
		
		function getWarehouseId($purchaseIdInserted)
		{
			return $purchase_id= getOne("select warehouse_id from purchase where purchase_id=".$purchaseIdInserted);
		}
		
		function insertPurchase($PurchaseArray)
		{
			$insertQry = getInsertDataString($PurchaseArray, 'purchase');
			updateData($insertQry);
			return mysql_insert_id();
		}
		
		function insertPurchaseDetails($PurchaseDetailsArray)
		{	//var_dump($PurchaseDetailsArray);exit;
			
			$insertQry = getInsertDataString($PurchaseDetailsArray, 'purchase_details');
			updateData($insertQry);
			return mysql_insert_id();
		}
		
		function isRecieptExist($reciept_no,$purchase_id=0){
		$query="select * from purchase where reciept_no='".$reciept_no."'";
		if($purchase_id!=0){
			$query.=" AND purchase_id!=".$purchase_id;
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	function isProductExistInInventory($product_id,$warehouse_id)
	{
		$query = "SELECT * FROM inventory WHERE warehouse_id ='".$warehouse_id."' AND product_id='".$product_id."'";
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;	
		}
		else{
			return false;
		}
	}
	
	function insertBulkLines($data_array, $feild_array, $table_name){
		insertBulk($data_array, $feild_array, $table_name);
	}
}