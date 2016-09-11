<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
extract($data);
?>

					<!-- Content -->
					<div id="content" class="clearfix">
						<input type="hidden" name="edit_id" value="" id="edit_id" />
                        <input type="hidden" name="show_status" id="show_status" value="<?php if((isset($current_show) && $current_show == 0) ) echo '0';
                                                                                          elseif(($current_show == 1) || !isset($current_show)) echo '1';
                                                                                          elseif($current_show == 2) echo '2';
                                                                                    ?>" />
						<input type="hidden" name="payment_category_id" id="payment_category_id" value="<?php if(isset($data['payment_category_details']['pc_id'])) echo $data['payment_category_details']['pc_id']?>" />
                        <!-- Sidebar -->
                        <div id="side-content-left">   
                     		<?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                            
                            <!-- Add user Box -->
                            <h3><? if(isset($data['payment_category_details'])){ echo "Edit Payment Category"; }else { echo "Add Payment Category" ;}?></h3>
                            
                            <div class="body-con">
                    
                                    <label for="sf-username">Payment Category Name</label>
                                    <input type="text" id="payment_category_name" name="payment_category_name" value="<? if(isset($data['payment_category_details']))
																														 	echo $data['payment_category_details']['name'];
																													?>"/>
                                    <label for="sf-pc-type">Payment Category Type</label>
                                    <? 
										$selected = " selected = 'selected' ";
									?>
                                    <select id="payment_category_type" name="payment_category_type" style="opacity: 0;">
                                    	<option value="1" <?php if( ($is_exist == true && ($data['payment_category_details']['type'] == "1")) || (isset($data['payment_category_details']) && ($data['payment_category_details']['type'] == "Income")))
																		echo $selected;   ?>>Income</option>
            	                        <option value="2" <?php if(($is_exist == true && ($data['payment_category_details']['type'] == "2")) || (isset($data['payment_category_details']) && ($data['payment_category_details']['type'] == "Expense"))) echo $selected;  ?>>Expense</option>   
                                    </select>
                                    <?php
									 if(isset($data['payment_category_details']))
									 {
									  ?>
                                      <input type="button" value="Update" class="green_button"  onclick="javascript:updatePaymentCategory('settings','edit_payment_category_entry')" /> 
                                      <?php 
									 }
									 else
									 {
									?>
                                    <input type="button" value="Insert" class="green_button" onClick="addPaymentCategory('settings','add_payment_category')" />
                                    <?php } ?>
                            </div>
                            <!-- END Add user Box -->
                            
                       

                        </div>
                        <!-- END Sidebar -->

                        <!-- Main Content -->
                        <div id="main-content-right">
                            <!-- All Users -->
                            <h2>All Payment Categories (<?=count($allPaymentCategories)?>)</h2>                           
                            <div class="show_links">
                               	<a href="javascript:show_records(0,'settings','view_payment_category');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                 <a href="javascript:show_records(1,'settings','view_payment_category');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'settings','view_payment_category');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            <div class="body-con">    
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr><th>Sr.No</th>
                                        <th>Payment Category Name</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?	for($i=0;$i<count($allPaymentCategories);$i++)
									   {?>
										    <tr>
                                            	<td><?=$i+1 ?></td>
												<td class="backcolor"><?=$allPaymentCategories[$i]['name']; ?></td>
                                                <td class="backcolor"><?=$allPaymentCategories[$i]['type']; ?></td>
                                                
                                                <td>
												<?php if($allPaymentCategories[$i]['is_active'] != 0) {?>
                                                <a href="javascript:openEditPaymentCategory(<?php echo $allPaymentCategories[$i]['pc_id']; ?>,'settings','edit_payment_category')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:deletePaymentCategory(<?php echo $allPaymentCategories[$i]['pc_id']; ?>,'<?php echo $allPaymentCategories[$i]['name']; ?>','settings','delete_payment_category')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allPaymentCategories[$i]['pc_id']; ?>,'settings','restore_payment_category')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
                                                <?php } ?>
                                                </td>
												
											</tr>								   
										   <?
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
