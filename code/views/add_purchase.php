<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data['productName']);exit;
$i=1;
?>
<input type="hidden" name="edit_id" value="" id="edit_id" />

					 <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content">
                            
                            <!-- Messages -->
                            <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                                <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                              <? }  else  if($notificationArray['type'] == "Failed") { ?>
                              <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                              <?   } } ?>	
                         	<h2>
							<? if($function == 'add_purchase')  { echo "Add Purchase"; } 
							   else { echo "Purchase Details";} 
							?>
                            </h2>		 
                            <div class="body-con">

                                    <ul class="align-list">
                                        <style>
										
										.purchase td{
											border:none;
											text-align: left;
										}
										
										#purchase_lines td{
											border: 1px solid #CCCCCC;
										}
										
										.purchase_value{
											text-align:left;	
										}
										
										</style>
                                      <table  class="purchase">
                                      <tr>
                                      		<td <? if($function == "view_purchase_details") { echo "style='text-align:right;'";}?>><label for="reciept_no">Receipt No <span><? if($function == "view_purchase_details") { ?>:<? }else{ echo"*";}  ?></span></label></td>
                                    		<? if($function == "view_purchase_details") { ?>
                                            	<td><label class="purchase_value"><? echo $data['purchase']['reciept_no']; ?></label></td>
                                            <? }else{ ?>	
                                            	<td><input type="text" id="reciept_no" name="reciept_no" value='<? if($is_exist == true){ echo $data['purchaseDetails']['reciept_no']; }?>' /></td>
											<? } ?>
                                             	
                                           	<td <? if($function == "view_purchase_details") { echo "style='text-align:right;'";}?>><label for="purchase_date">Date <span><? if($function == "view_purchase_details") { echo":";}?></span></label></td>
                                           	<? if($function == "view_purchase_details") { ?>
                                           		<td><label class="purchase_value"><? echo formatDate($data['purchase']['purchase_date']); ?></label></td>
                                           	<? }else{ ?>
                                           		<td><input type="text" id="purchase_date"  />
                                            	<input type="hidden" id="purchase_date_alt" name="purchase_date" size="30" value='<? if($is_exist == true){ echo $data['purchaseDetails']['purchase_date']; }?>' /></td>
                                            <? } ?>
                                     </tr>
                                      <tr>   	
											<td <? if($function == "view_purchase_details") { echo "style='text-align:right;'";}?>><label for="warehouse">Warehouse <span><? if($function == "view_purchase_details") { ?>:<? }else{ echo"*";}?></span></label>	</td>
                                            <? if($function == "view_purchase_details") { ?>
                                           		<td><label class="purchase_value"><? echo $data['warehouse']['name']; ?></label></td>
                                           	<? }else{ ?>
                                            	<? if($is_exist == true) { ?>
                                                	<td><? createComboBox('warehouse_id','warehouse_id','name', $data['allWarehouses'],true,$data['purchaseDetails']['warehouse_id'])
												?></td>
                                                <? }else{?>
												<td><? createComboBox('warehouse_id','warehouse_id','name', $data['allWarehouses'],true)
												?></td>
                                            <? }} ?>
                                            
                                            <td <? if($function == "view_purchase_details") { echo "style='text-align:right;'";}?>><label for="supplier">Supplier <span><? if($function == "view_purchase_details") { ?>:<? }else{ echo"*";} ?></span></label></td>
                                             <? if($function == "view_purchase_details") { ?>
                                           		<td><label class="purchase_value"><? echo $data['supplier']['supplier_name']; ?></label></td>
                                           	<? }else{ ?>
											<? if($is_exist == true) { ?>
                                                	<td><? createComboBox('supplier_id','supplier_id','supplier_name',  $data['allSuppliers'],true,$data['purchaseDetails']['supplier_id']); ?>
												</td>
                                                <? }else{ ?>	
												<td><? createComboBox('supplier_id','supplier_id','supplier_name', $data['allSuppliers'],true) ?>
												</td>
                                            <? } }?>
                                       </tr>
                                       <tr>
                                       <td colspan="4">
                                           <table id="purchase_lines" style="width: 60%;margin: auto;">
                                            <tr>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th class="amount_col">Unit Cost</th>
                                                <th class="amount_col">Total Cost</th>
                                            </tr>
                                            <? if($function == "view_purchase_details") { ?>
                                             	<? for($i=0; $i<count($data['purchaseDetails']); $i++) {?>
                                                	<tr>
                                                    	<td><label><?=$data['productName'][$i]['product_name']?></label></td>
                                                    	<td><label><?=$data['purchaseDetails'][$i]['quantity']?></label></td>
                                                        <td class="amount_col"><label><?=number_format($data['purchaseDetails'][$i]['unit_cost'],2)?></label></td>
                                                        <td class="amount_col"><label><?=number_format($data['purchaseDetails'][$i]['total_cost'],2)?></label></td>
                                                    </tr>
												<? } ?> 	
                                             <? }else{ ?>
                                            <? 
													if($is_exist == true) { 
													foreach($data['purchase'] as $value){	
												?>
														<tr>
															<td><? createComboBox('product_id[]','product_id','product_name',$data['allProducts'],true,$value['product_id']) ?>	</td>
															<td><input type="text" name="quantity[]" class="quantity" value="<? echo $value['quantity']; ?>" /></td>
															<td><input type="text" name="unit_cost[]" class="unit_cost" value="<? echo $value['unit_cost']; ?>" /></td>
															<td><input type="text" name="total_cost[]" class="total_cost" value="<? echo $value['total_cost']; ?>" /></td>	
															<td><img src="img/minus.png" class="remove_this_tr"/></td>
													   </tr>
													 <? } ?>  
												<?}else{ ?>
													<tr>
														<td><? createComboBox('product_id[]','product_id','product_name', $data['allProducts'],true,'','','Please Select','class=\'product_dropdown less_width\' onchange=change_product_dropdown(this);')
											?></td>
														<td><input type="text" name="quantity[]" class="quantity" value="" /></td>
														<td><input type="text" name="unit_cost[]" class="unit_cost" value="" /></td>
														<td><input type="text" name="total_cost[]" class="total_cost" value="" /></td>	
														<td><img src="img/minus.png" class="remove_this_tr"/></td>
												   </tr>
												<? } ?>  
                                           <tr><td colspan="5"><img src="img/plus.png" style="float: right;" id="add_one_record"/></td></tr>
                                           <? } ?>
                                        </table>
                                       </td>
                                       </tr>
                                       <tr>
                                       		<td <? if($function == "view_purchase_details") { echo "style='text-align:right;'";}?>><label for="tax">Tax (in amount)<span><? if($function == "view_purchase_details") { echo":";}?></span></label></td>
                                             <? if($function == "view_purchase_details") { ?>
                                           		<td class="amount_col"><label class="purchase_value"><? echo number_format($data['purchase']['tax'],2); ?></label></td>
                                           	<? }else{ ?>
                                    			<td><input type="text" id="tax" name="tax" value='<? if($is_exist == true){ echo $data['purchaseDetails']['tax']; }else{ echo "0.0"; }?>' /></td>
                                            <? } ?>
                                            
                                            <td <? if($function == "view_purchase_details") { echo "style='text-align:right;'";}?>><label for="discount">Discount (in amount)<span><? if($function == "view_purchase_details") { echo":";}?></span></label></td>
                                            <? if($function == "view_purchase_details") { ?>
                                           		<td class="amount_col"><label class="purchase_value"><? echo number_format($data['purchase']['discount'],2); ?></label></td>
                                           	<? }else{ ?>
                                    			<td><input type="text" id="discount" name="discount" value='<? if($is_exist == true){ echo $data['purchaseDetails']['discount']; }else{ echo "0.0"; }?>' /></td>
                                            <? } ?>
                                        </tr>
                                        <tr>
                                            <td <? if($function == "view_purchase_details") { echo "style='text-align:right;'";}?>><label for="total_invoice_amount">Total Invoice Amount <span><? if($function == "view_purchase_details") { echo":";}?></span></label></td>
                                            <? if($function == "view_purchase_details") { ?>
                                           		<td class="amount_col"><label class="purchase_value"><? echo number_format($data['purchase']['total_invoice_amount'],2); ?></label></td>
                                           	<? }else{ ?>
                                    			<td><input type="text" id="total_invoice_amount" name="total_invoice_amount" value='<? if($is_exist == true){ echo $data['purchaseDetails']['total_invoice_amount']; }else{ echo "0.0"; }?>' /></td>
											<? } ?>
                                            <td colspan="2"></td>
                                        </tr>
										<tr><td>
										 	<label></label>
											<? if($function == "view_purchase_details") { ?>
                                            <input type="button" value="Back" class="green_button"  onclick="javascript:callPage('materials','view_purchase')" >
                                        	<? }else{ ?>
                                            <input type="button" value="Submit" class="green_button"  onclick="javascript:addPurchase('materials','add_purchase')" >
										    <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('materials','view_purchase')" /> 
											<? } ?>
                                            
                                            </td></tr>
                                        </table> 
                                    </ul>
							</div>
                        </div>
						</div>
                        <!-- END Main Content -->
