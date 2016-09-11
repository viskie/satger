<?php 

//$permissionArray = getUserGroupPermissions(); 



$permissionArray = get_allmenu($logArray['user_id']);

//echo "<pre>"; print_r($permissionArray); exit;

?>





<!-- Panel Outer -->

<div id="panel-outer" class="radius">



<!-- Panel -->

<div id="panel" class="radius">



<!-- Include main menu -->

<!-- Main menu -->

<!-- This is the structure of main menu -->

<ul id="main-menu" class="radius-top clearfix" >

   <?php    

    

	$tabindex = 1;

	$arr_functions = get_allsubmenu($logArray['user_id'], $current_pageid);

	//echo count($permissionArray); echo "<pre>"; print_r($permissionArray); exit;

	foreach($permissionArray as $key=>$value)

	{

		?>

        <li>

        <a href="javascript:callPage('<?php echo $value['module_name']; ?>','show_box_view')" <?php if ( $module == $value['module_name'] ) 

																				{ echo 'class="active submenu-active"';

																					$tabindex_sub = $tabindex; 

																				} ?> tabindex="<?php echo $tabindex++; ?>" >

            <img src="<?=$value['img_url']?>" alt="<?=$value['description']?>" />

            <span><?=$value['description']?></span>

			<span class="submenu-arrow"></span><!-- Also this is required for the submenu -->

        </a>

    </li>        

        <?php	

		if ( $module == $value['module_name'] ) 

		{

			if(count($arr_functions) > 1)

				$tabindex = $tabindex+count($arr_functions);

		}

	}	

	

?> 

</ul>

<!-- END Main menu -->



<!-- Submenu -->

<!-- Depending on the page we are, we make visible the submenu we need -->



<!-- displya submenus dynamically -->

<input type="hidden" name="tabindex_val" id="tabindex_val" value="<?php echo ($tabindex_sub++); ?>" />

<!--<input type="hidden" name="from_menu" id="from_menu" value="">-->

<ul id="sub-menu" class="clearfix">

<?php 
foreach($arr_functions as $k=>$v)
{
	?>

    <li><a href="javascript:menu_callPage('<?php echo $module?>','<?php echo $v['function_name']; ?>')"><?php echo $v['friendly_name']; ?></a></li>

    <?php 		

}

?>

</ul>

<!-- //////////////////////////////////////////// -->



<?php /*if ( $module == 'inventory' ) { ?>

<ul id="sub-menu" class="clearfix">

	<li><a href="javascript:callPage('inventory','view_inventory');">Inventory</a></li>

	<li><a href="javascript:callPage('inventory','view_warehouse')">Warehouse</a></li>

</ul>

<? }  ?>



<?php if ( $module == 'materials' ) { ?>

<ul id="sub-menu" class="clearfix">

	<li><a href="javascript:callPage('materials','view_purchase')">Purchase</a></li>

    <li><a href="javascript:callPage('materials','view_supplier')">Supplier</a></li>

    <li><a href="javascript:callPage('materials','view_material')">Material</a></li>

</ul>

<? }  ?>



<?php if ( $module == 'clients' ) { ?>

<ul id="sub-menu" class="clearfix">

    <li><a href="javascript:callPage('clients','view')">clients</a></li>    

</ul>

<? }  ?>



<?php if ( $module == 'projects' ) { ?>

<ul id="sub-menu" class="clearfix">

    <li><a href="javascript:callPage('projects','view')">Projects</a></li>

</ul>

<? }  ?>



<?php if ( $module == 'products' ) { ?>

<ul id="sub-menu" class="clearfix">

    <li><a href="javascript:callPage('products','view')">Products</a></li>    

</ul>

<? }  ?>



<?php if ( $module == 'settings' ) { ?>

<ul id="sub-menu" class="clearfix">

    <li><a href="javascript:callPage('settings','view_project_category')">Project Category</a>

    <li><a href="javascript:callPage('settings','view_payment_category')">Payment Category</a></li>

	<li><a href="javascript:callPage('settings','import')"  >Import</a></li>

    <li><a href="javascript:callPage('settings','view_financial_month')"  >Financial Month</a></li>

    <li><a href="javascript:callPage('settings','show_configuration');">Lead Configuration</a></li>   

    <li><a href="javascript:callPage('settings','view_order_status');">Order Configuration</a></li>

	<li><a href="javascript:callPage('settings','view_leave_setting');">Leave Settings</a></li>

    <li><a href="javascript:callPage('settings','view_pages');">Pages</a></li>

    <li><a href="javascript:callPage('settings','view_function')"  >Functions</a></li>

    <li><a href="javascript:callPage('settings','manage_subfunction')">Sub Functions</a></li>

    <li><a href="javascript:callPage('settings','manage_permissions')">Permissions</a></li>

</ul>

<? }  ?>





<?php if ( $module == 'accounts' ) { ?>

<ul id="sub-menu" class="clearfix">

    <li><a href="javascript:callPage('accounts','view')" >Monthly Overview</a></li>

    <li><a href="javascript:callPage('accounts','view_incomes')">Income</a></li>

    <li><a href="javascript:callPage('accounts','view_expenses')">Expense</a></li>

	<li><a href="javascript:callPage('accounts','view_expected_expenses')">Expected Expense</a></li>

</ul>

<? }  ?>



<?php if ( $module == 'hrm' ) { ?>

<ul id="sub-menu" class="clearfix">

    <!-- <li><a href="javascript:callPage('settings','view')" >Twillio Settings</a></li> -->

    <!-- <li><a href="javascript:callPage('settings','view_project_category')"  >Project Category</a></li> -->

    <li><a href="javascript:callPage('hrm','view_employees')">Employee</a></li>   

    <li><a href="javascript:callPage('hrm','view_reimbursement');">Reimbursement</a></li>

    <li><a href="javascript:callPage('hrm','show_add_reimbursement');">Add Reimbursement</a></li>

    <li><a href="javascript:callPage('hrm','attendance');">Attendance</a></li>

    <li><a href="javascript:callPage('hrm','reports');">Attendance Reports</a></li>

    <li><a href="javascript:callPage('hrm','approve_attendance');">Approve</a></li>

	<li><a href="javascript:callPage('hrm','apply_for_leave');">Apply For Leave</a></li>

    <!--<li><a href="javascript:callPage('hrm','view_approve_leaves');">Approve Leaves</a></li>-->

    <li><a href="javascript:callPage('hrm','view_leaves_management');">Leaves Management</a></li>

</ul>

<? }  ?>



<?php if ( $module == 'leads' ) { ?>

<ul id="sub-menu" class="clearfix">

	<li><a href="javascript:callPage('leads','view_sales')">Sales</a></li>

    <li><a href="javascript:callPage('leads','view_leads')" >Leads</a></li>

    <li><a href="javascript:callPage('leads','order_mngt');">Orders</a></li>

</ul>

<? } ?>



<?php if ( $module == 'users' ) { ?>

<ul id="sub-menu" class="clearfix">

    <li><a href="javascript:callPage('users','view')"  >Users</a></li>

    <li><a href="javascript:callPage('users','view_groups');">Groups</a></li> 

</ul>

<? }*/ ?>

<!-- END Submenu -->

