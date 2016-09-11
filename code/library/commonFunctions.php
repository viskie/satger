<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}

function formatDate($date)
{
	if($date=="0000-00-00"){
		return "-";
	}else{
		return date("d-M-Y", strtotime($date));
	}

}

function formatDateTime($date)
{
	if($date=="0000-00-00 00:00:00"){
		return "-";
	}else{
		return date("d-M-Y h:i A", strtotime($date));
	}
}

function has_access($current_page_id,$which_access){
	$user_groups = implode(",",$_SESSION['user_group']);
	$result_set = getData("select * from `user_crud_permissions` where `page_id`='".$current_page_id."' and `group_id` IN (".$user_groups.") and `".$which_access."`='1'");
	//print_r($result_set);exit;
	if(count($result_set) >0)
		return true;
	else
		return false;	
}

function getUserGroupPermissions()
{	
			$userGroup = array();
			//$userGroup = $_SESSION['user_group'];
			$userMainGroup = (int)$_SESSION['user_main_group'];
			$pageArray = array();
			$retArray = array();
			
			if($userMainGroup != 1)
			{
				$first = true;
				$user_groups = $userMainGroup;
				$pageArray = getData("select * from pages where page_id in ( select page_id from functions where function_id in ( select function_id from user_permissions where group_id='".$user_groups."')) order by tab_order ASC");
			}
			else
			{
					$pageArray = getData("select * from pages where is_active = 1 and level = 1 order by `tab_order` ASC");
			}
			
			foreach($pageArray as $value)
			{
					$retArray[$value['description']] = $value;
			}
			
			
			return $retArray;
}

function buildUserMenu()
{
	$userGroup = array();
	$userGroup = $_SESSION['user_group'];
	$first = true;
	$user_groups = "";
	foreach($userGroup as $key=>$value)
	{
		if(!$first)
			$user_groups.= ", ";
		else
			$first = false;		
		$user_groups.= $value;	
	}
	
	//$userGroup = $_SESSION['user_group'];
	$userName = getOne("select name from users where user_id = '".$_SESSION['user_id']."'");
	$pageArray = getData("select * from pages where page_id in (select page_id from user_permissions where group_id IN(".$user_groups.") and is_active = 1) and is_active = 1 and level = 1 order by `tab_order` ASC");
	//print_r($pageArray); exit;
	?>
    <div id="topmenu">
    <ul>
     <?
	  	for($i=0; $i<sizeof($pageArray);$i++)
		{
			if($pageArray[$i]['page_name'] == '#'){ ?>
				<li><a href="#" class="parent"><span><?=getPageTitle('1',$_SESSION['preferred_language'],$pageArray[$i]['page_id'])?></span></a>
			<? }else{
			?>
			<li><a href="javascript:callPage('<?=$pageArray[$i]['page_name']?>','view')" class="parent"><span><?=getPageTitle('1',$_SESSION['preferred_language'],$pageArray[$i]['page_id'])?></span></a>
			<? }
				$subPageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id IN(".$user_groups.") and is_active = 1) and is_active = 1 and level = 2 and parent_page_id = '".$pageArray[$i]['page_id']."' order by `tab_order` ASC");
				if(sizeof($subPageArray)>0)
				{
					echo "<ul class=\"mysubmenu\">";
					for($j=0; $j<sizeof($subPageArray); $j++)
					{
					?>
								 <? $sub_sub_PageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id IN(".$user_groups.") and is_active = 1) and is_active = 1 and level = 3 and parent_page_id = '".$subPageArray[$j]['page_id']."' order by `tab_order` ASC");
								
                           if(sizeof($sub_sub_PageArray)>0)
							{
								echo "<li class='sidemenu_parent'><a href=\"javascript:callPage('".$subPageArray[$j]['page_name']."','view')\"><span>".getPageTitle('1',$_SESSION['preferred_language'],$subPageArray[$j]['page_id'])."</span></a>";
								echo "<div class=\"sidemenu_container\">";	
								echo "<ul class=\"sidemenu\">";
								for($k=0; $k<sizeof($sub_sub_PageArray); $k++)
								{
								?>
									
									<li><a href="javascript:callPage('<?=$subPageArray[$j]['page_name']?>','view')"><span><?=getPageTitle('1',$_SESSION['preferred_language'],$sub_sub_PageArray[$k]['page_id'])?></span></a></li>
										
								<?
								}
								echo "</ul>"; 
								echo "</div></li>";
							}else{?>
                    	<li><a href="javascript:callPage('<?=$subPageArray[$j]['page_name']?>','view')"><span><?=getPageTitle('1',$_SESSION['preferred_language'],$subPageArray[$j]['page_id'])?></span></a></li>
                    <? }
					}
					echo "</ul>";
				}				
			?>
         	</li>            
            <?
        }
	?>
    <li><a href="javascript:userLogout('')" class="last"><span class="sb_label_01_995"></span></a>
    </ul>
