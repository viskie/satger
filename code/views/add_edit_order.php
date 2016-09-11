<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
extract($data);

?>
<style>                
.sale td{
	border:none;
	text-align: left;
}

#sale_lines td{
	border: 1px solid #CCCCCC;
}

.sale_value{
	text-align:left;	
}
.inner tr,th,td{
   border:1px;
}
.avail_qnty
{
	padding-left:10px;
	float:left;
}
.qntity
{
	float:right;
}

</style>
 <!-- Main Content -->
    <div id="content" class="clearfix">
    
    <div id="main-content">        
        <!-- Messages -->
        <h2>Order Details</h2>		 
        <div class="body-con">
             <table cellpadding="0" cellspacing="0" border="0" align="center" class="sale">
             	 <input type="hidden" name="edit_id" value="<?php if( isset($is_edit) && ( $is_edit == "yes") && (isset($order_data[0]['order_id']))) echo $order_data[0]['order_id'];?>" id="edit_id" />
                 <input type="hidden" name="show_status" name="show_status" value="<?php if(isset($show_status) && ($show_status != '')) echo $show_status; ?>" />
                  <tr>
                        <td <?php if( isset($is_edit) && ( $is_edit == "no")) { echo "style='text-align:right;'";}?>>
                            <label for="reciept_no">Receipt No <span><?php if( isset($is_edit) && ( $is_edit == "no")) { ?>:<?php }else{ echo"*";}  ?></span></label>
                        </td>
                        <td>
                        <?php if( isset($is_edit) && ( $is_edit == "no")) { ?>
                            <label class="sale_value"><?php if(isset($order_data[0]['reciept_no'])) echo $order_data[0]['reciept_no']; ?></label>
                        <?php }else{ ?>	
                            <input type="text" id="txtrecieptno" name="txtreciept_no" value="<?php if(isset($is_edit) && ($is_edit == "yes") && isset($order_data)) echo $order_data[0]['reciept_no'];?>" />
                        <?php } ?>
                       </td>
                            
                        <td <?php if( isset($is_edit) && ( $is_edit == "no")) { echo "style='text-align:right;'";}?>>
                            <label for="sale_date">Date <span><?php if( isset($is_edit) && ( $is_edit == "no")) { echo":";}?></span></label>
                        </td>
                        <td>
                        <?php if( isset($is_edit) && ( $is_edit == "no")) { ?>
                            <label class="sale_value"><?php if(isset($order_data[0]['order_date'])) echo formatDate($order_data[0]['order_date']); ?></label>
                        <?php }else{ ?>
                            <input type="text" id="orderdate"  />
                            <input type="hidden" id="txtorderdate_alt" name="txtorderdate_alt" size="30" value='' />
                        <?php } ?>
                        </td>
                 </tr>
                 <tr>   	
                        <td <?php if( isset($is_edit) && ( $is_edit == "no")) { echo "style='text-align:right;'";}?>>
                        	<label for="warehouse">Warehouse <span><?php if( isset($is_edit) && ( $is_edit == "no")) { ?>:<?php }else{ echo"*";}?></span></label>	
                        </td>
                        <td>
                        <?php if( isset($is_edit) && ( $is_edit == "no")) { ?>
                            <label class="sale_value"><?php if(isset($order_data[0]['warehouse_id'])) echo $order_data[0]['warehouse_id']; ?></label>
                        <?php }else{ 
									if(isset($is_edit) && ($is_edit == "yes") && isset($order_data)) 
										createComboBox('warehouse_id','warehouse_id','name', $allWarehouses,true, $order_data[0]['warehouse_id']);
									else 	
                            			createComboBox('warehouse_id','warehouse_id','name', $allWarehouses,true);
                           } ?>
                        </td>
                        <td <?php if( isset($is_edit) && ( $is_edit == "no")) { echo "style='text-align:right;'";}?>>
                        	<label for="supplier">Client <span><?php if( isset($is_edit) && ( $is_edit == "no")) { ?>:<?php }else{ echo"*";} ?></span></label>
                        </td>
                        <td>
                         <?php if( isset($is_edit) && ( $is_edit == "no")) { ?>
                            <label class="sale_value"><?php if(isset($order_data[0]['client_id'])) echo  $order_data[0]['client_id']; ?></label>
                        <?php }else{ 
									if(isset($is_edit) && ($is_edit == "yes") && isset($order_data)) 
										createComboBox('client','client_id','client_name',  $allClients,'','','client_biz_name',$order_data[0]['client_id']); 
									else
							 			createComboBox('client','client_id','client_name',  $allClients,'','','client_biz_name'); 
							  } ?>
                        </td>
                   </tr>
                   <tr>
                       <td colspan="4">                   
                           <table id="sale_lines" style="width: 60%;margin: auto;" class="inner">
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                            </tr>
                             <?php if( isset($is_edit) && ( $is_edit == "no")) { ?>
                                <?php for($i=0; $i<count($order_details); $i++) {?>
                                    <tr>
                                        <td><label><?php if(isset($order_details[$i]['product_name'])) echo $order_details[$i]['product_name'];?></label></td>
                                        <td><label><?php if(isset($order_details[$i]['quantity'])) echo $order_details[$i]['quantity']?></label></td>
                                        <td><label><?php if(isset($order_details[$i]['unit_cost'])) echo $order_details[$i]['unit_cost']?></label></td>
                                        <td><label><?php if(isset($order_details[$i]['total_cost'])) echo $order_details[$i]['total_cost']?></label></td>
                                    </tr>
                                <?php } ?> 	
                             <?php }
							 elseif(isset($is_edit) && ( $is_edit == "yes") && isset($order_details))
							 {	 //echo "<pre>"; print_r($order_details); 
								 for($i=0; $i<count($order_details); $i++)
								 {	//echo "<pre>"; print_r($products); exit;
							?>
                            		<tr>
                                        <td>
                                        	<select id="product_id" name="product_id[]">
                                            	<option value="0">Please Select</option>
                                            <?php
											foreach($products as $k=>$v)
											{
												$disabled = '';
												$selected= "";
												$color = "";
												if($v['product_id'] == $order_details[$i]['product_id'])
												{
													$selected = 'selected="selected"';													
												}
												else
												{
													if(multi_in_array($v['product_id'],$sel_prod))
														$disabled = "disabled='disabled'";
														$color = 'style="background-color:#EAEAEA"';
												}
												
											?>
                                            <option value="<?php echo $v['product_id'];?>" <?php echo $disabled; ?> <?php echo $selected." ".$color; ?> ><?php echo $v['product_name']; ?></option>
                                            <?php 
											}
											?>
                                            </select>
                                            <div class="avail_qnty">Available :<div class="qntity"><?php if(isset($avail_units[$i])) echo $avail_units[$i]; ?></div></div> 
                                        </td>
                                        <td><input type="text" name="quantity[]" class="quantity" value="<?php echo $order_details[$i]['quantity']; ?>" /></td>
                                        <td><input type="text" name="unit_cost[]" class="unit_cost" value="<?php echo $order_details[$i]['unit_cost']; ?>" /></td>
                                        <td><input type="text" name="total_cost[]" class="total_cost" value="<?php echo $order_details[$i]['total_cost']; ?>" onblur="calculate_totalamt()"/></td>	
                                        <td><img src="img/minus.png" class="remove_this_tr"/></td>
                                   </tr>                                  
                            <?php 		 
								 }
							?>
                             <tr><td colspan="5"><img src="img/plus.png" style="float: right;" id="add_one_record"/></td></tr>
                            <?php 
							 }
							 else{ ?>
                            <tr>
                                <td>
                                	<select id="product_id" name="product_id[]" class="product_dropdown" onchange="change_product_dropdown(this)"></select>
                                    <div class="avail_qnty">Available :<div class="qntity"></div></div>
                                </td>
                                <td><input type="text" name="quantity[]" class="quantity" value="" /></td>
                                <td><input type="text" name="unit_cost[]" class="unit_cost" value="" /></td>
                                <td><input type="text" name="total_cost[]" class="total_cost" value="" onblur="calculate_totalamt()" /></td>	
                                <td><img src="img/minus.png" class="remove_this_tr"/></td>
                           </tr>
                           <tr><td colspan="5"><img src="img/plus.png" style="float: right;" id="add_one_record"/></td></tr>
                           <?php } ?>
                        </table>
                       </td>
                   </tr>
                   <tr>
                        <td <?php if( isset($is_edit) && ( $is_edit == "no")) { echo "style='text-align:right;'";}?>>
                        	<label for="tax">Tax (in amount)<span><?php if( isset($is_edit) && ( $is_edit == "no")) { echo":";}?></span></label>
                        </td>
                        <td>
                         <?php if( isset($is_edit) && ( $is_edit == "no")) { ?>
                            <label class="sale_value"><?php if(isset($order_data[0]['tax'])) echo $order_data[0]['tax']; ?></label>
                        <?php }else{ ?>
                            <input type="text" id="tax" name="tax" value='<?php if(isset($is_edit) && ( $is_edit == "yes") && isset($order_data)) echo  $order_data[0]['tax']; else echo '0.0';?>' onblur="calculate_totalamt()"/>
                        <?php } ?>
                        </td>
                        <td <?php if( isset($is_edit) && ( $is_edit == "no")) { echo "style='text-align:right;'";}?>>
                        	<label for="discount">Discount (in amount)<span><?php if( isset($is_edit) && ( $is_edit == "no")) { echo":";}?></span></label>
                        </td>
                        <td>
                        <?php if( isset($is_edit) && ( $is_edit == "no")) { ?>
                            <label class="sale_value"><?php if(isset($order_data[0]['discount'])) echo $order_data[0]['discount']; ?></label>
                        <?php }else{ ?>
                           	<input type="text" id="discount" name="discount" value='<?php if(isset($is_edit) && ( $is_edit == "yes") && isset($order_data)) echo  $order_data[0]['discount']; else echo '0.0';?>' onblur="calculate_totalamt()"/></td>
                        <?php } ?>
                       	</td>
                    </tr>
                    <tr>
                        <td <?php if( isset($is_edit) && ( $is_edit == "no")) { echo "style='text-align:right;'";}?>>
                        	<label for="total_invoice_amount">Total Invoice Amount <span><?php if( isset($is_edit) && ( $is_edit == "no")) { echo":";}?></span></label>
                        </td>
                        <td>
                        <?php if( isset($is_edit) && ( $is_edit == "no")) { ?>
                            <label class="sale_value"><?php if(isset($order_data[0]['total_invoice_amount'])) echo $order_data[0]['total_invoice_amount']; ?></label>
                        <?php }else{ ?>
                            <input type="text" id="total_invoice_amount" name="total_invoice_amount" value='<?php if(isset($is_edit) && ( $is_edit == "yes") && isset($order_data)) echo  $order_data[0]['total_invoice_amount']; else echo '0.0';?>' />
                        <?php } ?>
                        </td>
                        <?php
						 if(isset($is_edit) && ( $is_edit == "yes") && isset($order_data))
						 {
						?>
                         <td <?php if( isset($is_edit) && ( $is_edit == "no")) { echo "style='text-align:right;'";}?>>
                        	<label for="total_invoice_amount">Status<span><?php if( isset($is_edit) && ( $is_edit == "no")) { echo":";}?></span></label>
                        </td>
                        <td>
                        <?php if( isset($is_edit) && ( $is_edit == "no")) { ?>
                            <label class="sale_value"><?php if(isset($order_data[0]['status_id'])) echo $order_data[0]['status_id']; ?></label>
                        <?php }else{ ?>
                        	<select id="selstatus" name="selstatus">
                            	<option value="">Select Status</option>
                            <?php
							 	foreach($arr_status as $k=>$v)
								{
									$selected = "";
									if($v['status_id'] == $order_data[0]['status_id'])
										$selected = "selected='selected'";
							?>
                            	<option value="<?php echo $v['status_id']; ?>" <?php echo $selected; ?>><?php echo $v['name'];?></option>
                            <?php 
								}
							?>
                            </select>                            
                        <?php } ?>
                        </td>
                        <?php } else {?>
                        <td colspan="2"></td>
                        <?php } ?>
                    </tr>
                    <tr>
                    	<td colspan="4" style="text-align:center">
                        	<?php if( isset($is_edit) && ( $is_edit == "yes")) { ?>
	                        	<input type="button" value="Submit" class="green_button"  onclick="javascript:save_order('leads','save_order')"  >
							<?php }?>
                            <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('leads','order_mngt')" /> 
                        </td>
                    </tr>
                </table>                                        
       	 </div>
        </div>
    </div>
                        <!-- END Main Content -->
