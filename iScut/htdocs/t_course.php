<?php
$page_title="查看教授课程";
include("includes/header.html");
if( empty($_COOKIE['id']) || 't'!=$_COOKIE['type'] )
{
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
?>
<form action="t_course.php" method="POST">
<p><b>课程编号</b><select name="cid">
<?php
require_once("../mysqli_connect.php");
$t_id=$_COOKIE['id'];
$q="SELECT course.c_id AS c_id FROM teaches INNER JOIN course USING (c_id) WHERE teaches.t_id=$t_id";
$r=@mysqli_query($dbc,$q);
while($row=mysqli_fetch_array($r,MYSQLI_NUM))
{
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select>';
echo '<input type="submit" name="search_c_id" value="查询课程编号" /></p>';
echo '<p><b>课程名称</b><select name="cname">';
$q="SELECT course.c_name AS c_name FROM teaches INNER JOIN course USING (c_id) WHERE teaches.t_id=$t_id";
$r=@mysqli_query($dbc,$q);

while($row=mysqli_fetch_array($r,MYSQLI_NUM))
{
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select>';
echo '<input type="submit" name="search_c_name" value="查询课程名称" /></p>';
echo '<p><input type="submit" name="all" value="查看所有课程" /></p>';

if(isset($_POST['search_c_id'])){
	$i=$_POST['cid'];
		$q="SELECT a.i,a.n,a.y,a.s, COUNT(enrol.s_id),AVG(enrol.grade) FROM (SELECT course.c_id AS i,course.c_name AS n,teaches.year AS y,teaches.semester AS s FROM teaches 
		INNER JOIN course USING (c_id) WHERE teaches.t_id=$t_id AND teaches.c_id=$i) AS a LEFT JOIN enrol ON (a.i=enrol.c_id AND enrol.t_id=$t_id AND a.s=enrol.semester AND a.y=enrol.year) 
		GROUP BY a.i,a.y,a.s";
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)!=0){ 
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
		<tr><td align="left"><b>课程编号</b></td>
		<td align="left"><b>课程名称</b></td>
		<td align="left"><b>学年</b></td>
		<td align="left"><b>学期</b></td>
		<td align="left"><b>选课人数</b></td>
		<td align="left"><b>平均分</b></td>
		</tr>';
	while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
		echo '<tr><td align="left">'.$row[0].'</td><td align="left">'.$row[1].'</td><td align="left">'.$row[2].'</td><td align="left">
		'.$row[3].'</td><td align="left">'.$row[4].'</td><td align="left">'.$row[5].'</td></tr>';	
	}
}
	echo '</table>';
}elseif(isset($_POST['search_c_name'])){
	$n=$_POST['cname'];
		$q="SELECT a.i,a.n,a.y,a.s, COUNT(enrol.s_id),AVG(enrol.grade) FROM (SELECT course.c_id AS i,course.c_name AS n,teaches.year AS y,teaches.semester AS s FROM teaches 
		INNER JOIN course USING (c_id) WHERE teaches.t_id=$t_id AND course.c_name='$n') AS a LEFT JOIN enrol ON (a.n=enrol.c_name AND enrol.t_id=$t_id AND a.s=enrol.semester AND a.y=enrol.year) 
		GROUP BY a.i,a.y,a.s";
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)==0){
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
		<tr><td align="left"><b>课程编号</b></td>
		<td align="left"><b>课程名称</b></td>
		<td align="left"><b>学年</b></td>
		<td align="left"><b>学期</b></td>
		<td align="left"><b>选课人数</b></td>
		<td align="left"><b>平均分</b></td>
		</tr>';
	
	while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
		echo '<tr><td align="left">'.$row[0].'</td><td align="left">'.$row[1].'</td><td align="left">'.$row[2].'</td><td align="left">
		'.$row[3].'</td><td align="left">'.$row[4].'</td><td align="left">'.$row[5].'</td></tr>';	
	}
	echo '</table>';
}
	
}else{
	$q="SELECT a.i,a.n,a.y,a.s,COUNT(enrol.s_id),AVG(enrol.grade) FROM (SELECT course.c_id AS i,course.c_name AS n,teaches.year AS y,teaches.semester AS s FROM teaches 
		INNER JOIN course USING (c_id) WHERE teaches.t_id=$t_id) AS a LEFT JOIN enrol ON (a.i=enrol.c_id AND enrol.t_id=$t_id AND a.s=enrol.semester AND a.y=enrol.year) 
		GROUP BY a.i,a.y,a.s";
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)==0) echo 'haha';
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
		<tr><td align="left"><b>课程编号</b></td>
		<td align="left"><b>课程名称</b></td>
		<td align="left"><b>学年</b></td>
		<td align="left"><b>学期</b></td>
		<td align="left"><b>选课人数</b></td>
		<td align="left"><b>平均分</b></td>
		</tr>';
	while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
		echo '<tr><td align="left">'.$row[0].'</td><td align="left">'.$row[1].'</td><td align="left">'.$row[2].'</td><td align="left">
		'.$row[3].'</td><td align="left">'.$row[4].'</td><td align="left">'.$row[5].'</td></tr>';	
}
	echo '</table>';
}
?>


<?php
include("includes/footer.html");
?>
