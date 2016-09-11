<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
/****************************************************************
*	This file is made up with the code.
*	Please maintain the HTML structure as it is.
*	There are some HTML components which are surrounded by HTML comments
*	They are put there to maintain the general structure.
*	There are one column mode and two column mode in HTML.
*	Delete the one you don't want to use.
******************************************************************/
//extract($data);
?>

<!-- Content -->
<div id="content" class="clearfix">
<input type="hidden" name="show_status" id="show_status" value="<?php if(!isset($data['show_status']) || ($data['show_status'] == 1 )) echo '1';
																			  elseif((isset($data['show_status']) && $data['show_status'] == 0)) echo '0';
																			  elseif($data['show_status'] == 2) echo '2';?>" />
<input type="hidden" name="mainfunction" id="mainfunction" value="<?php if(isset($data['mainfunction'])) echo $data['mainfunction']; else  echo $mainfunction; ?>" />
<input type="hidden" name="subfunction_name" id="subfunction_name" value="<?php if(isset($data['subfunction_name'])) echo $data['subfunction_name']; else echo $subfunction_name; ?>" />  
<input type="hidden" name="edit_id" id="edit_id" value="<?php if(isset($data['franchiseDetails'])) echo $data['franchiseDetails']['franchise_id']; ?>" /> 

	<?php populateNotification($notificationArray); ?>
        
	<?php /* You can use following content blocks as per your requirements */ ?>

	<?php // TO SHOW CONTENT IN ONE COLUMN MODE (NORMAL VIEW) ?>

    <!-- Main Content -->
    <div id="main-content">
		<!-- Page Title -->
        <h2>All Franchise (<?php echo count($data['allFranchise']) ?>)</h2>
		
		<!-- Links -->
		<div class="show_links">
			<!--<a href="javascript:show_records(0,'franchise','view');" >All(14)</a>|
			<a href="javascript:show_records(1,'franchise','view');" >Active(10)</a>|
			<a href="javascript:show_records(2,'franchise','view');" >Deleted(4)</a> -->
            
            <a href="javascript:show_records(0,'franchise','view');" <?php  if((isset($data['show_status']) && $data['show_status'] == 0)) echo 'class="show_active"';?> >All (<?php echo $data['rec_counts']['all']; ?>)</a>|
            <a href="javascript:show_records(1,'franchise','view');" <?php if($data['show_status'] == 1 || !isset($data['show_status'])) echo 'class="show_active"';?>>Active (<?php echo $data['rec_counts']['active']; ?>)</a>|
            <a href="javascript:show_records(2,'franchise','view');" <?php if($data['show_status'] == 2) echo 'class="show_active"';?>>Deleted (<?php echo $data['rec_counts']['trash']; ?>)</a>
		</div>
		<?php if($data['arr_permission'][0]['add_perm'] == 1) { ?>
        <!-- Add link for data-tables(For CRUDs only) -->
        <a href="javascript:showForm('0','franchise','show_franchise_form');" class="for_links">Add Franchise</a>
		<? }?>
        <!-- body container -->
        <div class="body-con">  
			<!-- Here you can add the main content of the view -->
			   
            <!-- Datatables --> 
            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                <thead>
                    <tr>
                    	<th>No</th>
                    	<th>Code</th>
                       	<th>Franchise Name</th>
                       	<th>Region</th>
                       	<th>Type</th>
                       	<th>Country</th>
                       	<th>Phone Main</th>
                        <th>Email</th>
                        <th>Owner Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					$i=1;
					foreach($data['allFranchise'] as $franchise){
						echo"<tr>";
							echo"<td>".$i++."</td>";
							echo"<td>".$franchise['franchise_code']."</td>";
							echo"<td>".$franchise['franchise_name']."</td>";
							echo"<td>".$franchise['franchise_region']."</td>";
							echo"<td>".$franchise['franchise_type']."</td>";
							echo"<td>".$franchise['country']."</td>";
							echo"<td>".$franchise['phone_main']."</td>";
							echo"<td>".$franchise['email']."</td>";
							echo"<td>".$franchise['owner']."</td>";
				?>
                			<td>
							<? if($franchise['is_active'] != 0) {?>
                            	<?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>
									<a href="javascript:showForm('<?=$franchise['franchise_id']?>','franchise','show_franchise_form')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a><? }?>
                                    <?php if($data['arr_permission'][0]['delete_perm'] == 1) { ?>
									<a href="javascript:deleteRecord('<?=$franchise['franchise_id']?>','<?=$franchise['franchise_name']?>','franchise','delete_franchise')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
                                    <? }?>
							<? }else{ 
								if(isset($_REQUEST['show_status']))
								 if($data['arr_permission'][0]['restore_perm'] == 1) { 
									echo "<a href=\"javascript:restoreEntry('".$franchise['franchise_id']."','franchise','restore_franchise')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";
								 }
							
							}?>
					</td>
                <?php			
						echo"</tr>";
					}
				?>									   
                </tbody>
            </table>
            <!-- END of datatables --> 
        </div>
        <!-- END of Body Container -->
    </div>
    <!-- END Main Content -->

</div>
<!-- END Content -->