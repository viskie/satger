<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
?>
<?  if($function == 'edit_warehouse') {    ?> 
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['warehouseDetails']['warehouse_id']?>" />
<? } ?>
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function == 'show_add_warehouse') { echo "Add Warehouse"; } else { echo "Edit Warehouse";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                        	<label>Code <span>*</span></label>
                                            <input type="text" id="warehouse_code" name="warehouse_code"  value='' />
                                            
											<label>Name <span>*</span></label>
                                            <input type="text" id="name" name="name"  value='' />
										</li>
                                        <li>
                                        	<label for="address">Address <span>*</span></label>
                                            <textarea id="address" name="address" ><? if($function == 'edit_warehouse'){ echo $data['warehouseDetails']['address']; }?></textarea>
                                            
                                            <label for="franchise_id">Franchise <span>*</span></label>
                                            <?
											if(isset($data['warehouseDetails']))
											{					
												createComboBox('franchise_id','franchise_id','franchise_name', $data['allFranchise'], true, $data['warehouseDetails']['franchise_id'],"",'Please Select','class=\"validate[required]\"');
											}
											else 
											{	if(isset($data['warehouseVariables']))
													$selected_franchise = $data['warehouseVariables']['franchise_id'];
												else
													$selected_franchise = '';
												
												createComboBox('franchise_id','franchise_id','franchise_name', $data['allFranchise'], true,$selected_franchise,"",'Please Select','class=\"validate[required]\"');
											}
											?> 
                                        </li>
                                        <li>
                                        	<label for="city">City <span>*</span></label>
                                            <input type="text" id="city" name="city"  value='' />
                                            
                                            <label for="state">State <span>*</span></label>
                                            <input type="text" id="state" name="state"  value='' />
                                        </li>
                                        <li>
                                        	<label for="country">Country <span>*</span></label>
                                            <input type="text" id="country" name="country"  value='' />
                                            
                                            <label for="zip">Zip Code<span>*</span></label>
                                            <input type="text" id="zip" name="zip"  value='' />	
                                        </li>
                                        <li>
                                        	<label for="note">Note <span></span></label>
                                            <textarea id="note" name="note" ></textarea>
                                        </li>
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_warehouse') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateWarehouse('<?=$data['warehouseDetails']['warehouse_id']?>','inventory','edit_warehouse_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addWarehouse('inventory','add_warehouse')" >
                                           <? } ?>
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('inventory','view_warehouse')" /> 
                                        </li>
									</ul>
							</div>
                         
                                <!-- END Add Warehouse Form -->
                                
                        <!--    </div> -->
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_warehouse') {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
								<? foreach($data['warehouseDetails'] as $key=>$value ) { 
										$value=shownlInjs($value);
								?>
										$('#<?=$key;?>').val('<?=($value)?>');
								<? } ?>					
						});
                   </script>
                   
                   <? } ?>