<?php
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
																			  elseif( !isset($current_show) || $current_show == 1) echo '1';
																			  elseif($current_show == 2) echo '2';
																		?>" />
         <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
        <!-- Main Content -->
        <div id="main-content">    
            <!-- All Sale -->
            <h2>All Orders (<?php echo count($arr_orders)?>)</h2>
            <div class="show_links">
            	<a href="javascript:show_records(0,'leads','order_mngt');" <?php if((isset($current_show) && $current_show == 0)) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                <a href="javascript:show_records(1,'leads','order_mngt');" <?php if(!isset($current_show) || $current_show == 1) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                <a href="javascript:show_records(2,'leads','order_mngt');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
            </div>
            <a href="javascript:callPage('leads','add_edit_order');" class="for_links">Add Order</a>               
            
            <div class="body-con">    
            <!-- Users table --> 
            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width:10%">Sr. No</th>
                        <th style="text-align:left; width:25%;">Receipt No</th>
                        <th style="width:25%">Order Date</th>
                        <th style="width:25%">Total Invoice Amount</th>
                        <th style="width:15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
				   	for($i=0; $i<count($arr_orders); $i++)
					{
					?>
                    	<tr>
                            <td ><?php echo $i+1; ?></td>
                            <td style="text-align:left" ><?php echo $arr_orders[$i]['reciept_no']; ?></td>
                            <td class="date_col"><?php echo formatDate($arr_orders[$i]['order_date']); ?></td>
                            <td class="amount_col"><?php echo number_format($arr_orders[$i]['total_invoice_amount'],2) ?></td>
                            <td>
                            	<?php if($arr_orders[$i]['is_active'] != 0) {?>
                            	<a href="javascript:editOrder(<?php echo $arr_orders[$i]['order_id']; ?>,'leads','add_edit_order')" class="tiptip-top" title="Edit">
                                		<img src="img/icon_edit.png" alt="edit" />
                                    </a>
                              	&nbsp;&nbsp;&nbsp;
                                <a href="javascript:deleteOrder(<?php echo $arr_orders[$i]['order_id']; ?>,'leads','delete_order')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                 <?php } 
								 else {?>
                                &nbsp;&nbsp;&nbsp;
                                <a href="javascript:restoreEntry(<?php echo $arr_orders[$i]['order_id']; ?>,'leads','restore_order')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                
                                <?php } ?>
                           </td>                         
                        </tr>
                    <?php 
					}
					?>
                </tbody>
            </table>
            <!-- END Sale table --> 
            </div>                          
        </div>
        <!-- END Main Content -->
    </div>
    <!-- END Content -->