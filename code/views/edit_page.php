<?
//echo "<pre>"; print_r($data);
 //var_dump($data['page_Details']);exit;
?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['page_Details']['page_id']?>" />
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content">


                            <!-- Messages -->
                         		<?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                                <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                              <? }  else  if($notificationArray['type'] == "Failed") { ?>
                              <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                              <?   } } ?>
                            <h2>Edit Page</h2>
                            
                            <div class="body-con">

                                    <ul class="align-list">
                                     
                                     <li>
                                     <label for="description">Page Description</label><span style="color:red"> *</span>
                                    <input type="text" id="description" name="description" />
                                    </li>
                                    <li>
                                    <label for="module_name">Module Name</label><span style="color:red"> *</span>
                                    <input type="text" id="module_name" name="module_name" />
                                    </li>
                                    <li>
                                    <label for="title">Page Title</label><span style="color:red"> *</span>
                                    <input type="text" id="title" name="title" />
                                    </li>
                                    <div style="display:none">
                                    <li>
                                    <label for="level">Page Level</label>
                                    <select name="level" id="level">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    </select>
                                    </li>
                                    <li>
                                    <div id="parent_page" >
                                    <label for="parent_page_id">Parent Page</label>
                                    <select name="parent_page_id" id="parent_page_id">
                                    
                                    </select>
                                    </div>
                                     </li>
                                     </div>
                                     <li>
                                     <label for="tab_order">Tab Order</label>
                                    <select name="tab_order" id="tab_order">
                                    <?
									for($i=1;$i<=20;$i++)
									{
										?>
                                        <option value="<?=$i; ?>"><?=$i ?></option>
                                        <?
									}
									?>
                                    </select>
                                    </li>
                                    <li>
                                    <label for="is_crud">CRUD Page</label>
                                    <!--<select name="is_crud" id="is_crud">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    </select>-->
                                    <input type="checkbox" name="is_crud"  
									<? 
									if($data['page_Details']['is_crud']==1)
									{ echo "checked value=1"; 
										
									}
									else
									{
										echo "value=0";
									}?>>
                                    </li>
                                    <li>
                                    <label for="file">Module Image</label>
                                    <input type="file" name="file" id="file" size="40">
                                    </li>
                                      <li>
                                            <label></label>
                                          <input type="submit" value="Update" class="green"  onclick="return updatePage('<?=$data['page_Details']['page_id'] ?>','settings','edit_page_entry')"/>
                                     
                                            <!--<button value="Submit" class="green"  onclick="javascript:chkProjectCategory()">Update</button> -->

                                        </li>
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                            </div>
                            
                        </div>
						</div>
                        <!-- END Main Content -->
					<script type="text/javascript">
					
					function getParentForLevel(module_name,fun,level){
	
					$.ajax({
								url:"ajax.php",
								type:"POST",
								data:"page="+module_name+"&function="+fun+"&level="+level,
								success:function(resp){
									var parent_page_id_select='';
									for(var i=0; i<resp.length; i++){
										parent_page_id_select+="<option value="+resp[i].page_id+">"+resp[i].title+"</option>";
									}
									$("#parent_page_id").html(parent_page_id_select);
									$("#parent_page_id").change();	
								}
							});
					}
					
					
						$(document).ready( function () {
							<?
							foreach($data['page_Details'] as $key=>$value ) { 
							?>
								$('#<?=$key;?>').val('<?=$value;?>');
							<? 		
							} 
							?>	
							$("#level").change(function(){
								var level = $("#level").find(":selected").val();
								getParentForLevel("settings","get_parent_ajax",level);
								$("#parent_page").show('slow');
							}); 
	
	 						getParentForLevel("settings","get_parent_ajax",$("#level").val());
							
							$('#level').val(<?=$data['page_Details']['level'] ?>).change();
							$('#tab_order').val(<?=$data['page_Details']['tab_order'] ?>).change();
							
							
							$('#parent_page_id option[value="<?=$data['page_Details']['parent_page_id'] ?>"]').attr('selected','selected');
							$("#parent_page_id").change();
						});
                   </script>