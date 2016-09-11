<?
//echo "<pre>"; print_r($data);
?>
<?  

if($function == 'edit_client') {    ?> 
<input type="hidden" name="client_id" id="client_id" value="<?=$data['clientDetails']['client_id']?>" />
<input type="hidden" name="user_id" id="user_id" value="<?=$data['userDetails']['user_id']?>" />
<? } ?>
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function=='show_add_client') { echo "Add Client"; } else { echo "Edit Client";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
											<label>Business Name <span>*</span></label>
                                            <input type="text" id="client_biz_name" name="client_biz_name"  value='' />
										
											<label>Client Name <span>*</span></label>
                                            <input type="text" id="client_name" name="client_name"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Email <span>*</span></label>
                                            <input type="text" id="client_email" name="client_email"  value='' />
										
											<label for="adduser-username">Phone <span>*</span></label>
                                            <input type="text" id="client_phone" name="client_phone"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Address <span></span></label>
                                            <textarea id="address" name="address"></textarea>
										
											
											<label for="adduser-username">City <span></span></label>
                                            <input type="text" id="city" name="city"  value='' />
										<li>
											<label for="adduser-username">Zip <span></span></label>
                                            <input type="text" id="zip" name="zip"  value='' />
										
											<label for="adduser-username">State <span></span></label>
                                            <input type="text" id="state" name="state"  value='' />
										</li>
										<li>
											<label for="adduser-username">Country <span></span></label>
                                            <input type="text" id="country" name="country"  value='' />
										
											<label for="adduser-username">Status <span></span></label>
											<select id="status" name="status" value="status">
												<option value="Active" selected="selected">Active</option>
												<option value="InActive">InActive</option>
												<option value ="Disabled">Disabled</option>
											</select>
                                         </li>

										<li>
                                            <label for="remarks">Remarks/Notes <span></span></label>
                                            <textarea id="remarks" name="remarks" ><? if($function == 'edit_client'){ echo $data['clientDetails']['remarks']; }?></textarea>
                                            
										</li>
										<li>
                                            <label></label>
                                            <?  if($function == 'edit_client') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateClient('<?=$data['clientDetails']['client_id']?>','clients','edit_client_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addClient('clients','add_client')" >
                                           <? } ?>
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('clients','view')" /> 
                                        </li>
									</ul>
							</div>
                           <!-- <h3> Admin User for the Client</h3>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label for="adduser-username">Username <span>*</span></label>
                                            <input type="text" id="user_name" name="user_name"  value='' />
                                            <span class="msg-form-info">Alphanumeric characters only!</span>
                                        </li>
                                        <li>
                                            <label for="adduser-email">Email <span>*</span></label>
                                          <input type="text" id="user_email" name="user_email"  value='' />
                                        </li>
                                        <li>
                                            <label for="adduser-password">Password <span>*</span></label>
                                            <input type="password" id="user_password" name="user_password" />
                                            <span class="msg-form-info">At least 6 characters!</span>
                                        </li>
                                        <li>
                                            <label for="adduser-firstname">Name</label>
                                            <input type="text" id="name" name="name"  value='' />
                                        </li>
                                        <li>
                                            <label for="adduser-info">Phone</label>
                                             <input type="phone" id="user_phone" name="user_phone"  value='' />
                                        </li>
                                        <li>
                                            <label for="adduser-birthdate">Role</label>
											<select name="user_group" id="user_group">
												<option value='3'>Client Admins</option>
											</select> 
                                        </li>
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_client') {    ?>     
                                             <input type="button" value="Update" class="green"  onclick="javascript:updateClient('< ?=$data['clientDetails']['client_id']?>','clients','edit_user_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green"  onclick="javascript:addClient('clients','add_client')" >
                                           <? } ?>
                                        </li>
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                        <!--    </div> -->
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_client') {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
								<? foreach($data['clientDetails'] as $key=>$value ) { 
										$value=shownlInjs($value);
								?>
										$('#<?=$key;?>').val('<?=($value)?>');
								<? } ?>	
								
											
						});
                   </script>
                   
                   <? } ?>
                   
                   
