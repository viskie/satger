<?

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)

{

	header("location: index.php");

	exit();

}

//echo "<pre>"; print_r($data);

?>

<input type="hidden" name="edit_id" value="" id="edit_id" />

<input type="hidden" name="show_status" id="show_status" value="" />

					<!-- Content -->

					<div id="content" class="clearfix">



                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>

                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  

                      <? }  else  if($notificationArray['type'] == "Failed") { ?>

                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>

                      <?   } } ?>

                        <!-- Main Content -->

                        <div id="main-content">

						

                            <!-- All Users -->

                            <h2>Expense (<?=sizeof($data['allExpense'])?>)</h2>

                            <div class="show_links">

                            	<a href="javascript:show_records(0, 'accounts', 'view_expenses')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts']['all']?>)</a><span> | </span>

                            	<a href="javascript:show_records(1, 'accounts', 'view_expenses')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts']['active']?>)</a><span> | </span>

                            	<a href="javascript:show_records(2, 'accounts', 'view_expenses')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts']['deleted']?>)</a>

                           	</div>

                            <a href="javascript:callPage('accounts','show_add_expense');" class="for_links">Add Expense</a>

                            

                            <div class="body-con"> 

                            <!-- Users table --> 

                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">

                                <thead>

                                    <tr>

                                    	<th>Sr.No. </th>
										<th>Transaction Id</th>
                                        <th class="date_col">Date</th>

                                        <th class="date_col">Sent Date</th>

                                        <th>Category</th>

                                        <th>Employee</th>

                                        <th>Remarks</th>
										<th>Added By</th>
                                        <th>Modified By</th>
                                        <th class="amount_col">Amount <br /> USD</th>

                                        <th class="amount_col">Amount <br /> INR</th>

                                        <th>Edit</th>

                                    </tr>

                                </thead>

                                <tbody>

                                   <?	$i=0;

									   foreach($data['allExpense'] as $value)

									   {

										   ?>

										    <tr>

                                            	<td class="backcolor"><?=$i+1 ?></td>
												<td><?=$value['transaction_id']?></td>
												<td><?=formatDate($value['payment_date'])?></td>

                                                <td class="date_col"><?=formatDate($value['payment_sent_date']) ?></td>

												<td><?=$value['category_name']?></td>

                                                <td><?=$value['employee_name']?></td>

                                                <td><?=stripslashes($value['remarks']) ?></td>
												<td class="addByDate">
													<?=stripslashes($value['addby']); ?>
                                                	 <span style="position:absolute">
                                                        <div class="added_modified_date" title="Notes" style="display: none;">
                                                            <p><?php echo formatDate($value['added_date']); ?></p>
                                                        </div>    
                                                    </span>    
                                                </td>
                                                <td class="modifiedByDate">
													<?=stripslashes($value['modby']); ?>
                                                	 <span style="position:absolute">
                                                        <div class="added_modified_date" title="Notes" style="display: none;">
                                                            <p><?php echo formatDate($value['modified_date']); ?></p>
                                                        </div>    
                                                    </span>     
                                                </td>
                                                <td class="amount_col"><?=($value['amount_usd']=='0')?"NA":number_format($value['amount_usd'],2) ?></td>

												<td class="amount_col"><?=($value['amount']=='0')?"NA":number_format($value['amount'],2) ?></td>

												<td nowrap="nowrap">

                                                 <? if($value['is_active'] != 0){?> 

                                                <a href="javascript:openEditExpense('<?=$value['payment_id']?>','accounts','edit_expense')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>

                                                &nbsp;&nbsp;&nbsp;<a href="javascript:openDeleteExpense('<?=$value['payment_id']?>','accounts','delete_expense')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a> 

                                                <? }else{

													if(isset($_REQUEST['show_status']))

														echo "<a href=\"javascript:restoreEntry('".$value['payment_id']."','accounts','restore_payment_expense')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";

													}	

												?> 
                                                <?php if($value['invoice'] != ''){ ?>
                                               	&nbsp;&nbsp;&nbsp;<a href="javascript:downloadFile('<?php echo $value['invoice']; ?>','accounts','download_expense_invoice')" class="tiptip-top" title="Download Invoice"><img src="img/arrow_down.png" alt="Download Invoice"></a>
												<?php } ?>
												</td>

											</tr>								   

										   <?

										   $i++;

									   }

									  ?>	

                                </tbody>

                            </table>

                            <!-- END Users table -->                           

                          	</div>

                            

                        </div>

                        <!-- END Main Content -->



					</div>

					<!-- END Content -->

