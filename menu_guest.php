<?php
if (!isset($_SESSION)) {
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
?>
<ul class="navbar-nav">
	<li class="nav-item">
		<a class="nav-link" href="index.php">Home</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="index.php?pg=aboutus.php">About US</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="index.php?pg=service.php">Services</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_1"
			role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Product
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown_1">
			<?php //load products at product menu
			$sqlloadcategory="SELECT * FROM category ORDER BY category_id";
			$resultloadcategory=mysqli_query($con, $sqlloadcategory) or die("Error in sqlloadcategory".mysqli_error($con));
			while($rowloadcategory=mysqli_fetch_assoc($resultloadcategory))//list all products
			{
				echo '<a class="dropdown-item" href="index.php?pg=public_product.php&categoryid='.$rowloadcategory["category_id"].'">'.$rowloadcategory["category_name"].'</a>';
			}
			?>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="index.php?pg=register_customer.php">Register</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="index.php?pg=portfolio.php">Portfolio</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="index.php?pg=contact.php">Contact US</a>
	</li>
</ul>
