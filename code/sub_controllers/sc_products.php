<?php
require_once('library/userManager.php');
$userObject= new UserManager();
require_once('library/groupManager.php');
$groupObject= new GroupManager();
require_once('library/productManager.php');
$productObject = new ProductManager();
require_once('library/clientManager.php');
$clientObject = new ClientManager();
extract($_POST);

	switch($function){
			case "view":
					if(isset($show_status)){
						$show_status = $show_status;
					}
					else
					$show_status = 1;
					$data['allProducts'] = $productObject->getAllproducts($show_status);
					$data['rec_counts'] = $productObject->get_allcounts();
					$data['current_show'] = $show_status;
					
					$page = "manage_products.php";	
			break;
			
			case "restore_product" :
					
					$productObject->restore_product($edit_id);
					$data['allProducts'] = $productObject->getAllproducts($show_status);
					$data['rec_counts'] = $productObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('product','restore');
					$page = "manage_products.php";	
			break;
			
			case "show_add_product":
				$page = "add_edit_products.php";
			break;
			
			case "add_product":
					$productVariables = $productObject->getProductVariables();
					if(!$productObject->isItemCodeExist($productVariables['item_code']))
					{
						$productVariables['added_by']=$_SESSION['user_id'];
						$productVariables['added_date']=date('Y-m-d H:i:s');	
						$productIdInserted = $productObject->insertProduct($productVariables);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('product','add');
						$page = "manage_products.php";	
					}
					else
					{
						$is_exist = true;
						$data['productDetails'] = $productVariables;
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('product','dup','item code');  
						$page = "add_edit_products.php";
					}
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allProducts'] = $productObject->getAllproducts($show_status);
					$data['rec_counts'] = $productObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_products.php";
			break;
			
			case "edit_product":
				$productId = $_REQUEST['edit_id'];				
				$productDetails = $productObject->getProductDetails($productId);
			   $data['productDetails'] = $productDetails;				
				$page="add_edit_products.php";
			break;
			
			
			case "edit_product_entry":
				$productVariables = $productObject->getProductVariables();
				$productVariables['product_id'] = $_REQUEST['product_id'];
				if(!$productObject->isItemCodeExist($productVariables['item_code'],$productVariables['product_id']))
				{
					$productVariables['modified_by']=$_SESSION['user_id'];
					$productVariables['modified_date']=date('Y-m-d H:i:s');	
					$productObject->updateUsingId($productVariables);
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('product','update');
					$page="manage_products.php";
				}
				else
				{	
					$is_exist = true;
					$is_edit = true;
					$data['productDetails'] = $productVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('product','dup','item code'); 
					$page = "add_edit_products.php";
				}
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allProducts'] = $productObject->getAllproducts($show_status);
				$data['rec_counts'] = $productObject->get_allcounts();
				$data['current_show'] = $show_status;
				
				break;
			
			case "delete_product":	
					//echo "hii";exit;
					$product_id=$_REQUEST['edit_id'];
					$productObject->deleteUsingId($product_id);
					$data['allProducts'] = $productObject->getAllProducts();
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('product','delete');
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;	
					$data['allProducts'] = $productObject->getAllproducts($show_status);
					$data['rec_counts'] = $productObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_products.php";	
			break;
			
		}

?>
