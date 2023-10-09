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
  $sqlinsert="INSERT INTO order_product(order_id,product_id,quantity)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
         '".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtquantity"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
if($resultinsert)
{
  if (isset($_GET["edit_pk1"]))
  {
    $address="index.php?pg=order_detail.php&option=fullview&pk=".$_GET["edit_pk1"];
    echo '<script> alert("Data insert Sucessfully");
				window.location.href="'.$address.'";</script>';
  }
  else
  {
    if(isset($_SESSION["session_addtocart"]))
    {
      unset($_SESSION["session_addtocart"]);
    }
    if (!isset($_SESSION["session_orderid"]))
    {
      $_SESSION["session_orderid"]=$_POST["txtorderid"];
    }
   echo '<script> alert("Data stored successfully"); </script>';

  }

}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE order_product SET
          quantity='".mysqli_real_escape_string($con,$_POST["txtquantity"])."'
        WHERE order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."' AND product_id='".mysqli_real_escape_string($con,$_POST["txtproductid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
    if (isset($_GET["edit_pk1"]))
    {
      $address="index.php?pg=order_detail.php&option=fullview&pk=".$_POST["txtorderid"];
    }
    else
    {
        $address="index.php?pg=order_product.php&option=add";

    }
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="'.$address.'";</script>';

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
        document.getElementById("txtunitprice").value="";
  		}
  	};
  	xmlhttp.open("GET", "ajaxpage.php?frompage=product_category&ajaxcategoryid=" + category_id, true);
  	xmlhttp.send();
  }
  else
  {//if not select any category
    document.getElementById("txtsubcategoryid").innerHTML='<option value="select_option">Select The Sub Category ID</option>';
    document.getElementById("txtproductid").innerHTML='<option value="select_option">Select product ID</option>';
    document.getElementById("txtunitprice").value="";
  }
}
</script>

<script>
function load_product()
{
  var subcategory_id=document.getElementById("txtsubcategoryid").value;
  var order_id=document.getElementById("txtorderid").value;
  if (subcategory_id!="select_option")
  {//if select any subcategory

  	var xmlhttp = new XMLHttpRequest();
  	xmlhttp.onreadystatechange = function()
  	{
  		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
  		{
  			var get_response = xmlhttp.responseText.trim();
  			document.getElementById("txtproductid").innerHTML=get_response;
        document.getElementById("txtunitprice").value="";
  		}
  	};
  	xmlhttp.open("GET", "ajaxpage.php?frompage=order_product_subcategory&ajaxsubcategoryid=" + subcategory_id+"&ajaxorderid=" + order_id, true);
  	xmlhttp.send();
  }
  else
  {//if not select any subcategory
    document.getElementById("txtproductid").innerHTML='<option value="select_option">Select product ID</option>';
    document.getElementById("txtunitprice").value="";
  }
}
</script>

<script>
function load_unitprice()
{
  var product_id=document.getElementById("txtproductid").value;
  if (product_id!="select_option")
  {//if select any  product

  	var xmlhttp = new XMLHttpRequest();
  	xmlhttp.onreadystatechange = function()
  	{
  		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
  		{
  			var get_response = xmlhttp.responseText.trim();
        document.getElementById("txtunitprice").value=get_response;
  		}
  	};
  	xmlhttp.open("GET", "ajaxpage.php?frompage=order_product_product&ajaxproductid=" + product_id, true);
  	xmlhttp.send();
  }
  else
  {//if not select any product
    document.getElementById("txtunitprice").value="";
  }
}
</script>

