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
  $sqlinsert="INSERT INTO purchase_product(purchase_id,product_id,quantity,purchase_price)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtpurchaseid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtquantity"])."',
        '".mysqli_real_escape_string($con,$_POST["txtpurchaseprice"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
if($resultinsert)
{
  if (!isset($_SESSION["session_purchaseid"]))
  {
    $_SESSION["session_purchaseid"]=$_POST["txtpurchaseid"];
  }
  echo '<script> alert("Data stored successfully"); </script>';
}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE purchase_product SET
								quantity='".mysqli_real_escape_string($con,$_POST["txtquantity"])."',
								purchase_price='".mysqli_real_escape_string($con,$_POST["txtpurchaseprice"])."'
								WHERE purchase_id='".mysqli_real_escape_string($con,$_POST["txtpurchaseid"])."' AND product_id='".mysqli_real_escape_string($con,$_POST["txtproductid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=purchase_product.php&option=add";</script>';
	}

}
//update code End
?>

<script>
function load_subcategory()
{
  var category_id=document.getElementById("txtcategoryid").value;
  if (category_id!="select_option")
  {//if select any category

  	var xmlhttp = new XMLHttpRequest();
  	xmlhttp.onreadystatechange = function()
  	{
  		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
  		{
  			var get_response = xmlhttp.responseText.trim();
  			document.getElementById("txtsubcategoryid").innerHTML=get_response;
        document.getElementById("txtproductid").innerHTML='<option value="select_option">Select product ID</option>';
  		}
  	};
  	xmlhttp.open("GET", "ajaxpage.php?frompage=product_category&ajaxcategoryid=" + category_id, true);
  	xmlhttp.send();
  }
  else
  {//if not select any category
    document.getElementById("txtsubcategoryid").innerHTML='<option value="select_option">Select The Sub Category ID</option>';
    document.getElementById("txtproductid").innerHTML='<option value="select_option">Select product ID</option>';
  }
}
</script>

