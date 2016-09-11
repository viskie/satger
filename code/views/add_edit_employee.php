<script type="text/javascript">
$(document).ready( function () {
});
</script>

<?
if($function == 'edit_employee' || ($is_exist == true && $is_edit == true)) {   
?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['employeeDetails']['employee_id']?>" />
<input type="hidden" name="user_id" id="user_id" value="<?=$data['employeeDetails']['user_id']?>" />
<? 
}
//echo "<pre>"; print_r($data);
?>


                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                         	<div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                         <? }  else  if($notificationArray['type'] == "Failed") { ?>
                         	<div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                         <?   } } ?>
                            <h2><? if($function=='show_add_employee') { echo "Add employee"; } else { echo "Edit employee";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        
                                        <li>
                                        	 <label for="employee_user_name">Employee User Name <span>*</span></label>
                                    		 <input type="text" id="employee_user_name" name="employee_user_name" value='<? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['employee_user_name']; }?>' />
                                              <!--<span class="msg-form-info">Alphanumeric characters only!</span>-->
                                        		
											 <label for="employee_name">Employee Name <span>*</span></label>
                                    		 <input type="text" id="employee_name" name="employee_name" value='<? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['employee_name']; }?>' />
										
                                        	
										</li>
                                        <li>
                                        	<label for="employee_password">Password <span>*</span></label>	
											<input type="password" id="employee_password" name="employee_password" value="<? if($function == 'edit_employee' || $is_exist == true){ echo "********"; }?>"/>
                                             <!--<span class="msg-form-info">At least 6 characters!</span>-->
                                        
											<label for="date_of_birth">Date Of Birth <span></span></label>
                                    <input type="text" id="date_of_birth" name="date_of_birth" />
                                    <input type="hidden" id="dob_alt" name="dob_alt" size="30" value='<? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['date_of_birth']; }?>' />
										</li>
                                         <li>
											<label for="per_address">Permanent Address <span>*</span></label>
                                    <textarea id="per_address" name="per_address" ></textarea>
										
											<label for="cur_address">Current Address <span></span></label>
                                    <textarea id="cur_address" name="cur_address" ><? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['cur_address']; }?></textarea>
                                        </li>
                                        <li>
											<label for="phone_number">Phone Number <span>*</span></label>
                                    <input type="text" id="phone_number" name="phone_number" value='<? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['phone_number']; }?>' />
                                       
                                        	<label for="current_salary">Current Salary <span></span></label>
                                    <input type="text" id="current_salary" name="current_salary" value='<? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['current_salary']; }?>' />
                                        </li>
										<li>
                                        <label for="joining_date">Joining Date <span>*</span></label>
                                    <input type="text" id="joining_date" name="joining_date" value='<? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['joining_date']; }?>' />
                                    <input type="hidden" id="jd_alt" name="jd_alt" size="30" />
                                        
                                       
                                        <label for="designation">Designation <span></span></label>
                                    <input type="text" id="designation" name="designation" value='<? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['designation']; }?>' />
                                        </li>
                                        <li>
                                        <label for="personal_email">Personal Email <span>*</span></label>
                                    <input type="text" id="personal_email" name="personal_email" value='<? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['personal_email']; }?>' />
                                        
                                        <label for="company_email">Company Email <span></span></label>
                                    <input type="text" id="company_email" name="company_email" value='<? if($function == 'edit_employee' || $is_exist == true){ echo $data['employeeDetails']['company_email']; }?>' />
                                        </li>
                                        <li>
                                        <label for="employee_id">Manager <span></span></label>
                                        <?
										//var_dump($data['allEmployees']);exit;
										if($function == 'show_add_employee')
										{
											createComboBox('manager_id','employee_id','employee_name', $data['allEmployees'], FALSE);
										}
										if($function == 'edit_employee' || $is_exist == true)
										{	
											createComboBox('manager_id','employee_id','employee_name', $data['allEmployees'], FALSE, $data['employeeDetails']['manager_id']);
										}
										?>
                                        <label for="emp_status">Status <span>*</span></label>
                                        <?php if($function == 'edit_employee' || $is_exist == true) {?>
                                        <select name="employee_status" id="employee_status">
                                        	<option value="0" <?php if($data['employeeDetails']['employee_status'] == 0 ){ echo "selected='selected'";}?>>Past Employee</option>
                                            <option value="1" <?php if($data['employeeDetails']['employee_status'] == 1 ){ echo "selected='selected'";}?>>Current Employee</option>
                                        </select>
                                        <?php }else{ ?>
                                        <select name="employee_status" id="employee_status">
                                        	<option value="0">Past Employee</option>
                                            <option value="1" selected='selected'>Current Employee</option>
                                        </select>	
                                        <?php } ?>
                                        </li>
                                        
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_employee' ||($is_exist == true && $is_edit == true)) {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateEmployee('<?=$data['employeeDetails']['employee_id']?>','hrm','edit_employee_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addEmployee('hrm','add_employee')" >
                                           <? } ?>
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('hrm','view')" /> 
                                        </li>

									</ul>
							</div>
                            
                            
                           
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_employee' || $is_exist == true) {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
								//jQuery
								<? foreach($data['employeeDetails'] as $key=>$value ) {
										//echo "alert('".$value."');";
										//$value=addslashes($value);
										$value=shownlInjs($value);
										
									 ?>
										$('#<?=$key;?>').val('<?=($value);?>');
								<? } ?>	
								$("#date_of_birth").datepicker('setDate', parseISO8601(<?	
										echo "\"".$data['employeeDetails']['date_of_birth']."\"";
								?>)); 
								
								$("#joining_date").datepicker('setDate', parseISO8601(<?	
										echo "\"".$data['employeeDetails']['joining_date']."\"";
								?>)); 								
						});
						
                   </script>
                   <? } ?>