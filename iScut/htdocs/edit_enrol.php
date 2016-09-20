<?php
$page_title="编辑选课信息";
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
}
else{
	echo '<p class="error">本页面被错误访问!</p>';
	include("includes/footer.html");
	exit();
}
if(isset($_POST['submitted'])){
	if( !( empty($_POST['cid']) | empty($_POST['semester'])
		| empty($_POST['year']) | empty($_POST['tid']) ) ){
			$cid=$_POST['cid'];
			$s=$_POST['semester'];$y=$_POST['year'];
			$tid=$_POST['tid'];
			$q="SELECT COUNT(*) FROM teaches WHERE t_id=$tid AND
			c_id=$cid AND semester=$s AND year=$y";
			$r=@mysqli_query($dbc,$q);
			$row=mysqli_fetch_array($r,MYSQLI_NUM);
			if($row[0]==0){
				echo '<p class="error">修改不合法！</p>';
			}else{
				$q="UPDATE enrol SET c_id=$cid,semester=$s,
				year=$y,t_id=$tid WHERE enrol_id=$i";
				$r=@mysqli_query($dbc,$q);
				if(mysqli_affected_rows($dbc)==1){
					echo '<h2>修改成功</h2>';
				}else{
					echo '<h2>没有修改</h2>';
				}
			}
		}else{
			echo '<p class="error">信息不全，请重新填写！</p>';
		}
}

$q="SELECT * FROM enrol WHERE enrol_id=$i LIMIT 1";
$r=@mysqli_query($dbc,$q);
if(mysqli_num_rows($r)!=1){
	echo '<p class="error">本页面被错误访问!</p>';
	include("includes/footer.html");
	exit();
}

$row=mysqli_fetch_array($r,MYSQLI_ASSOC);
echo '<form action="edit_enrol.php" method="POST">
<p><b>学生学号：'.$row['s_id'].'</b></p>
<p><b>课程编号：</b><input type="text" name="cid" value="'.$row['c_id'].'"
maxlength="7" size="12" /></p>
<p><b>学期：</b><input type="radio" name="semester" value="1"';
if($row['semester']==1){echo 'checked="checked"';}
echo'/>1
<input type="radio" name="semester" value="2"';
if($row['semester']==2){echo 'checked="checked"';}
echo' />2</p>';
echo '<p><b>学年：</b><select name="year">';
for($i=2010;$i<2018;$i++){
	echo '<option value="'.$i.'"';
	if($row['year']==$i) {echo 'selected="selected"';}
	echo '>'.$i.'</option>';
}
echo '</select></p>
<p><b>教师编号：</b><input type="text" name="tid" value="'.$row['t_id'].'"
maxlength="5" size="12" /></p>
<p><input type="submit" name="submitted" value="确认修改"/></p>
<input type="hidden" name="id" value="'.$row['enrol_id'].'"/>';