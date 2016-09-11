<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
extract($data);
//var_dump($rec_counts['trash']);exit;
?>

					<!-- Content -->
					<div id="content" class="clearfix">
                    <input type="hidden" name="edit_id" value="" id="edit_id" />
					<input type="hidden" name="show_status" id="show_status" value="<?php if((isset($current_show) && $current_show == 0) ) echo '0';
                                                                                          elseif(($current_show == 1) || !isset($current_show)) echo '1';
                                                                                          elseif($current_show == 2) echo '2';
                                                                                    ?>" />
                      <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                        <!-- Main Content -->
                        <div id="main-content">
						
                            
                            <h2>Expected Expense (<?=count($allExpectedExpense)?>)</h2>
                            
                            <a href="javascript:callPage('accounts','show_add_expected_expense');" class="wout_dtable_links">Add Expected Expense</a>
                            <div class="show_links wout_dbtbl_showlink">
                               	<a href="javascript:show_records(0,'accounts','view_expected_expenses');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                 <a href="javascript:show_records(1,'accounts','view_expected_expenses');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'accounts','view_expected_expenses');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            <div class="body-con">    
                            <!-- Users table -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="date_col">Expected Payment Date</th>
                                        <th>Category</th>
                                        <th>Employee</th>
                                        <th>Remarks</th>
                                        <th class="amount_col">Amount <br /> USD</th>
                                        <th class="amount_col">Amount <br /> INR</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
								   		$total=0;
										for($i=0;$i<count($allExpectedExpense);$i++)
									   {//if($value['is_active'] == 1){
										   ?>
										    <tr>
												<td class="backcolor" class="date_col"><?=formatDate($allExpectedExpense[$i]['expected_payment_date'])?></td>
												<td><?=$allExpectedExpense[$i]['category_name']?></td>
                                                <td><?=$allExpectedExpense[$i]['employee_name']?></td>
                                                <td><?=stripslashes($allExpectedExpense[$i]['remarks']) ?></td>
                                                <td class="amount_col"><?=($allExpectedExpense[$i]['amount_usd']=='0')?"NA":number_format($allExpectedExpense[$i]['amount_usd'],2) ?></td>
												<td class="amount_col"><?
                                                	if($allExpectedExpense[$i]['amount']=='0'){
															echo "NA";
														}else{
															$total+=floatval($allExpectedExpense[$i]['amount']);
															echo number_format($allExpectedExpense[$i]['amount'],2);
														}
                                                ?></td>
                                                <td>
												<?php if($allExpectedExpense[$i]['is_active'] != 0) {?>
                                                <a href="javascript:openEditExpectedExpense(<?php echo $allExpectedExpense[$i]['expected_expense_id']; ?>,'accounts','edit_expected_expense')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:openDeleteExpectedExpense(<?php echo $allExpectedExpense[$i]['expected_expense_id']; ?>,'accounts','delete_expected_expense')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allExpectedExpense[$i]['expected_expense_id']; ?>,'accounts','restore_expected_expense')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
                                                <?php } ?>
                                                </td>   
                                                
											</tr>								   
										   <?
										   //}
									   }
									  ?>	
                                     <tr>
                                      		<td colspan="5" style="text-align:right"><b>Total</b></td>
                                            <?
                                            if(strstr ( $total, '.' )=='')
                                                {
                                                    $total= $total.".00";
                                                }
												?>
                                            <td class="amount_col"><b><?=number_format($total,2)?></b></td>
                                            <td></td>
                                      </tr>	
                                </tbody>
                            </table>
                           </div>
                            
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->