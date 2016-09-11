<script>
$(document).ready(function(e) {
$("#in_button").click(function(){
	$("#login_text").slideToggle();
   	$("#update_notes").show();
	$("#save_button").slideToggle();

});

$("#out_button").click(function(){
	$("#logout_text").slideToggle();
	 $("#update_notes").show();

});
});
</script>
<? 
$status = '';

//var_dump($data['latest']);exit;
//echo date('Y-m-d',strtotime($data['latest']['in_time'])); exit;
//echo date('Y-m-d');exit;

if($data['latest']['out_time']=='0000-00-00 00:00:00')
{
	$status = "not logout";
}
else if(date('Y-m-d',strtotime($data['latest']['in_time'])) != date('Y-m-d'))
{
	$status = "not login";
}
else
{
	$status = "logout";
}




?>

                        <!-- Main Content -->
						<div id="content" class="clearfix singlecolm_form">
                        
                        <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                      
                       <!-- <div id="main-content">-->
                            
                            <!-- Messages -->
                         
                           
                             <div id="main-content">
                                <h2>Attendance</h2>
                                <a href="javascript:callPage('hrm','my_report');" class="for_links" style="right:30px;">My Attendance Report</a>
                             </div>
                               
                            <div class="body-con">
                            	<div style="margin-top:50px;">
                                
                                <?
								if($status == 'not login')
								{
									?>
                                    <label>Current Time </label><label><span id="clock1" style="color:black">&nbsp;</span></label><br/>
                                    <label>Notes</label><textarea name="notes" id="notes" ></textarea><br/>
                                    <label></label><input type="button"  class="green_button" name="status_button" value="Log In" onclick="javascript:updateAttendance('hrm','log_in')" />
                                    <?
								}
								if($status == 'not logout')
								{
									?>
                                    <label>Login Time </label><label><?=date("j-M-Y H:i:s", strtotime($data['user_details']['in_time'])) ?></label>
                                    &nbsp;&nbsp;&nbsp;<input type="button"  class="green_button" value="Login Notes" id="in_button" style="width:100px"/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="in_notes" id="login_text" style="display:none"><?=$data['user_details']['in_notes']?></textarea>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  class="green_button" value="Save Note" id="save_button" style="width:100px;display:none" onclick="javascript:updateAttendance('hrm','save_inNotes')"/>
                                    <br/>
                                    <label>Current Time </label><label><span id="clock1" style="color:black">&nbsp;</span></label><br/>
                                    <label>Logout Notes</label><textarea name="notes" id="notes" ></textarea>
                                    
                                    <br/>
                                    <label></label><input type="button"  class="green_button" name="status_button" value="Log Out" onclick="javascript:updateAttendance('hrm','log_out')" />
                                    <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('hrm','attendance')" /> 
                                    <?
								}
								if($status == 'logout')
								{	$diff = date_diff(new DateTime($data['user_details']['out_time']),new DateTime($data['user_details']['in_time']));
//									var_dump($diff);
									
								
									?>
                                   
                                  	<label>Login Time </label><label><?=date("j-M-Y H:i:s", strtotime($data['user_details']['in_time'])) ?></label>
                                    &nbsp;&nbsp;&nbsp;<input type="button"  class="green_button" value="Login Notes" id="in_button" style="width:100px"/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="login_text" id="login_text" style="display:none"><?=$data['user_details']['in_notes']?></textarea><br/>
                                    
                                    <label>Logout Time </label><label><?=date("j-M-Y H:i:s", strtotime($data['user_details']['out_time'])) ?></label>
                                    &nbsp;&nbsp;&nbsp;<input type="button"  class="green_button" value="Logout Notes" id="out_button" style="width:100px"/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="logout_text" id="logout_text" style="display:none"><?=$data['user_details']['out_notes']?></textarea><br/>
                                    
                                    <label>Current Time </label><label><span id="clock1" style="color:black">&nbsp;</span></label><br/>
                                    <label>Working Time(h:m:s)</label>
                                    <label>
                                    <?
                                    if($diff->y=='0' && $diff->m=='0' && $diff->d=='0'){
										echo($diff->h.":".$diff->i.":".$diff->s);
									}else{
										echo ("Working hours problematic!");
									}
									?>
                                    </label><br/>
                                    <?
									if($diff->h > 10)
									{?>
										<label>Sent for Approval !</label><br/>
                                      <?
									}
									?>
                                    <div id="update_notes" style="text-align:center;display:none"><input type="button"  class="green_button" name="status_button" value="Update Notes" onclick="javascript:updateAttendance('hrm','update_notes')" />
                                    
                                    </div>
                                    
                                    <?
								}
								?>
                            
								</div>
                                    
							                           
                            
                           
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   
                   
                   
