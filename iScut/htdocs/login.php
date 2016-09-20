<?php

//ini_set('display_errors',1);
if(!empty($_COOKIE['id']))
{
	require_once('includes/login_functions.inc.php');
	$url=absolute_url('loggedin.php');
	header("Location:$url");
	exit();
}
if(isset($_POST['submitted']) && isset($_POST['type']) )
{
	require_once('includes/login_functions.inc.php');
	require_once('../mysqli_connect.php');
	//mysqli_query($dbc,"set names utf8");
	$type=$_POST['type'];
	if( check_login($dbc,$type,$_POST['id'],$_POST['pass']))
	{
		setcookie('id',$_POST['id']);
		setcookie('type',$type);
		$url=absolute_url('loggedin.php');
		header("Location:$url");
		exit();
	}else $errors="errors";
	mysqli_close($dbc);
}

include ('includes/login_page.inc.php');
?>
