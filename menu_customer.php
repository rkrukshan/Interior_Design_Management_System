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

$totalnotification=0;

$customerconfirmpricenotification=0;
$sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE customer_id='$system_userid' AND (status='Pending' OR status='Accepted')";                
$resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
while($rowview=mysqli_fetch_assoc($resultview))
{
	$sqlcheckorderprocess="SELECT * FROM order_process WHERE order_id='$rowview[order_id]' AND status='Completed'";
	$resultcheckorderprocess=mysqli_query($con,$sqlcheckorderprocess) or die ("Error in sqlcheckorderprocess" .mysqli_error($con));
	if (mysqli_num_rows($resultcheckorderprocess)==0)
	{
		$sqlcustomorder = "SELECT * FROM custom_order WHERE order_id='$rowview[order_id]' AND accept_price!='' AND status='Pending'";
		$resultcustomorder = mysqli_query($con, $sqlcustomorder) or die("Error in sqlcustomorder " . mysqli_error($con));
		if(mysqli_num_rows($resultcustomorder)>0)
		{
			$customerconfirmpricenotification++;
		}
	}
}
$totalnotification=$totalnotification+$customerconfirmpricenotification;

$pendingbillnotification=0;
$sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE status='Accepted' AND customer_id='$system_userid'";
$resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
while($rowview=mysqli_fetch_assoc($resultview))
{
	$get_orderid=$rowview["order_id"];
	
	$sqlfullview = "SELECT * FROM order_detail WHERE order_id  ='$get_orderid'";
	$resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
	$rowfullview=mysqli_fetch_assoc($resultfullview);
	$totalprice=0;
	$sqlvieworderproduct="SELECT order_id,product_id,quantity FROM order_product WHERE order_id='$get_orderid'";
	$resultvieworderproduct = mysqli_query($con,$sqlvieworderproduct) or die ("Error in sqlvieworderproduct ".mysqli_error($con));
	while($rowvieworderproduct=mysqli_fetch_assoc($resultvieworderproduct))
	{
		$sqlcheckprice="SELECT price,offer,start_date  FROM product_price WHERE product_id='$rowvieworderproduct[product_id]' ORDER BY start_date DESC ";
		$resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
		while($rowcheckprice=mysqli_fetch_assoc($resultcheckprice))
		{
			if ($rowfullview["create_date"]>=$rowcheckprice["start_date"])
			{
			$price=$rowcheckprice["price"];
			$offer=$rowcheckprice["offer"];
			break;
			}
		}


		if($offer>0)
		{
			$unitprice=$price-(($price*$offer)/100);
		}
		else
		{
			$unitprice=$price;
		}
		$unitprice=number_format((float)$unitprice, 2, '.', '');
		if ($rowfullview["status"]=="Accepted")
		{
			$sqlfinalquantity="SELECT order_id,product_id,quantity FROM order_product_delivery WHERE order_id='$get_orderid' AND product_id='$rowvieworderproduct[product_id]'";
			$resultfinalquantity=mysqli_query($con,$sqlfinalquantity) OR die ("Error in sqlfinalquantity" .mysqli_error($con));
			if(mysqli_num_rows($resultfinalquantity)>0)
			{
			$rowfinalquantity=mysqli_fetch_assoc($resultfinalquantity);
			$finalquantity=$rowfinalquantity["quantity"];
			$subtotal=$rowfinalquantity["quantity"]*$unitprice;
			}
			else
			{
			$subtotal=$rowvieworderproduct["quantity"]*$unitprice;
			$finalquantity="";
			}
		}
		else
		{
			$subtotal=$rowvieworderproduct["quantity"]*$unitprice;
		}

		$totalprice=$totalprice+$subtotal;                    
	}
	
	$sqlviewcustomorder = "SELECT * FROM custom_order WHERE order_id='$get_orderid'";
	$resultviewcustomorder = mysqli_query($con, $sqlviewcustomorder) or die("Error in sqlviewcustomorder " . mysqli_error($con));
	while ($rowviewcustomorder = mysqli_fetch_assoc($resultviewcustomorder))
	{
		if($rowviewcustomorder["accept_price"]=="")
		{
		  $subtotal=$rowviewcustomorder["quantity"]*0;
		}
		else
		{
		  $subtotal=$rowviewcustomorder["quantity"]*$rowviewcustomorder["accept_price"];
		}
		if($rowviewcustomorder["status"]=="Accepted")
		{
		$totalprice=$totalprice+$subtotal;
		}						
	}
	
	$sqlpaidamount="SELECT SUM(amount) AS t_amount FROM bill WHERE order_id='$get_orderid' AND pay_status='Paid'";
	$resultpaidamount=mysqli_query($con,$sqlpaidamount) or die ("error in sqlpaidamount" .mysqli_error($con));
	$rowpaidamount=mysqli_fetch_assoc($resultpaidamount);
	
	if ($totalprice>$rowpaidamount["t_amount"])                  
	{
		$pendingbillnotification++;
	}
}
$totalnotification=$totalnotification+$pendingbillnotification;

$workonprogressnotification=0;
$sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE status='Accepted' AND customer_id='$system_userid'";                
$resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
while($rowview=mysqli_fetch_assoc($resultview))
{
	$sqlcheck="SELECT order_id FROM order_process WHERE order_id='$rowview[order_id]' AND status='Progress'";
	$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck".mysqli_error($con));
   if(mysqli_num_rows($resultcheck)>0)
   {
	$workonprogressnotification++;
   }
}
$totalnotification=$totalnotification+$workonprogressnotification;


//message
$sqlview = "SELECT message_id,subject,from_id,message_date,read_status FROM message WHERE to_id='$system_userid' AND inbox_delete='1' AND read_status='1'";
$resultview = mysqli_query($con, $sqlview) or die("Error in sqlview " . mysqli_error($con));
$notificationmessage=mysqli_num_rows($resultview);
?>
<ul class="navbar-nav">
	<li class="nav-item">
		<a class="nav-link" href="index.php">Home</a>
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
		<a class="dropdown-item" href="index.php?pg=notification_customerconfirmprice.php">Custom Order Price(<?php echo $customerconfirmpricenotification; ?>)</a>
		<a class="dropdown-item" href="index.php?pg=notification_pendingbill.php">Pending Payment(<?php echo $pendingbillnotification; ?>)</a>
		<a class="dropdown-item" href="index.php?pg=notification_workonprogress_customer.php">Works On Progress(<?php echo $workonprogressnotification; ?>)</a>
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
