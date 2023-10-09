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
include "config.php";
//insert sql start
if(isset($_POST["btnsave"]))
{
  $sqlstockquantity="SELECT quantity FROM stock WHERE product_id='$_POST[txtproductid]'";
  $resultstockquantity = mysqli_query($con,$sqlstockquantity) or die ("Error in sqlstockquantity ".mysqli_error($con));
  $rowstockquantity=mysqli_fetch_assoc($resultstockquantity);
//to Reduce Stock quantity
  $finalstockquantity=$rowstockquantity["quantity"]-$_POST["txtquantity"];

  $sqlupdate="UPDATE stock SET
								quantity='".mysqli_real_escape_string($con,$finalstockquantity)."'
								WHERE product_id='".mysqli_real_escape_string($con,$_POST["txtproductid"])."'";
  $resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));


  $sqlinsert="INSERT INTO order_product_delivery(order_id,product_id,quantity)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
         '".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtquantity"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
if($resultinsert)
{
  echo '<script> alert("Data stored successfully");
  window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'";</script>';
}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
$sqlupdate="UPDATE order_product_delivery SET
       quantity='".mysqli_real_escape_string($con,$_POST["txtquantity"])."'
      WHERE order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."' AND product_id='".mysqli_real_escape_string($con,$_POST["txtproductid"])."'";
$resultupdate=mysqli_query($con,$sqlupdate) or die ("error in sqledit" . mysqli_error($con));
if($resultupdate)
{
  echo '<script> alert("Successfully Updated");
   window.location.href="index.php?pg=order_product_delivery.php&option=fullview&pk1='.$_POST["txtorderid"].'&pk2='.$_POST["txtproductid"].'";</script>';

}
}
//update code end
?>
<body>
    <?php
