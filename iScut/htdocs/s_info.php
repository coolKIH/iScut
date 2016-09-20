<?php
include ("includes/header.html");
require_once("includes/login_functions.inc.php");
require_once("../mysqli_connect.php");
if(empty($_COOKIE['id']))
{
	$url=absolute_url();
	header("Location:$url");
	exit();
}
$id=$_COOKIE['id'];
$q="SELECT * FROM student where s_id='$id'";
$r=@mysqli_query($dbc,$q);
if(mysqli_num_rows($r)==1)
{
	$row=mysqli_fetch_array($r,MYSQLI_ASSOC);

$i=$row['s_id'];
$n=$row['s_name'];
$g=$row['gender'];
$ey=$row['enter_year'];
$c=$row['s_class'];
$ea=$row['enter_age'];
$d=$row['dep_name'];
echo '<table align="center" width="50%">
	<tr><td align="left" width="100">学号</td>
	<td align="left" width="400">'.$i.'</td>
	<tr>
	<td align="left" width="100">姓名</td>
	<td align="left" width="400">'.$n.'</td></tr>
	<tr><td align="left" width="100">性别</td>
	<td align="left" width="400">'.$g.'</td></tr>
	<tr><td align="left" width="100">学院</td>
	<td align="left" width="400">'.$d.'</td></tr>
	<tr><td align="left" width="100">班级</td>
	<td align="left" width="400">'.$c.'</td></tr>

	<tr><td align="left" width="100">入学年份</td>
	<td align="left" width="400">'.$ey.'</td></tr>
	<tr><td align="left" width="100">入学年龄</td>
	<td align="width" width="400">'.$ea.'</td>
	</tr>
	</table>';
}else echo 'Error!';
include("includes/footer.html");
?>
