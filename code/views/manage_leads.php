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
                            <h2>All Leads (<?=sizeof($data['allLeads'])?>)</h2>
							<div class="show_links">
                            	<a href="javascript:show_records(0, 'leads', 'view_leads')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts']['all']?>)</a><span> | </span>
                            	<a href="javascript:show_records(1, 'leads', 'view_leads')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts']['active']?>)</a><span> | </span>
                            	<a href="javascript:show_records(2, 'leads', 'view_leads')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts']['deleted']?>)</a><span> | </span>
                                <a href="javascript:show_records(3, 'leads', 'view_leads')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 3) {?>style="color:black;"<? } ?>>Archive(<?=$data['rec_counts']['archive']?>)</a>
                           	</div>
							<? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>
								<a href="javascript:callPage('leads','archive_lead');" class="for_links archive_lead" style="margin-right: 60px;">Archive Selected</a>
							<? } ?>
							<? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 3) {?>
								<a href="javascript:callPage('leads','un_archive_lead');" class="for_links un_archive_lead" style="margin-right: 60px;">Un-Archive Selected</a>
							<? } ?>
                            <a href="javascript:callPage('leads','show_add_leads');" class="for_links">Add Lead</a>
                            
                            <div class="body-con">      
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th style="max-width: 30px;">Sr. No</th>
                                        <th>Client / Customer</th>
                                        <th>Type of Business</th>
										<th>Product</th>
                                        <!--<th class="date_col">Initial Contact Date</th>-->
                                        <th class="date_col">Followup Date</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Email</th>
                                        <th>Phone No</th>
                                        <th>Potential</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									   for($j=0;$j<count($data['allLeads']);$j++)
									  	{	
											if($data['allLeads'][$j]['is_archive'] == 0)
												$class = "class='archive_lead_check'";
											else
												$class = "class='unarchive_lead_check'";
										   ?>
										    <tr>
                                            	<td class="backcolor" style="max-width: 30px;">
													<?=$i; ?>
													<?php if((isset($_REQUEST['show_status']) && $_REQUEST['show_status'] == 1 )|| isset($_REQUEST['show_status']) && $_REQUEST['show_status'] == 3 ) {  ?>
													<input <? echo $class; ?> type="checkbox" name="archive_lead[]" value="<?=$data['allLeads'][$j]['lead_id']?>" />
													<? } ?>
												</td>
												<td style="text-align:left" >
													<?php echo $data['lead_client'][$j]; 								//$data['lead_client'][$j][0]['client_name']."(".$data['lead_client'][$j][0]['client_biz_name'].")"; ?>
                                                </td>
                                                <td><?php echo $data['allLeads'][$j]['type_business']; ?></td>
												<td><?=$data['lead_product'][$j]['product_name']; ?></td>
												<!--<td class="date_col">< ?=formatDate($data['allLeads'][$j]['initial_contact_date']) ?></td>-->
												<td class="date_col"
                                                <? if(strtotime($data['allLeads'][$j]['followup_date']) < time())
												{
													echo "style=\"color:red\"";
												}
												?>
                                                ><?=formatDate($data['allLeads'][$j]['followup_date']) ?></td>
                                                <td><?php  echo $data['priority'][$j]['value']; ?></td>
												<td><?=$data['lead_status'][$j]['status_name']; ?></td>
												<td><?=$data['allLeads'][$j]['lead_email']; ?></td>
                                                <td><?=$data['allLeads'][$j]['lead_phone']; ?></td>
                                                <td><?=$data['allLeads'][$j]['potential']; ?></td>
												<td nowrap="nowrap">
                                                <? if($data['allLeads'][$j]['is_active'] != 0){?>
                                                <a href="javascript:openEditLead('<?=$data['allLeads'][$j]['lead_id']?>','leads','edit_lead')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                                &nbsp;&nbsp;&nbsp;<a href="javascript:openDeleteLead('<?=$data['allLeads'][$j]['lead_id']?>','leads','delete_lead')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                                <?php if($data['allLeads'][$j]['is_archive'] == 0 && ($_REQUEST['show_status']!=0 || $_REQUEST['show_status']!=3)) {?>
                                                  &nbsp;&nbsp;&nbsp;<a href="javascript:openArchiveLead('<?=$data['allLeads'][$j]['lead_id']?>','leads','archive_lead')" class="tiptip-top" title="Archive"><img src="img/archive.png" alt="archive"></a>
                                                <?php } ?>
												<?php if($data['allLeads'][$j]['is_archive'] == 1 && ($_REQUEST['show_status']!=0 || $_REQUEST['show_status']!=3)) {?>
												  &nbsp;&nbsp;&nbsp;<a href="javascript:openArchiveLead('<?=$data['allLeads'][$j]['lead_id']?>','leads','un_archive_lead')" class="tiptip-top" title="Un-Archive"><img src="img/arrow_up.png" alt="un archive"></a>
												<?php } ?>  
                                                <? }else{
													if(isset($_REQUEST['show_status']))
														echo "<a href=\"javascript:restoreEntry('".$data['allLeads'][$j]['lead_id']."','leads','restore_lead')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";
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
<script>
	$(document).ready(function(e) {
		
		$('.archive_lead').bind('click', false);
		$('.archive_lead').css({
			'color' : '#CDE0EB',
			'text-decoration' : 'none'	
		});
		$('.archive_lead_check').click(function () {
			if ($('.archive_lead_check').is(':checked')) {
				$('.archive_lead').unbind('click', false);
				$('.archive_lead').css({
					'color' : '#0098EA'
				});
			}else{
				$('.archive_lead').bind('click', false);
				$('.archive_lead').css({
					'color' : '#CDE0EB',
					'text-decoration' : 'none'	
				});
			}				
		});	
		
		$('.un_archive_lead').bind('click', false);
		$('.un_archive_lead').css({
			'color' : '#CDE0EB',
			'text-decoration' : 'none'	
		});
		$('.unarchive_lead_check').click(function () {
			if ($('.unarchive_lead_check').is(':checked')) {
				$('.un_archive_lead').unbind('click', false);
				$('.un_archive_lead').css({
					'color' : '#0098EA'
				});
			}else{
				$('.un_archive_lead').bind('click', false);
				$('.un_archive_lead').css({
					'color' : '#CDE0EB',
					'text-decoration' : 'none'	
				});
			}				
		});	
	});  
</script>		