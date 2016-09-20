<?php
$page_name="查看课程";
include ("includes/header.html");

if($_COOKIE['type'] != 'm'){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
require_once("../mysqli_connect.php");
echo '<form action="m_course.php" method="post">
<p><b>课程编号</b><select name="cid">';
$q="SELECT DISTINCT c_id FROM course";
$r=@mysqli_query($dbc,$q);
while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select><input type="submit" name="search_c_id" value="查询" /></p>
<p><b>课程名称</b><select name="cname">';
$q="SELECT DISTINCT c_name FROM course";
$r=@mysqli_query($dbc,$q);
while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select><input type="submit" name="search_c_name" value="查询" /></p>
<p><input type="submit" name="search_all" value="显示全部" /></p></form>';

$q="";
if(isset($_POST['search_c_id'])){
	$cid=$_POST['cid'];
	$q="SELECT * FROM course WHERE c_id='$cid'";
}elseif(isset($_POST['search_c_name'])){
	$cname=$_POST['cname'];
	$q="SELECT * FROM course WHERE c_name='$cname'";
}else{
	$q="SELECT * FROM course";
}
$r=@mysqli_query($dbc,$q);
if(!empty($q) && !(mysqli_num_rows($r)>0)){
	echo '<h2>暂无课程记录！</h2>';
}else{
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	<tr><td align="left">编辑</td><td align="left">删除
	</td><td align="left">课程编号</td><td align="left">课程名称</td>
	<td align="left">学分</td><td align="left">年级限制</td>
	<td align="left">撤销年限</td></tr>';
	while($row=mysqli_fetch_array($r,MYSQLI_ASSOC)){
		$cid=$row['c_id'];
		$cname=$row['c_name'];
		$credit=$row['credit'];
		$lg=$row['least_grade'];
		$oy=$row['off_year'];
		echo '<tr><td align="left"><a href="edit_course.php?cid='.$cid.'">编辑</a></td>
		<td align="left"><a href="delete_course.php?cid=$cid">删除</a></td>
		<td align="left">'.$cid.'</td>
		<td align="left">'.$cname.'</td>
		<td align="left">'.$credit.'</td>
		<td align="left">'.$lg.'</td>
		<td align="left">'.$oy.'</td></tr>';
	}
	echo '</table>';
	echo '<p><a href="m_course.php?addnew=true"><b>新增课程</b></a></p>';
	if(isset($_GET['addnew'])){
		echo '<form action="m_course.php" method="post">
		<p><b>课程编号</b><input type="text" name="cid"	size="12" maxlength="7" /></p>
	<p><b>课程名称</b><input type="text" name="cname" size="12" maxlength="10" /></p>
	<p><b>学分</b><input type="text" name="credit" size="12" maxlength="5" /></p>
	<p><b>年级限制</b><select name="lg">';
	for($i=1;$i<=4;$i++){
		echo '<option value="'.$i.'"';
		echo '>'.$i.'</option>';
	}
	echo '</select></p>';
	echo '<p><b>撤销年份</b><select name="oy"><option value="NULL">无</option>';
	for($i=2010;$i<=2020;$i++){
		echo '<option value="'.$i.'"';
		echo '>'.$i.'</option>';
	}
	echo '</select></p><p><input type="submit" name="submitted" value="确认添加" /></p>
	</form>';
	}
	if(isset($_POST['submitted'])){
		echo 'haha';
		if(!(empty($_POST['cid']) | empty($_POST['cname']) | empty($_POST['credit'])|
		empty($_POST['lg'])  )){
			$i=trim($_POST['cid']);
			$n=trim($_POST['cname']);
			$c=trim($_POST['credit']);
			$l=trim($_POST['lg']);
			$o=$_POST['oy'];
			
			$q="INSERT INTO course VALUES ('$i','$n','$c','$l',$o)";
			$r=@mysqli_query($dbc,$q);
			if(mysqli_affected_rows($r) == 1){
				echo '<h3>恭喜，添加新课程成功！</h3>';
			}else{
				echo '<p class="error">请重新输入，确保学生ID不重复哦！</p>';
			}
		}else{
			echo '<p class="error">请填写必要信息！</p>';
		}
	}
	
}

include("includes/footer.html");
?>