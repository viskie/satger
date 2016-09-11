<script src="js/DateTimePicker.js"></script>
<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data['allTasks']);
extract($data);
?>
					<!-- Content -->
					<div id="content" class="clearfix">
					<input type="hidden" name="edit_id" value="" id="edit_id" />
                    <input type="hidden" name="task_function" value="<?php if(isset($data['task_function'])){ echo $data['task_function']; } ?>" id="task_function" />
        			<input type="hidden" name="show_status" id="show_status" value="<?php if((isset($show_status) && $show_status == 0)) echo '0';
																			  elseif(($show_status == 1)|| !isset($show_status)) echo '1';
																			  elseif($show_status == 2) echo '2';
																		?>" />
                       <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                        <!-- Main Content -->
                        <div id="main-content">

                            <!-- All Tasks -->
                            <h2>
                            <?php 
								if($data['task_function'] == 1) echo"All Tasks (".count($allTasks).")"; 
								else if($data['task_function'] == 2) echo"All Team Tasks (".count($allTasks).")";
							?>
                            </h2>
                            
                            <!-- div for filters -->
                            <div style="margin-bottom: 0px;">
                            <input type="hidden" name="is_post_back" id="is_post_back" value="FALSE" />
                           
                            <label style="width: 70px;">From</label><input type="text" style="max-width: 162px;position:relative;z-index:20" id="from_assign" name="from_assign" value="<?php if(isset($data['date_from'])) { echo $data['date_from']; }?>"/>
                            <label style="width: 95px;">To</label><input type="text" style="max-width: 162px;position:relative;z-index:20" id="to_assign" name="to_assign" value="<?php if(isset($data['date_to'])) { echo $data['date_to']; }?>"/>
                            
                            <label style="width: 65px;">Status</label>
                            <?php 
								if(isset($data['task_status']))
									createComboBox('task_status','task_status_id','task_status_name',$data['allTaskStatus'],TRUE,$data['task_status'],'','All','class="less_width"'); 
								else
									createComboBox('task_status','task_status_id','task_status_name',$data['allTaskStatus'],TRUE,'','','All','class="less_width"');		
							?>
                            <br/>
                            
							<?php if($_SESSION['user_main_group'] == developer_grpid) { ?>
                            <label style="width: 65px;">Manager</label>
                            <?
								if(isset($data['manager_id']))
									createComboBox('manager','employee_id','employee_name', $data['all_managers'],TRUE,$data['manager_id'],'','All','class="less_width"'); 
								else
									createComboBox('manager','employee_id','employee_name', $data['all_managers'],TRUE,'','','All','class="less_width"');	
							 }?> 
                            
							<?php if($_SESSION['user_main_group'] == developer_grpid || (isset($data['is_employee_manager']) && $data['is_employee_manager'] == 1 && $data['task_function'] == 2)) { ?>
                            <label style="width: 65px;">Employee</label>
                            <?
								if(isset($data['employee_id'])){
									createComboBox('all_employee','employee_id','employee_name', $data['allEmployees'],TRUE,$data['employee_id'],'','All','class="less_width"'); 
								}else {
                            		createComboBox('all_employee','employee_id','employee_name', $data['allEmployees'],TRUE,'','','All','class="less_width"'); 
                             } ?>
                             
							 <?php } ?>
                             
							 <?php if($data['task_function'] == 1) { ?>
                           	<input style="margin-left: 83px;" type="button" name="report_submit" value="Submit" id="report_submit" class="green_button" onclick="$('#is_post_back').val('TRUE');callPage('projects','view_task');">
                            <? }else if($data['task_function'] == 2) { ?>
                            	<input style="margin-left: 83px;" type="button" name="report_submit" value="Submit" id="report_submit" class="green_button" onclick="$('#is_post_back').val('TRUE');callPage('projects','view_team_task');">
                            <? } ?>
                            </div>
                             
							
                            <div style="position:relative">
                                <div class="show_links" style="top:13px;">
                                	<?php if($data['task_function'] == 1) {?>
                                    <a href="javascript:show_records(0,'projects','view_task');" <?php if((isset($show_status) && $show_status == 0) ) echo 'class="show_active"';?> >All(<?php echo $rec_counts['all']; ?>)</a>|
                                    <a href="javascript:show_records(1,'projects','view_task');" <?php if(($show_status == 1)|| !isset($show_status)) echo 'class="show_active"';?>>Active(<?php echo $rec_counts['active']; ?>)</a>|
                                    <a href="javascript:show_records(2,'projects','view_task');" <?php if($show_status == 2) echo 'class="show_active"';?>>Deleted(<?php echo $rec_counts['trash']; ?>)</a>
                                	<? } ?>
                                    
                                    <?php if($data['task_function'] == 2) {?>
                                    <a href="javascript:show_records(0,'projects','view_team_task');" <?php if((isset($show_status) && $show_status == 0) ) echo 'class="show_active"';?> >All(<?php echo $rec_counts['all']; ?>)</a>|
                                    <a href="javascript:show_records(1,'projects','view_team_task');" <?php if(($show_status == 1)|| !isset($show_status)) echo 'class="show_active"';?>>Active(<?php echo $rec_counts['active']; ?>)</a>|
                                    <a href="javascript:show_records(2,'projects','view_team_task');" <?php if($show_status == 2) echo 'class="show_active"';?>>Deleted(<?php echo $rec_counts['trash']; ?>)</a>
                                	<? } ?>
                                    
                                </div>
                                
                                <a href="javascript:callPage('projects','show_add_task');" class="for_links" style="top:12px;">Add Task</a>
                           </div>
                           
                           <div class="body-con">
                            
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th style="text-align:left">Project</th>
                                        <th>Manager</th>
                                        <th>Employee</th>
                                        <th>Assigned Date</th>
                                        <th>Start Date</th>
                                       	<th>Actual Complition Date</th>
                                        <th>Status</th>
                                        <th>Title</th>
                                       	<th>Priority</th>
                                        <th style="width: 80px;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                   <? 
								   		$i=1;
								   		foreach($data['allTasks'] as $task)
									   {
										  //if($task['actual_complition_date'] == '0000-00-00 00:00:00'){
										   $class="";
										   $class1="";
										   	if($task['task_status'] == 2)
										   		$class = "status_blue";
										   	else if($task['task_status'] == 1)
												$class = "status_red";
											else if($task['task_status'] == 3)
												$class = "status_green";
											
											if($task['task_priority'] == 1)
												$class1 = "status_red";
											else if($task['task_priority'] == 2)
												$class1 = "status_blue";
											else if($task['task_priority'] == 3)
												$class1 = "status_green";
													
									   ?>
										    <tr>
                                            	<td class="backcolor"><?=$i++; ?></td>
												<td style="text-align:left">
												<?php 
													if($task['project_id'] != '-1')
														echo $task['PROJECT_NAME'];
													else
														echo "Other";	
												?>
                                                </td>
												<td><?=$task['MANAGER_NAME']?></td>
												<td><?=$task['EMP_NAME']?></td>
												<td><?=formatDateTime($task['assigned_date'])?></td>
												<td><?=formatDateTime($task['start_date'])?></td>
												<td><?=formatDateTime($task['actual_complition_date'])?></td>
                                                <td class="<?php echo $class;?>"><?=$task['TASK_STATUS_NAME']?></td>
                                                <td><?=$task['title']?></td>
                                                <td class="<?php echo $class1;?>">
												<?php 
													if($task['task_priority'] == 1)
														echo "Urgent";
													if($task['task_priority'] == 2)
														echo "High";
													if($task['task_priority'] == 3)
														echo "Moderate";
													if($task['task_priority'] == 4)
														echo "Low";
												?>
                                                </td>
                                                <td style="width: 80px;">
                                                <?php if($task['is_active'] != 0){
													echo "<a href=\"javascript:openEditTask('".$task['task_id']."','projects','edit_task')\" class=\"tiptip-top\" title=\"Edit\"><img src=\"img/icon_edit.png\" alt=\"Edit\"></a>&nbsp;&nbsp;&nbsp;";
													if($data['task_function'] == 1)
                                                 		echo "<a href=\"javascript:openDeleteTask('".$task['title']."','".$task['task_id']."','projects','delete_task')\" class=\"tiptip-top\" title=\"Delete\"><img src=\"img/icon_bad.png\" alt=\"delete\"></a>&nbsp;&nbsp;&nbsp;";
													else  if($data['task_function'] == 2)
														echo "<a href=\"javascript:openDeleteTask('".$task['title']."','".$task['task_id']."','projects','delete_team_task')\" class=\"tiptip-top\" title=\"Delete\"><img src=\"img/icon_bad.png\" alt=\"delete\"></a>&nbsp;&nbsp;&nbsp;";
															
                                                 	if($task['actual_complition_date'] == '0000-00-00 00:00:00'){ 
														if($data['task_function'] == 1)
                                                			echo "<a href=\"javascript:openMarkAsComplete('".$task['task_id']."','projects','mark_as_complete')\" class=\"tiptip-top\" title=\"Mark as complete\"><img src=\"img/ok.png\" alt=\"delete\"></a>&nbsp;&nbsp;&nbsp;";
														else if($data['task_function'] == 2)
															echo "<a href=\"javascript:openMarkAsComplete('".$task['task_id']."','projects','mark_as_complete_team')\" class=\"tiptip-top\" title=\"Mark as complete\"><img src=\"img/ok.png\" alt=\"delete\"></a>&nbsp;&nbsp;&nbsp;";
                                                	}
													}else
													{
														if($data['task_function'] == 1)	
                                               				echo "<a href=\"javascript:restoreEntry('".$task['task_id']."','projects','restore_task')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"Restore\"></a>&nbsp;&nbsp;&nbsp;";
														else if($data['task_function'] == 2)
														echo "<a href=\"javascript:restoreEntry('".$task['task_id']."','projects','restore_team_task')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"Restore\"></a>&nbsp;&nbsp;&nbsp;";
													} ?>
                                           		</td>        
                                          	</tr>								   
										   <? //}
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
<script>
$(document).ready(function(e) {
	/*$('#manager').change(function(){
		employee_id = $('#manager').val();
		$.ajax({
			url:"ajax.php",
			type:"POST",
			data:"page=projects&function=get_emp_of_manager_ajax&manager_id="+employee_id,
			success:function(resp){
				var user_select='<option value="0">Plese Select</option>';
				for(var i=0; i<resp.length; i++){
					user_select+="<option value="+resp[i].employee_id+">"+resp[i].employee_name+"</option>";
				}
				$("#all_employee").html(user_select);
				$("#all_employee").change();
			}
		});	
	});*/
	
	$("#from_assign").datetimepicker(
		{ 
			dateFormat: 'yy-mm-dd', 
			timeFormat: 'hh:mm:ss',
		}
	); 
	$("#to_assign").datetimepicker(
		{ dateFormat: 'yy-mm-dd', 
			timeFormat: 'hh:mm:ss',
			
		}
	);
			
});
</script> 