<?php
	switch($function)
		{
			case "view":
			break;
			
			case "logout":
				 $_SESSION['user_id'] = "";
				 $_SESSION['user_name'] = "";
				 $_SESSION['user_group'] = "";
				 $_SESSION['preferred_language'] = "";
				 $_SESSION['name'] = "";
				 $_SESSION['user_login'] = false;
				 session_destroy();
				 header("Location: login.php");
				 echo "
				 		<script type='text/javascript'>
							window.location = 'login.php';
						</script>
				 ";
			break;
			case "language_change":
				require_once('library/userManager.php');
				$userObject = new UserManager();
				$language=$_REQUEST['language'];
				$userObject->setLanguage($language,$_SESSION['user_id']);
				
				$_SESSION['preferred_language'] = $language;
				
				//$page = getOne("SELECT `page_name` FROM `pages` WHERE `is_active`=1 AND `page_id`=(select landing_page from user_groups where group_id = '".$_SESSION['user_main_group']."')");
				
				$page = "manage_settings.php";
			break;
		}
?>
