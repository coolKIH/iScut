<?php
$page_title="查看/编辑/新增选课信息";
include ("includes/header.html");

if($_COOKIE['type'] != 'm'){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
require_once("../mysqli_connect.php");
	$q="SELECT COUNT(*) FROM enrol";
	$r=@mysqli_query($dbc,$q);
	$row = mysqli_fetch_array($r,MYSQLI_NUM);
	if( $row[0] == 0 ){
		echo '<h2>尚无选课记录！</h2>';
	}
	else
	{
		echo '<form action="m_enrol.php" method="post">
		<p><b>按学生学号</b><select name="sid">';
		$q="SELECT DISTINCT s_id FROM enrol";
		$r=@mysqli_query($dbc,$q);
		while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
			echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		}
		echo '</select><input type="submit" name="search_s_id" value="查询"/></p>
		<p><b>按课程编号</b><select name="cid">';
		$q="SELECT DISTINCT c_id FROM teaches";
		$r=@mysqli_query($dbc,$q);
		while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
			echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		}
		echo '</select><input type="submit" name="search_c_id" value="查询"/></p>
		<p><b>按教师编号</b><select name="tid">';
		$q="SELECT DISTINCT t_id FROM teacher";
		$r=@mysqli_query($dbc,$q);
		while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
			echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		}
		echo '</select><input type="submit" name="search_t_id" value="查询" /></p>
		<p><b>按教师姓名</b><select name="tname">';
		$q="SELECT DISTINCT t_name FROM teacher";
		$r=@mysqli_query($dbc,$q);
		while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
			echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		}
		echo '</select><input type="submit" name="search_t_name" value="查询" /></p>
		<p><b>按班级</b><select name="class">';
		$q="SELECT DISTINCT s_class FROM student";
		$r=@mysqli_query($dbc,$q);
		while($row=mysqli_fetch_array($r,MYSQLI_NUM)){
			echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		}
		echo '</select><input type="submit" name="search_s_class" value="查询" /></p>
		<p><input type="submit" name="search_all" value="显示所有"/></form>';
		
		$q="";
		if(isset($_POST['search_s_id'])){
			$si=$_POST['sid'];
			$q="SELECT * FROM enrol WHERE s_id=$si";
		}
		elseif(isset($_POST['search_c_id'])){
			$ci=$_POST['cid'];
			$q="SELECT * FROM enrol WHERE c_id=$ci";
		}
		elseif(isset($_POST['search_t_id'])){
			$ti=$_POST['tid'];
			$q="SELECT * FROM enrol WHERE t_id=$ti";
		}elseif(isset($_POST['search_t_name'])){
			$tn=$_POST['tname'];
			$q="SELECT enrol.* FROM enrol INNER JOIN teacher USING (t_id) WHERE teacher.t_name='$tn'";
		}
		elseif(isset($_POST['search_s_class'])){
			$sc=$_POST['class'];
			$q="SELECT enrol.* FROM enrol INNER JOIN student ON enrol.s_id=student.s_id AND student.s_class='$sc'";
		}else{
			$q="SELECT * FROM enrol";
	    }
			$r=@mysqli_query($dbc,$q);
			$num=mysqli_num_rows($r);
			if($num == 0){
				echo '<h2>无选课记录！</h2>';
			}
			else{
				echo '<h1>经查询，共有'.$num.'条选课记录</h1><table width="75%" align="center" cellspacing="3" cellpadding="3">
				<tr><td align="left">编辑</td><td align="left">删除</td>
				<td align="left">学生学号</td>
				<td align="left">课程编号</td>
				<td align="left">学期</td><td align="left">学年</td>
				<td align="left">成绩</td><td align="left">教师编号</td></tr>';
				while($row=mysqli_fetch_array($r,MYSQLI_ASSOC)){
					echo '<tr><td align="left"><a href="edit_enrol.php?id='.$row['enrol_id'].'">编辑</a></td><td align="left">
					<a href="delete_enrol.php?id='.$row['enrol_id'].'">删除</a></td>
					<td align="left">'.$row['s_id'].'</td><td align="left">'.$row['c_id'].'</td>
					<td align="left">'.$row['semester'].'</td><td align="left">'.$row['year'].'</td>
					<td align="left">'.$row['grade'].'</td><td align="left">'.$row['t_id'].'</td></tr>';
				}
				echo '</table>';
		}
	}
	echo '<p><a href="new_enrol.php"><h2>新增选课信息</h2></a></p>';
	
	include("includes/footer.html");
	?>