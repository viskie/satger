<?php
require_once('library/userManager.php');
$userObject= new UserManager();
require_once('library/groupManager.php');
$groupObject= new GroupManager();
require_once('library/clientManager.php');
$clientObject = new ClientManager();

extract($_POST);

	switch($function){
			case "view":
					
					if(isset($show_status))
					{
					$show_status = $show_status;
					}
					else
					$show_status = 1;
					$data['allClients'] = $clientObject->getAllclients($show_status);
					
					$data['rec_counts'] = $clientObject->get_allcounts();
					$data['current_show'] = $show_status;
					
					$page = "manage_clients.php";	
			break;
			
			case "show_add_client":
				$page = "add_edit_clients.php";			
			break;
			
			case "add_client":
					
						$clientObject->getClientVariables();
						$clientVariables = $clientObject->db_fields;
						if(!$clientObject->isClientExist($clientVariables['client_biz_name'],$clientVariables['client_name']))
						{
							$clientVariables['client_admin_user_id'] = $_SESSION['user_id'];
							
							$clientVariables['added_by']=$_SESSION['user_id'];
							$clientVariables['added_date']=date('Y-m-d H:i:s');
							
							$clientIdInserted = $clientObject->insert($clientVariables,'clients');
							
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('client','add');
						}
						else
						{
							$notificationArray['type'] = 'Failed';
							$notificationArray['message'] = showmsg('client','dup','client name'); 
						}
					
				
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allClients'] = $clientObject->getAllclients($show_status);
					$data['rec_counts'] = $clientObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_clients.php";
				
			break;
			
			case "edit_client":
				$clientId = $_REQUEST['edit_id'];				
				$clientDetails = $clientObject->getClientDetails($clientId);
			    $data['clientDetails'] = $clientDetails;			
			
				$userId  = $clientDetails['client_admin_user_id'];
				$userDetails=$userObject->getUserDetails($userId);
				$data['userDetails'] = $userDetails;
				$page="add_edit_clients.php";
			break;
			
			case "edit_client_entry":
			
				$clientObject->getClientVariables();
				$clientVariables = $clientObject->db_fields;
				$clientVariables['client_id'] = $_REQUEST['client_id'];
				if(!$clientObject->isClientExist($clientVariables['client_biz_name'],$clientVariables['client_name'],$clientVariables['client_id']))
				{
					$clientVariables['modified_by']=$_SESSION['user_id'];
					$clientVariables['modified_date']=date('Y-m-d H:i:s');
					
					$clientObject->update($clientVariables,"clients","client_id");
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('client','update');
				}
				else
				{
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('client','dup','update');
				}
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allClients'] = $clientObject->getAllclients($show_status);
					$data['rec_counts'] = $clientObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_clients.php";
				
			break;
			
			case "delete_client":			
				//print_r($_REQUEST);exit;
				$client_id=$_REQUEST['edit_id'];
				$clientObject->delete($client_id,'clients','client_id');
				$data['allClients'] = $clientObject->getAll('clients');
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('client','delete');
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allClients'] = $clientObject->getAllclients($show_status);
					$data['rec_counts'] = $clientObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_clients.php";
			break;
			
			case "restore_client" :
					
					$clientObject->restore_client($edit_id);
					$data['allClients'] = $clientObject->getAllclients($show_status);
					$data['rec_counts'] = $clientObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('client','restore');
					$page = "manage_clients.php";	
			break;
		}

?>
