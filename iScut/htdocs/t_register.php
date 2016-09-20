<?php
$page_title='New instructor Regestration';
include ('includes/header.html');
if($_COOKIE['type'] != 'm'){
	require_once("includes/login_functions.inc.php");
	$url=absolute_url();
	header("Location:$url");
	exit();
}
if(isset($_POST['submitted']))
{
	if( !empty($_POST['id']) && !empty($_POST['name'])
			&& !empty($_POST['pass1']) && !empty($_POST['pass2'])
				&& !empty($_POST['department']) )
	{
	$i=trim($_POST['id']);$n=trim($_POST['name']);
	$p1=trim($_POST['pass1']);$p2=trim($_POST['pass2']);
	$d=trim($_POST['department']);
	if($p1==$p2)
	{
	require_once("../mysqli_connect.php");
	mysqli_query($dbc,"set names utf8");
	$q="INSERT INTO teacher VALUES ('$i','$n',SHA1('$p1'),'$d')";
	$r=@mysqli_query($dbc,$q);
	if($r){
	echo '<h1>Thank you!</h1>
	<p>You are registered.<br /> </p>';
	}
	else echo '<h1>System error.</h1>
		<p class="error">ID already exits.</p>';

	mysqli_close($dbc);
	include("includes/footer.html");
	exit();
	}else
	{
		echo '<h1>Error!</h1>
			<p class="error">Passwords do not match.</p>
			<p>Please try again.</p>';
	}
	}
	else{
		echo '<h1>Error!</h1>
			<p class="error">Please fill in all the blanks!</p>';
	}
}

?>

<h1>Register</h1>
<form action="t_register.php" method="POST">
<p>ID:<input type="text" name="id" size="15" maxlength="5" value="
<?php if(isset($_POST['id'])) echo $_POST['id'];?>"/></p>
<p>Name:<input type="text" name="name" size="15" maxlength="5" value="
<?php if(isset($_POST['name'])) echo $_POST['name'];?>"/></p>
<p>Password:<input type="password" name="pass1" size="15" maxlength="20"/></p>
<p>Confirm Password:<input type="password" name="pass2" size="15" maxlength="20"/></p>
<p>Department:<input type="text" name="department" size="15" maxlength="15"
value=" <?php if(isset($_POST['department'])) echo $_POST['department'];?>
"/></p>
<p><input type="submit" name="submit" value="Register" /></p>
<input type="hidden" name="submitted" value="TRUE" />

<?php
include('includes/footer.html');
?>
