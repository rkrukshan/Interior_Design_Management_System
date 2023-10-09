<?php
if (!isset($_SESSION))
{
    session_start();
}
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
if($system_usertype=="Admin"||$system_usertype=="Clerk")
{//Admin,Clerk Can Access This Page
include "config.php";
//insert sql start
if(isset($_POST["btnsave"]))
{
  $sqlinsert="INSERT INTO stock(product_id,quantity)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtquantity"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
if($resultinsert)
{
  echo '<script> alert("Data stored successfully"); </script>';
}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE stock SET
								quantity='".mysqli_real_escape_string($con,$_POST["txtquantity"])."'
								WHERE product_id='".mysqli_real_escape_string($con,$_POST["txtproductid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=stock.php&option=fullview&pk='.$_POST["txtproductid"].'";</script>';
	}

}
//update code End
?>
<body>
    <?php
if (isset($_GET["option"]))
{
    if ($_GET["option"] == "add")
    {
      ?>
      <!-- form section start -->
      <section class="feature_part padding_top">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form class="form-horizontal" method="POST" action="">
                  <div class="card-body">
                    <center><h4 class="card-title">Add Stock</h4></center>
                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtproductid" name="txtproductid" placeholder="product ID Here" required>
                                              <option value="select_option">Select product ID</option>
                                              <?php
                                              $sqlload="SELECT product_id,name FROM product";
                                              $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                            while( $rowload=mysqli_fetch_assoc($resultload))
                                            {
                                              echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
                                            }

                                              ?>
                                            </select>
                                          </div>

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Quantity</label>
                                          <div class="col-sm-3">
                                              <input type="number" class="form-control" id="txtquantity" name="txtquantity" placeholder="Quantity Here" onkeypress="return NumberValidation(event)">
                                          </div>
                                      </div>
                    <!-- field end -->

                    <!-- button start -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <center>
                          <a href ="index.php?pg=stock.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
                          <input type="reset" class="btn btn-danger" id="btnclear" name="btnclear" value="Clear">
                          <input type="submit" class="btn btn-success" id="btnsave" name="btnsave" value="Save">
                        </center>
                                          </div>
                                      </div>
                    <!-- button end -->
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- form section end -->


      <?php
    }
     else if ($_GET["option"] == "view")
    {
      ?>
  		<div class="card">
  			<div class="card-body">
  				<center><h5 class="card-title">Stock View</h5></center>
  				<div class="table-responsive">
  					<table id="zero_config" class="table table-striped table-bordered">
  						<thead>
  							<tr>
  								<th>product ID</th>
  								<th>quantity</th>
  							</tr>
  						</thead>
  						<tbody>
  							<?php
  							$sqlview="SELECT product_id,name,minimum_alert FROM product";
  							$resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
  							while($rowview=mysqli_fetch_assoc($resultview))
  							{
                  $sqlcheckprice="SELECT product_id  FROM product_price WHERE product_id='$rowview[product_id]' AND end_date IS NULL";
                  $resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
                  $m=mysqli_num_rows($resultcheckprice);
                  if($m==0)//not sale
                  {
                    $pricemessage='<font color="orange">Currently not Sale</font>';
                  }
                  else
                  {
                    $pricemessage="";
                  }

                  $sqlstockcheck="SELECT quantity FROM stock WHERE product_id='$rowview[product_id]'";
                  $resultstockcheck=mysqli_query($con,$sqlstockcheck) or die ("Error in sqlstockcheck" . mysqli_error($con));
                  $n=mysqli_num_rows($resultstockcheck);
                  if($n==0)
                  {
                    $quantity='<font color="red"> Still not Purchase</font>';
                  }
                  else
                  {
                    $rowstockcheck=mysqli_fetch_assoc($resultstockcheck);
					if($rowview["minimum_alert"]>$rowstockcheck["quantity"])
					{
						$quantity=$rowstockcheck["quantity"].'<font color="red"> Want to Purchase</font>';
					}
					else 
					{//Stock is Available
						$quantity=$rowstockcheck["quantity"];
					}
                    
                  }

  								echo'<tr>';
  									echo '<td>'.$rowview["name"].' '.$pricemessage.'</td>';
  									echo '<td>'.$quantity.'</td>';
  								echo'</tr>';
  							}
  							?>
  						</tbody>
  					</table>
  				</div>
  			</div>
  		</div>
  		<?php
    }
     else if ($_GET["option"] == "fullview")
     {
       $get_productid =$_GET["pk"];
       $sqlfullview = "SELECT * FROM stock WHERE product_id='$get_productid'";
       $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
       $rowfullview=mysqli_fetch_assoc($resultfullview);

       $sqlproductname="SELECT name FROM product WHERE product_id='$rowfullview[product_id]'";
       $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
       $rowproductname=mysqli_fetch_assoc($resultproductname);
       ?>
       <div class="card">
       <div class="card-body">
       <center><h5 class="card-title">Stock Full View</h5></center>
       <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
           <tr><th>Product ID</th><td><?php echo $rowproductname["name"]; ?></td></tr>
           <tr><th>Quantity</th><td><?php echo $rowfullview["quantity"]; ?></td></tr>

           <tr>
             <td colspan="2">
               <center>
                 <a href="index.php?pg=stock.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                 <a href="index.php?pg=stock.php&option=edit&pk=<?php echo $rowfullview["product_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

               </center>
             </td>
           </tr>
         </table>
       </div>
       </div>
       </div>
       <?php
       }
       else if ($_GET["option"] == "edit")
       {
         //edit form
 		$get_productid=$_GET["pk"];
 		$sqledit="SELECT * FROM stock WHERE product_id = '$get_productid'";
 		$resultedit=mysqli_query($con,$sqledit) or die ("Error in sqlediit" . mysqli_error($con));
 		$rowedit=mysqli_fetch_assoc($resultedit);
 		?>
 		<!-- form section start -->
 		<section class="feature_part padding_top">
 			<div class="container">
 				<div class="row">
 					<div class="col-md-12">
 						<div class="card">
 							<form class="form-horizontal" method="POST" action="">
 								<div class="card-body">
 									<center><h4 class="card-title">Edit Stock</h4></center>

 									<!-- field start -->
 									<div class="form-group row">
                                         <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                         <div class="col-sm-3">
                                             <select class="form-control" id="txtproductid" name="txtproductid" placeholder="Product id Here"   required>
											                        <?php
                                              $sqlload="SELECT product_id,name FROM product WHERE product_id='$rowedit[product_id]'";
                                              $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                            while( $rowload=mysqli_fetch_assoc($resultload))
                                            {
                                              echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
                                            }

                                              ?>
                                            </select>
                                         </div>

 										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Quantity</label>
                                         <div class="col-sm-3">
                                             <input type="text" class="form-control" id="txtquantity" name="txtquantity" placeholder="Quantity Here" value="<?php echo $rowedit["quantity"]; ?>" required onkeypress="return NumberValidation(event)">
                                         </div>
                                     </div>
 									<!-- field end -->


 									<!-- button start -->
 									<div class="form-group row">
                                         <div class="col-sm-12">
 											<center>
 												<a href ="index.php?pg=stock.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
 												<input type="reset" class="btn btn-danger" id="btncancel" name="btncancel" value="Cancel">
 												<input type="submit" class="btn btn-success" id="btnsavechanges" name="btnsavechanges" value="Save Changes">
 											</center>
                                         </div>
                                     </div>
 									<!-- button end -->

 								</div>
 							</form>
 						</div>
 					</div>
 				</div>
 			</div>.
 		</section>
 		<!-- form section end -->
 		<?php
       }
       else if ($_GET["option"] == "delete")
       {
       $get_productid =$_GET["pk"];
       $sqldelete = "DELETE FROM stock WHERE product_id='$get_productid'";
       $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
       if ($resultdelete)
       {
         echo '<script> alert("Record is Deleted");
               window.location.href="index.php?pg=stock.php&option=view";</script>';
       }
       }
       }
       ?>
       </body>
       <?php
}
else 
{//Others Will Redirect to Index Page
    echo '<script>window.location.href="index.php";</script>';
}
       ?>
