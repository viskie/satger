<?php
extract($data);
?>
   <!-- Main Content -->
        <div id="content" class="clearfix">
        <div id="main-content" class="singlecolm_form">
           <!-- Messages -->
          <input type="hidden" name="edit_id" value="<?php if(isset($action) && ($action == 'edit')) echo $status_data[0]['id']; ?>" id="edit_id" />       
          <h2>Permission</h2>            
          <div class="body-con" style="width:97.6%">
          	<?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
          	<table cellpadding="0" cellspacing="0" border="0" align="center" style="width:80%; margin:auto;" class="permission_table">
            	<tr>
                	<td align="center"><label for="group_name" style="text-align:center">Groups</label></td>
                </tr>
            	<?php
				for($i=0; $i<count($arr_group); $i++)
				{
				?>
                <tr>
                	<td align="left">
                       	<span  class="close_child_page"></span>
						<span style="padding-left:4px; float:left; width:45%; text-align:left;"><?php echo $arr_group[$i]['group_name']; ?></span>
                        <span style="margin-left: 15px;"> 
                        	<?php
								$checked = '';
								$check_permission = check_permission('all', $arr_group[$i]['group_id']);
								if($check_permission)
									$checked = 'checked=checked';
							?>                       	
                        	<input type="checkbox" id="check_all_pages" class="check_all_pages" name="check_all_pages_<?php echo $arr_group[$i]['group_id']; ?>" value="1" onchange="check_pages(<?php echo $arr_group[$i]['group_id']; ?>)" <?php echo $checked; ?>>
                            <span class="check_all_text_<?php echo $arr_group[$i]['group_id']?>"><?php if(isset($check_permission)) echo "Uncheck All"; else echo "Check All"; ?></span>
                        </span>
                        <ol class="pages_list" style="display:none">	
							<?php 
                            for($j=0; $j<count($arr_perm_data); $j++)
                            {
                            ?>						
                            <li class="page_li">
                            	<span  class="close_child_page"></span>
                                <?php
									$checked = '';
									$check_permission = check_permission('', $arr_group[$i]['group_id'], $arr_perm_data[$j]['page_id']);
									if($check_permission)
									{
										$check_fun = 1;
										$checked = 'checked=checked';
									}
								?>
                                <input  type="checkbox" name="page_<?php echo $arr_group[$i]['group_id']?>[]" value="<?php echo $arr_perm_data[$j]['page_id'];?>" class="page_<?php echo $arr_group[$i]['group_id']?>" onchange="check_functions(this, <?php echo $arr_group[$i]['group_id']?>,<?php echo $arr_perm_data[$j]['page_id'];?>)" <?php echo $checked; ?>>
                                <span><?php echo $arr_perm_data[$j]['module_name']; ?></span>
                                <?php 
                                if(isset($arr_perm_data[$j]['functions']) && count($arr_perm_data[$j]['functions'])>0)
                                {
                                ?>
                                <ol class="function_list" style="display:none">
                                <?php 
                                    foreach($arr_perm_data[$j]['functions'] as $k=>$v)
                                    { 
                                ?>
                                    <li class="func_li">
                                    	<span  class="close_child_page"></span>
                                        <?php
											$checked = '';
											if(isset($check_fun))
											{
												$check_permission = check_permission('', $arr_group[$i]['group_id'], $arr_perm_data[$j]['page_id'],$v['function_id']);
												if($check_permission)
												{
													$check_subfun = 1;
													$checked = 'checked=checked';
												}
											}
										?>
                                        <input  type="checkbox" name="function_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>[]" value="<?php echo $v['function_id'];?>" class="function_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>" onchange="check_subfunction(this, <?php echo $arr_group[$i]['group_id']?>,<?php echo $arr_perm_data[$j]['page_id'];?>,<?php echo $v['function_id'];?>)" <?php echo $checked; ?>>
                                        <span><?php echo $v['friendly_name']; ?></span>
                                        <?php 
										if(isset($v['subfunction']) && count($v['subfunction'])>0)
										{
										?>
                                        <ol class="subfunc_list" style="display:none">
                                        	<?php 
												foreach($v['subfunction'] as $k1=>$v1)
												{
													?>
													<li class="subfunc_li">
                                                    <div style="float:left; width:28%;"> 
                                                    	 <?php
															$checked = '';
															if(isset($check_subfun))
															{
																$check_permission = check_permission('subfunction',$arr_group[$i]['group_id'], $arr_perm_data[$j]['page_id'],$v['function_id'],$v1['function_id'],'view');
																if($check_permission)
																	$checked = 'checked=checked';
															}
														?>                                                   	
														<input  type="checkbox" name="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>[]" value="<?php echo $v1['function_id'];?>" class="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>" onchange="change_parent(this,<?php echo $arr_group[$i]['group_id']?>,<?php echo $arr_perm_data[$j]['page_id'];?>,<?php echo $v['function_id'];?>,<?php echo $v1['function_id'];?>)"   <?php echo $checked; ?>>
														<span><?php echo $v1['friendly_name']; ?></span>
                                                    </div>
                                                    <?php 
													if($v1['is_crud'] == 1)
													{
													?>
                                                    <div class="crud_perm">
                                                    	<?php
															$checked = '';
															if(isset($check_subfun))
															{
																$check_permission = check_permission('subfunction',$arr_group[$i]['group_id'], $arr_perm_data[$j]['page_id'],$v['function_id'],$v1['function_id'],'add');
																if($check_permission)
																	$checked = 'checked=checked';
															}
														?>  
                                                    	<input  type="checkbox" name="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>_<?php echo $v1['function_id'];?>[]" value="add" class="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>" onchange="change_parent(this,<?php echo $arr_group[$i]['group_id']?>,<?php echo $arr_perm_data[$j]['page_id'];?>,<?php echo $v['function_id'];?>,<?php echo $v1['function_id'];?>)"  <?php echo $checked; ?>>
														<span>Add</span>
                                                    </div>
                                                    <div class="crud_perm">
                                                    	<?php
															$checked = '';
															if(isset($check_subfun))
															{
																$check_permission = check_permission('subfunction',$arr_group[$i]['group_id'], $arr_perm_data[$j]['page_id'],$v['function_id'],$v1['function_id'],'edit');
																if($check_permission)
																	$checked = 'checked=checked';
															}
														?>  
														<input  type="checkbox" name="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>_<?php echo $v1['function_id'];?>[]" value="edit" class="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>" onchange="change_parent(this,<?php echo $arr_group[$i]['group_id']?>,<?php echo $arr_perm_data[$j]['page_id'];?>,<?php echo $v['function_id'];?>,<?php echo $v1['function_id'];?>)"  <?php echo $checked; ?>>
														<span>Edit</span>
                                                    </div>
                                                    <div class="crud_perm">
                                                    	<?php
															$checked = '';
															if(isset($check_subfun))
															{
																$check_permission = check_permission('subfunction',$arr_group[$i]['group_id'], $arr_perm_data[$j]['page_id'],$v['function_id'],$v1['function_id'],'delete');
																if($check_permission)
																	$checked = 'checked=checked';
															}
														?>                                                     	
														<input  type="checkbox" name="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>_<?php echo $v1['function_id'];?>[]" value="delete" class="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>" onchange="change_parent(this,<?php echo $arr_group[$i]['group_id']?>,<?php echo $arr_perm_data[$j]['page_id'];?>,<?php echo $v['function_id'];?>,<?php echo $v1['function_id'];?>)"  <?php echo $checked; ?>>
														<span>Delete</span>
                                                    </div>
                                                    <div class="crud_perm"> 
                                                    	<?php
															$checked = '';
															if(isset($check_subfun))
															{
																$check_permission = check_permission('subfunction',$arr_group[$i]['group_id'], $arr_perm_data[$j]['page_id'],$v['function_id'],$v1['function_id'],'restore');
																if($check_permission)
																	$checked = 'checked=checked';
															}
														?>                                              	
													<input  type="checkbox" name="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>_<?php echo $v1['function_id'];?>[]" value="restore" class="subfunction_<?php echo $arr_group[$i]['group_id']?>_<?php echo $arr_perm_data[$j]['page_id'];?>_<?php echo $v['function_id'];?>" onchange="change_parent(this,<?php echo $arr_group[$i]['group_id']?>,<?php echo $arr_perm_data[$j]['page_id'];?>,<?php echo $v['function_id'];?>,<?php echo $v1['function_id'];?>)"  <?php echo $checked; ?>>
														<span>Restore</span>
                                                    </div>
                                                    
                                                    </li>
                                                    <?php 	
													}
												}
											?>
                                        </ol>
										<?php 
										}
										?>
                                    </li>
                                    <li style="clear:both; float:none; width:95%;"></li>
                                <?php 		
                                    }
                                ?>
                                </ol>
                                <?php 
                                }
                                ?>
                            </li>
                                <?php 
                            } ?>
						</ol>
                    </td>                    
                </tr>
                <?php
				}
				?>
                <tr>
                	<td>
                    	 <input type="button" value="Submit" class="green_button"  onclick="javascript:updatePermission('settings','update_page_permission')" />
                         <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('settings','manage_permissions')" /> 
                    </td>
                </tr>
            </table>            
           <!-- END Add user form -->                
            </div>            
        </div>
        </div>
        <!-- END Main Content -->