<script>
function load_product()
{
  var subcategory_id=document.getElementById("txtsubcategoryid").value;
  if (subcategory_id!="select_option")
  {//if select any subcategory

  	var xmlhttp = new XMLHttpRequest();
  	xmlhttp.onreadystatechange = function()
  	{
  		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
  		{
  			var get_response = xmlhttp.responseText.trim();
  			document.getElementById("txtproductid").innerHTML=get_response;
  		}
  	};
  	xmlhttp.open("GET", "ajaxpage.php?frompage=purchase_product_subcategory&ajaxsubcategoryid=" + subcategory_id, true);
  	xmlhttp.send();
  }
  else
  {//if not select any subcategory
    document.getElementById("txtproductid").innerHTML='<option value="select_option">Select product ID</option>';
  }
}
</script>
<script>
function confirmoption()
{
var productid=document.getElementById("txtproductid").value;
if (productid!="select_option")
  {
  return true;
  }
else
  {
  alert("Please Select the Product");
  return false;
  }
}
</script>
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
                  <form class="form-horizontal" method="POST" action="" onsubmit="return confirmoption()">
                    <div class="card-body">
                      <center><h4 class="card-title">Add Purchase Product</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Purchase ID</label>
                                            <div class="col-sm-3">
                                              <?php
                                              if (isset($_SESSION["session_purchaseid"]))
                                              {
                                                $generateid=$_SESSION["session_purchaseid"];
                                              }
                                              else
                                              {
                                                $sqlgenerateid="SELECT purchase_id FROM purchase_product ORDER BY purchase_id DESC LIMIT 1";
                                                $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                                                $n=mysqli_num_rows($resultgenerateid);//count the number of records
                                                if($n==1)
                                                {//for other than 1st time
                                                    $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                                                    $generateid=++$rowgenerateid["purchase_id"];
                                                }
                                                else
                                                  {//For 1st time
                                                      $generateid="PUR0001";
                                                  }
                                              }

                                              ?>
                                                <input type="text" class="form-control" id="txtpurchaseid" name="txtpurchaseid" placeholder="Purchase id Here" readonly  value="<?php echo $generateid; ?>" required>
                                            </div>

                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Category id</label>
                                                                <div class="col-sm-3">
                                                                    <select class="form-control" id="txtcategoryid" name="txtcategoryid" placeholder="category ID Here" onchange="load_subcategory()" required>
                                                                    <option value="select_option">Select The Category ID</option>
                                                                      <?php
                                                                      $sqlload="SELECT category_id,category_name FROM category";
                                                                      $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                                                    while( $rowload=mysqli_fetch_assoc($resultload))
                                                                    {
                                                                      echo '<option value="'.$rowload["category_id"].'">'.$rowload["category_name"].'</option>';
                                                                    }

                                                                      ?>
                                                                    </select>

                                                                </div>



                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">


                        <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Sub Category id</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtsubcategoryid" name="txtsubcategoryid" onchange="load_product()" placeholder="Subcategory ID Here" required>
                                                <option value="select_option">Select The Sub Category ID</option>

                                                </select>

                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtproductid" name="txtproductid" placeholder="Actual Product ID Here" required>
                                                <option value="select_option">Select product ID</option>
                                              </select>
                                            </div>

                                              </div>
                                              <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">

                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Quantity</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="txtquantity" name="txtquantity" min="1" placeholder="Quantity Here" required onkeypress="return NumberValidation(event)">
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Purchase Price</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="txtpurchaseprice" name="txtpurchaseprice" placeholder="Purchase Price Here" required onkeypress="return NumberValidation(event)">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=purchase.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
          <?php
          if (isset($_SESSION["session_purchaseid"]))
          {
            ?>
            <div class="table-responsive">
              <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Purchase ID</th>
                    <th>Product id</th>
                    <th>Quantity</th>
                    <th>Purchase Price</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $totalprice=0;
                  $sqlview="SELECT purchase_id ,product_id,quantity,purchase_price FROM purchase_product WHERE purchase_id='$_SESSION[session_purchaseid]'";
                  $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                  while($rowview=mysqli_fetch_assoc($resultview))
                  {
                    $sqlproductname="SELECT name FROM product WHERE product_id='$rowview[product_id]'";
                    $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                    $rowproductname=mysqli_fetch_assoc($resultproductname);

                    $subtotal=$rowview["quantity"]*$rowview["purchase_price"];
                    $totalprice=$totalprice+$subtotal;
                    echo'<tr>';
                      echo '<td>'.$rowview["purchase_id"].'</td>';
                      echo '<td>'.$rowproductname["name"].'</td>';
                      echo '<td>'.$rowview["quantity"].'</td>';
                      echo '<td>'.$rowview["purchase_price"].'</td>';
                      echo '<td>'.$subtotal.'</td>';
                      echo '<td>';
                        echo '<a href="index.php?pg=purchase_product.php&option=edit&pk1='.$rowview["purchase_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-info">Edit</button></a> ';
                        echo '<a onclick="return confirmdelete()" href="index.php?pg=purchase_product.php&option=delete&pk1='.$rowview["purchase_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-danger">Delete</button></a> ';
                      echo '</td>';
                    echo'</tr>';
                  }
                  echo'<tr>';
                    echo '<td>Total price</td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td>'.$totalprice.'</td>';
                    echo '<td>';
                    if($totalprice>0)
                    {
                      $_SESSION["session_purchase_amount"]=$totalprice;
                      echo '<a href="index.php?pg=purchase.php&option=add"><button class="btn btn-success">Finish</button></a> ';
                    }
                    echo '</td>';
                echo'</tr>';
                  ?>
                </tbody>
              </table>
            </div>
            <?php
          }
          ?>
        </section>
        <!-- form section end -->


        <?php
    }
    else if ($_GET["option"] == "view")
    {
      ?>
      <div class="card">
        <div class="card-body">
        <center>  <h5 class="card-title">Purchase Product View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=purchase_product.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Purchase ID</th>
                  <th>Product id</th>
                  <th>Quantity</th>
                  <th>Purchase Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT purchase_id ,product_id,quantity,purchase_price FROM purchase_product";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlproductname="SELECT name FROM product WHERE product_id='$rowview[product_id]'";
                  $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                  $rowproductname=mysqli_fetch_assoc($resultproductname);
                  echo'<tr>';
                    echo '<td>'.$rowview["purchase_id"].'</td>';
                    echo '<td>'.$rowproductname["name"].'</td>';
                    echo '<td>'.$rowview["quantity"].'</td>';
                    echo '<td>'.$rowview["purchase_price"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=purchase_product.php&option=fullview&pk1='.$rowview["purchase_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-success">View</button></a> ';
                      echo '<a href="index.php?pg=purchase_product.php&option=edit&pk1='.$rowview["purchase_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=purchase_product.php&option=delete&pk1='.$rowview["purchase_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
      $get_purchaseid=$_GET["pk1"];
      $get_productid=$_GET["pk2"];
    $sqlfullview = "SELECT * FROM purchase_product WHERE purchase_id ='$get_purchaseid' AND product_id='$get_productid'";
    $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
    $rowfullview=mysqli_fetch_assoc($resultfullview);

    $sqlproductname="SELECT name FROM product WHERE product_id='$rowfullview[product_id]'";
    $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
    $rowproductname=mysqli_fetch_assoc($resultproductname);
    ?>
    <div class="card">
    <div class="card-body">
      <center><h5 class="card-title">Purchase Product Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Purchase ID</th><td><?php echo $rowfullview["purchase_id"]; ?></td></tr>
          <tr><th>Product ID</th><td><?php echo $rowproductname["name"]; ?></td></tr>
          <tr><th>Quantity</th><td><?php echo $rowfullview["quantity"]; ?></td></tr>
          <tr><th>Purchase Price</th><td><?php echo $rowfullview["purchase_price"]; ?></td></tr>

          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=purchase_product.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <a href="index.php?pg=purchase_product.php&option=edit&pk1=<?php echo $rowfullview["purchase_id"];?>&pk2=<?php echo $rowfullview["product_id"];?>"><button class="btn btn-info">Edit</button></a>&nbsp;
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
      $get_purchaseid=$_GET["pk1"];
      $get_productid=$_GET["pk2"];
  $sqledit="SELECT * FROM purchase_product WHERE purchase_id = '$get_purchaseid' AND product_id = '$get_productid'";
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
                <center><h4 class="card-title">Edit Purchase Product</h4></center>

                <!-- field start -->
                <div class="form-group row">
                                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Purchase ID</label>
                                      <div class="col-sm-3">
                                          <select class="form-control" id="txtpurchaseid" name="txtpurchaseid" placeholder="Purchase id Here" readonly required>
                                          <?php
                                                $sqlload="SELECT DISTINCT purchase_id FROM purchase_product WHERE purchase_id='$rowedit[purchase_id]'";
                                                $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                              while( $rowload=mysqli_fetch_assoc($resultload))
                                              {
                                               echo '<option value="'.$rowload["purchase_id"].'">'.$rowload["purchase_id"].'</option>';
                                              }

                                                ?>


                                        </select>
                                      </div>
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Product ID</label>
                                      <div class="col-sm-3">
                                          <select class="form-control" id="txtproductid" name="txtproductid" placeholder="Product id Here" readonly required>

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
                                  </div>
                <!-- field end -->

                <!-- field start -->
                <div class="form-group row">
                                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Quantity</label>
                                      <div class="col-sm-3">
                                          <input type="number" class="form-control" id="txtquantity" name="txtquantity" min="1"placeholder="Quantity Here" value="<?php echo $rowedit["quantity"]; ?>" required onkeypress="return NumberValidation(event)">
                                      </div>

                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Purchase price</label>
                                      <div class="col-sm-3">
                                          <input type="number" class="form-control" id="txtpurchaseprice" name="txtpurchaseprice" placeholder="Purchase price Here" value="<?php echo $rowedit["purchase_price"]; ?>" required onkeypress="return NumberValidation(event)">
                                      </div>
                                  </div>
                <!-- field end -->


                <!-- button start -->
                <div class="form-group row">
                                      <div class="col-sm-12">
                    <center>
                      <a href ="index.php?pg=purchase_product.php&option=add"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
      $get_purchaseid =$_GET["pk1"];
      $get_productid =$_GET["pk2"];
    $sqldelete = "DELETE FROM purchase_product WHERE purchase_id ='$get_purchaseid' AND product_id='$get_productid'";
    $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
    if ($resultdelete)
    {
      echo '<script> alert("Record is Deleted");
            window.location.href="index.php?pg=purchase_product.php&option=add";</script>';
    }
    }
    }
    ?>
    </body>
