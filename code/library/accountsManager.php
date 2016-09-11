<?
//Vishak Nair - 25/08/2012
//for user management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
extract($_POST);
require_once('Config.php');
class AccountsManager extends commonObject
{
	public $db_fields;
	function AccountsManager(){
		$this->db_fields = array();	
	}
	
	//Function to fetch records for report
	function getAllPayments($start_date='0000-00-00',$end_date='0000-00-00',$payment_type='*',$category_id='0'){
		$where="";
		if($start_date!=='0000-00-00' || $end_date!=='0000-00-00' || $payment_type!=='*' || $category_id!=='0'){
			$where="WHERE ";
		}
		
		if($start_date!=='0000-00-00' && $end_date!=='0000-00-00'){
			$where.="p.payment_date BETWEEN '".$start_date."' AND '".$end_date."'";
		}else if($start_date!=='0000-00-00' && $end_date==='0000-00-00'){
			$where.="p.payment_date > '".$start_date."'";
		}else if($start_date==='0000-00-00' && $end_date!=='0000-00-00'){
			$where.="p.payment_date < '".$end_date."'";
		}
		
		
		if($payment_type!=='*'){
			if(strpos($where,'payment_date')!==FALSE){
				$where.=" AND ";
			}
			$where.="p.payment_type='".$payment_type."'";
		}
		
		if($category_id!=='0'){
			if(strpos($where,'payment_date')!==FALSE || strpos($where,'payment_type')!==FALSE){
				$where.=" AND ";
			}
			$where.="p.category_id IN(".$category_id.")";
		}
			
		$query="Select p.*,c.name as category_name,emp.employee_name as employee_name,prj.project_name as project_name from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id LEFT OUTER JOIN projects prj ON p.project_id=prj.project_id ".$where." AND p.is_active=1 order by payment_date DESC,payment_type ASC";
		//echo $query;exit;
		return getData($query);
	}
	
	function getAllCategoryOverview($start_date='0000-00-00',$end_date='0000-00-00',$payment_type='*',$category_id='0'){
		$where="";
		if($start_date!=='0000-00-00' || $end_date!=='0000-00-00' || $payment_type!=='*' || $category_id!=='0'){
			$where="WHERE ";
		}
		
		if($start_date!=='0000-00-00' && $end_date!=='0000-00-00'){
			$where.="p.payment_date BETWEEN '".$start_date."' AND '".$end_date."'";
		}else if($start_date!=='0000-00-00' && $end_date==='0000-00-00'){
			$where.="p.payment_date > '".$start_date."'";
		}else if($start_date==='0000-00-00' && $end_date!=='0000-00-00'){
			$where.="p.payment_date < '".$end_date."'";
		}
		
		
		if($payment_type!=='*'){
			if(strpos($where,'payment_date')!==FALSE){
				$where.=" AND ";
			}
			$where.="p.payment_type='".$payment_type."'";
		}
		
		if($category_id!=='0'){
			if(strpos($where,'payment_date')!==FALSE || strpos($where,'payment_type')!==FALSE){
				$where.=" AND ";
			}
			$where.="p.category_id IN(".$category_id.")";
		}
			
		$query="Select p.*,sum(p.amount) as aggr_sum,sum(p.amount_usd) as aggr_sum_usd,c.name as category_name,emp.employee_name as employee_name,prj.project_name as project_name from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id LEFT OUTER JOIN projects prj ON p.project_id=prj.project_id ".$where."  AND p.is_active=1 group by p.`category_id` order by payment_date DESC,payment_type ASC";
	//echo $query;exit;
		return getData($query);
		
		/* Select p.*,sum(p.amount) as agg_sum, c.name as category_name,emp.employee_name as employee_name,prj.project_name as project_name from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id LEFT OUTER JOIN projects prj ON p.project_id=prj.project_id WHERE p.payment_date BETWEEN '2014-03-02' AND '2014-04-01' AND p.category_id IN(1,6,3,7) group by p.`category_id` order by payment_date DESC,payment_type ASC */
	}
	
