<?
	require_once('library/accountsManager.php');
	$accountsObject= new accountsManager();
	
	require_once('library/settingManager.php');
	$settingObject= new settingManager();
	
	$selected_day = $settingObject->getDefaultFinancialMonth();
	
	//echo $selected_day;exit;
	
	if(isset($_REQUEST['year']))
	{
		$year = $_REQUEST['year'];
		$data['year'] = $year;
		
		//$data['selected_day'] = $settingObject->getDefaultFinancialMonth();
		
		for($i=1;$i<=12;$i++)
		{
			$data['income_statistics'][$i] = $accountsObject->getTotalAmountOfIncome($year,$i,$selected_day);
			$data['expense_statistics'][$i] = $accountsObject->getTotalAmountOfExpense($year,$i,$selected_day);
			$data['income_expense_statistics'][$i] = $accountsObject->getTotalAmountOfIncomeAndExpense($year,$i,$selected_day);
		}
		//print_r($data);
		return $data['income_statistics'];
	}
	else
	{
		$curYear = date('Y');
		$data['year'] = $curYear;
		for($i=1;$i<=12;$i++)
		{
			$data['income_statistics'][$i] = $accountsObject->getTotalAmountOfIncome($curYear,$i,$selected_day);
			$data['expense_statistics'][$i] = $accountsObject->getTotalAmountOfExpense($curYear,$i,$selected_day);
			$data['income_expense_statistics'][$i] = $accountsObject->getTotalAmountOfIncomeAndExpense($curYear,$i,$selected_day);
		}
		return $data; 	
	}
	//print_r($_REQUEST);
	$page = "manage_dashboard.php";
	
?>