<? if((isset($_POST['wl-username'])) && (trim($_POST['wl-password']) != ""))
{	require_once('library/loginManager.php');
	$inpUsername = $_POST['wl-username'];
	$inpPassword = $_POST['wl-password'];	
	
	if(checkLogin($inpUsername,$inpPassword))
	{
		//session_start();
		setUserDetails($inpUsername);
		header("Location: home.php");
		exit;
	}
	else
	{
		$_SESSION['notification'] = "Username or Password Incorrect";
	}
}
?>
