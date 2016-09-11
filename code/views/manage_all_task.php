<script src="js/DateTimePicker.js"></script>
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
                            <h2>All Tasks (<?=count($allTasks)?>)</h2>
                            
                            <!-- div for filters -->
                            <div>
                            <label style="width: 65px;">Manager</label>
							<? createComboBox('manager','employee_id','employee_name', $data['all_managers'],TRUE,'','','Please Select','class="less_width"'); ?> 
                            
                            <label style="width: 65px;">Employee</label>
                            <select class="less_width" id="all_employee"></select>
                            
                            <label style="width: 65px;">Status</label>
                            <?php createComboBox('task_status','task_status_id','task_status_name',$data['allTaskStatus'],TRUE,'','','Please Select','class="less_width"'); ?>
                            
                           	<input type="submit" name="report_submit" value="Submit" id="report_submit" onclick="">
                            <a href="javascript:callPage('projects','view_all_task');">Show all task</a><br/>
                            <label style="width: 70px;">From</label><input type="text" style="max-width: 162px" id="from_complition"/>
                            <label style="width: 95px;">To</label><input type="text" style="max-width: 162px" id="to_complition"/>
                            </div>
                            
                            <div class="show_links" style="top:138px;">
                                <a href="javascript:show_records(0,'projects','view_task');" <?php if((isset($show_status) && $show_status == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'projects','view_task');" <?php if(($show_status == 1)|| !isset($show_status)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'projects','view_task');" <?php if($show_status == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            
                            <a href="javascript:callPage('projects','show_add_task');" class="for_links" style="top:136px;">Add Task</a>
                           
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
                                        <th>Expected Complition Date</th>
                                        <th>Actual Complition Date</th>
                                        <th>Status</th>
                                        <th>Title</th>
                                        <th>Task Details</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <? 
								   		$i=1;
								   		foreach($data['allTasks'] as $task)
									   {
										 
										   $class="";
										   if(date('Y-m-d',strtotime($task['start_date'])) == date('Y-m-d'))
										   		$class = "status_orang";
											else if(date('Y-m-d H:i:s',strtotime($task['expected_complition_date'])) < date('Y-m-d H:i:s'))
												$class = "status_red";
											
											if($task['actual_complition_date'] != '0000-00-00 00:00:00')
												$class = "status_green"
											
									   ?>
										    <tr class="<?php echo $class;?>">
                                            	<td class="backcolor"><?=$i++; ?></td>
												<td style="text-align:left" ><?=$task['PROJECT_NAME']?></td>
												<td><?=$task['MANAGER_NAME']?></td>
												<td><?=$task['EMP_NAME']?></td>
												<td><?=formatDateTime($task['assigned_date'])?></td>
												<td><?=formatDateTime($task['start_date'])?></td>
												<td><?=formatDateTime($task['expected_complition_date'])?></td>
                                                <td><?=formatDateTime($task['actual_complition_date'])?></td>
                                                 <td><?=$task['TASK_STATUS_NAME']?></td>
                                                <td><?=$task['title']?></td>
                                                <td><?=$task['task_details']?></td>
                                                <td><?=$task['remark']?></td>
                                                <td>
                                                <?php if($task['is_active'] != 0){ ?>
												 <a href="javascript:openEditTask(<?php echo $task['task_id']; ?>,'projects','edit_task')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="Edit"></a>  &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:openDeleteTask('<?php echo $task['title']; ?>','<?php echo $task['task_id']; ?>','projects','delete_task')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a> &nbsp;&nbsp;&nbsp;
                                                <?php if($task['actual_complition_date'] == '0000-00-00 00:00:00'){ ?>
                                                <a href="javascript:openMarkAsComplete('<?php echo $task['task_id']; ?>','projects','mark_as_complete')" class="tiptip-top" title="Mark as complete"><img src="img/ok.png" alt="delete"></a>
                                                
                                               <?php }}else{?>
                                               &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo  $task['task_id']; ?>,'projects','restore_task')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
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
<script>
$(document).ready(function(e) {
	$('#manager').change(function(){
		employee_id = $('#manager').val();
		$.ajax({
			url:"ajax.php",
			type:"POST",
			data:"page=projects&function=get_emp_of_manager_ajax&manager_id="+employee_id,
			success:function(resp){
				var user_select='<option value="">Plese Select</option>';
				for(var i=0; i<resp.length; i++){
					user_select+="<option value="+resp[i].employee_id+">"+resp[i].employee_name+"</option>";
				}
				$("#all_employee").html(user_select);
				$("#all_employee").change();
			}
		});	
	});
	
	$("#from_complition").datetimepicker(
		{ dateFormat: 'yy-mm-dd', 
			timeFormat: 'hh:mm:ss',
			
		}
	); 
	$("#to_complition").datetimepicker(
		{ dateFormat: 'yy-mm-dd', 
			timeFormat: 'hh:mm:ss',
			
		}
	);
			
});
</script> 