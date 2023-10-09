<?php
if (!isset($_SESSION)) 
{
    session_start();
}
date_default_timezone_set("Asia/Colombo");
include "config.php";
if(isset($_SESSION["login_usertype"]))
{//some one is logon
  $system_usertype=$_SESSION["login_usertype"];
  $system_username=$_SESSION["login_username"];
  $system_userid=$_SESSION["login_userid"];
}
else
{//guest
  $system_usertype="Guest";
}
$get_productid=$_GET["productid"];
$_SESSION["session_addtocart"]=$get_productid;
if($system_usertype=="Guest")
{
    echo '<script> window.location.href="index.php?pg=login.php";</script>';
}
else 
{
    echo '<script> window.location.href="index.php?pg=order_product.php&option=add";</script>';
}
?>