<script src="js/DateTimePicker.js"></script>
<?
//if($function == 'edit_task') {   
?>
<input type="hidden" name="edit_id" id="edit_id" value="" />
<? 
//}
//var_dump($data['taskDetails']);exit;
//echo "<pre>"; print_r($data);
//echo "<pre>"; print_r($_REQUEST);
?>
 <input type="hidden" name="task_function" value="<?php if(isset($data['task_function'])){ echo $data['task_function']; } ?>" id="task_function" />
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function=='show_add_task') 
										{ echo "Add taks"; } 
									else if ($function=='edit_task')
									 { echo "Edit task";} 
									 ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label>Project <span>*</span></label>
                                            <?
											if($function=='show_add_task')
											 {
                                               createComboBox('project','project_id','project_name',$data['allProjects'],TRUE);	
											 }
											if( $function=='edit_task')
											 {
												 foreach($data['allProjects'] as $project){
													 if($project['project_id']==$data['taskDetails']['project_id']){
														 echo "<label style='text-align:left'>".$project['project_name']."</label>";
														 //echo "<input type='text' value='".$project['project_name']."' name='project' style='text-align:left' readonly='readonly'/>";
													 }
												 }
                                               //createComboBox('project','project_id','project_name',,TRUE,$data['taskDetails']['project_id']);
											 }
											?>
										</li>
                                       <li>
                                       		 <div style="display:none" id="manager_select">
                                            	<label>Manager<span>*</span></label>
                                             	<?php
                                                if($function=='show_add_task'){														
                                                    createComboBox('manager_id','employee_id','employee_name', $data['allEmployees'],'Please select');
                                                }
                                                if( $function=='edit_task'){
                                                    createComboBox('manager_id','employee_id','employee_name', $data['allEmployees'],'Please select',$data['taskDetails']['manager_id']);
                                                }
                                             	?>
                                             </div>
                                       </li>
                                        
                                        <?php if( $function=='edit_task'){ ?>
                                        <li>
                                        	 <label>Manager : </label>
                                              <label style="text-align:left"><?=$data['taskDetails']['employee_name'] ?></label>
                                        </li>
                                        <?php } ?>
                                       <li>
                                       		<label>Employee <span>*</span></label>
                                             <?php
											 	if($function=='show_add_task'){														
													createComboBox('employee_id','employee_id','employee_name',$data['allEmployees'],'Please select');
												}
												if( $function=='edit_task'){
													createComboBox('employee_id','employee_id','employee_name',$data['allEmployees'],'Please select',$data['taskDetails']['employee_id']);
												}
											 ?>
                                        </li>
                                        <li>
                                        	<label for="assigned_date">Assigned Date : <span></span></label>
                                            <input type="text" id="assigned_date" name="assigned_date"  value=''/>
											<input type="hidden" id="assigned_date_alt" name="assigned_date_alt" size="30" />
                                            
                                            <label for="task_start_date">Start Date : <span></span></label>
                                            <input type="text" id="task_start_date" name="task_start_date"  value=''/>
											<input type="hidden" id="task_start_alt" name="task_start_alt" size="30" />
                                        <li>
											<label for="expected_complition_date" style="width:159px;font-size: 11px">Expected Complition Date <span><?php if( $function=='edit_task'){ echo "*"; }?></span> :</label>
											<input type="text" id="expected_complition_date" name="expected_complition_date"  value='' />
                                            <input type="hidden" id="expected_complition_alt" name="expected_complition_alt" size="30" />
                                            
                                           <!-- <label for="expected_end_date">Actual Complition Date : <span></span></label>
                                            <input type="text" id="end_date" name="end_date"  value='' />
                                            <input type="hidden" id="end_alt" name="end_alt" size="30" />-->
										</li>
                                        <?php if($function != 'show_add_task') { ?>
                                        <li>
											<label for="task_status">Status : <span></span></label>
                                             <?
												if($function=='show_add_task')
											 	{
                                               	createComboBox('task_status','task_status_id','task_status_name',$data['allTaskStatus']);	
											 	}
												if( $function=='edit_task')
											 	{
                                               		createComboBox('task_status','task_status_id','task_status_name',$data['allTaskStatus'],TRUE,$data['taskDetails']['task_status']);
											 	}
											 
										} ?>
                                            <?php if($function=='edit_task') {
													$proirity_value = $data['taskDetails']['task_priority'];	
											?>
                                            	<label for="task_status">Priority <span>*</span></label>
                                                <select name="task_priority" id="task_priority">
                                                    <option value="0">Please select</option>
                                                    <option value="1" <?php if($proirity_value == 1) { echo "selected='selected'";}?>>Urgent</option>
                                                    <option value="2" <?php if($proirity_value == 2) { echo "selected='selected'";}?>>High</option>
                                                    <option value="3" <?php if($proirity_value == 3) { echo "selected='selected'";}?>>Moderate</option>
                                                    <option value="4" <?php if($proirity_value == 4) { echo "selected='selected'";}?>>Low</option>
                                                </select>
                                            <?php }else{?>
                                            	<label for="task_status">Priority <span>*</span></label>
                                                <select name="task_priority" id="task_priority">
                                                    <option value="0">Please select</option>
                                                    <option value="1">Urgent</option>
                                                    <option value="2">High</option>
                                                    <option value="3">Moderate</option>
                                                    <option value="4">Low</option>
                                                </select>
                                            <?php } ?>
                                            
										</li>
                                        
                                        <li>
											<label for="title">Title : <span></span></label>
                                            <input type="text" id="title" name="title"  value='<?php if($function == "edit_task"){ echo $data['taskDetails']['title'];}?>'/>
                                        </li>
                                        <li>
                                        	<label for="task">Task : <span></span></label>
                                            <textarea rows="12" id="task" name="task"><?php if($function == "edit_task"){ echo $data['taskDetails']['task_details'];}?></textarea>
                                        
                                        	<label for="remark">Remarks/Notes : <span></span></label>
                                            <textarea rows="12" id="remark" name="remark"><?php if($function == "edit_task"){ echo $data['taskDetails']['remark'];}?></textarea>
                                        </li>
                                        <li>
                                            <label></label>
                                            <?php  
											if($function == 'edit_task') {       
                                             	 if($data['task_function'] == 1){
													echo "<input type=\"button\" value=\"Update\" class=\"green_button\"  onclick=\"javascript:updateTask('".$data['taskDetails']['task_id']."','projects','edit_task_entry')\" >";
												 }else if($data['task_function'] == 2){
													 echo"<input type=\"button\" value=\"Update\" class=\"green_button\"  onclick=\"javascript:updateTask('".$data['taskDetails']['task_id']."','projects','edit_team_task_entry')\" >";
												 }
                                            } 
											else if($function == 'show_add_task') {
                                           		if($data['task_function'] == 1){
													echo "<input type=\"button\" value=\"Insert\" class=\"green_button\"  onclick=\"javascript:addTask('projects','add_task')\" >";
												}else{
													echo "<input type=\"button\" value=\"Insert\" class=\"green_button\"  onclick=\"javascript:addTask('projects','add_team_task')\" >";
												}
                                           } 
										   
										   if($data['task_function'] == 1){
										   		echo "<input type=\"button\" value=\"Cancel\" class=\"green_button\"  onclick=\"javascript:callPage('projects','view_task')\" />";
										   }else if($data['task_function'] == 2){
											   echo "<input type=\"button\" value=\"Cancel\" class=\"green_button\"  onclick=\"javascript:callPage('projects','view_team_task')\" />";
										   }
										   ?>
                                           
                                        </li>

									</ul>
							</div>                            
                            
                          
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_task') {   ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
							$('#all_employee').show();
							$('#assigned_date').val('<?php echo $data['taskDetails']['assigned_date'] ?>');
							$('#task_start_date').val('<?php echo $data['taskDetails']['start_date'] ?>');
							$('#expected_complition_date').val('<?php echo $data['taskDetails']['expected_complition_date'] ?>');
							
							$('#task_status').change(function(){
								task_status_id = $('#task_status').val();
								task_id = <?php echo $data['taskDetails']['task_id']; ?>;
								if(task_status_id == 3)
								{
									if($('#task_status').val() == 0)
										alert("Please select expected end date!");	
								}
								$.ajax({
										url:"ajax.php",
										type:"POST",
										data:"page=projects&function=mark_as_complete_ajax&task_status_id="+task_status_id+"&task_id="+task_id,
										success:function(resp){
											
										}
								});			
							});
						});
                   </script>
                   
                   <? } ?>
				   
<script>
$(document).ready(function(e) {
	
	$("#assigned_date").datetimepicker(
		{ dateFormat: 'yy-mm-dd', 
			timeFormat: 'hh:mm:ss',
			
		}
	); 
	$("#task_start_date").datetimepicker(
		{ dateFormat: 'yy-mm-dd', 
			timeFormat: 'hh:mm:ss',
			
		}
	);
	$("#expected_complition_date").datetimepicker(
		{ dateFormat: 'yy-mm-dd', 
			timeFormat: 'hh:mm:ss',
			
		}
	);
	
	$('#project').change(function(){
		if($('#project').val() == '-1'){
			$('#manager_select').show();	
		}else{
			$('#manager_select').hide();	
		}
	});
});
</script>                   