<script>
$(document).ready(function(e) {
	$( "#purchase_date" ).datepicker({
			dateFormat: "d-M-yy",
			altField: "#purchase_date_alt",
			changeMonth: true,
			changeYear: true,
      		altFormat: "yy-mm-dd"
		});
		
		$("#purchase_date").datepicker('setDate', new Date());
});
</script>
<script>
$(document).ready(function(e) {
		single_record = "<tr><td><?  createComboBox('product_id[]','product_id','product_name', $data['allProducts'],true,'','','Please Select','class=\"product_dropdown\" onchange=\"change_product_dropdown(this)\"') ?></td><td><input type='text' name='quantity[]' class='quantity' value='' /></td><td><input type='text' name='unit_cost[]' class='unit_cost' value='' /></td><td><input type='text' name='total_cost[]' class='total_cost' value='' /></td><td><img src='img/minus.png' class='remove_this_tr' /></td></tr>";
	
	/* Add one row after last record after clicking on plus img*/
	$("#add_one_record").click(function(e) {
		//single_record_str=single_record1+product_combobox+single_record2;
		var current_sel = $("#purchase_lines tr").last().before(single_record).prev().find('select');
		$(current_sel).uniform();
		$(current_sel).closest('.selector').addClass('small_sel');
		$(current_sel).find('option').each(function()
		{ 
			if(unique_exclude_product.indexOf($(this).val()) !== -1)
			{   		
				$(this).attr('disabled', true);
				$(this).css({backgroundColor: '#EAEAEA'});
			}
		});
					
	});
	
	/* Remove one row after clicking on minus img*/
	$("table").delegate('.remove_this_tr','click', function(e) {
		if(confirm("Do you really want to remove this item ?")){
			var current_drpdwn = $(this).closest('tr').find(".product_dropdown").val();
			
			$('select.product_dropdown').each(function() 
			{  				
				$(this).find('option').each(function() 
				{   
					if($(this).val() == current_drpdwn) 
					{		
						$(this).removeAttr('disabled');
						$(this).css({backgroundColor: '#FFFFFF'});
					}
				});		
			});		
			
			$(this).closest('tr').remove();
			$('.total_cost').last().change();
			return false;
		}
	});
	
	/* validations for Quantity*/
	
   
	$("table").delegate('.quantity','blur',function(){ //focusout
		
		//var units=$(this).closest('tr').find('.quantity').attr("original_value");
		var dropdown_val = $(this).closest('tr').find('.product_dropdown').val();
		if(dropdown_val > 0)
		{
			var units=$(this).closest('tr').find('.qntity').html(); 
			units = parseInt(units);
			
			quantity_value = this.value;
			if(quantity_value == "")
			{
				alert("Please enter quantity!");
				//$(this).closest('tr').find(".quantity").focus();
				$(this).focus();
				return false;
			}
			else
			{
				quantity_value = parseInt(quantity_value);
				if(isNaN(quantity_value)){
						alert("Please enter numeric values in quantity!");
						$(this).val('');
						$(this).focus();
						return false;
					}
					else if (Math.floor(quantity_value) != quantity_value) {
					  alert("Please enter non decimal value!");
					  $(this).val('');
					  $(this).focus();
					  return false;
					}
					else if(quantity_value > units && units >0)
					{
						alert("Only "+units+" are available in Inventory!");
						$(this).val('');
						$(this).focus();
						return false;
						
					}
					else
					{
						var this_unit_cost=$(this).closest('tr').find('.unit_cost').val();
						if(this_unit_cost!=""){
							total = Math.round((parseFloat(quantity_value)*parseFloat(this_unit_cost))*100)/100; 
							$(this).closest('tr').find('.total_cost').val(total).change();
					}
				}					
			}
			
		}
	});
	
	/* validations for Unit Cost*/
	var unit_cost_value;
	$("table").delegate('.unit_cost','focusout',function(){		
		
		var dropdown_val = $(this).closest('tr').find('.quantity').val();
		if(dropdown_val != "")
		{
			unit_cost_value = this.value;
			if(unit_cost_value == "")
			{
				alert("Please enter unit cost valus!");
				$(this).focus();
				return false;
			}
			else if(isNaN(unit_cost_value)){
				alert("Please enter numeric values in unit cost!");
				$(this).focus();
				return false;
			}else{
				var this_quantity=$(this).closest('tr').find('.quantity').val();
				if(this_quantity!=""){
					total = Math.round((parseFloat(unit_cost_value)*parseFloat(this_quantity))*100)/100; 
					$(this).closest('tr').find('.total_cost').val(total).change();
				}
			}
		}
	});
	
	
	$("table").delegate('.total_cost','change',function(){
		var grand_total=0;
		$('.total_cost').each(function(index, element) {
			if($(this).val()!=""){
	            grand_total+=parseFloat($(this).val());
			}
        });
		grand_total=grand_total+parseFloat($("#tax").val())-parseFloat($("#discount").val());
		grand_total= Math.round(grand_total*100)/100; 
		$("#total_invoice_amount").val(grand_total);
	});
	
	$("table").delegate('#tax','change',function(){
		var grand_total=0;
		$('.total_cost').each(function(index, element) {
			if($(this).val()!=""){
	            grand_total+=parseFloat($(this).val());
			}
        });
		grand_total=grand_total+parseFloat($("#tax").val())-parseFloat($("#discount").val());
		grand_total= Math.round(grand_total*100)/100; 
		$("#total_invoice_amount").val(grand_total);
	});
	
	$("table").delegate('#discount','change',function(){
		var grand_total=0;
		$('.total_cost').each(function(index, element) {
			if($(this).val()!=""){
	            grand_total+=parseFloat($(this).val());
			}
        });
		grand_total=grand_total+parseFloat($("#tax").val())-parseFloat($("#discount").val());
		grand_total= Math.round(grand_total*100)/100; 
		$("#total_invoice_amount").val(grand_total);
	});

	
});
</script>