<script src="js/DateTimePicker.js"></script>
<?
if($function == 'edit_candidate' || $function == 'view_candidates') {   
?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['candidateDetails']['id']?>" />
<? 

 }
//var_dump($data['projectDetails']);exit;
//echo "<pre>"; print_r($data);
?>


                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function=='show_add_candidate') 
										{ echo "Add Candidate"; } 
									else if ($function=='edit_candidate')
									 { echo "Edit Candidate";} 
								?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label for="name">Name : <samp>*</samp> </label>
                                            <input type="text" id="name" name="name"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['name']; }?>'/>
											
                                            <label for="interview_date_time">Interview Date Time : <samp></samp></label>
                                            <input type="text" id="interview_date_time" name="interview_date_time"  value="<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['interview_date_time']; }?>" />									
                                            <input type="hidden" id="interview_date_time_alt" name="interview_date_time_alt" size="30" />
										</li>
                                        <li>
                                        	<label for="interviewed_by">Interviewed By: </label>
                                            <input type="text" id="interviewed_by" name="interviewed_by"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['interviewed_by']; }?>'/>
                                            
                                            <label for="position">Postion: </label>
                                            <?
												if($function=='show_add_candidate')
											  	{// $details = $clientObject->getAllClients();
                                               	createComboBox('position','position_id','position_name',$data['allposition'],true);
											  	}
												if( $function=='edit_candidate')
											  	{// $details = $clientObject->getAllClients();
                                               	createComboBox('position','position_id','position_name',$data['allposition'],true,$data['candidateDetails']['position']);
											  	}
											  
											?>
                                        </li>
                                        <li>
                                        	 <label for="experience">Experience: <samp>*</samp></label>
                                             <input type="text" id="experience" name="experience"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['experience']; }?>'/>
                                             
                                             <label for="previous_company">Previous Company:<samp>*</samp> </label>
                                             <input type="text" id="previous_company" name="previous_company"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['previous_company']; }?>'/>
                                        </li>
                                        
                                        <li>
                                        	<label for="phone_number">Phone Number: </label>
                                            <input type="text" id="phone_number" name="phone_number"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['phone_number']; }?>'/>
                                            <label for="phone_number">Reference: </label>
                                            <input type="text" id="reference" name="reference"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['reference']; }?>'/>
                                        </li>
                                        
                                        <li>
                                        	<label for="current_ctc">Current CTC: </label>
                                            <input type="text" id="current_ctc" name="current_ctc"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['current_ctc']; }?>'/>
                                            
                                            <label for="expected_ctc">Expected CTC: </label>
                                            <input type="text" id="expected_ctc" name="expected_ctc"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['expected_ctc']; }?>'/>
                                        </li>
                                        
                                        <li>
                                        	<label for="notice_period">Notice Period: </label>
                                            <input type="text" id="notice_period" name="notice_period"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['notice_period']; }?>'/>
                                            
                                            <label for="email">Email : </label>
                                            <input type="text" id="email" name="email"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['email']; }?>'/>
                                        </li>
                                        
                                        <li>
                                        	<label for="score">Score: </label>
                                            <input type="text" id="score" name="score"  value='<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['score']; }?>'/>
                                            
                                            <label for="status">Status: </label>
                                           	<?
												if($function=='show_add_candidate')
											  	{// $details = $clientObject->getAllClients();
                                               		createComboBox('status','status_id','status_name',$data['allstatus'],true);
											  	}
												if( $function=='edit_candidate')
											  	{// $details = $clientObject->getAllClients();
                                               		createComboBox('status','status_id','status_name',$data['allstatus'],true,$data['candidateDetails']['status']);
											  	}
											  
											?>
                                        </li>
                                        
                                        <li>
                                        	<label for="remarks">Remarks/Notes : <span></span></label>
                                            <textarea id="remarks" name="remarks"><? if($function == 'edit_candidate'){ echo $data['candidateDetails']['remarks']; }?></textarea>
                                            
                                            <label for="resume">Attache Resume : <span>*</span></label>
                                            <input type="file" name="resume" id="resume" value="" />
											<? if($function == 'edit_candidate'){ echo $data['candidateDetails']['resume']; ?>
                                            	<input type="hidden" name="old_resume" value="<? echo $data['candidateDetails']['resume']; ?>" />
                                            <? }?>
                                        </li>
                                        
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_candidate') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateCandidate('<?=$data['candidateDetails']['id']?>','hrm','edit_candidate_entry')" >
                                            <? } else if($function == 'show_add_candidate') { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addCandidate('hrm','add_candidate')" >
                                           <? } else
										   {
											   ?>
                                               <input type="button" value="Edit Details" class="green_button"  onclick="javascript:openEditCandidate('<?=$data['candidateDetails']['id']?>','hrm','edit_candidate')"  >
                                               <?
										   }
										   ?>
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('hrm','view_candidates')" /> 
                                        </li>

									</ul>
							</div>                            
                            
                          
                        </div>
						</div>
                        <!-- END Main Content -->
                       
                   <script type="text/javascript">
						$(document).ready( function () {
							$("#interview_date_time").datetimepicker(
								{ dateFormat: 'yy-mm-dd', 
									timeFormat: 'hh:mm:ss tt',
									ampm: true
								}
							); 
						});
                   </script>
                  