if (isset($_GET["option"]))
{
    if ($_GET["option"] == "add")
    {
      $get_orderid =$_GET["pk1"];
      $get_productid =$_GET["pk2"];

      $sqlinitialquantity="SELECT quantity FROM order_product WHERE order_id='$get_orderid' AND product_id='$get_productid'";
      $resultinitialquantity = mysqli_query($con,$sqlinitialquantity) or die ("Error in sqlinitialquantity ".mysqli_error($con));
      $rowinitialquantity=mysqli_fetch_assoc($resultinitialquantity);

      $sqlstockquantity="SELECT quantity FROM stock WHERE product_id='$get_productid'";
      $resultstockquantity = mysqli_query($con,$sqlstockquantity) or die ("Error in sqlstockquantity ".mysqli_error($con));
      $rowstockquantity=mysqli_fetch_assoc($resultstockquantity);
      ?>
      <!-- form section start -->
      <section class="feature_part padding_top">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form class="form-horizontal" method="POST" action="">
                  <div class="card-body">
                    <center><h4 class="card-title">Add Order Product Delivery</h4></center>
                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order ID Here" required>

                                            <?php
                                            $sqlload="SELECT order_id FROM order_detail WHERE order_id='$get_orderid'";
                                            $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                          while( $rowload=mysqli_fetch_assoc($resultload))
                                          {
                                            echo '<option value="'.$rowload["order_id"].'">'.$rowload["order_id"].'</option>';
                                          }

                                            ?>
                                          </select>
                                          </div>

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Product ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtproductid" name="txtproductid" placeholder="Product ID Here" required>

                                              <?php
                                              $sqlload="SELECT product_id,name FROM Product WHERE product_id='$get_productid'";
                                              $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                            while( $rowload=mysqli_fetch_assoc($resultload))
                                            {
                                              echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
                                            }

                                              ?>
                                            </select>
                                          </div>
                                      </div>
                    <!-- field end -->
                    <!-- field start -->
                    <div class="form-group row">

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Quantity</label>
                                          <div class="col-sm-3">
                                              <input type="number" class="form-control" value="<?php echo $rowinitialquantity["quantity"] ?>" min="0" max="<?php echo $rowstockquantity["quantity"] ?>" id="txtquantity" name="txtquantity" placeholder="Quantity Here" required onkeypress="return NumberValidation(event)">
                                          </div>
                                      </div>
                    <!-- field end -->

                    <!-- button start -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <center>
                          <a href ="index.php?pg=order_detail.php&option=fullview&pk=<?php echo $get_orderid; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        <center>  <h5 class="card-title">Order Product Delivery View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=order_product_delivery.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th> Product ID</th>
                  <th>Quantity</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT order_id,product_id,quantity FROM order_product_delivery";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlproductname="SELECT name FROM product WHERE product_id='$rowview[product_id]'";
                  $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                  $rowproductname=mysqli_fetch_assoc($resultproductname);
                  echo'<tr>';
                    echo '<td>'.$rowview["order_id"].'</td>';
                    echo '<td>'.$rowproductname["name"].'</td>';
                    echo '<td>'.$rowview["quantity"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=order_product_delivery.php&option=fullview&pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-success">View</button></a> ';
                      echo '<a href="index.php?pg=order_product_delivery.php&option=edit&pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=order_product_delivery.php&option=delete&pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-danger">Delete</button></a> ';
                    echo '</td>';
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
       $get_orderid =$_GET["pk1"];
       $get_productid =$_GET["pk2"];
       $sqlfullview = "SELECT * FROM order_product_delivery WHERE order_id='$get_orderid' AND product_id='$get_productid'";
       $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
       $rowfullview=mysqli_fetch_assoc($resultfullview);

       $sqlproductname="SELECT name FROM product WHERE product_id='$rowfullview[product_id]'";
       $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
       $rowproductname=mysqli_fetch_assoc($resultproductname);
       ?>
       <div class="card">
       <div class="card-body">
       <center><h5 class="card-title">Order Product Delivery Full View</h5></center>
       <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
           <tr><th>Order ID</th><td><?php echo $rowfullview["order_id"]; ?></td></tr>
           <tr><th>Product ID</th><td><?php echo $rowproductname["name"]; ?></td></tr>
           <tr><th>Quantity</th><td><?php echo $rowfullview["quantity"]; ?></td></tr>

           <tr>
             <td colspan="2">
               <center>
                 <a href="index.php?pg=order_product_delivery.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                 <a href="index.php?pg=order_product_delivery.php&option=edit&pk1=<?php echo $rowfullview["order_id"]; ?>&pk2=<?php echo $rowfullview["product_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

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
         $get_orderid=$_GET["pk1"];
         $get_productid=$_GET["pk2"];
     $sqledit="SELECT * FROM order_product_delivery WHERE order_id = '$get_orderid' AND product_id = '$get_productid'";
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
                       <center><h4 class="card-title">EDIT Order Product Delivery</h4></center>
                       <!-- field start -->
                       <div class="form-group row">
                                             <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
                                             <div class="col-sm-3">
                                                 <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order ID Here" required readonly >
                                                 <?php
                                                 $sqlload="SELECT order_id FROM order_detail WHERE order_id='$rowedit[order_id]'";
                                                 $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                               while( $rowload=mysqli_fetch_assoc($resultload))
                                               {
                                                 echo '<option value="'.$rowload["order_id"].'">'.$rowload["order_id"].'</option>';
                                               }

                                                 ?>
                                               </select>
                                             </div>

                         <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Product ID</label>
                                             <div class="col-sm-3">
                                                 <select class="form-control" id="txtproductid" name="txtproductid" placeholder="Product ID Here" required readonly>
                                                   <?php
                                                   $sqlload="SELECT product_id,name FROM Product WHERE product_id='$rowedit[product_id]' ";
                                                   $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                                 while( $rowload=mysqli_fetch_assoc($resultload))
                                                 {
                                                   echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
                                                 }

                                                   ?>
                                                 </select>
                                             </div>
                                         </div>
                       <!-- field end -->
                       <!-- field start -->
                       <div class="form-group row">

                         <label for="fname" class="col-sm-3 text-right control-label col-form-label">Quantity</label>
                                             <div class="col-sm-3">
                                                 <input type="number" class="form-control" id="txtquantity" name="txtquantity" placeholder="Quantity Here" required value="<?php echo $rowedit["quantity"]; ?>" onkeypress="return NumberValidation(event)">
                                             </div>
                                         </div>
                       <!-- field end -->

                       <!-- button start -->
                       <div class="form-group row">
                           <div class="col-sm-12">
                           <center>
                             <a href ="index.php?pg=order_product_delivery.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
           </div>
         </section>
         <!-- form section end -->


         <?php
       }
       else if ($_GET["option"] == "delete")
       {
       $get_orderid=$_GET["pk1"];
       $get_productid=$_GET["pk2"];
       $sqldelete = "DELETE FROM order_product_delivery WHERE order_id ='$get_orderid' AND product_id='$get_productid'";
       $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
       if ($resultdelete)
       {
         echo '<script> alert("Record is Deleted");
               window.location.href="index.php?pg=order_product_delivery.php&option=view";</script>';
       }
       }
       }
       ?>
       </body>
