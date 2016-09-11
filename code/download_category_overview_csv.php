<?php

include('library/commonObject.php');

require_once('library/accountsManager.php');

$accountsObject= new accountsManager();



function formatDate($date)

{

	if($date=="0000-00-00"){

		return "-";

	}else{

		return date("d-M-Y", strtotime($date));

	}



}



	$date = new DateTime();

	$date->sub(new DateInterval('P30D'));

	

	$start_date=$date->format('Y-m-d');

	$end_date=date('Y-m-d');

	$payment_type='*';

	$category_id='0';

	//var_dump($_REQUEST);exit;

	

	$data['allPayments'] = $accountsObject->getAllPayments($_REQUEST['start_date'],$_REQUEST['end_date'],$_REQUEST['payment_type'],$_REQUEST['category_id']);

	//var_dump($data['allPayments']);exit;

	

			$timestamp = date('Ymd-His'); 

			

			$csv_array = array();

			//$fp = fopen("C:/wamp/www/satger/accounts_csv/accounts-{$timestamp}.csv", 'w');

			

									

			array_push($csv_array, array('Code','Date','Category','Details', 'Payment Type','Amount(USD)','Amount(INR)'));

			

			$total=0;

			$total1=0;

			foreach ($data['allPayments'] as $fields) {

				

				if($fields['payment_type']=="Expense")

				{$total-=floatval($fields['amount']);

				 $total1-=floatval($fields['amount_usd']);

				 $fields['amount'] = "-".$fields['amount'];

				 $fields['amount_usd'] = "-".$fields['amount_usd'];

				}

				else

				{$total+=floatval($fields['amount']);

				 $total1+=floatval($fields['amount_usd']);

				}

				

				 if($fields['category_name']=='Project')

				 {

				  $fields['remarks']=$fields['project_name'].' - '.$fields['remarks'] ;

				 }

				 else if($fields['category_name']=='Employee')

				 {$fields['remarks']=$fields['employee_name'].' - '.$fields['remarks'];

				 }

				 else

				 {$fields['remarks']=$fields['remarks']; 

				 }

			 

			 	$fields['payment_date']=formatDate($fields['payment_date']);

			  

			  array_push($csv_array, array($fields['code'],$fields['payment_date'],$fields['category_name'],$fields['remarks'],$fields['payment_type'],number_format($fields['amount_usd'],2),number_format($fields['amount'],2)));

				}

				

				array_push($csv_array, array('','','','', 'Total',number_format($total1,2),number_format($total,2)));



				$csv_content = $accountsObject->array2csv($csv_array);

				header('Content-disposition: inline;filename=accounts-'.$timestamp.'.csv');

				header('Content-Type: text/csv;charset=UTF-8');

				echo $csv_content;

?>