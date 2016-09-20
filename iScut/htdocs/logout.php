<?php
if(!isset($_COOKIE['id']))
{
	require_once('includes/login_functions.inc.php');
	$url=absolute_url();
	header("Location:$url");
	exit();
}else {
	setcookie('id');
	setcookie('type');
}

$page_title="登出";
include ("includes/header.html");

echo "<h1>已经注销！</h1>
<p>欢迎再次登录</p>";
include ("includes/footer.html");

?>
