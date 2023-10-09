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
$get_productid=$_GET['productid'];

$sqlproduct="SELECT * FROM product WHERE product_id='$get_productid'";
$resultproduct=mysqli_query($con,$sqlproduct) or die ("Error in sqlproduct".mysqli_error($con));
$rowproduct=mysqli_fetch_assoc($resultproduct);//it's contain all product details (specificly)

$sqlproductprice="SELECT price,offer FROM product_price WHERE product_id='$get_productid' AND end_date IS NULL";//produts which are still available
$resultproductprice=mysqli_query($con,$sqlproductprice) or die ("Error in sqlproductprice" . mysqli_error($con));
$rowproductprice=mysqli_fetch_assoc($resultproductprice);

$price=$rowproductprice["price"];
$offer=$rowproductprice["offer"];
if($offer>0)//if offer is applicable
{									
	$unitprice=$price-(($price*$offer)/100);//price which is after applied  offer
	$displayprice='<h3>LKR '.$unitprice.' <del>LKR '.$price.'</del></h3>';//display prices which are after offer applied and before offer (old price)
}
else 
{//if offer is not applicable
	$unitprice=$price;//offer is not applicable
	$displayprice='<h3>LKR '.$unitprice.'</h3>';//display price (offer is not applicable)
}
$sqlsubcategoryname="SELECT subcategory_name FROM subcategory WHERE subcategory_id='$rowproduct[subcategory_id]'";
//for subcategory name which are still available

$resultsubcategoryname=mysqli_query($con,$sqlsubcategoryname) or die ("Error in sqlsubcategoryname" . mysqli_error($con));
$rowsubcategoryname=mysqli_fetch_assoc($resultsubcategoryname);

$sqlcheckstock="SELECT quantity FROM stock WHERE product_id='$get_productid'";
$resultcheckstock=mysqli_query($con,$sqlcheckstock) or die ("Error in sqlcheckstock" . mysqli_error($con));
$rowcheckstock=mysqli_fetch_assoc($resultcheckstock);
if($rowcheckstock["quantity"]>0)
{
	$displaystock="In Stock";//if quantity is greater than 0 that mean there are stock available
}
else
{
	$displaystock="Out of Stock";//if quantity is less than 0 that mean there are no longer stock available
}
?>
  <link rel="stylesheet" href="css/lightslider.min.css">
  
  

