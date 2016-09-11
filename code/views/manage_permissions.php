<!-- Main Content -->
<div id="content" class="clearfix">
<div id="main-content" class="singlecolm_form">
                            <!-- Messages -->
        <h2>Status Permissions</h2>
        <div class="body-con">

                <ul class="align-list">
                    <li>
                        <label for="pages" class="grp_perm_lable">Permissions</label>
                        <ol class="main_page grp_perm_ol">
                            <?  for($i=0; $i<count($data['allGroups']); $i++) {	?>
                                    <li class="perm_row">
                                    <span class="close_child_page"></span>
                                    <span style="padding-left:4px;"><? echo $data['allGroups'][$i]['group_name']; ?></span>
                                    <span class="perm_chkall" style="margin-right:16.2%;">
                                    	<input type="checkbox" class="check_all_pages"><span class="check_all_text">Check All</span>
                                    </span>
                                    <div style="clear:both; height:1px;"></div>     
                                    <ol class="function_list" style="display:none;">	
                                    <?  for($j=0; $j<count($data['allStatus']); $j++){	?>                                        
                                            <li><input class="no_crud" type="checkbox" name="status_<?=$data['allGroups'][$i]['group_id']?>[]" value="<? echo $data['allStatus'][$j]['status_id']; ?>" <? if(isset($data['status_permissions'][$data['allGroups'][$i]['group_id']])) { if(in_array($data['allStatus'][$j]['status_id'],$data['status_permissions'][$data['allGroups'][$i]['group_id']])) {?> checked="checked" <? }} ?>>
                                            <span><? echo $data['allStatus'][$j]['status_name']; ?></span>	
                                            </li>
                                        
                                    <? } ?>
                                    	<li style="float: none;clear:both;"></li>
                                        </ol></li>
                            <? } ?>
                        </ol>
                    </li>
                    <li style="float:none; clear:both; display:block;"></li>                    
                </ul>
                <div style="padding-left:122px;">                	
                	<input type="button" value="Update" class="green_button" onClick="updateStatusPermissions('settings','add_status_permission')" /> 
                </div>
       
            <!-- END Add user form -->
            
        </div>
        
    </div>
    </div>
    <!-- END Main Content -->

<script type="text/javascript">
$(document).ready(function(){
	$(".close_child_page,.open_child_page").click(function(){
			$(this).parent().find(">ol").slideToggle();
			$(this).toggleClass("close_child_page");
			$(this).toggleClass("open_child_page");	
	});	
	
	$(".main_page li input").click(function(){
		if($(this).is(":checked")){
			$(this).parent().find("ol li input").attr("checked","checked");
		}else{
			$(this).parent().find("ol li input").removeAttr("checked");
		}
	});
	
	$(".check_all_pages").click(function(){
		if($(this).is(":checked")){
			$(this).closest('li').find(".function_list input").attr("checked","checked").change();
			$(this).closest('li').find(".check_all_text").text("Uncheck all");
		}else{
			$(this).closest('li').find(".function_list input").removeAttr("checked").change();
			$(this).closest('li').find(".check_all_text").text("Check all");
		}
	});
});
</script>