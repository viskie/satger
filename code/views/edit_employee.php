<script>
$(document).ready(function(e) {
	$("#date_of_birth").datepicker('setDate', parseISO8601(<?	
			echo "\"".$data['employee_Details']['date_of_birth']."\"";
	?>)); 
	
	$("#joining_date").datepicker('setDate', parseISO8601(<?	
			echo "\"".$data['employee_Details']['joining_date']."\"";
	?>));   
});
</script>
<?
//echo "<pre>"; print_r($data);

?>
<input type="hidden" name="employee_id" id="employee_id" value="<?=$data['employee_Details']['employee_id']?>" />
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content">


                            <!-- Messages -->
                         
                            <h2>Edit Employee</h2>
                            
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label for="adduser-username">Employee Name <span>*</span></label>
                                            <input type="text" id="employee_name" name="employee_name"  value='<?=$data['employee_Details']['employee_name']?>' />
                                            
                                        </li>
                                        <li>
                                        	<label for="date_of_birth">Date Of Birth <span></span></label>
                                    		<input type="text" id="date_of_birth" name="date_of_birth" />
                                    		<input type="hidden" id="dob_alt" name="dob_alt" size="30" />
                                       </li>
                                       <li>
                                       		<label for="per_address">Permanent Address <span>*</span></label>
		                                    <textarea id="per_address" name="per_address"  > <?=$data['employee_Details']['per_address']?> </textarea>
                                        </li>
                                        <li>
                                        	<label for="cur_address">Current Address <span></span></label>
                                    		<textarea id="cur_address" name="cur_address"  ><?=$data['employee_Details']['cur_address']?></textarea>
                                        	
                                        </li>
                                        <li>
                                        	<label for="phone_number">Phone Number <span>*</span></label>
                                    		<input type="text" id="phone_number" name="phone_number" value='<?=$data['employee_Details']['phone_number']?>' />
                                        	
                                        </li>
                                        <li>
                                        	<label for="current_salary">Current Salary <span></span></label>
                                  		    <input type="text" id="current_salary" name="current_salary" value='<?=$data['employee_Details']['current_salary']?>' />
                                        	
                                        </li>
                                         <li>
                                        	<label for="joining_date">Joining Date <span>*</span></label>
                                    		<input type="text" id="joining_date" name="joining_date"  />
                                    		<input type="hidden" id="jd_alt" name="jd_alt" size="30" />
                                        	
                                        </li>
                                        <li>
                                        	<label for="designation">Designation <span></span></label>
                                  		    <input type="text" id="designation" name="designation" value='<?=$data['employee_Details']['designation']?>' />
                                        	
                                        </li>
                                        <li>
                                        	<label for="personal_email">Personal Email <span>*</span></label>
                               		        <input type="text" id="personal_email" name="personal_email" value='<?=$data['employee_Details']['personal_email']?>' />
                                        	
                                        </li>
                                        <li>
                                        	<label for="company_email">Company Email <span></span></label>
                                    		<input type="text" id="company_email" name="company_email" value='<?=$data['employee_Details']['company_email']?>' />
                                        	
                                        </li>
                                        <li>
                                            <label></label>
                                          <input type="button" value="Update" class="green_button"  onClick="updateEmployee('manage_employees.php','edit_employee_entry')"/>
                                         
                                            <!--<button value="Submit" class="green"  onclick="javascript:chkProjectCategory()">Update</button> -->

                                        </li>
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                            </div>
                            
                        </div>
						</div>
                        <!-- END Main Content -->
