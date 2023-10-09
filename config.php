<?php
$host_name = "localhost";
$server_user_name = "root";
$server_password = "";
$db = "idms";

$con = mysqli_connect($host_name, $server_user_name, $server_password, $db);

if (!$con) 
{
    die("server is not connected" . mysqli_error($con));
}
?>