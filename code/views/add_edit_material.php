<?
if($function == 'edit_material') {   
?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['materialDetails']['material_id']?>" />
<? 
}
//echo "<pre>"; print_r($data);
?>
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="singlecolm_form">
                            
                            <!-- Messages -->
                         
                            <h2><? if($function=='show_add_material') { echo "Add Material"; } else { echo "Edit Material";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label for="material_name">Material Name <span>*</span></label>
                                            <input type="text" id="material_name" name="material_name"  value='' />

										</li>
                                        <li>
                                            <label for="material_code">Item Code <span>*</span></label>
                                            <input type="text" id="material_code" name="material_code"  value='' />

										</li>
                                        <li>
                                            <label for="material_cost">Basic Cost <span>*</span></label>
                                            <input type="text" id="material_cost" name="material_cost"  value='' />

										</li>
                                        
                                        
                                        <li>
                                            <label></label>
                                            <?  if($function == 'edit_material') {    ?>     
                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateMaterial('<?=$data['materialDetails']['material_id']?>','materials','edit_material_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addMaterial('materials','add_material')" >
                                           <? } ?>
                                            <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('materials','view_material')" /> 
                                        </li>

									</ul>
							</div>                            
                            
                           
                            
                        </div>
						</div>
                        <!-- END Main Content -->
                   <?
                   if($function == 'edit_material') {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
							<? foreach($data['materialDetails'] as $key=>$value ) { 
									
									?>
										$('#<?=$key;?>').val('<?=addslashes($value)?>');
							<? 		
								} ?>	
								
								
						});
                   </script>
                   
                   <? } ?>