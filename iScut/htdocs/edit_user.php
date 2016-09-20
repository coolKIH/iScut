<?php

$page_title='Edit a User';

include ('includes/header.html');

echo '<h1>Edit a User</h1>';
if((isset($_GET['id'])) && (is_numeric($_GET['id'])) ){
$id=$_GET['id'];
}
elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ){
	$id=$_POST['id'];
}else{
	echo '<p class="error">This page has been accessed in error.</p>';
	include("includes/footer.html");
	exit();
}


require_once('../mysqli_connect.php');
//mysqli_query($dbc,"set names utf8");
if(isset($_POST['submitted']))
{
$errors=array();

if(!(empty($_POST['name']) |empty($_POST['gender']) | empty($_POST['en_year']) |empty($_POST['class']) | empty($_POST['en_age']) | empty($_POST['department'])  ))
{
	$n=trim($_POST['name']);$g=$_POST['gender'];$ey=$_POST['en_year'];
	$c=trim($_POST['class']);$ea=$_POST['en_age'];$d=trim($_POST['department']);
	$q="update student set s_name='$n',gender='$g',enter_year='$ey',
		s_class='$c',enter_age='$ea',dep_name='$d' where s_id=$id LIMIT 1";
	$r=@mysqli_query($dbc,$q);
	if(mysqli_affected_rows($dbc)==1) echo '<p>The user has been edited.</p>';
	else echo 'Nothing\'s changed!';
}
else echo '<p class="error">Please fill in all the blanks.</p>';
	
}

$q="select s_name,gender,enter_year,s_class,enter_age,dep_name from student  where s_id=$id";
$r=mysqli_query($dbc,$q);
if(mysqli_num_rows($r)==1)
{
	$row=mysqli_fetch_array($r,MYSQLI_ASSOC);

	echo '<form action="edit_user.php" method="post">
		<p>姓名:<input type="text" name="name"  size="15" maxlength="30"
		value=" '.$row['s_name'].'"/></p>
	    <p>性别:<input type="radio" name="gender" value="男"';
	if($row['gender']=='男') echo 'checked ="checked"';
	echo '/>男

		<input type="radio" name="gender" value="女"';
	if($row['gender']=='女') echo 'checked="checked"';
	echo '/>女</p>
		<p>入校年份:<select name="en_year" 
		value="'.$row['enter_year'].'">';
	for($y=2010;$y<=2015;$y++)
		echo "<option value=\"$y\">$y</option>\n";

	echo '</select></p>';

	echo '<p>班级:<input type="text" name="class" size="15" 
		maxlength="15" value="'.$row['s_class'].'"> </p>';
	echo '<p>入校年龄: <select name="en_age" value="'.$row['enter_age'].'">';
	for($a=15; $a <= 50; $a++)
		echo "<option value=\"$a\">$a </option>\n";
	echo '</select></p>';
	echo '<p>学院: <input type="text" name="department" size="15"	maxlength="15" value="'.$row['dep_name'].'"></p>';
	echo '<p><input type="submit" name="Submit" value="Edit"></p>
		<input type="hidden" name="submitted" value="TRUE" />
		<input type="hidden" name="id" value="'.$id.'" />
		 </form>';
}else{
	echo '<p class="error">Sorry.This page is accessed in error.</p>';
}
mysqli_close($dbc);
include ('includes/footer.html');
?>
