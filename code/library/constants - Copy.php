<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}
$PAGE_LEVELS=array('1','2','3','4');

$SUPER_LEVEL_ACCESS = array('1','2');

define('developer_grpid','1');

// for changing msgs for add, edit, delete, make changes in function of name 'showmsg' written in commonFunction.php
$arr_msg = array(
			'group' => array(
						'delpermission' => "You do not have permission to delete this group!"				
						),
			'reimbursement' => array(
						'paid' => "Reimbursement paid successfully!"						
						),
			'attendance' => array(
						'login' => "User login successfully!",						
						'loggedin' => "You are already logged In!",						
						'innote_save' => "In note saved successfully!",						
						'logout' => "User logout successfully!",						
						'loggedout' => "You are already logged out!",						
						'note_update' => "Notes updated successfully!",						
						'put_ note' => "Put some notes to update!",						
						'selemployee' => "Please select atleast one employee !"						
						),
			'leave' => array(
						'apply' => "'Leave applied successfully!",						
						'date_valid' => "End date greater than start date!"						
						),
			'order' => array(
						'restore' => "Order restored successfully!"						
						),
			'account' => array(
						'expense_logged' => "Expense logged successfully!",	
						'expense_paid' => "Expected expense marked as a paid!"	
						),
			'setting' => array(
						'upload_error' => "file can not be uploaded!",						
						'upload' => "file Uploaded successfully!",						
						'file_type' => "check file format or size of file!",						
						'file_select' => "File not selected!",
						'file_exist' => "already exist!",
						'function_exist' => "Function already exist!",
						'status_restore' => "Status restored successfully!",	
						'status_name_exist' => "Status name already exist!",	
						'status_order_exist' => "Status order already exist!",	
						'status_exist' => "Status name and order already exist!",	
						'mandatory' => "Please fill mandatory fields.",
						'financial_month' => "Date should be number between 2 to 28. If you want to set financial date as 1 then please select defalut date.",
						'function_menu_order' => 'Function order already exist!',		
						),
			);