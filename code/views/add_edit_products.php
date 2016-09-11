<?
if($function == 'edit_product' || ( $is_edit == true && $is_exist == true)) {   
?>
<input type="hidden" name="product_id" id="product_id" value="<?=$data['productDetails']['product_id']?>" />
<? 
 }
//echo "<pre>"; print_r($data);
?>
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                         <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                            <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                         <? }  else  if($notificationArray['type'] == "Failed") { ?>
                         	<div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                         <?   } } ?>
                        <div id="main-content" class="singlecolm_form" >
                            
                            <!-- Messages -->
                         
                            <h2><? if($function=='show_add_product') { echo "Add Product"; } else { echo "Edit Product";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label>Product Name <span>*</span></label>
                                            <input type="text" id="product_name" name="product_name"  value='' />

										</li>
                                        <li>
                                            <label>Item Code <span>*</span></label>
                                            <input type="text" id="item_code" name="item_code"  value='' />

										</li>
                                        <li>
                                            <label>Basic Cost <span>*</span></label>
                                            <input type="text" id="basic_cost" name="basic_cost"  value='' />

										</li>
                                        
                                        
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_product' || ( $is_edit == true && $is_exist == true)) {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateProduct('<?=$data['productDetails']['product_id']?>','products','edit_product_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addProduct('products','add_product')" >
                                           <? } ?>
                                           <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('products','view')" /> 
                                        </li>

									</ul>
							</div>                            
                            
                           
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_product' || $is_exist == true) {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
							<? foreach($data['productDetails'] as $key=>$value ) { 
									
									?>
										$('#<?=$key;?>').val('<?=addslashes($value)?>');
							<? 		
								} ?>	
								
								
						});
                   </script>
                   
                   <? } ?>