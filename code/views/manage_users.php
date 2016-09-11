<?

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)

{

	header("location: index.php");

	exit();

}



?>

				



    <!-- Content -->

    <div id="content" class="clearfix">

        <input type="hidden" name="edit_id" value="<?php if(isset($data['userDetails'])) echo $data['userDetails']['user_id']?>" id="edit_id" />

        <input type="hidden" name="user_id" value="<?php if(isset($data['userDetails'])) echo $data['userDetails']['user_id']?>" id="user_id" />

		<input type="hidden" name="show_status" id="show_status" value="" />

        <input type="hidden" name="mainfunction" id="mainfunction" value="<?php if(isset($data['mainfunction'])) echo $data['mainfunction']; else  echo $mainfunction; ?>" />

    	<input type="hidden" name="subfunction_name" id="subfunction_name" value="<?php if(isset($data['subfunction_name'])) echo $data['subfunction_name']; else echo $subfunction_name; ?>" />

        <!-- Sidebar -->

        <div id="side-content-left">   

     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>

        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  

      <? }  else  if($notificationArray['type'] == "Failed") { ?>

      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>

      <?   } } ?>

            <!-- Roles box -->

            <table style="display:none">

                <thead>

                    <tr>

                        <th colspan="2">Roles</th>

                    </tr>

                </thead>

                <tbody>

                   <?

                   foreach($data['allGroups'] as $value)

                   {

                       ?>

                       <tr>

                        <td class="backcolor tleft"><?=$value['group_name']; ?></td>

                        <td><a href="javascript: void(0)" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>

                        </td>

                      </tr>									   

                       <?

                   }

                   ?>	

                </tbody>

            </table>

            <!-- END Roles box -->

            

            <!-- Add user Box -->

            <?php if($data['arr_permission'][0]['add_perm'] == 1 || (isset($data['userDetails']) && $data['arr_permission'][0]['edit_perm'] == 1)) { ?>

            <h3><? if(isset($data['userDetails'])){ echo "Edit User";}else { echo "Add User";}?></h3>

            <div class="body-con">

            <label for="sf-username">Username<span>*</span></label>

                    <input type="text" id="user_name" name="user_name" value="<?php if(isset($is_exist) && ($is_exist == true)) 

                                                                                        { echo $data['userVariables']['user_name']; }

                                                                                    elseif(isset($data['userDetails']))

                                                                                        echo $data['userDetails']['user_name'];

                                                                                ?>"/>

                    <label for="sf-email">Email<span>*</span></label>

                    <input type="text" id="user_email" name="user_email" value="<?php if($is_exist == true) 

                                                                                        { echo $data['userVariables']['user_email']; }

                                                                                      elseif(isset($data['userDetails']))

                                                                                        echo $data['userDetails']['user_email'];

                                                                                ?>"/>

                    <label for="sf-email">Name<span>*</span></label>

                    <input type="text" id="name" name="name" value="<?php if($is_exist == true) 

                                                                            { echo $data['userVariables']['name']; }

                                                                          elseif(isset($data['userDetails']))

                                                                            echo $data['userDetails']['name'];

                                                                    ?>"/>

                    <label for="sf-password">Password<span>*</span></label>

                    <input type="password" id="user_password" name="user_password" value="<?php if(isset($data['userDetails']))

                                                                                                    echo '********';

                                                                                            ?>" />

                     <label for="sf-password">Phone<span>*</span></label>

                    <input type="text" id="user_phone" name="user_phone" value="<?php if($is_exist == true)

                                                                                         { echo $data['userVariables']['user_phone']; }

                                                                                      elseif(isset($data['userDetails']))

                                                                                         echo $data['userDetails']['user_phone'];

                                                                                ?>"/>

                   <label for="sf-role">Role</label>

                   <?php 

                    if((isset($is_exist) && $is_exist == true) || (isset($data['userDetails'])))

                    {

                        if((isset($is_exist) && $is_exist == true))

                            $selected_val = $data['userVariables']['user_group'];

                        else

                            $selected_val = $data['userDetails']['user_group'];

                        createComboBox('user_group','group_id','group_name',  $data['allGroups'],false,$selected_val);

                    }

                    else

                        createComboBox('user_group','group_id','group_name', $data['allGroups'],false);

                    if(isset($data['userDetails']))

                    {

                    ?>

                    <input type="button" value="Submit" class="green_button"  onclick="javascript:editUser('users','edit_user_entry')" />

                    <?php 

                    }

                    else

                    {

                   ?>

                   <input type="button" value="Insert" class="green_button" onClick="addUser('users','add_user')" />

                    <?php } ?>

            </div>

            <!-- END Add user Box -->

             <?php 

				$div_id = 'main-content-right';

			} ?>       



        </div>

        <!-- END Sidebar -->



        <!-- Main Content -->

        <div id="<?php if(isset($div_id)) echo $div_id; else echo 'main-content'; ?>">



            <!-- All Users -->

            <h2>All Users (<?=sizeof($data['allUsers'])?>)</h2>

            <div class="show_links">

				<a href="javascript:show_records(0, 'users', 'users')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts']['all']?>)</a><span> | </span>

				<a href="javascript:show_records(1, 'users', 'users')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts']['active']?>)</a><span> | </span>

				<a href="javascript:show_records(2, 'users', 'users')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 2) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts']['deleted']?>)</a>

			</div>

            

            <div class="body-con">   

            <!-- Users table --> 

            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">

                <thead>

                    <tr>

                        <th>Username</th>

                        <th>Email</th>

                        <th>Name</th>

                        <th>Phone</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                   <?

                       foreach($data['allUsers'] as $value)

                       {

                           ?>

                            <tr>

                                <td class="backcolor"><?=$value['user_name']; ?></td>

                                <td><?=$value['user_email']; ?></td>

                                <td><?=$value['user_name']; ?></td>

                                <td><?=$value['user_phone']; ?></td>

                                <td>

								<? if($value['is_active'] != 0){?> 

                                	<?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>

								<a href="javascript:openEditUser('<?=$value['user_id']?>','users','edit_user')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>		

                                	<?php } if($data['arr_permission'][0]['delete_perm'] == 1) {  ?>

											&nbsp;&nbsp;&nbsp;<a href="javascript:deleteUser('<?=$value['user_id']?>','<?=$value['user_name']?>','users','delete_user')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>

								

								<? 		}

								}else{

									if(isset($_REQUEST['show_status']))

										if($data['arr_permission'][0]['restore_perm'] == 1) {

											echo "<a href=\"javascript:restoreEntry('".$value['user_id']."','users','restore_user')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>";

										}

									}	

								?>

								</td>

                            </tr>								   

                           <?

                       }

                      ?>	

                </tbody>

            </table>

            <!-- END Users table -->                           

            </div>

            

        </div>

        <!-- END Main Content -->



    </div>

    <!-- END Content -->

