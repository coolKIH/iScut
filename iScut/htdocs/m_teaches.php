<?php
$page_title="查看授课信息";
include ("includes/header.html");

if($_COOKIE['type'] != 'm'){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
require_once("../mysqli_connect.php");
$q="SELECT COUNT(*) FROM teaches";
$r=@mysqli_query($dbc,$q);
$row=mysqli_fetch_array($r,MYSQLI_NUM);
if($row[0]==0){
	echo '<h2>目前授课记录为空！</h2>';
}else{
	echo '<form action="m_teaches.php" method="POST">
	<p><b>教师编号</b><input type="text" name="tid" maxlength="5" size="10"/>
	<input type="submit" name="search_t_id" value="查询"/></p>
	<p><b>课程编号</b><input type="text" name="cid" manxlength="7" size="10"/>
	<input type="submit" name="search_c_id" value="查询" /></p>
	<p><input type=submit" name="all" value="查看全部" /></p></form>';
	$q="";
	if(isset($_POST['search_t_id'])){
		$tid=$_POST['tid'];
		$q="SELECT * FROM teaches WHERE t_id=$tid";
	}elseif(isset($_POST['search_c_id'])){
		$cid=$_POST['cid'];
		$q="SELECT * FROM teaches WHERE c_id=$cid";
	}else{
		$q="SELECT * FROM teaches";
	}
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)==0){
		echo '<h2>查无记录！</h2>';
	}else{
		echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
		<tr><td align="left"><b>编辑</b></td>
		<td align="left"><b>删除</b></td>
		<td align="left"><b>教师编号</b></td>
		<td align="left"><b>课程编号</b></td>
		<td align="left"><b>学期</b></td>
		<td align="left"><b>学年</b></td></tr>';
		while($row=mysqli_fetch_array($r)){
			echo '<tr><td align="left"><a href="edit_teaches.php?id='.$row['teaches_id'].'">编辑</a></td>
			<td align="left"><a href="delete_teaches.php?id='.$row['teaches_id'].'">删除</a></td>
			<td align="left">'.$row['t_id'].'</td><td align="left">'.$row['c_id'].'</td>
			<td align="left">'.$row['semester'].'</td><td align="left">'.$row['year'].'</td></tr>';
		}
		echo '</table>';
	}
}
		echo '<p><a href="new_teaches.php">新增授课信息</a></p>';
		
include("includes/footer.html")
?>		