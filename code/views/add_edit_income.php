<script type="text/javascript">

$(document).ready( function () {

	$(document).ready( function () {

		$("#datepicker").datepicker('setDate', parseISO8601(<?

				if($function == 'edit_income'){

					echo "\"".$data['incomeDetails']['payment_sent_date']."\"";

				}else{

					echo "\"".date('Y-m-d')."\"";

				}

			?>));

		

		$("#datepicker1").datepicker('setDate', parseISO8601(<?

				if($function == 'edit_income'){

					echo "\"".$data['incomeDetails']['payment_date']."\"";

				}else{

					echo "\"".date('Y-m-d')."\"";

				}

			?>));

		});

});

</script>



<?

if($function == 'edit_income') {   

?>

<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['incomeDetails']['payment_id']?>" />
<input type="hidden" name="code" id="code" value="<?=$data['incomeDetails']['code']?>" />

<? 

}

//echo "<pre>"; print_r($data);

?>





                        <!-- Main Content -->

						<div id="content" class="clearfix">

                        <div id="main-content" class="twocolm_form">

                            

                            <!-- Messages -->

                         

                            <h2><? if($function=='show_add_income') { echo "Add Income"; } else { echo "Edit Income";} ?></h2>

                            <div class="body-con">



                                    <ul class="align-list">

                                         <li id="cat">

											<label for="category">Category <span>*</span></label>

                                           <?

									   		//$catdetails = $accountsObject->getAllIncomeCategories();

//											echo $incomeDetails['category_id'];exit;

										   	if($function == 'edit_income')

										   		createComboBox('category_id','pc_id','name', $data['catdetails'],TRUE,$incomeDetails['category_id']);

											else	

											   	createComboBox('category_id','pc_id','name', $data['catdetails'],TRUE);

										   ?>
                                           
                                           <label for="transcation_id">Transcation Id </label>
                                           <input type="text" id="transaction_id" name="transaction_id"  value='<? if($function == 'edit_income'){ echo $data['incomeDetails']['transaction_id']; }?>' />

										</li>

                                         <li style="display:none" id="proj">

											<label for="project">Project </label>

                                           <?

										   //$prodetails = $projectObject->getAllProjects();

										   if($function == 'edit_income')

										   		createComboBox('project','project_id','project_name',$data['prodetails'],TRUE,$incomeDetails['project_id']);

											else

												createComboBox('project','project_id','project_name',$data['prodetails'],TRUE);	

										   ?>

										</li>

                                        <li>

											<label for="amount_usd">Amount USD </label>

                                            <input type="text" id="amount_usd" name="amount_usd"  value='<? if($function == 'edit_income'){ echo $data['incomeDetails']['amount_usd']; }?>' />

										

											<label for="conversion_rate">Conversion Rate </label>

                                            <input type="text" id="conversion_rate" name="conversion_rate"  value='<? if($function == 'edit_income'){ echo $data['incomeDetails']['conversion_rate']; } ?>' />

										</li>

                                         <li>

											<label for="amount_inr">Amount INR <span>*</span></label>

                                            <input type="text" id="amount_inr" name="amount_inr"  value='<? if($function == 'edit_income'){ echo $data['incomeDetails']['amount']; } ?>' />

										

											<label for="payment_sent_date">Payment Sent Date </label>

                                            <input type="text" id="datepicker" name="payment_sent_date"  value='<? if($function == 'edit_income'){ echo $data['incomeDetails']['payment_sent_date']; } ?>' />

                                            <input type="hidden" id="sent_alt" name="sent_alt" size="30">

                                        </li>

                                        <li>

											<label for="payment_recived_date">Payment Received Date <span>*</span></label>

											<input type="text" id="datepicker1" name="payment_recived_date"  value='<? if($function == 'edit_income'){ echo $data['incomeDetails']['payment_date']; } ?>'  />

                                            <input type="hidden" id="recived_alt" name="recived_alt" size="30">

                                        

                                        	<label for="remarks">Remarks <span>*</span></label>

											<textarea id="remark" name="remark"  value=''><? if($function == 'edit_income'){ echo stripslashes($data['incomeDetails']['remarks']); } ?></textarea>

                                        </li>
										<li>
                                        	<label for="invoice">Attache Invoice : <span>*</span></label>
                                            <input type="file" name="invoice" id="invoice" value="" />
											<? if($function == 'edit_income'){ echo $data['incomeDetails']['invoice']; ?>
                                            	<input type="hidden" name="old_invoice" value="<? echo $data['incomeDetails']['invoice']; ?>" />
                                            <? }?>
                                        </li>
										

                                        <li>

                                            <label></label>

                                            <?  if($function == 'edit_income') {    ?>     

                                             <input type="button" value="Update" class="green_button"  onclick="javascript:updateIncome('<?=$data['incomeDetails']['payment_id']?>','accounts','edit_income_entry')" >

                                            <? } else { ?>

                                           <input type="button" value="Insert" class="green_button"  onclick="javascript:addIncome('accounts','add_income')" >

                                           <? } ?>

                                            <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('accounts','view_incomes')" /> 

                                        </li>



									</ul>

							</div>

                            

                            

                           

                            

                        </div>

						</div>

                        <!-- END Main Content -->

                   <?

                   if($function == 'edit_payment') {    ?>     

                   <script type="text/javascript">

						$(document).ready( function () {

								<? foreach($data['paymentDetails'] as $key=>$value ) { 

										$value=shownlInjs($value);

								?>

										$('#<?=$key;?>').val('<?=$value;?>');

								<? } ?>	

								

															

						});

						

                   </script>

                   <? } ?>

                   

                   <script type="text/javascript">

				   $(document).ready( function () {

					   

                   		$('#cat select').change(function(){

							var cat_name=$('#cat select').find(":selected").text();

							if(cat_name == 'Project'){

								$('#proj').show('slow');	

							}else{

								$("#proj select").find("option[value='0']").attr("selected","selected");

								$('#proj').hide('slow');

							}

						});

                   		$('#cat select').change();

					});	

                   </script>

