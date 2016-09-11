<?php
require_once('library/accountsManager.php');
$accountsObject= new accountsManager();
require_once('library/employeeManager.php');
$employeeObject= new EmployeeManager();
require_once('library/categoryManager.php');
$categoryObject= new CategoryManager();
require_once('library/projectManager.php');
$projectObject= new ProjectManager();
	switch($function)
	{
			case "view":
				$date = new DateTime();
				$date->sub(new DateInterval('P30D'));
				
				$start_date=$date->format('Y-m-d');
				$end_date=date('Y-m-d');
				$payment_type='*';
				$category_id='0';
				
				if(isset($_REQUEST['is_post_back']) && $_REQUEST['is_post_back']=="TRUE"){
					if(isset($_REQUEST['start_date']) && $_REQUEST['start_date']!=''){
						$start_date=$_REQUEST['start_date'];
						$data['start_date']=$start_date;
					}
					if(isset($_REQUEST['end_date']) && $_REQUEST['start_date']!=''){
						$end_date=$_REQUEST['end_date'];
						$data['end_date']=$end_date;
					}
					if(isset($_REQUEST['payment_type'])){
						$payment_type=$_REQUEST['payment_type'];
						$data['payment_type']=$payment_type;
					}
					if(isset($_REQUEST['category_id'])){
						$category_id=$_REQUEST['category_id'];
						$data['category_id']=$category_id;
					}
				}
				$data['allPayments'] = $accountsObject->getAllPayments($start_date,$end_date,$payment_type,$category_id);
				$data['expense_categories']=$categoryObject->getAllPaymentCategoriesOfType('Expense');
				$data['income_categories']=$categoryObject->getAllPaymentCategoriesOfType('Income');
				//echo $page;exit;
				//$page="manage_accounts.php";
				break;
			
			case "view_incomes":
				//print_r($_SESSION); exit;
				/*$sql = "SELECT * FROM `payments` WHERE `payment_type` = 'Expense' order by `payment_id`";
				$result = mysql_query($sql);
				$count = 1;
				while($row = mysql_fetch_array($result))
				{
					$code = str_pad($count++, 4, "0", STR_PAD_LEFT);
					mysql_query("update payments set code='E".$code."' where payment_id=".$row['payment_id']);
					
				}
				exit;	*/
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}
				if(isset($_REQUEST['show_status']))
				{
					if($_REQUEST['show_status'] == 0)
					{
						$data['allIncome'] = $accountsObject->getAllIncome(1,$user_id);
					}
					else if($_REQUEST['show_status'] == 2)
					{
						$data['allIncome'] = $accountsObject->getAllIncome(2,$user_id);
					}
					else
					{
						$data['allIncome'] =  $accountsObject->getAllIncome(0,$user_id);	
					}
				}
				else
				{
					$data['allIncome'] = $accountsObject->getAllIncome(0,$user_id);
					$_REQUEST['show_status'] = 1;
				}
				$data['rec_counts'] = $accountsObject->get_allcounts_income($user_id);
				//$data['allIncome'] = $accountsObject->getAllIncome();
				$page='manage_income.php';
			break;
			
			case "show_add_income":
				$data['catdetails'] = $accountsObject->getAllIncomeCategories(1);
				$data['prodetails'] = $projectObject->getAllProjects();
				
				$page = "add_edit_income.php";
			break;	
			
			case "add_income":
				$upload_dir = "uploads";
				if(!is_dir($upload_dir."/income_invoice")){
					mkdir($upload_dir."/income_invoice");
				}
				$accountsObject->getIncomeAccountVariables();
				$accountVariables = $accountsObject->db_fields;
				$result = $accountsObject->getAutoIncrement();  /* This will return AUTO_INCREMENT value */
				//$allowedExts = array("pdf", "doc", "docx");
				if($_FILES["invoice"]["name"] != ""){
					$file_name = explode(".", $_FILES["invoice"]["name"]);
					$_FILES["invoice"]["name"] = $file_name[0]."_".$result['Auto_increment'].".".$file_name[1];
					if(!(move_uploaded_file($_FILES["invoice"]["tmp_name"], $upload_dir."/income_invoice/".$_FILES["invoice"]["name"]))){
					}
					$accountVariables['invoice'] = $_FILES["invoice"]["name"];
				}
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}
				
