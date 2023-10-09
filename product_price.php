<?php
if(!isset($_SESSION))
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
  $sqllastprice="SELECT start_date FROM product_price WHERE product_id='$_POST[txtproductid]' ORDER BY start_date DESC LIMIT 1";
  $resultlastprice=mysqli_query($con,$sqllastprice) or die ("Error in sqllastprice" . mysqli_error($con));
  $rowlastprice=mysqli_fetch_assoc($resultlastprice);
  $today=date("Y-m-d");
  $yesterday=date("Y-m-d", strtotime($today)-(3600*24));
  if ($rowlastprice["start_date"]==$today)
   {
    $sqldelete="DELETE FROM product_price WHERE product_id='$_POST[txtproductid]' AND start_date='$rowlastprice[start_date]'";
    $resultdelete=mysqli_query($con,$sqldelete) or die ("Error in sqldelete" . mysqli_error($con));
  }
  $sqlinsert="INSERT INTO product_price(product_id,start_date,price,offer)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
        '".mysqli_real_escape_string($con,date("Y-m-d"))."',
        '".mysqli_real_escape_string($con,$_POST["txtprice"])."',
        '".mysqli_real_escape_string($con,$_POST["txtoffer"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
if($resultinsert)
{
  echo '<script> alert("Data stored successfully");
  window.location.href="index.php?pg=product.php&option=fullview&pk='.$_POST["txtproductid"].'"; </script>';
}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
  $sqllastprice="SELECT start_date FROM product_price WHERE product_id='$_POST[txtproductid]' AND end_date IS NULL";
  $resultlastprice=mysqli_query($con,$sqllastprice) or die ("Error in sqllastprice" . mysqli_error($con));
  $rowlastprice=mysqli_fetch_assoc($resultlastprice);
  $today=date("Y-m-d");
  $yesterday=date("Y-m-d", strtotime($today)-(3600*24));
  if ($rowlastprice["start_date"]==$today)
   {
    $sqldelete="DELETE FROM product_price WHERE product_id='$_POST[txtproductid]' AND start_date='$rowlastprice[start_date]'";
    $resultdelete=mysqli_query($con,$sqldelete) or die ("Error in sqldelete" . mysqli_error($con));
  }
  else
   {
     $sqlupdate="UPDATE  product_price SET end_date='$yesterday' WHERE product_id='$_POST[txtproductid]' AND start_date='$rowlastprice[start_date]'";
     $resultupdate=mysqli_query($con,$sqlupdate) or die ("Error in sqlupdate" . mysqli_error($con));
  }

  $sqlinsert="INSERT INTO product_price(product_id,start_date,price,offer)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
        '".mysqli_real_escape_string($con,date("Y-m-d"))."',
        '".mysqli_real_escape_string($con,$_POST["txtprice"])."',
        '".mysqli_real_escape_string($con,$_POST["txtoffer"])."')";
  $resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
	if ($resultinsert)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=product.php&option=fullview&pk='.$_POST["txtproductid"].'";</script>';

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
      $get_productid=$_GET["productid"];
		    ?>
        <!-- form section start -->
        <section class="feature_part padding_top">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form class="form-horizontal" method="POST" action="">
                    <div class="card-body">
                      <center><h4 class="card-title">Add Product Price</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtproductid" name="txtproductid" placeholder="Product ID Here" required>
                                                <?php
                                                  $sqlload="SELECT product_id,name FROM product WHERE product_id='$get_productid'";
                                                  $resultload=mysqli_query($con,$sqlload) or die("Error in sqlload" . mysqli_error($con));
                                                  while($rowload=mysqli_fetch_assoc($resultload))
                                                  {
                                                    echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
                                                  }
                                                  ?>
                                                </Select>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Price</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control" id="txtprice" name="txtprice" placeholder="Price Here" required onkeypress="return NumberValidation(event)">
                                                                </div>

                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Offer</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtoffer" name="txtoffer" value="0" placeholder="Offer Here" required onkeypress="return NumberValidation(event)">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=product.php&option=fullview&pk=<?php echo $get_productid; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        <center>  <h5 class="card-title">Product Price View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=product_price.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Start Date</th>
                  <th>price</th>
                  <th>Offer</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT product_id,start_date,price,offer FROM product_price";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlproductname="SELECT name FROM product WHERE product_id='$rowview[product_id]'";
                  $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                  $rowproductname=mysqli_fetch_assoc($resultproductname);
                  echo'<tr>';
                    echo '<td>'.$rowproductname["name"].'</td>';
                    echo '<td>'.$rowview["start_date"].'</td>';
                    echo '<td>'.$rowview["price"].'</td>';
                    echo '<td>'.$rowview["offer"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=product_price.php&option=fullview&pk1='.$rowview["product_id"].'&pk2='.$rowview["start_date"].'"><button class="btn btn-success">View</button></a> ';
                      echo '<a href="index.php?pg=product_price.php&option=edit&pk1='.$rowview["product_id"].'&pk2='.$rowview["start_date"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=product_price.php&option=delete&pk1='.$rowview["product_id"].'&pk2='.$rowview["start_date"].'"><button class="btn btn-danger">Delete</button></a> ';
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
      $get_productid =$_GET["pk1"];
      $get_startdate =$_GET["pk2"];
      $sqlfullview = "SELECT * FROM product_price WHERE product_id  ='$get_productid' AND start_date='$get_startdate'";
      $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
      $rowfullview=mysqli_fetch_assoc($resultfullview);

      $sqlproductname="SELECT name FROM product WHERE product_id='$rowfullview[product_id]'";
      $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
      $rowproductname=mysqli_fetch_assoc($resultproductname);
      ?>
      <div class="card">
      <div class="card-body">
      <center><h5 class="card-title">Product Price Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Product ID</th><td><?php echo $rowproductname["name"]; ?></td></tr>
          <tr><th> Start Date</th><td><?php echo $rowfullview["start_date"]; ?></td></tr>
          <tr><th>End Date</th><td><?php echo $rowfullview["end_date"]; ?></td></tr>
          <tr><th> Price</th><td><?php echo $rowfullview["price"]; ?></td></tr>
          <tr><th> Offer</th><td><?php echo $rowfullview["offer"]; ?></td></tr>


          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=product_price.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <a href="index.php?pg=product_price.php&option=edit&pk1=<?php echo $rowfullview["product_id"]; ?>&pk2=<?php echo $rowfullview["start_date"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

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
        $get_productid =$_GET["pk1"];
        $get_startdate =$_GET["pk2"];
        $sqledit = "SELECT * FROM product_price WHERE product_id  ='$get_productid' AND start_date='$get_startdate'";
        $resultedit = mysqli_query($con,$sqledit) or die("Sqledit error ".mysqli_error($con));
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
                        <center><h4 class="card-title">Edit Product Price</h4></center>
                        <!-- field start -->
                        <div class="form-group row">
                                              <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                              <div class="col-sm-3">
                                                  <select class="form-control" id="txtproductid" name="txtproductid" placeholder="Product ID Here" required readonly >
                                                    <?php
                                                    $sqlload="SELECT product_id,name FROM product WHERE product_id='$rowedit[product_id]'";
                                                    $resultload=mysqli_query($con,$sqlload) or die("Error in sqlload" . mysqli_error($con));
                                                    while($rowload=mysqli_fetch_assoc($resultload))
                                                    {
                                                      echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
                                                    }
                                                    ?>
                                                  </select>
                                              </div>

                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                              <div class="col-sm-3">
                                                  <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" placeholder="From ID Here" required readonly value="<?php echo $rowedit["start_date"]; ?>">
                                              </div>
                                          </div>
                        <!-- field end -->

                        <!-- field start -->
                        <div class="form-group row">


                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Price</label>
                                              <div class="col-sm-3">
                                                  <input type="text" class="form-control" id="txtprice" name="txtprice" placeholder="Price Here" required value="<?php echo $rowedit["price"]; ?>" onkeypress="return NumberValidation(event)">
                                              </div>
                                              <label for="fname" class="col-sm-3 text-right control-label col-form-label">Offer</label>
                                              <div class="col-sm-3">
                                                  <input type="text" class="form-control" id="txtoffer" name="txtoffer" placeholder="Offer Here" required value="<?php echo $rowedit["offer"]; ?>" onkeypress="return NumberValidation(event)">
                                              </div>
                                          </div>
                        <!-- field end -->


                        <!-- button start -->
                        <div class="form-group row">
                                              <div class="col-sm-12">
                            <center>
                              <a href ="index.php?pg=product.php&option=fullview&pk=<?php echo $get_productid; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
                              <input type="reset" class="btn btn-danger" id="btncancel" name="btncancel" value="Cancel">
                              <input type="submit" class="btn btn-success" id="btnsavechanges" name="btnsavechanges" value="Save Changes">
                            </center>
                                              </div>
                                          </div>
                        <!-- button end -->
                        <?php
      }
      else if ($_GET["option"] == "delete")
      {
        $get_productid =$_GET["pk1"];
        $get_startdate =$_GET["pk2"];
      $sqldelete = "DELETE FROM product_price WHERE product_id  ='$get_productid' AND start_date='$get_startdate'";
      $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
      if ($resultdelete)
      {
        echo '<script> alert("Record is Deleted");
              window.location.href="index.php?pg=product_price.php&option=view";</script>';
      }
      }
      }
      ?>
      </body>