	//Return total of Income payment
	function getTotalAmountOfIncome($year, $month, $selected_day)
	{
		
		
		if($selected_day == 0)
		{
			
			$days_in_month = cal_days_in_month(CAL_GREGORIAN, intval($month), intval($year));
			
		$income_total =  getData("SELECT sum(amount) as total_amount from payments where `payment_type`='Income' and `payment_date`>='".$year."-".$month."-01' and `payment_date`<='".$year."-".$month."-".$days_in_month."'");
		}
		
		else
		{	/*
			echo $year;
			echo $month;
			echo $selected_day;
			exit;
			*/
			
			$income_total =  getData("SELECT sum(amount) as total_amount from payments where `payment_type`='Income' and `payment_date`>='".$year."-".$month."-".$selected_day."' and `payment_date`<='".$year."-".($month+1)."-".($selected_day-1)."'");
			
		}
		
		//var_dump($income_total);exit;
		
		if($income_total[0]['total_amount'] != NULL)	
			return 	$income_total[0]['total_amount'];
		else{
			return 0;
		}
	}
	
	//Return total of Expense payment
	function getTotalAmountOfExpense($year, $month, $selected_day)
	{	
		if($selected_day == 0)
		{
			$days_in_month = cal_days_in_month(CAL_GREGORIAN, intval($month), intval($year));
			
		$expense_total = getData("SELECT sum(amount) as total_amount from payments where `payment_type`='Expense' and `payment_date`>='".$year."-".$month."-01' and `payment_date`<='".$year."-".$month."-".$days_in_month."'");
		
		}
		else
		{
			$expense_total = getData("SELECT sum(amount) as total_amount from payments where `payment_type`='Expense' and `payment_date`>='".$year."-".$month."-".$selected_day."' and `payment_date`<='".$year."-".($month+1)."-".($selected_day-1)."'");
		}
		
		if($expense_total[0]['total_amount'] != NULL)	
			return 	$expense_total[0]['total_amount'];
		else{
			return 0;
		}
	}
	
	//Return Income-Expense payment
	function getTotalAmountOfIncomeAndExpense($year, $month, $selected_day)
	{	
		if($selected_day == 0)
		{
		$days_in_month = cal_days_in_month(CAL_GREGORIAN, intval($month), intval($year));
		
		$income_total =  getData("SELECT sum(amount) as income_total from payments where `payment_type`='Income' and `payment_date`>='".$year."-".$month."-01' and `payment_date`<='".$year."-".$month."-".$days_in_month."'");
		
		
		$expense_total =  getData("SELECT sum(amount) as expense_total from payments where `payment_type`='Expense' and `payment_date`>='".$year."-".$month."-01' and `payment_date`<='".$year."-".$month."-".$days_in_month."'");	
		
		}
		else
		{
			$income_total =  getData("SELECT sum(amount) as income_total from payments where `payment_type`='Income' and `payment_date`>='".$year."-".$month."-".$selected_day."' and `payment_date`<='".$year."-".($month+1)."-".($selected_day-1)."'");
		
		
		$expense_total =  getData("SELECT sum(amount) as expense_total from payments where `payment_type`='Expense' and `payment_date`>='".$year."-".$month."-".$selected_day."' and `payment_date`<='".$year."-".($month+1)."-".($selected_day-1)."'");
		}
		
		$diffrence = $income_total[0]['income_total'] - $expense_total[0]['expense_total'];
		return $diffrence;
	}
	
