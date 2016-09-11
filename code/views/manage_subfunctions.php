<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
extract($data);
?>
<input type="hidden" name="edit_id" value="<?php if(isset($arr_edit) && (isset($arr_edit['function_id']))){ echo  $arr_edit['function_id']; }?>" id="edit_id" />

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
                            <h3>Add Sub-function</h3>
                            <div class="body-con">
                            	<div>
                                	<div><label for="page_id">Page</label><span style="color:red"> *</span></div>
                                    <div >
                                    	<select name="page_id" id="page_id" onchange="change_selfunction(this.value)">
                                        	<option value="0">Please Select</option>
                                            <?php
											foreach($data['AllPages'] as $k=>$v)
											{
												$selected = '';
												if(isset($arr_edit) && ($arr_edit['page_id'] == $v['page_id']))
													$selected = 'selected="selected"';
											?>
                                            <option value="<?php echo $v['page_id']; ?>" <?php echo $selected; ?>><?php echo $v['module_name']; ?></option>
                                            <?php 	
											}
											?>
                                        </select>										
                                     </div>
                                </div>
                            	<div>
                                	<div><label for="func_id">Main Function</label><span style="color:red"> *</span></div>
                                    <div id="function_drpdwn">
                                    	<?php //echo $arr_edit['main_function_id'];
										if(isset($arr_edit) && (isset($arr_edit['main_function_id']))){
											createComboBox('main_function_id','function_id','friendly_name', $data['AllMainFunctions'],true,$arr_edit['main_function_id']);
										}else{
											createComboBox('main_function_id','function_id','friendly_name', $data['AllMainFunctions'],true);
										}
										 ?>   
                                    </div>
                                    <div>
                                    	<div><label for="function_name">Sub-function Name</label><span style="color:red"> *</span></div>
                                        <div>
                                        	<input type="text" id="function_name" name="function_name" value="<?php if(isset($arr_edit)) { echo $arr_edit['function_name']; } ?>"/>
                                        </div>
                                    </div>
                                    <div>
                                    	<div><label for="friendly_name">Sub-function Friendly Name</label><span style="color:red"> *</span></div>
                                        <div>
           		                             <input type="text" id="friendly_name" name="friendly_name" value="<?php if(isset($arr_edit)) { echo $arr_edit['friendly_name']; } ?>"/>
                                        </div>
                                    </div>                                    
                                    <div>
                                    	<div><label for="menu_order">Menu Order</label><span style="color:red"> *</span></div>
                                     	<div><input type="text" id="menu_order" name="menu_order" value="<?php if(isset($arr_edit)) { echo $arr_edit['menu_order']; } ?>"/></div>
                                    </div>
                                    <div>
                                    	 <label for="function_name">Is CRUD</label>
                                         <input type="radio" name="chkcrud" id="chkcrud" value="1" <?php if((isset($arr_edit['is_crud']) && ($arr_edit['is_crud'] == 1)) || !(isset($arr_edit))) { echo 'checked="checked"'; } ?>  />Yes
                                    	<input type="radio" name="chkcrud" id="chkcrud" value="0"  <?php if(isset($arr_edit['is_crud']) && ($arr_edit['is_crud'] == 0)) { echo 'checked="checked"'; } ?>/>No
                                    </div> 
                                    <div>
                                    	 <input type="button" value="Submit" class="green_button"  onclick="javascript:save_subfunction('settings','save_subfunction')" />
                                    </div>
                                </div>
                            </div>
                            <!-- END Function Box -->
                          </div>
                       	
                        <!-- END Sidebar -->

                        <!-- Main Content -->
                        <div id="main-content-right">
							<div class="show_links">
                                <a href="javascript:show_records(0,'settings','manage_subfunction');" <?php  if((isset($current_show) && $current_show == 0)) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'settings','manage_subfunction');" <?php if($current_show == 1 || !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'settings','manage_subfunction');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            <!-- All Function -->
                            <h2>All Sub-functions (<?=sizeof($data['allFunctions'])?>)</h2>
                            
                            
                            <div class="body-con">   
                            <!-- Function table --> 
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
                                   <? $i=0;
									   foreach($data['allFunctions'] as $value)
									   {	$i++;
										   ?>
										    <tr>
                                            	<td><?php echo $i; ?></td>
												<td class="backcolor"><?php echo $value['friendly_name']; ?></td>
                                                <td class="backcolor"><?php echo $value['function_name']; ?></td>												
												<td>
                                                	<?php if($value['is_active'] != 0) {?>
                                                	<a href="javascript:openEditFunction('<?=$value['function_id']?>','settings','edit_subfunction')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
														  	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteFunction('<?=$value['function_id']?>','<?=$value['function_name']?>','settings','delete_subfunction')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                    <?php } else {?>
                                                    	 &nbsp;&nbsp;&nbsp;
                               							 <a href="javascript:restoreEntry(<?php echo $value['function_id']; ?>,'settings','restore_subfunction')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
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
<script language="javascript" type="text/javascript">
function change_selfunction(selpage)
{
	$.ajax({
			url:"ajax.php",
			type:"POST",
			data:"page=settings&function=get_functions&page_id="+selpage,
			success:function(resp){
				
				$("#function_drpdwn").html(resp);
				$("#function_drpdwn select").uniform();
			}
		});
}
</script>