//				var_dump($accountVariables);exit;
				$accountVariables['added_by']=$_SESSION['user_id'];
				$accountVariables['added_date']=date('Y-m-d H:i:s');
				
				
				$accountIdInserted = $accountsObject->insert($accountVariables,'payments');
				$data['rec_counts'] = $accountsObject->get_allcounts_income($user_id);
				$data['allIncome'] = $accountsObject->getAllIncome(0,$user_id);
				$page = "manage_income.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Income','add'); 
			break;
			
			case "edit_income":
				$data['catdetails'] = $accountsObject->getAllIncomeCategories(0);
				$data['prodetails'] = $projectObject->getAllProjects();
				
				$paymentId = $_REQUEST['edit_id'];				
				$incomeDetails = $accountsObject->getIncomeDetails($paymentId);
			    $data['incomeDetails'] = $incomeDetails;
				$data['incomeDetails']['payment_id'] = $paymentId;
				$page="add_edit_income.php";
			break;
			
			case "edit_income_entry":
				$old_invoice = $_POST['old_invoice'];
				$upload_dir = "uploads";
				if(!is_dir($upload_dir."/income_invoice")){
					mkdir($upload_dir."/income_invoice");
				}
				
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}
				$accountsObject->getIncomeAccountVariables();
				$accountVariables = $accountsObject->db_fields;
				$accountVariables['payment_id'] = $_REQUEST['edit_id'];
				
				$accountVariables['modified_by']=$_SESSION['user_id'];
				$accountVariables['modified_date']=date('Y-m-d H:i:s');
				
				if($_FILES['invoice']['name'] != ''){
					$file_name = explode(".", $_FILES["invoice"]["name"]);
					$_FILES["invoice"]["name"] = $file_name[0]."_".$accountVariables['payment_id'].".".$file_name[1];
					if($old_invoice != ''){
						if($_FILES["invoice"]["name"] != $old_invoice){
							$accountVariables['invoice'] = $_FILES["invoice"]["name"];
							unlink($upload_dir."/income_invoice/".$old_invoice);
							if(!(move_uploaded_file($_FILES["invoice"]["tmp_name"], $upload_dir."/income_invoice/".$_FILES["invoice"]["name"]))){
							}
						}
					}else{
						$accountVariables['invoice'] = $_FILES["invoice"]["name"];
						if(!(move_uploaded_file($_FILES["invoice"]["tmp_name"], $upload_dir."/income_invoice/".$_FILES["invoice"]["name"]))){
						}
					}
				}
				
				$accountsObject->update($accountVariables,"payments","payment_id");
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Payment','update');
				$page="manage_income.php";
				$data['rec_counts'] = $accountsObject->get_allcounts_income($user_id);
				$data['allIncome'] = $accountsObject->getAllIncome(0,$user_id);
			break;
			
			case "delete_income":			
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}
				$income_id=$_REQUEST['edit_id'];
				$accountsObject->delete($income_id,'payments','payment_id');
				$data['allIncome'] = $accountsObject->getAllIncome(0,$user_id);
				$data['rec_counts'] = $accountsObject->get_allcounts_income($user_id);
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Income','delete');
				$page="manage_income.php";
			break;
			
			case "restore_payment_income" :
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}
				$payment_id=$_REQUEST['edit_id'];
				$accountsObject->restoreIncomeExpense($payment_id);
				$data['allIncome'] = $accountsObject->getAllIncome(0,$user_id);
				$data['rec_counts'] = $accountsObject->get_allcounts_income($user_id);
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Income','restore');
				$page="manage_income.php";
			break;
			
			case "download_income_invoice":
				$file = "uploads/income_invoice/".$_POST['edit_id'];
				$mime_type = array("doc"=>"application/msword", "docx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.document", "pdf"=>"application/pdf");
				if (file_exists($file)) {
					header('Content-Description: File Transfer');
					header('Content-Type:' .$mime_type);
					header('Content-Disposition: attachment; filename='.basename($file));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					ob_clean();
					flush();
					readfile($file);
					exit;
				}
				exit;
				
			case "view_expenses":
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}
				if(isset($_REQUEST['show_status']))
				{
					if($_REQUEST['show_status'] == 0)
					{
						$data['allExpense'] = $accountsObject->getAllExpense(1,$user_id);
					}
					else if($_REQUEST['show_status'] == 2)
					{
						$data['allExpense'] = $accountsObject->getAllExpense(2,$user_id);
					}
					else
					{
						$data['allExpense'] =  $accountsObject->getAllExpense(0,$user_id);	
					}
				}
				else
				{
					$data['allExpense'] = $accountsObject->getAllExpense(0,$user_id);
					
				}
				$data['rec_counts'] = $accountsObject->get_allcounts_expense($user_id);
				//$data['allExpense'] = $accountsObject->getAllExpense();
				$page='manage_expense.php';
			break;	
			
			case "show_add_expense":
				$data['catdetails'] = $accountsObject->getAllExpenseCategories();
				$data['empdetails'] = $employeeObject->getAllEmployees();
				$data['prodetails'] = $projectObject->getAllProjects();
				$page = "add_edit_expense.php";
			break;
			
			case "add_expense":
				$upload_dir = "uploads";
				if(!is_dir($upload_dir."/expense_invoice")){
					mkdir($upload_dir."/expense_invoice");
				}
				$accountsObject->getExpenseAccountVariables();
				$accountVariables = $accountsObject->db_fields;
				$result = $accountsObject->getAutoIncrement();  /* This will return AUTO_INCREMENT value */
				//$allowedExts = array("pdf", "doc", "docx");
				if($_FILES["invoice"]["name"] != ""){
					$file_name = explode(".", $_FILES["invoice"]["name"]);
					$_FILES["invoice"]["name"] = $file_name[0]."_".$result['Auto_increment'].".".$file_name[1];
					if(!(move_uploaded_file($_FILES["invoice"]["tmp_name"], $upload_dir."/expense_invoice/".$_FILES["invoice"]["name"]))){
						
					}
					$accountVariables['invoice'] = $_FILES["invoice"]["name"];
				}
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}
				
				$accountVariables['added_by']=$_SESSION['user_id'];
				$accountVariables['added_date']=date('Y-m-d H:i:s');
				$accountIdInserted = $accountsObject->insert($accountVariables,'payments');
				$data['allExpense'] = $accountsObject->getAllExpense(0,$user_id);
				$data['rec_counts'] = $accountsObject->get_allcounts_expense($user_id);
				$page = "manage_expense.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = $arr_msg['account']['expense_logged'];
			break;
			
			case "edit_expense":
			
				$data['catdetails'] = $accountsObject->getAllExpenseCategories();
				$data['empdetails'] = $employeeObject->getAllEmployees();
				$data['prodetails'] = $projectObject->getAllProjects();
				$paymentId = $_REQUEST['edit_id'];				
				$expenseDetails = $accountsObject->getExpenseDetails($paymentId);
			    $data['expenseDetails'] = $expenseDetails;
				$data['expenseDetails']['payment_id'] = $paymentId;
				$page="add_edit_expense.php";
			break;
			
			case "edit_expense_entry":
				$old_invoice = $_POST['old_invoice'];
				$upload_dir = "uploads";
				if(!is_dir($upload_dir."/expense_invoice")){
					mkdir($upload_dir."/expense_invoice");
				}
				
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}
				$accountsObject->getExpenseAccountVariables();
				$accountVariables = $accountsObject->db_fields;
				$accountVariables['payment_id'] = $_REQUEST['edit_id'];
				$accountVariables['modified_by']=$_SESSION['user_id'];
				$accountVariables['modified_date']=date('Y-m-d H:i:s');
				
				if($_FILES['invoice']['name'] != ''){
					$file_name = explode(".", $_FILES["invoice"]["name"]);
					$_FILES["invoice"]["name"] = $file_name[0]."_".$accountVariables['payment_id'].".".$file_name[1];
					if($old_invoice != ''){
						if($_FILES["invoice"]["name"] != $old_invoice){
							$accountVariables['invoice'] = $_FILES["invoice"]["name"];
							unlink($upload_dir."/expense_invoice/".$old_invoice);
							if(!(move_uploaded_file($_FILES["invoice"]["tmp_name"], $upload_dir."/expense_invoice/".$_FILES["invoice"]["name"]))){
							}
						}
					}else{
						$accountVariables['invoice'] = $_FILES["invoice"]["name"];
						if(!(move_uploaded_file($_FILES["invoice"]["tmp_name"], $upload_dir."/expense_invoice/".$_FILES["invoice"]["name"]))){
						}
					}
				}
				
				$accountsObject->update($accountVariables,"payments","payment_id");
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Payment','update');
				$page="manage_expense.php";
				$data['allExpense'] = $accountsObject->getAllExpense(0,$user_id);
				$data['rec_counts'] = $accountsObject->get_allcounts_expense($user_id);
			break;
			
			case "delete_expense":
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}			
				$expense_id=$_REQUEST['edit_id'];
				$accountsObject->delete($expense_id,'payments','payment_id');
				$data['allExpense'] = $accountsObject->getAllExpense(0,$user_id);
				$data['rec_counts'] = $accountsObject->get_allcounts_expense($user_id);
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Expense','delete');
				$page="manage_expense.php";
			break;
			
			case "restore_payment_expense" :
				if($_SESSION['user_main_group'] != developer_grpid){
					$user_id = $_SESSION['user_id'];	
				}else{
					$user_id = 0;	
				}
				$payment_id=$_REQUEST['edit_id'];
				$accountsObject->restoreIncomeExpense($payment_id);
				$data['allExpense'] = $accountsObject->getAllExpense(0,$user_id);
				$data['rec_counts'] = $accountsObject->get_allcounts_expense($user_id);
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('Expense','restore');
				$page="manage_expense.php";
			break;
			
			case "download_expense_invoice":
				$file = "uploads/expense_invoice/".$_POST['edit_id'];
				$mime_type = array("doc"=>"application/msword", "docx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.document", "pdf"=>"application/pdf");
				if (file_exists($file)) {
					header('Content-Description: File Transfer');
					header('Content-Type:' .$mime_type);
					header('Content-Disposition: attachment; filename='.basename($file));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					ob_clean();
					flush();
					readfile($file);
					exit;
				}
				exit;
				
			/**** Expected Expense CRUD ****/
			case "view_expected_expenses":
			//echo $show_status;
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allExpectedExpense'] = $accountsObject->getAllExpectedExpense($show_status);
				$data['rec_counts'] = $accountsObject->get_allcounts_expected_expense();
				$data['current_show'] = $show_status;
				$page = "manage_expected_expense.php";
			break;
			
			case "show_add_expected_expense" :
				$data['catdetails'] = $accountsObject->getAllExpenseCategories(1);
				$data['empdetails'] = $employeeObject->getAllEmployees();
				$data['prodetails'] = $projectObject->getAllProjects();
				$page = "add_edit_expected_expense.php";
			break;
			
			case "add_expected_expense":
				$accountsObject->getExpectedExpenseAccountVariables();
				$accountVariables = $accountsObject->db_fields;
				$accountVariables['added_by']=$_SESSION['user_id'];
				$accountVariables['added_date']=date('Y-m-d H:i:s');
				$accountIdInserted = $accountsObject->insert($accountVariables,'expected_expense');
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Expected Expense','add');
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allExpectedExpense'] = $accountsObject->getAllExpectedExpense($show_status);
				$data['rec_counts'] = $accountsObject->get_allcounts_expected_expense();
				$data['current_show'] = $show_status;
				$page = "manage_expected_expense.php"; 
			break;
			
			case "edit_expected_expense":
				$data['catdetails'] = $accountsObject->getAllExpenseCategories();
				$data['empdetails'] = $employeeObject->getAllEmployees();
				$data['prodetails'] = $projectObject->getAllProjects();
				$expectedExpenseId = $_REQUEST['edit_id'];				
				$expectedExpenseDetails = $accountsObject->getExpectedExpenseDetails($expectedExpenseId);
			    $data['expectedExpenseDetails'] = $expectedExpenseDetails;
				$data['expectedExpenseDetails']['expected_expense_id'] = $expectedExpenseId;
				$page="add_edit_expected_expense.php";
			break;
			
			case "edit_expected_expense_entry":
				$accountsObject->getExpectedExpenseAccountVariables();
				$accountVariables = $accountsObject->db_fields;
				$accountVariables['expected_expense_id'] = $_REQUEST['edit_id'];
				
				$accountVariables['modified_by']=$_SESSION['user_id'];
				$accountVariables['modified_date']=date('Y-m-d H:i:s');
				
				$accountsObject->update($accountVariables,"expected_expense","expected_expense_id");
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Expected Expense','update');
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allExpectedExpense'] = $accountsObject->getAllExpectedExpense($show_status);
				$data['rec_counts'] = $accountsObject->get_allcounts_expected_expense();
				$data['current_show'] = $show_status;
				$page = "manage_expected_expense.php"; 
			break;
			
			case"delete_expected_expense":
				$expected_expense_id=$_REQUEST['edit_id'];
				$accountsObject->delete($expected_expense_id,'expected_expense','expected_expense_id');
				$data['allExpectedExpense'] = $accountsObject->getAllExpectedExpense();
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('Expected Expense','delete');
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allExpectedExpense'] = $accountsObject->getAllExpectedExpense($show_status);
				$data['rec_counts'] = $accountsObject->get_allcounts_expected_expense();
				$data['current_show'] = $show_status;
				$page = "manage_expected_expense.php"; 
			break;
			
			case "mark_as_paid":
				$expected_expense_id=$_REQUEST['edit_id'];
				$accountsObject->delete($expected_expense_id,'expected_expense','expected_expense_id');
