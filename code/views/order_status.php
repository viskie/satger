<?php
	if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
	{
		header("location: index.php");
		exit();
	}
	extract($data);
	
	if(isset($action) && ($action == 'edit'))
	{
		$btn_value = "Update";
		$field_lable = "Edit Order Status";
	}
	else
	{
		$btn_value = "Insert";
		$field_lable = "Add Order Status";
	}
	?>
    <!-- Content -->
    <div id="content" class="clearfix">
        
         <input type="hidden" name="show_status" id="show_status" value="<?php if(!isset($current_show) || ($current_show == 1 )) echo '1';
																			  elseif((isset($current_show) && $current_show == 0)) echo '0';
																			  elseif($current_show == 2) echo '2';
																		?>" />
		<input type="hidden" name="edit_id" value="<?php if(isset($action) && ($action == 'edit')) echo $status_data[0]['id']; 
														elseif(isset($action) && ($action == 'show_edit')) echo $edit_id; ?>" id="edit_id" />       
        <div id="side-content-left">
				<?  if(array_key_exists('type',$notificationArray)) {
						if($notificationArray['type'] == "Success") { ?>
			                <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
						<? }  else  if($notificationArray['type'] == "Failed") { ?>
              				<div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
		              <?   }
					  } ?>         
            <h3><?php echo $field_lable; ?></h3>
            <div class="body-con">    
                <label for="sf-username">Order Status Name<span>*</span></label>
                <input type="text" id="txtstatus" name="txtstatus" value="<?php if(isset($action) && ($action == 'edit')) echo $status_data[0]['name']; 
																				else if(isset($show_name) && ($show_name != "")) echo $show_name; ?>" /> 
                <label for="sf-username">Order No.<span>*</span></label>
                <input type="text" id="txtorder" name="txtorder" value="<?php if(isset($action) && ($action == 'edit')) echo $status_data[0]['status_order']; 
																				else if(isset($show_order) && ($show_order != "")) echo $show_order;?>" /> 
                <input type="button" value="<?php echo $btn_value; ?>" class="green_button" onClick="return addOrderStatus('settings','add_order_status')" />                    
            </div>            
       	</div>
        <!-- END Sidebar -->

        <!-- Main Content -->
        <div id="main-content-right">
        	<div class="show_links">
                <a href="javascript:show_records(0,'settings','view_order_status');" <?php  if((isset($current_show) && $current_show == 0)) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                <a href="javascript:show_records(1,'settings','view_order_status');" <?php if($current_show == 1 || !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                <a href="javascript:show_records(2,'settings','view_order_status');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
            </div>
            <a href="javascript:callPage('settings','change_user_status_permission');" class="for_links">Manage Permission</a>
            <!-- All Users -->
            <h2>All Order Status (<?php echo count($arr_status)?>)</h2>               
            <!-- Users table --> 
             <div class="body-con">
            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Status Order No.</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   <?php                       
					   for($i=0; $i<count($arr_status); $i++)
                       {	
                           ?>
                            <tr>
                                <td class="backcolor" style="width:120px;"><?php echo $arr_status[$i]['status_order']; ?></td>
                                <td class="backcolor"><?php echo $arr_status[$i]['name']; ?></td>                                
                                <td>
                                	<?php if($arr_status[$i]['is_active'] != 0) {?>
                                	<a href="javascript:editOrderStatus(<?php echo $arr_status[$i]['id']; ?>,'settings','edit_order_status')" class="tiptip-top" title="Edit">
                                		<img src="img/icon_edit.png" alt="edit" />
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="javascript:deleteOrderStatus(<?php echo $arr_status[$i]['id']; ?>,'settings','delete_order_status')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                     <?php }  
									 else { 
									?>
                                &nbsp;&nbsp;&nbsp;
                                <a href="javascript:restoreOrder(<?php echo $arr_status[$i]['id']; ?>,'settings','restore_status')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                
                                <?php } ?>
                                </td>
                            </tr>								   
                           <?php
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
