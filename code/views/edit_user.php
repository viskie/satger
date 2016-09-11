<?
//echo "<pre>"; print_r($data);

?>
<input type="hidden" name="user_id" id="user_id" value="<?=$data['userDetails']['user_id']?>" />
                        <!-- Main Content -->
						<div id="content" class="clearfix">
							 <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                                <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                              <? }  else  if($notificationArray['type'] == "Failed") { ?>
                              <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                              <?   } } ?>
                        <div id="main-content">


                            <!-- Messages -->
                         
                            <h2>Edit User</h2>
                            
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label for="adduser-username">Username <span>*</span></label>
                                            <input type="text" id="user_name" name="user_name"  value='<?=$data['userDetails']['user_name']?>' />
                                            <span class="msg-form-info">Alphanumeric characters only!</span>
                                        </li>
                                        <li>
                                            <label for="adduser-email">Email <span>*</span></label>
                                          <input type="text" id="user_email" name="user_email"  value='<?=$data['userDetails']['user_email']?>' />
                                        </li>
                                        <li>
                                            <label for="adduser-password">Password <span>*</span></label>
                                            <input type="password" id="user_password" name="user_password" value="********" />
                                            <span class="msg-form-info">At least 6 characters!</span>
                                        </li>
                                        <li>
                                            <label for="adduser-firstname">Name</label>
                                            <input type="text" id="name" name="name"  value='<?=$data['userDetails']['name']?>' />
                                        </li>
                                        <li>
                                            <label for="adduser-info">Phone</label>
                                             <input type="text" id="user_phone" name="user_phone"  value='<?=$data['userDetails']['user_phone']?>' />
                                        </li>
                                        <li>
                                            <label for="adduser-birthdate">Role</label>
                                           <? //getGroupCombo('role','user_group') ;
										   createComboBox('user_group','group_id','group_name', $data['allGroups'],false,$data['userDetails']['user_group']);
										   //createComboBox($role,$value,$display, $data, $blankField=false, $selectedValue="",$display2="",$firstFieldValue='Please Select', $otherParameters = "");
										   ?>
                                        </li>
                                        <li>
                                            <label></label>
                                            <input type="button" value="Submit" class="green_button"  onclick="javascript:editUser('users','edit_user_entry')" />
											<input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('users','view')" />
                                        </li>
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                            </div>
                            
                        </div>
						</div>
                        <!-- END Main Content -->
						