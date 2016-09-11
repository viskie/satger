<?php
extract($data);
?>
   <!-- Main Content -->
        <div id="content" class="clearfix">
        <div id="main-content" class="singlecolm_form">
           <!-- Messages -->
          <input type="hidden" name="edit_id" value="<?php if(isset($action) && ($action == 'edit')) echo $status_data[0]['id']; ?>" id="edit_id" />       
          <h2>Order Status Permission</h2>            
          <div class="body-con" style="width:97.6%">
          	<?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
          	<table cellpadding="0" cellspacing="0" border="0" align="center" style="width:80%; margin:auto;">
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
							$checkall_val = "";
							if(isset($arr_permission[$arr_group[$i]['group_id']]))
							{
								if(count($arr_permission[$arr_group[$i]['group_id']]) == count($arr_status))
									$checkall_val = "checked='checked'";
							}
							?>
                        	<input type="checkbox" class="check_all_pages" name="check_all_pages_<?php echo $arr_group[$i]['group_id']; ?>" onclick="check_status(<?php echo $arr_group[$i]['group_id']; ?>)" value="1" <?php echo $checkall_val; ?>>
                            <span class="check_all_text_<?php echo $arr_group[$i]['group_id']?>"><?php if($checkall_val != "") echo "Uncheck All"; else echo "Check All"; ?></span>
                        </span>
                        <ol class="status_list" style="display:none;">	
						<?php 
						for($j=0; $j<count($arr_status); $j++)
						{
							$check_val = "";	
							if(isset($arr_permission[$arr_group[$i]['group_id']]))
							{
								if(in_array($arr_status[$j]['id'], $arr_permission[$arr_group[$i]['group_id']]))
									$check_val = "checked='checked'";
							}
						?>						
                        <li>
                        	<input  type="checkbox" name="status_<?php echo $arr_group[$i]['group_id']; ?>[]" value="<?php echo $arr_status[$j]['id'];?>" class="status_<?php echo $arr_group[$i]['group_id']; ?>" onclick="change_status(<?php echo $arr_group[$i]['group_id']; ?>)" <?php echo $check_val; ?>>
                        	<span><?php echo $arr_status[$j]['name']; ?></span>
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
                    	 <input type="button" value="Submit" class="green_button"  onclick="javascript:updatePermission('settings','change_grpstatus_permission')" />
                         <input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('settings','view_order_status')" /> 
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
	
	$(".main_page li input").click(function()
	{
		if($(this).is(":checked")){
			$(this).parent().find("ol li input").attr("checked","checked");
		}else{
			$(this).parent().find("ol li input").removeAttr("checked");
		}
	});
	
	/*$(".check_all_pages").click(function(){ alert ();
		if($(this).is(":checked")){	alert("check");
			$(this).closest('li').find(".status_list input").attr("checked","checked").change();
			$(this).closest('li').find(".check_all_text").text("Uncheck all");
		}
		else
		{	alert("uncheck");
			$(this).closest('li').find(".status_list input").removeAttr("checked").change();
			$(this).closest('li').find(".check_all_text").text("Check all");
		}
	});	*/
	
});
	function check_status(group_id)
	{
		if($('input[name=check_all_pages_'+group_id+']').is(":checked"))
		{	
			$('.status_'+group_id).attr("checked","checked").change();			
			$('.check_all_text_'+group_id).text("Uncheck all");
		}
		else
		{
			$('.status_'+group_id).removeAttr("checked").change();			
			$('.check_all_text_'+group_id).text("Check all");
		}		
	}
	function change_status(group_id)
	{	
		var chk = false;
		$("input[name='status_"+group_id+"[]']").each(function(){
				if(!$(this).is(':checked'))
				{
					chk = true;
					$('input[name=check_all_pages_'+group_id+']').removeAttr("checked").change();
					$('.check_all_text_'+group_id).text("Check all");
				}
		  });
		  if(chk == false)
		  {
			  $('input[name=check_all_pages_'+group_id+']').attr("checked","checked").change();
			  $('.check_all_text_'+group_id).text("Uncheck all");			
		  }
		return false;
		
	}
</script>