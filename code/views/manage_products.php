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
                        <div id="main-content">

                            <!-- All Users -->
                            <h2>All Products (<?=count($allProducts)?>)</h2>
                            
                            <div class="show_links">
                                <a href="javascript:show_records(0,'products','view');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'products','view');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'products','view');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            
                            <a href="javascript:callPage('products','show_add_product');" class="for_links">Add Product</a>
                            
                            <div class="body-con">   
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th style="text-align:left">Product Name</th>
                                        <th>Item Code</th>
                                        <th class="amount_col">Basic Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   for($i=0;$i<count($allProducts);$i++)
									   {
										   ?>
										    <tr>
                                            	<td ><?=$i+1; ?></td>
												<td style="text-align:left" ><?=$allProducts[$i]['product_name']; ?></td>
												
												<td><?=$allProducts[$i]['item_code']; ?></td>
												<td class="amount_col"><?=number_format($allProducts[$i]['basic_cost'],2); ?></td>
                                                
                                                 <td>
												<?php if($allProducts[$i]['is_active'] != 0) {?>
                                                <a href="javascript:openEditProduct(<?php echo $allProducts[$i]['product_id']; ?>,'products','edit_product')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:deleteProduct(<?php echo $allProducts[$i]['product_id']; ?>,'<?php echo $allProducts[$i]['product_name']; ?>','products','delete_product')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allProducts[$i]['product_id']; ?>,'products','restore_product')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
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
