<?
if($function == 'edit_lead') {   
?>
<input type="hidden" name="edit_id" id="edit_id" value="" />
<? 
}
//echo "<pre>"; print_r($data['leadDetails']); exit;
?>


                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function=='show_add_leads') { echo "Add Lead"; } else { echo "Edit Lead";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        
                                       <li>
                                        	<label for="client">Lead Name <span>*</span></label>
                                         	<input type="text" id="lead_name" name="lead_name" value=' <?php  if($function == 'edit_lead') { echo $data['leadDetails'][0]['lead_name'];  }?>' />
                                        
                                        	<label for="firm_name">Name of Firm <span></span></label>
                                         	<input type="text" id="firm_name" name="firm_name" value=' <?php  if($function == 'edit_lead') { echo $data['leadDetails'][0]['firm_name'];  }?>' />
                                        </li>
                                        <li>
                                        	<label for="firm_name">Position in the Firm <span></span></label>
                                         	<input type="text" id="firm_position" name="firm_position" value=' <?php  if($function == 'edit_lead') { echo $data['leadDetails'][0]['firm_position'];  }?>' />
                                        
                                        	<label for="firm_name">Type of Business <span></span></label>
                                         	<input type="text" id="type_business" name="type_business" value=' <?php  if($function == 'edit_lead') { echo $data['leadDetails'][0]['type_business'];  }?>' />
                                        </li>
                                        <!--<li>
											 <label for="client">Client / Custmoer <span>*</span></label>
                                            
                                    		 < ?  if($function == "edit_lead"){
												 	//print_r($data['leadDetails']); exit;
												 	createComboBox('client','client_id','client_name',  $data['clientDetails'],'',$data['leadDetails'][0]['client_id'],'client_biz_name'); }
												else{
													createComboBox('client','client_id','client_name',  $data['clientDetails'],'','','client_biz_name');								
												}
											?>
										</li>-->
										<li>
											 <label for="product">Product <span>*</span></label>
                                    		 <?  if($function == "edit_lead"){ createComboBox('product','product_id','product_name',$data['product'],true,$data['leadDetails'][0]['product_id']); } else { createComboBox('product','product_id','product_name',  $data['product'],true); }?> 
                                         
											 <label for="source">Source <span>*</span></label>
                                    		 <?  if($function == "edit_lead"){ createComboBox('source','source_id','source_name',$data['source'],true,$data['leadDetails'][0]['source_id']); } else { createComboBox('source','source_id','source_name',  $data['source'],true); }?> 
                                         </li>
										
                                        
                                         <li>
											<label for="initial_contact_date">Initial Contact Date <span>*</span></label>
                                    		<input type="text" id="initial_contact_date" name="initial_contact_date" value='' />
                                            <input id="initial_contact_date_alt" type="hidden" size="30" name="initial_contact_date_alt" value="">
                                            
                                        
                                        	<label for="followup_date">Followup Date <span>*</span></label>
                                    		<input type="text" id="followup_date" name="followup_date" value='' />
                                            <input id="followup_date_alt" type="hidden" size="30" name="followup_date_alt" value="">
                                        </li>
                                        <li>
                                        	<label for="conversion_date">Conversion Date <span></span></label>
                                    		<input type="text" id="conversion_date" name="conversion_date" value='' />
                                            <input id="conversion_date_alt" type="hidden" size="30" name="conversion_date_alt" value="">
                                            
                                            <label for="initial_meeting_date">Initial Meeting Date <span></span></label>
                                    		<input type="text" id="initial_meeting_date" name="initial_meeting_date" value='' />
                                            <input id="initial_meeting_date_alt" type="hidden" size="30" name="initial_meeting_date_alt" value="">
                                        </li>
                                        <li>
                                        	<label for="lead-email">Email<span>*</span></label>
                    						<input type="text" id="lead_email" name="lead_email" value='<?php  if($function == 'edit_lead') { echo $data['leadDetails'][0]['lead_email'];  }?>'/>
                                        
                                        	<label for="lead-phone">Phone<span>*</span></label>
                    						<input type="text" id="lead_phone" name="lead_phone" value='<?php  if($function == 'edit_lead') { echo $data['leadDetails'][0]['lead_phone'];  }?>'/>
                                        </li>
                                        
                                        <li>
                                        	<label for="status">Status <span>*</span></label>
                                    		<?  if($function == "edit_lead"){ createComboBox('status','status_id','status_name',$data['status'],'',$data['leadDetails'][0]['status_id']); } else { createComboBox('status','status_id','status_name',$data['status'],true); } ?>
                                        	
                                            <label for="priority">Priority<span></span></label>
                                            <select name="priority_id" id="priority_id">
                                            	<option value="">Please select</option>
                                                <?php
												for($i=0;$i<count($priority);$i++)
												{
													$selected = "";
													if($function == 'edit_lead' && ($data['leadDetails'][0]['priority_id'] == $priority[$i]['id']))
													{
														$selected = "selected='selected'";
													}
												?>
                                                <option value="<?php echo $priority[$i]['id']; ?>" <?php echo $selected; ?>><?php echo $priority[$i]['value']; ?></option>
                                                <?php	
												}
												?>
                                            </select>
                                         </li>
                                         <li id="sub-status" style="display:none">   
                                            <label for="sub-status">Substatus <span>*</span></label>
                                           	<select id="sub-status-select" name="sub-status"></select>  
                                             <!-- </div> -->
                                        </li> 
                                        <li>
                                        	<label for="lead-phone">Number of meetings<span></span></label>
                    						<input type="text" id="number_of_meeting" name="number_of_meeting" value='<?php  if($function == 'edit_lead') { echo $data['leadDetails'][0]['number_of_meeting'];  }?>'/>
                                            <label for="potential">Potential<span></span></label>
                    						<input type="text" id="potential" name="potential" value='<?php  if($function == 'edit_lead') { echo $data['leadDetails'][0]['potential'];  }?>'/>
                                        </li>
                                        <li>
                                            <label for="lead_notes">Notes</label>
                                            <textarea id="lead_notes" name="lead_notes"></textarea>
                                        </li>
                                        
                                        
                                        
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_lead') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateLead('<?=$data['leadDetails'][0]['lead_id']?>','leads','edit_lead_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addLead('leads','add_lead')" >
                                           <? } ?>
                                            <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('leads','view_leads')" /> 
                                        </li>

									</ul>
							</div>
                           
							<? //var_dump($data['leadnoteDetails']);exit;
								if($function == 'edit_lead' && count($data['leadNoteDetails'])!=0)
								{ ?>
									<div style="width:65%;margin:auto;">
                                    <h2 style="margin-bottom:0;">Notes</h2>
                                    <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                    <thead>
                                    <tr>
                                            <th style="width:60px;">Sr. No</th>
                                            <th>Note</th>
                                     </tr>
                                     </thead>
                                    <tbody>
                                    <? for($i=0;$i<count($data['leadNoteDetails']);$i++)
                                        {	?>
                                            <tr>
                                            <td style="width:60px;"><?=$i+1 ?></td><td style="text-align:left;"><?=stripslashes($data['leadNoteDetails'][$i]['notes']) ?></td></tr>
                                            </tr>
                                     <? } ?>
                                    </tbody>
                                    </table>
									</div>
                                <? } ?>
                            
                           
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   
                   <script type="text/javascript">
						$(document).ready(function(e) {
                   <? if($function == 'edit_lead') { ?>
							getSubStatusOfLead("leads","get_substatus_ajax",<? echo $data['leadDetails'][0]['status_id']; ?>,<? echo $data['leadDetails'][0]['substatus_id']; ?>);
							$("#sub-status").show();
							$('#sub-status-select option[value="<? echo $data['leadDetails'][0]['substatus_id']; ?>"]').attr('selected','selected');
							$("#sub-status-select").change();
                  
							$("#initial_contact_date").datepicker('setDate', parseISO8601(<?	
									echo "\"".$data['leadDetails'][0]['initial_contact_date']."\"";
							?>)); 
							
							$("#initial_contact_date").datepicker('setDate', parseISO8601(<?	
									echo "\"".$data['leadDetails'][0]['initial_contact_date']."\"";
							?>)); 
							
							$("#followup_date").datepicker('setDate', parseISO8601(<?	
									echo "\"".$data['leadDetails'][0]['followup_date']."\"";
							?>)); 
							
							$("#followup_date").datepicker('setDate', parseISO8601(<?	
									echo "\"".$data['leadDetails'][0]['followup_date']."\"";
							?>)); 
							
							$("#conversion_date").datepicker('setDate', parseISO8601(<?	
									echo "\"".$data['leadDetails'][0]['conversion_date']."\"";
							?>)); 
							
							$("#initial_meeting_date").datepicker('setDate', parseISO8601(<?	
									echo "\"".$data['leadDetails'][0]['initial_meeting_date']."\"";
							?>));
							
						 <? } ?>	
							$("#status").change(function(){
								var status_selected = $("#status").find(":selected").val();
								getSubStatusOfLead("leads","get_substatus_ajax",status_selected,0);
								$("#sub-status").show('slow');
							});   
						});
				  </script>