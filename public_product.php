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

$get_categoryid=$_GET["categoryid"];
$sqlcategoryname="SELECT category_name FROM category WHERE category_id='$get_categoryid'";
$resultcategoryname=mysqli_query($con,$sqlcategoryname) or die ("Error in sqlcategoryname" . mysqli_error($con));
$rowcategoryname=mysqli_fetch_assoc($resultcategoryname);
?>

    <!--================Category Product Area =================-->
    <section class="cat_product_area section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h1 class="page-title"><?php echo $rowcategoryname["category_name"]; ?></h1>
                </div>
                <div class="col-lg-4">
                    <div class="left_sidebar_area">
                        <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                                <h3>Browse Categories</h3>
                            </div>
                            <div class="widgets_inner">
                                <ul class="list">
                                    <?php //list all categories in publicproduct's sidebar (browse categories)
									$sqlloadcategory="SELECT * FROM category ORDER BY category_id";
									$resultloadcategory=mysqli_query($con, $sqlloadcategory) or die("Error in sqlloadcategory".mysqli_error($con));
									while($rowloadcategory=mysqli_fetch_assoc($resultloadcategory))//list all products
									{
										if($rowloadcategory["category_id"]==$get_categoryid)
										{
											$color="#ff3368";//for highlight selected category
										}
										else 
										{
											$color="";//otherwise nothing is apply
										}
										echo '<li>';
											echo '<a href="index.php?pg=public_product.php&categoryid='.$rowloadcategory["category_id"].'"><font color="'.$color.'">'.$rowloadcategory["category_name"].'</font></a>';//for drop down
										echo '<li>';
									}
									?>
                                    
                                </ul>
                            </div>
                        </aside>

                       
                    </div>
                </div>
                <div class="col-lg-8">
					<?php 
					$sqlsubcategory="SELECT * FROM subcategory WHERE category_id='$get_categoryid'";
					$resultsubcategory=mysqli_query($con,$sqlsubcategory) or die ("Error in $sqlsubcategory" . mysqli_error($con));
					while($rowsubcategory=mysqli_fetch_assoc($resultsubcategory))
					{
					?>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-12 text-center mb-5">
									<h1 class="page-title"><?php echo $rowsubcategory["subcategory_name"]; ?></h1><!--Display Subcategory Name-->
								</div>
							</div>
						</div>
						
						<div class="row align-items-center latest_product_inner">
						<?php
						$sqlproduct="SELECT * FROM product WHERE subcategory_id='$rowsubcategory[subcategory_id]'";
						$resultproduct=mysqli_query($con,$sqlproduct) or die ("Error in sqlproduct" . mysqli_error($con));
						while($rowproduct=mysqli_fetch_assoc($resultproduct))
						{
							$sqlproductprice="SELECT price,offer FROM product_price WHERE product_id='$rowproduct[product_id]' AND end_date IS NULL";//for products which are still on sale
							$resultproductprice=mysqli_query($con,$sqlproductprice) or die ("Error in sqlproductprice" . mysqli_error($con));
							if(mysqli_num_rows($resultproductprice)>0)
							{
								$rowproductprice=mysqli_fetch_assoc($resultproductprice);
								$price=$rowproductprice["price"];
								$offer=$rowproductprice["offer"];
								if($offer>0)//products which are applicable for offer
								{									
									$unitprice=$price-(($price*$offer)/100);
									$displayprice='<h3>LKR '.$unitprice.' <del>LKR '.$price.'</del></h3>';
									//for current price(after the offer is applied ($unitprice)) and strikethrough/cut for old price ($price)
								}
								else
								{
									$unitprice=$price;
									$displayprice='<h3>LKR '.$unitprice.'</h3>';//for current price(after the offer is applied)
								}
								
								$sqlproductimage="SELECT image FROM product_image WHERE product_id='$rowproduct[product_id]'";
								$resultproductimage=mysqli_query($con,$sqlproductimage) or die ("Error in sqlproductimage" . mysqli_error($con));
								$rowproductimage=mysqli_fetch_assoc($resultproductimage);
						?>
								<div class="col-lg-4 col-sm-6">
									<div class="single_product_item">
										<img src="file/product/<?php echo $rowproductimage['image'];//display product image?>" alt="">
										<div class="single_product_text">
											<h4><?php echo $rowproduct['name']; ?></h4><!--for display product name-->
											<?php echo $displayprice; ?><!--for display product old and new prices-->
											<a href="index.php?pg=single_product.php&productid=<?php echo $rowproduct['product_id']; ?>" class="fa fa-eye">View More<i class="fa fa-eye"></i></a>
										</div>
									</div>
								</div>
						<?php 
							}
						}	
						?>
						</div>
					<?php 
					}
					?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Category Product Area =================-->

    

    