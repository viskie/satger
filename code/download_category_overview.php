<?php
//include pdf maker
//echo "<pre>";
//print_r($_SERVER); exit;
require_once("library/pdf_maker/dompdf/dompdf_config.inc.php");
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
	
	$data['allPayments'] = $accountsObject->getAllCategoryOverview($_REQUEST['start_date'],$_REQUEST['end_date'],$_REQUEST['payment_type'],$_REQUEST['category_id']);
	//var_dump($data['allPayments']);exit;
	
			$timestamp = date('Ymd-His'); 
			
			if($_REQUEST['payment_type']=='*')
						{
							$_REQUEST['payment_type']='Income & Expense';
						}
						
						$html='';
						$html.="<html>
									<head>
										<style>
											table{
												width:100%;
											}
											table td,table th{
												padding:5px;
												border:1px solid black;
												font-size:12px;
											}
											table .date{
												width:70px;
											}
											table .center{
												text-align:center;
											}
											table .right{
												text-align:right;
											}
										</style>
									</head>
									<body>";
						$html.='<div style="width:90%;margin:0 auto;">';
						$html.='<h2 style="text-align:center">Accounts Overview</h2>';
						$html.='<label>From:</label><b>'.formatDate($_REQUEST['start_date']).'&nbsp;&nbsp;&nbsp;</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						$html.='<label>To:</label><b>'.formatDate($_REQUEST['end_date']).'&nbsp;&nbsp;&nbsp;</b>';
						$html.="<br/><br/>
						<h4 style='text-align:'>Income</h4>
						<table cellpadding='0' cellspacing='0'>
						<tr>
							<th>Category</th>
							<th class='amount_col'>Aggregate Amt.(INR)</th>
							<th class='amount_col'>Aggregate Amt.(USD)</th>
                        </tr>";
						
						$total=0;
						$total1=0;
						foreach($data['allPayments'] as $fields)
						{
							//var_dump($fields); exit;
							if($fields['payment_type'] == "Income"){
								if($fields['aggr_sum']=='0')
								{ //echo "NA";
								}else{
									//echo $payment['aggr_sum'];	
									$total+=floatval($fields['aggr_sum']);
								}
								if($fields['aggr_sum_usd']=='0')
								{ //echo "NA";
								}else{
									//echo $payment['aggr_sum_usd'];
									$total1+=floatval($fields['aggr_sum_usd']);
								}
								$html.='<tr>';
								$html.='<td>'.$fields['category_name'].'</td>';
								$html.='<td>'.$fields['aggr_sum'].'</td>';
								$html.='<td>'.$fields['aggr_sum_usd'].'</td>';
								$html.='</tr>';
							}
						}
						$html.='<tr><td  style="text-align:right;font-weight:bold">Total&nbsp;&nbsp;</td><td class="right" style="font-weight:bold;">'.number_format($total,2).'</td><td class="right" style="font-weight:bold;">'.number_format($total1,2).'</td></tr>';
						$html.='</table>';
						
						$html.="<br/><br/>
						<h4 style='text-align:'>Expense</h4>
						<table cellpadding='0' cellspacing='0'>
						<tr>
							<th>Category</th>
							<th class='amount_col'>Aggregate Amt.(INR)</th>
							<th class='amount_col'>Aggregate Amt.(USD)</th>
                        </tr>";
						
						$total=0;
						$total1=0;
						foreach($data['allPayments'] as $fields)
						{
							if($fields['payment_type'] == "Expense"){
								if($fields['aggr_sum']=='0')
								{ //echo "NA";
								}else{
									//echo $payment['aggr_sum'];	
									$total+=floatval($fields['aggr_sum']);
								}
								if($fields['aggr_sum_usd']=='0')
								{ //echo "NA";
								}else{
									//echo $payment['aggr_sum_usd'];
									$total1+=floatval($fields['aggr_sum_usd']);
								}
								$html.='<tr>';
								$html.='<td>'.$fields['category_name'].'</td>';
								$html.='<td>'.$fields['aggr_sum'].'</td>';
								$html.='<td>'.$fields['aggr_sum_usd'].'</td>';
								$html.='</tr>';
							}
						}
						$html.='<tr><td  style="text-align:right;font-weight:bold">Total&nbsp;&nbsp;</td><td class="right" style="font-weight:bold;">'.number_format($total,2).'</td><td class="right" style="font-weight:bold;">'.number_format($total1,2).'</td></tr>';
						$html.='</table></div>';
						$html.='</body></html>';
						
						$file_name="accounts-".$timestamp.".pdf";
						$dompdf = new DOMPDF();
						$dompdf->load_html($html);
						$dompdf->set_paper("a4", "portrait");
						$dompdf->render();
						$dompdf->stream($file_name, array("Attachment" => 1));
						exit;
?>