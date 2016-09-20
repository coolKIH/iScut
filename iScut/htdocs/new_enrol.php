<?php
$page_title="新增选课信息";
include ("includes/header.html");

if($_COOKIE['type'] != 'm'){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
require_once("../mysqli_connect.php");
if(isset($_POST['submitted'])){
	if( !( empty($_POST['sid']) | empty($_POST['cid']) |
	empty($_POST['semester']) | empty($_POST['year']) | empty($_POST['tid'])) ){
		$sid=trim($_POST['sid']);$cid=trim($_POST['cid']);
		$s=trim($_POST['semester']);$y=trim($_POST['year']);$tid=trim($_POST['tid']);
		$q="SELECT * FROM student WHERE s_id=$sid";
		$r=@mysqli_query($dbc,$q);
		if(mysqli_num_rows($r)!=0){
			$q="SELECT * FROM teaches WHERE c_id=$cid AND semester=$s AND year=$y AND t_id=$tid";
			$r=mysqli_query($dbc,$q);
			if(mysqli_num_rows($r)!=0){
				$q="INSERT INTO enrol VALUES ('$sid','$cid','$s','$y',NULL,'$tid',NULL)";
				$r=@mysqli_query($dbc,$q);
				if(mysql_affected_rows($dbc)!=0){
					echo '<h2>恭喜你，新增选课信息成功！</h2>';
				}else{
					echo '<p class="error">添加失败，可能选课信息已存在！</p>';
				}
			}else{
				echo '<p class="error">无此课程安排</p>';
			}
			
		}else{
			echo '<p class="error">该学号不存在</p>';
		}
	}else{
		echo '<p class="error">请填写完整表格</p>';
	}
}
echo '<form action="new_enrol.php" method="POST">
<p><b>学生学号</b><input type="text" name="sid" maxlength="10"
size="12" /></p>
<p><b>课程编号</b><input type="text" name="cid" maxlength="7"
size="12" /></p>
<p><b>学期</b><input type="radio" name="semester" value="1" checked="checked" />1
<input type="radio" name="semester" value="2" />2</p>
<p><b>学年</b><select name="year">';
for($i=2008;$i<2018;$i++){
	echo '<option value="'.$i.'">'.$i.'</option>';
}
echo '</select>
<p><b>教师编号</b><input type="text" name="tid" maxlength="5" size="10"/></p>
<p><input type="submit" name="submitted" value="确认添加" /></p></form>';

include("includes/footer.html");
?>