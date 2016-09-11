<?
//var_dump( $data['functionDetails']);exit;

?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['functionDetails']['function_id']?>" />
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content">


                            <!-- Messages -->
                         	<?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                             	<div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                           	<? }  else  if($notificationArray['type'] == "Failed") { ?>
                            	<div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                            <?   } } ?>
                            <h2>Edit Function</h2>
                            
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                             <label for="function_name">Function Name</label><span style="color:red"> *</span>
                                            <input type="text" id="function_name" name="function_name"  value='<?=$data['functionDetails']['function_name']?>'/>
                                            
                                            <label for="friendly_name">Function Friendly Name</label><span style="color:red"> *</span>
                                            <input type="text" id="friendly_name" name="friendly_name"  value='<?=$data['functionDetails']['friendly_name']?>'/>  
                                        </li>
                                        <li>    
                                            <label for="page_id">Page</label><span style="color:red"> *</span>
											<?
                                            createComboBox('page_id','page_id','module_name', $data['AllPages'],true,$data['functionDetails']['page_id']);
                                             ?>           
                                        </li>
                                       
                                        <li>
                                            <label></label>
                                          <input type="button" value="Submit" class="green_button"  onclick="javascript:updateFunction('<?=$data['functionDetails']['function_id'] ?>','settings','edit_function_entry')" />
                                            
                                            <!--<button value="Submit" class="green"  onclick="javascript:chkProjectCategory()">Update</button> -->

                                        </li>
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                            </div>
                            
                        </div>
						</div>
                        <!-- END Main Content -->