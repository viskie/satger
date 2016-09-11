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

                        <input type="hidden" name="position_id" id="position_id" value="<?php if(isset($data['position_Details']['position_id'])) echo $data['position_Details']['position_id']?>" />

                        <!-- Sidebar -->

                        <div id="side-content-left">   

							 <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>

                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  

                      <? }  else  if($notificationArray['type'] == "Failed") { ?>

                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>

                      <?   } } ?>

                            

                            <!-- Add user Box -->

                            <h3><? if(isset($data['position_Details'])) { echo "Edit Candidate Position";} else{ echo "Add Candidate Position"; }?></h3>

                            <div class="body-con">                    

                                    <label for="sf-username">Candidate Position Name<span> *</span></label>

                                    <input type="text" id="position_name" name="position_name" value='<?php if(isset($data['position_Details']['position_id'])) echo $data['position_Details']['position_name'] ?>' />

                                    <?php

									if(isset($data['position_Details'])) 

									{

									?>

                                     <input type="button" value="Update" class="green_button"  onclick="javascript:updatePosition('<?php echo $data['position_Details']['position_id']?>','settings','edit_position_entry')" > 

                                    <?php 

									}

									else

									{

									?>

                                    <input type="button" value="Insert" class="green_button" onClick="javascript:addPosition('settings','add_position')">

                                    <?php } ?>

                                   

                            </div>

                            <!-- END Add user Box -->

                            

                       



                        </div>

                        <!-- END Sidebar -->



                        <!-- Main Content -->

                        <div id="main-content-right">

							<!-- All Users -->

                            <h2>All Candidate Positions (<?=count($allPositions)?>)</h2>

                            

                            <div class="show_links">

                               	<a href="javascript:show_records(0,'settings','view_position');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|

                                 <a href="javascript:show_records(1,'settings','view_position');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|

                                <a href="javascript:show_records(2,'settings','view_position');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>

                            </div>

                            

                            <div class="body-con">       

                            <!-- Users table --> 

                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">

                                <thead>

                                    <tr>

                                    	<th>Sr. No</th>

                                        <th>Candidate Position Name</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                   <?	for($i=0;$i<count($allPositions);$i++)

									   {

									   	

										   ?>

										    <tr>

                                            	<td class="backcolor"><?=$i+1 ?></td>

												<td ><?=$allPositions[$i]['position_name']; ?></td>

                                                <td>

												<?php if($allPositions[$i]['is_active'] != 0) {?>

                                                <a href="javascript:openEditEntry(<?php echo $allPositions[$i]['position_id']; ?>,'settings','edit_position')" class="tiptip-top" title="Edit">

                                                        <img src="img/icon_edit.png" alt="edit" />

                                                    </a>

                                                &nbsp;&nbsp;&nbsp;

                                                <a href="javascript:deleteEntry(<?php echo $allPositions[$i]['position_id']; ?>,'<?php echo $allPositions[$i]['position_name']; ?>','settings','delete_position')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>

                                                 <?php } 

                                                 else {?>

                                                &nbsp;&nbsp;&nbsp;

                                                <a href="javascript:restoreEntry(<?php echo $allPositions[$i]['position_id']; ?>,'settings','restore_position')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>

                                                

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

