<?php
$page_name="编辑课程";
include ("includes/header.html");

if($_COOKIE['type'] != 'm'){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
if(isset($_GET['cid']) && is_numeric($_GET['cid'])){
	$cid=$_GET['cid'];
}elseif(isset($_POST['ocid']) && is_numeric($_POST['ocid']) ){
	$cid=$_POST['ocid'];
}else{
	echo '<p class="error">This page has been accessed in error.</p>';
	include("includes/footer.html");
	exit();
}
require_once("../mysqli_connect.php");

if(isset($_POST['submitted'])){
	if(!(empty($_POST['cid']) | empty($_POST['cname']) | empty($_POST['credit'])|
		empty($_POST['lg'])  )){
			$i=trim($_POST['cid']);
			$n=trim($_POST['cname']);
			$c=trim($_POST['credit']);
			$l=trim($_POST['lg']);
			$o=$_POST['oy'];
			
			$q="UPDATE course SET c_id='$i',c_name='$n',credit='$c',least_grade='$l',
			off_year=$o WHERE c_id='$cid'";
		
			$r=@mysqli_query($dbc,$q);
			if(mysqli_affected_rows($dbc)==1) echo '<p>课程信息已经更新</p>';
			else echo '改动失败！';
		}else{
			echo '<p class="error">请正确填写课程信息！</p>';
		}
}
$q="SELECT * FROM course WHERE c_id='$cid'";
$r=@mysqli_query($dbc,$q);
if(mysqli_num_rows($r)==1){
	$row=mysqli_fetch_array($r,MYSQLI_ASSOC);
	echo '<form action="edit_course.php" method="post">
	<p><b>课程编号</b><input type="text" name="cid" value="'.$row['c_id'].'"
	size="12" maxlength="7" /></p>
	<p><b>课程名称</b><input type="text" name="cname" value="'.$row['c_name'].'"
	size="12" maxlength="10" /></p>
	<p><b>学分</b><input type="text" name="credit" value="'.$row['credit'].'"
	size="12" maxlength="5" /></p>
	<p><b>年级限制</b><select name="lg">';
	for($i=1;$i<=4;$i++){
		echo '<option value="'.$i.'"';
		if($i==$row['least_grade']) echo 'selected="selected"';
		echo '>'.$i.'</option>';
	}
	echo '</select></p>';
	echo '<p><b>撤销年份</b><select name="oy"><option value="NULL">无</option>';
	for($i=2010;$i<=2020;$i++){
		echo '<option value="'.$i.'"';
		if($i==$row['off_year']) echo 'selected="selected"';
		echo '>'.$i.'</option>';
	}
	echo '</select></p><p><input type="submit" name="submitted" value="确认修改" /></p>
	<input type="hidden" name="ocid" value="'.$row['c_id'].'" />	</form>';
	
}else{
	echo '<p class="error">有错误发生！</p>';
	include("includes/footer.html");
	exit();
}

include("includes/footer.html");
?>
