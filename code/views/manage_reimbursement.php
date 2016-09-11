<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data['allExpectedExpense']); exit;
?>
<input type="hidden" name="edit_id" value="" id="edit_id" />
					<!-- Content -->
					<div id="content" class="clearfix">

                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                        <!-- Main Content -->
                        <div id="main-content">
						<h2>Reimbursements (<?=sizeof($data['allReimbursements'])?>)</h2>
                        	<div class="body-con">
                            <!-- Users table -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="date_col">Paid Date</th>
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
									   foreach($data['allReimbursements'] as $value)
									   {
										   //if($value['is_active'] == 1){
										   ?>
										    <tr>
												<td class="backcolor" class="date_col"><?=formatDate($value['paid_date'])?></td>
												<td><?=$value['category_name']?></td>
                                                <td><?=$value['employee_name']?></td>
                                                <td><?=stripslashes($value['remarks']) ?></td>
												<td class="amount_col"><?=($value['amount_usd']=='0')?"NA":number_format($value['amount_usd'],2) ?></td>
												<td class="amount_col"><?
                                                	if($value['amount']=='0'){
															echo "NA";
														}else{
															$total+=floatval($value['amount']);
															echo number_format($value['amount'],2);
														}
                                                ?></td>
												<td nowrap="nowrap">
                                                <a href="javascript:openPaidReimbursement('<?=$value['reimbursement_id']?>','hrm','paid_reimbursement')" class="tiptip-top" title="Mark as Paid"><img src="img/ok.png" alt="edit" /></a>
                                                &nbsp;&nbsp;&nbsp;<a href="javascript:openEditReimbursement('<?=$value['reimbursement_id']?>','hrm','edit_reimbursement')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                                &nbsp;&nbsp;&nbsp;<a href="javascript:openDeleteReimbursement('<?=$value['reimbursement_id']?>','hrm','delete_reimbursement')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>  
												</td>
											</tr>								   
										   <?
										   //}
									   }
									  ?>	
                                     <tr>
                                      		<td colspan="5" style="text-align:right"><b>Total</b></td>
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