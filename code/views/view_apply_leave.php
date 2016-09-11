<?
if($function == 'edit_apply_leave') {   
?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['applyLeaveVariables']['applied_leave_id']?>" />
<? 
}

//echo "<pre>"; print_r($data);
?>
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                         <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                            <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                         <? }  else  if($notificationArray['type'] == "Failed") { ?>
                         	<div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                         <?   } } ?>
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function=='edit_apply_leave') { echo "Edit Applied Leave"; } else { echo "Apply For Leave";} ?></h2>
                            <a href="javascript:callPage('hrm','view_applied_leaves');" style="float: right;margin-right: 16px;">View Applied Leaves</a>
                            <div class="body-con" style="clear:both">

                                    <ul class="align-list">
                                    	
                                        <li>
                                            <label>From Date <span>*</span></label>
                                            <input type="text" id="leave_from_date"  value="<? if($function == "edit_apply_leave" || $is_exist == true){ echo $data['applyLeaveVariables']['from_date'];}?>"/>
                                            <input type="hidden" id="leave_from_date_alt" name="leave_start_date" />

										
											<label>To Date <span>*</span></label>
                                            <input type="text" id="leave_to_date"  value="<? if($function == "edit_apply_leave" || $is_exist == true){ echo $data['applyLeaveVariables']['to_date'];}?>"/>
                                            <input type="hidden" id="leave_to_date_alt" name="leave_to_date" />

										</li>
                                        <li>
                                        	<label>Leave Type <span>*</span></label>
                                        	<? if($function=='edit_apply_leave' || $is_exist == true) {?>
                                            	<select id="leave_type" name="leave_type">
                                            	<option value="0">Please select</option>.
                                            	<option value="sick" <? if($data['applyLeaveVariables']['leave_type'] == "sick"){?> selected="selected" <? } ?>>Sick Leave</option>
                                                <option value="casual" <? if($data['applyLeaveVariables']['leave_type'] == "casual"){?> selected="selected" <? } ?>>Casual Leave</option>
                                                <option value="paid" <? if($data['applyLeaveVariables']['leave_type'] == "paid"){?> selected="selected" <? } ?>>Paid Leave</option>
                                            </select>
                                            <? }else{ ?>
                                            <select id="leave_type" name="leave_type">
                                            	<option value="0">Please select</option>.
                                            	<option value="sick">Sick Leave</option>
                                                <option value="casual">Casual Leave</option>
                                                <option value="paid">Paid Leave</option>
                                            </select>
                                            <? } ?>
                                        
                                            <label>Reason For Leave <span>*</span></label>
                                            <textarea id="leave_reason" name="leave_reason"><? if($function == "edit_apply_leave" || $is_exist == true){ echo $data['applyLeaveVariables']['leave_reason'];}?></textarea>

										</li>
                                        
                                        
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_apply_leave') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateAppliedLeave('<?=$data['applyLeaveVariables']['applied_leave_id']?>','hrm','edit_applied_leave_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addApplyLeave('hrm','add_apply_leave')" >
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('hrm','apply_for_leave')" /> 
                                           <? } ?>
                                        </li>

									</ul>
							</div>                            
                        </div>
						</div>         
<script>
<?  if($function == 'edit_apply_leave' || $is_exist == true) {    ?>
	$(document).ready(function(e) {
		$("#leave_from_date").datepicker('setDate', parseISO8601(<?	
				echo "\"".$data['applyLeaveVariables']['from_date']."\"";
		?>)); 
		
		$("#leave_to_date").datepicker('setDate', parseISO8601(<?	
				echo "\"".$data['applyLeaveVariables']['to_date']."\"";
		?>));   
	});
<? } ?>	
</script>
                        