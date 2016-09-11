<?
require_once('library/checkSession.php');
require_once('library/constants.php');
require_once('library/commonFunctions.php');
require_once('library/commonObject.php');
require_once('library/Config.php');

//Purify all request vaiables
purifyInputs();

$request_string = http_build_query($_REQUEST);
$session_string = http_build_query($_SESSION);


if(!(isset($_REQUEST['page'])))
{
	$_REQUEST['page']='';
}

if(!(isset($_REQUEST['function'])))
{
	$_REQUEST['function']='';
}

$logArray = array(
'user_id'=>$_SESSION['user_id'],
'page'=>$_REQUEST['page'],
'function'=>$_REQUEST['function'],
'request_variables'=>$request_string,
'session_variables'=>$session_string,
'request_time'=>date('Y-m-d H:i:s'),
'ip_address'=>$_SERVER['REMOTE_ADDR']);

$log_id = insertLog($logArray);

//Set Page and Function Variables
$landing_page=getOne("SELECT `landing_page` FROM `user_groups` WHERE `group_id`='".$_SESSION['user_main_group']."'");
$landing_page=explode(',',$landing_page);
//$default_page_details=getRow("Select p.`page_id`,p.module_name,p.page_name,f.function_name from `pages` p LEFT JOIN `functions` f ON p.page_id=f.page_id LEFT JOIN sub_functions sb ON sb.main_function_id=f.function_id where sb.function_id='".$landing_page[2]."'");
$default_page_details=getRow("Select p.`page_id`,p.module_name,p.page_name,sb.function_name from `pages` p LEFT JOIN `functions` f ON p.page_id=f.page_id LEFT JOIN sub_functions sb ON sb.main_function_id=f.function_id where sb.function_id='".$landing_page[2]."'");
//var_dump($default_page_details);exit;
//Set Page and Function Variables
$page = setPage()?setPage():$default_page_details['page_name'];
$function = setFunction()?setFunction():$default_page_details['function_name'];
$module = setModule()?setModule():$default_page_details['module_name'];
$pageTitle = getPageTitle($page);

$current_pageid = get_currentpageid($module); //echo $current_pageid;

log_history("Page-Function","Page=>".$page." :: Function=>".$function);

//Check Page & Function Permissions
if($function!='logout')
{
	//echo "<pre>"; print_r($_REQUEST); exit; 
	$arr_all = array(
				'page' => $page,
				'function' => $function				
				);
	if(isset($_REQUEST['mainfunction']))
		$arr_all['mainfunction'] = $_REQUEST['mainfunction'];
	if(isset($_REQUEST['subfunction_name']))
		$arr_all['subfunction_name'] = $_REQUEST['subfunction_name'];
	//echo "<pre>"; print_r($arr_all); exit;
	checkUserPemission($arr_all);
	//checkPagePermissions($page,$function);
	//checkPagePermissions($function);
}

unset($_REQUEST['page']);
unset($_REQUEST['function']);
unset($_POST['page']);
unset($_POST['function']);
?>