	function getAllIncome($value,$user_id)
	{
		$condition='';
		if($user_id != 0){
			$condition = 'and payments.added_by='.$user_id;	
		}
		if($value == 0){
			return getData("Select payments.*,pr.project_name,user.addby,moduser.modby from payments LEFT OUTER JOIN projects pr ON payments.project_id=pr.project_id LEFT JOIN (SELECT user_id,user_name as addby from users) as user ON  payments.added_by=user.user_id LEFT JOIN (SELECT user_id,user_name as modby from users) as moduser  ON  payments.modified_by=moduser.user_id where payments.payment_type = 'Income' and payments.is_active=1  ".$condition." order by payment_date desc");
			//return getData("Select pa.*,pr.project_name from payments pa LEFT OUTER JOIN projects pr ON pa.project_id=pr.project_id where pa.payment_type = 'Income' and pa.is_active=1 ".$condition." order by payment_date desc");
		}else if($value == 1)
			return getData("Select payments.*,pr.project_name,user.addby,moduser.modby from payments LEFT OUTER JOIN projects pr ON payments.project_id=pr.project_id LEFT JOIN (SELECT user_id,user_name as addby from users) as user ON  payments.added_by=user.user_id LEFT JOIN (SELECT user_id,user_name as modby from users) as moduser  ON  payments.modified_by=moduser.user_id where payments.payment_type = 'Income' ".$condition."  order by payment_date desc");	
			//return getData("Select pa.*,pr.project_name from payments pa LEFT OUTER JOIN projects pr ON pa.project_id=pr.project_id where pa.payment_type = 'Income' ".$condition." order by payment_date desc");
		else if($value == 2)
			return getData("Select payments.*,pr.project_name,user.addby,moduser.modby from payments LEFT OUTER JOIN projects pr ON payments.project_id=pr.project_id LEFT JOIN (SELECT user_id,user_name as addby from users) as user ON  payments.added_by=user.user_id LEFT JOIN (SELECT user_id,user_name as modby from users) as moduser  ON  payments.modified_by=moduser.user_id where payments.payment_type = 'Income' ".$condition."  and payments.is_active=0 order by payment_date desc");
			//return getData("Select pa.*,pr.project_name from payments pa LEFT OUTER JOIN projects pr ON pa.project_id=pr.project_id where pa.payment_type = 'Income' ".$condition."  and pa.is_active=0 order by payment_date desc");	
	}
	
	function get_allcounts_income($user_id)
	{
		$condition='';
		if($user_id != 0){
			$condition = ' and pa.added_by='.$user_id.' ';	
		}
		$arr_counts = array();
		$all = getOne("Select COUNT(payment_id) AS CNT from payments pa LEFT OUTER JOIN projects pr ON pa.project_id=pr.project_id where pa.payment_type = 'Income' ".$condition." order by payment_date desc");
		$arr_counts['all'] = $all;
		$active = getOne("Select COUNT(payment_id) AS CNT from payments pa LEFT OUTER JOIN projects pr ON pa.project_id=pr.project_id where pa.payment_type = 'Income' ".$condition." and pa.is_active=1 order by payment_date desc");
		$arr_counts['active'] = $active;
		$trash = getOne("Select COUNT(payment_id) AS CNT from payments pa LEFT OUTER JOIN projects pr ON pa.project_id=pr.project_id where pa.payment_type = 'Income' ".$condition." and pa.is_active=0 order by payment_date desc");
		$arr_counts['deleted'] = $trash;
		return $arr_counts;
		
	}
	
	function restoreIncomeExpense($payment_id)
	{
		updateData("UPDATE payments SET is_active=1 WHERE payment_id=".$payment_id);	
	}
	
	function getAllIncomeCategories($in_add=0){
		$query = "Select * from payment_category where type='Income'"; 
		if($in_add==1)
		{$query .= " and is_active=1"; }
		return getData($query);
	}
	
	function getAllExpenseCategories($in_add=0){
		
		$query = "Select * from payment_category where type='Expense'"; 
		if($in_add==1)
		{$query .= " and is_active=1"; }
		return getData($query);
	}
	
	function getIncomeDetails($payment_id)
	{
		return $resultSet = getRow("select * from  payments where payment_id='".$payment_id."'");
	}
		
	function getIncomeAccountVariables()
	{
		$this->db_fields['category_id'] = $_REQUEST['category_id'];
		$this->db_fields['payment_type']="Income";
		if(isset( $_REQUEST['project']))
			$this->db_fields['project_id'] = $_REQUEST['project'];
		$this->db_fields['amount_usd'] = $_REQUEST['amount_usd'];
		$this->db_fields['conversion_rate'] = $_REQUEST['conversion_rate'];
		$this->db_fields['amount'] = $_REQUEST['amount_inr'];
		$this->db_fields['payment_sent_date'] = $_REQUEST['sent_alt'];
		$this->db_fields['payment_date'] = $_REQUEST['recived_alt'];
		$this->db_fields['remarks'] = $_REQUEST['remark'];
		$this->db_fields['transaction_id'] = $_REQUEST['transaction_id'];				
	}
	
