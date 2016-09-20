<?php
if(!isset($_COOKIE['id']))
{
	require_once('includes/login_functions.inc.php');
	$url=absolute_url();
	header("Location:$url");
	exit();
}
$page_title='Logged in!';
include ('includes/header.html');
echo '<h1>Logged in!</h1>
<p>You are now logged in!</p>
<p><a href="logout.php">Logout</a></p>';

include ('includes/footer.html');
?>