<script>
$(document).ready(function(e) {
	$( "#orderdate" ).datepicker({
			dateFormat: "d-M-yy",
			altField: "#txtorderdate_alt",
			changeMonth: true,
			changeYear: true,
      		altFormat: "yy-mm-dd"
		});
		<?php 
			if(isset($is_edit) && ($is_edit == "yes") && isset($order_data)) 
			{
		?>
				$("#orderdate").datepicker('setDate', parseISO8601(<?	
					echo "\"".$order_data[0]['order_date']."\"";
			?>)); 
		<?php 
			}
			else
			{
		?>
		$("#orderdate").datepicker('setDate', new Date());
		<?php } ?>
		$("#warehouse_id").change(function(){			
						
			console.log(unique_exclude_product);		
			
			var warehouse_selected = $("#warehouse_id").find(":selected").val();
			getProductsOfWarehouse("leads","get_product_ajax",warehouse_selected); //alert("here");
			$("#product_id").show('slow');
		});

		product_combobox="<select id='product_id' name='product_id[]' class='product_dropdown' onchange='change_product_dropdown(this)'></select><div class='avail_qnty'>Available :<div class='qntity'></div></div>";
		single_record1 = "<tr><td>";
		single_record2="</td><td><input type='text' name='quantity[]' class='quantity' value='' /></td><td><input type='text' name='unit_cost[]' class='unit_cost' value='' /></td><td><input type='text' name='total_cost[]' class='total_cost' value='' onblur='calculate_totalamt()' /></td><td><img src='img/minus.png' class='remove_this_tr' /></td></tr>";
	
	/* Add one row after last record after clicking on plus img*/		
	$("#add_one_record").click(function(e) {	
		<?php 	
		if(isset($is_edit) && ($is_edit == "yes")&& isset($order_details))
		{			
			$product_combobox = '<select id="product_id" name="product_id[]"><option value="0">Please Select</option>';			
			foreach($products as $k=>$v)
			{
				$disabled = '';
				$color = "";				
				if(multi_in_array($v['product_id'],$sel_prod))
				{
					$disabled = 'disabled="disabled"';
					$color = 'background-color:#EAEAEA';
				}					
				$product_combobox .= '<option value="'.$v['product_id'].'" '.$disabled.'" "'.$color.'" style="'.$color.'">'.$v['product_name'].'</option>';			
			}			
			$product_combobox .= '</select';
			?>
			var product_combobox = '<?php echo $product_combobox; ?>';
			<?php 			
		}		
		?>
		single_record_str=single_record1+product_combobox+single_record2;
		var current_sel = $("#sale_lines tr").last().before(single_record_str).prev().find('select');
		$(current_sel).uniform();
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
	
});

function calculate_totalamt()
{	
	var grand_total=0;
	$('.total_cost').each(function(index, element) {
		if($(this).val()!=""){
			if($(this).val() > 0)
			{
				grand_total+=parseFloat($(this).val());
			}
		}
	});
	if($("#discount").val() > 0)
		var discount_val = $("#discount").val();
	else
		var discount_val = 0;
	if($("#tax").val() > 0)
		var tax_val = $("#tax").val();
	else
		var tax_val = 0;
	
	grand_total=grand_total+parseFloat(tax_val)-parseFloat(discount_val);
	grand_total= Math.round(grand_total*100)/100; 		
	$("#total_invoice_amount").val(grand_total);		
}	
/*var unique_exclude_product = [];
function change_product_dropdown(element)
{	
	var exclude_product = [];
	var current_selected = $(element).val();
	
	$('select.product_dropdown').each(function() 
	{   
		if($(this).val() != 0)
		{
			exclude_product.push($(this).val());		
		}		
	});
	unique_exclude_product = [];
	$.each(exclude_product, function(i,v){
	   if ($.inArray(v, unique_exclude_product) == -1) unique_exclude_product.push(v);
	});
	
	$('select.product_dropdown').each(function() 
	{   
		select_elem = $(this);
		var arr_temp= $.grep(unique_exclude_product, function(value) {
			  return value != select_elem.val();
			});
			
		$(this).find('option').each(function() 
		{    		
			if(arr_temp.indexOf($(this).val()) !== -1) 
			{
				if(select_elem.find(":selected").val()!==$(this).val())
				{
					$(this).attr('disabled', true);
					$(this).css({backgroundColor: '#EAEAEA'});
				}
			}
			else
			{
				$(this).removeAttr('disabled');
				$(this).css({backgroundColor: '#FFFFFF'});
			}
		});		
	});
	
	if(current_selected != '0')
	{
		$(element).closest('tr').find('.quantity').focus();
	}
	getUnitsForProduct("leads","get_units_ajax",current_selected,element);
	
}*/
/*function getUnitsForProduct(module_name,fun,product_id,drp_object)
{	
	$.ajax({
			url:"ajax.php",
			type:"POST",
			data:"page="+module_name+"&function="+fun+"&product_id="+product_id,
			success:function(resp){
				 units = resp;
				 //$(drp_object).closest("tr").find(".quantity").val(resp);
				 $(drp_object).closest("tr").find(".qntity").html(resp);
				 $(drp_object).closest("tr").find(".qntity").attr("original_value",resp);	 
				
			}
		});		
}*/
</script>