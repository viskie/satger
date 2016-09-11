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
<input type="hidden" name="show_status" id="show_status" value="" />
					<!-- Content -->
					<div id="content" class="clearfix">

                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>

                        <!-- Main Content -->
                        <div id="main-content" >
							
                            <!-- All Materials -->
                            <h2>All Materials (<?=sizeof($data['allMaterials'])?>)</h2>
							 <div class="show_links">
                            	<a href="javascript:show_records(0, 'materials', 'view_material')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts']['all']?>)</a><span> | </span>
                            	<a href="javascript:show_records(1, 'materials', 'view_material')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts']['active']?>)</a><span> | </span>
                            	<a href="javascript:show_records(2, 'materials', 'view_material')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts']['deleted']?>)</a>
                           	</div>
                             <a href="javascript:callPage('materials','show_add_material');" class="for_links">Add Material</a>
                             
                             <div class="body-con">    
                            <!-- Material table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th style="text-align:left">Material Name</th>
                                        <th>Item Code</th>
                                        <th class="amount_col">Basic Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   foreach($data['allMaterials'] as $value)
									   {
										   ?>
										    <tr>
                                            	<td ><?=$i; ?></td>
												<td style="text-align:left" ><?=$value['material_name']; ?></td>
												
												<td><?=$value['material_code']; ?></td>
												<td class="amount_col"><?=number_format($value['material_cost'],2); ?></td>
												<td nowrap="nowrap">
                                                <? if($value['is_active'] != 0){?> 
                                                <a href="javascript:openEditMaterial('<?=$value['material_id']?>','materials','edit_material')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
														  &nbsp;&nbsp;&nbsp;<a href="javascript:openDeleteMaterial('<?=$value['material_id']?>','<?=$value['material_name']?>','materials','delete_material')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
												<? }else{
													if(isset($_REQUEST['show_status']))
														echo "<a href=\"javascript:restoreEntry('".$value['material_id']."','materials','restore_material')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";
													}	
												?>
                                                </td>
                                             
											</tr>								   
										   <?
										   $i++;
									   }
									  ?>	
                                </tbody>
                            </table>
                            <!-- END Material table -->
                            </div>
                                                       
                        </div>
                        <!-- END Main Content -->
					</div>
					<!-- END Content -->