<?php
if (!isset($_SESSION)) 
{
    session_start();
}
date_default_timezone_set("Asia/Colombo");
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
include "config.php";
?>
<html>
	<head>
	<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>DECO NEEDS</title>
		<link rel="icon" href="system_image/logo.png">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Drop Down CSS -->
		<!--<link rel="stylesheet" href="css/dropdown.css">-->
		<!-- animate CSS -->
		<link rel="stylesheet" href="css/animate.css">
		<!-- owl carousel CSS -->
		<link rel="stylesheet" href="css/owl.carousel.min.css">
		<!-- font awesome CSS -->
		<link rel="stylesheet" href="css/all.css">
		<!-- flaticon CSS -->
		<link rel="stylesheet" href="css/flaticon.css">
		<link rel="stylesheet" href="css/themify-icons.css">
		<!-- font awesome CSS -->
		<link rel="stylesheet" href="css/magnific-popup.css">
		<!-- swiper CSS -->
		<link rel="stylesheet" href="css/slick.css">
		<!-- style CSS -->
		<link rel="stylesheet" href="css/style.css">

		<!-- additional link -->
		<link rel="stylesheet" type="text/css" href="assets/extra-libs/multicheck/multicheck.css">
		<link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="assets/libs/select2/dist/css/select2.min.css">


		 <script language="javascript">
			document.onmousedown=disableclick;
			status="Right Click Disabled";
			function disableclick(event)
			{
			  if(event.button==2)
			   {
				 alert(status);
				 return false;    
			   }
			}
		</script>
		<script type="text/javascript">
		// for print report button
			function printpage() 
			{
				//Get the print button and put it into a variable
				var printButton = document.getElementById("printpagebutton");
				//Set the print button visibility to 'hidden' 
				printButton.style.visibility = 'hidden';
				//Print the page content
				window.print()
				//Set the print button to 'visible' again 
				//[Delete this line if you want it to stay hidden after printing]
				printButton.style.visibility = 'visible';
			}
		</script>
	</head>
	<body oncontextmenu="return false">
		<table width="1200" border="0" align="center">
		<tr>  <!-- banner start -->
			<td><center><img src="system_image/letter_head.PNG" height="250" width="900"></center></td>
		</tr> <!-- banner end -->
		<tr>
			<td>
			<input id="printpagebutton" type="button" value="Print Report" class="btn btn-primary" onclick="printpage()"/>  
			<!-- print button, but it was not visible in printed paper  -->
			<br>
			<?php

				if(isset($_GET['pr'])) // if get print
				{
					$filename=$_GET['pr'];
					include($filename);
				}
			?>
			</td>
		</tr>
		</table>
	</body>
</html>
