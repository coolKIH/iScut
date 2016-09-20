<?php
DEFINE ('DB_USER','yourusername');
DEFINE ('DB_PASS','yourpassword');
DEFINE ('DB_HOST','localhost');
DEFINE ('DB_NAME','iScut');

$dbc = @mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) OR die ('Could not connect to MySQL:' . mysqli_connect_error() );
mysqli_query($dbc,"set names utf8");
?>
