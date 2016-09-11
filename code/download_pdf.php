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
	
	$data['allPayments'] = $accountsObject->getAllPayments($_REQUEST['start_date'],$_REQUEST['end_date'],$_REQUEST['payment_type'],$_REQUEST['category_id']);
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
						<table cellpadding='0' cellspacing='0'>
						<tr>
							<th>Code</th>
							<th>Transaction Id</th>
                            <th class='date center'>Date</th>
                            <th>Category</th>
                            <th>Details</th>
                            <th>Payment Type</th>
                            <th>Amt.(USD)</th>
                            <th>Amt.(INR)</th>
                        </tr>";
						
						$total=0;
						$total1=0;
						foreach($data['allPayments'] as $fields)
						{
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
							
							$html.='<tr>';
							$html.='<td>'.$fields['code'].'</td>';
							$html.='<td>'.$fields['transaction_id'].'</td>';
							$html.='<td class="date center">'.formatDate($fields['payment_date']).'</td>';
							$html.='<td>'.$fields['category_name'].'</td>';
							$html.='<td>'.$fields['remarks'].'</td>';
							$html.='<td>'.$fields['payment_type'].'</td>';
							/*if(strstr ( $fields['amount_usd'], '.' )=='')
							{
								$fields['amount_usd']= $fields['amount_usd'].".00";
							}
							if(strstr ( $fields['amount'], '.' )=='')
							{
								$fields['amount']= $fields['amount'].".00";
							}
							if($fields['payment_type']=='Expense')
							{
								$fields['amount'] = "-".$fields['amount'];
							}*/
							$html.='<td class="right">'.number_format($fields['amount_usd'],2).'</td>';
							$html.='<td class="right">'.number_format($fields['amount'],2).'</td>';
							$html.='</tr>';
						}
						$html.='<tr><td colspan=6 style="text-align:right;font-weight:bold">Total&nbsp;&nbsp;</td><td class="right" style="font-weight:bold;">'.number_format($total1,2).'</td><td class="right" style="font-weight:bold;">'.number_format($total,2).'</td></tr>';
						$html.='</table></div>';
						$html.='</body></html>';
						
						$file_name="accounts-".$timestamp.".pdf";
						$dompdf = new DOMPDF();
						$dompdf->load_html($html);
						$dompdf->set_paper("a4", "portrait");
						$dompdf->render();
						
						/*
							Code for creating .zip
						*/
						if(isset($_REQUEST['is_zip']) && $_REQUEST['is_zip'] == TRUE){
							$files = array();	
							foreach($data['allPayments'] as $fields)
							{
								if($fields['payment_type'] == 'Income'){
									if(is_file("uploads/income_invoice/".$fields['invoice'])){
										$files[] = "uploads/income_invoice/".$fields['invoice'];		
									}
								}
								if($fields['payment_type'] == 'Expense'){
									if(is_file("uploads/expense_invoice/".$fields['invoice'])){
										$files[] = "uploads/expense_invoice/".$fields['invoice'];		
									}
								}
							}
							$output = $dompdf->output();
    						file_put_contents('uploads/Overview.pdf', $output);
							$files[] = 'uploads/Overview.pdf';
							//print_r($files); exit;
							
							$zipname = 'invoice '.$_REQUEST['start_date'].' to '.$_REQUEST['end_date'].'.zip';
							$zip = new ZipArchive;		
							$zip->open($zipname, ZipArchive::OVERWRITE);
							
							foreach ($files as $file) {
								$new_filename = substr($file,strpos($file,"/")+1);
								$zip->addFile($file,$new_filename);
							}
							$zip->close();
							header('Content-Type: application/zip');
							header("Content-Disposition: attachment; filename='".$zipname."'");
							header("Pragma: no-cache"); 
							header("Expires: 0");
							header('Cache-Control: must-revalidate');
							header('Content-Length: ' . filesize($zipname));
							ob_clean();
  							flush();
							if(readfile($zipname)){
								unlink($zipname);
							}
							//header("Location: ".$zipname);
							//unlink($zipname);
						}else{
							$dompdf->stream($file_name, array("Attachment" => 1));
						}
						
						exit;
?>