</div>
    <?
}

function getPageTitle($pageName)
{
	return $page_title = getOne("select title from pages where page_name = '".$pageName."'");
}

function buildSidebar()
{
	
}

function purifyInputs()
{
	foreach($_REQUEST as $key=>$value)
	{
		if(is_array($value)){	//Change: Msnthan Tripathi:25-Aug-2012. The function is giving error when passed array of checkboxes in query string.
			foreach($value as $keySub => $valueSub){
				if(is_array($valueSub)){
					foreach($valueSub as $key_sub_sub => $val_sub_sub){
						$value[$key_sub_sub] = addslashes($val_sub_sub);	
					}
				}
				else{
					$value[$keySub] = addslashes($valueSub);
				}
			}
		}else{
			$_REQUEST[$key] = addslashes($value);
		}
	}
}

function setPage()
{
	$page = "";
	if(isset($_POST['page']) && trim($_POST['page'])!=='')
	{
		$page = trim(addslashes($_POST['page']));
		if($page == 'home')
			$page = "home.php";
		else	
			$page = "manage_".$page.".php";	
	}
	else
	{
		$page=FALSE;
	}
	return $page;
}

function setFunction()
{
	$function = "";
	if(isset($_POST['function']) && trim($_POST['function'])!=='')
	{ 
		$function = trim(addslashes($_POST['function']));	
	}
	else{
		$function = FALSE;
	}
	return $function;
}

function setModule()
{
	$module = "";
	if(isset($_POST['page'])  && trim($_POST['page'])!=='')
	{ 
		$module = trim(addslashes($_POST['page']));	
	}
	else{
		$module = FALSE;
	}
	return $module;
}

