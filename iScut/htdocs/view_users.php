<?php

$page_title='查看注册学生';
include ('includes/header.html');

if($_COOKIE['type'] != 'm'){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}

echo '<h1>已注册学生</h1>';

require_once('../mysqli_connect.php');

echo '<form action="view_users.php" method="POST">
<p>按学号：<input type="text" name="sid" maxlength="10" size="12" /><input type="submit" name="search_s_id" value="查询"/></p>
<p>按姓名：<input type="text" name="sname" maxlength="8" size="12" /><input type="submit" name="search_s_name" value="查询"/></p>
<p><input type="submit" name="all" value="查看全部" /></form>';
$q="";
if(isset($_POST['search_s_id'])){
	$sid=$_POST['sid'];
	$q="SELECT * FROM student WHERE s_id=$sid";
}elseif(isset($_POST['search_s_name'])){
	$sname=$_POST['sid'];
	$q="SELECT * FROM student WHERE s_name='$sname'";
}else{
$q="SELECT * FROM student ORDER BY s_id ASC";
}
$r=@mysqli_query($dbc,$q);

$num=mysqli_num_rows($r);

if($num>0){
echo "<p>找到 $num 个结果</p>\n";
echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
<tr><td align="left"><b>编辑</b></td><td align="left"><b>删除</b></td><td align="left"><b>学生学号</b></td>
<td align="left"><b>学生姓名</b></td><td align="left"><b>班级</b></td><td align="left"><b>学院</b></td>
<td align="left"><b>入学年份</b></td><td><b>性别</b></td></tr>';

while($row=mysqli_fetch_array($r,MYSQLI_ASSOC)){
echo '<tr>
<tr><td align="left"><a href="edit_user.php?id='.$row['s_id'].' ">Edit</a>
</td>
<td align="left"><a href="delete_user.php?id='.$row['s_id'].' ">Delete</a></td>
<td align="left">'.$row['s_id'].'</td><td align="left">'.
$row['s_name'].'</td><td align="left">'.$row['s_class'].'</td>
<td align="left">'.$row['dep_name'],'</td>
<td align="left">'.$row['enter_year'].'</td>
<td align="left">'.$row['gender'].'</td></tr>';
}
echo '</table>';
mysqli_free_result($r);
} else{ 
echo '<p class="error">查无记录！</p>';
}
echo '<p><a href="s_register.php">新增注册学生</a></p>';
mysqli_close($dbc);
					

include ('includes/footer.html');
?>
