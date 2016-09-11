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

                            <!-- All Leaves -->
                            <h2>All Leaves (<?=sizeof($data['applyLeaveDetails'])?>)</h2>
                            
                            
                             <div class="body-con">    
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
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
									   foreach($data['applyLeaveDetails'] as $value)
									   {
										   ?>
										    <tr>
                                            	<td ><?=$i; ?></td>
												<td><?=ucfirst($value['leave_type']); ?></td>
												
												<td><?=formatDate($value['from_date']); ?></td>
												<td><?=formatDate($value['to_date']); ?></td>
                                                <? $diff = date_diff(new DateTime($value['from_date']),new DateTime($value['to_date'])); ?>
                                                <td><?=$diff->d?></td>
                                                <td><?=$value['leave_reason']; ?></td>
                                                <? 
													$current_day = strtotime(date('Y-m-d')); 
													$from_day = strtotime($value['from_date']);
													
												?>
                                                <? if($current_day < $from_day) {?>
												<td nowrap="nowrap"><a href="javascript:editAppliedLeave('<?=$value['applied_leave_id']?>','hrm','edit_apply_leave')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
														  &nbsp;&nbsp;&nbsp;<a href="javascript:deleteAppliedLeave('<?=$value['applied_leave_id']?>','hrm','delete_applied_leave')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
												</td>
                                             	<? }else{ echo"<td>NA</td>"; }  ?>
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
