<?php
$user ="root";
$host = "localhost";
$password = "";
$db_name = "ground_truther";
//establish connection
$db_connection = mysqli_connect($host,$user, $password, $db_name);
//define whether the connection has been established
if ($db_connection){
	return $db_connection;
} else {
    die ("Sorry, connection error!");
}
?>