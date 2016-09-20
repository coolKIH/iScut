<?php

$page_title='修改密码';
include ('includes/header.html');

if(isset($_POST['submitted']))
{
	$type=$_POST['type'];
	require_once('../mysqli_connect.php');
	$errors=array();

	if(empty($_POST['id'])){
	$errors[]='You forgot to enter your ID.';
	}else {
	$i=trim($_POST['id']);
	}
	if(empty($_POST['cp']))
	$errors[]='You forgot to enter your current password.';
	else $cp=trim($_POST['cp']);
	if(!empty($_POST['np']))
	{
	if($_POST['np']!=$_POST['cnp'])
	$errors[]='Your new password did not match the confirmed one.';
	else
	$np=trim($_POST['np']);
	} else echo 'You forgot to enter your new password.';

	
	if(empty($errors))
  {
	 if($type=='s'){
		 $q="SELECT s_id FROM student WHERE (s_id='$i' AND pass=SHA1('$cp'))";
		 $q2="UPDATE student SET pass=SHA1('$np') WHERE s_id=$i";
	 }elseif($type=='t'){
		 $q="SELECT t_id FROM teacher WHERE (t_id='$i' AND pass=SHA1('$cp'))";
		 $q2="UPDATE teacher SET pass=SHA1('$np') WHERE t_id=$i";
	 }elseif($tpe=='m'){
		 $q="SELECT m_id FROM manager WHERE (m_id='$i' AND pass=SHA1('$cp'))";
		 $q2="UPDATE manager SET pass=SHA1('$np') WHERE m_id=$i";
	 }
	
	$r=@mysqli_query($dbc,$q);
	$num=@mysqli_num_rows($r);

	if($num==1)
     {
//	$row=mysqli_fetch_array($r,MYSQLI_NUM);
	
//	$q="UPDATE student SET pass=SHA1('$np') WHERE s_id=$row[0]";
	$r=mysqli_query($dbc,$q2);

	if(mysqli_affected_rows($dbc)==1){
	echo '<h1>Thank you!</h1>
	<p>Your password has been updated.</p><p><br /></p>';}
	else echo '<h1>System error: Fail to update</h1>';

	include ('includes/footer.html');
	exit();
     }else
    {
	echo '<h1>Please check if your student ID is valid which your password should match.</h>'; 
    }
 }else {
    echo '<h1>Error!</h1>';
	echo '<p class="error">The following error(s) occurred:<br />';
	foreach($errors as $msg)
	echo " - $msg<br />\n"; 

	echo '</p><p>Please try again.</p>'; 
       } 
	mysqli_close($dbc);
}
?>


<h1>修改密码</h1>
<form action="password.php" method="post">
<p><b>账号:</b>
<input type="text" name="id" size="15" maxlength="10" /></p>
<p><b>当前密码:</b><input type="password" name="cp" size="15" maxlength="20" /></p>
<p><b>新密码:</b><input type="password" name="np" size="15" maxlength="20" /></p>
<p><b>确认密码:</b><input type="password" name="cnp" size="15" maxlength="20" /></p>
<p><input type="submit" name="submit" value="Change Password" /></p>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="type" value="<?php echo $_GET['type']; ?>" /> 

</form>						
<?php
include ('includes/footer.html');
?>