function getAllUserGroups()
{
	$getQuery = "Select * from user_groups order by group_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}

function getAllGlobalAdmins()
{
	$getQuery = "Select * from users where user_group = 1 order by user_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}

function getAllAdmins()
{
	$getQuery = "Select * from users where user_group = 2 order by user_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}

function setActiveInactive($value)
{
	
}

function getUserName($user_id)
{
	$userName = getOne("select name from users where user_id = '".$user_id."'");
	return $userName;
}

function getAdminUsersCombo($boxName)
{
	$adminUsers = getAllAdmins();
	createComboBox($boxName,'user_id','name',$adminUsers);
}

function getGroupCombo($boxName,$selectedGroup='')
{	
	$userGroupArray = getData("select * from user_groups where is_active=1");
	createComboBox($boxName,'group_id','group_name', $userGroupArray);
}

function createComboBox($name,$value,$display, $data, $blankField=false, $selectedValue="",$display2="",$firstFieldValue='Please Select', $otherParameters = "")
{
	echo "<select id='".$name."' name = '".$name."' ".$otherParameters." >";
	if($blankField){
		echo "<option value='0'>".$firstFieldValue."</option>";
	}
	for($d=0;$d<sizeof($data);$d++)
	{
		$selectedString = "";
		$selectedValue = trim($selectedValue);
		if($data[$d][$value] == $selectedValue)
		{
			$selectedString = " selected = 'selected' ";
		}
		
		echo "<option value='".$data[$d][$value]."' ".$selectedString.">".$data[$d][$display];
		if($display2!=""){
			echo " (".$data[$d][$display2].")";
		}
		echo "</option>";
	}
	echo "</select>";
}

function getConfigValue($key)
{
	return $value = getOne("Select config_value from settings where config_name = '".$key."'");
}

function updateConfigValue($key,$value)
{
	updateData("update settings set config_value = '".$value."' where config_name = '".$key."'");
}

/*function checkPagePermissions($fileName,$selectedFunction=1)
{
	$fileName = addslashes($fileName);

	$userGroup = array();
	$userGroup = $_SESSION['user_main_group'];

	if((int)$userGroup != 1)
	{
		$pageId = getOne("Select page_id from pages where page_name = '".$fileName."'");

		$pagePermission= getData("Select * from user_permissions where group_id IN(".$userGroup.") and page_id = '".$pageId."' and `".$selectedFunction."` = 1 and is_active = '1'");
		
		if(sizeof($pagePermission)>=1)
		{
			//Page-User Validated
		}
		else
		{	//echo $fileName;exit;
			
			 echo "
					<script type='text/javascript'>
						alert(\"You do not have permission to view this page.".$pageId." Please Contact administrator\");
						window.location = 'index.php';
					</script>
			 ";
			exit;
		}
	}
}*/

function checkPagePermissions($function)
{
	//$moduleName = addslashes($moduleName);

	$userGroup = array();
	$userGroup = $_SESSION['user_main_group'];

	if((int)$userGroup != 1)
	{
		$functionId = getOne("Select function_id from functions where function_name = '".$function."'");

		$pagePermission= getData("Select * from user_permissions where group_id IN(".$userGroup.") and function_id = '".$functionId."' and is_active = '1'");
		
		if(sizeof($pagePermission)>=1)
		{
			//Page-User Validated
		}
		else
		{	//echo $fileName;exit;
			
			 echo "
					<script type='text/javascript'>
						alert(\"You do not have permission to view this page.".$function." Please Contact administrator\");
						window.location = 'login.php';
					</script>
			 ";
			exit;
		}
	}
}

function mailUser($transcript, $phoneNumber, $CallSid)
{	//echo "select user_id from schedule where ph_id = (select ph_id from phone_numbers where phone_number like '%".trim($phoneNumber)."') and is_active=1";
	 $inCallEmployeeId = getOne("select user_id from schedule where ph_id = (select ph_id from phone_numbers where phone_number like '%".trim($phoneNumber)."') and is_active=1");
	$inCallEmployeeMail = getOne("select user_email from users where user_id = '".$inCallEmployeeId."'");
	$voiceURL = getOne("select recording_url from incomming_calls where call_sid = '".$CallSid."'");
	
	
	if(trim($inCallEmployeeMail) != "")
	{
		$message = "
			<h3> New Call for you..!!</h3>
			<br />
			You have a new message.<br />
			Transcription: ".$transcript."<br />
			Voice Url: ".$voiceURL."<br /><br />
			Log in to VBX scheduler for more details.<br />
			Thanks.		
		";
		mailEmployee($inCallEmployeeMail, $message);
	}
}

function insertLog($logArray)
{
	$insertQry = getInsertDataString($logArray, 'requestlog');
	updateData($insertQry);
	return mysql_insert_id();
}

function get_permission($from)
{
	$arr_permission = array();
	$arr_exist_group = getData('SELECT group_id From status_permissions WHERE status_category ="'.$from.'" GROUP BY group_id');
	
	for($i=0; $i<count($arr_exist_group); $i++)
	{
		$exist_status = getData('SELECT status_permission_id, group_id, status_id From status_permissions WHERE status_category ="'.$from.'" and group_id='.$arr_exist_group[$i]['group_id']);
		for($j=0; $j<count($exist_status); $j++)
		{
			$arr_permission[$arr_exist_group[$i]['group_id']][$j] = $exist_status[$j]['status_id'];
		}
	}
	return $arr_permission;
}
function get_allgroups()
{
	$arr_groups =  getData("SELECT group_id, group_name From user_groups WHERE is_active = 1");
	return ($arr_groups);
}
function save_permission($arr_data, $from)
{
	$arr_groups = get_allgroups();
	for($i=0; $i<count($arr_groups); $i++)
	{
		$groupid = $arr_groups[$i]['group_id'];
		if(isset($arr_data["status_$groupid"]))
		{
			$all_exist_status = getData("SELECT status_permission_id, status_id From status_permissions WHERE status_category ='".$from."' and group_id =".$groupid);
			$exist_status = array();
			foreach($all_exist_status as $k=>$v)
			{
				$exist_status[] =  $v['status_id'];
			}
			$intersect = array_intersect($arr_data["status_$groupid"],$exist_status);
			$new_extra = array_diff_assoc($arr_data["status_$groupid"], $intersect);
			$old_extra = array_diff_assoc($exist_status,$intersect);
			foreach($old_extra as $k=>$v) 
			{
				$delquery = "DELETE FROM status_permissions WHERE status_category = '".$from."' and status_id=".$v." and group_id=".$groupid;
				updateData($delquery);
			}
			foreach($new_extra as $k=>$v)
			{
				$insert_data = array(
										'status_category' => $from,
										'group_id' 	=> $groupid,
										'status_id' => $v,
										);
				$insertQry = getInsertDataString($insert_data, 'status_permissions');
				updateData($insertQry);					
			}				
		}
		else
		{
			$delquery = "DELETE FROM status_permissions WHERE status_category = '".$from."' and group_id=".$groupid;
			updateData($delquery);
		}
	}
}
function multi_in_array($needle, $haystack, $strict = false) 
{
	foreach ($haystack as $item) {
		if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && multi_in_array($needle, $item, $strict))) {
			return true;
		}
	}
	return false; 	
} 	

function secondsToTime($seconds,$is_hms_padded=false)
	{
		// extract hours
		$hours = floor($seconds / (60 * 60));
	 
		// extract minutes
		$divisor_for_minutes = $seconds % (60 * 60);
		$minutes = floor($divisor_for_minutes / 60);
	 
		// extract the remaining seconds
		$divisor_for_seconds = $divisor_for_minutes % 60;
		$seconds = ceil($divisor_for_seconds);
	 	
		// return the final array
	 	if($is_hms_padded==true)
		{	$obj = array(
				"h" => str_pad((int) $hours,2,"0",STR_PAD_LEFT),
				"m" => str_pad((int) $minutes,2,"0",STR_PAD_LEFT),
				"s" => str_pad((int) $seconds,2,"0",STR_PAD_LEFT)
			);
			
		}
	 
		else
			{$obj = array(
				"h" => (int) $hours,
				"m" => (int) $minutes,
				"s" => (int) $seconds,
			);
		}
		return $obj;
	}
	
	
function getDateTimeDiff($date1,$date2,$is_hms=false,$is_hms_padded=false)
{
	$seconds = strtotime($date1) - strtotime($date2); 
	if($is_hms==true)	
	{
		if($is_hms_padded==true)
		{	
			$diff = secondsToTime($seconds,true);
		}
		else
		{	$diff = secondsToTime($seconds);
		}
		
		return $diff;
	}
	else
	{
		return ($seconds);   // returns diff in seconds
	}
	
}

function showmsg($field, $action, $matchwith='')
{
	if($action == 'add')
		$msg = ucfirst(strtolower($field))." added successfully !";
	elseif($action == 'update')
		$msg = ucfirst(strtolower($field))." updated successfully!";
	if($action == 'delete')
		$msg = ucfirst(strtolower($field))." deleted successfully!";
	if($action == 'dup')
		$msg = "Duplicate ".strtolower($field)." with same ".$matchwith." found!";
	if($action == 'restore')
		$msg = ucfirst(strtolower($field))." restored successfully!";
	return $msg;
}

// for permission management functions 
function checkUserPemission($arr_all)
{	
	$group_id = $_SESSION['user_main_group'];
	$cond = " group_id = '".$group_id."'";
	//echo "<pre>"; print_r($arr_all);
	if($group_id != developer_grpid)
	{
		if(isset($arr_all['page']))
		{
			$page_id 	= getOne("select page_id from pages WHERE page_name = '".$arr_all['page']."'");	
			if($page_id != "")
				$cond .= " and page_id = '".$page_id."'";
		}
		
		if((isset($arr_all['mainfunction']) && ($arr_all['mainfunction'] != 'show_box_view') ) || (isset($arr_all['function']) && ($arr_all['function'] != 'show_box_view') ))
		{
			if(isset($arr_all['mainfunction']))
				$function_name = $arr_all['mainfunction'];
			else	
				$function_name = $arr_all['function'];
			$function_id = getOne("select function_id from functions WHERE page_id = '".$page_id."' and function_name = '".$function_name."'");
			if($function_id != "")
				$cond .= " and function_id = '".$function_id."'";			
			
			if(isset($arr_all['subfunction_name']))
			{	
				$subfunction_id = getOne("select function_id from sub_functions WHERE  main_function_id  = '".$function_id."' and function_name = '".$arr_all['subfunction_name']."'");
				if($subfunction_id != "")
					$cond .= " and sub_function_id = '".$subfunction_id."'";
			}
		}
		
		$check_permission= getData("Select permission_id from user_permissions where ".$cond);
		//echo "Select permission_id from user_permissions where ".$cond; exit;
		if(count($check_permission) == 0)
		{
			 echo "<script type='text/javascript'>
						alert(\"You do not have permission to view this page.".$function." Please Contact administrator\");
						window.location = 'index.php';
				   </script>";
			exit;
		}
	}
	
}
function check_permission($check='',$groupid='',$pageid='',$functionid='',$subfunctionid='',$action='')
{
	if($check == 'all')
	{
		$perm_pages = getData("select DISTINCT page_id from user_permissions WHERE group_id = ".$groupid." and is_active=1");
		$pages 	= getData("select page_id from pages WHERE is_active = 1");
		if(count($perm_pages) == count($pages))
			return true;
		else
			return false;
	}
	else
	{
		$str_condition = ' group_id='.$groupid.' and is_active=1';
		if($pageid != "")
			$str_condition .= ' and page_id='.$pageid;
		if($functionid != "")
			$str_condition .= ' and function_id='.$functionid;
		if($subfunctionid != "")
			$str_condition .= ' and sub_function_id='.$subfunctionid;
		if($check == 'subfunction')
		{
			if($action == 'view')
				$str_condition .= ' and view_perm = 1';
			if($action == 'add')
				$str_condition .= ' and add_perm = 1';
			if($action == 'edit')
				$str_condition .= ' and edit_perm = 1';
			if($action == 'delete')
				$str_condition .= ' and delete_perm = 1';
			if($action == 'restore')
				$str_condition .= ' and restore_perm = 1';			
		}
		$arr_permission = getData("select permission_id from user_permissions WHERE ".$str_condition);
		//echo "<pre>"; print_r($arr_permission); exit;	
		if(count($arr_permission)> 0)
		 	return true;
		else
			return false;
	}	
}

function get_allmenu($userid)
{
	$groupid = getOne("select user_group from users WHERE user_id = '".$userid."'");
	$arr_allmenu = getData("select * from  pages WHERE is_active = 1");
	$arr_menu = array();
	foreach($arr_allmenu as $k=>$v)
	{
		if($groupid == developer_grpid)
		{
			$arr_menu[] = $v;
		}
		else
		{
			$check_permission = getData("select permission_id from user_permissions WHERE group_id = '".$groupid."' and page_id = '".$v['page_id']."' and is_active=1");
			if(count($check_permission) > 0)
			{
				$arr_menu[] = $v;
			}
		}
	} 
	return $arr_menu;
}

function get_allsubmenu($userid,$pageid)
{
	$groupid = getOne("select user_group  from users WHERE user_id = '".$userid."'"); 
	$arr_submenu = array();
	$arr_allsubmenu = getData("select * from  functions WHERE page_id = '".$pageid."' and is_active=1 ORDER BY menu_order ASC"); //echo 'here'.$groupid; //echo "<pre>"; print_r($arr_allsubmenu); exit;
	foreach($arr_allsubmenu as $k=>$v)
	{
		if($groupid == developer_grpid)
		{
			$arr_submenu[] = $v;
		}
		else
		{
			$check_permission = getData("select permission_id from  user_permissions WHERE group_id = '".$groupid."' and page_id = '".$pageid."' and function_id ='".$v['function_id']."' and is_active=1");
			if(count($check_permission) > 0)
			{
				$arr_submenu[] = $v;
			}
		}
	}
	//echo "<pre>"; print_r($arr_submenu); exit;
	return($arr_submenu);		
	
}

function get_currentpageid($module)
{
	$pageid = getOne('select page_id from pages where module_name = "'.$module.'"');
	return $pageid;
}
function get_current_functionid($name, $pageid)
{
	$functionid = getOne('select function_id from functions where function_name = "'.$name.'" and page_id="'.$pageid.'"');
	return $functionid;
}
function get_menudata($userid,$id,$byfield='',$pageid='')
{	
	if($byfield == 'function_name')
	{
		$functionid = get_current_functionid($id,$pageid);
		$cond = "main_function_id = '".$functionid."'";
	}
	else
		$cond = "main_function_id = '".$id."'";
	$arr_allfunctions = getData("select function_id, page_id, function_name, friendly_name, main_function_id, is_crud from sub_functions WHERE ".$cond." and is_active=1 ORDER BY menu_order ASC");
	
	$groupid = getOne("select user_group  from users WHERE user_id = '".$userid."'"); 
	//echo $groupid;
	$all_subfunction = array();
	foreach($arr_allfunctions as $k=>$v)
	{	
		if($groupid == developer_grpid)
		{
			$all_subfunction[] = $v;
		}
		else
		{
			$check_permission = getData("select * from  user_permissions WHERE group_id = '".$groupid."' and page_id = '".$v['page_id']."' and function_id  ='".$v['main_function_id']."' and sub_function_id = '".$v['function_id']."' and is_active=1");
			if(count($check_permission) > 0)
			{
				$all_subfunction[] = $v;
			}
		}
	}	
	
	return $all_subfunction;
}

function get_permission_data()
{
	$arr_permission = array();
	$arr_pages = getData("select * from pages WHERE is_active = 1");
	$i=0;
	foreach($arr_pages as $k=>$v)
	{
		$arr_permission[$i]['page_id'] = $v['page_id'];
		$arr_permission[$i]['module_name'] = $v['module_name'];
		$arr_functions = getData("select * from functions WHERE page_id = '".$v['page_id']."' and is_active=1 ORDER BY menu_order ASC");
		$j=0;
		foreach($arr_functions as $k1=>$v1)
		{
			$arr_permission[$i]['functions'][$j] = $v1;
			$arr_subfunctions = getData("select * from sub_functions WHERE main_function_id = '".$v1['function_id']."' and is_active=1 ORDER BY menu_order ASC");
			foreach($arr_subfunctions as $k2=>$v2)
			{
				$arr_permission[$i]['functions'][$j]['subfunction'][] = $v2;
			}
			$j++;
		}
		$i++;
	}
	//echo "<pre>"; print_r($arr_permission); //exit;
	return ($arr_permission);
}

function get_action_permissions($userid,$pageid,$function,$function_type,$set_subfunction_id)
{
	$groupid = getOne("select user_group  from users WHERE user_id = '".$userid."'");
	if($groupid == developer_grpid)
	{
			$check_permission[0] = array(
				'permission_id' => 0,
				'view_perm' => 1,
				'add_perm' => 1,
				'edit_perm' => 1,
				'delete_perm' => 1,
				'restore_perm' => 1,
				);
	}
	else
	{	
		$cond='';
		if($function_type == '')
		{
			$functionid = get_current_functionid($function,$pageid);
			$cond .= ' function_id = "'.$functionid.'"';
		}
		elseif($function_type == 'subfunction')
		{
			$cond = " sub_function_id = '".$set_subfunction_id."'";
		}
		$check_permission = getData("select  permission_id, view_perm, add_perm, edit_perm, delete_perm, restore_perm from user_permissions WHERE group_id = '".$groupid."' and page_id = '".$pageid."' and ".$cond);		
		
	}
	//echo "<pre>"; print_r($check_permission); exit;
	return $check_permission;
	 
}

function shownlInjs($text){
	return preg_replace('/(\r?\n)+/', '\\n', $text);
}

function populateNotification($notificationArray=array()){
	if(array_key_exists('type',$notificationArray)) {
		if($notificationArray['type'] == "Success") {
			echo "<div class='msg-ok enable-close' style='cursor: pointer;'>".$notificationArray['message']."</div>";
		} else if($notificationArray['type'] == "Failed") {
			echo "<div class='msg-error enable-close' style='cursor: pointer;'>".$notificationArray['message']."</div>";
		}
	}
}

function sendMail($from,$reply_to,$to,$subject,$field_array,$data_array,$function,$user_name)
{
	$headers = "From: " . $from . "\r\n";
	$headers .= "Bcc: admin@satger.com" . "\r\n";
	$headers .= "Reply-To: ". $reply_to . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$message = '';
	if($function == "add_task")
		$message='<span style="font-weight:bold;font-size: 13px;">'.$user_name.' added this task on </span>';
	else
		$message='<span style="font-weight:bold;font-size: 13px;">'.$user_name.' updated this task on </span>';
	
	$message.=' <span style=color:#838181;font-size:13px;white-space:nowrap>'.date("d-M-Y h:i A").'</span>';	
	$message.='<br><span style="font-weight:bold;font-size: 13px;">Task Details :</span>';
	$message.='<table cellspacing="0" cellpadding="1px" style="font-size:14px;border:1px solid #DDD;margin:10px 0;">';
	$message.='<tr>';
	foreach($field_array as $field)
	{
		$message.='<th style="border:1px solid #DDD;padding:7px 21px 7px 7px;">'.$field.'</th>';	
	}
	$message.='</tr><tr>';
	foreach($data_array as $data)
	{
		$message.='<td style="border:1px solid #DDD;padding:7px 21px 7px 7px;">'.$data.'</td>';
	}
	$message.='</tr></table>';
	//$to = "Vishak Nairrc.pune@gmail.com";
	//$message = "hello";
	if(mail($to,$subject,$message,$headers)){
		//echo "Mail send!";
	}else{
		//echo "Mail not send!";
	}
		
}
?>
