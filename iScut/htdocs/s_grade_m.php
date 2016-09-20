<?php
$page_title='查看/更新成绩单';
include("includes/header.html");
if( empty($_COOKIE['id']) || 't'!=$_COOKIE['type']){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
$t_id=$_COOKIE['id'];
$id=$t_id;
require_once("../mysqli_connect.php");

if(isset($_POST['submit'])){
	echo '<h1>修改成绩...</h1>';
	if(isset($_POST['grade_m_info']) && isset($_POST['grade'])){	
		$sinfo=$_POST['grade_m_info'];
		$newGrade=$_POST['grade'];
		$num=count($newGrade);
		for($i=0;$i<$num;$i++){
			$change_row=explode(',',$sinfo[$i]);
			$grade=$newGrade[$i];
			$sid=$change_row[0];
			$cid=$change_row[1];
			$sms=$change_row[2];
			$year=$change_row[3];
			$tid=$change_row[4];
			$q="UPDATE enrol SET grade=$grade WHERE
			s_id=$sid AND c_id=$cid AND semester=$sms AND
			year=$year AND t_id=$tid";
			$r=@mysqli_query($dbc,$q);
			if(mysqli_affected_rows($dbc)==1){
				echo '<h1>修改成功</h1>';
			}
		}
	}
}
echo '<form action="s_grade_m.php" method="POST">
<p><b>课程编号</b><select name="cid">';

$q="SELECT course.c_id AS c_id FROM teaches INNER JOIN course USING (c_id) WHERE teaches.t_id=$t_id";
$r=@mysqli_query($dbc,$q);
while($row=mysqli_fetch_array($r,MYSQLI_NUM))
{
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select>';

echo '<b>课程名称</b><select name="cname">';
$q="SELECT course.c_name AS c_name FROM teaches INNER JOIN course USING (c_id) WHERE teaches.t_id=$t_id";
$r=@mysqli_query($dbc,$q);

while($row=mysqli_fetch_array($r,MYSQLI_NUM))
{
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select></p>';
echo '<p><b>学生学号</b><select name="sid">';
$q="SELECT DISTINCT student.s_id FROM student INNER JOIN enrol USING (s_id) WHERE enrol.t_id=$t_id";
$r=@mysqli_query($dbc,$q);
while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select>';
echo '<b>学生姓名</b><select name="sname">';
$q="SELECT student.s_name FROM student INNER JOIN enrol USING (s_id) WHERE enrol.t_id=$t_id";
$r=@mysqli_query($dbc,$q);
while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select></p>';
echo '<p><input type="submit" name="cidpsid" value="课程编号+学号查询"/>
	<input type="submit" name="cidpsname" value="课程编号+姓名查询" />
	<input type="submit" name="cnamepsid" value="课程名称+学号查询" />
	<input type="submit" name="cnamepsname" value="课程名称+姓名查询" />
	<br /><input type="submit" name="all" value="查看所有" /></p></form>';
	$q="";
	if(isset($_POST['cidpsid'])){
		$cid=$_POST['cid'];
		$sid=$_POST['sid'];
		$q="SELECT course.c_id,course.c_name,enrol.year,enrol.semester,student.s_id,student.s_name,enrol.grade FROM teaches INNER JOIN enrol ON (teaches.c_id=enrol.c_id AND enrol.t_id=$id AND teaches.year=enrol.year AND
		teaches.semester=enrol.semester) INNER JOIN course ON (enrol.c_id=course.c_id AND course.c_id=$cid) INNER JOIN student ON (student.s_id=enrol.s_id AND student.s_id=$sid)"; 
	}elseif(isset($_POST['cidpsname'])){
		$cid=$_POST['cid'];
		$sname=$_POST['sname'];
		$q="SELECT course.c_id,course.c_name,enrol.year,enrol.semester,student.s_id,student.s_name,enrol.grade 
		FROM teaches INNER JOIN enrol ON (teaches.c_id=enrol.c_id AND enrol.t_id=$id AND teaches.year=enrol.year AND
		teaches.semester=enrol.semester) INNER JOIN course ON (enrol.c_id=course.c_id AND course.c_id=$cid) INNER JOIN student 
		ON (student.s_id=enrol.s_id AND student.s_name='$sname')"; 
	}elseif(isset($_POST['cnamepsid'])){
		$cname=$_POST['cname'];
		$sid=$_POST['sid'];
		$q="SELECT course.c_id,course.c_name,enrol.year,enrol.semester,student.s_id,student.s_name,enrol.grade 
		FROM teaches INNER JOIN enrol ON (teaches.c_id=enrol.c_id AND enrol.t_id=$id AND teaches.year=enrol.year AND
		teaches.semester=enrol.semester) INNER JOIN course ON (enrol.c_id=course.c_id AND course.c_name='$cname') 
		INNER JOIN student ON (student.s_id=enrol.s_id AND student.s_id=$sid)"; 
	}elseif(isset($_POST['cnamepsname'])){
		$cname=$_POST['cname'];
		$sname=$_POST['sname'];
		$q="SELECT course.c_id,course.c_name,enrol.year,enrol.semester,student.s_id,student.s_name,enrol.grade 
		FROM teaches INNER JOIN enrol ON (teaches.c_id=enrol.c_id AND enrol.t_id=$id AND teaches.year=enrol.year AND
		teaches.semester=enrol.semester) INNER JOIN course ON (enrol.c_id=course.c_id AND course.c_name='$cname') 
		INNER JOIN student ON (student.s_id=enrol.s_id AND student.s_name='$sname')"; 
	}else{
		$q="SELECT course.c_id,course.c_name,enrol.year,enrol.semester,student.s_id,student.s_name,enrol.grade FROM teaches INNER JOIN enrol ON (teaches.c_id=enrol.c_id AND enrol.t_id=$id AND teaches.year=enrol.year AND
		teaches.semester=enrol.semester) INNER JOIN course ON enrol.c_id=course.c_id INNER JOIN student ON student.s_id=enrol.s_id"; 
	}

	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r) < 1){
		echo '<h1>记录为空！</h1>';
	}else{
		echo '<form action="s_grade_m.php" method="POST">
		<table align="center" cellspacing="3" cellpadding="3" width="75%">
		<tr><td align="left"><b>课程编号</b></td>
		<td align="left"><b>课程名称</b></td>
		<td align="left"><b>选课学年</b></td>
		<td align="left"><b>选课学期</b></td>
		<td align="left"><b>学生学号</b></td>
		<td align="left"><b>学生姓名</b></td>
		<td align="left"><b>成绩</b></td></tr>';
		while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
			$cid=$row[0];$cname=$row[1];
			$ey=$row[2];$es=$row[3];
			$sid=$row[4];$sname=$row[5];$grade=$row[6];
			echo '<tr>
			<td align="left">'.$cid.'</td>
			<td align="left">'.$cname.'</td>
			<td align="left">'.$ey.'</td>
			<td align="left">'.$es.'</td>
			<td align="left">'.$sid.'</td>
			<td align="left">'.$sname.'</td>
			<td align="left"><select name="grade[]">';
			echo '<option value="NULL"';
			echo '>暂无成绩</option>';
			for($i=0;$i<=100;$i++){
				echo '<option value="'.$i.'" ';if(!empty($grade) && $i==$grade) {echo 'selected="selected"';} 
				echo '>'.$i.'</option>';
			}
			echo '</select></td></tr>
			<input type="hidden" name="grade_m_info[]" value="'.$sid.','.$cid.','.$es.','
			.$ey.','.$id.'" />';
		}
		echo '<tr><td align="center"><input type="submit" name="submit" value="修改分数" /></td></tr></table>
		</form>';
	}
	
include("includes/footer.html");
?>
