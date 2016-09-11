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
?>

<input type="hidden" name="edit_id" value="" id="edit_id" /> 
<input type="hidden" name="mainfunction" id="mainfunction" value="<?php if(isset($data['mainfunction'])) echo $data['mainfunction']; else  echo $mainfunction; ?>" />
<input type="hidden" name="subfunction_name" id="subfunction_name" value="<?php if(isset($data['subfunction_name'])) echo $data['subfunction_name']; else echo $subfunction_name; ?>" />
<!-- Content -->
<div id="content" class="clearfix">

	<?php
        /* Populate the notifiction if any */
		populateNotification($notificationArray);
    ?>
        
<?php /* TO SHOW CONTENT IN ONE COLUMN MODE (NORMAL VIEW) */ ?>

    <!-- Main Content -->
    <div id="main-content">
		<!-- Page Title -->
        <h2>My Profile</h2>

        <!-- body container -->
        <div class="body-con">  
			<!-- Here you can add the main content of the view -->
			<input type="hidden" id="user_group" name="user_group" value='' />
			<ul class="align-list">
            	<li>
                	<label for="name">Name<span>*</span></label>
                   	<input type="text" id="name" name="name" class="validate[required,custom[onlyLetter]]" value='<?php echo $data['profile_details']['name']; ?>' />
				</li>
				<li>
					<label for="user_name">Username</label>
                    <label for="name" style="text-align:left"><?php echo $data['profile_details']['user_name']; ?></label>
					
				</li>
                <li>
                	<label for="user_password">Password<span>*</span></label>
					<input type="password" id="user_password" name="user_password" value='********' class="validate[required,length[6,20]]" />
				</li>
                <li>
                	<label for="conf_password">Confirm Password<span>*</span></label>
					<input type="password" id="conf_password" value='********' class="validate[required,length[6,20],equals[user_password]]" />
				</li>
                
                <li>
                	<label for="user_phone">Phone<span>*</span></label>
					<input type="text" id="user_phone" name="user_phone"  class="validate[required,length[10,15],custom[phone]]" value='<?php echo $data['profile_details']['user_phone']; ?>' />
				</li>
                <li>
                	<label for="user_email">Email<span>*</span></label>
					<input type="text" id="user_email" name="user_email" class="validate[required,custom[email]]" value='<?php echo $data['profile_details']['user_email']; ?>' />
				</li>
				<li>
					<label></label>
					<input type="button" value="Update" class="green_button"  onclick="javascript:validateProfileDetails('hrm','save_my_profile');" >
				</li>
			</ul>
		</div>
        <!-- END of Body Container -->
    </div>
    <!-- END Main Content -->

</div>
<!-- END Content -->