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
        <input type="hidden" name="show_status" id="show_status" value="<?php if((isset($current_show) && $current_show == 0)) echo '0';
																			  elseif(($current_show == 1)|| !isset($current_show)) echo '1';
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
                            <h2>All Clients (<?=count($allClients)?>)</h2>
                            <div class="show_links">
                                <a href="javascript:show_records(0,'clients','view');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'clients','view');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'clients','view');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                            
                            <a href="javascript:callPage('clients','show_add_client');" class="for_links">Add Client</a>
                            
                            <div class="body-con">    
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th style="text-align:left">Business Name</th>
                                        <th>Client Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>Country</th>
                                        <th>Remarks/Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <? 
								   		for($i=0;$i<count($allClients);$i++)
									   {
									   ?>
										    <tr>
                                            	<td class="backcolor"><?=$i+1; ?></td>
												<td style="text-align:left" ><?=$allClients[$i]['client_biz_name']; ?></td>
												<td><?=$allClients[$i]['client_name']; ?></td>
												<td><?=$allClients[$i]['client_email']; ?></td>
												<td><?=$allClients[$i]['client_phone']; ?></td>
												<td><?=$allClients[$i]['city']; ?></td>
												<td><?=$allClients[$i]['status']; ?></td>
                                                <td><?=$allClients[$i]['country']; ?></td>
                                                <td><?=stripslashes($allClients[$i]['remarks']); ?></td>
                                                
                                                <td>
												<?php if($allClients[$i]['status'] != 'Disabled') {?>
                                                <a href="javascript:openEditClient(<?php echo $allClients[$i]['client_id']; ?>,'clients','edit_client')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:openDeleteClient(<?php echo $allClients[$i]['client_id']; ?>,'<?php echo $allClients[$i]['client_biz_name']; ?>','clients','delete_client')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allClients[$i]['client_id']; ?>,'clients','restore_client')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
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
