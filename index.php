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
?>
<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DECO NEEDS</title>
    <link rel="icon" href="system_image/logo.png" height="100" width="100">
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

	<!-- confirm Delete Function Start-->
	<script>
	function confirmdelete()
	{
		var confirmdelete = confirm ("Are you sure you want to delete this Record?");
		if (confirmdelete)
		{
			return  true;
		}
		else
		{
			return  false;
		}
	}
	</script>
	<!-- confirm Delete Function End-->

  <!-- confirm Accept Function Start-->
  <script>
  function confirmaccept()
  {
    var confirmaccept = confirm ("Are you sure you want to Accept this Record?");
    if (confirmaccept)
    {
      return  true;
    }
    else
    {
      return  false;
    }
  }
  </script>
  <!-- confirm Accept Function End-->

  <!-- confirm Reject Function Start-->
  <script>
  function confirmreject()
  {
    var confirmreject = confirm ("Are you sure you want to Reject this Record?");
    if (confirmreject)
    {
      return  true;
    }
    else
    {
      return  false;
    }
  }
  </script>
  <!-- confirm Reject Function End-->

	<script>
  //Text validation start
  function TextValidation(evt) // only text to allow the input field
  {
  	var charCode = (evt.which) ? evt.which : event.keyCode;
  	if (((charCode >64 && charCode < 91)||(charCode >96 && charCode < 123)||charCode ==08 || charCode ==127||charCode ==32||charCode ==46)&&(!(evt.ctrlKey&&(charCode==118||charCode==86))))
  		return true;

  		return false;
  }
  //Text validation End
  </script>

	<script>
  //Number validation Start
function NumberValidation(evt) // only numbers to allow the input field
{
	var charCode = (evt.which) ? evt.which : event.keyCode;//derive unicode and put in keycode
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

		return true;
}
  //Number validation End
	</script>

  <script>
  //mobile number validation Start
  function MobileNumberValidation(mobile_text_box_name) // Mobile No
  {
  	var phoneno = /^\d{10}$/;
  	if(document.getElementById(mobile_text_box_name).value=="")
  	{
  	}
  	else
  	{
  		if( document.getElementById(mobile_text_box_name).value.match(phoneno))
  		{
  			hand(mobile_text_box_name);
  		}
  		else
  		{
  			alert("Enter 10 digit Mobile Number");
  			document.getElementById(mobile_text_box_name).value="";
  			document.getElementById(mobile_text_box_name).focus()=true;
  			return false;
  		}
  	}
  }
  function hand(mobile_text_box_name)
  {
  	var str = document.getElementById(mobile_text_box_name).value;
  	var res = str.substring(0, 2);
  	if(res=="07")
  	{
  		return true;
  	}
  	else
  	{
  		alert("Enter 10 digit of Mobile Number start with 07xxxxxxxx");
  		document.getElementById(mobile_text_box_name).value="";
  		document.getElementById(mobile_text_box_name).focus()=true;
  		return false;
  	}
  }
  //mobile number validation End
  </script>

<script>
//land phone number validation Start
function LandPhoneNumberValidation(lanphone_text_box_name) // Land No
{
	var landno = /^\d{10}$/;
	if(document.getElementById(lanphone_text_box_name).value=="")
	{
	}
	else
	{
		if( document.getElementById(lanphone_text_box_name).value.match(landno))
		{
			land(lanphone_text_box_name);
		}
		else
		{
			alert("Enter 10 digit Land Phone Number");
			document.getElementById(lanphone_text_box_name).value="";
			document.getElementById(lanphone_text_box_name).focus()=true;
			return false;
		}
	}
}
function land(lanphone_text_box_name)
{
	var str = document.getElementById(lanphone_text_box_name).value;
	var res = str.substring(0, 2);
	if(res!="07")
	{
		return true;
	}
	else
	{
		alert("Enter 10 digit of Land Phone Number Ex 021xxxxxxx");
		document.getElementById(lanphone_text_box_name).value="";
		document.getElementById(lanphone_text_box_name).focus()=true;
		return false;
	}
}
//land phone number validation End
</script>

