<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
extract($data);
//var_dump(count($allProjects));exit;
?>
					<!-- Content -->
					<div id="content" class="clearfix">
                    
                    <input type="hidden" name="edit_id" value="" id="edit_id" />
                    <input type="hidden" name="show_status" id="show_status" value="<?php if((isset($current_show) && $current_show == 0) ) echo '0';
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
                            <h2>All Projects (<?=count($allProjects)?>)</h2>
                            <div class="show_links">
                                <a href="javascript:show_records(0,'projects','view');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'projects','view');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'projects','view');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                             <a href="javascript:callPage('projects','show_add_project');" class="for_links">Add Project</a>               
                            
                            <div class="body-con">   
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th style="text-align:left">Project Name</th>
                                        <th>Client</th>
                                        <th class="date_col">Start Date</th>
                                        <th class="date_col">Expected End Date</th>
                                        <th class="date_col">End Date</th>
                                        <th class="amount_col">Project Cost INR</th>
                                        <th class="amount_col">Project Cost(USD)</th>
                                        <th class="amount_col">Project Expense</th>
                                        <th>Remarks/Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
								   for($i=0;$i<count($allProjects);$i++)
									   {?>
										    <tr>
                                            	<td ><?=$i+1; ?></td>
												<td style="text-align:left" ><?=$allProjects[$i]['project_name']; ?></td>
												<td><?=$allProjects[$i]['client_biz_name']; ?></td>
												<td class="date_col"><?=formatDate($allProjects[$i]['start_date']); ?></td>
												<td class="date_col"><?=formatDate($allProjects[$i]['expected_end_date']); ?></td>
												<td class="date_col"><?=formatDate($allProjects[$i]['end_date']); ?></td>
                                                <td class="amount_col"><?=$allProjects[$i]['project_cost_INR']=='0'?'':number_format($allProjects[$i]['project_cost_INR'],2) ?></td>
                                                <td class="amount_col"><?=$allProjects[$i]['project_cost_dollar']=='0'?'':number_format($allProjects[$i]['project_cost_dollar'],2) ?></td>
                                                <td class="amount_col"><?=$allProjects[$i]['project_expense']=='0'?'':number_format($allProjects[$i]['project_expense'],2) ?></td>
												<td><?=stripslashes($allProjects[$i]['remarks']); ?></td>
                                                
                                                <td style="width:65px">
												<?php if($allProjects[$i]['is_active'] != 0) {?>
                                                <a href="javascript:openEditProject(<?php echo $allProjects[$i]['project_id']; ?>,'projects','edit_project')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                     &nbsp;
                                                    <a href="javascript:openEditProject('<?=$allProjects[$i]['project_id']?>','projects','view_project')" class="tiptip-top" title="View">
                                                    <img src="img/icon_view.png" alt="view">
                                                    </a>
                                                &nbsp;
                                                <a href="javascript:deleteProject(<?php echo $allProjects[$i]['project_id']; ?>,'<?php echo $allProjects[$i]['project_name']; ?>','projects','delete_project')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allProjects[$i]['project_id']; ?>,'projects','restore_project')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
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