	//Expense Functions 
	function getAllExpense($value,$user_id)
	{
		$condition='';
		if($user_id != 0){
			$condition = 'and p.added_by='.$user_id;	
		}
		if($value == 0)
			return getData("Select p.*,c.name as category_name,emp.employee_name as employee_name ,user.addby,moduser.modby from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id LEFT JOIN (SELECT user_id,user_name as addby from users) as user ON  p.added_by=user.user_id LEFT JOIN (SELECT user_id,user_name as modby from users) as moduser  ON  p.modified_by=moduser.user_id where payment_type = 'Expense' AND p.is_active=1  ".$condition." order by payment_date DESC,payment_type ASC");
			//return getData("Select p.*,c.name as category_name,emp.employee_name as employee_name from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id where payment_type = 'Expense' AND p.is_active=1 ".$condition." order by payment_date DESC,payment_type ASC");
		else if($value == 1)
			return getData("Select p.*,c.name as category_name,emp.employee_name as employee_name ,user.addby,moduser.modby from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id LEFT JOIN (SELECT user_id,user_name as addby from users) as user ON  p.added_by=user.user_id LEFT JOIN (SELECT user_id,user_name as modby from users) as moduser  ON  p.modified_by=moduser.user_id where payment_type = 'Expense' ".$condition." order by payment_date DESC,payment_type ASC");
			//return getData("Select p.*,c.name as category_name,emp.employee_name as employee_name from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id where payment_type = 'Expense' ".$condition." order by payment_date DESC,payment_type ASC");
		else if($value == 2)
			return getData("Select p.*,c.name as category_name,emp.employee_name as employee_name ,user.addby,moduser.modby from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id LEFT JOIN (SELECT user_id,user_name as addby from users) as user ON  p.added_by=user.user_id LEFT JOIN (SELECT user_id,user_name as modby from users) as moduser  ON  p.modified_by=moduser.user_id where payment_type = 'Expense' AND p.is_active=0 ".$condition." order by payment_date DESC,payment_type ASC");	
			//return getData("Select p.*,c.name as category_name,emp.employee_name as employee_name from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id where payment_type = 'Expense' AND p.is_active=0 ".$condition." order by payment_date DESC,payment_type ASC");	
	}
	
	function get_allcounts_expense($user_id)
	{
		$condition='';
		if($user_id != 0){
			$condition = 'and p.added_by='.$user_id;	
		}
		$arr_counts = array();
		$all = getOne("Select COUNT(payment_id) AS CNT from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id where payment_type = 'Expense' ".$condition." order by payment_date DESC,payment_type ASC");
		$arr_counts['all'] = $all;
		$active = getOne("Select COUNT(payment_id) AS CNT from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id where payment_type = 'Expense' AND p.is_active=1 ".$condition." order by payment_date DESC,payment_type ASC");
		$arr_counts['active'] = $active;
		$trash = getOne("Select COUNT(payment_id) AS CNT from payments p LEFT OUTER JOIN `payment_category` c ON p.category_id=c.pc_id LEFT OUTER JOIN employee emp ON p.employee_id=emp.employee_id where payment_type = 'Expense' AND p.is_active=0 ".$condition." order by payment_date DESC,payment_type ASC");
		$arr_counts['deleted'] = $trash;
		return $arr_counts;
	}
	
	function getExpenseAccountVariables()
	{
		$this->db_fields['category_id'] = $_REQUEST['category_id'];
		$this->db_fields['payment_type']="Expense";
		if(isset($_REQUEST['employee']))
			$this->db_fields['employee_id'] = $_REQUEST['employee'];
		$this->db_fields['amount_usd'] = $_REQUEST['amount_usd'];
		$this->db_fields['conversion_rate'] = $_REQUEST['conversion_rate'];
		$this->db_fields['amount'] = $_REQUEST['amount_inr'];
		$this->db_fields['payment_sent_date'] = $_REQUEST['sent_alt'];
		$this->db_fields['payment_date'] = $_REQUEST['recived_alt'];
		$this->db_fields['remarks'] = $_REQUEST['remark'];	
		$this->db_fields['project_id'] = $_REQUEST['project'];
		$this->db_fields['transaction_id'] = $_REQUEST['transaction_id'];
	}
	
	function getExpenseDetails($payment_id)
	{
		return $resultSet = getRow("select * from  payments where payment_id='".$payment_id."'");
	}
	
