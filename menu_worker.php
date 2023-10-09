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


//message
$sqlview = "SELECT message_id,subject,from_id,message_date,read_status FROM message WHERE to_id='$system_userid' AND inbox_delete='1' AND read_status='1'";
$resultview = mysqli_query($con, $sqlview) or die("Error in sqlview " . mysqli_error($con));
$notificationmessage=mysqli_num_rows($resultview);

$totalnotification=0;

$workonprogressnotification=0;
$sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE status='Accepted'";                
$resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
while($rowview=mysqli_fetch_assoc($resultview))
{
	$sqlcheck="SELECT order_id FROM order_process WHERE order_id='$rowview[order_id]' AND status='Progress'";
	$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck".mysqli_error($con));
   if(mysqli_num_rows($resultcheck)>0)
   {
	   $sqlcheck_worker="SELECT worker_id FROM order_worker WHERE order_id='$rowview[order_id]' AND worker_id='$system_userid'";
		$resultcheck_worker=mysqli_query($con,$sqlcheck_worker) or die ("Error in sqlcheck_worker".mysqli_error($con));
	   if(mysqli_num_rows($resultcheck_worker)>0)
	   {
			$workonprogressnotification++;
	   }
   }
}
$totalnotification=$totalnotification+$workonprogressnotification;
?>
<ul class="navbar-nav">
	<li class="nav-item">
		<a class="nav-link" href="index.php">Home</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_1"
			role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Management
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown_1">
			<a class="dropdown-item" href="index.php?pg=staff.php&option=view"> Staff</a>					
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_3"
			role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Product
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
			<?php 
			$sqlloadcategory="SELECT * FROM category ORDER BY category_id";
			$resultloadcategory=mysqli_query($con, $sqlloadcategory) or die("Error in sqlloadcategory".mysqli_error($con));
			while($rowloadcategory=mysqli_fetch_assoc($resultloadcategory))
			{
				echo '<a class="dropdown-item" href="index.php?pg=public_product.php&categoryid='.$rowloadcategory["category_id"].'">'.$rowloadcategory["category_name"].'</a>';
			}
			?>
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_2"
			role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Order
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
			<a class="dropdown-item" href="index.php?pg=order_detail.php&option=view">order details</a>			
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_2"
			role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Notification (<?php echo $totalnotification; ?>)
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
			<a class="dropdown-item" href="index.php?pg=notification_worker.php">Works On Progress(<?php echo $workonprogressnotification; ?>)</a>
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_2"
			role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Profile (<?php echo $notificationmessage; ?>)
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
			<a class="dropdown-item" href="index.php?pg=message.php&option=view">message (<?php echo $notificationmessage; ?>)</a>			
			<a class="dropdown-item" href="index.php?pg=profile.php">Profile</a>
			<a class="dropdown-item" href="index.php?pg=changepassword.php">Change Password</a>
			<a class="dropdown-item" href="logout.php">Logout</a>
		</div>
	</li>
</ul>
