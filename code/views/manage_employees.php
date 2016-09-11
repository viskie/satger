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
                        <!-- Sidebar -->
                        <!-- Main Content -->
                       
						<!--  link for Add Employee  -->
                            <!-- All Users -->
                            <div id="main-content">
                                <h2>All Employees (<?=count($allEmployees)?>)</h2>
                                <div class="show_links">
                                <a href="javascript:show_records(0,'hrm','view_employees');" <?php if((isset($current_show) && $current_show == 0) ) echo 'class="show_active"';?> >All (<?php echo $rec_counts['all']; ?>)</a>|
                                <a href="javascript:show_records(1,'hrm','view_employees');" <?php if(($current_show == 1)|| !isset($current_show)) echo 'class="show_active"';?>>Active (<?php echo $rec_counts['active']; ?>)</a>|
                                <a href="javascript:show_records(2,'hrm','view_employees');" <?php if($current_show == 2) echo 'class="show_active"';?>>Deleted (<?php echo $rec_counts['trash']; ?>)</a>
                            </div>
                                <div class="for_links"><a href="javascript:callPage('hrm','show_add_employee');">Add Employee</a></div> 
                            </div>                               
                            <!-- Users table --> 
                            <div class="body-con"> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Employee Name</th>
                                        <th>Phone Number</th>
                                        <th class="amount_col">Current Salary</th>
                                        <th class="date_col">Joining Date</th>
                                        <th>Designation</th>
                                        <th>Personal Email</th>
                                        <th>Company Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
								   for($i=0;$i<count($allEmployees);$i++)
									   {
									      ?>
										    <tr>
                                            	<td class="backcolor"><?=$i+1; ?></td>
												<td ><?=$allEmployees[$i]['employee_name']; ?></td>
                                                <td><?=$allEmployees[$i]['phone_number']; ?></td>
                                                <td class="amount_col"><?=number_format($allEmployees[$i]['current_salary'],2); ?></td>
                                                <td class="date_col"><?=formatDate($allEmployees[$i]['joining_date']); ?></td>
                                                <td><?=$allEmployees[$i]['designation']; ?></td>
                                                <td><?=$allEmployees[$i]['personal_email']; ?></td>
                                                <td><?=$allEmployees[$i]['company_email']; ?></td>
												
                                                <td>
												<?php if($allEmployees[$i]['is_active'] != 0) {?>
                                                <a href="javascript:openEditEmployee(<?php echo $allEmployees[$i]['employee_id']; ?>,'hrm','edit_employee')" class="tiptip-top" title="Edit">
                                                        <img src="img/icon_edit.png" alt="edit" />
                                                    </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:deleteEmployee(<?php echo $allEmployees[$i]['employee_id']; ?>,'<?php echo $allEmployees[$i]['employee_name']; ?>','hrm','delete_employee')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                 <?php } 
                                                 else {?>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:restoreEntry(<?php echo $allEmployees[$i]['employee_id']; ?>,'hrm','restore_employee')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>
                                                
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
                            
                       
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->
