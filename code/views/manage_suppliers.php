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
							
                            <!-- All Users -->
                            <h2>All Suppliers (<?=sizeof($data['allSuppliers'])?>)</h2>
                             <div class="show_links">
                            	<a href="javascript:show_records(0, 'materials', 'view_supplier')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts']['all']?>)</a><span> | </span>
                            	<a href="javascript:show_records(1, 'materials', 'view_supplier')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts']['active']?>)</a><span> | </span>
                            	<a href="javascript:show_records(2, 'materials', 'view_supplier')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts']['deleted']?>)</a>
                           	</div>
                            <a href="javascript:callPage('materials','show_add_supplier');" class="for_links">Add Supplier</a>
                            
                            <div class="body-con">    
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th style="text-align:left">Name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Zip-Code</th>
                                        <th>Phone 1</th>
                                        <th>Phone 2</th>
                                        <th>Email</th>
                                        <th>Currency</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   foreach($data['allSuppliers'] as $value)
									   {
										   ?>
										    <tr>
                                            	<td class="backcolor"><?=$i; ?></td>
												<td style="text-align:left" ><?=$value['supplier_name']; ?></td>
												<td><?=stripslashes($value['address']); ?></td>
												<td><?=$value['city']; ?></td>
												<td><?=$value['state']; ?></td>
												<td><?=$value['country']; ?></td>
												<td><?=$value['zip']; ?></td>
                                                <td><?=$value['phone1']; ?></td>
                                                <td><?=$value['phone2']; ?></td>
                                                <td><?=$value['email']; ?></td>
                                                <td><?=$value['currency']; ?></td>
												<td nowrap="nowrap">
                                                <? if($value['is_active'] != 0){?> 
                                                <a href="javascript:openEditSupplier('<?=$value['supplier_id']?>','materials','edit_supplier')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                                &nbsp;&nbsp;&nbsp;<a href="javascript:openDeleteSupplier('<?=$value['supplier_id']?>','<?=$value['supplier_name']?>','materials','delete_supplier')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>  
												<? }else{
													if(isset($_REQUEST['show_status']))
														echo "<a href=\"javascript:restoreEntry('".$value['supplier_id']."','materials','restore_supplier')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";
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
                            <!-- END Users table -->                           
                          	</div>
                            
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->