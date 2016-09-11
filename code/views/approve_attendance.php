<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
$i=1;
?>
<input type="hidden" name="edit_id" value="" id="edit_id" />

					<!-- Content -->
					<div id="content" class="clearfix">

                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
            
                       


                        <!-- Main Content -->
                        <div id="main-content">
                            <!-- All Users -->
                            <h2>Nonapproved Attendance (<?=sizeof($data['nonApprovedAttendance'])?>)</h2>
                                                       
                            <div class="body-con">   
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Name</th>
                                        <th>Date</th>
                                        <th>In Time</th>
                                        <th>Out Time</th>
                                        <th>Working Hours</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   foreach($data['nonApprovedAttendance'] as $value)
									   {
										   ?>
										    <tr>
                                            	<td><?=$value['name'] ?></td>
												<td><?=formatDate(date('Y-m-d',strtotime($value['in_time']))) ?></td>
												<td><? echo formatDate(date('Y-m-d',strtotime($value['in_time'])))." ".date('H:i:s',strtotime($value['in_time'])) ?></td>
                                                <td><? echo formatDate(date('Y-m-d',strtotime($value['out_time'])))." ".date('H:i:s',strtotime($value['out_time'])) ?></td>
                                                <?php
												$new_diff = secondsToTime($value['seconds'],true);
												$w_h =   $new_diff['h'].":". $new_diff['m'].":". $new_diff['s'];
												?>
												<td><?=$w_h ?></td>
												
												<td nowrap="nowrap"><a href="javascript:updateApprove('<?=$value['attendance_id']?>','hrm','update_approve')" class="tiptip-top" title="Approve"><img src="img/icon_ok.png" alt="approve" /></a>
														  &nbsp;&nbsp;&nbsp;<a href="javascript:updateApprove('<?=$value['attendance_id']?>','hrm','show_update_time')" class="tiptip-top" title="Edit Time"><img src="img/icon_edit.png" alt="edit_time"></a>
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
                        
                         <!-- Main Content --><div id="main-content" style="margin-top:30px;">
                            <!-- All Leaves -->
                            <h2>All Leaves (<?=sizeof($data['leaveDetails'])?>)</h2>
                            
                            <div id="rejection_id" style="display:none">
                            	<span>Please specify the reason for rejection</span>
                            	<textarea name="reject_reason"></textarea>
                            </div>   
                             <div class="body-con">   
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th>Employee Name</th>
                                        <th>Leave Type</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>No Off Days</th>
                                        <th>Reason</th>	
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   foreach($data['leaveDetails'] as $value)
									   {
										   ?>
										    <tr>
                                            	<td ><?=$i; ?></td>
                                                <? $diff = date_diff(new DateTime($value['from_date']),new DateTime($value['to_date'])); ?>
												<td>
												<? 
													$show = $value['employee_name'];
													if($value['leave_type'] == "sick"){
														$show.="(".($data['sickLeave']-$diff->d).")";
													}
													else if($value['leave_type'] == "casual"){
														$show.="(".($data['casualLeave']-$diff->d).")";
													}
													else if($value['leave_type'] == "paid"){
														$show.="(".($data['paidLeave']-$diff->d).")";
													}
													echo $show;
												?>
                                                </td>
                                                <td><?=ucfirst($value['leave_type']); ?></td>
                                                <td><?=formatDate($value['from_date']); ?></td>
												<td><?=formatDate($value['to_date']); ?></td>
                                                <td><?=$diff->d?></td>
                                                <td><?=$value['leave_reason']; ?></td>
                                                <? if($value['leave_status'] == 0){ ?>
                                               <td nowrap="nowrap"><img id="approve_<?=$value['applied_leave_id']?>" src="img/icon_ok.png" alt="edit" style="width:20px" onclick="approveAppliedLeave('<?=$value['applied_leave_id']?>','hrm','approve_applied_leave_ajax')"/>
														  &nbsp;&nbsp;&nbsp;<img id="reject_<?=$value['applied_leave_id']?>" src="img/icon_bad.png" class="reject" alt="delete" style="width:20px" onclick="openColorbox('<?=$value['applied_leave_id']?>');">
												</td>
                                             	<? }else if($value['leave_status'] == 1){ ?>
  														<td><img id="reject_<?=$value['applied_leave_id']?>" src="img/icon_bad.png" class="reject" alt="delete" style="width:20px" onclick="openColorbox('<?=$value['applied_leave_id']?>');"></td>			                                
												<? }else{ ?>
                                                	<td><img id="approve_<?=$value['applied_leave_id']?>" src="img/icon_ok.png" alt="edit" style="width:20px" onclick="approveAppliedLeave('<?=$value['applied_leave_id']?>','hrm','approve_applied_leave_ajax')"/></td>        
                                               	<? } ?>         
											</tr>								   
										   <?
										   $i++;
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
