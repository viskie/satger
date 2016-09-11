<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}
require_once('DAL.php');

$host = "";
$user= "";
$pass= "";
$database = "";


if($_SERVER['HTTP_HOST']=='showroom')
{
	$host="mydb";
	$user="root";
	$pass="ci52.906";
	$database="satger";
	$p=("http://".$_SERVER['HTTP_HOST']."/satger/code/");
	define("PATH",$p);
}else if(($_SERVER['HTTP_HOST']=='appserver') || ($_SERVER['HTTP_HOST']=='10.20.30.40')){
	$host="localhost";
	$user="root";
	$pass="sat_dev_321";
	$database="satgerapp";
	$p=("http://".$_SERVER['HTTP_HOST']."/Satger");
	define("PATH",$p);
}else if(($_SERVER['HTTP_HOST']=='www.satger.com') ||($_SERVER['HTTP_HOST']=='satger.com') ||($_SERVER['HTTP_HOST']=='http://satger.com') ){
	$host="satgerapp.db.8955426.hostedresource.com";
	$user="satgerapp";
	$pass="S@tger11515";
	$database="satgerapp";
	$p=("http://".$_SERVER['HTTP_HOST']."/Satger-Demo");
	define("PATH",$p);
}else if(($_SERVER['HTTP_HOST']=='www.satger.info') ||($_SERVER['HTTP_HOST']=='satger.info') ||($_SERVER['HTTP_HOST']=='http://satger.info') ){
	$host="localhost";
	$user="satgerin_stgrapp";
	$pass="Qyp6#k+9Q0)H";
	$database="satgerin_satgerapp";
	$p=("http://".$_SERVER['HTTP_HOST']."/satger");
	define("PATH",$p);
}else{
	$host="localhost";
	$user="root";
	$pass="sat_dev_321";
	$database="satgerapp";
	$p=("http://".$_SERVER['HTTP_HOST']."/Satger");
	define("PATH",$p);
}

mysql_connect($host,$user,$pass,TRUE) or die("could not connect");
mysql_select_db($database) or die("could not select database".$database);
mysql_set_charset("utf8");

?>