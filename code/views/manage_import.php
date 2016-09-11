<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

?>
<input type="hidden" name="edit_id" value="" id="edit_id" />

					<!-- Content -->
					<div id="content" class="clearfix">

                        <!-- Sidebar -->
                        <div id="main-content">   
                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                            <!-- Roles box -->
                            
                            <!-- END Roles box -->
                            
                          
                       

                        </div>
                        <!-- END Sidebar -->

                        <!-- Main Content -->
                        <div id="main-content" class="singlecolm_form">
                        	<h2>Import</h2>
                            
                            <div class="body-con"> 
                                <ul class="align-list">
                                    <li>
                                    <label for="select_table">Select Table name <span></span></label>
                                       <? createComboBox('table_name',"Tables_in_$database","Tables_in_$database", $tables); ?>
                                       <input type="file" name="file" id="file" size="40">
                                      </li>
                                      <li>
                                      	<label></label>
                                        <input type="button" value="Submit" class="green_button"  onclick="javascript:callPage('settings','execute_imported')" >
                                    </li>
                                </ul>
							</div>
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->
