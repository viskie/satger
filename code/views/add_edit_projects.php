<?
if($function == 'edit_project' || $function == 'view_project') {   
?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['projectDetails']['project_id']?>" />
<? 

 }
//var_dump($data['projectDetails']);exit;
//echo "<pre>"; print_r($data);
?>


                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function=='show_add_project') 
										{ echo "Add project"; } 
									else if ($function=='edit_project')
									 { echo "Edit Project";} 
									 else
									 {echo "Project Details";}?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label <? if($function=='view_project'){?> style="font-weight:normal"<? }?> >Project Name : <span <? if($function=='view_project'){?> style="display:none"<? }?> >*</span></label>
                                            <input type="text" id="project_name" name="project_name"  value='' <? if($function=='view_project'){?> style="display:none"<? }?>/>
											<? if($function=='view_project')
												{
													?>
                                                    <label style="text-align:left"><?=$data['projectDetails']['project_name'] ?></label>
                                                    <?
												}
												?>
                                            <label for="client" <? if($function=='view_project'){?> style="font-weight:normal"<? }?> >Client : <span <? if($function=='view_project'){?> style="display:none"<? }?> >*</span></label>
                                            <?
												if($function=='show_add_project')
											  {// $details = $clientObject->getAllClients();
                                               createComboBox('client','client_id','client_biz_name',$data['clientDetails'],true);
											  }
											
                                              if( $function=='edit_project')
											  {// $details = $clientObject->getAllClients();
                                               createComboBox('client','client_id','client_biz_name',$data['clientDetails'],true,$data['projectDetails']['client']);
											  }
											  if($function=='view_project')
											  {
												  ?>
                                                   <label style="text-align:left"><?=$data['projectDetails']['client_biz_name'] ?></label>
                                                  <?
											  }
											 // var_dump($data['projectDetails']);exit;
                                            ?>
										</li>
                                        <li>
                                        	<label <? if($function=='view_project'){?> style="font-weight:normal"<? }?>>Manager : <span <? if($function=='view_project'){?> style="display:none"<? }?> >*</span></label>
                                             <?php
											 	if($function=='show_add_project'){														
													createComboBox('employee_id','employee_id','employee_name', $data['allEmployees'],'Please select');
												}
												if( $function=='edit_project'){
													createComboBox('employee_id','employee_id','employee_name', $data['allEmployees'],'Please select',$data['projectDetails']['employee_id']);
												}
												if($function=='view_project')
											 	 {
												  ?>
                                                   <label style="text-align:left"><?=$data['projectDetails']['employee_name'] ?></label>
                                                  <?
											  	}
											 ?>
                                             
                                             <!-- project category -->
                                            <label for="project_category" <? if($function=='view_project'){?> style="font-weight:normal"<? }?> >Project Category : <span <? if($function=='view_project'){?> style="display:none"<? }?> >*</span></label>
                                            <?
												if($function=='show_add_project')
											  {// $details = $clientObject->getAllClients();
                                               createComboBox('project_category_id','project_category_id','project_category_name',$data['projectcategoryDetails'],true);
											  }
											
                                              if( $function=='edit_project')
											  {// $details = $clientObject->getAllClients();
                                               createComboBox('project_category_id','project_category_id','project_category_name',$data['projectcategoryDetails'],true,$data['projectDetails']['project_category_id']);
											  }
											  if($function=='view_project')
											  {
												  ?>
                                                   <label style="text-align:left"><?=$data['projectDetails']['project_category_name'] ?></label>
                                                  <?
											  }
											 
                                            ?>
                                            
                                            <!-- -->
                                        </li>
                                        <li>
                                        	<label for="start_date" <? if($function=='view_project'){?> style="font-weight:normal"<? }?> >Start date : <span></span></label>
                                            <input type="text" id="start_date" name="start_date"  value='' <? if($function=='view_project'){?> style="display:none"<? }?>/>											<?
                                            if($function=='view_project')
											  {
												  ?>
                                                   <label style="text-align:left"><?=formatdate($data['projectDetails']['start_date']) ?></label>
                                                  <?
											  }
											  ?>
                                            <input type="hidden" id="start_alt" name="start_alt" size="30" />
                                            
                                            <label for="end_date" <? if($function=='view_project'){?> style="font-weight:normal"<? }?>>End date : <span></span></label>
                                            <input type="text" id="end_date" name="end_date"  value='' <? if($function=='view_project'){?> style="display:none"<? }?>/>
                                            <?
                                            if($function=='view_project')
											  {
												  ?>
                                                   <label style="text-align:left"><?=formatdate($data['projectDetails']['end_date']) ?></label>
                                                  <?
											  }
											  ?>
                                            <input type="hidden" id="end_alt" name="end_alt" size="30" />
										</li>
                                        <li>
											<label for="expected_end_date" <? if($function=='view_project'){?> style="font-weight:normal"<? }?> >Expected end date : <span></span></label>
											<input type="text" id="expected_end_date" name="expected_end_date"  value='' <? if($function=='view_project'){?> style="display:none"<? }?> />
                                            <?
                                            if($function=='view_project')
											  {
												  ?>
                                                   <label style="text-align:left"><?=formatdate($data['projectDetails']['expected_end_date']) ?></label>
                                                  <?
											  }
											  ?>
                                            <input type="hidden" id="expected_end_alt" name="expected_end_alt" size="30" />
                                            
                                            
											 
										</li>
                                        
                                        <li>
											<label for="project_cost_INR" <? if($function=='view_project'){?> style="font-weight:normal"<? }?> >Project Cost INR : <span<? if($function=='view_project'){?> style="display:none"<? }?> >*</span></label>
                                            <input type="text" id="project_cost_INR" name="project_cost_INR"  value='' <? if($function=='view_project'){?> style="display:none"<? }?> />
                                            <?
                                            if($function=='view_project')
											  {
												  ?>
                                                   <label style="text-align:left"><?=$data['projectDetails']['project_cost_INR'] ?></label>
                                                  <?
											  }
											  ?>
										
											<label for="project_cost_dollar" <? if($function=='view_project'){?> style="font-weight:normal"<? }?> >Project Cost(USD) : <span></span></label>
                                            <input type="text" id="project_cost_dollar" name="project_cost_dollar"  value='' <? if($function=='view_project'){?> style="display:none"<? }?> />
                                           <?
                                            if($function=='view_project')
											  {
												  ?>
                                                   <label style="text-align:left"><?=$data['projectDetails']['project_cost_dollar'] ?></label>
                                                  <?
											  }
											  ?> 
										</li>
                                        
                                        <li>
											<label for="project_expense" <? if($function=='view_project'){?> style="font-weight:normal"<? }?> >Project Expense : <span></span></label>
                                            <input type="text" id="project_expense" name="project_expense"  value='' <? if($function=='view_project'){?> style="display:none"<? }?> />
                                            <?
                                            if($function=='view_project')
											  {
												  ?>
                                                   <label style="text-align:left"><?=$data['projectDetails']['project_expense'] ?></label>
                                                  <?
											  }
											  ?> 
                                       
                                            <label for="remarks" <? if($function=='view_project'){?> style="font-weight:normal"<? }?> >Remarks/Notes : <span></span></label>
                                            <textarea id="remarks" name="remarks" <? if($function=='view_project'){?> style="display:none"<? }?> ><? if($function == 'edit_project'){ echo $data['projectDetails']['remarks']; }?></textarea>
                                             <?
                                            if($function=='view_project')
											  {
												  ?>
                                                   <label style="text-align:left"><?=stripslashes($data['projectDetails']['remarks']) ?></label>
                                                  <?
											  }
											  ?> 
										</li>
                                        <? //echo $data['projectDetails']['project_id'];exit;?>
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_project') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateProject('<?=$data['projectDetails']['project_id']?>','projects','edit_project_entry')" >
                                            <? } else if($function == 'show_add_project') { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addProject('projects','add_project')" >
                                           <? } else
										   {
											   ?>
                                               <input type="button" value="Edit Details" class="green_button"  onclick="javascript:openEditProject('<?=$data['projectDetails']['project_id']?>','projects','edit_project')"  >
                                               <?
										   }
										   ?>
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('projects','view')" /> 
                                        </li>

									</ul>
							</div>                            
                            
                           <? if($function=='view_project') 
									{echo " <h2>Income-Expense Details</h2>";
									
									?>
                                    <div>
                                    <div style="width:50%;float:left">
                                    <table>
                                    <tr>
                                    <th colspan="2">Expenses</th>
                                    </tr>
                                    <tr>
                                    <td style="font-weight:bold">Particular</td><td style="font-weight:bold">Amount</td>
                                    </tr>
                                    
                                    <?
									$ex_cnt = count($data['expensePaymentDetails']);
									$in_cnt = count($data['incomePaymentDetails']);
									
									if($ex_cnt > $in_cnt)
									{
										$max = $ex_cnt;
									}
									else if($in_cnt > $ex_cnt)
									{
										$max = $in_cnt;
									}
									else
									{
										$max = $in_cnt;
									}
									
									$ex_dif = $max - $ex_cnt;
									$in_dif = $max - $in_cnt;
									
									$total_expense=0;
									
									foreach($data['expensePaymentDetails'] as $value)
									{
										$total_expense = $total_expense + $value['amount'];
										?>
                                        <tr>
                                        <td><?=stripslashes($value['remarks'])?></td><td><?=$value['amount']?></td>
                                        </tr>
                                        <?
									}
									for($i=1;$i<=$ex_dif;$i++)
                                    {
										?>
                                        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <?
                                    }
                                    ?>
                                    
                                    <tr><td style="font-weight:bold">Total Expense</td><td><?=$total_expense ?></td></tr>
                                    </table>
                                    </div>
                                    <div style="width:50%;float:left">
                                    <table>
                                    <tr>
                                    <th colspan="2">Incomes</th>
                                    </tr>
                                    <tr>
                                    <td style="font-weight:bold">Particular</td><td style="font-weight:bold">Amount</td>
                                    </tr>
                                    
                                    <?
									
									$total_income=0;
									
									
									foreach($data['incomePaymentDetails'] as $value)
									{
										$total_income = $total_income + $value['amount'];
										?>
                                        <tr>
                                        <td><?=stripslashes($value['remarks'])?></td><td><?=$value['amount']?></td>
                                        </tr>
                                        <?
									}
									for($i=1;$i<=$in_dif;$i++)
                                    {
										?>
                                        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <?
                                    }
                                    ?>
                                    <tr><td style="font-weight:bold">Total Income</td><td><?=$total_income ?></td></tr>
                                   
                                    </table>
                                    
                                    </div>
                                   
                                    <div style="clear:both;"></div>
                                    <lable style="font-weight:bold;text-align:center;float:right">Project Total : </label><label style="width:50px"><?=($total_income-$total_expense) ?></label>
                                    </div>
                                    <?
									
									}?>
                            
                            
                           
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_project') {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
							<? foreach($data['projectDetails'] as $key=>$value ) { 
									$value=shownlInjs($value);
									if($value!="0000-00-00"){
									?>
										$('#<?=$key;?>').val('<?=$value;?>');
							<? 		} 
								} ?>	
								
								<? if($data['projectDetails']['start_date']!="0000-00-00"){?>
									$("#start_date").datepicker('setDate', parseISO8601(<?	
										echo "\"".$data['projectDetails']['start_date']."\"";
									?>)); 
								<? }?>
								<? if($data['projectDetails']['expected_end_date']!="0000-00-00"){?>
									$("#expected_end_date").datepicker('setDate', parseISO8601(<?	
									echo "\"".$data['projectDetails']['expected_end_date']."\"";
									?>));
								<? }?>
								<? if($data['projectDetails']['end_date']!="0000-00-00"){?>
									$("#end_date").datepicker('setDate', parseISO8601(<?	
									echo "\"".$data['projectDetails']['end_date']."\"";
									?>));
								<? }?>
						});
                   </script>
                   
                   <? } ?>