<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
?>
<input type="hidden" name="edit_id" value="" id="edit_id" />

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
                            <h3>Add Function</h3>
                            <div class="body-con">
                    				<label for="page_id">Page</label><span style="color:red"> *</span>
                                    <?php
									if($is_exist || $is_edit){
										createComboBox('page_id','page_id','module_name', $data['AllPages'],true,$data['functionDetails']['page_id']);
									}else{
										createComboBox('page_id','page_id','module_name', $data['AllPages'],true);
									}
									 ?>
                    				
                                     <label for="function_name">Function Name</label><span style="color:red"> *</span>
                                     <input type="text" id="function_name" name="function_name" value="<? if($is_exist || $is_edit) { echo $data['functionDetails']['function_name']; } ?>"/>
                                    
                                     <label for="friendly_name">Function Friendly Name</label><span style="color:red"> *</span>
                                     <input type="text" id="friendly_name" name="friendly_name" value="<? if($is_exist || $is_edit) { echo $data['functionDetails']['friendly_name']; } ?>"/>
                                    
                                     <label for="menu_order">Menu Order</label><span style="color:red"> *</span>
                                     <input type="text" id="menu_order" name="menu_order" value="<?php if($is_exist || $is_edit) { echo $data['functionDetails']['menu_order']; } ?>"/>
                                    
                                    <?php if($is_edit){?>
                                    	<input type="button" value="Submit" class="green_button"  onclick="javascript:updateFunction('<?=$data['functionDetails']['function_id'] ?>','settings','edit_function_entry')" />
                                    <? }else{ ?>
                                    	<input type="button" value="Insert" class="green_button" onClick="addFunction('settings','add_function')" />
                                    <? }?>
                                    </p>
                            </div>
                            <!-- END Function Box -->
                            
                       

                        </div>
                        <!-- END Sidebar -->

                        <!-- Main Content -->
                        <div id="main-content-right">
							<div class="show_links">
                                <a href="javascript:show_records(0,'settings','view_function');" <?php  if((isset($current_show) && $current_show == 0)) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'settings','view_function');" <?php if($current_show == 1 || !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'settings','view_function');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            <!-- All Function -->
                            <h2>All Functions (<?=sizeof($data['allFunctions'])?>)</h2>
                            
                            
                            <div class="body-con">   
                            <!-- Function table -->
                            <?php //echo "<pre>"; print_r($data['allFunctions']); ?>
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>#</th>
                                        <th>Function Friendly Name</th>
                                        <th>Function Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?	$i = 0;
									   foreach($data['allFunctions'] as $value)
									   {		
									   		$i++;
										   ?>
										    <tr>
                                            	<td><?php echo $i; ?></td>
												<td class="backcolor"><?=$value['friendly_name']; ?></td>
                                                <td class="backcolor"><?=$value['function_name']; ?></td>												
												<td>
                                                	<?php if($value['is_active'] != 0) {?>
                                                	<a href="javascript:openEditFunction('<?=$value['function_id']?>','settings','edit_function')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
														  	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteFunction('<?=$value['function_id']?>','<?=$value['function_name']?>','settings','delete_function')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                    <?php } else {?>
                                                    	 &nbsp;&nbsp;&nbsp;
                               							 <a href="javascript:restoreEntry(<?php echo $value['function_id']; ?>,'settings','restore_function')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                    <?php } ?>
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