	function getIncomePaymentById($projectId)
	{
		return $resultSet = getData("select * from payments where payment_type='Income' and project_id='".$projectId."'");
	}
	function getExpensePaymentById($projectId)
	{
		return $resultSet = getData("select * from payments where payment_type='Expense' and project_id='".$projectId."'");
	}
	
	function getAutoIncrement(){
		$result =  getData("SHOW TABLE STATUS LIKE 'payments'");
		return $result[0];
	}
	//Expected Expense Functions
	function getAllExpectedExpense($show='1')
		{
			if($show == 0)
				$arr_orders =  getData("Select ee.*,c.name as category_name,emp.employee_name as employee_name from expected_expense ee LEFT OUTER JOIN `payment_category` c ON ee.category_id=c.pc_id LEFT OUTER JOIN employee emp ON ee.employee_id=emp.employee_id order by expected_payment_date DESC ");
			elseif($show == 1)
				$arr_orders =  getData("Select ee.*,c.name as category_name,emp.employee_name as employee_name from expected_expense ee LEFT OUTER JOIN `payment_category` c ON ee.category_id=c.pc_id LEFT OUTER JOIN employee emp ON ee.employee_id=emp.employee_id where ee.is_active=1 order by expected_payment_date DESC");
			elseif($show == 2)
				$arr_orders =  getData("Select ee.*,c.name as category_name,emp.employee_name as employee_name from expected_expense ee LEFT OUTER JOIN `payment_category` c ON ee.category_id=c.pc_id LEFT OUTER JOIN employee emp ON ee.employee_id=emp.employee_id where ee.is_active=0 order by expected_payment_date DESC");
			return $arr_orders;
		}
		
		function get_allcounts_expected_expense()
		{
			$arr_counts = array();
			$all = getOne("SELECT COUNT(expected_expense_id) AS CNT From expected_expense WHERE 1");
			$arr_counts['all'] = $all;
			$active = getOne("SELECT COUNT(expected_expense_id) AS CNT From expected_expense WHERE is_active = 1");
			$arr_counts['active'] = $active;
			$trash = getOne("SELECT COUNT(expected_expense_id) AS CNT From expected_expense WHERE is_active = 0");
			$arr_counts['trash'] = $trash;
			return $arr_counts;
			
		}
		
		function restore_expected_expense($id)
		{
			$change_data = array (
									'is_active' => 1,							
									); 
			$change_data['expected_expense_id'] = $id;
			$updateQry=$this->getUpdateDataString($change_data,"expected_expense","expected_expense_id");
			updateData($updateQry);
			
		}
	
	/*function getAllExpectedExpense()
	{
		return $resultSet = getData("Select ee.*,c.name as category_name,emp.employee_name as employee_name from expected_expense ee LEFT OUTER JOIN `payment_category` c ON ee.category_id=c.pc_id LEFT OUTER JOIN employee emp ON ee.employee_id=emp.employee_id where ee.is_active=1 order by expected_payment_date DESC");	
	}*/
	
	function getExpectedExpenseDetails($expectedExpenseId)
	{
		return $resultSet = getRow("select * from  expected_expense where expected_expense_id='".$expectedExpenseId."'");	
	}
	
	function getExpectedExpenseAccountVariables()
	{
		$this->db_fields['category_id'] = $_REQUEST['category_id'];
		if(isset($_REQUEST['employee']))
			$this->db_fields['employee_id'] = $_REQUEST['employee'];
		$this->db_fields['amount_usd'] = $_REQUEST['amount_usd'];
		$this->db_fields['conversion_rate'] = $_REQUEST['conversion_rate'];
		$this->db_fields['amount'] = $_REQUEST['amount_inr'];
		$this->db_fields['expected_payment_date'] = $_REQUEST['expected_payment_date_alt'];
		$this->db_fields['remarks'] = $_REQUEST['remark'];	
		$this->db_fields['project_id'] = $_REQUEST['project'];	
	}
	
	function download_send_headers($filename) {
    
	header("Content-type: text/csv");
    header("Content-Disposition: attachment;filename={$filename}");
	header("Pragma: no-cache");
	header("Expires: 0");
    
	}
	
	function array2csv(array &$array)
	{
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   //fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
	}
} 
?>
