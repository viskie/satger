<?php
require_once('library/userManager.php');
$userObject= new UserManager();
require_once('library/groupManager.php');
$groupObject= new GroupManager();
require_once('library/pageManager.php');
$pageObject = new PageManager();
require_once('library/functionManager.php');
$functionObject = new FunctionManager();
	switch($function){
			case "users":
				if(isset($_REQUEST['show_status']))
				{
					if($_REQUEST['show_status'] == 0)
					{
						$data['allUsers'] = $userObject->getAllUsers('users',1);
					}
					else if($_REQUEST['show_status'] == 2)
					{
						$data['allUsers'] = $userObject->getAllUsers('users',2);
					}
					else
					{
						$data['allUsers'] = $userObject->getAll('users');	
					}
				}
				else
				{
					$data['allUsers'] = $userObject->getAll('users');
					$_REQUEST['show_status'] = 1;
				}
				$data['rec_counts'] = $userObject->get_allcounts();
				$data['allGroups']=$groupObject->get_Groups(1);
				
				// for managing actions permissions
				if(isset($_POST['mainfunction']))
				{
					$data['mainfunction'] = $_POST['mainfunction'];
					$data['subfunction_name'] = $_POST['subfunction_name'];					
				}
				else
				{
					$data['mainfunction'] = $mainfunction;
					$data['subfunction_name'] = $subfunction_name;
				}
				
				$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
				$data['arr_permission'] = $arr_permissions;	
				///////////////////////////////////
			break;
			
			/*case "show_add_user":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){	
					$data['allGroups']=$groupObject->getAll('user_groups');
					$allLanguages=getAllLanguages();
					$defaultLanguage=1;
					foreach($allLanguages as $language){
						if($language['is_default']=='1'){
							$data['defaultLanguage']=$language['id'];
							break;
						}
					}
					$data['allLanguages'] = $allLanguages;
					$page = "add_new_user.php";
				}else
				{
					$no_access = true;	
				}	
			break;*/
			
			case "add_user":
					$userObject->getUserVariables();
					$userVariables = $userObject->db_fields;
				
					if(!$userObject->isUserExist($userVariables['user_name'])){
						
						$userPassword=$userVariables['user_password'];
						$userVariables['user_password']="";
						
						$userVariables['added_by']=$_SESSION['user_id'];
						$userVariables['added_date']=date('Y-m-d H:i:s');
						
						$user_id=$userObject->insert($userVariables,'users');
						$userObject->setPassword($userPassword,$user_id);
						
						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
						}
						array_push($selectedGroupArray ,$_REQUEST['user_group']);
						//$groupObject->setGroupPermissionsForUser($user_id,$selectedGroupArray);
						$data['allGroups']=$groupObject->getAll('user_groups');
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('user','add'); 
						$page="manage_users.php";
						
					}else{
						$userObject->getUserVariables();
						$userVariables = $userObject->db_fields;
						$data['userVariables'] = $userVariables;
						$is_exist = true;
						$data['allGroups']=$groupObject->getAll('user_groups');
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('user','dup','username');  
					}
					$data['allUsers'] = $userObject->getAll('users');
					$data['rec_counts'] = $userObject->get_allcounts();
					
					// for managing actions permissions
				if(isset($_POST['mainfunction']))
				{
					$data['mainfunction'] = $_POST['mainfunction'];
					$data['subfunction_name'] = $_POST['subfunction_name'];					
				}
				else
				{
					$data['mainfunction'] = $mainfunction;
					$data['subfunction_name'] = $subfunction_name;
				}
				
				$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
				$data['arr_permission'] = $arr_permissions;	
				///////////////////////////////////
			break;
			
			case "edit_user":
				$data['allUsers'] = $userObject->getAll('users');
				$data['allGroups'] = $groupObject->get_Groups(0);
				$userId = $_REQUEST['edit_id'];
				$userDetails=$userObject->getUserDetails($userId);
					//$userDetails['selectedGroups']=$userObject->getAllPermissionedGroupsOfGroup($userId);
				$data['userDetails'] = $userDetails;
				$data['rec_counts'] = $userObject->get_allcounts();
					//		$userDetails['selectedBranches']=$userObject->getAllPermissionedBranchesOfUser($userId);
				$page="manage_users.php";
				//$page="edit_user.php";
				
				// for managing actions permissions
				if(isset($_POST['mainfunction']))
				{
					$data['mainfunction'] = $_POST['mainfunction'];
					$data['subfunction_name'] = $_POST['subfunction_name'];					
				}
				else
				{
					$data['mainfunction'] = $mainfunction;
					$data['subfunction_name'] = $subfunction_name;
				}
				
				$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
				$data['arr_permission'] = $arr_permissions;	
				///////////////////////////////////
			break;
			
			case "edit_user_entry":
				//echo "<pre>"; print_r($_REQUEST);
					$userObject->getUserVariables();
					$userVariables = $userObject->db_fields;
					$userVariables['user_id']=$_REQUEST['user_id'];
					
					if(!$userObject->isUserExist($userVariables['user_name'],$userVariables['user_id'])){
						$userPassword=$userVariables['user_password'];
					
						unset($userVariables['user_password']);
						$previousPass=$userObject->getUserPassword($userVariables['user_id']);
						
						$userVariables['modified_by']=$_SESSION['user_id'];
						$userVariables['modified_date']=date('Y-m-d H:i:s');
						
						$userObject->update($userVariables,'users','user_id');
						$sha1_currentpass=sha1($userPassword);
						if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
							$userObject->setPassword($userPassword,$userVariables['user_id']);
						}
						$data['allUsers']=$userObject->getAll('users');
						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
						}
						array_push($selectedGroupArray ,$_REQUEST['user_group']);
			
						//$groupObject->setGroupPermissionsForUser($userVariables['user_id'],$selectedGroupArray);
						
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] =  showmsg('user','update'); 
						$page="manage_users.php";
					}else{
						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
						}
						array_push($selectedGroupArray ,$_REQUEST['user_group']);
						$userDetails['selectedGroups'] = $selectedGroupArray;
						
						$data['userDetails']=$userVariables;
						
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('user','dup','username'); 
						$page="manage_users.php";
					}
					$data['allUsers'] = $userObject->getAll('users');
					$data['allGroups']=$groupObject->getAllGroups();
					$data['rec_counts'] = $userObject->get_allcounts();
					// for managing actions permissions
				if(isset($_POST['mainfunction']))
				{
					$data['mainfunction'] = $_POST['mainfunction'];
					$data['subfunction_name'] = $_POST['subfunction_name'];					
				}
				else
				{
					$data['mainfunction'] = $mainfunction;
					$data['subfunction_name'] = $subfunction_name;
				}
				
				$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
				$data['arr_permission'] = $arr_permissions;	
				///////////////////////////////////
			break;
			
			case "delete_user":
			
					$user_id=$_REQUEST['edit_id'];
					$userObject->delete($user_id,'users','user_id');
					$data['allUsers'] = $userObject->getAll('users');
					$data['allGroups'] = $groupObject->getAll('user_groups');
					$data['rec_counts'] = $userObject->get_allcounts();
					$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('user','delete'); 
						$page="manage_users.php";
						// for managing actions permissions
				if(isset($_POST['mainfunction']))
				{
					$data['mainfunction'] = $_POST['mainfunction'];
					$data['subfunction_name'] = $_POST['subfunction_name'];					
				}
				else
				{
					$data['mainfunction'] = $mainfunction;
					$data['subfunction_name'] = $subfunction_name;
				}
				
				$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
				$data['arr_permission'] = $arr_permissions;	
				///////////////////////////////////
			
			break;
			
			case "restore_user":
				$user_id=$_REQUEST['edit_id'];
				$userObject->restoreUsers($user_id);
				$data['allGroups'] = $groupObject->getAll('user_groups');
				$data['rec_counts'] = $userObject->get_allcounts();
				$data['allUsers'] = $userObject->getAll('users');
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('user','restore'); 
				$page="manage_users.php";
				// for managing actions permissions
				if(isset($_POST['mainfunction']))
				{
					$data['mainfunction'] = $_POST['mainfunction'];
					$data['subfunction_name'] = $_POST['subfunction_name'];					
				}
				else
				{
					$data['mainfunction'] = $mainfunction;
					$data['subfunction_name'] = $subfunction_name;
				}
				
				$arr_permissions = get_action_permissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
				$data['arr_permission'] = $arr_permissions;	
				///////////////////////////////////
			break;
			//*****************************************************************************
			
			case "view_groups":
				if(isset($_REQUEST['show_status']))
				{
					if($_REQUEST['show_status'] == 0)
					{
						$data['allGroups'] = $groupObject->getAllGroup('user_groups',1);
					}
					else if($_REQUEST['show_status'] == 2)
					{
						$data['allGroups'] = $groupObject->getAllGroup('user_groups',2);
					}
					else
					{
						$data['allGroups'] = $groupObject->getAllGroups();	
					}
				}
				else
				{
					$data['allGroups'] = $groupObject->getAllGroups();
				}
				$data['rec_counts'] = $groupObject->get_allcounts();
				//$data['allGroups']=$groupObject->getAllGroups();
				//var_dump($data['allGroups']);exit;
				$page="manage_groups.php";
			break;
			
			case "show_add_group":					
				$data['arr_perm_data'] = get_permission_data();	
				$page = "edit_group.php";
			break;
			
			case "save_group" :				
				$groupVariables = $groupObject->getGroupVariablesNew();
				$groupVariables['modified_by']=$_SESSION['user_id'];
				$groupVariables['modified_date']=date('Y-m-d H:i:s');
				if(isset($_POST['edit_id']))
				{	
					$groupVariables['group_id'] = $_POST['edit_id'];
					if(!$groupObject->isGroupExistNew($groupVariables['group_name'],$groupVariables['group_id']))
					{																			
						$groupObject->updateUsingId($groupVariables);					
						$groupObject->save_permission($_POST,$groupVariables['group_id']);						
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('group','update');;
						$page="manage_groups.php";
					}
					
				}
				elseif(!$groupObject->isGroupExistNew($groupVariables['group_name']))
				{		
					$group_id=$groupObject->insertGroupNew($groupVariables);
					$groupObject->save_permission($_POST,$group_id);
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('group','add');;
					$page="manage_groups.php";
				}
				else
				{
					$is_exist = true;
					$data['groupDetails'] = $groupVariables;
					$data['arr_perm_data'] = get_permission_data();
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('group','dup','group name');  
					$page = "edit_group.php";
				}
				$data['allGroups']=$groupObject->getAllGroups();
				$data['rec_counts'] = $groupObject->get_allcounts();
			break;	
					
				
			/*case "add_group":
					$groupVariables = $groupObject->getGroupVariablesNew();
					if(!$groupObject->isGroupExistNew($groupVariables['group_name']))
					{
						$groupVariables['added_by']=$_SESSION['user_id'];
						$groupVariables['added_date']=date('Y-m-d H:i:s');
						$group_id=$groupObject->insertGroupNew($groupVariables);
						//print_r($_REQUEST); exit;
						$selectedFunctionArray=array();
						if(isset($_REQUEST['functions'])){
							$selectedFunctionArray=$_REQUEST['functions'];
							$groupObject->setPagePermissionsForGroupNew($group_id,$selectedFunctionArray);
						}
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('group','add');;
						$page="manage_groups.php";
					}
					else
					{
						$is_exist = true;
						$data['allPages'] = $pageObject->getAllPages();
						$data['allFunctions'] = $functionObject->getAll('functions');
						$data['allGroups']=$groupObject->getAllGroups();
						$data['groupDetails'] = $groupVariables;
						$data['groupPermissionDetails'] = $_REQUEST['functions'];
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('group','dup','group name');  
						$page = "edit_group.php";
					}
					$data['allGroups']=$groupObject->getAllGroups();
					$data['rec_counts'] = $groupObject->get_allcounts();
			break;*/
			
			case "edit_group":
				$data['allPages'] = $pageObject->getAllPages();
				$data['allFunctions'] = $functionObject->getAll('functions');
				$data['allGroups']=$groupObject->getAllGroups();
				 
				$group_Id = $_REQUEST['edit_id'];
				$groupDetails=$groupObject->getGroupDetailsNew($group_Id);
				$data['groupDetails'] = $groupDetails;
				
				$data['arr_perm_data'] = get_permission_data();
				$page = "edit_group.php";
			break;
			
			/*case "edit_group_entry":
					//echo "<pre>"; print_r($_REQUEST); exit;
					$groupVariables = $groupObject->getGroupVariablesNew();
					$groupVariables['group_id'] = $_REQUEST['edit_id'];
					
					if(!$groupObject->isGroupExistNew($groupVariables['group_name'],$groupVariables['group_id']))
					{
						
						$groupVariables['modified_by']=$_SESSION['user_id'];
						$groupVariables['modified_date']=date('Y-m-d H:i:s');
						
						$groupObject->updateUsingId($groupVariables);
						
						$selectedFunctionArray=array();
						if(isset($_REQUEST['functions'])){
							$selectedFunctionArray=$_REQUEST['functions'];
						}
						$groupObject->setPagePermissionsForGroupNew($groupVariables['group_id'],$selectedFunctionArray);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('group','update');;
						$page="manage_groups.php";
					}
					else
					{
						$is_edit = true;
						$is_exist = true;
						$data['allPages'] = $pageObject->getAllPages();
						$data['allFunctions'] = $functionObject->getAll('functions');
						$data['allGroups']=$groupObject->getAllGroups();
						$data['groupDetails'] = $groupVariables;
						if(isset($_REQUEST['functions']))
							$data['groupPermissionDetails'] = $_REQUEST['functions'];
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('group','dup','group name'); 
						$page = "edit_group.php";
					}
					$data['allGroups']=$groupObject->getAllGroups();
					$data['rec_counts'] = $groupObject->get_allcounts();
			break;*/
			
			case "delete_group":
				$group_id=$_REQUEST['edit_id'];
				if($group_id != 1){
					$groupObject->deleteUsingIdNew($group_id);
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('group','delete');
					
				}else{
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['group']['delpermission'];
				}
				$data['allGroups']=$groupObject->getAllGroups();
				$data['rec_counts'] = $groupObject->get_allcounts();
				$page="manage_groups.php";
			
			break;
			
			case "restore_group":
				$group_id=$_REQUEST['edit_id'];
				$groupObject->restoreGroup($group_id);
				$data['rec_counts'] = $groupObject->get_allcounts();
				$data['allGroups'] = $groupObject->getAllGroups();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('group','restore');
				$page="manage_groups.php";
			break;	
			
			case "get_users_of_group":
				$group_id = $_REQUEST['group_id'];
				header('content-type:application/json');
				$response['users'] = $userObject->getUsersOfGroup($group_id);
				echo json_encode($response['users']);
				exit;
			break;
		}
?>
