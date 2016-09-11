<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
extract($data);
//var_dump(count($allProjects));exit;
?>
					<!-- Content -->
					<div id="content" class="clearfix">
                    
                    <input type="hidden" name="edit_id" value="" id="edit_id" />
                    <input type="hidden" name="show_status" id="show_status" value="<?php if((isset($current_show) && $current_show == 0) ) echo '0';
                                                                                          elseif(($current_show == 1)|| !isset($current_show)) echo '1';
                                                                                          elseif($current_show == 2) echo '2';
                                                                                    ?>" />
                      <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                        <!-- Main Content -->
                        <div id="main-content">
                            <!-- All Users -->
                            <h2>All Candidates (<?=count($allCandidates)?>)</h2>
                            
                             <!-- div for filters -->
                            <div style="margin-bottom: 16px;">
                            <input type="hidden" name="is_post_back" id="is_post_back" value="FALSE" />
                           
                           	<label style="width: 65px;">Status</label>
                            <?php 
								if(isset($data['status']))
									createComboBox('status','status_id','status_name',$data['allstatus'],TRUE,$data['status'],'','All','class="less_width"'); 
								else
									createComboBox('status','status_id','status_name',$data['allstatus'],TRUE,'','','All','class="less_width"');		
							?>
                           
                            
                            <label style="width: 65px;">Position</label>
                            <?php 
								if(isset($data['position']))
									createComboBox('position','position_id','position_name',$data['allposition'],TRUE,$data['position'],'','All','class="less_width"'); 
								else
									createComboBox('position','position_id','position_name',$data['allposition'],TRUE,'','','All','class="less_width"');		
							?>
                            
                            <!--<label style="width: 65px;">Position</label>
                            <select name="priority">
                            	<option value=""></option>
                            </select>-->
                            
                            <input style="margin-left: 83px;" type="button" name="report_submit" value="Submit" id="report_submit" class="green_button" onclick="$('#is_post_back').val('TRUE');callPage('hrm','view_candidates');">

                            </div>
                            
                            <div style="position:relative">
                            <div class="show_links" style="top: 23px;">
                                <a href="javascript:show_records(0,'hrm','view_candidates');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'hrm','view_candidates');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'hrm','view_candidates');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                             <a href="javascript:callPage('hrm','show_add_candidate');" class="for_links" style="top: 23px;">Add Candidate</a>               
                            
                            <div class="body-con">   
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th style="width:50px;">Sr. No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th class="date_col" style="width: 126px;">Interview Date</th>    
                                        <th style="text-align:left">Position</th>
                                        <th>Experience</th>
                                        <th>Current CTC</th>
                                        <th>Expected CTC</th>
                                        <th>Status</th>
                                        <th style="width: 70px;">Priority</th>
                                        <th style="width: 74px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
								   for($i=0;$i<count($allCandidates);$i++)
									   {?>
										    <tr>
                                            	<td><?=$i+1; ?></td>
                                                <td><?=$allCandidates[$i]['name']; ?></td>
                                                <td><?=$allCandidates[$i]['email']; ?></td>
												<td><?=$allCandidates[$i]['phone_number']; ?></td>
                                                <td><?=formatDateTime($allCandidates[$i]['interview_date_time']); ?></td>
												<td style="text-align:left" ><?=$allCandidates[$i]['position_name']; ?></td>
                                                <td><?=$allCandidates[$i]['experience']; ?></td>
                                                <td><?=$allCandidates[$i]['current_ctc']; ?></td>
                                                <td><?=$allCandidates[$i]['expected_ctc']; ?></td>
												<td><?=$allCandidates[$i]['status_name']; ?></td>
												<td>
                                                	<input type="text" name="priority" class="priority" value="<?=$allCandidates[$i]['priority']; ?>" style="width: 67px;" onblur="changePriority(<?php echo $allCandidates[$i]['id']; ?>,this.value)"/>
                                                </td>
											
                                                <td style="width:65px">
												<?php if($allCandidates[$i]['is_active'] != 0) {?>
                                                <a href="javascript:openEditCandidate(<?php echo $allCandidates[$i]['id']; ?>,'hrm','edit_candidate')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                &nbsp;
                                                <a href="javascript:openDeleteCandidate(<?php echo $allCandidates[$i]['id']; ?>,'<?php echo $allCandidates[$i]['name']; ?>','hrm','delete_candidate')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allCandidates[$i]['id']; ?>,'hrm','restore_candidate')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
                                                <?php } ?>
                                                <?php if($allCandidates[$i]['resume'] != ''){ ?>
                                                &nbsp;&nbsp;<a href="javascript:downloadFile('<?php echo $allCandidates[$i]['resume']; ?>','hrm','download_resume')" class="tiptip-top" title="Download Resume"><img src="img/arrow_down.png" alt="Download Resume" ></a>
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
                        </div>
                        <!-- END Main Content -->
					</div>
					<!-- END Content -->
<script type="text/javascript">
$(document).ready(function(e) { 
});

function changePriority(id,current_val){
	$.ajax({
		url:"ajax.php",
		type:"POST",
		data:"page=hrm&function=change_priority&id="+id+"&current_val="+current_val,
		success:function(resp){

		}
	});
}
</script>