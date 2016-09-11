<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
?>
<?  if($function == 'edit_supplier') {    ?> 
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['supplierDetails']['supplier_id']?>" />
<? } ?>
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="twocolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function == 'show_add_supplier') { echo "Add Supplier"; } else { echo "Edit Supplier";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
											<label>Name <span>*</span></label>
                                            <input type="text" id="supplier_name" name="supplier_name"  value='' />
                                            
                                            <label for="email">Email <span>*</span></label>
                                            <input type="text" id="email" name="email"  value='' />
										</li>
                                        <li>
										
											<label for="currency">Currency <span>*</span></label>
                                            <input type="text" id="currency" name="currency"  value='' />
										
                                        	<label for="address">Address <span>*</span></label>
                                            <textarea id="address" name="address" ></textarea>
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
                                        	<label for="phone1">Phone 1<span>*</span></label>
                                            <input type="text" id="phone1" name="phone1"  value='' />
                                            
                                            <label for="phone2">Phone 2<span></span></label>
                                            <input type="text" id="phone2" name="phone2"  value='' />
                                        </li>
                                        
                                       
										
										<li>
                                            <label></label>
                                            <?  if($function == 'edit_supplier') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateSupplier('<?=$data['supplierDetails']['supplier_id']?>','materials','edit_supplier_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addSupplier('materials','add_supplier')" >
                                           <? } ?>
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('materials','view_supplier')" /> 
                                        </li>
									</ul>
							</div>
                         
                                <!-- END Add user form -->
                                
                        <!--    </div> -->
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_supplier') {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
								<? foreach($data['supplierDetails'] as $key=>$value ) { 
										$value=shownlInjs($value);
								?>
										$('#<?=$key;?>').val('<?=($value)?>');
								<? } ?>					
						});
                   </script>
                   
                   <? } ?>
                   
                   
