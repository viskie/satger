<script type="text/javascript">
$(document).ready( function () {
});
</script>

<?
if($function == 'edit_inventory') {   
?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['inventoryDetails']['inventory_id']?>" />
<? 
}
//echo "<pre>"; print_r($data);
?>


                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function=='show_add_inventory') { echo "Add Inventory"; } else { echo "Edit Inventory";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        
                                        <li>
											 <label for="product_id">Product <span></span></label>
                                    		 <?
										//var_dump($data['allEmployees']);exit;
										if($function == 'show_add_inventory')
										{
											createComboBox('product_id','product_id','product_name', $data['allProducts'], true);
										}
										if($function == 'edit_inventory')
										{	
											createComboBox('product_id','product_id','product_name', $data['allProducts'], true, $data['inventoryDetails']['product_id']);
										}
										?>
										
                                        
											 <label for="warehouse_id">Warehouse <span></span></label>
                                    		 <?
										//var_dump($data['allEmployees']);exit;
										if($function == 'show_add_inventory')
										{
											createComboBox('warehouse_id','warehouse_id','name', $data['allWarehouses'], true);
										}
										if($function == 'edit_inventory')
										{	
											createComboBox('warehouse_id','warehouse_id','name', $data['allWarehouses'], true, $data['inventoryDetails']['warehouse_id']);
										}
										?>
										
                                        </li>
                                        <li>
										<label for="basic_cost">Basic Cost of Inventory <span>*</span></label>
                                    	<input type="text" id="basic_cost" name="basic_cost" />
                                    
										
											<label for="units">Units <span>*</span></label>
                                    		<input type="text" id="units" name="units" />
                                           </li>
                                           
                                           <li>
										
											<label for="remarks">Remarks <span></span></label>
                                    <textarea id="remarks" name="remarks" ><? if($function == 'edit_inventory'){ echo $data['inventoryDetails']['remarks']; }?></textarea>
                                        </li>
                                        
                                        
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_inventory') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateInventory('<?=$data['inventoryDetails']['inventory_id']?>','inventory','edit_inventory_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addInventory('inventory','add_inventory')" >
                                           <? } ?>
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('inventory','view_inventory')" /> 
                                        </li>

									</ul>
							</div>
                            
                            
                           
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_inventory') {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
								<? foreach($data['inventoryDetails'] as $key=>$value ) { 
										$value=shownlInjs($value);
								?>
										$('#<?=$key;?>').val('<?=($value)?>');
								<? } ?>	
								
								
									//$('#user_password').val('');									
						});
						
                   </script>
                   <? } ?>
                   
                  
