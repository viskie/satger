<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class SaleManager extends commonObject
{
		public $db_fields;
		function SaleManager()
		{
			$this->db_fields = array();	
		}
		
		function getAllSale()
		{
			return $resultSet = getData("SELECT * FROM `sales` where is_active='1'");
		}
		
		function getWarehouseId($saleIdInserted)
		{
			return $sale_id= getOne("select warehouse_id from sales where sale_id=".$saleIdInserted);
		}
		
		function getSaleById($sale_id)
		{
			return $resultSet = getRow("select * from  sales where sale_id='".$sale_id."'");
		}
		
		function getSaleDetailsById($sale_id)
		{
			return $resultSet = getData("select * from  sale_details where sale_id='".$sale_id."'");
		}
		
		function isRecieptExist($reciept_no,$sale_id=0){
			$query="select * from sales where reciept_no='".$reciept_no."'";
			if($sale_id!=0){
				$query.=" AND sale_id!=".$sale_id;
			}
			$resultSet = getData($query);
			if(sizeof($resultSet)>0){
				return true;
			}else{
				return false;
			}
		}
		
		function insertSale($saleArray)
		{
			$insertQry = getInsertDataString($saleArray, 'sales');
			updateData($insertQry);
			return mysql_insert_id();
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
	
		function getSaleVariables()
		{
			$this->db_fields['reciept_no'] = $_REQUEST['reciept_no'];
			$this->db_fields['warehouse_id'] = $_REQUEST['warehouse_id'];
			$this->db_fields['client_id'] = $_REQUEST['client'];
			$this->db_fields['sale_date'] = $_REQUEST['sale_date'];
			$this->db_fields['tax'] = $_REQUEST['tax'];
			$this->db_fields['discount'] = $_REQUEST['discount'];
			$this->db_fields['total_invoice_amount'] = $_REQUEST['total_invoice_amount'];
			
			//return $varArray;
		}
		
		function getSaleDetailsVariables()
		{	 $varArray=array();
			 $varArray['product_id'] = $_REQUEST['product_id'];
			 $varArray['quantity'] = $_REQUEST['quantity'];
			 $varArray['unit_cost'] = $_REQUEST['unit_cost'];
			 $varArray['total_cost'] = $_REQUEST['total_cost'];
			 return $varArray;
		}
}
?>