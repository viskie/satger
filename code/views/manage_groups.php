<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data['userPagePermission']); exit;
?>
<input type="hidden" name="edit_id" value="" id="edit_id" />
<input type="hidden" name="show_status" id="show_status" value="" />
					<!-- Content -->
					<div id="content" class="clearfix">
						
                         <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                      <!-- Main Content -->
                        <div id="main-content" class="singlecolm_form">
                        
                            <!-- All Users -->
                            <h2>All Groups (<?=sizeof($data['allGroups'])?>)</h2>
							 <div class="show_links">
                            	<a href="javascript:show_records(0, 'users', 'view_groups')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts']['all']?>)</a><span> | </span>
                            	<a href="javascript:show_records(1, 'users', 'view_groups')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts']['active']?>)</a><span> | </span>
                            	<a href="javascript:show_records(2, 'users', 'view_groups')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts']['deleted']?>)</a>
                           	</div>
                            <a href="javascript:callPage('users','show_add_group');" class="for_links">Add Group</a>                            
                              
                            <!-- Users table -->
                            <div class="body-con"> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" align="center" aria-describedby="example_info">
                                <thead>
                                    <tr>
                                        <th>Group Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   foreach($data['allGroups'] as $value)
									   { 
										   ?>
										    <tr>
												<td><a href="#" onclick="getUsersOfGroup('<?=$value['group_id']?>','<?=$value['group_name']?>')"><?=$value['group_name']; ?></a></td>
												<td><?=$value['comments']; ?></td>
												<td>
												<? if($value['is_active'] != 0) {?>
												<a href="javascript:openEditGroup('<?=$value['group_id']?>','users','edit_group')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
														  	<? if($value['group_id'] != 1) {?>&nbsp;&nbsp;&nbsp;<a href="javascript:deleteGroup('<?=$value['group_id']?>','<?=$value['group_name']?>','users','delete_group')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a><? } ?>
												<? }else{ 
													if(isset($_REQUEST['show_status']))
														
															echo "<a href=\"javascript:restoreEntry('".$value['group_id']."','users','restore_group')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";
												}
												?>
                                                </td>
											</tr>
										   <?
									   }
									  ?>	
                                </tbody>
                            </table>
                            <!-- END Users table -->
                            </div>
                            	<div id="users_of_group"></div>                         
                          </div>
                        <!-- END Main Content -->
                        
					</div>
					<!-- END Content -->
<script type="text/javascript">
function getUsersOfGroup(group_id,group_name){
	$.ajax({
			url:"ajax.php",
			type:"POST",
			data:"page=users&function=get_users_of_group&group_id="+group_id,
			success:function(resp){
				//alert(resp);
				var resp_string = "<h3>Users of "+group_name+" group</h3><table><thead><tr><th>User Name</th><th>User Email</th><th>User Phone</th></tr></thead><tbody>";;
				if(resp.length > 0){
					for(var i=0; i<resp.length; i++){
						resp_string += "<tr><td>"+resp[i].name+"</td><td>"+resp[i].user_email+"</td><td>"+resp[i].user_phone+"</td></tr>";
					}
				}else{
					resp_string += "<tr><td colspan=3>No Users Found</td></tr>";
				}
				resp_string += "</tbody></table>";
				$("#users_of_group").html(resp_string);
			}
		});
}
</script>