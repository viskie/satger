<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
extract($data);
?>

<script>
<?php if(isset($data['is_redirect']) && $data['is_redirect']){ ?>
	document.getElementById("redirect_message").value="<?php echo $notificationArray['message'];?>";
    callPage('settings','view_pages');
<?php }?>
function getParentForLevel(module_name,fun,level,selected){
	
	$.ajax({
				url:"ajax.php",
				type:"POST",
				data:"page="+module_name+"&function="+fun+"&level="+level,
				success:function(resp){
					var parent_page_id_select='';
					for(var i=0; i<resp.length; i++){
						var selected_str="";
						if(selected==resp[i].page_id){
							selected_str=" selected='selected'";
						}
						parent_page_id_select+="<option value="+resp[i].page_id+" selected_str>"+resp[i].title+"</option>";
					}
					$("#parent_page_id").html(parent_page_id_select);
					$("#parent_page_id").change();	
				}
			});
}

$(document).ready(function(e) {
	
	$("#level").change(function(){
								var level = $("#level").find(":selected").val();
								getParentForLevel("settings","get_parent_ajax",level);
								$("#parent_page").show('slow');
							}); 
	
	<?php if($is_edit || $is_exist){?>
//		 getParentForLevel("settings","get_parent_ajax",$("#level").val(),'<?php echo $data['page_Details']['parent_page_id']; ?>');
	<? } ?>
	 
});
</script>

<input type="hidden" name="redirect_message" value="" id="redirect_message" />
<input type="hidden" name="edit_id" value="" id="edit_id" />
<input type="hidden" name="show_status" id="show_status" value="<?php if((isset($current_show) && $current_show == 0) ) echo '0';
                                                                                          elseif(($current_show == 1) || !isset($current_show)) echo '1';
                                                                                          elseif($current_show == 2) echo '2';
                                                                                    ?>" />

					<!-- Content -->
					<div id="content" class="clearfix">

                        <!-- Sidebar -->
                        <div id="side-content-left">   
                        
						 <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                            <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                          <? }  else  if($notificationArray['type'] == "Failed") { ?>
                          <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                          <?   } } ?>
                            
                            <!-- Add user Box -->
                            <h3><? if($is_exist == true|| $is_edit == true){ echo "Edit Page";} else{ echo "Add Page"; }?></h3>
                            <div class="body-con">
                    
                                    <label for="description">Page Description</label><span style="color:red"> *</span>
                                    <input type="text" id="description" name="description" value="<? if($is_exist == true|| $is_edit == true){ echo $data['page_Details']['description'];} ?>"/>
                                    <label for="module_name">Module Name</label><span style="color:red"> *</span>
                                    <input type="text" id="module_name" name="module_name" value="<? if($is_exist == true|| $is_edit == true){ echo $data['page_Details']['module_name'];} ?>"/>
                                    <label for="title">Page Title</label><span style="color:red"> *</span>
                                    <input type="text" id="title" name="title" value="<? if($is_exist == true|| $is_edit == true){ echo $data['page_Details']['title'];} ?>"/>
                                <div style="display:none">
                                    <label for="level">Page Level</label>
                                    <select name="level" id="level">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                    <div id="parent_page" >
                                    <label for="parent_page_id">Parent Page</label>
                                    <select name="parent_page_id" id="parent_page_id">
                                    
                                    </select>
                                    </div>
                                 </div>
                                    <label for="tab_order">Tab Order</label>
                                    <select name="tab_order" id="tab_order">
                                    <?
									$tab_order = $data['maxTabOrder']+1;
									if($is_edit || $is_exist){
										$tab_order = $data['page_Details']['tab_order'];
									}
									for($i=1;$i<=20;$i++)
									{
										?>
                                        <option 
										<?
										if ($tab_order==$i)
										{ echo "selected=selected";
										}?> value="<?=$i; ?>"><?=$i ?></option>
                                        <?
									}
									?>
                                    </select>
                                    <label for="is_crud">CRUD Page</label>
                                    <!--<select name="is_crud" id="is_crud">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    </select>-->
                                    
                                    <? if($is_exist || $is_edit) {?>
                                     <input type="checkbox" name="is_crud"  
									<? 
									if($data['page_Details']['is_crud']==1)
									{ 
										echo "checked value=1"; 
									}
									else
									{
										echo "value=0";
									}?>>
                                    <? }else{ ?>
										<input type="checkbox" name="is_crud" value="" />
                                    <? } ?>
                                    <br/><br/>
                                    <label for="file">Module Image</label><span style="color:red"> *</span>
                                    <input type="file" name="file" id="file" size="40">
                                    <? if($is_exist == true|| $is_edit == true)
									{ 
									?>
                                    <img src="<?=$data['page_Details']['img_url'] ?>" style="width:80px;"/>
                                    <?
									} 
									?>
                                    <br/>
                                    <?php if($is_edit){?>
                                    	 <input type="submit" value="Update" onclick="return updatePage('<?=$data['page_Details']['page_id'] ?>','settings','edit_page_entry')"/>
                                     <?php }else{ ?>
	                                     <input type="submit" value="Insert" onClick="return addPage('settings','add_page')"/>
                                     <?php }?>
                                    </p>
                            </div>
                            <!-- END Add user Box -->
                            
                       

                        </div>
                        <!-- END Sidebar -->

                        <!-- Main Content -->
                        <div id="main-content-right">

                            <!-- All Users -->
                            <h2>All Pages (<?=count($allPages)?>)</h2>
                            <div class="show_links">
                                <a href="javascript:show_records(0,'settings','view_pages');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'settings','view_pages');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'settings','view_pages');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
							<div class="body-con">
                                
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Module Name</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?	for($i=0;$i<count($allPages);$i++)
									   {
									   		if($allPages[$i]['module_name'] != 'home')
											{
										   ?>
										    <tr>
												<td><?=$allPages[$i]['description']; ?></td>
												<td ><?=$allPages[$i]['module_name']; ?></td>
                                                <td ><?=$allPages[$i]['title']; ?></td>
                                                 <td>
												<?php if($allPages[$i]['is_active'] != 0) {?>
                                                <a href="javascript:openEditPage(<?php echo $allPages[$i]['page_id']; ?>,'settings','edit_page')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:deletePage(<?php echo $allPages[$i]['page_id']; ?>,'<?php echo $allPages[$i]['title']; ?>','settings','delete_page')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allPages[$i]['page_id']; ?>,'settings','restore_page')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
                                                <?php } ?>
                                                </td>   
                                                
												
											</tr>								   
										   <?
										   }
									   }
									  ?>	
                                </tbody>
                            </table>
                            </div>
                            <!-- END Users table -->                           
                          
                            
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->
