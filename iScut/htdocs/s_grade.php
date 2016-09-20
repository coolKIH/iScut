<?php

$page_title="成绩查询";
ini_set("display_errors",1);

include("includes/header.html");
if( empty($_COOKIE['id']) || 's'!=$_COOKIE['type'] )
{
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
?>

<form action='s_grade.php' method="POST">
<p><b>学年</b>
<select name="year">
<?php
for($y=2008,$y1=$y+1;$y<=2015;$y++,$y1++)
	echo "<option value=\"$y\">$y"."~"."$y1</option>";
echo '</select>';
echo '学期
<select name="semester">
<option value="1">第一学期</option>
<option valuie="2">第二学期</option>
</select>
<br />
<input type="submit" name="some" value="查询"/>
<input type="submit" name="all" value="查询所有" /><br />
';
require_once("../mysqli_connect.php");
$id=$_COOKIE['id'];
$q="SELECT DISTINCT c_id FROM course";
$r=@mysqli_query($dbc,$q);
echo '
<b>课程编号</b><select name="c_id" >';
while($row=mysqli_fetch_array($r,MYSQLI_NUM))
	{
	echo '<option value="'.$row[0].'"/>'.$row[0].'</option>';
	}
	echo '</select>';
	echo '<input type="submit" name="search_c_id" value="查询课程编号"/><br />
<b>课程名称</b><select name="c_name">';
$q="SELECT DISTINCT c_name FROM course";
$r=@mysqli_query($dbc,$q);
while($row=mysqli_fetch_array($r))
{
	echo '<option value="'.$row[0].'">'.$row[0].'</option>';
}
echo '</select>
<input type="submit" name="search_c_name" value="查询课程名称"/></p></form>';

if(isset($_POST['all'])) {
	$q="SELECT * FROM enrol INNER JOIN course USING (c_id)
		where enrol.s_id=$id";
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r) > 0){
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
		<tr>
		<td align="left"><b>课程编号</b></td>
		<td align="left"><b>课程名称</b></td>
		<td align="left"><b>分数</b></td>
		</tr>';
		while($row=mysqli_fetch_array($r,MYSQLI_ASSOC))
		{
		echo'<tr>
			<td align="left">'.$row['c_id'].'</td>
			<td align="left">'.$row['c_name'].'</td>
			<td align="left">'.$row['grade'].'</td>
			</tr>';
		}
		echo '</table>';
		mysqli_free_result($r);
	}else
		echo 'No record';
}
elseif(isset($_POST['some'])) {
	$y=$_POST['year'];$s=$_POST['semester'];
	$q="SELECT * from enrol INNER JOIN course USING (c_id)
		WHERE enrol.s_id=$id AND enrol.year=$y AND enrol.semester=$s";
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r) > 0)
	{
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
		<tr>
		<td align="left"><b>课程编号</b></td>
		<td align="left"><b>课程名称</b></td>
		<td align="left"><b>成绩</b></td>
		</tr>';
	while($row=mysqli_fetch_array($r,MYSQLI_ASSOC))
		{
		echo '
		<tr>
		<td align="left">'.$row['c_id'].'</td>
		<td align="left">'.$row['c_name'].'</td>
		<td align="left">'.$row['grade'].'</td></tr>';
		}
		echo '</table>';
	}
	else
		echo 'No record';
}
elseif(isset($_POST['search_c_id'])){
	$i=$_POST['c_id'];
	$q="SELECT * FROM enrol INNER JOIN course USING (c_id)
		WHERE enrol.s_id='$id' AND enrol.c_id='$i' ";
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r) > 0 )
	{
		echo '
	  <table align="center" cellspacing="3" cellpadding="3" width="75%" >
			<tr>
			<td align="left"><b>课程编号</b></td>
			<td align="left"><b>课程名称</b></td>
			<td align="left"><b>成绩</b></td>
			</tr> ';
		while($row=mysqli_fetch_array($r,MYSQLI_ASSOC))
		{
			echo '
				<tr>
				<td align="left">'.$row['c_id'].'</td>
				<td align="left">'.$row['c_name'].'</td>
				<td align="left">'.$row['grade'].'</td></tr>';
		}
		echo '</table>';
	}
	else
		echo 'No record';
}

elseif(isset($_POST['search_c_name'])){
	$n=$_POST['c_name'];
	$q="SELECT * FROM enrol INNER JOIN course USING (c_id) 
		WHERE enrol.s_id='$id' AND course.c_name='$n'";
    $r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r) > 0)
	{
	echo '
	<table align="center" cellspacing="3" cellpadding="3" width="75%" >
	<tr>																		<td align="left"><b>课程编号</b></td>
	<td align="left"><b>课程名称</b></td>
	<td align="left"><b>成绩</b></td>
	</tr> ';
	while($row=mysqli_fetch_array($r,MYSQLI_ASSOC))
	{
	echo '
	<tr>
	<td align="left">'.$row['c_id'].'</td>
	<td align="left">'.$row['c_name'].'</td>
	<td align="left">'.$row['grade'].'</td></tr>';
	}
	echo '</table>';
	}
	else
		echo 'No record';
}

include("includes/footer.html");
?>
