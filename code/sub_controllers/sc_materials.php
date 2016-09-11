<?php
require_once('library/userManager.php');
$userObject= new UserManager();
require_once('library/supplierManager.php');
$supplierObject= new SupplierManager();
require_once('library/materialManager.php');
$materialObject= new MaterialManager();
require_once('library/warehouseManager.php');
$warehouseObject= new WarehouseManager();
require_once('library/purchaseManager.php');
$purchaseObject= new PurchaseManager();
require_once('library/productManager.php');
$productObject= new ProductManager();
require_once('library/inventoryManager.php');
$inventoryObject = new InventoryManager();

	switch($function){
						
			/***** Cases For Suppliers *****/
			case "view_supplier":
				if(isset($_REQUEST['show_status']))
				{
					if($_REQUEST['show_status'] == 0)
					{
						$data['allSuppliers'] = $supplierObject->getAllSuppliers(1);
					}
					else if($_REQUEST['show_status'] == 2)
					{
						$data['allSuppliers'] = $supplierObject->getAllSuppliers(2);
					}
					else
					{
						$data['allSuppliers'] = $supplierObject->getAll('supplier');
					}
				}
				else
				{
					$data['allSuppliers'] = $supplierObject->getAll('supplier');
					$_REQUEST['show_status'] = 1;
				}
				$data['rec_counts'] = $supplierObject->get_allcounts();
				$page = "manage_suppliers.php";
			break;
			
			case "show_add_supplier":
				$page = "add_edit_supplier.php";
			break;
			
			case "add_supplier":
				$supplierObject->getSupplierVariables();
				$supplierVariables = $supplierObject->db_fields;
				$supplierVariables['added_by'] = $_SESSION['user_id'];
				$supplierIdInserted = $supplierObject->insert($supplierVariables,'supplier');
				$data['allSuppliers'] = $supplierObject->getAll('supplier');
				$data['rec_counts'] = $supplierObject->get_allcounts();
				//echo "---".$supplierIdInserted; exit;
				$page = "manage_suppliers.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Supplier','add');
			break;
			
			case "edit_supplier":
				$supplierId = $_REQUEST['edit_id'];				
				$supplierDetails = $supplierObject->getSupplierDetailsById($supplierId);
			    $data['supplierDetails'] = $supplierDetails;			
				$page = "add_edit_supplier.php";
			break;
			
			case "edit_supplier_entry":
				$supplierObject->getSupplierVariables();
				$supplierVariables = $supplierObject->db_fields;
				$supplierVariables['supplier_id'] = $_REQUEST['edit_id'];
				$supplierVariables['modified_by'] = $_SESSION['user_id'];
				$supplierVariables['modified_date'] = date('Y-m-d H:i:s');
				$supplierIdInserted = $supplierObject->update($supplierVariables,'supplier','supplier_id');
				$data['allSuppliers'] = $supplierObject->getAll('supplier');
				$data['rec_counts'] = $supplierObject->get_allcounts();
				$page = "manage_suppliers.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Supplier','update');
			break;
			
			case "delete_supplier":
				$supplier_id=$_REQUEST['edit_id'];
				$supplierObject->delete($supplier_id,'supplier','supplier_id');
				$data['allSuppliers'] = $supplierObject->getAll('supplier');
				$data['rec_counts'] = $supplierObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Supplier','delete');
				$page="manage_suppliers.php";
			break;
			
			case "restore_supplier":
				$supplier_id=$_REQUEST['edit_id'];
				$supplierObject->restoreSupplier($supplier_id);
				$data['allSuppliers'] = $supplierObject->getAll('supplier');
				$data['rec_counts'] = $supplierObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Supplier','restore');
				$page="manage_suppliers.php";
			break;
			/***** End Of Supplier Cases *****/
			
			/***** Cases For Materials *****/
			case "view_material":
				if(isset($_REQUEST['show_status']))
				{
					if($_REQUEST['show_status'] == 0)
					{
						$data['allMaterials'] = $materialObject->getAllMaterial('materials',1);
					}
					else if($_REQUEST['show_status'] == 2)
					{
						$data['allMaterials'] = $materialObject->getAllMaterial('materials',2);
					}
					else
					{
						$data['allMaterials'] = $materialObject->getAll('materials');	
					}
				}
				else
				{
					$data['allMaterials'] = $materialObject->getAll('materials');
				}
				$data['rec_counts'] = $materialObject->get_allcounts();
				
				//$data['allMaterials'] = $materialObject->getAll('materials');
				$page="manage_materials.php";
			break;
			
			case "show_add_material":
				$page = "add_edit_material.php";
			break;
			
			case "add_material":
				$materialObject->getMaterialVariables();
				$materialVariables = $materialObject->db_fields;
				$materialVariables['added_by'] = $_SESSION['user_id'];
				$materialIdInserted = $materialObject->insert($materialVariables,'materials');
				$data['allMaterials'] = $materialObject->getAll('materials');
				$data['rec_counts'] = $materialObject->get_allcounts();
				$page = "manage_materials.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Material','add');
			break;
			
			case "edit_material":
				$materialId = $_REQUEST['edit_id'];				
				$materialDetails = $materialObject->getMaterialDetailsById($materialId);
			    $data['materialDetails'] = $materialDetails;			
				$page = "add_edit_material.php";
			break;
			
			case "edit_material_entry":
				$materialObject->getMaterialVariables();
				$materialVariables = $materialObject->db_fields;
				$materialVariables['material_id'] = $_REQUEST['edit_id'];
				$materialVariables['modified_by'] = $_SESSION['user_id'];
				$materialVariables['modified_date'] = date('Y-m-d H:i:s');
				$materialIdInserted = $materialObject->update($materialVariables,'materials','material_id');
				$data['allMaterials'] = $materialObject->getAll('materials');
				$data['rec_counts'] = $materialObject->get_allcounts();
				$page = "manage_materials.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Material','update'); 
			break;
			
			case "delete_material":
				$material_id=$_REQUEST['edit_id'];
				$materialObject->delete($material_id,'materials','material_id');
				$data['allMaterials'] = $materialObject->getAll('materials');
				$data['rec_counts'] = $materialObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Material','delete');
				$page="manage_materials.php";
			break;
			
			case "restore_material":
				$marerial_id=$_REQUEST['edit_id'];
				$materialObject->restoreMatrial($marerial_id);
				$data['allMaterials'] = $materialObject->getAll('materials');
				$data['rec_counts'] = $materialObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Material','restore');
				$page="manage_materials.php";
			break;
			
			/***** End Of Material Cases *****/
			
			/**** Start of purchase  ****/
			
			case "view":
			case "view_purchase":
				$data['allPurchases'] = $purchaseObject->getAllPurchase();
				$page = "manage_purchase.php";
			break;
			
			case "show_add_purchase":
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses();
				$data['allSuppliers'] = $supplierObject->getAllSuppliers();
				$data['allProducts'] = $productObject->getAllProducts();
				$page = "add_purchase.php";
			break;
			
			case "add_purchase":
				//var_dump($_REQUEST);exit;
				$purchaseObject->getPurchaseVariables();
				$purchaseVariables = $purchaseObject->db_fields;
				
				$purchaseDetailsVariables =$purchaseObject->getPurchaseDetailsVariables();
				//print_r($purchaseDetailsVariables); exit;
				$no_of_records=0;
				foreach($purchaseDetailsVariables as $field=>$value)
				{
					$no_of_records = count($value);
				}
				//echo $no_of_records; exit;
				$no_of_fields = count($purchaseDetailsVariables);
				$array_records = array();
				$fields_array = array('purchase_id','reciept_no','product_id','quantity','unit_cost','total_cost');
				
				if(!$purchaseObject->isRecieptExist($purchaseVariables['reciept_no']))
				{	
					$purchaseVariables['added_by'] = $_SESSION['user_id'];
					$purchaseVariables['added_date'] = date('Y-m-d H:i:s');
					$purchaseIdInserted = $purchaseObject->insertPurchase($purchaseVariables);
					//$purchaseDetailsIdInserted = $purchaseObject->insertPurchaseDetails($purchaseDetailsVariables);
				
					for($j=0;$j<$no_of_records;$j++)
					{
						  array_push($array_records,array("purchase_id"=>$purchaseIdInserted,"reciept_no"=>$purchaseVariables['reciept_no'],"product_id"=>$purchaseDetailsVariables['product_id'][$j],"quantity"=>$purchaseDetailsVariables['quantity'][$j],"unit_cost"=>$purchaseDetailsVariables['unit_cost'][$j],"total_cost"=>$purchaseDetailsVariables['total_cost'][$j]));
					}
				
					//var_dump($array_records);exit;
					$purchaseObject->insertBulkLines($array_records, $fields_array, 'purchase_details');
					
					$warehouse_id = $purchaseObject->getWarehouseId($purchaseIdInserted);
					for($i=0;$i<count($array_records);$i++){
						if($purchaseObject->isProductExistInInventory($array_records[$i]['product_id'],$warehouse_id)){
							//update product in inventory
							$inventoryObject->updateProduct($array_records[$i],$warehouse_id,0);
						}else{
							//insert product in inventory
							$inventoryObject->insertProduct($array_records[$i],$warehouse_id);
						}
					}
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Purchase','add');
					$page = "manage_purchase.php";
				}
				else
				{
					$is_exist = true;
					$data['purchaseDetails'] = $purchaseVariables;
					for($j=0;$j<$no_of_records;$j++)
					{
						  array_push($array_records,array("reciept_no"=>$purchaseVariables['reciept_no'],"product_id"=>$purchaseDetailsVariables['product_id'][$j],"quantity"=>$purchaseDetailsVariables['quantity'][$j],"unit_cost"=>$purchaseDetailsVariables['unit_cost'][$j],"total_cost"=>$purchaseDetailsVariables['total_cost'][$j]));
					}
					$data['purchase'] = $array_records;
					$data['product'] = $inventoryObject->getProductsOfWarehouse($purchaseVariables['warehouse_id']);
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('reciept','dup','reciept number');
					$page = "add_purchase.php";
				}
				
				$data['allPurchases'] = $purchaseObject->getAllPurchase();
				$data['allPurchase'] = $purchaseObject->getAllPurchase();
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses();
				$data['allSuppliers'] = $supplierObject->getAllSuppliers();
				$data['allProducts'] = $productObject->getAllProducts();
				
			break;
			
			case "view_purchase_details" :
				$purchase_id = $_REQUEST['edit_id'];
				$data['purchase'] = $purchaseObject->getPurchaseById($purchase_id);
				$data['warehouse'] = $warehouseObject->getWarehouseDetailsById($data['purchase']['warehouse_id']);
				$data['supplier'] = $supplierObject->getSupplierDetailsById($data['purchase']['supplier_id']);
				$data['purchaseDetails'] = $purchaseObject->getPurchaseDetailsById($purchase_id);
				foreach($data['purchaseDetails'] as $val){
					$data['productName'][] = $productObject->getProductDetails($val['product_id']);
				}
				$page = "add_purchase.php";
			break;
			
			/*** end of Purchase ***/
			
			
	}
?>