<script>
function subtotal()
{
  var unitprice=document.getElementById("txtunitprice").value;
  var quantity=document.getElementById("txtquantity").value;
  var subtotal=+quantity * +unitprice;
  subtotal=subtotal.toFixed(2);
  document.getElementById("txtsubtotal").value=subtotal;
}
</script>
<script>
function reduce()
{
  var discount=document.getElementById("txtdiscountprice").value;
  var subtotal=document.getElementById("txtsubtotal").value;
  var final=+subtotal - +discount;
  document.getElementById("txtfinalprice").value=final;
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
                <form class="form-horizontal" method="POST" action="">
                  <div class="card-body">
                    <center><h4 class="card-title">Add Order Product</h4></center>
                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
                                          <div class="col-sm-3">
                                            <?php
                                            if (isset($_SESSION["session_orderid"]))
                                            {
                                              $generateid=$_SESSION["session_orderid"];
                                            }
                                            else if (isset($_GET["edit_pk1"]))
                                            {
                                              $generateid=$_GET["edit_pk1"];
                                            }
                                            else
                                            {
                                              $sqlgenerateid="SELECT order_id FROM order_product ORDER BY order_id DESC LIMIT 1";
                                              $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                                              $n=mysqli_num_rows($resultgenerateid);//count the number of records
                                              if($n==1)
                                              {//for other than 1st time
                                                  $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                                                  $generateid=++$rowgenerateid["order_id"];
                                              }
                                              else
                                                {//For 1st time
                                                    $generateid="OR00001";
                                                }
                                            }

                                            ?>
                                              <input type="text" class="form-control" id="txtorderid" name="txtorderid" placeholder="Order id Here" readonly  value="<?php echo $generateid; ?>" required>
                                          </div>
                                          <?php 
                                          if(isset($_SESSION["session_addtocart"]))
                                          {
                                            $sqlsessionsubcategory="SELECT subcategory_id FROM product WHERE product_id ='$_SESSION[session_addtocart]'";
                                            $resultsessionsubcategory=mysqli_query($con,$sqlsessionsubcategory) or die ("Error in sqlsessionsubcategory" . mysqli_error($con));
                                            $rowsessionsubcategory=mysqli_fetch_assoc($resultsessionsubcategory);

                                            $sqlsessioncategory="SELECT category_id FROM subcategory WHERE subcategory_id ='$rowsessionsubcategory[subcategory_id]'";
                                            $resultsessioncategory=mysqli_query($con,$sqlsessioncategory) or die ("Error in sqlsessioncategory" . mysqli_error($con));
                                            $rowsessioncategory=mysqli_fetch_assoc($resultsessioncategory);

                                            $sqlproductprice="SELECT price,offer FROM product_price WHERE product_id='$_SESSION[session_addtocart]' AND end_date IS NULL";//produts which are still available
                                            $resultproductprice=mysqli_query($con,$sqlproductprice) or die ("Error in sqlproductprice" . mysqli_error($con));
                                            $rowproductprice=mysqli_fetch_assoc($resultproductprice);

                                            $price=$rowproductprice["price"];
                                            $offer=$rowproductprice["offer"];
                                            if($offer>0)//if offer is applicable
                                            {									
                                              $unitprice=$price-(($price*$offer)/100);//price which is after applied  offer
                                            }
                                            else //if offer is not applicable
                                            {
                                              $unitprice=$price;//offer is not applicable
                                            }
                                          }
                                          else 
                                          {
                                            $unitprice="";//when session is not set 
                                          }
                                          ?>

                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Category id</label>
                                                              <div class="col-sm-3">
                                                                  <select class="form-control" id="txtcategoryid" name="txtcategoryid" placeholder="category ID Here" onchange="load_subcategory()" required>
                                                                 
                                                                    <?php
                                                                    if(isset($_SESSION["session_addtocart"]))
                                                                    {
                                                                      $sqlload="SELECT category_id,category_name FROM category WHERE category_id='$rowsessioncategory[category_id]'";
                                                                    }
                                                                    else 
                                                                    {
                                                                      echo ' <option value="select_option">Select The Category ID</option>';//if ot session set
                                                                      $sqlload="SELECT category_id,category_name FROM category";
                                                                    }
                                                                   
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
                                              
                                              <?php
                                                                    if(isset($_SESSION["session_addtocart"]))
                                                                    {
                                                                      $sqlload="SELECT subcategory_id,subcategory_name FROM subcategory WHERE subcategory_id='$rowsessionsubcategory[subcategory_id]'";
                                                                      $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                                                      while( $rowload=mysqli_fetch_assoc($resultload))
                                                                      {
                                                                        echo '<option value="'.$rowload["subcategory_id"].'">'.$rowload["subcategory_name"].'</option>';
                                                                      }
                                                                    }
                                                                    else 
                                                                    {
                                                                      echo '<option value="select_option">Select The Sub Category ID</option>';
                                                                    }
                                                                    ?>
                                              </select>

                                          </div>
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtproductid" name="txtproductid" onchange="load_unitprice()" placeholder="Actual Product ID Here" required>
                                              <?php 
                                              if(isset($_SESSION["session_addtocart"]))
                                              {
                                                $sqlload="SELECT product_id,name FROM product WHERE product_id='$_SESSION[session_addtocart]'";
                                                $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                                while( $rowload=mysqli_fetch_assoc($resultload))
                                                {
					                                        echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
                                                }
                                              }
                                              else 
                                              {
                                                echo '<option value="select_option">Select product ID</option>';
                                              }
                                              ?>
                                              
                                            </select>
                                          </div>

                                            </div>
                                            <!-- field end -->

                    <!-- field start -->
                    <div class="form-group row">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Unit Price</label>
                      <div class="col-sm-3">
                          <input type="text" class="form-control" id="txtunitprice" name="txtunitprice" value="<?php echo  $unitprice; ?>" placeholder="Unit Price Here" required readonly>
                      </div>
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Quantity</label>
                                          <div class="col-sm-3">
                                              <input type="number" class="form-control" id="txtquantity" name="txtquantity" placeholder="Quantity Here" required onkeypress="return NumberValidation(event)" oninput="subtotal()">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Sub Total</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtsubtotal" name="txtsubtotal" placeholder="Sub Total Here" required readonly>
                                        </div>
                                        
                    <!-- field end -->
                  &nbsp;  &nbsp;  &nbsp;
                    <!-- button start -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <center>
                          <?php
                            if (isset($_GET["edit_pk1"]))
                            {
                              $address="index.php?pg=order_detail.php&option=fullview&pk=".$_GET["edit_pk1"];
                            }
                            else
                            {
                              $address="index.php?pg=order_detail.php&option=view";

                            }
                          ?>
                          <a href ="<?php echo $address; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        if (isset($_SESSION["session_orderid"]))
        {
          //list all the order product
          ?>
          <div class="card">
            <div class="card-body">
            <center>  <h5 class="card-title">Order Product Details</h5></center>
              <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Order id</th>
                      <th>Product ID</th>
                      <th>Quantity</th>
                      <th>Unit Price</th>
                      <th>Sub Total</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $totalprice=0;
                    $sqlview="SELECT order_id,product_id,quantity FROM order_product WHERE order_id='$_SESSION[session_orderid]'";
                    $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                    while($rowview=mysqli_fetch_assoc($resultview))
                    {
                      $sqlproductname="SELECT name FROM product WHERE product_id='$rowview[product_id]'";
                      $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                      $rowproductname=mysqli_fetch_assoc($resultproductname);

                      $sqlcheckprice="SELECT price,offer  FROM product_price WHERE product_id='$rowview[product_id]' AND end_date IS NULL";
                      $resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
                      $rowcheckprice=mysqli_fetch_assoc($resultcheckprice);

                      if($rowcheckprice["offer"]>0)
                      {
                        $unitprice=$rowcheckprice["price"]-(($rowcheckprice["price"]*$rowcheckprice["offer"])/100);
                      }
                      else
                      {
                        $unitprice=$rowcheckprice["price"];
                      }
                       $unitprice=number_format((float)$unitprice, 2, '.', '');
                       $subtotal=$rowview["quantity"]*$unitprice;
                       $totalprice=$totalprice+$subtotal;
                      echo'<tr>';
                        echo '<td>'.$rowview["order_id"].'</td>';
                        echo '<td>'.$rowproductname["name"].'</td>';
                        echo '<td>'.$rowview["quantity"].'</td>';
                        echo '<td>'.$unitprice.'</td>';
                        echo '<td>'.$subtotal.'</td>';
                        echo '<td>';
                          echo '<a href="index.php?pg=order_product.php&option=edit&pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-info">Edit</button></a> ';
                          echo '<a onclick="return confirmdelete()" href="index.php?pg=order_product.php&option=delete&pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-danger">Delete</button></a> ';
                        echo '</td>';
                      echo'</tr>';
                    }
                    echo'<tr>';
                      echo '<td>Total Price</td>';
                      echo '<td></td>';
                      echo '<td></td>';
                      echo '<td></td>';
                      echo '<td>'.$totalprice.'</td>';
                        echo '<td>';
                        if($totalprice>0)
                        {
                          ?>
                          <a href="index.php?pg=order_detail.php&option=add"><button class="btn btn-primary">Finish</button></a>
                          <?php
                        }
                        echo '</td>';
                    echo'</tr>';
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
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
        <center>  <h5 class="card-title">Order Product View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=order_product.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Order id</th>
				  <th>Product ID</th>
                  <th>Quantity</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT order_id,product_id,quantity FROM order_product";
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
                      echo '<a href="index.php?pg=order_product.php&option=fullview&pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-success">View</button></a> ';
                      echo '<a href="index.php?pg=order_product.php&option=edit&pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=order_product.php&option=delete&pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
      $get_productid  =$_GET["pk2"];
  $sqlfullview = "SELECT * FROM order_product WHERE order_id ='$get_orderid' AND product_id ='$get_productid'";
  $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
  $rowfullview=mysqli_fetch_assoc($resultfullview);

  $sqlproductname="SELECT name FROM product WHERE product_id='$rowfullview[product_id]'";
  $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
  $rowproductname=mysqli_fetch_assoc($resultproductname);
  ?>
  <div class="card">
    <div class="card-body">
      <center><h5 class="card-title">Order Product Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Order ID</th><td><?php echo $rowproductname["name"]; ?></td></tr>
          <tr><th>Product ID</th><td><?php echo $rowfullview["product_id"]; ?></td></tr>
          <tr><th>Quantity</th><td><?php echo $rowfullview["quantity"]; ?></td></tr>
          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=order_product.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <a href="index.php?pg=order_product.php&option=edit&pk1=<?php echo $rowfullview["order_id"]; ?>&pk2=<?php echo $rowfullview["product_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;
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
      if (isset($_GET["edit_pk1"]))
      {
        $get_orderid =$_GET["edit_pk1"];
      }
      else
      {
        $get_orderid =$_GET["pk1"];
      }

      $get_productid  =$_GET["pk2"];
  $sqledit = "SELECT * FROM order_product WHERE order_id ='$get_orderid' AND product_id ='$get_productid'";
  $resultedit = mysqli_query($con,$sqledit) or die("Sqlfullview error ".mysqli_error($con));
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
                    <center><h4 class="card-title">Edit Order Product</h4></center>
                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order ID Here" required readonly>
                                                <?php
                                                $sqlload="SELECT Distinct order_id FROM order_product WHERE order_id='$rowedit[order_id]'";
                                                $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                              while( $rowload=mysqli_fetch_assoc($resultload))
                                              {
                                                echo '<option value="'.$rowload["order_id"].'">'.$rowload["order_id"].'</option>';
                                              }

                                                ?>
                                              </select>
                                          </div>

                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtproductid" name="txtproductid" placeholder="Product ID Here" required readonly>
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
                                              <input type="number" class="form-control" id="txtquantity" name="txtquantity" placeholder="Quantity Here" required value="<?php echo $rowedit["quantity"];?>" onkeypress="return NumberValidation(event)">
                                          </div>
                                      </div>
                    <!-- field end -->

                    <!-- button start -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <center>
                          <?php
                            if (isset($_GET["edit_pk1"]))
                            {
                              $address="index.php?pg=order_detail.php&option=fullview&pk=".$get_orderid;
                            }
                            else
                            {
                              $address="index.php?pg=order_product.php&option=add";

                            }
                          ?>
                          <a href ="<?php echo $address; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
      if (isset($_GET["edit_pk1"]))
      {
        $get_orderid =$_GET["edit_pk1"];
      }
      else
      {
        $get_orderid =$_GET["pk1"];
      }
      $get_productid =$_GET["pk2"];
	  $sqldelete = "DELETE FROM order_product WHERE order_id = '$get_orderid' AND product_id = '$get_productid'";
		$resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
		if ($resultdelete)
		{
      if (isset($_GET["edit_pk1"]))
      {
        $address="index.php?pg=order_detail.php&option=fullview&pk=".$get_orderid;
      }
      else
      {
          $address="index.php?pg=order_product.php&option=add";

      }
			echo '<script> alert("Record is Deleted");
						window.location.href="'.$address.'";</script>';
		}
    }
}
?>
</body>
