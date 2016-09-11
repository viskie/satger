<script type="text/javascript">
$(document).ready( function () {
$("#paid_date").datepicker('setDate', parseISO8601(<?
		if($function == 'edit_reimbursement'){
			echo "\"".$data['reimbursementDetails']['paid_date']."\"";
		}else{
			echo "\"".date('Y-m-d')."\"";
		}
	?>));
});
</script>

<?
if($function == 'edit_reimbursement') { 
?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['reimbursementDetails']['reimbursement_id']?>" />
<? 
}
//echo "<pre>"; print_r($data['expectedExpenseDetails']); exit;
?>


                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function == 'show_add_reimbursement') { echo "Add Reimbursement"; } else { echo "Edit Reimbursement";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                       <li id="cat">
											<label for="category">Category <span>*</span></label>
                                           <?
										   	//$catdetails = $accountsObject->getAllExpenseCategories();
										   	if($function == 'edit_reimbursement')
										   		createComboBox('category_id','pc_id','name',$data['catdetails'],TRUE,$reimbursementDetails['category_id']);
											else
												createComboBox('category_id','pc_id','name',$data['catdetails'],TRUE);
										   ?>
										</li>
                                       	<li style="display:none" id="employee">
											<label for="employee">Employee </label>
                                           <?
										   	//$empdetails = $employeeObject->getAllEmployees();
										   	if($function == 'edit_reimbursement')
											   	createComboBox('employee','employee_id','employee_name', $data['empdetails'],TRUE,$reimbursementDetails['employee_id']);
										    else   
										   		createComboBox('employee','employee_id','employee_name', $data['empdetails'],TRUE);
										   ?>
										</li>
                                        <li style="display:none" id="proj">
											<label for="project">Project </label>
                                           <?
										   //$prodetails = $projectObject->getAllProjects();
										   if($function == 'edit_reimbursement')
										   		createComboBox('project','project_id','project_name',$data['prodetails'],TRUE,$reimbursementDetails['project_id']);
											else
												createComboBox('project','project_id','project_name',$data['prodetails'],TRUE);	
										   ?>
										</li>
                                        <li>
											<label for="amount_usd">Amount USD </label>
                                            <input type="text" id="amount_usd" name="amount_usd"  value='<? if($function == 'edit_reimbursement'){ echo $data['reimbursementDetails']['amount_usd']; }?>' />
										
											<label for="conversion_rate">Conversion Rate </label>
                                            <input type="text" id="conversion_rate" name="conversion_rate"  value='<? if($function == 'edit_reimbursement'){ echo $data['reimbursementDetails']['conversion_rate']; } ?>' />
										</li>
                                         <li>
											<label for="amount_inr">Amount INR <span>*</span></label>
                                            <input type="text" id="amount_inr" name="amount_inr"  value='<? if($function == 'edit_reimbursement'){ echo $data['reimbursementDetails']['amount']; } ?>' />
										
											<label for="paid_date">Paid Date <span>*</span></label>
                                            <input type="text" id="paid_date" name="paid_date"  value='<? if($function == 'edit_reimbursement'){ echo $data['reimbursementDetails']['paid_date']; } ?>' />
                                            <input type="hidden" id="paid_date_alt" name="paid_date_alt" size="30">
                                        </li>
                                        
                                        <li>
                                        	<label for="remarks">Remarks <span>*</span></label>
											<textarea id="remark" name="remark"  value=''><? if($function == 'edit_reimbursement'){ echo stripslashes($data['reimbursementDetails']['remarks']); } ?></textarea>
                                        </li>
										
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_reimbursement') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateReimbursement('<?=$data['reimbursementDetails']['reimbursement_id']?>','hrm','edit_reimbursement_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addReimbursement('hrm','add_reimbursement')" >
                                           <? } ?>
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('hrm','view_reimbursement')" /> 
                                        </li>

									</ul>
							</div>
                            
                            
                           
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_payment') {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
								<? foreach($data['paymentDetails'] as $key=>$value ) { 
										$value=shownlInjs($value);
								?>
										$('#<?=$key;?>').val('<?=$value;?>');
								<? } ?>	
															
						});
						
                   </script>
                   <? } ?>
                   
                   <script type="text/javascript">
				   $(document).ready( function () {
                   		$('#cat select').change(function(){
							var cat_name=$('#cat select').find(":selected").text();
							if(cat_name == 'Employee'){
								$('#employee').show('slow');	
							}else{
								$("#employee select").find("option[value='0']").attr("selected","selected");
								$('#employee').hide('slow');
							}
							if(cat_name == 'Project Expense'){
								$('#proj').show('slow');	
							}else{
								$("#proj select").find("option[value='0']").attr("selected","selected");
								$('#proj').hide('slow');
							}
						});
						$('#cat select').change();
					});	
                   </script>