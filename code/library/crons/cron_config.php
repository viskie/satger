<?php
/*	$host="localhost";
	$user="satger_satm1";
	$pass="$(ST6)wR6}=8";
	$database="satger_satgerinternal";
*/	
	require_once('../DAL.php');
	$host="localhost";
	$user="root";
	$pass="";
	$database="satgerapp";

	mysql_connect($host,$user,$pass,TRUE) or die("could not connect");
	mysql_select_db($database) or die("could not select database".$database);
?>