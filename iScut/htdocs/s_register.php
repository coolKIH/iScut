<?php

$page_title='New Student Regestration';
include ('includes/header.html');
if($_COOKIE['type'] != 'm'){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
if(isset($_POST['s_submitted']))
{
$errors = array();
$indi_ms='You forgot to enter your ';
if(empty($_POST['id'])) $errors[]=$indi_ms . 'student ID.';
else $i=trim($_POST['id']);

if(empty($_POST['name'])) $errors[]=$indi_ms .'name.';
else $n=trim($_POST['name']);

if(empty($_POST['en_year'])) $errors[]=$indi_ms . "entrance year.";
else $fy=trim($_POST['en_year']);
if(empty($_POST['class'])) $errors[]=$indi_ms . 'class.';
else $c=$_POST['class'];

if(!empty($_POST['pass1'])){
if($_POST['pass1']!=$_POST['pass2']) $errors[]='Your password did not match the confirmed one.';
else $p=trim($_POST['pass1']);
}else $errors[]=indi_ms . 'password.';

if(empty($_POST['en_age'])) $errors[]=$indi_ms . 'age when enrolled.';
else $fa=$_POST['en_age'];

if(empty($_POST['department'])) $errors[]=$indi_ms . 'department.';
else $dn=trim($_POST['department']);
$g=$_POST['gender'];
if(empty($errors))
{
require_once ('../mysqli_connect.php');
	mysqli_query($dbc,"set names utf8");
	$q="INSERT INTO student VALUES ('$i','$n','$g','$fy','$c',SHA1('$p'),'$fa','$dn')";
	$r=@mysqli_query ($dbc,$q);
	if($r){
	echo '<h1>Thank you!</h1>
		<p>You are now registered.<br /></p>';
	}else {
	echo '<h1>System error</h1>';
	echo '<p>' . mysqli_error($dbc) . '<br/><br/>Query:' .$q.'</p>';	
	}

	mysqli_close($dbc);
	include('includes/footer.html');
	exit();
	}
else{
echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg)
	echo " -$msg<br />\n";

	echo '</p><p>Please try again.</p><p><br /></p>';
}
}
?>

<h1>Register</h1>
<form action="s_register.php" method="post">
<p>Student ID:<input type="text" name="id" size="15" maxlength="10"
	value="<?php if(isset($_POST['id'])) echo $_POST['id'];?>"  /></p>
<p>Name:<input type="text" name="name" size="15" maxlength="5" 
value="<?php
 if(isset($_POST['name'])) echo $_POST['name'];?>"
/></p>

<p>Gender:<input type="radio" name="gender" value="男" checked="checked"/>男
<input type="radio" name="gender" value="女"/>女 </p>

<p>Year of entrance:<select name="en_year">
<?php	for($y=2010; $y <= 2015; $y++)
		echo "<option value=\"$y\">$y </option>\n";
?>
</select></p>
<p>Age of entrance:<select name="en_age">
<?php	for($a=15; $a <= 50; $a++)
		echo "<option value=\"$a\">$a </option>\n";
?>
</select></p>
<p>School:<input type="text" name="department" size="15" maxlength="15"
value="<?php if(isset($_POST['department'])) echo $_POST['department']; ?>" /></p>

<p>Class:<input type="text" name="class" size="15" maxlength="15"
value="<?php if(isset($_POST['class'])) echo $_POST['class']; ?>" /></p>
<p>Password: <input type="password" name="pass1" size="15" maxlength="20" /></p>
<p>Confirm Password: <input type="password" name="pass2" size="15" maxlength="20" /></p>
<p><input type="submit" name="submit" value="Register" /></p>
<p><input type="hidden" name="s_submitted" value="TRUE" />

</form>						
<?php
include ('includes/footer.html');
?>
