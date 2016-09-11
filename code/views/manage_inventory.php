<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
extract($data);
?>

					<!-- Content -->
					<div id="content" class="clearfix">

                     <input type="hidden" name="edit_id" value="" id="edit_id" />
                    <input type="hidden" name="show_status" id="show_status" value="<?php if((isset($current_show) && $current_show == 0) ) echo '0';
                                                                                          elseif(($current_show == 1) || !isset($current_show)) echo '1';
                                                                                          elseif($current_show == 2) echo '2';
                                                                                    ?>" />

                       <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                      
                        <!-- Main Content -->
                        <div id="main-content" >
						
                        
                            <!-- All Users -->
                            <h2>Inventories (<?=count($allInventories)?>)</h2>                            
                            <a href="javascript:callPage('inventory','show_add_inventory');" class="for_links">Add Inventory</a>
                            
                            <div class="show_links">
                               	<a href="javascript:show_records(0,'inventory','view_inventory');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                 <a href="javascript:show_records(1,'inventory','view_inventory');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'inventory','view_inventory');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            
                            <div class="body-con">   
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th>Product Name</th>
                                        <th>Warehouse Name</th>
                                        <th class="amount_col">Basic Inventory Cost</th>
                                        <th>Units</th>
                                        <th>Remarks</th>
                                        <th style="width:15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
								   		for($i=0;$i<count($allInventories);$i++)
									   {?>
										    <tr>
                                            	<td ><?=$i+1; ?></td>
												<td ><?=$allInventories[$i]['product_name']; ?></td>
                                                <td ><?=$allInventories[$i]['name']; ?></td>
                                                <td class="amount_col"><?=number_format($allInventories[$i]['basic_cost'],2); ?></td>
                                                <td ><?=$allInventories[$i]['units']; ?></td>
                                                <td ><?=stripslashes($allInventories[$i]['remarks']); ?></td>
                                                
                                                <td>
												<?php if($allInventories[$i]['is_active'] != 0) {?>
                                                <a href="javascript:openEditInventory(<?php echo $allInventories[$i]['inventory_id']; ?>,'inventory','edit_inventory')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:openDeleteInventory(<?php echo $allInventories[$i]['inventory_id']; ?>,'inventory','delete_inventory')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allInventories[$i]['inventory_id']; ?>,'inventory','restore_inventory')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
                                                <?php } ?>
                                                </td>   
												
											</tr>								   
										   <?
										   
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