//				$data['allExpectedExpense'] = $accountsObject->getAllExpectedExpense();
				
				$accountsObject->getExpectedExpenseAccountVariables();
				$accountVariables = $accountsObject->db_fields;
				$accountVariables['payment_type'] = "Expense";
				$accountVariables['payment_date'] = date('Y-m-d H:i:s');
				$accountVariables['added_by'] = $_SESSION['user_id'];
				$accountVariables['added_date'] = date('Y-m-d H:i:s');
				unset($accountVariables['expected_payment_date']);
				$accountIdInserted = $accountsObject->insert($accountVariables,'payments');				
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = $arr_msg['account']['expense_paid'];
				
				if(isset($show_status))
					$show_status = $show_status;
				else
					$show_status = 1;
				$data['allExpectedExpense'] = $accountsObject->getAllExpectedExpense($show_status);
				$data['rec_counts'] = $accountsObject->get_allcounts_expected_expense();
				$data['current_show'] = $show_status;
				
				$page="manage_expected_expense.php";
			break;
			
			case "restore_expected_expense":
					$accountsObject->restore_expected_expense($edit_id);
					$data['allExpectedExpense'] = $accountsObject->getAllExpectedExpense($show_status);
					$data['rec_counts'] = $accountsObject->get_allcounts_expected_expense();
					$data['current_show'] = $show_status;
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('expected expense','restore');
					$page = "manage_expected_expense.php";	
			break;
			/**** End Of Expected Expense CRUD ****/
			
			
			case "category_overview":
				//echo "<pre>"; print_r($_POST);
				$date = new DateTime();
				$date->sub(new DateInterval('P30D'));
				
				$start_date=$date->format('Y-m-d');
				$end_date=date('Y-m-d');
				$payment_type='*';
				$category_id= '0';
				
				if(isset($_REQUEST['is_post_back']) && $_REQUEST['is_post_back']=="TRUE"){
					if(isset($_REQUEST['start_date']) && $_REQUEST['start_date']!=''){
						$start_date=$_REQUEST['start_date'];
						$data['start_date']=$start_date;
					}
					if(isset($_REQUEST['end_date']) && $_REQUEST['start_date']!=''){
						$end_date=$_REQUEST['end_date'];
						$data['end_date']=$end_date;
					}
					if(isset($_REQUEST['payment_type'])){
						$payment_type=$_REQUEST['payment_type'];
						$data['payment_type']=$payment_type;
					}
					if(isset($_REQUEST['category_id'])){
						$category_id=implode(',',$_REQUEST['category_id']);
						$data['category_id']=$category_id;
						
					}
				}
				$data['allPayments'] = $accountsObject->getAllCategoryOverview($start_date,$end_date,$payment_type,$category_id);
				//echo "<pre>"; print_r($data['allPayments']);exit;
				$data['expense_categories']=$categoryObject->getAllPaymentCategoriesOfType('Expense');
				$data['income_categories']=$categoryObject->getAllPaymentCategoriesOfType('Income');
				$page = "manage_category_overview.php";
			break;
		}
?>