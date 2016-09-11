<?php
require_once('library/userManager.php');
$userObject= new UserManager();
require_once('library/groupManager.php');
$groupObject= new GroupManager();
require_once('library/clientManager.php');
$clientObject = new ClientManager();
require_once('library/leadManager.php');
$leadObject = new LeadManager();
require_once('library/productManager.php');
$productObject = new ProductManager();
require_once('library/saleManager.php');
$saleObject = new SaleManager();
require_once('library/warehouseManager.php');
$warehouseObject= new WarehouseManager();
require_once('library/supplierManager.php');
$supplierObject= new SupplierManager();
require_once('library/inventoryManager.php');
$inventoryObject = new InventoryManager();
extract($_POST);

	switch($function){
			case "view":
			case"view_sales":
				$data['allSales'] = $saleObject->getAllSale();
				$page = "manage_sales.php";	
			break;
			
			case "show_add_sale":
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses(0);
				$data['allClients'] = $clientObject->getAllClients();
				$data['allProducts'] = $productObject->getAllProducts(1);
				$page = "add_sale.php";
			break;
			
			case "add_sale":
				
				$saleObject->getSaleVariables();
				$saleVariables = $saleObject->db_fields;
				
				$saleDetailsVariables =$saleObject->getSaleDetailsVariables();
				//print_r($purchaseDetailsVariables); exit;
				$no_of_records=0;
				foreach($saleDetailsVariables as $field=>$value)
				{
					$no_of_records = count($value);
				}
				//echo $no_of_records; exit;
				$no_of_fields = count($saleDetailsVariables);
				$array_records = array();
				$fields_array = array('sale_id','product_id','quantity','unit_cost','total_cost');
				
				if(!$saleObject->isRecieptExist($saleVariables['reciept_no']))
				{
					$saleVariables['added_by'] = $_SESSION['user_id'];
					$saleVariables['added_date'] = date('Y-m-d H:i:s');
					$saleIdInserted = $saleObject->insertSale($saleVariables);
					//$purchaseDetailsIdInserted = $purchaseObject->insertPurchaseDetails($purchaseDetailsVariables);
				
					for($j=0;$j<$no_of_records;$j++)
					{
						  array_push($array_records,array("sale_id"=>$saleIdInserted,"product_id"=>$saleDetailsVariables['product_id'][$j],"quantity"=>$saleDetailsVariables['quantity'][$j],"unit_cost"=>$saleDetailsVariables['unit_cost'][$j],"total_cost"=>$saleDetailsVariables['total_cost'][$j]));
					}
				
					//var_dump($array_records);exit;
					$saleObject->insertBulkLines($array_records, $fields_array, 'sale_details');
					
					for($i=0;$i<count($array_records);$i++){
						if(!$saleObject->isProductExistInInventory($array_records[$i]['product_id'],$saleVariables['warehouse_id']))
						{
							//insert product in inventory
							$inventoryObject->insertProduct($array_records[$i],$saleVariables['warehouse_id']);
						}else{
							//update product in inventory
							$inventoryObject->updateProduct($array_records[$i],$saleVariables['warehouse_id'],1);
						}
					}
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('sale','add'); 
					$page = "manage_sales.php";
				}
				else
				{
					$is_exist = true;
					$data['saleDetails'] = $saleVariables;
					for($j=0;$j<$no_of_records;$j++)
					{
						  array_push($array_records,array("product_id"=>$saleDetailsVariables['product_id'][$j],"quantity"=>$saleDetailsVariables['quantity'][$j],"unit_cost"=>$saleDetailsVariables['unit_cost'][$j],"total_cost"=>$saleDetailsVariables['total_cost'][$j]));
					}
					$data['sale'] = $array_records;
					$data['product'] = $inventoryObject->getProductsOfWarehouse($saleVariables['warehouse_id']);
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('reciept','dup','number');  
					$page = "add_sale.php";
				}
				
				//$data['allPurchases'] = $purchaseObject->getAllPurchase();
				$data['allSales'] = $saleObject->getAllSale();
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses(0);
				$data['allClients'] = $clientObject->getAllClients();
				$data['allProducts'] = $productObject->getAllProducts(1);
				
			break;
			
			case "view_sale_details":
				$sale_id = $_REQUEST['edit_id'];
				$data['sale'] = $saleObject->getSaleById($sale_id);
				//print_r($data['sale']); exit;
				$data['warehouse'] = $warehouseObject->getWarehouseDetailsById($data['sale']['warehouse_id']);
				$data['client'] = $clientObject->getClientById($data['sale']['client_id']);
				//print_r($data['client']); exit;
				$data['saleDetails'] = $saleObject->getSaleDetailsById($sale_id);
				foreach($data['saleDetails'] as $val){
					$data['productName'][] = $productObject->getProductDetails($val['product_id']);
				}
				$page = "add_sale.php";
			break;
			
			case "get_product_ajax":
				$warehouse_id = $_REQUEST['warehouse_id'];
				header('content-type:application/json');
				$response['product'] = $inventoryObject->getProductsOfWarehouse($warehouse_id);
				echo json_encode($response['product']);
				exit;
			break;
			
			/******* Cases of lead********/
			case "view_leads":
					//$data['allLeads'] = $leadObject->getAll('lead');
					if(isset($_REQUEST['show_status']))
					{
						if($_REQUEST['show_status'] == 0)
						{
							$data['allLeads'] = $leadObject->getAllLeads(0);
						}
						else if($_REQUEST['show_status'] == 1)
						{
							$data['allLeads'] = $leadObject->getAllLeads(1);
						}
						else if($_REQUEST['show_status'] == 2)
						{
							$data['allLeads'] = $leadObject->getAllLeads(2);	
						}
						else if($_REQUEST['show_status'] == 3)
						{
							$data['allLeads'] = $leadObject->getAllLeads(3);	
						}
					}
					else
					{
						$data['allLeads'] = $leadObject->getAllLeads(1);
						$_REQUEST['show_status'] = 1;
					}
					foreach($data['allLeads'] as $key=>$val){
						//print_r($val['client_id']);
						$data['lead_source'][] = $leadObject->getSourceById($val['source_id']);
						//$data['lead_client'][] = $clientObject->getClientById($val['client_id']);
						$data['lead_client'][] = $val['lead_name'];
						$data['lead_product'][] = $productObject->getProductDetails($val['product_id']);
						$data['lead_status'][] = $leadObject->getStatusById($val['status_id']);
						$data['lead_substatus'][] = $leadObject->getSubStatusById($val['substatus_id']);
						$data['priority'][] = $leadObject->getPriorityById($val['priority_id']);
					}
					$data['rec_counts'] = $leadObject->get_allcounts();
					$page = "manage_leads.php";
			break;
			
			case "show_add_leads":
				//$data['clientDetails'] = $clientObject->getAllClients();
				$data['product'] = $productObject->getAllProducts(1);
				$data['source'] = $leadObject->getAllSource(0);
				$data['status'] = $leadObject->getAllStatus(0);
				$data['priority'] = $leadObject->getAllPriorities();
				$page = "add_edit_leads.php";
			break;
			
			case "add_lead":
				$leadObject->getAllLeadVariable();
				$lead_variables = $leadObject->db_fields;
				$lead_variables['handled_by'] = $_SESSION['user_id'];
				
				$lead_variables['added_by']=$_SESSION['user_id'];
				$lead_variables['added_date']=date('Y-m-d H:i:s');
				
				$leadIdInserted = $leadObject->insert($lead_variables,'lead');
				
				$data['allLeads'] = $leadObject->getAllLeads(1);
				foreach($data['allLeads'] as $key=>$val){
					//print_r($val['client_id']);
					$data['lead_source'][] = $leadObject->getSourceById($val['source_id']);
					//$data['lead_client'][] = $clientObject->getClientById($val['client_id']);
					$data['lead_client'][] = $val['lead_name'];
					$data['lead_product'][] = $productObject->getProductDetails($val['product_id']);
					$data['lead_status'][] = $leadObject->getStatusById($val['status_id']);
					$data['lead_substatus'][] = $leadObject->getSubStatusById($val['substatus_id']);
					$data['priority'][] = $leadObject->getPriorityById($val['priority_id']);
				}
				
				
				if($_REQUEST['lead_notes']!="")
				{
					$varArray=array();
					$varArray['lead_id']=$leadIdInserted;
					$varArray['user_id']=$_SESSION['user_id'];
					$varArray['added_date'] = date('Y-m-d H:i:s');
					$varArray['notes']=preg_replace("/\r\n|\r|\n/", ' ', $_REQUEST['lead_notes']);
					$leadnoteIdInserted = $leadObject->insertLeadNote($varArray);
				}
				
				$_REQUEST['show_status'] = 1;
				$data['rec_counts'] = $leadObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('lead','add'); 
				$page = "manage_leads.php";
			break;
			
			case "edit_lead":
				//$data['clientDetails'] = $clientObject->getAllClients();
				$data['product'] = $productObject->getAllProducts(0);
				$data['source'] = $leadObject->getAllSource(1);
				$data['status'] = $leadObject->getAllStatus(1);
				$data['priority'] = $leadObject->getAllPriorities();
				
				$edit_lead_id = $_REQUEST['edit_id'];
				$leadDetails = $leadObject->getLeadDetailsUsingId($edit_lead_id);
				$data['leadDetails'] = $leadDetails;
				
				$lead_note_details = $leadObject->getNotesOfLead($edit_lead_id);
			   	$data['leadNoteDetails'] = $lead_note_details;
				//print_r($data);exit;
				$page = "add_edit_leads.php";
			break;
			
			case "edit_lead_entry":
				$leadObject->getAllLeadVariable();
				$leadVariables = $leadObject->db_fields;
				
				$leadVariables['lead_id'] = $_REQUEST['edit_id'];
				
				$leadVariables['modified_by']=$_SESSION['user_id'];
				$leadVariables['modified_date']=date('Y-m-d H:i:s');
				
				$leadObject->update($leadVariables,"lead","lead_id");
				$data['allLeads'] = $leadObject->getAllLeads(1);
				foreach($data['allLeads'] as $key=>$val){
					//print_r($val['client_id']);
					$data['lead_source'][] = $leadObject->getSourceById($val['source_id']);
					//$data['lead_client'][] = $clientObject->getClientById($val['client_id']);
					$data['lead_client'][] = $val['lead_name'];
					$data['lead_product'][] = $productObject->getProductDetails($val['product_id']);
					$data['lead_status'][] = $leadObject->getStatusById($val['status_id']);
					$data['lead_substatus'][] = $leadObject->getSubStatusById($val['substatus_id']);
					$data['priority'][] = $leadObject->getPriorityById($val['priority_id']);
				}
				
				if($_REQUEST['lead_notes']!="")
				{
					$varArray=array();
					$varArray['lead_id']=$_REQUEST['edit_id'];
					$varArray['user_id']=$_SESSION['user_id'];
					$varArray['added_date'] = date('Y-m-d H:i:s');	
					$varArray['notes']=preg_replace("/\r\n|\r|\n/", ' ', $_REQUEST['lead_notes']);
					$leadnoteIdInserted = $leadObject->insertLeadNote($varArray);
				}
				
				$lead_note_details = $leadObject->getNotesOfLead($_REQUEST['edit_id']);
			   	$data['leadNoteDetails'] = $lead_note_details;
				$data['rec_counts'] = $leadObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('lead','update');
				$_REQUEST['show_status'] = 1;
				$page="manage_leads.php";
			break;

			case "get_substatus_ajax":
				$status_id = $_REQUEST['status_id'];
				header('content-type:application/json');
				$response['sub-status'] = $leadObject->getSubStatusByStatusId($status_id);
				echo json_encode($response['sub-status']);
				exit;
			break;
			
			case "delete_lead":
				$lead_id=$_REQUEST['edit_id'];
				$leadObject->delete($lead_id,'lead','lead_id');
				$data['allLeads'] = $leadObject->getAllLeads(1);
				foreach($data['allLeads'] as $key=>$val){
					//print_r($val['client_id']);
					$data['lead_source'][] = $leadObject->getSourceById($val['source_id']);
					$data['lead_client'][] = $val['lead_name'];
					$data['lead_product'][] = $productObject->getProductDetails($val['product_id']);
					$data['lead_status'][] = $leadObject->getStatusById($val['status_id']);
					$data['lead_substatus'][] = $leadObject->getSubStatusById($val['substatus_id']);
					$data['priority'][] = $leadObject->getPriorityById($val['priority_id']);
				}
				$data['rec_counts'] = $leadObject->get_allcounts();
				$_REQUEST['show_status'] = 1;
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('lead','delete');
				$page="manage_leads.php";
			break;
			
			case "restore_lead":
				$lead_id=$_REQUEST['edit_id'];
				$leadObject->restoreUsers($lead_id);
				$data['allLeads'] = $leadObject->getAllLeads(1);
				foreach($data['allLeads'] as $key=>$val){
					$data['lead_source'][] = $leadObject->getSourceById($val['source_id']);
					$data['lead_client'][] = $val['lead_name'];
					$data['lead_product'][] = $productObject->getProductDetails($val['product_id']);
					$data['lead_status'][] = $leadObject->getStatusById($val['status_id']);
					$data['lead_substatus'][] = $leadObject->getSubStatusById($val['substatus_id']);
					$data['priority'][] = $leadObject->getPriorityById($val['priority_id']);
				}
				
				$data['rec_counts'] = $leadObject->get_allcounts();
				$_REQUEST['show_status'] = 1;
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Lead Restore Successfully!';
				$page="manage_leads.php";
			break;
			
			case "archive_lead":
				if(isset($_REQUEST['archive_lead'])){
					$archive_leads = $_REQUEST['archive_lead'];
					$leadObject->archiveLead($archive_leads);
				}else{
					$lead_id=$_REQUEST['edit_id'];
					$leadObject->archiveLead($lead_id);
				}	
				$data['allLeads'] = $leadObject->getAllLeads(1);
				foreach($data['allLeads'] as $key=>$val){
					$data['lead_source'][] = $leadObject->getSourceById($val['source_id']);
					$data['lead_client'][] = $val['lead_name'];
					$data['lead_product'][] = $productObject->getProductDetails($val['product_id']);
					$data['lead_status'][] = $leadObject->getStatusById($val['status_id']);
					$data['lead_substatus'][] = $leadObject->getSubStatusById($val['substatus_id']);
					$data['priority'][] = $leadObject->getPriorityById($val['priority_id']);
				}
				
				$data['rec_counts'] = $leadObject->get_allcounts();
				$_REQUEST['show_status'] = 1;
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Lead Archived Successfully!';
				$page="manage_leads.php";
			break;
			
			case "un_archive_lead":
				//print_r($_REQUEST); exit;
				if(isset($_REQUEST['archive_lead'])){
					$un_archive_leads = $_REQUEST['archive_lead'];
					$leadObject->unArchiveLead($un_archive_leads);
				}else{
					$lead_id=$_REQUEST['edit_id'];
					$leadObject->unArchiveLead($lead_id);
				}	
				$data['allLeads'] = $leadObject->getAllLeads(1);
				foreach($data['allLeads'] as $key=>$val){
					$data['lead_source'][] = $leadObject->getSourceById($val['source_id']);
					$data['lead_client'][] = $val['lead_name'];
					$data['lead_product'][] = $productObject->getProductDetails($val['product_id']);
					$data['lead_status'][] = $leadObject->getStatusById($val['status_id']);
					$data['lead_substatus'][] = $leadObject->getSubStatusById($val['substatus_id']);
					$data['priority'][] = $leadObject->getPriorityById($val['priority_id']);
				}
				
				$data['rec_counts'] = $leadObject->get_allcounts();
				$_REQUEST['show_status'] = 1;
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Lead Un-Archived Successfully!';
				$page="manage_leads.php";
			break;
			/******* End of lead********/
			
			case "get_units_ajax":
				$product_id = $_REQUEST['product_id'];
				header('content-type:application/json');
				$response['units'] = $leadObject->getUnits($product_id);
				echo json_encode($response['units']);
				exit;
			break;
			
			// order management cases starts from here
						
			case "order_mngt" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
									
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['arr_orders'] = $orderObject->get_allOrders($show_status);
					$data['rec_counts'] = $orderObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_order.php";						
			break; 
			
			case "add_edit_order":
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					$data['allWarehouses'] = $warehouseObject->getAllWarehouses(0);
					$data['allClients'] = $clientObject->getAllClients();
					$data['allProducts'] = $productObject->getAllProducts(1);
					
					if(isset($edit_id) && $edit_id != "")
					{	
						$data['order_data'] = $orderObject->get_orderdata($edit_id);
						$data['order_details'] = $orderObject->get_orderdata($edit_id,'details');
						$sel_prod = array();
						$avail_units = array();
						foreach($data['order_details'] as $k=> $v)
						{
							$avail_units[] = $leadObject->getUnits($v['product_id']);
							$sel_prod[] = $v['product_id'];
						}
						$data['sel_prod'] = $sel_prod;
						$data['avail_units'] = $avail_units;
						$data['products'] = $inventoryObject->getProductsOfWarehouse($data['order_data'][0]['warehouse_id']);
						 
					} 
					$data['arr_status'] =  $orderObject->get_userstatus($_SESSION['user_id']);
					//echo "<pre>"; print_r($data['arr_status']);
					$data['is_edit'] = 'yes';
					$data['current_show'] = $show_status;
					$page = "add_edit_order.php";
			break;
			
			case "save_order" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					$orderObject->save_order($_POST);					
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['arr_orders'] = $orderObject->get_allOrders($show_status);
					$data['rec_counts'] = $orderObject->get_allcounts();
					$data['current_show'] = $show_status;
					if(isset($edit_id) && ($edit_id != ''))
						{$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Order','update'); 
						}
					else
						{$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Order','add'); 
						}
					$page = "manage_order.php";	
			break;
			
			case "delete_order" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					if($show_status == 2)
						$is_trash = 1;
					else
						$is_trash = '';
					$orderObject->delete_order($edit_id, $is_trash);
					$data['arr_orders'] = $orderObject->get_allOrders($show_status);
					$data['rec_counts'] = $orderObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Order','delete'); 
					$page = "manage_order.php";	
			break;
			
			case "restore_order" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					$orderObject->restore_order($edit_id);
					$data['arr_orders'] = $orderObject->get_allOrders($show_status);
					$data['rec_counts'] = $orderObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
$notificationArray['message'] = $arr_msg['order']['restore'];
					$page = "manage_order.php";	
			break;
			
			case "check_receipt_exist" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					if((isset($edit_id) && ($edit_id != '') && ($orderObject->isRecieptExist($reciept_no,$edit_id))) || ($edit_id == '' && $orderObject->isRecieptExist($reciept_no)))
					{
						echo "exist";
					}
					else
					{
						echo "not exist";
					}
					exit;
			break;
			
			// order management cases ends here
					
	}
?>	