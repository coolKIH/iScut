<?php
include ("includes/header.html");
require_once('../mysqli_connect.php');
require_once('includes/login_functions.inc.php');?>
<script type="text/javascript"> 
function check_all(obj,cName) 
{ 
	    var checkboxs = document.getElementsByName(cName); 
		    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 
</script> 
<?php
if(empty($_COOKIE['id']))
{
	$url=absolute_url();
	header("Location:$url");
	exit();
}
$id=$_COOKIE['id'];
if($_GET['action'] == 'selected')
{
	$q="SELECT * FROM course INNER JOIN enrol USING (c_id)
		WHERE enrol.s_id='$id' ORDER BY enrol.year,enrol.semester";
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)>0)
	{
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
		<tr>
		<td align="left"><b>课程编号</b></td>
		<td align="left"><b>课程名称</b></td>
		<td align="left"><b>课程学分</b></td>
		<td align="left"><b>选课学年</b></td>
		<td align="left"><b>选课学期</b></td>
		<td align="left"><b>成绩</b></td>
		</tr>';
	while($row=mysqli_fetch_array($r,MYSQLI_ASSOC))
	{
		$i=$row['c_id'];
		$n=$row['c_name'];
		$c=$row['credit'];
		$y=$row['year'];
		$y1=$y+1;
		$s=$row['semester'];
		$g=$row['grade'];
	echo '<tr>
		<td align="left">'.$i.'</td>
		<td align="left">'.$n.'</td>
		<td align="left">'.$c.'</td>
		<td align="left">'.$y.'~'.$y1.'</td>
		<td align="left">'.$s.'</td>
		<td align="left">';
	if(!empty($g)) echo $g;
	else echo '暂无成绩';
	echo '</td>';
	}
	echo '</table>';

	}else echo '已选课程为空！';
}
elseif($_GET['action']=='toselect')
{
	$q="SELECT MONTH(NOW()),YEAR(NOW()) LIMIT 1";
	$r=@mysqli_query($dbc,$q);
	$row=mysqli_fetch_array($r,MYSQLI_NUM);
	$m=$row[0];$y=$row[1];
	$q="SELECT enter_year FROM student WHERE s_id='$id' LIMIT 1";
	$r=@mysqli_query($dbc,$q);
	$row=mysqli_fetch_array($r,MYSQLI_NUM);
	$ey=$row[0];
	if($m < 8){
		$level=$y-$ey;
		$s=2;
	}
	else {
		$level=$y-$ey+1;
		$s=1;
	}//注意改动，去掉已选部分
	$q="SELECT course.c_id AS c_id, course.c_name AS c_name,course.credit AS credit, teacher.t_name AS t_name,teacher.t_id AS t_id FROM course INNER JOIN teaches INNER JOIN teacher WHERE (ISNULL(course.off_year) OR
'$y'<course.off_year) AND course.least_grade<='$level'
AND course.c_id NOT IN (select c_id FROM enrol WHERE s_id='$id') ";//取消年份，已选，或者超年级皆不可
	$r=@mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)>0){
		echo '<form action="s_course.php" method="POST">
			<table align="center" cellspacing="3" cellpadding="3" 
			width="75%">
			<tr>
			<td align="left">'; ?>
			<input type="checkbox" name="all"
			onclick="check_all(this,'checkbox[]')" />
			课程编号</td>
			<td align="left">课程名称</td>
			<td align="left">课程学分</td>
			<td align="left">授课老师</td>
			</tr>
		<?php
		while($row=mysqli_fetch_array($r,MYSQLI_ASSOC)){
			$i=$row['c_id'];
			$n=$row['c_name'];
			$c=$row['credit'];
			$tn=$row['t_name'];
			$ti=$row['t_id'];
			
		echo '<tr>
			<td align="left">
			<input type="checkbox" name="checkbox[]" value="'.$id.','
			.$i.','.$s.','.$y.','.$ti.'"/>'.$i.'</td>
			<td align="left">'.$n.'</td>
			<td align="left">'.$c.'</td>
			<td align="left">'.$tn.'</td>
			</tr>';
			
		}
		echo '<tr>
			<td></td><td></td><td align="center">
			<input type="submit" name="submit" value="确认选课" />
			</td><td></td><td></td></tr>';
	echo '</table></form>';	
	}else echo 'No record.';


}
elseif(isset($_POST['checkbox']))
{//只是能同时选择同一门课
	$checkboxes=$_POST['checkbox'];
	$c=count($checkboxes);
	for($i=0;$i<$c;$i++)
	{
		$enrol_row=explode(',',$checkboxes[$i]);
		$s_id=$enrol_row[0];
		$c_id=$enrol_row[1];
		$semester=$enrol_row[2];
		$year=$enrol_row[3];
		$t_id=$enrol_row[4];
		$q="INSERT INTO enrol VALUES('$s_id','$c_id','$semester','$year'
			,NULL,'$t_id')";
		$r=@mysqli_query($dbc,$q);
	}
	echo '选课成功！';
	echo '<p><b><a href="s_course.php?action=toselect">继续选课</a></b>
		<b><a href="s_course.php?action=selected">查看已选</a></b></p>';
}
include ('includes/footer.html');
?>
