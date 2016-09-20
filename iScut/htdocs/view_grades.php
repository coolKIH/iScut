<?php

$page_title='平均成绩统计';
include ('includes/header.html');

if($_COOKIE['type'] != 'm'){
	require_once("includes/login_funtions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
require_once('../mysqli_connect.php');
echo '<form action="view_grades.php" method="POST">
<p><b>个人平均成绩(输入学号或者姓名):</b><input type="text"
name="student" maxlength="12" size="15"/><input type="submit"
name="get_one" value="查询"/></p>
<p><b>班级平均成绩:</b><input type="text"
name="class" maxlength="20" size="15" /><input type="submit"
name="get_class" value="查询"/></p>
<p><b>课程平均成绩:</b><input type="text" name="course" 
maxlength="20" size="15" /><input type="submit" name="get_course"
value="查询" /></p>
<p><input type="submit" name="get_all" value="查询全体学生平均成绩"/></p></form>';
if(isset($_POST['get_one'])){
	$p=trim($_POST['student']);
	if(empty($p)){
		echo '<h3>请填写具体信息</h3>';
	}else{
	if(is_numeric($p)){
	$q="SELECT student.s_id,student.s_name, round(AVG(grade),2) FROM student INNER JOIN enrol USING (s_id) WHERE student.s_id='$p' AND !ISNULL(enrol.grade)";
	}else{
		$q="SELECT student.s_id,student.s_name, AVG(grade) FROM student INNER JOIN enrol USING (s_id) WHERE student.s_name='$p' AND !ISNULL(enrol.grade)";
	}
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)==1){
		$row=mysqli_fetch_array($r,MYSQLI_NUM);
		echo '<table align="width" cellspacing="3" cellpadding="3" width="50%"><tr><td align="left">学号</td><td align="left">姓名</td><td align="left">平均分</td></tr>
		<tr><td align="left">'.$row[0].'</td><td align="left">'.$row[1].'</td><td align="left">'.$row[2].'</td></tr></table>';
		
	}else{
		echo '<h3>没有可显示的结果</h3>';
	}
	}
	}elseif(isset($_POST['get_class'])){
	$sc=trim($_POST['class']);
	if(empty($sc)){
		echo '<h3>请填写具体信息</h3>';
	}else{
	$q="SELECT student.s_class,AVG(enrol.grade) FROM student INNER JOIN enrol USING (s_id) WHERE student.s_class='$sc'"; 
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)==1){
		$row=mysqli_fetch_array($r,MYSQLI_NUM);
		echo '<table align="width" cellspacing="3" cellpadding="3" width="50%"><tr><td align="left">班级</td><td align="left">平均分</td></tr>
		<tr><td align="left">'.$row[0].'</td><td align="left">'.$row[1].'</td></tr></table>';	
	}else{
		echo '<h3>没有可显示的结果</h3>';
	}
	}
}elseif(isset($_POST['get_course'])){
	$c=trim($_POST['course']);
	if(empty($c)){
		echo '<h3>请填写具体信息</h3>';
	}else{
	if(is_numeric($c)){
		$q="SELECT course.c_id,course.c_name,AVG(grade) FROM course INNER JOIN enrol WHERE c_id='$c'";
	}else{
		$q="SELECT course.c_id,course.c_name,AVG(grade) FROM course INNER JOIN enrol WHERE c_name='$c'";
	}
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)==1){
		$row=mysqli_fetch_array($r,MYSQLI_NUM);
		echo '<table align="width" cellspacing="3" cellpadding="3" width="50%"><tr><td align="left">课程编号</td><td align="left">课程名称</td><td align="left">平均分</td></tr>
		<tr><td align="left">'.$row[0].'</td><td align="left">'.$row[1].'</td><td align="left">'.$row[2].'</td></tr></table>';
		
	}else{
		echo '<h3>没有可显示的结果</h3>';
	}
	}
}elseif(isset($_POST['get_all'])){
	$q="SELECT AVG(grade) FROM enrol";
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)==1){
		$row=mysqli_fetch_array($r,MYSQLI_NUM);
		echo '<table align="width" cellspacing="3" cellpadding="3" width="50%"><tr><td align="left">平均分</td></tr>
		<tr><td align="left">'.$row[0].'</td></tr></table>';
		
	}else{
		echo '<h3>没有可显示的结果</h3>';
	}
}
	

include("includes/footer.html");
?>