<script>
//check email validation format Start
function EmailValidation()
{
	var email=document.getElementById("txtemail").value;
	var emailformat=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if (email.match(emailformat))
	{

	}
	else if(email.length==0)
	{

	}
	else
	{
		alert("Email Address is Invalid");
		document.getElementById("txtemail").value="";
		document.getElementById("txtemail").focus()=true;
	}
}
//check email validation format End
</script>
<script>
//check NIC exist or not
function NICexist()
{
	var nic=document.getElementById("txtnic").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var get_response = xmlhttp.responseText.trim();
            
			if(get_response=="YES")
			{
				alert("Sorry This NIC number is already Entered");
				document.getElementById("txtnic").value="";
				document.getElementById("txtnic").focus();
				document.getElementById("txtdob").value="";
				document.getElementById("txtgender").value = "";
			}
			else
			{
				NICNumberValidation();
			}
		}
	};
	xmlhttp.open("GET", "ajaxpage.php?frompage=NICexist&ajaxnic=" + nic, true);
	xmlhttp.send();

}
</script>
<script>
//nic format validation
function NICNumberValidation()
{
	var nic=document.getElementById("txtnic").value;
	if(nic.length==10)
	{
		var nicformat1=/^[0-9]{9}[a-zA-Z0-9]{1}$/;
		if(nic.match(nicformat1))
		{
			var nicformat2=/^[0-9]{9}[vVxX]{1}$/;
			if(nic.match(nicformat2))
			{
				calculatedob(nic);
			}
			else
			{
				alert("last character must be V/v/X/x");
				document.getElementById("txtnic").value="";
				document.getElementById("txtnic").focus();
				document.getElementById("txtdob").value="";
			}
		}
		else
		{
			alert("First 9 characters must be numbers");
			document.getElementById("txtnic").value="";
			document.getElementById("txtnic").focus();
			document.getElementById("txtdob").value="";
		}
	}
	else if(nic.length==12)
	{
		var nicformat3=/^[0-9]{12}$/;
		if(nic.match(nicformat3))
		{
			calculatedob(nic);
		}
		else
		{
			alert("All 12 characters must be number");
			document.getElementById("txtnic").value="";
			document.getElementById("txtnic").focus();
			document.getElementById("txtdob").value="";
		}
	}
	else if(nic.length==0)
	{

	}
	else
	{
		alert("NIC No must be 10 or 12 Characters");
		document.getElementById("txtnic").value="";
		document.getElementById("txtnic").focus();
		document.getElementById("txtdob").value="";
	}
}

//send nic to ajaxpage for get dob
function calculatedob(nic)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById("txtdob").value = xmlhttp.responseText.trim();
			if(nic.length==10)
			{
				var bday_num = nic.substring(2, 5);
			}
			else
			{
				var bday_num = nic.substring(4, 7);
			}
			if(bday_num>500)
			{
				var gender="Female";
			}
			else
			{
				var gender="Male";
			}
			document.getElementById("txtgender").value = gender;
		}
	};
	xmlhttp.open("GET", "ajaxpage.php?frompage=dob&dobcal=" + nic, true);
	xmlhttp.send();
}
</script>
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php"> <img src="system_image/logo.png?<?php echo date("Y-m-d"); ?>" height="100" width="100" alt="logo"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <?php
							if($system_usertype=="Guest")
							{
								include "menu_guest.php";
							}
							else if($system_usertype=="Admin")
							{
								include "menu_admin.php";
							}
							else if($system_usertype=="Clerk")
							{
								include "menu_clerk.php";
							}
							else if($system_usertype=="Worker")
							{
								include "menu_worker.php";
							}
							else if($system_usertype=="Customer")
							{
								include "menu_customer.php";
							}
							?>
                        </div>
                        <div class="hearer_icon d-flex">
							<?php
							if($system_usertype=="Guest")
							{
								echo '<font color="#fff">Guest (<a href="index.php?pg=login.php"><font color="#fff">Login</font></a>)</font>';
							}
							else if($system_usertype=="Customer")
							{
								$sqlcustomername="SELECT name FROM customer WHERE customer_id='$system_userid'";
							    $resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
							    $rowcustomername=mysqli_fetch_assoc($resultcustomername);
								
								echo '<font color="#fff"><a href="index.php?pg=profile.php"><font color="#fff">'.$rowcustomername["name"].'</font></a> - Customer (<a href="logout.php"><font color="#fff">Logout</font></a>)</font>';
							}
							else 
							{
								$sqlstaffname="SELECT name FROM staff WHERE staff_id = '$system_userid'";
								$resultstaffname=mysqli_query($con,$sqlstaffname) or die ("Error in sqlstaffname" . mysqli_error($con));
								$rowstaffname=mysqli_fetch_assoc($resultstaffname);
								
								echo '<font color="#fff"><a href="index.php?pg=profile.php"><font color="#fff">'.$rowstaffname["name"].'</font></a> - '.$system_usertype.' (<a href="logout.php"><font color="#fff">Logout</font></a>)</font>';
							}
							
							?>
                            <!--<a id="search_1" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <a href=""><i class="ti-heart"></i></a>
                            <div class="dropdown cart">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown3" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                                 <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <div class="single_product">

                                    </div>
                                </div> 

                            </div>-->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="search_input" id="search_input_box">
            <div class="container ">
                <form class="d-flex justify-content-between search-inner">
                    <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                    <button type="submit" class="btn"></button>
                    <span class="ti-close" id="close_search" title="Close Search"></span>
                </form>
            </div>
        </div>
    </header>
    <!-- Header part end-->
        <?php
