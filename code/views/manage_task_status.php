<?
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
                        <input type="hidden" name="show_status" id="show_status" value="<?php if((isset($show_status) && $show_status == 0) ) echo '0';
                                                                                          elseif(($show_status == 1) || !isset($show_status)) echo '1';
                                                                                          elseif($show_status == 2) echo '2';
                                                                                    ?>" />
                        
						<input type="hidden" name="task_status_id" id="task_status_id" value="<?php if(isset($data['task_status_Details']['task_status_id'])) echo $data['task_status_Details']['task_status_id']?>" />
                        <!-- Sidebar -->
                        <div id="side-content-left">   
							 <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                            
                            <!-- Add Task Status Box -->
                            <h3><? if(isset($data['task_status_Details'])) { echo "Edit Task Status";} else{ echo "Add Task Status"; }?></h3>
                            <div class="body-con">                    
                                    <label for="sf-username">Task Status Name<span> *</span></label>
                                    <input type="text" id="task_status_name" name="task_status_name" value='<?php if(isset($data['task_status_Details']['task_status_id']) || $is_exist == true) echo $data['task_status_Details']['task_status_name'] ?>' />
                                    <?php
									if($is_edit == true || (isset($data['task_status_Details']) && !($is_exist == true))) 
									{
									?>
                                     <input type="button" value="Update" class="green_button"  onclick="javascript:updateTaskStatus('<?php echo $data['task_status_Details']['task_status_id']?>','settings','edit_task_status_entry')"> 
                                    <?php 
									}
									else
									{
									?>
                                    <input type="button" value="Insert" class="green_button" onClick="addTaskStatus('settings','add_task_status')">
                                    <?php } ?>
                                   
                            </div>
                            <!-- END Add user Box -->
                            
                       </div>
                        <!-- END Sidebar -->

                        <!-- Main Content -->
                       <div id="main-content-right">
							<!-- All Users -->
                            <h2>All Task Status (<?=count($allTaskStatus)?>)</h2>
                            
                            <div class="show_links">
                               	<a href="javascript:show_records(0,'settings','view_task_status');" <?php if((isset($show_status) && $show_status == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                 <a href="javascript:show_records(1,'settings','view_task_status');" <?php if(($show_status == 1)|| !isset($show_status)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'settings','view_task_status');" <?php if($show_status == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            
                            <div class="body-con">       
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th>Task Status Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?	for($i=0;$i<count($allTaskStatus);$i++)
									   {
									   	
										   ?>
										    <tr>
                                            	<td class="backcolor"><?=$i+1 ?></td>
												<td ><?=$allTaskStatus[$i]['task_status_name']; ?></td>
                                                <td>
												<?php if($allTaskStatus[$i]['is_active'] != 0) {?>
                                                <a href="javascript:openEditTaskStatus(<?php echo $allTaskStatus[$i]['task_status_id']; ?>,'settings','edit_task_status')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:deleteTaskStatus(<?php echo $allTaskStatus[$i]['task_status_id']; ?>,'<?php echo $allTaskStatus[$i]['task_status_name']; ?>','settings','delete_task_status')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allTaskStatus[$i]['task_status_id']; ?>,'settings','restore_task_status')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
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
