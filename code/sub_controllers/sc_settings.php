<?php
require_once('library/categoryManager.php');
$categoryObject= new CategoryManager();
require_once('library/importManager.php');
$importObject= new ImportManager();

require_once('library/settingManager.php');
$SettingObject= new SettingManager();
require_once('library/leadManager.php');
$leadObject = new LeadManager();
require_once('library/productManager.php');
$productObject = new ProductManager();
require_once('library/functionManager.php');
$functionObject = new FunctionManager();
require_once('library/pageManager.php');
$pageObject = new PageManager();
require_once('library/groupManager.php');
$groupObject = new GroupManager();
require_once('library/taskManager.php');
$taskObject= new TaskManager();
extract($_POST);

	switch($function)
		{	
			case "view":
			case "view_project_category":
			if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allProjectCategories'] = $categoryObject->getAllProjectCategories($show_status);
				$data['rec_counts'] = $categoryObject->get_allcounts();
				$data['current_show'] = $show_status;
				$page = "manage_project_category.php";
			
			break;
			
			case "updateSettings":
				$twilio_sid = $_REQUEST['twilio_sid'];
				$twilio_auth_token = $_REQUEST['twilio_auth_token'];
				$twilio_app_sid = $_REQUEST['twilio_app_sid'];
				//$notification = updateSettings($twilio_sid,$twilio_auth_token,$twilio_app_sid);
				$page = "manage_project_category.php";
			    $notificationArray['type'] = 'Success';
			    $notificationArray['message'] = showmsg('Settings','update');
			   	$data['allSettings'] = getData("select * from settings");
			break;
			/*
			case "view_project_category":
						$data['allProjectCategories'] = $categoryObject->getAllProjectCategories();
						$page = "manage_project_category.php";
			break;
			*/
			case "add_project_category":
						
				$projectcategoryVariables = $categoryObject->getProjectCategoryVariables();
				if(!$categoryObject->isProjectCategoryExist($projectcategoryVariables['project_category_name'])){
					$projectcategoryVariables['added_by']=$_SESSION['user_id'];
					$projectcategoryVariables['added_date']=date('Y-m-d H:i:s');
					
					$project_category_id=$categoryObject->insertProjectCategory($projectcategoryVariables);
					
					$data['allProjectCategories']=$categoryObject->getAllProjectCategories();
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Project Category','add'); 
					
				}else{
					$is_exist = true;
					$data['project_category_Details'] = $projectcategoryVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('project category','dup','category name');  
					
				}
				
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allProjectCategories'] = $categoryObject->getAllProjectCategories($show_status);
				$data['rec_counts'] = $categoryObject->get_allcounts();
				$data['current_show'] = $show_status;
				$page = "manage_project_category.php";
			break;
			
			case "edit_project_category":
				
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allProjectCategories'] = $categoryObject->getAllProjectCategories($show_status);
				$data['rec_counts'] = $categoryObject->get_allcounts();
				$data['current_show'] = $show_status;
				$project_category_Id = $_REQUEST['edit_id'];
				$project_category_Details=$categoryObject->getProjectCategoryDetails($project_category_Id);
				$data['project_category_Details'] = $project_category_Details;
				$page = "manage_project_category.php";
				//$page = "edit_project_category.php";				
			break;
			
			case "edit_project_category_entry":
					
					$projectcategoryVariables = $categoryObject->getProjectCategoryVariables();
					$projectcategoryVariables['project_category_id']=$_REQUEST['project_category_id'];
					
					if(!$categoryObject->isProjectCategoryExist($projectcategoryVariables['project_category_name'],$projectcategoryVariables['project_category_id'])){
						
						$projectcategoryVariables['modified_by']=$_SESSION['user_id'];
						$projectcategoryVariables['modified_date']=date('Y-m-d H:i:s');
						$data['allProjectCategories']=$categoryObject->getAllProjectCategories();
						$categoryObject->updateUsingId($projectcategoryVariables);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Project Category','update');
						
					}else{
						$data['project_category_Details'] = $projectcategoryVariables;
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('project category','dup','category name'); 
						
					}
					if(isset($show_status))
					$show_status = $show_status;
					else
						$show_status = 1;
					$data['allProjectCategories'] = $categoryObject->getAllProjectCategories($show_status);
					$data['rec_counts'] = $categoryObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_project_category.php";
			break;
			
			case "delete_project_category":
			
					$project_category_id=$_REQUEST['edit_id'];
					$categoryObject->deleteUsingId($project_category_id);
					$data['allProjectCategories'] = $categoryObject->getAllProjectCategories();
					
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Project Category','delete');
					if(isset($show_status))
					$show_status = $show_status;
					else
						$show_status = 1;
					$data['allProjectCategories'] = $categoryObject->getAllProjectCategories($show_status);
					$data['rec_counts'] = $categoryObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_project_category.php";
			
			break;
			
			case "restore_project_category" :
					
					$categoryObject->restore_project_category($edit_id);
					$data['allProjectCategories'] = $categoryObject->getAllProjectCategories($show_status);
					$data['rec_counts'] = $categoryObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('project_category','restore');
					$page = "manage_project_category.php";	
			break;
			
			/**** Task Status ****/
			case "view_task_status":
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus($show_status);
				$data['rec_counts'] = $taskObject->get_allcounts();
				//$data['current_show'] = $show_status;
				$page = "manage_task_status.php";
			break;
			
			case "add_task_status":
						
				$taskStatusVariables = $taskObject->getTaskStatusVariables();
				if(!$taskObject->isTaskStatusExist($taskStatusVariables['task_status_name'])){
					$taskStatusVariables['added_by']=$_SESSION['user_id'];
					$taskStatusVariables['added_date']=date('Y-m-d H:i:s');
					
					$second_last_id = $taskObject->getSecondLastInsertedId();
					$taskStatusVariables['task_status_id'] = ++$second_last_id;
					
					$task_status_id=$taskObject->insertTaskStatus($taskStatusVariables);
					
					$data['allTaskStatus']=$taskObject->getAllTaskStatus();
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Task Status','add'); 
					
				}else{
					$is_exist = true;
					$data['task_status_Details'] = $taskStatusVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('Task Status','dup','Task Status');  
					
				}
				
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus($show_status);
				$data['rec_counts'] = $taskObject->get_allcounts();
				//$data['current_show'] = $show_status;
				$page = "manage_task_status.php";
			break;
			
			case "edit_task_status":
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allTaskStatus'] = $taskObject->getAllTaskStatus($show_status);
				
				$data['rec_counts'] = $taskObject->get_allcounts();
				$data['current_show'] = $show_status;
				$task_status_Id = $_REQUEST['edit_id'];
				$task_status_Details=$taskObject->getTaskStatusDetails($task_status_Id);
				$data['task_status_Details'] = $task_status_Details;
				$page = "manage_task_status.php";
			break;
			
			case "edit_task_status_entry":
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
						
					$taskStatusVariables = $taskObject->getTaskStatusVariables();
					$taskStatusVariables['task_status_id']=$_REQUEST['task_status_id'];
					
					if(!$taskObject->isTaskStatusExist($taskStatusVariables['task_status_name'],$taskStatusVariables['task_status_id'])){
						
						$taskStatusVariables['modified_by']=$_SESSION['user_id'];
						$taskStatusVariables['modified_date']=date('Y-m-d H:i:s');
						$taskObject->updateUsingId($taskStatusVariables);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Task Status','update');
						
					}else{
						$is_exist = true;
						$is_edit = true;
						$data['task_status_Details'] = $taskStatusVariables;
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('task status','dup','task status'); 
					}
					$data['allTaskStatus']=$taskObject->getAllTaskStatus($show_status);
					$data['rec_counts'] = $taskObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_task_status.php";
			break;
			
			case "delete_task_status":
					$task_status_id=$_REQUEST['edit_id'];
					$taskObject->deleteUsingId($task_status_id);
					
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allTaskStatus']=$taskObject->getAllTaskStatus($show_status);
					
					$data['rec_counts'] = $taskObject->get_allcounts();
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('task status','delete');
					$page = "manage_task_status.php";
			break;
			
			case "restore_task_status" :
				$task_status_id=$_REQUEST['edit_id'];
				$taskObject->restore_task_status($task_status_id);
				$show_status = 1;
				$data['allTaskStatus']=$taskObject->getAllTaskStatus($show_status);
				$data['rec_counts'] = $taskObject->get_allcounts();
				$data['current_show'] = $show_status;
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('task status','restore');
				$page = "manage_task_status.php";	
			break;
			/**** END Task Status ****/
			
			/****  Payment category    */
			
			case "view_payment_category":
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allPaymentCategories'] = $categoryObject->getAllPaymentCategories($show_status);
				$data['rec_counts'] = $categoryObject->get_allcounts_payment();
				$data['current_show'] = $show_status;
				$page = "payment_category.php";
			break;
			
			case "add_payment_category":
				$payment_category_variables = $categoryObject->getPaymentCategoryVariables();
				if(!$categoryObject->isPaymentCategoryExist($payment_category_variables['name']))
				{
					$payment_category_variables['added_by']=$_SESSION['user_id'];
					$payment_category_variables['added_date']=date('Y-m-d H:i:s');
					
					$payment_category_id=$categoryObject->insert($payment_category_variables,'payment_category');
					$data['allPaymentCategories']=$categoryObject->getAll('payment_category');
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Project Category','add');  
					
				}else
				{
					$is_exist = true;
					$data['payment_category_details'] = $payment_category_variables;
					//print_r($data['payment_category_details']); exit;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('payment category','dup','category name'); 
				}
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allPaymentCategories'] = $categoryObject->getAllPaymentCategories(1);
				$data['rec_counts'] = $categoryObject->get_allcounts_payment();
				$data['current_show'] = $show_status;
				$page = "payment_category.php";
			break;
			
			case "edit_payment_category":
				
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allPaymentCategories'] = $categoryObject->getAllPaymentCategories(1);
				$data['rec_counts'] = $categoryObject->get_allcounts_payment();
				$data['current_show'] = $show_status;
				$payment_category_Id = $_REQUEST['edit_id'];
				$payment_category_Details=$categoryObject->getPaymentCategoryDetails($payment_category_Id);
				$data['payment_category_details'] = $payment_category_Details;
				$page = "payment_category.php";
				
			break;
			
			case "edit_payment_category_entry":
				//echo "<pre>"; print_r($_REQUEST);
				$paymentcategoryVariables = $categoryObject->getPaymentCategoryVariables();
				$paymentcategoryVariables['pc_id']=$_REQUEST['payment_category_id'];
				$data['allPaymentCategories'] = $categoryObject->getAll('payment_category');
				if(!$categoryObject->isPaymentCategoryExist($paymentcategoryVariables['name'],$paymentcategoryVariables['pc_id'])){
					$paymentcategoryVariables['modified_by']=$_SESSION['user_id'];
					$paymentcategoryVariables['modified_date']=date('Y-m-d H:i:s');
					
					$categoryObject->update($paymentcategoryVariables,'payment_category','pc_id');
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Payment Category','update');
					
				}else{
					$is_exist = true;
					$data['payment_category_details'] = $paymentcategoryVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('payment category','dup','category name');
					
				}
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allPaymentCategories'] = $categoryObject->getAllPaymentCategories(1);
				$data['rec_counts'] = $categoryObject->get_allcounts_payment();
				$data['current_show'] = $show_status;
				$page = "payment_category.php";
			break;
			
			case "delete_payment_category":
				$payment_category_id=$_REQUEST['edit_id'];
				$categoryObject->delete($payment_category_id,'payment_category','pc_id');
				$data['allPaymentCategories'] = $categoryObject->getAll('payment_category');
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Payment Category','delete');
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allPaymentCategories'] = $categoryObject->getAllPaymentCategories(1);
				$data['rec_counts'] = $categoryObject->get_allcounts_payment();
				$data['current_show'] = $show_status;
				$page = "payment_category.php";
			break;
			
			case "restore_payment_category" :
					
					$categoryObject->restore_payment_category($edit_id);
					$data['allPaymentCategories'] = $categoryObject->getAllPaymentCategories(1);
					$data['rec_counts'] = $categoryObject->get_allcounts_payment();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('paymentt_category','restore');
					$page = "payment_category.php";	
			break;
			
			/************* End of payment category**********/
			
			case "import":
				$data['tables']=$importObject->getAllTables();
				$page = "manage_import.php";
			break;
			
			case "execute_imported":
				//20980000 bytes = 20MB
				$uploads_dir = "uploads";
				$mimes = array('application/vnd.ms-excel','application/excel', 'application/vnd.msexcel','text/csv','application/csv','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				$table_name=$_REQUEST['table_name'];
				//$total_fields=$importObject->getNumOfFieldsOfTable($table_name,'satger');
  		
//					var_dump($_FILES);exit;
  				if ( $_FILES["file"]["tmp_name"] == ""){
				   	$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['setting']['file_select'];
   				}else if (file_exists( $uploads_dir."/".$_FILES["file"]["name"])){
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $_FILES["file"]["name"] .$arr_msg['setting']['file_exist'];;
   				}else if (in_array($_FILES['file']['type'],$mimes)&& ($_FILES["file"]["size"] < 20980000) && ($_FILES["file"]["size"] > 0)){
					if(!(move_uploaded_file($_FILES["file"]["tmp_name"], $uploads_dir."/".$_FILES["file"]["name"]))){
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = $arr_msg['setting']['upload_error']; 
					}else{
						$file_name='uploads/'.$_FILES["file"]["name"];
						$insert_query="INSERT INTO ".$table_name." ";
						$extension=substr($_FILES['file']['name'],strrpos($_FILES['file']['name'],'.')+1);
						$first_row=TRUE;
						if(in_array($_FILES['file']['type'],array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','application/excel', 'application/vnd.msexcel')) && $extension!=='csv'){
							require_once 'library/excel/Classes/PHPExcel/IOFactory.php';
							$objReader = PHPExcel_IOFactory::createReaderForFile($file_name);
							$objPHPExcel = $objReader->load($file_name);
							$worksheet=$objPHPExcel->getSheet(0);
							foreach ($worksheet->getRowIterator() as $row) {
								$cellIterator = $row->getCellIterator();
								$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
								$row_values=array();
								foreach ($cellIterator as $cell) {
									if (!is_null($cell)) {
										$row_values[]=$cell->getCalculatedValue();
									}
								}
								if($first_row){
									$insert_query.="(`".implode('`,`',$row_values)."`) VALUES ";
									$first_row=FALSE;
								}else{
									$insert_query.="('".implode('\',\'',$row_values)."'),";
								}
							}
						}else{
							$file_handle = fopen($file_name, "r");
							
							while (!feof($file_handle) ) {				
								$line_of_text = fgetcsv($file_handle);

								if($line_of_text && is_array($line_of_text)){
									if($first_row){
										$insert_query.="(`".implode('`,`',$line_of_text)."`) VALUES ";
										$first_row=FALSE;
									}else{
										$insert_query.="('".implode('\',\'',$line_of_text)."'),";
									}
								}
							}
							
							fclose($file_handle);
						}
						$insert_query=substr($insert_query,0,-1);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = $arr_msg['setting']['upload'];
					}
  				}else{
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $_FILES['file']['type'].$arr_msg['setting']['file_type'];
				}
				$data['tables']=$importObject->getAllTables();
				$page = "manage_import.php";
			break;
			
			case "view_financial_month":
				$get_default = $SettingObject->getDefaultFinancialMonth();
				$data['get_default'] = $get_default;
				$page = "select_financial_month.php";
			break;
			
			case "update_financial_month":
				if($_REQUEST['financial_month'] == 1)
				{
					$updateQuery = $SettingObject->updateConfigValue('0',$_SESSION['user_id'],date('Y-m-d H:i:s'));
					$get_default = $SettingObject->getDefaultFinancialMonth();
					$data['get_default'] = $get_default;	
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Financial Month','update');
				}
				else{
					if($_REQUEST['financial_month'] <2 || $_REQUEST['financial_month'] > 28 ){
						$get_default = $SettingObject->getDefaultFinancialMonth();
						$data['get_default'] = $get_default;
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = $arr_msg['setting']['financial_month'];
					}
					else{
						$updateQuery = $SettingObject->updateConfigValue($_REQUEST['month_start_date'],$_SESSION['user_id'],date('Y-m-d H:i:s'));		
						$get_default = $SettingObject->getDefaultFinancialMonth();
						$data['get_default'] = $get_default;
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Financial Month','update');
					}
				}
				$page = "select_financial_month.php";
			break;
			
			// *****************************************************************
			case "show_configuration":
				if(isset($_REQUEST['show_lead_status']))
				{
					if($_REQUEST['show_lead_status'] == 0)
					{
						$data['allStatus'] = $leadObject->getAllStatus(1);
					}
					else if($_REQUEST['show_lead_status'] == 2)
					{
						$data['allStatus'] = $leadObject->getAllStatus(2);
					}
					else
					{
						$data['allStatus'] = $leadObject->getAll("lead_status");
					}
				}
				else
				{
					$data['allStatus'] = $leadObject->getAll("lead_status");
					$_REQUEST['show_lead_status'] = 1;
				}
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				
				if(isset($_REQUEST['show_substatus']))
				{
					if($_REQUEST['show_substatus'] == 0)
					{
						$data['allSubStatus'] = $leadObject->getAllSubStatus(1);
					}
					else if($_REQUEST['show_substatus'] == 2)
					{
						$data['allSubStatus'] = $leadObject->getAllSubStatus(2);
					}
					else
					{
						$data['allSubStatus'] = $leadObject->getAllSubStatus();
					}
				}
				else
				{
					$data['allSubStatus'] = $leadObject->getAllSubStatus();
					$_REQUEST['show_substatus'] = 1;
				}
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus(); 
				
				if(isset($_REQUEST['show_source']))
				{
					if($_REQUEST['show_source'] == 0)
					{
						$data['allSource'] = $leadObject->getAllSource(1);
					}
					else if($_REQUEST['show_source'] == 2)
					{
						$data['allSource'] = $leadObject->getAllSource(2);
					}
					else
					{
						$data['allSource'] = $leadObject->getAllSource(0);
					}
				}
				else
				{
					$data['allSource'] = $leadObject->getAllSource(0);
					$_REQUEST['show_source'] = 1;
				}
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				
				//$data['allSubStatus'] = $leadObject->getAllSubStatus();
				//$data['allSource'] = $leadObject->getAllSource();
				$page = "manage_configuration.php";
			break;
			
			//*********************************************************
			
			/*case "show_add_status":
				$page = "add_edit_status.php";
			break;*/	
			
			case "add_status":
				$leadObject->getStatusVariables();
				$statusVariables = $leadObject->db_fields;
				
				$statusVariables['added_by']=$_SESSION['user_id'];
				$statusVariables['added_date']=date('Y-m-d H:i:s');
				
				$statusIdInserted = $leadObject->insert($statusVariables,'lead_status');
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$data['from'] = 'status';
				$notificationArray['message'] = showmsg('Status','add'); 
				$page = "manage_configuration.php";
			break;
			
			case "edit_status":
				$statusId = $_REQUEST['statusid'];				
				$statusDetails = $leadObject->getStatusById($statusId);
				$data['statusDetails'] = $statusDetails;
				$data['statusDetails']['statusid'] = $statusId;
				
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$page = "manage_configuration.php";
			break;
			
			case "edit_status_entry":
				$leadObject->getStatusVariables();
				$statusVariables = $leadObject->db_fields;
				$statusVariables['status_id'] = $_REQUEST['statusid'];
				
				$statusVariables['modified_by']=$_SESSION['user_id'];
				$statusVariables['modified_date']=date('Y-m-d H:i:s');
				
				$leadObject->update($statusVariables,"lead_status","status_id");
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Status','update');
				$page="manage_configuration.php";
				$data['from'] = 'status';
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allSource'] = $leadObject->getAllSource();
			break;
			
			case "delete_status":			
				//print_r($_REQUEST);exit;
				$status_id=$_REQUEST['statusid'];
				$leadObject->delete($status_id,'lead_status','status_id');
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Status','delete');
				$page="manage_configuration.php";
			break;
			
			case "restore_status":
				$status_id=$_REQUEST['statusid'];
				$leadObject->restoreStatus($status_id);
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Status Restore Successfully!';
				$page="manage_configuration.php";
			break;
			
			case "show_manage_permission":
				$data['allStatus'] = $leadObject->getAll("lead_status");
				//print_r($data['allStatus']); exit;
				$data['allGroups']=$groupObject->getAllGroups();
				
				$status_permissions =get_permission('lead');
				$data['status_permissions'] = $status_permissions;
				//print_r($data['status_permissions']); exit;
				$page = "manage_permissions.php";
			break;
			
			case "add_status_permission":
				$status_permission_array = $_POST;
				//print_r($status_permission_array); exit;
				save_permission($status_permission_array,'lead');
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Lead status permissions','add'); 
				$page = "manage_configuration.php";
			break;
			
			//*********************************************
			
			/*case "show_add_substatus":
				$data['allSource'] = $leadObject->getAllSource();
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$page = "add_edit_substatus.php";
			break;	*/
			
			case "add_substatus":
				$leadObject->getSubStatusVariables();
				$substatusVariables = $leadObject->db_fields;
				
				$substatusVariables['added_by']=$_SESSION['user_id'];
				$substatusVariables['added_date']=date('Y-m-d H:i:s');
				
				$substatusIdInserted = $leadObject->insert($substatusVariables,'lead_substatus');
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$data['from'] = 'substatus';
				$notificationArray['message'] = showmsg('Substatus','add'); 
				$page = "manage_configuration.php";
			break;
			
			case "edit_substatus":
				$substatusId = $_REQUEST['sub_status_id'];				
				$substatusDetails = $leadObject->getSubStatusById($substatusId);
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
			    $data['substatusDetails'] = $substatusDetails;
				$data['substatusDetails']['substatus_id'] = $substatusId;
				$page = "manage_configuration.php";
			break;
			
			case "edit_substatus_entry":
				$leadObject->getSubStatusVariables();
				$substatusVariables = $leadObject->db_fields;
				$substatusVariables['substatus_id'] = $_REQUEST['sub_status_id'];
				
				$substatusVariables['modified_by']=$_SESSION['user_id'];
				$substatusVariables['modified_date']=date('Y-m-d H:i:s');
				$leadObject->update($substatusVariables,"lead_substatus","substatus_id");
				$data['from'] = 'substatus';
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Substatus','update');
				$page="manage_configuration.php";
			break;
			
			case "delete_substatus":			
				//print_r($_REQUEST);exit;
				$substatus_id=$_REQUEST['sub_status_id'];
				$leadObject->delete($substatus_id,'lead_substatus','substatus_id');
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$data['from'] = 'substatus';
				$notificationArray['message'] =  showmsg('Substatus','delete');
				$page="manage_configuration.php";
			break;
			
			case "restore_substatus":
				//print_r($_REQUEST);exit;
				$substatus_id=$_REQUEST['sub_status_id'];
				$leadObject->restoreSubStatus($substatus_id);
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Sub-Status Restore Successfully!';
				$page="manage_configuration.php";
			break;
			//*********************************************************
			
			/*case "show_add_source":
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$page = "add_edit_source.php";
			break;	*/
			
			case "add_source":
				$leadObject->getSourceVariables();
				$sourceVariables = $leadObject->db_fields;
				
				$sourceVariables['added_by']=$_SESSION['user_id'];
				$sourceVariables['added_date']=date('Y-m-d H:i:s');
				
				$sourceIdInserted = $leadObject->insert($sourceVariables,'lead_source');
				$data['allSource'] = $leadObject->getAllSource();
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$data['from'] = 'source'; 
				$notificationArray['message'] =  showmsg('Source','add'); 
				$page = "manage_configuration.php";
			break;
			
			case "edit_source":
				$sourceId = $_REQUEST['source_id'];				
				$sourceDetails = $leadObject->getSourceById($sourceId);
			    $data['sourceDetails'] = $sourceDetails;
				$data['sourceDetails']['source_id'] = $sourceId;
				
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$page="manage_configuration.php";
			break;
			
			case "edit_source_entry":
				$leadObject->getSourceVariables();
				$sourceVariables = $leadObject->db_fields;
				$sourceVariables['source_id'] = $_REQUEST['source_id'];
				
				$sourceVariables['modified_by']=$_SESSION['user_id'];
				$sourceVariables['modified_date']=date('Y-m-d H:i:s');
				
				$leadObject->update($sourceVariables,"lead_source","source_id");
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Source','update');
				$page="manage_configuration.php";
				$data['from'] = 'source'; 
				$data['allSource'] = $leadObject->getAllSource();
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
			break;
			
			case "delete_source":			
				//print_r($_REQUEST);exit;
				$source_id=$_REQUEST['source_id'];
				$leadObject->delete($source_id,'lead_source','source_id');
				$data['allSource'] = $leadObject->getAllSource();
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source(); 
				$notificationArray['type'] = 'Success';
				$data['from'] = 'source'; 
				$notificationArray['message'] = showmsg('Source','delete');
				$page="manage_configuration.php";
			break;
			
			case "restore_source":
				$source_id=$_REQUEST['source_id'];
				$leadObject->restoreSource($source_id);
				$data['allStatus'] = $leadObject->getAll("lead_status");
				$data['allSubStatus'] = $leadObject->getAllSubStatus();
				$data['allSource'] = $leadObject->getAllSource();
				$data['rec_counts'] = $leadObject->get_allcounts_status(); 
				$data['rec_counts_substatus'] = $leadObject->get_allcounts_substatus();
				$data['rec_counts_source'] = $leadObject->get_allcounts_source();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Source Restore Successfully!';
				$page="manage_configuration.php";
			break;
			
			/****Caese of Functions****/
			/****Cases of Functions****/
			case "view_function":
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allFunctions'] = $functionObject->get_functions($show_status);
				$data['AllPages'] = $functionObject->getAllPages();
				$data['rec_counts'] = $functionObject->get_all_funcounts();					
				$data['current_show'] = $show_status;
				$page = "manage_functions.php";
			break;
			
			case "add_function":
				$functionObject->getFunctionVariables();
				$functionVariables = $functionObject->db_fields;
				
				if($functionObject->isFunctionExists($functionVariables['function_name']))
				{
					$is_exist = true;
					$data['functionDetails'] = $functionVariables;						
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['setting']['function_exist'];
				}
				elseif($functionObject->isOrderExists($functionVariables['page_id'], $functionVariables['menu_order']))
				{
					$is_exist = true;
					$data['functionDetails'] = $functionVariables;
					$data['functionDetails']['menu_order'] = '';									
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['setting']['menu_order'];
				}
				else
				{					
					$functionVariables['added_by']=$_SESSION['user_id'];
					$functionVariables['added_date']=date('Y-m-d H:i:s');					
					$statusIdInserted = $functionObject->insert($functionVariables,'functions');					
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Function','add'); 
					
				}
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allFunctions'] = $functionObject->get_functions($show_status);
				$data['AllPages'] = $functionObject->getAllPages();
				$data['rec_counts'] = $functionObject->get_all_funcounts();	
				$data['current_show'] = $show_status;	
				
				$page = "manage_functions.php";
			break;
			
			case "edit_function":
				$function_id = $_REQUEST['edit_id'];
				$functionDetails = $functionObject->getFunctionDetailsById($function_id);
				$data['AllPages'] = $functionObject->getAllPages();
				$data['allFunctions'] =  $functionObject->get_functions($show_status);
				$data['rec_counts'] = $functionObject->get_all_funcounts();	
				$data['current_show'] = $show_status;
				$is_edit=TRUE;
				$data['functionDetails'] = $functionDetails;
				$page = "manage_functions.php";
			break;
			
			case "edit_function_entry":
				$functionObject->getFunctionVariables();
				$functionVariables = $functionObject->db_fields;
				$functionVariables['function_id'] = $_REQUEST['edit_id'];
				//echo $functionVariables['function_id'];
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allFunctions'] = $functionObject->get_functions($show_status);
				$data['rec_counts'] = $functionObject->get_all_funcounts();	
				$data['current_show'] = $show_status;
				$data['AllPages'] = $functionObject->getAllPages();
				$page = "manage_functions.php";
				if($functionObject->isFunctionExists($functionVariables['function_name'],$functionVariables['function_id']))
				{ 
					$is_exist = true;
					$is_edit=TRUE;
					$data['functionDetails'] = $functionVariables;
					$notificationArray['type'] = 'Failed';	
					$notificationArray['message'] = $arr_msg['setting']['function_exist']; 					
				}
				elseif($functionObject->isOrderExists($functionVariables['page_id'], $functionVariables['menu_order'],$functionVariables['function_id']))
				{
					$is_exist = true;
					$data['functionDetails'] = $functionVariables;	
					$data['functionDetails']['menu_order'] = '';				
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['setting']['function_menu_order'];
				}
				else{					
					$functionVariables['modified_by']=$_SESSION['user_id'];
					$functionVariables['modified_date']=date('Y-m-d H:i:s');
					
					$statusIdInserted = $functionObject->update($functionVariables,'functions','function_id');
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Function','update');										
					
				}
				
			break;
			
			case"delete_function":
				$function_id = $_REQUEST['edit_id'];
				$functionObject->delete($function_id,'functions','function_id');
				
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Function','delete');
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allFunctions'] = $functionObject->get_functions($show_status);
				$data['rec_counts'] = $functionObject->get_all_funcounts();	
				$data['AllPages'] = $functionObject->getAllPages();
				$data['current_show'] = $show_status;
				$page = "manage_functions.php";
			break;
			
			case "restore_function" :
				
				$functionObject->restore_function($edit_id);
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allFunctions'] = $functionObject->get_functions($show_status);
				$data['rec_counts'] = $functionObject->get_all_funcounts();	
				$data['current_show'] = $show_status;
				$data['AllPages'] = $functionObject->getAllPages();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('function','restore');
				$page = "manage_functions.php";			
			break;
			/****End of Caese of Functions****/
			
			// subfunction crud 
			case "manage_subfunction":
							
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allFunctions'] = $functionObject->get_subfunctions($show_status);
				$data['AllMainFunctions'] = $functionObject->getAllFunctions(); //echo "<pre>"; print_r($data['AllMainFunctions']); exit;
				$data['rec_counts'] = $functionObject->get_all_subfuncounts();	
				$data['AllPages'] = $functionObject->getAllPages();				
				$data['current_show'] = $show_status;
				$page = "manage_subfunctions.php";
			break;
			
			case "save_subfunction":
				$arr_data = $_POST;
				if($arr_data['page_id'] == '' || $arr_data['main_function_id'] == '0' || $arr_data['function_name'] == '' || $arr_data['friendly_name'] == '')
				{
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['setting']['mandatory'];
					$data['arr_edit'] = $arr_data;
				}
				elseif($functionObject->is_subfun_OrderExists($arr_data['page_id'],$arr_data['main_function_id'], $arr_data['menu_order'],$arr_data['edit_id']))
				{
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['setting']['function_menu_order'];
					$data['arr_edit'] = $arr_data;
					$data['arr_edit']['is_crud'] = $arr_data['chkcrud'];
				}
				else
				{
					$arr_data['is_crud'] = $arr_data['chkcrud'];
					$arr_data['added_by'] = $_SESSION['user_id'];
					$arr_data['added_date'] = date('Y-m-d H:i:s');	
					$chk_exist = $functionObject->save_function($arr_data); 
					if($chk_exist == "exist")
					{
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = $arr_msg['setting']['function_exist'];
						$data['arr_edit'] = $arr_data;
					}
					else
					{
						$notificationArray['type'] = 'Success';
						if($arr_data['edit_id'] != "")
							$notificationArray['message'] = showmsg('Sub-function','update');
						else 
							$notificationArray['message'] = showmsg('Sub-function','add'); 
							
					}
				}
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allFunctions'] = $functionObject->get_subfunctions($show_status);
				$data['AllMainFunctions'] = $functionObject->getAllFunctions();	
				$data['rec_counts'] = $functionObject->get_all_subfuncounts();
				$data['AllPages'] = $functionObject->getAllPages();					
				$data['current_show'] = $show_status;				
				$page = "manage_subfunctions.php";				
			break;
			
			case "edit_subfunction":
				$function_id = $_REQUEST['edit_id'];
				$functionDetails = $functionObject->get_subfunction($function_id); //echo "<pre>"; print_r($functionDetails); exit;
				$data['AllMainFunctions'] = $functionObject->get_mainfunctions($functionDetails['page_id']); 		
				$data['allFunctions'] =  $functionObject->get_subfunctions($show_status);
				$data['rec_counts'] = $functionObject->get_all_subfuncounts();
				$data['AllPages'] = $functionObject->getAllPages();		
				$data['current_show'] = $show_status;
				$data['arr_edit'] = $functionDetails;
				$page = "manage_subfunctions.php";
			break;
			
			case"delete_subfunction":
				$function_id = $_REQUEST['edit_id'];
				$functionObject->delete($function_id,'sub_functions','function_id');
				
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allFunctions'] =  $functionObject->get_subfunctions($show_status);
				$data['rec_counts'] = $functionObject->get_all_subfuncounts();
				$data['AllMainFunctions'] = $functionObject->getAllFunctions();	
				$data['AllPages'] = $functionObject->getAllPages();	
				$data['current_show'] = $show_status;				
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Sub-function','delete');				
				$page = "manage_subfunctions.php";
			break;
			
			case "restore_subfunction" :				
				$functionObject->restore_subfunction($edit_id);
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
				$data['allFunctions'] =  $functionObject->get_subfunctions($show_status);
				$data['rec_counts'] = $functionObject->get_all_subfuncounts();
				$data['AllMainFunctions'] = $functionObject->getAllFunctions();	
				$data['AllPages'] = $functionObject->getAllPages();	
				$data['current_show'] = $show_status;
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Sub-function','restore');
				$page = "manage_subfunctions.php";			
			break;
			
			case "get_functions" :
				$data['AllMainFunctions'] =  $functionObject->get_mainfunctions($page_id);
				$dropdwn_html = '<select name="main_function_id" id="main_function_id">
                                     <option value="0">Please Select</option>';                                           
										foreach($data['AllMainFunctions'] as $k=>$v)
										{
											$dropdwn_html .= '<option value="'.$v['function_id'].'">'.$v['function_name'].'</option>';									   
										}											
               $dropdwn_html .= '</select>';
			   echo $dropdwn_html;
			   exit;			
			break;
			///////////////////////////////////
			
			/*** Page CRUD ***/
			case "view_pages":
			//echo $show_status;
				if(isset($_REQUEST['redirect_message']) && $_REQUEST['redirect_message']!==''){
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $_REQUEST['redirect_message'];
				}
				
				$data['maxTabOrder'] = $pageObject->getMaxTabOrder();
				
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allPages'] = $pageObject->getAllPages($show_status);
					$data['rec_counts'] = $pageObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_pages.php";	
			break;
			
			case "get_parent_ajax":
				$level = $_REQUEST['level'];
				$level=$level-1;
				//echo $level;
				header('content-type:application/json');
				$response['parent'] = $pageObject->getParentPages($level);
				echo json_encode($response['parent']);
				exit;
			break;
			
			case "add_page":
				$data['maxTabOrder'] = $pageObject->getMaxTabOrder();
				$uploads_dir = "img";
				$mimes = array("image/gif", "image/jpeg", "image/jpg", "image/png");
				
				//var_dump($_FILES);exit; 
				
				$pageVariables = $pageObject->getPageVariables();
				if(!$pageObject->isPageExist($pageVariables['module_name'])){
					if ( $_FILES["file"]["tmp_name"] == ""){
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = $arr_msg['setting']['file_select'];
					}
					else
					{   
						if (in_array($_FILES['file']['type'],$mimes)&& ($_FILES["file"]["size"] < 200000) && ($_FILES["file"]["size"] > 0))
						{
							if(!move_uploaded_file($_FILES["file"]["tmp_name"], $uploads_dir."/".$_FILES["file"]["name"]))
							{
								$notificationArray['type'] = 'Failed';
								$notificationArray['message'] = $arr_msg['setting']['upload_error'];
							}
							else
							{	
								$pageVariables['added_by'] = $_SESSION['user_id'];
								$pageVariables['added_date'] = date('Y-m-d H:i:s');
								$page_id=$pageObject->insertPage($pageVariables);
							
								$module_name = strtolower($pageVariables['module_name']);
								$fp1 = fopen('sub_controllers/sc_'.$module_name.'.php','w+');
								$fp2 = fopen('views/manage_'.$module_name.'.php','w+');
								
								$notificationArray['type'] = 'Success';
								$notificationArray['message'] = showmsg('Page','add');
							}
						}
						else
						{
								$notificationArray['type'] = 'Failed';
								$notificationArray['message'] = $arr_msg['setting']['file_type'];
						}
					}
					
				}else{
					$is_exist = true;
					$data['page_Details'] = $pageVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('page','dup','module name');
				}
				
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allPages'] = $pageObject->getAllPages($show_status);
					$data['rec_counts'] = $pageObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_pages.php";	
			break;
			
			case "edit_page":
				$data['maxTabOrder'] = $pageObject->getMaxTabOrder();
				
				$page_Id = $_REQUEST['edit_id'];
				$page_Details=$pageObject->getPageDetails($page_Id);
				$data['page_Details'] = $page_Details;
				$is_edit=true;
				
				if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allPages'] = $pageObject->getAllPages($show_status);
					$data['rec_counts'] = $pageObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_pages.php";	
				
				
			break;
			
			case "edit_page_entry":
				//echo "<pre>"; print_r($_REQUEST);
					$pageVariables = $pageObject->getPageVariables();
					$pageVariables['page_id']=$_REQUEST['edit_id'];
					
					//var_dump($_FILES['file']['name']);exit;
					//var_dump($pageVariables);exit;
					
					/*******/
					$uploads_dir = "img";
					$mimes = array("image/gif", "image/jpeg", "image/jpg", "image/png");
					if(!$pageObject->isPageExist($pageVariables['module_name'],$pageVariables['page_id'])){
						
						if(($_FILES['file']['name'])!='')
						{
						
								  if (in_array($_FILES['file']['type'],$mimes)&& ($_FILES["file"]["size"] < 200000) && ($_FILES["file"]["size"] > 0))
									{
										if(!move_uploaded_file($_FILES["file"]["tmp_name"], $uploads_dir."/".$_FILES["file"]["name"]))
										{
											$notificationArray['type'] = 'Failed';
											$notificationArray['message'] = $arr_msg['setting']['upload_error'];
										}
										else
										{	
											$pageVariables['modified_by'] = $_SESSION['user_id'];
											$pageVariables['modified_date'] = date('Y-m-d H:i:s');
											$pageObject->updateUsingId($pageVariables);
										
											$module_name = strtolower($pageVariables['module_name']);
											$data['is_redirect']=TRUE;									
											$notificationArray['type'] = 'Success';
											$notificationArray['message'] = showmsg('Page','update');
										}
									}
									else
									{
											$notificationArray['type'] = 'Failed';
											$notificationArray['message'] =	$arr_msg['setting']['file_type'];
									}
						
								
						
						}
						else
						{
							$pageVariables['modified_by'] = $_SESSION['user_id'];
							$pageVariables['modified_date'] = date('Y-m-d H:i:s');
							$pageObject->updateUsingId($pageVariables);
						
							$module_name = strtolower($pageVariables['module_name']);
																
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('Page','update'); 
							$page="manage_pages.php";
						}
						
					}else{
						$data['page_Details'] = $pageVariables;
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('page','dup','module name');
						$is_edit=true;
						$is_exist=true;
						$page = "manage_pages.php";
					}
					
					$data['maxTabOrder'] = $pageObject->getMaxTabOrder();
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allPages'] = $pageObject->getAllPages($show_status);
					$data['rec_counts'] = $pageObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_pages.php";	
					
			break;
			
			
			case "delete_page":
					$data['maxTabOrder'] = $pageObject->getMaxTabOrder();
					$page_id=$_REQUEST['edit_id'];
					$pageObject->deleteUsingId($page_id);
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Page','delete'); 
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['allPages'] = $pageObject->getAllPages($show_status);
					$data['rec_counts'] = $pageObject->get_allcounts();
					$data['current_show'] = $show_status;
					$page = "manage_pages.php";	
			
			break;
			
			case "restore_page":
					$pageObject->restore_page($edit_id);
					$data['allPages'] = $pageObject->getAllPages($show_status);
					$data['rec_counts'] = $pageObject->get_allcounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('page','restore');
					$page = "manage_pages.php";	
			break;
			
			/*****    End of Pages          **/
			
			case "view_order_status":	
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					if(isset($show_status))
						$show_status = $show_status;
					else
						$show_status = 1;
					$data['arr_status'] = $orderObject->get_allstatus($show_status);
					$data['rec_counts'] = $orderObject->get_all_statuscounts();					
					$data['current_show'] = $show_status;
					$page = "order_status.php";
			break;
			
			case "add_order_status" : 
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					if($txtstatus != "" && $txtorder != "")
					{
						$data = array(
									'userid' => $_SESSION['user_id'],
									'txtstatus' => $txtstatus,
									'txtorder'	=> $txtorder
									); 
						if(isset($edit_id) && ($edit_id != "")) // update
						{
							if($show_status == 2)
								$data['is_trash'] = 1;
							$insert_status = $orderObject->insertstatus($data,$edit_id);
							if($insert_status != 'update')
							{
								$data['action'] = "show_edit";
								$data['edit_id'] = $edit_id;							
							}						
						}
						else // insert
						{							
							$insert_status = $orderObject->insertstatus($data);																		
						}
						
						
						if($insert_status == 'both_exist'){
							$notificationArray['type'] = 'Failed';
							$notificationArray['message'] = $arr_msg['setting']['status_exist']; 
						}elseif($insert_status == 'insert'){
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('Status','add');
						}elseif($insert_status == 'update'){
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('Status','update');
						}elseif($insert_status == 'name_exist'){
							$notificationArray['type'] = 'Failed';
							$notificationArray['message'] = $arr_msg['setting']['status_name_exist'];
							$data['show_order'] = $txtorder;
						}elseif($insert_status == 'order_exist')
						{
							$notificationArray['type'] = 'Failed';
							$notificationArray['message'] = $arr_msg['setting']['status_order_exist'];
							$data['show_name'] = $txtstatus;
						}
						
					}
					else{
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = $arr_msg['setting']['mandatory'];
					}
					$data['arr_status'] = $orderObject->get_allstatus($show_status);
					$data['rec_counts'] = $orderObject->get_all_statuscounts();
					if(isset($show_status))
						$data['current_show'] = $show_status;	
					$page = "order_status.php";
			break;
			
			case "edit_order_status" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					$data['status_data'] = $orderObject->get_statusdata($edit_id);
					$data['action'] = "edit";
					$data['arr_status'] = $orderObject->get_allstatus($show_status);
					$data['rec_counts'] = $orderObject->get_all_statuscounts();
					if(isset($show_status))
						$data['current_show'] = $show_status;				
					$page = "order_status.php";
			break;
			
			case "delete_order_status" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					if($show_status == 2)
						$is_trash = 1;
					else
						$is_trash = '';
					$orderObject->delete_status($edit_id,$is_trash);
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Status','delete'); //"delete";
					$data['arr_status'] = $orderObject->get_allstatus($show_status);
					$data['rec_counts'] = $orderObject->get_all_statuscounts();
					$data['current_show'] = $show_status;									
					$page = "order_status.php";					
			break;
			
			case "restore_order_status" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					$orderObject->restore_status($edit_id);
					$data['arr_status'] = $orderObject->get_allstatus($show_status);
					$data['rec_counts'] = $orderObject->get_all_statuscounts();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = $arr_msg['setting']['status_restore']; //'restore';
					$page = "order_status.php";	
			break;
			
			case "change_user_status_permission" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					$data['arr_group'] = $orderObject->get_allgroups();
					$data['arr_status'] = $orderObject->get_allstatus(1);
					$data['arr_permission'] = get_permission('order');				
					$page = "manage_userpermission.php";
			break;
			
			case "change_grpstatus_permission" :
					require_once('library/orderManager.php');
					$orderObject = new OrderManager();
					$arr_data = $_POST;
					save_permission($arr_data,'order');
					$data['arr_group'] = $orderObject->get_allgroups();
					$data['arr_status'] = $orderObject->get_allstatus(1);
					$data['arr_permission'] = get_permission('order');
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Permissions','update');
					$page = "manage_userpermission.php";					
			break;			
			
			/**** leave settings cases ****/
			case "view_leave_setting":
				$data['sickLeave'] = $SettingObject->getSickLeaveSetting();
				$data['casualLeave'] = $SettingObject->getCasualLeaveSetting();
				$data['paidLeave'] = $SettingObject->getPaidLeaveSetting();
				$page = "leave_settings.php";
				break;
			
			case"update_leave_setting":
				$sick_leave = $_REQUEST['sick_leave'];
				$casual_leave = $_REQUEST['casual_leave'];
				$paid_leave = $_REQUEST['paid_leave'];
				$SettingObject->updateSickLeaveSettings($sick_leave,$_SESSION['user_id'],date('Y-m-d H:i:s'));
				$SettingObject->updateCasualLeaveSettings($casual_leave,$_SESSION['user_id'],date('Y-m-d H:i:s'));
				$SettingObject->updatePaidLeaveSettings($paid_leave,$_SESSION['user_id'],date('Y-m-d H:i:s'));
				
			    $notificationArray['type'] = 'Success';
			    $notificationArray['message'] = showmsg('Settings','update'); 
			    $data['sickLeave'] = $SettingObject->getSickLeaveSetting();
				$data['casualLeave'] = $SettingObject->getCasualLeaveSetting();
				$data['paidLeave'] = $SettingObject->getPaidLeaveSetting();
				$page= "leave_settings.php";
			break;	
			/**** end of leave settings ****/
			
			case "manage_priority" :
				if(!isset($show_status))
					$show_status = 1;
				$data['arr_priority'] = $SettingObject->get_allpriority($show_status);
				$data['rec_counts'] = $SettingObject->get_all_prioritycounts();	 
				$data['current_show'] = $show_status;
				$page= "manage_priority.php";
			break;
			
			case "save_priority":
				$arr_data = $_POST;
				if($arr_data['priority_order'] == '' || $arr_data['value'] == '0')
				{
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['setting']['mandatory'];
					$arr_data['id'] = $arr_data['edit_id'];
					$data['arr_edit'] = $arr_data;
				}
				/*elseif($SettingObject->is_OrderExists($arr_data['priority_order'],$arr_data['edit_id']))
				{
					$arr_data['priority_order'] = '';
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = $arr_msg['setting']['priority_order'];
					$arr_data['id'] =   $arr_data['edit_id'];
					$data['arr_edit'] = $arr_data;					
				}*/
				else
				{					
					$arr_data['added_by'] = $_SESSION['user_id'];
					$arr_data['added_date'] = date('Y-m-d H:i:s');	
					$chk_exist = $SettingObject->save_priority($arr_data); 
					
					$notificationArray['type'] = 'Success';
					if($arr_data['edit_id'] != "")
						$notificationArray['message'] = showmsg('Priority','update');
					else 
						$notificationArray['message'] = showmsg('Priority','add'); 					
				}
				if(!isset($show_status))
					$show_status = 1;
				$data['arr_priority'] = $SettingObject->get_allpriority($show_status);
				$data['rec_counts'] = $SettingObject->get_all_prioritycounts();	 
				$data['current_show'] = $show_status;
				$page= "manage_priority.php";							
			break;
			
			case "edit_priority" :
				if(!isset($show_status))
					$show_status = 1;
				$data['arr_edit'] = $SettingObject->get_prioritydata($edit_id);				
				$data['arr_priority'] = $SettingObject->get_allpriority($show_status);
				$data['rec_counts'] = $SettingObject->get_all_prioritycounts();	 
				if(isset($show_status))
					$data['current_show'] = $show_status;				
				$page= "manage_priority.php";
			break;
			
			case "delete_priority" :
				$SettingObject->delete_priority($edit_id);				
				if(!isset($show_status))
					$show_status = 1;				
				$data['arr_priority'] = $SettingObject->get_allpriority($show_status);
				$data['rec_counts'] = $SettingObject->get_all_prioritycounts();	
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Priority','delete');
				$data['current_show'] = $show_status;									
				$page= "manage_priority.php";
			break;
			
			case "restore_priority" :
				$SettingObject->restore_status($edit_id);
				$data['arr_priority'] = $SettingObject->get_allpriority($show_status);
				$data['rec_counts'] = $SettingObject->get_all_prioritycounts();	
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Priority','delete'); 
				$data['current_show'] = $show_status;									
				$page= "manage_priority.php";
			break;
			
			// permission management
			case "manage_permissions" :
				set_time_limit(0);
				$data['arr_group'] = $SettingObject->get_allgroups();
				$data['arr_perm_data'] = get_permission_data();				
				//$data['arr_set_perm'] = $SettingObject->get_allowed_permission();								
				$page = "manage_permission_setting.php";
			break;
			
			case "update_page_permission" :
				set_time_limit(0);
				$SettingObject->save_permission($_POST);
				$data['arr_group'] = $SettingObject->get_allgroups();
				$data['arr_perm_data'] = get_permission_data();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Permissions','update');
				$page = "manage_permission_setting.php";
			break;
			//////////////////////////////
			
			/********* candidate position*/
			
			case "view_position":
			if(!isset($show_status))
				$show_status = 1;
			$data['allPositions'] = $SettingObject->getAllPositions($show_status);
			$data['rec_counts'] = $SettingObject->get_all_counts_positions();
			$data['current_show'] = $show_status;
			$page = "manage_candidate_position.php";
			
			break;
			
			
			case "add_position":
						
				$positionVariables = $SettingObject->getPositionVariables();
				if(!$SettingObject->isPositionExist($positionVariables['position_name'])){
					$positionVariables['added_by']=$_SESSION['user_id'];
					$positionVariables['added_date']=date('Y-m-d H:i:s');
					
					$position_id=$SettingObject->insertPosition($positionVariables);
					
					$data['allPositions']=$SettingObject->getAllPositions();
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Candidate Position','add'); 
					
				}else{
					$is_exist = true;
					$data['position_Details'] = $positionVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('Candidate Position','dup','position name');  
					
				}
				
				if(!isset($show_status))
					$show_status = 1;
				$data['allPositions'] = $SettingObject->getAllPositions($show_status);
				$data['rec_counts'] = $SettingObject->get_all_counts_positions();
				$data['current_show'] = $show_status;
				$page = "manage_candidate_position.php";
			break;
			
			case "edit_position":
				
				if(!isset($show_status))
					$show_status = 1;
				$data['allPositions'] = $SettingObject->getAllPositions($show_status);
				$data['rec_counts'] = $SettingObject->get_all_counts_positions();
				$data['current_show'] = $show_status;
				$position_Id = $_REQUEST['edit_id'];
				$position_Details=$SettingObject->getPositionDetails($position_Id);
				$data['position_Details'] = $position_Details;
				$page = "manage_candidate_position.php";
			break;
			
			case "edit_position_entry":
					
					$positionVariables = $SettingObject->getPositionVariables();
					$positionVariables['position_id']=$_REQUEST['position_id'];
					
					if(!$SettingObject->isPositionExist($positionVariables['position_name'],$positionVariables['position_id'])){
						
						$positionVariables['modified_by']=$_SESSION['user_id'];
						$positionVariables['modified_date']=date('Y-m-d H:i:s');
						$data['allPositions']=$SettingObject->getAllPositions();
						$SettingObject->updateUsingId($positionVariables,'candidate_position','position_id');
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Candidate Position','update');
						
					}else{
						$data['position_Details'] = $positionVariables;
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('Candidate Position','dup','position name'); 
						
					}
					if(!isset($show_status))
						$show_status = 1;
					$data['allPositions'] = $SettingObject->getAllPositions($show_status);
					$data['rec_counts'] = $SettingObject->get_all_counts_positions();
					$data['current_show'] = $show_status;
					$page = "manage_candidate_position.php";
			break;
			
			case "delete_position":
			
					$position_id=$_REQUEST['edit_id'];
					$SettingObject->deleteUsingId('position_id',$position_id,'candidate_position');
					$data['allPositions'] = $SettingObject->getAllPositions($show_status);
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Candidate Position','delete');
					if(!isset($show_status))
						$show_status = 1;
					$data['allPositions'] = $SettingObject->getAllPositions($show_status);
					$data['rec_counts'] = $SettingObject->get_all_counts_positions();
					$data['current_show'] = $show_status;
					$page = "manage_candidate_position.php";
			
			break;
			
			case "restore_position" :
					
					$SettingObject->restore_position($edit_id);
					$data['allPositions'] = $SettingObject->getAllPositions($show_status);
					$data['rec_counts'] = $SettingObject->get_all_counts_positions();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Candidate Position','restore');
					$page = "manage_candidate_position.php";	
			break;
			
			/***** end of candidate position*/
			
			/********* candidate status*/
			
			case "view_status":
			if(!isset($show_status))
				$show_status = 1;
			$data['allStatus'] = $SettingObject->getAllCandidateStatus($show_status);
			$data['rec_counts'] = $SettingObject->get_all_counts_CandidateStatus();
			$data['current_show'] = $show_status;
			$page = "manage_candidate_status.php";
			
			break;
			
			
			case "add_candidate_status":
						
				$statusVariables = $SettingObject->getCandidateStatusVariables();
				if(!$SettingObject->isCandidateStatusExist($statusVariables['status_name'])){
					$statusVariables['added_by']=$_SESSION['user_id'];
					$statusVariables['added_date']=date('Y-m-d H:i:s');
					
					$status_id=$SettingObject->insertCandidateStatus($statusVariables);
					
					$data['allStatus']=$SettingObject->getAllCandidateStatus();
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Candidate Status','add'); 
					
				}else{
					$is_exist = true;
					$data['status_Details'] = $statusVariables;
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = showmsg('Candidate Status','dup','status name');  
					
				}
				
				if(!isset($show_status))
					$show_status = 1;
				$data['allStatus'] = $SettingObject->getAllCandidateStatus($show_status);
				$data['rec_counts'] = $SettingObject->get_all_counts_CandidateStatus();
				$data['current_show'] = $show_status;
				$page = "manage_candidate_status.php";
			break;
			
			case "edit_candidate_status":
				
				if(!isset($show_status))
					$show_status = 1;
				$data['allStatus'] = $SettingObject->getAllCandidateStatus($show_status);
				$data['rec_counts'] = $SettingObject->get_all_counts_CandidateStatus();
				$data['current_show'] = $show_status;
				$status_Id = $_REQUEST['edit_id'];
				$status_Details=$SettingObject->getCandidateStatusDetails($status_Id);
				$data['status_Details'] = $status_Details;
				$page = "manage_candidate_status.php";
			break;
			
			case "edit_candidate_status_entry":
					
					$statusVariables = $SettingObject->getCandidateStatusVariables();
					$statusVariables['status_id']=$_REQUEST['status_id'];
					
					if(!$SettingObject->isCandidateStatusExist($statusVariables['status_name'],$statusVariables['status_id'])){
						
						$statusVariables['modified_by']=$_SESSION['user_id'];
						$statusVariables['modified_date']=date('Y-m-d H:i:s');
						$data['allStatus']=$SettingObject->getAllCandidateStatus();
						$SettingObject->updateUsingId($statusVariables,'candidate_status','status_id');
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Candidate status','update');
						
					}else{
						$data['status_Details'] = $statusVariables;
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = showmsg('Candidate status','dup','status name'); 
						
					}
					if(!isset($show_status))
						$show_status = 1;
					$data['allStatus'] = $SettingObject->getAllCandidateStatus($show_status);
					$data['rec_counts'] = $SettingObject->get_all_counts_CandidateStatus();
					$data['current_show'] = $show_status;
					$page = "manage_candidate_status.php";
			break;
			
			case "delete_candidate_status":
			
					$status_id=$_REQUEST['edit_id'];
					$SettingObject->deleteUsingId('status_id',$status_id,'candidate_status');
					$data['allStatus'] = $SettingObject->getAllCandidateStatus($show_status);
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Candidate Status','delete');
					if(!isset($show_status))
						$show_status = 1;
					$data['allStatus'] = $SettingObject->getAllCandidateStatus($show_status);
					$data['rec_counts'] = $SettingObject->get_all_counts_CandidateStatus();
					$data['current_show'] = $show_status;
					$page = "manage_candidate_status.php";
			
			break;
			
			case "restore_candidate_status" :
					
					$SettingObject->restore_CandidateStatus($edit_id);
					$data['allStatus'] = $SettingObject->getAllCandidateStatus($show_status);
					$data['rec_counts'] = $SettingObject->get_all_counts_CandidateStatus();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('Candidate status','restore');
					$page = "manage_candidate_status.php";	
			break;
			
			/***** end of candidate status*/
			
		}
?>