if (isset($_GET["pg"])) 
{
	$page=explode(".",$_GET["pg"]);
	$pagename=$page[0];//refer page name
	if($pagename=="public_product" || $pagename=="single_product")
	{
		$pagename='Product';
	}
	$pagename=ucwords(str_replace("_"," ",$pagename));//(for-> Home-Page)converts the first character of each word in a string to uppercase 
                                                      //str_replace("_"," ",$pagename) means place space (" ") insted of ( _ )  
    ?>
     <!-- breadcrumb start-->
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2><font color="#fff"><?php echo $pagename; ?></font></h2><!--Selected Current page's name primely below menu-->
              <p><a href="index.php"><font color="#fff">Home</font></a> <span>-</span><font color="#fff"><?php echo $pagename; ?></font></p><!--Selected Current page's name with path (secondary) below menu-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->
    <?php
} 
else 
{
    ?>
     <!-- banner part start-->
    <section class="banner_part">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="banner_slider owl-carousel">
                        <div class="single_banner_slider">
                            <div class="row">
                                <div class="col-lg-5 col-md-8">
                                    <div class="banner_text">
                                        <div class="banner_text_iner">
                                            <h1>Couch</h1>
                                            <p>A couch consists of the frame, springs, padding, and covering. It's  made out of soft leather, corduroy or linen.</p>
                                            <!--<a href="#" class="btn_2">buy now</a>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="banner_img d-none d-lg-block">
                                    <img src="img/slider1.png" alt="">
                                </div>
                            </div>
                        </div>
						<div class="single_banner_slider">
                            <div class="row">
                                <div class="col-lg-5 col-md-8">
                                    <div class="banner_text">
                                        <div class="banner_text_iner">
                                            <h1>Cloth & Wood
                                                Sofa</h1>
                                            <p>A brilliant take on urban chic styling, the Enderlin sofa in vibrant blue makes high design highly affordable.</p>
                                            <!--<a href="#" class="btn_2">buy now</a>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="banner_img d-none d-lg-block">
                                    <img src="img/banner_img.png" alt="">
                                </div>
                            </div>
                        </div>
						<div class="single_banner_slider">
                            <div class="row">
                                <div class="col-lg-5 col-md-8">
                                    <div class="banner_text">
                                        <div class="banner_text_iner">
                                            <h1>Wooden Sofa Set</h1>
                                            <p>Driven by technical excellence, we are counted among the most renowned firm of Luxury Wooden Sofa Set.</p>
                                            <!--<a href="#" class="btn_2">buy now</a>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="banner_img d-none d-lg-block">
                                    <img src="img/slider2.png" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="single_banner_slider">
                            <div class="row">
                                <div class="col-lg-5 col-md-8">
                                    <div class="banner_text">
                                        <div class="banner_text_iner">
                                            <h1>Cloth $ Wood Sofa</h1>
                                            <p>Incididunt ut labore et dolore magna aliqua quis ipsum
                                                suspendisse ultrices gravida. Risus commodo viverra</p>
                                            <a href="#" class="btn_2">buy now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner_img d-none d-lg-block">
                                    <img src="img/banner_img.png" alt="">
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="slider-counter"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner part start-->
    <?php
}

?>


    <?php  
if (isset($_GET["pg"]))//for load body contents and without pg did't load any body contents
 {
    include $_GET["pg"];// for include pages within the body and without this statement doesn't load any page
 } 
