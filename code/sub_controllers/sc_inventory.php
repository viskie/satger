<?
require_once('library/franchiseManager.php');
$franchiseObject= new FranchiseManager();
require_once('library/warehouseManager.php');
$warehouseObject = new WarehouseManager();
require_once('library/productManager.php');
$productObject = new ProductManager();
require_once('library/inventoryManager.php');
$inventoryObject = new InventoryManager();
extract($_POST);

		switch($function)
		{
			/**** Warehouse Managment ****/
			case "view_warehouse":
				//$data['allWarehouses'] = $warehouseObject->getAll('warehouse'); 
				if(isset($_REQUEST['show_status']))
				{
					if($_REQUEST['show_status'] == 0)
					{
						$data['allWarehouses'] = $warehouseObject->getAllWarehouses(1);
					}
					else if($_REQUEST['show_status'] == 2)
					{
						$data['allWarehouses'] = $warehouseObject->getAllWarehouses(2);
					}
					else
					{
						$data['allWarehouses'] = $warehouseObject->getAll('warehouse');
					}
				}
				else
				{
					$data['allWarehouses'] = $warehouseObject->getAll('warehouse');
					
				}
				$data['rec_counts'] = $warehouseObject->get_allcounts();
				$page = "manage_warehouse.php";
			break;
			
			case "show_add_warehouse":
				$data['allFranchise'] = $franchiseObject->get_franchises(1);
				$page = "add_edit_warehouse.php";
			break;
			
			case "add_warehouse":
				$warehouseObject->getWarehouseVariables();
				$warehouseVariables = $warehouseObject->db_fields;
				$warehouseVariables['added_by'] = $_SESSION['user_id'];
				$warehouseIdInserted = $warehouseObject->insert($warehouseVariables,'warehouse');
				$data['allWarehouses'] = $warehouseObject->getAll('warehouse');
				$data['rec_counts'] = $warehouseObject->get_allcounts();
				$page = "manage_warehouse.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Warehouse','add'); 
			break;
			
			case "edit_warehouse":
				$data['allFranchise'] = $franchiseObject->get_franchises(0);
				$warehouseId = $_REQUEST['edit_id'];				
				$warehouseDetails = $warehouseObject->getWarehouseDetailsById($warehouseId);
			    $data['warehouseDetails'] = $warehouseDetails;			
				$page = "add_edit_warehouse.php";
			break;
			
			case "edit_warehouse_entry":
				$warehouseObject->getWarehouseVariables();
				$warehouseVariables = $warehouseObject->db_fields;
				$warehouseVariables['warehouse_id'] = $_REQUEST['edit_id'];
				$warehouseVariables['modified_by'] = $_SESSION['user_id'];
				$warehouseVariables['modified_date'] = date('Y-m-d H:i:s');
				$warehouseIdInserted = $warehouseObject->update($warehouseVariables,'warehouse','warehouse_id');
				$data['allWarehouses'] = $warehouseObject->getAll('warehouse');
				$data['rec_counts'] = $warehouseObject->get_allcounts();
				$page = "manage_warehouse.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Warehouse','update'); 
			break;
			
			case "delete_warehouse":
				$warehouse_id=$_REQUEST['edit_id'];
				$warehouseObject->delete($warehouse_id,'warehouse','warehouse_id');
				$data['allWarehouses'] = $warehouseObject->getAll('warehouse');
				$data['rec_counts'] = $warehouseObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Warehouse','delete'); 
				$page="manage_warehouse.php";
			break;
			
			case "restore_warehouse":
				$warehouse_id=$_REQUEST['edit_id'];
				$warehouseObject->restoreWarehouse($warehouse_id);
				$data['allWarehouses'] = $warehouseObject->getAll('warehouse');
				$data['rec_counts'] = $warehouseObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Warehouse','restore'); 
				$page="manage_warehouse.php";
			break;
			/**** End Of Warehouse Managment ****/
			
			// *********Inventory Management ****************
			case "view":
			case "view_inventory":
				$data['allProducts'] = $productObject->getAllProducts(1);
				$data['allWarehouses'] = $warehouseObject->getAll('warehouse'); 
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allInventories'] = $inventoryObject->getAllInventories($show_status);
				$data['rec_counts'] = $inventoryObject->get_allcounts();
				$data['current_show'] = $show_status;
				$page = "manage_inventory.php";
			break;
			
			case "restore_inventory" :
					
					$inventoryObject->restore_inventory($edit_id);
					$data['allInventories'] = $inventoryObject->getAllInventories($show_status);
					$data['rec_counts'] = $inventoryObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('inventory','restore');
					$page = "manage_inventory.php";	
			break;
			
			case "show_add_inventory":
				$data['allProducts'] = $productObject->getAllProducts(1);
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses(0); 
				$page = "add_edit_inventory.php";
			break;
			
			case "add_inventory":
				
				$inventoryVariables =$inventoryObject->getInventoryVariables();
				
				$inventoryVariables['added_by']=$_SESSION['user_id'];
				$inventoryVariables['added_date']=date('Y-m-d H:i:s');
				
				$inventoryIdInserted = $inventoryObject->insert($inventoryVariables,'inventory');
				$data['allProducts'] = $productObject->getAllProducts();
				$data['allWarehouses'] = $warehouseObject->getAll('warehouse'); 
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Inventory','add'); 
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allInventories'] = $inventoryObject->getAllInventories($show_status);
				$data['rec_counts'] = $inventoryObject->get_allcounts();
				$data['current_show'] = $show_status;
				$page = "manage_inventory.php";
			break;
			
			case "edit_inventory":
				$data['allProducts'] = $productObject->getAllProducts(0);
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses(1); 
				$inventoryId = $_REQUEST['edit_id'];				
				$inventoryDetails = $inventoryObject->getInventoryById($inventoryId);
			    $data['inventoryDetails'] = $inventoryDetails;
				$data['inventoryDetails']['inventory_id'] = $inventoryId;
				$page="add_edit_inventory.php";
			break;
			
			case "edit_inventory_entry":
				$inventoryVariables =$inventoryObject->getInventoryVariables();
				$inventoryVariables['inventory_id'] = $_REQUEST['edit_id'];
				$inventoryVariables['modified_by']=$_SESSION['user_id'];
				$inventoryVariables['modified_date']=date('Y-m-d H:i:s');
				$inventoryObject->update($inventoryVariables,"inventory","inventory_id");
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Inventory','update');
				$data['allProducts'] = $productObject->getAllProducts();
				$data['allWarehouses'] = $warehouseObject->getAll('warehouse');
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allInventories'] = $inventoryObject->getAllInventories($show_status);
				$data['rec_counts'] = $inventoryObject->get_allcounts();
				$data['current_show'] = $show_status;
				$page = "manage_inventory.php"; 
				
			break;
			
			case "delete_inventory":			
				$inventory_id=$_REQUEST['edit_id'];
				$inventoryObject->delete($inventory_id,'inventory','inventory_id');
				$data['allProducts'] = $productObject->getAllProducts();
				$data['allWarehouses'] = $warehouseObject->getAll('warehouse'); 
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Inventory','delete');
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allInventories'] = $inventoryObject->getAllInventories($show_status);
				$data['rec_counts'] = $inventoryObject->get_allcounts();
				$data['current_show'] = $show_status;
				$page = "manage_inventory.php"; 
			break;
			
			/**** End Of Inventory Managment ****/
		}
?>