<?php
$page_title="Login";
include ('includes/header.html');


if(!(empty($errors)))
{
	echo '<h1>Error!</h1>
		<p class="error">Please check your ID and password and try again.</p>';
}
?>
<h1>Login</h1>
<form action="login.php?type=<?php echo $_GET['type'];?>" method="post">
<p>ID: <input type="text" name="id" size="15" maxlength="10" /></p>
<p>Password:<input type="password" name="pass" size="15" maxlength="20"/></p>
<p><input type="submit" name="submit" value="Login"/></p>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="type" value="<?php echo $_GET['type'];?>" />
</form>

<?php
include ('includes/footer.html');
?>