<!--================Single Product Area =================-->
  <div class="product_image_area section_padding">
    <div class="container">
      <div class="row s_product_inner justify-content-between">
        <div class="col-lg-7 col-xl-7">
          <div class="product_slider_img">
            <div id="vertical">
			<?php 
			$sqlproductimage="SELECT image FROM product_image WHERE product_id='$get_productid'";
			$resultproductimage=mysqli_query($con,$sqlproductimage) or die ("Error in sqlproductimage" . mysqli_error($con));
			while($rowproductimage=mysqli_fetch_assoc($resultproductimage))
			{
			?>
              <div data-thumb="file/product/<?php echo $rowproductimage["image"];?>"><!--for single product-->
                <img src="file/product/<?php echo $rowproductimage["image"];?>" />
              </div>
            <?php 
			}
			?>  
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-xl-4">
          <div class="s_product_text">
            
            <h3> <?php echo $rowproduct["name"]; ?> </h3><!--display product name-->
            <h2><?php echo $displayprice;?></h2><!--display product price(Prices which are before or after offer or both)-->
            <ul class="list">
              <li>
                <a class="active" href="#">
                  <span>Category</span> : <?php echo $rowsubcategoryname['subcategory_name']; ?></a><!--display subcategory name-->
              </li>
              <li>
                <a href="#"> <span>Availablity</span> : <?php echo $displaystock; ?></a><!--display stock availabity-->
              </li>
            </ul>
            <p>
              <?php echo $rowproduct['material']; ?><!--display product material-->
            </p>
            <div class="card_area d-flex justify-content-between align-items-center">
      <?php
            if (isset($_SESSION["session_orderid"]))
            {
              $sqlcheckorder="SELECT product_id FROM order_product WHERE order_id = '$_SESSION[session_orderid]' AND product_id='$get_productid'";//if order in process for a product
              $resultcheckorder=mysqli_query($con,$sqlcheckorder) or die("Error in sqlcheckorder" . mysqli_error($con));
              if(mysqli_num_rows($resultcheckorder)>0)//order_id = '$_SESSION[session_orderid]' AND product_id='$get_productid
              {
                $visible="no";
              }
              else 
              {
                $visible="yes";
              }
            }
            else //if not set session
            {
              $visible="yes";
            }
            if( $visible=="yes")//if not set session
            {
              ?>
               <a href="index.php?pg=check_addtocart.php&productid=<?php echo $rowproduct['product_id'];?>" class="btn_3">add to cart</a>
              <?php
            }
            else 
            {
              ?>
               <a href="" class="btn_3">Already Added</a>
              <?php
            }
            ?>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--================End Single Product Area =================-->

  <!--================Product Description Area =================-->
  <section class="product_description_area">
    <div class="container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
            aria-selected="true">Description</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review"
            aria-selected="false">Reviews</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
          <p>
            <?php echo $rowproduct['description']; ?><!--display product description-->
          </p>
          <p>
            <?php echo $rowproduct['material']; ?><!--display product material below the description-->
          </p>
        </div>
        
        <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
          <div class="row">
            <div class="col-lg-6">
              
              <div class="review_list">
				<?php 
				$totalreview=0;
				$totalpoint=0;
				$sqlorderid="SELECT order_id FROM order_product WHERE product_id='$get_productid'";
				$resultorderid=mysqli_query($con,$sqlorderid) or die ("Error in sqlorderid". mysqli_error($con));
				while($roworderid=mysqli_fetch_assoc($resultorderid))
				{
					$sqlcheckreview="SELECT * FROM review WHERE order_id='$roworderid[order_id]'";
					$resultcheckreview=mysqli_query($con,$sqlcheckreview) or die ("Error in sqlcheckreview" . mysqli_error($con));
					if(mysqli_num_rows($resultcheckreview)>0)//if any reviews arrived
					{
						$rowcheckreview=mysqli_fetch_assoc($resultcheckreview);
						$totalreview++;//n.o of reviews
						$totalpoint=$totalpoint+$rowcheckreview["rate"];//total rate (stars)
						//total point mean overall stars of all comments
						$sqlcustomername="SELECT c.name FROM customer AS c, order_detail AS od WHERE c.customer_id=od.customer_id AND od.order_id='$roworderid[order_id]'";
            //name of the customer who perticular order the product and that product's orderid is already in the order product table
						$resultcustomername=mysqli_query($con,$sqlcustomername)or die ("Error in sqlcustomername" . mysqli_error($con));
						$rowcustomername=mysqli_fetch_assoc($resultcustomername);
				?>		
					<div class="review_item">
					  <div class="media">
						<div class="d-flex">
						  <img src="system_image\users.png" height=100 width=100 alt="" />
						</div>
						<div class="media-body">
						  <h4><?php echo $rowcustomername["name"]; ?></h4><!--display user name-->
						  <?php 
						  for($x=1; $x<=5; $x++)//for review stars ($x)
						  {
							  if($x<=$rowcheckreview["rate"])//compare with rate points
							  {
								echo '<i class="fa fa-star"></i>';  //display reviewed star(s)
							  }
							  else
							  {
								 echo '<i class="far fa-star"></i>';  //display non reviewed star(s)
							  }
						  }
						  ?>
						</div>
					  </div>
					  <p>
						<?php echo $rowcheckreview["comment"]; ?><!--display comments-->
					  </p>
					</div>
                <?php 
					}
				}
				?>
                
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row total_rate">
                <div class="col-6">
                  <div class="box_total">
                    <h5>Overall</h5>
					<?php
					if($totalpoint==0)//if noone is reviewed yet
					{
						$averagerate=0;
					}
					else
					{
						$averagerate=$totalpoint/$totalreview;//stars/n.o of review(s)
						$averagerate=number_format((float)$averagerate, 1, '.', '');//round price to 1 decimel digits
					}
					?>
                    <h4><?php echo $averagerate;?></h4><!--for display overall(average reviews)-->
                    <h6>(<?php  echo $totalreview; ?> Reviews)</h6> <!--display n.o of reviews located in below overall reviews-->
                  </div>
                </div>
                <div class="col-6">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================End Product Description Area =================-->
  
  
  <!-- jquery plugins here-->
  <!-- jquery -->
  <script src="js/jquery-1.12.1.min.js"></script>
  <!-- popper js -->
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- easing js -->
  <script src="js/jquery.magnific-popup.js"></script>
  <!-- swiper js -->
  <script src="js/lightslider.min.js"></script>
  <!-- swiper js -->
  <script src="js/masonry.pkgd.js"></script>
  <!-- particles js -->
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <!-- slick js -->
  <script src="js/slick.min.js"></script>
  <script src="js/swiper.jquery.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/contact.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/stellar.js"></script>
  <!-- custom js -->
  <script src="js/theme.js"></script>
  <script src="js/custom.js"></script>