else 
{
    include "body.php";//for load body of home page 
}

?>

    <!--::footer_part start::-->
    <footer class="footer_part">
        <div class="container">
            <div class="row justify-content-around">
				<div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Top Products</h4>
						<ul class="list-unstyled">
							<?php 
							$sqlcategory="SELECT * From category ORDER BY category_id";
							$resultcategory=mysqli_query($con,$sqlcategory) or die ("Error in sqlcategory" .mysqli_error($con));
							while($rowcategory=mysqli_fetch_assoc($resultcategory))
							{
								echo '<li><a href="index.php?pg=public_product.php&categoryid='.$rowcategory["category_id"].'">'.$rowcategory["category_name"].'</a></li>';//to display all product name in the footer part
							}
							?>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <div class="single_footer_part">
                        <h4>Quick Links</h4>
                        <ul class="list-unstyled">
                            <li><a href="index.php?pg=aboutus.php">About Us</a></li>
                            <li><a href="index.php?pg=service.php">Services</a></li>
                            <li><a href="index.php?pg=portfolio.php">Portfolio</a></li>
                            <li><a href="index.php?pg=contact.php">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Services</h4>
                        <ul class="list-unstyled">
                            <li><a href="index.php?pg=service.php">Door Design and Productions</a></li>
                            <li><a href="index.php?pg=service.php">Furniture Accessory</a></li>
                            <li><a href="index.php?pg=service.php">Art Selection</a></li>
                            <li><a href="index.php?pg=service.php">Space Planning</a></li>
                            <li><a href="index.php?pg=service.php">Ceiling Designing</a></li>
                            <li><a href="index.php?pg=service.php">Re-Design & Decorating</a></li>
                            <li><a href="index.php?pg=service.php">Ingraining & Embossing</a></li>
                            <li><a href="index.php?pg=service.php">Construction Documentation (CAD)</a></li>
                            <li><a href="index.php?pg=service.php">3D Printing and Crafting</a></li>
							<li><a href="index.php?pg=service.php">3D Prototype Designing</a></li>
                        </ul>
                    </div>
                </div>
                <!--<div class="col-sm-6 col-lg-2">
                    <div class="single_footer_part">
                        <h4>Resources</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Guides</a></li>
                            <li><a href="">Research</a></li>
                            <li><a href="">Experts</a></li>
                            <li><a href="">Agencies</a></li>
                        </ul>
                    </div>
                </div>-->
                <div class="col-sm-6 col-lg-4">
                    <div class="single_footer_part">
                        <h4>Contact Us</h4>
                        <p>
                            Contact Us for your uniquely personalised interior design services 
                        </p>
						<ul class="list-unstyled">
                            <li><i class="fa fa-phone"></i> <a href="tel:+94212229626">+94(0) 21 222 9626</a></li>
                            <li><i class="fa fa-envelope"></i> <a href="mailto:deconeedslk@gmail.com">deconeedslk@gmail.com</a></li>
                            <li><i class="fa fa-map-marker"></i> 63, Kumarasuwamy Road Thirunelveli, Jaffna, Srilanka.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="copyright_part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="copyright_text">
                            <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | DECO NEEDS (PVT) LTD
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></P>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer_icon social_icon">
                            <ul class="list-unstyled">
                                <!--<li><a href="#" class="single_social_icon"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" class="single_social_icon"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                                <li><a href="#" class="single_social_icon"><i class="fab fa-behance"></i></a></li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--::footer_part end::-->


    <!-- BEGIN MODAL -->
                <div class="modal none-border" id="deco_popup">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong><div id="deco_popup_heading"></div></strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body" id="deco_popup_content"></div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>




    <!-- jquery plugins here-->
    <script src="js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src="js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src="js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src="js/swiper.min.js"></script>
    <!-- swiper js -->
    <script src="js/masonry.pkgd.js"></script>
    <!-- particles js -->
    <script src="js/owl.carousel.min.js"></script>
    <!--<script src="js/jquery.nice-select.min.js"></script>
     slick js -->
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
	


    <!--additional link -->

    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!-- this page js -->
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>
    <script src="assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/libs/select2/dist/js/select2.min.js"></script>
    <script>
        //***********************************//
        // For select 2
        //***********************************//
        $(".select2").select2();

    </script>
</body>

</html>