<script type="text/javascript">
	$(document).ready(function(){
		$(".close_child_page,.open_child_page").click(function()
		{
				$(this).parent().find(">ol").slideToggle();
				$(this).toggleClass("close_child_page");
				$(this).toggleClass("open_child_page");	
		});		
	});

	function check_pages(group_id)
	{
		if($('input[name=check_all_pages_'+group_id+']').is(":checked"))
		{	
			//$('.page_'+group_id).attr("checked","checked");
			$('.page_'+group_id).closest('.page_li').find('input[type="checkbox"]').attr("checked","checked");
			$('.check_all_text_'+group_id).text("Uncheck all");
		}
		else
		{
			//$('.page_'+group_id).removeAttr("checked");
			$('.page_'+group_id).closest('.page_li').find('input[type="checkbox"]').removeAttr("checked");
			$('.check_all_text_'+group_id).text("Check all");
		}
		change_attr($('.page_'+group_id).closest('.page_li'));			
	}
	function check_functions(chkval, group_id, pageid)
	{	
		if($(chkval).is(':checked'))
		{	
			$(chkval).closest('.page_li').find('input[type="checkbox"]').attr("checked","checked");
		}
		else
		{
			$(chkval).closest('.page_li').find('input[type="checkbox"]').removeAttr("checked");
		}
		change_attr($(chkval).closest('.page_li'));		
	}
	function check_subfunction(this_element, group_id, pageid, functionid)
	{
		var my_check_box=this_element;
		if($(my_check_box).is(":checked"))
		{
			$('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.page_li').find('.page_'+group_id).attr("checked","checked");
			$('.subfunction_'+group_id+'_'+pageid+'_'+functionid).attr("checked","checked");//.change();
		}
		else
		{	
			$(my_check_box).removeAttr("checked");
			
			$('.subfunction_'+group_id+'_'+pageid+'_'+functionid).each(function(){	
				$(this).removeAttr("checked");
				
			 });						
		}
		change_attr($(my_check_box).closest('.page_li'));
		
		// if uncheck all function, page will also unchecked	
		 var chk = false;
		 $(".function_"+group_id+"_"+pageid).each(function(){
			if($(this).is(':checked'))
			{
				chk = true;					
				return false; 										  				
			}
		 }); 
		 if(chk == false)
		 {
			$('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.page_li').find('.page_'+group_id).removeAttr("checked");
			var pageli = $('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.page_li');
			change_attr(pageli);			
		 }	
		
	}
	function change_parent(this_element,group_id, pageid, functionid, subfunctionid)
	{	
		var my_check_box=this_element;
		if($(my_check_box).is(":checked"))
		{	
			$('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.func_li').find('.function_'+group_id+'_'+pageid).attr("checked","checked"); 			
			$('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.page_li').find('.page_'+group_id).attr("checked","checked"); 
			
			if(my_check_box.value != 'add' && my_check_box.value != 'edit'  && my_check_box.value != 'delete' && my_check_box.value != 'restore')
			{
					$("input[name='subfunction_"+group_id+'_'+pageid+'_'+functionid+'_'+subfunctionid+"[]']").each(function(){				
					$(this).attr("checked","checked");
				 });
			 }
			 else
			 {
				 $(my_check_box).closest('.subfunc_li').find('.subfunction_'+group_id+'_'+pageid+'_'+functionid).first().attr("checked","checked");				 
			 }
			 
			var pageli = $('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.page_li');
			change_attr(pageli); 			
		}
		else
		{	
			if(my_check_box.value != 'add' && my_check_box.value != 'edit'  && my_check_box.value != 'delete' && my_check_box.value != 'restore'){
				$("input[name='subfunction_"+group_id+'_'+pageid+'_'+functionid+'_'+subfunctionid+"[]']").each(function(){				
					$(this).removeAttr("checked");
			 	});
			}
			
		}
		
		// if uncheck all subfunction, function will also unchecked	
		var chk = false;
		$("input[name='subfunction_"+group_id+'_'+pageid+'_'+functionid+"[]']").each(function(){
			if($(this).is(':checked'))
			{
				chk = true;					
				return false; 										  				
			}
		 }); 
		 if(chk == false)
		 {
			$('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.func_li').find('.function_'+group_id+'_'+pageid).removeAttr("checked"); 			
			var func_li = $('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.func_li');
			change_attr(func_li);
						
		 }			
		 
		 // if uncheck all function, page will also unchecked	
		 var chk = false;
		 $(".function_"+group_id+"_"+pageid).each(function(){
			if($(this).is(':checked'))
			{
				chk = true;					
				return false; 										  				
			}
		 }); 
		 if(chk == false)
		 {
			$('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.page_li').find('.page_'+group_id).removeAttr("checked");
			var pageli = $('.subfunction_'+group_id+'_'+pageid+'_'+functionid).closest('.page_li');
			change_attr(pageli);			
		 }	
		 
	}
	function change_attr(pageli)
	{
		$(pageli).find('input[type=checkbox]').each( function(){
				var this_check=$(this);
				if($(this_check).is(':checked')){
					if(!$(this_check).parent().hasClass('checked')){
						$(this_check).parent().addClass('checked');
					}
				}else{
					if($(this_check).parent().hasClass('checked')){
						$(this_check).parent().removeClass('checked');
					}
				}
			})
	}

	
</script>