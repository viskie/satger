<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
$path = PATH;
//print_r($_REQUEST); 
?>
<script>
function changeURL()
{	
	var PATH="<?=$path ?>"
	//alert("in changeurl");
	var from_date=$( "#account_from_date_alt" ).val();
	//alert(from_date);
	var end_date=$( "#account_to_date_alt" ).val();
	var payment_type=$( "#account_payment_type" ).val();
	var category_id=$( "#account_category" ).val();
	
	$('#url_csv').html('<a href="'+PATH+'/download_csv.php?start_date='+from_date+'&end_date='+end_date+'&payment_type='+payment_type+'&category_id='+category_id+'">CSV</a>');
	
	$('#url_pdf').html('<a href="'+PATH+'/download_category_overview.php?start_date='+from_date+'&end_date='+end_date+'&payment_type='+payment_type+'&category_id='+category_id+'">PDF</a>');
}
function exportClickHandler(){
	$('.export_hidden_div').slideToggle();
	return false;
}
$(document).ready(function(e) {
	//$("#account_category").multiselect();
	$( "#account_from_date" ).datepicker({
	
		dateFormat: "d-M-yy",
		altField: "#account_from_date_alt",
		altFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		onClose: function( selectedDate ) {
					$( "#account_to_date" ).datepicker( "option", "minDate", selectedDate );
					
					changeURL();
				}
	});
	
	$( "#account_to_date" ).datepicker({
		dateFormat: "d-M-yy",
		altField: "#account_to_date_alt",
		altFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		onClose: function( selectedDate ) {
						$( "#account_from_date" ).datepicker( "option", "maxDate", selectedDate );
						
						changeURL();
					}
	});
	 $("#account_payment_type").change(function(){
		if($(this).val()=="Expense"){
			$("#account_category #opt_grp_income").attr('disabled','disabled');
			$("#account_category #opt_grp_expense").removeAttr('disabled');
		}else if($(this).val()=="Income"){
			$("#account_category #opt_grp_expense").attr('disabled','disabled');
			$("#account_category #opt_grp_income").removeAttr('disabled');
		}else{
			$("#account_category #opt_grp_expense,#account_category #opt_grp_income").removeAttr('disabled');
		}
	 });
		 
	<?	if(isset($start_date)){?>
			$("#account_from_date").datepicker('setDate', parseISO8601(<?= "\"".$start_date."\""?>));
	<?	} ?>
	
	<?	if(isset($end_date)){?>
			$("#account_to_date").datepicker('setDate', parseISO8601(<?= "\"".$end_date."\""?>));
	<?	} ?>
	
	<?	if(isset($payment_type)){?>
			$("#account_payment_type").find("option[value='"+<?= "'".$payment_type."'"?>+"']").attr("selected","selected");
	<?	} ?>
	
	<?	if(isset($category_id)){?>
			$("#account_category").find("option[value='"+<?= "'".$category_id."'"?>+"']").attr("selected","selected");
	<?	} ?>
	$("#account_payment_type").change();
	$("#account_category").change();
	 //$('select').uniform();
});
</script>
					<!-- Content -->
					<div id="content" class="clearfix">
                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                      
                      <?	
					   $date = new DateTime();
						$date->sub(new DateInterval('P30D'));
				
				
					   if(!isset($_REQUEST['start_date']))
					   {
						   $_REQUEST['start_date']=$date->format('Y-m-d');
					   }
					   if(!isset($_REQUEST['end_date']))
					   {
						   $_REQUEST['end_date']=date('Y-m-d');
					   }
					   
					   if(!isset($_REQUEST['payment_type']))
					   {
						   $_REQUEST['payment_type']='*';
					   }
					   
					   if(!isset($_REQUEST['category_id']))
					   {
							$_REQUEST['category_id']='0';
					   }else{
					   		$category_id=implode(',',$_REQUEST['category_id']);
							//$category_id = "(".$category_id.")";
					   }
					   $query_string = "?start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&payment_type=".$_REQUEST['payment_type']."&category_id=".$category_id;
					   ?> 
                       
                       <? 
                        $url_csv=PATH."/download_csv.php";
						$url_csv = $url_csv.$query_string;
						
						$url_pdf=PATH."/download_category_overview.php";
						$url_pdf = $url_pdf.$query_string;
						
						?>
                       
                      
                        <!-- Main Content -->
                        <div id="main-content">
                            <!-- All Users -->
                            <h2>Category Overview(<?=count($allPayments)?>)</h2>
                            
                            <div class="body-con">
                            <div style="margin-bottom: 2%;" class="cat_filter">
                                <label class="up-align" style="max-width:20px;">From</label>
                                <input type="text" id="account_from_date" style="max-width:120px;" />
                                <input type="hidden" id="account_from_date_alt" name="start_date" />
                                <label class="up-align" style="max-width:20px;">To</label>
                                <input type="text" id="account_to_date" style="max-width:120px;" />
                                <input type="hidden" id="account_to_date_alt" name="end_date" />
                                <label class="up-align" style="max-width:100px">Payment type</label>
                                <select id="account_payment_type" name="payment_type" class="less_width" onchange="changeURL()">
                                    <option value="*">All</option>
                                    <option value="Income">Income</option>
                                    <option value="Expense">Expense</option>
                                </select>
                                <label class="up-align" style="max-width:80px">Category</label>
                                <select id="account_category" name="category_id[]" onchange="changeURL()" class="less_width" multiple="multiple">
                                    <option value="0">All</option>
                                    <optgroup label="Income" id="opt_grp_income">
                                    <?
                                        foreach($income_categories as $income){
                                            echo "<option value='".$income['pc_id']."'>".$income['name']."</option>";
                                        }
                                    ?>
                                    </optgroup>
                                    <optgroup label="Expense" id="opt_grp_expense">
                                    <?
                                        foreach($expense_categories as $expense){
                                            echo "<option value='".$expense['pc_id']."'>".$expense['name']."</option>";
                                        }
                                    ?>
                                    </optgroup>
                                </select>
                                <input type="hidden" name="is_post_back" id="is_post_back" value="FALSE" />
                                <input type="submit" name='report_submit' value="Submit" id="report_submit" onclick="$('#is_post_back').val('TRUE');callPage('accounts','category_overview');" />
                                <span style="position:relative;">
                                    <button class="blue" onclick="return exportClickHandler();">Export</button>
                                    <div class="export_hidden_div">
                                        <!--<div id="url_csv"><a href="<?=$url_csv?>">CSV</a></div>-->
                                        <div id="url_pdf"><a href="<?=$url_pdf?>">PDF</a></div>
                                    </div>
                                </span><br />
                            </div>
                            
                            <!-- Income table --> 
                            <!--<span style="font-size: 15px;font-weight: bold;">Payment Type - Income</span>-->
                            <div style="float: left;width: 47%;margin: 0 0 0 1%;">
                            <h3>Income</h3>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" aria-describedby="example_info" style="">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th class="amount_col">Aggregate Amt.(INR)</th>
                                        <th class="amount_col">Aggregate Amt.(USD)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
								   		//$pre_date='';
										$total=0;
										$total1=0;
										
									   foreach($allPayments as $payment)
									   {
										 	if($payment['payment_type'] == "Income"){
										   ?>
                                           		<td class="tleft"><?=$payment['category_name']?></td>
                                                <td class="tright">
                                                <?php if($payment['aggr_sum']=='0')
														{ echo "NA";
														}else{
															echo $payment['aggr_sum'];	
															$total+=floatval($payment['aggr_sum']);
														}
												?>
                                                </td>
                                                <td class="tright">
                                                <?php if($payment['aggr_sum_usd']=='0')
														{ echo "NA";
														}else{
															echo $payment['aggr_sum_usd'];
															$total1+=floatval($payment['aggr_sum_usd']);
														}
												?>
                                                </td>
                                           	</tr>
										   <?
										   //$pre_date=$cur_date;
											}
									   }
									  ?>
                                      <tr>
                                      		<td style="text-align:right"><b>Total</b></td>
                                            <td class="amount_col"><b><?=number_format($total,2)?></b></td>
                                            <td class="amount_col"><b><?=number_format($total1,2)?></b></td>
                                      </tr>	
                                </tbody>
                            </table>
                            <!-- END Income table -->                           
                          	</div>
                            
                            <!-- Expense table -->                           
                            <!--<span style="font-size: 15px;font-weight: bold;">Payment Type - Expense</span>-->
                            <div style="margin: 0 0 0 52%;width: 47%;position: relative;">
                             <h3>Expense</h3>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" aria-describedby="example_info" style="">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th class="amount_col">Aggregate Amt.(INR)</th>
                                        <th class="amount_col">Aggregate Amt.(USD)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
								   		//$pre_date='';
										$total=0;
										$total1=0;
									   foreach($allPayments as $payment)
									   {
										 	if($payment['payment_type'] == "Expense"){
										   ?>                                           		
                                          
												<td class="tleft"><?=$payment['category_name']?></td>
                                                <td class="tright">
                                                <?php if($payment['aggr_sum']=='0')
														{ echo "NA";
														}else{
															echo $payment['aggr_sum'];	
															$total+=floatval($payment['aggr_sum']);
														}
												?>
                                                </td>
                                                <td class="tright">
                                                <?php if($payment['aggr_sum_usd']=='0')
														{ echo "NA";
														}else{
															echo $payment['aggr_sum_usd'];
															$total1+=floatval($payment['aggr_sum_usd']);
														}
												?>
                                                </td>
                                           	</tr>
										   <?
										   //$pre_date=$cur_date;
											}
									   }
									  ?>
                                      <tr>
                                      		<td style="text-align:right"><b>Total</b></td>
                                            <td class="amount_col"><b><?=number_format($total,2)?></b></td>
                                            <td class="amount_col"><b><?=number_format($total1,2)?></b></td>
                                      </tr>	
                                </tbody>
                            </table>
                            </div>
                            </div>
                            
                        </div>
                        <!-- END Main Content -->
					</div>
					<!-- END Content -->