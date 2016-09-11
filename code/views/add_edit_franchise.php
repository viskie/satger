<script type="text/javascript">
$(document).ready( function () {
});
</script>
<input type="hidden" name="mainfunction" id="mainfunction" value="<?php if(isset($data['mainfunction'])) echo $data['mainfunction']; else  echo $mainfunction; ?>" />
<input type="hidden" name="subfunction_name" id="subfunction_name" value="<?php if(isset($data['subfunction_name'])) echo $data['subfunction_name']; else echo $subfunction_name; ?>" />
<input type="hidden" name="edit_id" id="edit_id" value="<?php if(isset($data['franchiseDetails'])) echo $data['franchiseDetails']['franchise_id']; ?>" /> 
<!-- Main Content -->
<div id="content" class="clearfix">
    <div id="main-content" class="twocolm_form">
        
        <!-- Messages -->
        <?php populateNotification($notificationArray); ?>
        <?php if($data['arr_permission'][0]['add_perm'] == 1 || (isset($data['franchiseDetails']) && $data['arr_permission'][0]['edit_perm'] == 1)) { ?>
        <h2><?php if(isset($is_edit) && $is_edit==true) { echo "Edit Franchise"; } else { echo "Add Franchise";} ?></h2>
        <div class="body-con">
            <ul class="align-list">
            	<li>
                    <label for="franchise_username">Username <span>*</span></label>
                    <input type="text" id="franchise_username" name="franchise_username"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['franchise_username']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['userName'];
																		?>" class="validate[required,custom[onlyAlphaNumeric]]" />
                    <!--<span class="msg-form-info">Alphanumeric characters only!</span>-->
                   
                    <label for="franchise_password">Password <span>*</span></label>
                    <input type="password" id="franchise_password" name="franchise_password" value="<?php if(isset($is_exist) && ($is_exist == true)) 
																								{ echo $data['franchiseVariables']['franchise_password'];; }
																							elseif(isset($data['franchiseDetails']))
																								echo '********';
																						?>" class="validate[required,length[6,20]]" />
                    <!--<span class="msg-form-info">At least 6 characters!</span>-->
                </li>
                <li>
                    <label for="franchise_code">Code <span>*</span></label>
                    <input type="text" id="franchise_code" name="franchise_code"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['franchise_code']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['franchise_code'];
																		?>" class="validate[required,custom[onlyAlphaNumeric]]"/>
                               
                    <label for="franchise_name">Franchise Name <span>*</span></label>
                    <input type="text" id="franchise_name" name="franchise_name"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['franchise_name']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['franchise_name'];
																		?>" class="validate[required,custom[onlyLetter]]"/>
                </li>
                <li>
                <?php
				$selected_region = '';
				if(isset($is_exist) && ($is_exist == true)) 
				{$selected_region = $data['franchiseVariables']['franchise_region'];}
				elseif(isset($data['franchiseDetails']))
				{$selected_region = $data['franchiseDetails']['franchise_region'];}
				?>
                    <label for="franchise_region">Region <span>*</span></label>
                    <select id="franchise_region" name="franchise_region" class="validate[required]">
                        <option value="0">Please Select</option>
                        <option value="Domestic" <? if($selected_region=='Domestic') echo "selected=selected"; ?> >Domestic</option>
                        <option value="International" <? if($selected_region=='International') echo "selected=selected"; ?> >International</option>
                    </select>
                
                
                <?php
				$selected_type = '';
				if(isset($is_exist) && ($is_exist == true)) 
				{$selected_type = $data['franchiseVariables']['franchise_type'];}
				elseif(isset($data['franchiseDetails']))
				{$selected_type = $data['franchiseDetails']['franchise_type'];}
				?>
                    <label for="franchise_type">Type <span>*</span></label>
                    <select id="franchise_type" name="franchise_type" class="validate[required]">
                    	<option value="0">Please Select</option>
                        <option value="Single" <? if($selected_type=='Single') echo "selected=selected"; ?> >Single</option>
                        <option value="Co-Brand" <? if($selected_type=='Co-Brand') echo "selected=selected"; ?> >Co-Brand</option>
                        <option value="Area-Development" <? if($selected_type=='Area-Development') echo "selected=selected"; ?> >Area Development</option>
                        <option value="Master-Franchise" <? if($selected_type=='Master-Franchise') echo "selected=selected"; ?>>Master Franchise</option>
                    </select>
                </li>
                <li>
                    <label for="address">Address <span></span></label>
                    <textarea id="address" name="address"><?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['address']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['address'];
																		?></textarea>
                
                	<label for="owner">Owner<span>*</span></label>
                    <input type="text" id="owner" name="owner"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['owner']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['owner'];
																		?>" class="validate[required,custom[onlyLetter]]"/>
                </li>
                <li>
                    <label for="city">City <span></span></label>
                    <input type="text" id="city" name="city"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['city']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['city'];
																		?>" class="validate[optional,custom[onlyLetter]]" />
                    
                    <label for="state">State <span></span></label>
                    <input type="text" id="state" name="state"   value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['state']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['state'];
																		?>" class="validate[optional,custom[onlyLetter]]"/>
                </li>
                <li>
                    <label for="country">Country <span></span></label>
                    <input type="text" id="country" name="country"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['country']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['country'];
																		?>" class="validate[optional,custom[onlyLetter]]"/>
                    
                    <label for="zip">Zip <span></span></label>
                    <input type="text" id="zip" name="zip"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['zip']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['zip'];
																		?>" class="validate[optional,custom[onlyNumber]]"/>
                </li>
                <li>
                    <label for="phone_main">Phone Main <span>*</span></label>
                    <input type="text" id="phone_main" name="phone_main"   value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['phone_main']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['phone_main'];
																		?>" class="validate[required,length[10,15],custom[phone]]"/>
                    
                    <label for="phone_tollfree">Phone Tollfree <span></span></label>
                    <input type="text" id="phone_tollfree" name="phone_tollfree"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['phone_tollfree']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['phone_tollfree'];
																		?>" class="validate[optional,length[10,15],custom[phone]]" />
                </li>
                 <li>
                    <label for="email">Email <span>*</span></label>
                    <input type="text" id="email" name="email"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['email']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['email'];
																		?>" class="validate[required,custom[email]]"/>
                    
                    <label for="fax">Fax<span></span></label>
                    <input type="text" id="fax" name="fax"  value="<?php if(isset($is_exist) && ($is_exist == true)) 
																				{ echo $data['franchiseVariables']['fax']; }
																			elseif(isset($data['franchiseDetails']))
																				echo $data['franchiseDetails']['fax'];
																		?>" class="validate[optional,length[10,15],custom[phone]]"/>
                </li>
                
    
                    <li>
                        <label></label>
                        <?  if(isset($data['franchiseDetails']) && (isset($is_edit) && ($is_edit == true))) {    ?>     
                         <input type="button" value="Update" class="green_button"  onclick="javascript:showFormFranchise('<?=$data['franchiseDetails']['franchise_id']?>','franchise','save_franchise')" >
                        <? } else { ?>
                       <input type="button" value="Insert" class="green_button"  onclick="javascript:showFormFranchise('0','franchise','save_franchise')" >
                       <? } ?>
                       <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('franchise','view')" /> 
                    </li>
    
                </ul>
        </div>
        	<? }?>
    </div>
</div>
<!-- END Main Content -->
<?php
if(isset($data['franchiseDetails'])) {    ?>     
<script type="text/javascript">
	$(document).ready( function () {
			//jQuery
			<?php foreach($data['franchiseDetails'] as $key=>$value ) { ?>
					$('#<?=$key;?>').val('<?=addslashes($value);?>');
			<?php } ?>	
	});
</script>
<?php } ?>