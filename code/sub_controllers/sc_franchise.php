<?php

/****************************************************************
*	This file is made up with the code.
*	Please maintain the code structure as it is.
*	There is 'view' case added by default.
*	It is default case for any subcontroller.(DON'T DELETE IT!)
*	You can include any model that you want to use at the top of the page.
*	If you want to pass any data to view add it to '$data' array. (As shown in sample)
*	If you want to populate any notification pass it through '$notificationArray' array.(As shown in sample)
*	You can use 'showmsg()' function to show the generel message for add, update, delete event.
*	If you want to show some custom message, you can add it to array named '$arr_msg' defined in constants.php
*	If you want to change the view page to other than set in $_POST['page'], use $page variable (As shown in sample)
******************************************************************/

/*
Include model sample

require_once('library/modelManager.php');
$modelObject= new ModelManager();
*/
require_once('library/franchiseManager.php');
$franchiseObject= new FranchiseManager();
require_once('library/userManager.php');
$userObject= new UserManager();
require_once('library/warehouseManager.php');
$warehouseObject = new WarehouseManager();

	switch($function)
	{	
		case "view":
		case "view_franchise":
			// YOUR LOGIC GOES HERE
			// DON'T DELETE THIS CASE!!!(Doing this will make the application vulnurable)
			$data['show_status']=$show_status;
			$data['allFranchise'] = $franchiseObject->get_franchises($show_status);
			$data['rec_counts'] = $franchiseObject->get_all_counts();
			$page = "manage_franchise.php";
			
			// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////
		break;
		
		case "show_franchise_form":
			
			if(intval($_POST['edit_id']) !== 0)
			{	
				$franchiseDetails = $franchiseObject->getRecordById('franchise_id',$_POST['edit_id']);
				$data['franchiseDetails']  = $franchiseDetails;
				$franchise_user_name = $franchiseObject->getFranchiseUserName($franchiseDetails['franchise_id']);
				$data['franchiseDetails']['userName'] = $franchise_user_name;
				$is_edit=true;
			}
			$page = "add_edit_franchise.php";
			
			// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////
		break;
		
		case "save_franchise":
			$franchiseObject->getFranchiseVariables();
			$franchiseVariables = $franchiseObject->db_fields;
			//print_r($franchiseVariables );exit;
			if(intval($_POST['edit_id']) !== 0)
			{		
				$franchiseVariables['franchise_id'] = $_POST['edit_id'];
		
				if($franchiseObject->isFranchiseExists($franchiseVariables['franchise_code'],$franchiseVariables['franchise_id'])){
					
					$franchiseVariables['modified_by']=$_SESSION['user_id'];
					$franchiseVariables['modified_date']=date('Y-m-d H:i:s');
					$statusIdInserted = $franchiseObject->update($franchiseVariables,'franchise','franchise_id');
					$franchiseVariables['franchise_username'] = $_POST['franchise_username'];
					//$franchiseVariables['user_id'] = $franchiseObject->getFranchiseUserId($franchiseVariables['franchise_id']);
					$user_id = $franchiseObject->updateFranchiseInUser($franchiseVariables);
					//unset($franchiseVariables['franchise_username']);
					
					//print_r($franchiseVariables); exit;
					$previousPass=$userObject->getFranchisePassword($franchiseVariables['franchise_id']);
					$sha1_currentpass=sha1($_POST['franchise_password']);
					if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
						$userObject->setPassword($previousPass,$franchiseVariables['franchise_id']);
					}
					
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Franchise','update');					
					$page="manage_franchise.php";
				}else{
					$is_exist = true;
					$data['franchiseDetails'] = $franchiseVariables;
					$franchise_user_name = $franchiseObject->getFranchiseUserName($franchiseVariables['franchise_id']);
					$data['franchiseDetails']['userName'] = $franchise_user_name;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('Franchise','dup','franchis-code');
					$page = "add_edit_franchise.php"; 					
				}
				$is_edit=true;
				
			}
			else
			{
				if($franchiseObject->isFranchiseExists($franchiseVariables['franchise_code'])){
					$franchiseVariables['added_by']=$_SESSION['user_id'];
					$franchiseVariables['added_date']=date('Y-m-d H:i:s');	
					
					$franchise_id = $franchiseObject->insert($franchiseVariables,'franchise');
					
					$franchiseVariables['franchise_id'] = $franchise_id;
					$franchiseVariables['franchise_username'] = $_POST['franchise_username'];
					$franchiseVariables['franchise_password'] = $_POST['franchise_password'];
					/*  This will add new franchise in user table to create franchise admin*/
					$user_id = $franchiseObject->insertFranchiseInUser($franchiseVariables);
					//unset($franchiseVariables['franchise_username']);
					//unset($franchiseVariables['franchise_password']);
					//$franchiseObject->addUserIdInFranchise($user_id,$franchise_id);				
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Franchise','add'); 
					$page="manage_franchise.php";
				}else{
					$is_exist = true;
					//$data['franchiseDetails'] = $franchiseVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('Franchise','dup','franchis-code'); 
					$page = "add_edit_franchise.php";
				}
			}
			$data['show_status']=$show_status;
			$franchiseVariables['franchise_username'] = $_POST['franchise_username'];
			$franchiseVariables['franchise_password'] = $_POST['franchise_password'];
			$data['franchiseVariables'] = $franchiseVariables;
			$data['allFranchise'] = $franchiseObject->get_franchises();
			$data['rec_counts'] = $franchiseObject->get_all_counts();
			
			// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////
		break;
		
		case "delete_franchise":
			$franchise_id = $_POST['edit_id'];
			$franchiseObject->delete($franchise_id,'franchise','franchise_id');
			$notificationArray['type'] = 'Success';
			$notificationArray['message'] = showmsg('Franchise','delete');
			$data['allFranchise'] = $franchiseObject->get_franchises();
			$data['rec_counts'] = $franchiseObject->get_all_counts();
			$data['show_status'] = $show_status;
			$page = "manage_franchise.php";
			
				// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////
		break;
		
		case "restore_franchise" :
			$franchiseObject->restoreEntry('franchise_id', $_POST['edit_id']);
			$data['allFranchise'] = $franchiseObject->get_franchises();
			$data['rec_counts'] = $franchiseObject->get_all_counts();
			$data['show_status'] = $show_status;
			$notificationArray['type'] = 'Success';
			$notificationArray['message'] = showmsg('Franchise','restore');
			$page = "manage_franchise.php";	
			
				// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////		
		break;
			/**** End of Frenchise ****/
			
			/**** Warehouse Managment ****/
			case "view_warehouse":
				
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses($show_status);
				$data['show_status'] = $show_status;
				$data['rec_counts'] = $warehouseObject->get_allcounts();
				$page = "manage_warehouse.php";
				
					// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////
			break;
			
			case "show_warehouse_form":
				if(intval($_POST['edit_id']) !== 0)
				{	
					$data['allFranchise'] = $franchiseObject->get_franchises(0);
					$warehouseDetails=$warehouseObject->getRecordById('warehouse_id',$_POST['edit_id']);
					$data['warehouseDetails']  = $warehouseDetails;
					$is_edit = true;
				}
				else
				{
					$data['allFranchise'] = $franchiseObject->get_franchises(1);
				}
				$data['show_status'] = 1;
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses();
				$page = "add_edit_warehouse.php";
				
					// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////
			break;
			
			case "save_warehouse":
				$warehouseObject->getWarehouseVariables();
				$warehouseVariables = $warehouseObject->db_fields;
				if(intval($_POST['edit_id']) !== 0)
				{	$warehouse_id = $_POST['edit_id'];
					$warehouseVariables['warehouse_id'] = $warehouse_id;
					if(!$warehouseObject->isItemCodeExist($warehouseVariables['warehouse_code'],$warehouse_id)){
						$warehouseVariables['modified_by'] = $_SESSION['user_id'];
						$warehouseVariables['modified_date'] = date('Y-m-d H:i:s');
						$warehouseIdInserted = $warehouseObject->update($warehouseVariables,'warehouse_id');
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Warehouse','update');
						$page = "manage_warehouse.php";
						
					}
					else
					{
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('Warehouse','dup','Warehouse Code');
						$is_edit = true;
						$is_exist = true;
						$data['warehouseDetails'] = $warehouseVariables;
						$page = "add_edit_warehouse.php";
					}
				}
				else
				{
					if(!$warehouseObject->isItemCodeExist($warehouseVariables['warehouse_code'])){
						$warehouseVariables['added_by'] = $_SESSION['user_id'];
						$warehouseIdInserted = $warehouseObject->insert($warehouseVariables,'warehouse');
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Warehouse','add');
						$page = "manage_warehouse.php";
					}
					else
					{
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('Warehouse','dup','Warehouse Code');
						$is_exist = true;
						//$data['warehouseDetails'] = $warehouseVariables;
						$page = "add_edit_warehouse.php";
					}
				}
				$data['show_status'] = 1;
				$data['warehouseVariables'] = $warehouseVariables;
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses();
				$data['rec_counts'] = $warehouseObject->get_allcounts();
				
					// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////
			break;
			
			case "delete_warehouse":
				$warehouse_id=$_POST['edit_id'];
				$warehouseObject->delete($warehouse_id,'warehouse_id');
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses();
				$data['rec_counts'] = $warehouseObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Warehouse','delete'); 
				$data['show_status'] = 1;
				$page="manage_warehouse.php";
				
					// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////
			break;
			
			case "restore_warehouse":
				$warehouse_id=$_POST['edit_id'];
				//$warehouseObject->restoreWarehouse($warehouse_id);
				$warehouseObject->restoreEntry('warehouse_id',$warehouse_id);
				$data['allWarehouses'] = $warehouseObject->getAllWarehouses();
				$data['rec_counts'] = $warehouseObject->get_allcounts();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Warehouse','restore');
				$data['show_status'] = 1;
				$page="manage_warehouse.php";
				
					// for managing actions permissions
		if(isset($mainfunction))
		{	
			$data['mainfunction'] = $mainfunction;
			$data['subfunction_name'] = $subfunction_name;							
		}
		else
		{
			$data['mainfunction'] = $_POST['mainfunction'];
			$data['subfunction_name'] = $_POST['subfunction_name'];	
		}
		$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
		$data['arr_permission'] = $arr_permissions;				
		///////////////////////////////////
			break;
			/**** End Of Warehouse Managment ****/
	}
?>
