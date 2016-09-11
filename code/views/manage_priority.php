<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
?>
<input type="hidden" name="edit_id" value="<?php if(isset($arr_edit) && ($data['arr_edit']['id'] != "")) echo $data['arr_edit']['id']; ?>" id="edit_id" />

					<!-- Content -->
					<div id="content" class="clearfix">
						 <input type="hidden" name="show_status" id="show_status" value="<?php if(!isset($current_show) || ($current_show == 1 )) echo '1';
																			  elseif((isset($current_show) && $current_show == 0)) echo '0';
																			  elseif($current_show == 2) echo '2';
																		?>" />
                        <!-- Sidebar -->
                        <div id="side-content-left">   
                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                            <!-- Roles box -->
                            
                            <!-- END Roles box -->
                            
                            <!-- Add Function Box -->
                            <h3>Add Priority</h3>
                            <div class="body-con">
                    				                   				
                                 <label for="priority_value">Priority Value</label><span style="color:red"> *</span>
                                 <input type="text" id="value" name="value" value="<? if(isset($arr_edit)) { echo $data['arr_edit']['value']; } ?>"/>
                                
                                 <label for="priority_order">Order</label><span style="color:red"> *</span>
                                 <input type="text" id="priority_order" name="priority_order" value="<?php if(isset($arr_edit)) { echo $data['arr_edit']['priority_order']; } ?>"/>
                                
                                <input type="button" value="Insert" class="green_button" onClick="save_priority('settings','save_priority')" />
                                   
                                   
                            </div>
                            <!-- END Function Box -->
                            
                       

                        </div>
                        <!-- END Sidebar -->

                        <!-- Main Content -->
                        <div id="main-content-right">
							<div class="show_links">
                                <a href="javascript:show_records(0,'settings','manage_priority');" <?php  if((isset($current_show) && $current_show == 0)) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'settings','manage_priority');" <?php if($current_show == 1 || !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'settings','manage_priority');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            <!-- All Function -->
                            <h2>All Priorities (<?=sizeof($data['arr_priority'])?>)</h2>
                            
                            
                            <div class="body-con">   
                            <!-- Function table -->
                            <?php //echo "<pre>"; print_r($data['allFunctions']); ?>
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>#</th>
                                        <th>Priority Value</th>
                                        <th>Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?	$i = 0;
									   foreach($data['arr_priority'] as $value)
									   {		
									   		$i++;
										   ?>
										    <tr>
                                            	<td><?php echo $i; ?></td>
												<td class="backcolor"><?=$value['value']; ?></td>
                                                <td class="backcolor"><?=$value['priority_order']; ?></td>												
												<td>
                                                	<?php if((!in_array($value['id'],$arr_const_priority)))
													{ if($value['is_active'] != 0) {?>
                                                	<a href="javascript:openEditFunction('<?=$value['id']?>','settings','edit_priority')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
														  	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteFunction('<?=$value['id']?>','<?=$value['value']?>','settings','delete_priority')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                    <?php } else {?>
                                                    	 &nbsp;&nbsp;&nbsp;
                               							 <a href="javascript:restoreEntry(<?php echo $value['id']; ?>,'settings','restore_priority')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                    <?php } }?>
												</td>
											</tr>								   
										   <?
									   }
									  ?>	
                                </tbody>
                            </table>
                            </div>
                            <!-- END Function table -->                           
                        </div>
                        <!-- END Main Content -->
					</div>
					<!-- END Content -->