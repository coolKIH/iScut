<?php
$page_title='删除学生账号';
include ('includes/header.html');

echo '<h1>删除学生账号</h1>';
if((isset($_GET['id'])) && (is_numeric($_GET['id'])) ){
$id=$_GET['id'];
}elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ){
	$id=$_POST['id'];
}else{
	echo '<p class="error">This page has been accessed in error.</p>';
	include("includes/footer.html");
	exit();
}

require_once('../mysqli_connect.php');
if(isset($_POST['submitted']))
{
	if($_POST['sure'] == 'yes')
	{
		$q="DELETE FROM student where s_id=$id LIMIT 1";
		$r=@mysqli_query($dbc,$q);
		$q="DELETE FROM enrol where s_id=$id";
		$r=@mysqli_query($dbc,$q);
		if(mysqli_affected_rows($dbc)!=0)
			echo '<p>The user has been deleted.</p>';
		else
			echo '<p class="error">Cannot delete.'.$id.'</p>';
	}
	else echo '<p>The user has not been deleted.</p>';
}
else
{
require_once('../mysqli_connect.php');
mysqli_query($dbc,"set names utf8");

$q="select s_name from student where s_id=$id";
$r=@mysqli_query($dbc,$q);
if(mysqli_num_rows($r)==1)
{
	$row=mysqli_fetch_array($r,MYSQLI_NUM);
echo '<form action="delete_user.php" method="post">
	<h3>Name:'.$row[0].'</h3>
	<p>Are you sure you want to delete the user?<br />
	<input type="radio" name="sure" value="yes" />Yes
	<input type="radio" name="sure" value="No" checked="checked" />No</p>
	<p><input type="submit" name="Submit" value="Submit"/></p>
	<input type="hidden" name="id" value="'.$id.'"/>
	<input type="hidden" name="submitted" value="TRUE"/>
	</form>';
}
else {
	echo '<p class="error">This page has been accessed in error!</p>';
}
}
mysqli_close($dbc);
include ('includes/footer.html');
?>
