<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

?>
	<!--<input type="hidden" name="edit_id" value="" id="edit_id" />-->
   <input type="hidden" name="hidden" value="" id="hidden" />
    <!-- Content -->
   
    <div id="content" class="clearfix">

           
            <!-- ****************************   Status************************************* -->                      
            <!-- Main Content -->
            <div id="main-content" style="width:100%; margin-bottom:25px;">
            	<input type="hidden" name="show_lead_status" id="show_lead_status" value="" />
            	<input type="hidden" name="statusid" id="statusid" value="<?php if(isset($data['statusDetails']))  echo $data['statusDetails']['statusid']; ?>" />
                 
            	<h2 id="lead_status">Status (<?=sizeof($data['allStatus'])?>)</h2>
                 <div class="show_links" style="left:360px;">
                            	<a href="javascript:show_lead_configuration(0, 'settings', 'show_configuration','status')" <? if(isset($_REQUEST['show_lead_status']))if($_REQUEST['show_lead_status'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts']['all']?>)</a><span> | </span>
                            	<a href="javascript:show_lead_configuration(1, 'settings', 'show_configuration','status')" <? if(isset($_REQUEST['show_lead_status']))if($_REQUEST['show_lead_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts']['active']?>)</a><span> | </span>
                            	<a href="javascript:show_lead_configuration(2, 'settings', 'show_configuration','status')" <? if(isset($_REQUEST['show_lead_status']))if($_REQUEST['show_lead_status'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts']['deleted']?>)</a>
                 </div>
                        
                <a href="javascript:callPage('settings','show_manage_permission');"  class="for_links">Manage Permission</a>
                
                <div class="body-con lead_config">
                	<div id="side-content-left">
                    	<?php if(isset($data['from']) && ($data['from'] == 'status')) { 
								  if(array_key_exists('type',$notificationArray)) {
									if($notificationArray['type'] == "Success") { ?>
										<div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
									<?php }  else  if($notificationArray['type'] == "Failed") { ?>
										<div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
								  <?php   }
                              		} 
							  }?>         
                    	<h3><?php  if(isset($data['statusDetails'])) { echo "Edit Status";} else { echo "Add Status";}  ?></h3>
                       	<div class="body-con">
                            <label for="sf-username">Status Name<span>*</span></label>
                            <input type="text" id="status_name" name="status_name"  value="<?php if(isset($data['statusDetails']))  echo $data['statusDetails']['status_name']; ?>"/>                             	<?php  if(isset($data['statusDetails'])) {    ?>     
                                    <input type="button" value="Update" class="green_button"  onclick="javascript:updateStatus('<?php echo $data['statusDetails']['statusid']?>','settings','edit_status_entry')" >
                                 <?php } else { ?>
                            <input type="button" value="Insert" class="green_button" onclick="javascript:addStatus('settings','add_status')" />
                            <?php } ?>
                        </div>                    
                    </div>                
                	<!-- END Sidebar -->
                
                <div id="main-content-right" style="width:82%">                           
                    <!-- Users table --> 
                    <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                        <thead>
                            <tr>                                
                                <th>Status Name</th>                            
                                <th style="width:15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                                $cnt = 1;
                               foreach($data['allStatus'] as $value)
                               {
                                   ?>
                                    <tr>                                        
                                        <td class="backcolor"><?=$value['status_name']; ?></td>
                                        
                                        <td style="width:15%" nowrap="nowrap">
                                        <? if($value['is_active'] != 0){?> 
                                        <a href="javascript:openEditStatus('<?=$value['status_id']?>','settings','edit_status')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                        &nbsp;&nbsp;&nbsp;<a href="javascript:openDeleteStatus('<?=$value['status_id']?>','<?=$value['status_name']?>','settings','delete_status')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>  
                                        <? }else{
													if(isset($_REQUEST['show_lead_status']))
														echo "<a href=\"javascript:restoreLeadEntry('".$value['status_id']."','settings','restore_status','status')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";
													}	
										?>
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
            </div>
            <!-- END Main Content -->
            <div style="clear:both;"></div>

            <!-- **************************** SubStatus************************************* -->
            <!-- Main Content -->
            <div id="main-content" style="width:100%; margin-bottom:25px;">
            	 <input type="hidden" name="show_substatus" id="show_substatus" value="" />
            	<input type="hidden" name="sub_status_id" id="sub_status_id" value="<?php if(isset($data['substatusDetails']))  echo $data['substatusDetails']['substatus_id']; ?>" />
                <!-- All Users -->
                <h2 id="substatus">Substatus (<?php echo sizeof($data['allSubStatus'])?>)</h2>                
                 <div class="show_links" style="left:360px;">
                            	<a href="javascript:show_lead_configuration(0, 'settings', 'show_configuration','sub_status')" <? if(isset($_REQUEST['show_substatus']))if($_REQUEST['show_substatus'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts_substatus']['all']?>)</a><span> | </span>
                            	<a href="javascript:show_lead_configuration(1, 'settings', 'show_configuration','sub_status')" <? if(isset($_REQUEST['show_substatus']))if($_REQUEST['show_substatus'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts_substatus']['active']?>)</a><span> | </span>
                            	<a href="javascript:show_lead_configuration(2, 'settings', 'show_configuration','sub_status')" <? if(isset($_REQUEST['show_substatus']))if($_REQUEST['show_substatus'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts_substatus']['deleted']?>)</a>
                 </div>               
                <div class="body-con lead_config">
                	<div id="side-content-left">
                    	<?php if(isset($data['from']) && ($data['from'] == 'substatus')) { 
							  	if(array_key_exists('type',$notificationArray)) {
                                	if($notificationArray['type'] == "Success") { ?>
                                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                                    <?php }  else  if($notificationArray['type'] == "Failed") { ?>
                                        <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                              <?php  }
							  	}
                              } ?>         
                    	<h3><?php  if(isset($data['substatusDetails'])) { echo "Edit Substatus";} else { echo "Add Substatus";}  ?></h3>
                        <div class="body-con">
                        	<label for="status">Status <span>*</span></label>
                             <?php									   		
								if(isset($data['substatusDetails']))
									createComboBox('status_id','status_id','status_name',$data['allStatus'],FALSE,$data['substatusDetails']['status_id']);
								else	
									createComboBox('status_id','status_id','status_name',$data['allStatus'],FALSE);
							   ?>                                           
                            <label for="substatus_name">Substatus Name <span>*</span></label>
                            <input type="text" id="substatus_name" name="substatus_name"  value="<?php if(isset($data['substatusDetails']))  echo $data['substatusDetails']['substatus_name']; ?>" />
                            <?php if(isset($data['substatusDetails'])) {    ?>     
                                    <input type="button" value="Update" class="green_button"  onclick="javascript:updateSubstatus('<?php echo $data['substatusDetails']['substatus_id']?>','settings','edit_substatus_entry')" >
                            <?php } else { ?>
                            <input type="button" value="Insert" class="green_button"  onclick="javascript:addSubstatus('settings','add_substatus')" >
                            <?php } ?>
                        </div>                    
                    </div>                
                	<!-- END Sidebar -->
                	 <div id="main-content-right" style="width:82%">           
                        <!-- Users table --> 
                        <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    
                                    <th>Substatus Name</th>
                                    <th>Status Name</th>
                                    <th style="width:15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?
                                    $cnt = 1;
                                   foreach($data['allSubStatus'] as $value)
                                   {
                                       ?>
                                        <tr>
                                            
                                            <td class="backcolor"><?=$value['substatus_name']; ?></td>
                                            <td><?=$value['status_name']; ?></td>
                                            <td style="width:15%" nowrap="nowrap">
                                             <? if($value['is_active'] != 0){?> 
                                            <a href="javascript:openEditSubStatus('<?=$value['substatus_id']?>','settings','edit_substatus')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                            &nbsp;&nbsp;&nbsp;<a href="javascript:openDeleteSubStatus('<?=$value['substatus_id']?>','<?=$value['substatus_name']?>','settings','delete_substatus')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>  
                                             <? }else{
													if(isset($_REQUEST['show_substatus']))
														echo "<a href=\"javascript:restoreLeadEntry('".$value['substatus_id']."','settings','restore_substatus','sub_status')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";
													}	
										?>
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
            </div>
            <!-- END Main Content -->
            <div style="clear:both;"></div>                                  
        
        
            <!-- **************************** Source************************************* -->
            <!-- Main Content -->
			<div id="main-content" style="width:100%; margin-bottom:25px;">
            	 <input type="hidden" name="show_source" id="show_source" value="" />
            	<input type="hidden" name="source_id" id="source_id" value="<?php if(isset($data['sourceDetails']))  echo $data['sourceDetails']['source_id']; ?>" />
                
                <h2  id="source">Source (<?=sizeof($data['allSource'])?>)</h2>                
                 <div class="show_links" style="left:360px;">
                            	<a href="javascript:show_lead_configuration(0, 'settings', 'show_configuration','source')" <? if(isset($_REQUEST['show_source']))if($_REQUEST['show_source'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts_source']['all']?>)</a><span> | </span>
                            	<a href="javascript:show_lead_configuration(1, 'settings', 'show_configuration','source')" <? if(isset($_REQUEST['show_source']))if($_REQUEST['show_source'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts_source']['active']?>)</a><span> | </span>
                            	<a href="javascript:show_lead_configuration(2, 'settings', 'show_configuration','source')" <? if(isset($_REQUEST['show_source']))if($_REQUEST['show_source'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts_source']['deleted']?>)</a>
                 </div>                
                <div class="body-con lead_config">
                	<div id="side-content-left">
                    	<?php if(isset($data['from']) && ($data['from'] == 'source')) { 
							  	if(array_key_exists('type',$notificationArray)) {
                                	if($notificationArray['type'] == "Success") { ?>
                                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                                    <?php }  else  if($notificationArray['type'] == "Failed") { ?>
                                        <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                              <?php  }
							  	}
                              } ?>         
                    	<h3><?php  if(isset($data['sourceDetails'])) { echo "Edit Source";} else { echo "Add Source";}  ?></h3>
                        <div class="body-con">
                        	<label for="source_name">Source Name<span>*</span> </label>
                            <input type="text" id="source_name" name="source_name"  value="<?php if(isset($data['sourceDetails'])) echo $data['sourceDetails']['source_name']; ?>"/>                                       
                            <?php if(isset($data['sourceDetails'])) {    ?>     
                                <input type="button" value="Update" class="green_button"  onclick="javascript:updateSource('<?php echo $data['sourceDetails']['source_id']?>','settings','edit_source_entry')" >
                            <?php } else { ?>
                            	<input type="button" value="Insert" class="green_button" onclick="javascript:addSource('settings','add_source')" >
                            <?php } ?>
                        </div>                    
                    </div>                
                	<!-- END Sidebar -->
                 	<div id="main-content-right" style="width:82%">         
                        <!-- Users table --> 
                        <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    
                                    <th>Source Name</th>
                                    <th style="width:15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?
                                    $cnt = 1;
                                   foreach($data['allSource'] as $value)
                                   {
                                       ?>
                                        <tr>
                                            
                                            <td class="backcolor"><?=$value['source_name']; ?></td>
                                            
                                            <td style="width:15%" nowrap="nowrap">
                                             <? if($value['is_active'] != 0){?> 
                                            <a href="javascript:openEditSource('<?=$value['source_id']?>','settings','edit_source')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                            &nbsp;&nbsp;&nbsp;<a href="javascript:openDeleteSource('<?=$value['source_id']?>','<?=$value['source_name']?>','settings','delete_source')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>  
                                            </td>
                                             <? }else{
													if(isset($_REQUEST['show_source']))
														echo "<a href=\"javascript:restoreLeadEntry('".$value['source_id']."','settings','restore_source','source')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";
													}	
										?>
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

            <div style="clear:both;"></div>
            </div>            

    </div>
    <!-- END Content -->
<script>
$(document).ready( function () {
	<? if($function == "edit_source" || $function == "delete_source" || $function == "add_source" || $function == "edit_source_entry" || $_REQUEST['hidden'] == "source") {?>
		document.getElementById('source').scrollIntoView();
	<? }else if ($function == "edit_substatus" || $function == "delete_substatus" || $function == "add_substatus" || $function == "edit_substatus_entry" || $_REQUEST['hidden'] == "sub_status") { ?>
		document.getElementById('substatus').scrollIntoView();
	<? } ?>		
});
</script>