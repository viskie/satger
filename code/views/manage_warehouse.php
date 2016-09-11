<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
$i=1;
//echo "<pre>"; print_r($data);
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
                        <div id="main-content">
							
                            <!-- All Warehouse -->
                            <h2>All Warehouses (<?=sizeof($data['allWarehouses'])?>)</h2>                      
							 <div class="show_links">
                            	<a href="javascript:show_records(0, 'inventory', 'view_warehouse')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts']['all']?>)</a><span> | </span>
                            	<a href="javascript:show_records(1, 'inventory', 'view_warehouse')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts']['active']?>)</a><span> | </span>
                            	<a href="javascript:show_records(2, 'inventory', 'view_warehouse')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts']['deleted']?>)</a>
                           	</div>		
                            <a href="javascript:callPage('inventory','show_add_warehouse');" class="for_links">Add Warehouse</a>
                            
                            <div class="body-con">       
                            <!-- Warehouse table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th>Code</th>
                                        <th style="text-align:left">Name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Zip-Code</th>
                                        <th>Note</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   foreach($data['allWarehouses'] as $value)
									   {
										   ?>
										    <tr>
                                            	<td class="backcolor"><?=$i; ?></td>
                                                <td><?=$value['warehouse_code']?></td>
												<td style="text-align:left" ><?=$value['name']; ?></td>
												<td><?=stripslashes($value['address']); ?></td>
												<td><?=$value['city']; ?></td>
												<td><?=$value['state']; ?></td>
												<td><?=$value['country']; ?></td>
												<td><?=$value['zip']; ?></td>
                                                <td><?=stripslashes($value['note']); ?></td>
												<td nowrap="nowrap">
												<? if($value['is_active'] != 0){?> 
												<a href="javascript:openEditWarehouse('<?=$value['warehouse_id']?>','inventory','edit_warehouse')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                                &nbsp;&nbsp;&nbsp;<a href="javascript:openDeleteWarehouse('<?=$value['warehouse_id']?>','<?=$value['name']?>','inventory','delete_warehouse')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>  
												<? }else{
													if(isset($_REQUEST['show_status']))
														echo "<a href=\"javascript:restoreEntry('".$value['warehouse_id']."','inventory','restore_warehouse')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";
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
                            <!-- END Warehouse table -->                           
                          	</div>
                            
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->