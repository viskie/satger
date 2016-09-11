<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
	exit();
}
?>

                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="singlecolm_form" >
							 <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                                <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                              <? }  else  if($notificationArray['type'] == "Failed") { ?>
                              <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                              <?   } } ?>

                            <!-- Messages -->
                         
                            <h2>Set Leave Settings</h2>
                            
                            <div class="body-con">

                                    <ul class="align-list">
                                       
                                        <li>
                                        <label for="sick_leave">Sick Leave <span>*</span></label>
                                          <input type="text" id="sick_leave" name="sick_leave"  value='<? echo $data['sickLeave'];?>' />
                                        </li>
                                        <li>
                                        <label for="casual_leave">Casual Leave <span>*</span></label>
                                          <input type="text" id="casual_leave" name="casual_leave"  value='<? echo $data['casualLeave'];?>' />
                                        </li>
                                        <li>
                                        <label for="paid_leave">Paid Leave  <span>*</span></label>
                                          <input type="text" id="paid_leave" name="paid_leave"  value='<? echo $data['paidLeave'];?>' />
                                        </li>
                                        <li>
                                            <label></label>
                                            <input type="button" value="Update" class="green_button"  onclick="javascript:updateLeaveSettings('settings','update_leave_setting')" />

                                        </li>
                                        
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                            </div>
                            
                        </div>
                       </div>