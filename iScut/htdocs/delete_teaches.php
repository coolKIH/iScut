<?php
$page_title="删除授课信息";
include ("includes/header.html");

if($_COOKIE['type'] != 'm'){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
require_once("../mysqli_connect.php");
if(isset($_GET['id'])){
	$i=$_GET['id'];
}elseif(isset($_POST['id'])){
	$i=$_POST['id'];
}else{
	echo '<p class="error">本页面被错误访问!</p>';
	include("includes/footer.html");
	exit();
}
if(isset($_POST['submitted'])){
	if($_POST['sure']=='no'){
	echo '<p>你取消了删除操作！</p>';
	}elseif($_POST['sure']=='yes'){
		$q="DELETE FROM teaches WHERE teaches_id=$i";
		$r=@mysqli_query($dbc,$q);
		if(mysqli_affected_rows($dbc)==1){
			echo '<h1>删除成功！</h1>';
		}else{
			echo '<h1>删除失败！</h1>';
		}
	}
}else{

$q="SELECT t_id FROM teaches WHERE teaches_id=$i";
$r=@mysqli_query($dbc,$q);
if(mysqli_num_rows($r)!=1){
	echo '<h3>不存在此记录，所以无法删除</h3>';
	include("includes/footer");
	exit();
}
echo '<form action="delete_teaches.php" method="POST">
<p><b>确定删除吗？</b></p>
<p><input type="radio" name="sure" value="yes"/>是的
<input type="radio" name="sure" value="no" checked="checked"/>不是</p>
<p><input type="submit" name="submitted" value="确定" /></p>
<input type="hidden" name="id" value="'.$i.'"/>';
}
include("includes/footer");
?>