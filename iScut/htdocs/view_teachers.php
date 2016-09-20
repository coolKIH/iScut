<?php

$page_title='查看注册教师';
include ('includes/header.html');

if($_COOKIE['type'] != 'm'){
	require_once("includes/login_funtions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}

echo '<h1>已注册教师</h1>';

require_once('../mysqli_connect.php');

echo '<form action="view_teachers.php" method="POST">
<p>按教师编号：<input type="text" name="tid" maxlength="10" size="12" /><input type="submit" name="search_t_id" value="查询"/></p>
<p>按姓名：<input type="text" name="tname" maxlength="8" size="12" /><input type="submit" name="search_t_name" value="查询"/></p>
<p><input type="submit" name="all" value="查看全部" /></form>';
$q="";
if(isset($_POST['search_t_id'])){
	$tid=$_POST['tid'];
	$q="SELECT * FROM teacher WHERE t_id=$tid";
}elseif(isset($_POST['search_s_name'])){
	$sname=$_POST['sid'];
	$q="SELECT * FROM teacher WHERE t_name='$tname'";
}else{
$q="SELECT * FROM teacher ORDER BY t_id ASC";
}
$r=@mysqli_query($dbc,$q);

$num=mysqli_num_rows($r);

if($num>0){
echo "<p>找到 $num 个结果</p>\n";
echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
<tr><td align="left"><b>编辑</b></td><td align="left"><b>删除</b></td><td align="left"><b>教师编号</b></td>
<td align="left"><b>教师姓名</b></td><td align="left"><b>学院</b></td></tr>';

while($row=mysqli_fetch_array($r,MYSQLI_ASSOC)){
echo '<tr>
<tr><td align="left"><a href="edit_teacher.php?id='.$row['t_id'].' ">编辑</a>
</td>
<td align="left"><a href="delete_teacher.php?id='.$row['t_id'].' ">删除</a></td>
<td align="left">'.$row['t_id'].'</td><td align="left">'.
$row['t_name'].'</td><td align="left">'.$row['dep_name'].'</td></tr>';
}
echo '</table>';
mysqli_free_result($r);
} else{ 
echo '<p class="error">查无记录！</p>';
}
echo '<p><a href="t_register.php">新增注册教师</a></p>';
mysqli_close($dbc);
					

include ('includes/footer.html');
?>
