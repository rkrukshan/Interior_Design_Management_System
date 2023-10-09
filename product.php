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
if($system_usertype=="Admin"||$system_usertype=="Clerk")
{//Admin,Clerk Can Access This Page
include "config.php";
//insert sql start
if(isset($_POST["btnsave"]))
{
  $sqlinsert="INSERT INTO product(product_id,subcategory_id,name,description,material,minimum_alert)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtsubcategoryid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtname"])."',
        '".mysqli_real_escape_string($con,$_POST["txtdescription"])."',
        '".mysqli_real_escape_string($con,$_POST["txtmaterial"])."',
        '".mysqli_real_escape_string($con,$_POST["txtminimum_alert"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));


        //insert the product price
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
if(isset($_POST["btnsavechanges"]))
{
$sqlupdate="UPDATE product SET
              subcategory_id='".mysqli_real_escape_string($con,$_POST["txtsubcategoryid"])."',
              name='".mysqli_real_escape_string($con,$_POST["txtname"])."',
              description='".mysqli_real_escape_string($con,$_POST["txtdescription"])."',
              material='".mysqli_real_escape_string($con,$_POST["txtmaterial"])."',
              minimum_alert='".mysqli_real_escape_string($con,$_POST["txtminimum_alert"])."'
              WHERE product_id='".mysqli_real_escape_string($con,$_POST["txtproductid"])."'";
$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
if ($resultupdate)
{
  echo '<script> alert("Data updated Sucessfully");
      window.location.href="index.php?pg=product.php&option=fullview&pk='.$_POST["txtproductid"].'";</script>';
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
  		}
  	};
  	xmlhttp.open("GET", "ajaxpage.php?frompage=product_category&ajaxcategoryid=" + category_id, true);
  	xmlhttp.send();
  }
  else
  {//if not select any category
    document.getElementById("txtsubcategoryid").innerHTML='<option value="select_option">Select The Sub Category ID</option>';
  }
}
</script>

<script>
function submit_checkoption()
{
    var subcategory_id=document.getElementById("txtsubcategoryid").value;
    if (subcategory_id=="select_option")
    {
      alert ("please selct subcategory");
      return false;
    }
    else
    {
      return true;
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
                  <form class="form-horizontal" method="POST" action="" onsubmit="return submit_checkoption()">
                    <div class="card-body">
                      <center><h4 class="card-title">Add Product</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                            <div class="col-sm-3">
                                              <?php
                                              $sqlgenerateid="SELECT product_id FROM product ORDER BY product_id DESC LIMIT 1";
                                              $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                                              $n=mysqli_num_rows($resultgenerateid);//count the number of records
                                              if($n==1)
                                              {//for other than 1st time
                                                  $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                                                  $generateid=++$rowgenerateid["product_id"];
                                              }
                                              else
                                                {//For 1st time
                                                    $generateid="P0001";
                                                }
                                              ?>
                                                <input type="text" class="form-control" id="txtproductid" name="txtproductid" placeholder="Product id Here" readonly  value="<?php echo $generateid; ?>" required>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Name Here" required onkeypress="return TextValidation(event)">
                                            </div>


                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">

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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Sub Category id</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtsubcategoryid" name="txtsubcategoryid" placeholder="Subcategory ID Here" required>
                                                <option value="select_option">Select The Sub Category ID</option>

                                                </select>

                                            </div>
                                              </div>
                                              <!-- field end -->



                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Material</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtmaterial" name="txtmaterial" placeholder="Material Here" required>
                                            </div>

                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Minimum Alert</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtminimum_alert" name="txtminimum_alert" placeholder=" Minimum Alert Here" required onkeypress="return NumberValidation(event)">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Price</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtprice" name="txtprice" placeholder="Price Here" required onkeypress="return NumberValidation(event)">
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Offer</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtoffer" name="txtoffer" placeholder="Offer Here" required value="0" onkeypress="return NumberValidation(event)">
                                            </div>
                                        </div>
                      <!-- field end -->
                      <!-- field start -->
                      <div class="form-group row">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                        <div class="col-sm-3">
                                            <textarea class="form-control" id="txtdescription" name="txtdescription" rows="4" placeholder="Describe Here" required> </textarea>
                                        </div>
                                    </div>
                    <!-- field end -->
                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=product.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        <center>  <h5 class="card-title">Product View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=product.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Subcategory id</th>
                  <th>Name</th>
                  <th>Material</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT product_id ,subcategory_id,name,material FROM product";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlsubcategoryname="SELECT category_id,subcategory_name FROM subcategory WHERE subcategory_id='$rowview[subcategory_id]'";
                  $resultsubcategoryname=mysqli_query($con,$sqlsubcategoryname) or die ("Error in sqlsubcategoryname" . mysqli_error($con));
                  $rowsubcategoryname=mysqli_fetch_assoc($resultsubcategoryname);

                  $sqlcategoryname="SELECT category_name FROM category WHERE category_id='$rowsubcategoryname[category_id]'";
                  $resultcategoryname=mysqli_query($con,$sqlcategoryname) or die ("Error in sqlcategoryname" . mysqli_error($con));
                  $rowcategoryname=mysqli_fetch_assoc($resultcategoryname);
                  echo'<tr>';
                    echo '<td>'.$rowview["product_id"].'</td>';
                    echo '<td>'.$rowcategoryname["category_name"].' - '.$rowsubcategoryname["subcategory_name"].'</td>';
                    echo '<td>'.$rowview["name"].'</td>';
                    echo '<td>'.$rowview["material"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=product.php&option=fullview&pk='.$rowview["product_id"].'"><button class="btn btn-success">View</button></a> ';

                      $sqlcheckprice="SELECT product_id  FROM product_price WHERE product_id='$rowview[product_id]' AND end_date IS NULL";
                      $resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
                      $n=mysqli_num_rows($resultcheckprice);
                      if($n>0)
                      {
                        echo '<a href="index.php?pg=product.php&option=edit&pk='.$rowview["product_id"].'"><button class="btn btn-info">Edit</button></a> ';
                        echo '<a onclick="return confirmdelete()" href="index.php?pg=product.php&option=delete&pk='.$rowview["product_id"].'"><button class="btn btn-danger">Delete</button></a> ';
                      }
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
      $get_productid =$_GET["pk"];
      $sqlfullview = "SELECT * FROM product WHERE product_id='$get_productid'";
      $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
      $rowfullview=mysqli_fetch_assoc($resultfullview);

      $sqlsubcategoryname="SELECT subcategory_name,category_id FROM subcategory WHERE subcategory_id='$rowfullview[subcategory_id]'";
      $resultsubcategoryname=mysqli_query($con,$sqlsubcategoryname) or die ("Error in sqlsubcategoryname" . mysqli_error($con));
      $rowsubcategoryname=mysqli_fetch_assoc($resultsubcategoryname);

      $sqlcategoryname="SELECT category_name FROM category WHERE category_id='$rowsubcategoryname[category_id]'";
      $resultcategoryname=mysqli_query($con,$sqlcategoryname) or die ("Error in sqlcategoryname" . mysqli_error($con));
      $rowcategoryname=mysqli_fetch_assoc($resultcategoryname);
      ?>
      <div class="card">
      <div class="card-body">
      <center><h5 class="card-title">Product View</h5></center>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <tr><th>Product ID</th><td><?php echo $rowfullview["product_id"]; ?></td></tr>
          <tr><th>Subcategory ID</th><td><?php echo $rowcategoryname["category_name"].' - '.$rowsubcategoryname["subcategory_name"]; ?></td></tr>
          <tr><th>Name</th><td><?php echo $rowfullview["name"]; ?></td></tr>
          <tr><th>Description</th><td><?php echo $rowfullview["description"]; ?></td></tr>
          <tr><th>Material</th><td><?php echo $rowfullview["material"]; ?></td></tr>
          <tr><th>Minimum Alert</th><td><?php echo $rowfullview["minimum_alert"]; ?></td></tr>

          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=product.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <?php
                $sqlcheckprice="SELECT product_id  FROM product_price WHERE product_id='$get_productid' AND end_date IS NULL";
                $resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
                $n=mysqli_num_rows($resultcheckprice);
                if($n>0)
                {
                ?>
                <a href="index.php?pg=product.php&option=edit&pk=<?php echo $rowfullview["product_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;
                <?php
              }
                ?>
              </center>
            </td>
          </tr>
        </table>
      </div>
      </div>
      </div>

      <!--Product price-->
      <div class="card">
        <div class="card-body">
        <center>  <h5 class="card-title">Product Price View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <?php
              $sqlcheckprice="SELECT product_id  FROM product_price WHERE product_id='$get_productid' AND end_date IS NULL";
              $resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
              $n=mysqli_num_rows($resultcheckprice);
              if($n==0)
              {
                if($system_usertype=="Admin")
                {
              ?>
                <a href="index.php?pg=product_price.php&option=add&productid=<?php echo $rowfullview["product_id"]; ?>"><button class="btn btn-primary">Add Record</button></a>
                <br><br>
                <?php
                }
              }
                ?>
              <thead>
                <tr>
                  <th>N.O</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>price</th>
                  <th>Offer</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT * FROM product_price WHERE product_id='$get_productid' ORDER BY start_date DESC";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                $x=1;
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlproductname="SELECT name FROM product WHERE product_id='$rowview[product_id]'";
                  $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                  $rowproductname=mysqli_fetch_assoc($resultproductname);
                  echo'<tr>';
                    echo '<td>'.$x++.'</td>';
                    echo '<td>'.$rowview["start_date"].'</td>';
                    echo '<td>'.$rowview["end_date"].'</td>';
                    echo '<td>'.$rowview["price"].'</td>';
                    echo '<td>'.$rowview["offer"].'</td>';
                    echo '<td>';
                    if($rowview["end_date"]=="")
                    {
                      if($system_usertype=="Admin")
                      {
                      echo '<a href="index.php?pg=product_price.php&option=edit&pk1='.$rowview["product_id"].'&pk2='.$rowview["start_date"].'"><button class="btn btn-info">Edit</button></a> ';
                      }
                    }
                    echo '</td>';
                  echo'</tr>';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <center>  <h5 class="card-title">Product Image View</h5></center>
          <div class="row">
            <div class="col-lg-12">
                <?php
                $sqlcheckprice="SELECT product_id  FROM product_price WHERE product_id='$get_productid' AND end_date IS NULL";
                $resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
                $n=mysqli_num_rows($resultcheckprice);
                if($n>0)
                {
                ?>
                  <a href="index.php?pg=product_image.php&option=add&productid=<?php echo $rowfullview["product_id"]; ?>"><button class="btn btn-primary">Add Record</button></a>
                <?php
                }
                ?>
                <div class="row align-items-center latest_product_inner">
                  <?php
                  $sqlview="SELECT * FROM product_image WHERE product_id='$get_productid'";
                  $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                  while($rowview=mysqli_fetch_assoc($resultview))
                  {
                    ?>
              					<div class="col-md-3">
                          <!--change picture date("H:i:s") for cookie-->
              						<a href="file/product/<?php echo $rowview["image"]; ?>?<?php echo date("H:i:s"); ?>" class="img-pop-up img-gal">
              							<div class="single-gallery-image" style="background: url(file/product/<?php echo $rowview["image"]; ?>?<?php echo date("H:i:s"); ?>);"></div>
              						</a>
                          <?php
                          if($n>0)
                            {
                              echo '<a href="index.php?pg=product_image.php&option=edit&pk='.$rowview["image_id"].'"><button class="btn btn-info">Edit</button></a> ';
                              echo '<a onclick="return confirmdelete()" href="index.php?pg=product_image.php&option=delete&pk='.$rowview["image_id"].'"><button class="btn btn-danger">Delete</button></a> ';
                            }
                          ?>
              					</div>
                    <?php
                  }
                  ?>
              </div>
            </div>
        </div>
      </div>


      <?php
      }
      else if ($_GET["option"] == "edit")
      {
        $get_productid =$_GET["pk"];
        $sqledit = "SELECT * FROM product WHERE product_id='$get_productid'";
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
                      <center><h4 class="card-title">Edit Product</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtproductid" name="txtproductid" placeholder="Product id Here" required readonly value="<?php echo $rowedit["product_id"]; ?>">
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Name Here" required value="<?php echo $rowedit["name"]; ?>" onkeypress="return TextValidation(event)">
                                            </div>


                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Category id</label>
                                            <div class="col-sm-3">
                                              <select class="form-control" id="txtcategoryid" name="txtcategoryid" placeholder="category ID Here" onchange="load_subcategory()" required>

                                                <?php
                                                $sqlgetcategory="SELECT category_id FROM subcategory WHERE subcategory_id='$rowedit[subcategory_id]'";
                                                $resultgetcategory=mysqli_query($con,$sqlgetcategory) or die ("Error in sqlgetcategory" . mysqli_error($con));
                                                $rowgetcategory=mysqli_fetch_assoc($resultgetcategory);

                                                $sqlload="SELECT category_id,category_name FROM category";
                                                $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                              while( $rowload=mysqli_fetch_assoc($resultload))
                                              {
                                                if($rowload["category_id"]==$rowgetcategory["category_id"])
                                                {
                                                    echo '<option selected value="'.$rowload["category_id"].'">'.$rowload["category_name"].'</option>';
                                                }
                                                else {
                                                    echo '<option value="'.$rowload["category_id"].'">'.$rowload["category_name"].'</option>';
                                                }

                                              }

                                                ?>
                                              </select>
                                            </div>

                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Sub Category id</label>
                                                                <div class="col-sm-3">
                                                                    <select class="form-control" id="txtsubcategoryid" name="txtsubcategoryid" placeholder="Subcategory ID Here" required >
                                            <?php
                                                                      $sqlload="SELECT subcategory_id,subcategory_name FROM subcategory WHERE category_id='$rowgetcategory[category_id]'";
                                                                      $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                                                    while( $rowload=mysqli_fetch_assoc($resultload))
                                                                    {
                                              if($rowedit["subcategory_id"]==$rowload["subcategory_id"])
                                              {
                                                echo '<option selected value="'.$rowload["subcategory_id"].'">'.$rowload["subcategory_name"].'</option>';
                                              }
                                              else
                                              {
                                                echo '<option value="'.$rowload["subcategory_id"].'">'.$rowload["subcategory_name"].'</option>';
                                              }

                                                                    }

                                                                      ?>
                                            </select>
                                                                </div>


                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Material</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtmaterial" name="txtmaterial" placeholder="Material Here" required value="<?php echo $rowedit["material"]; ?>">
                                            </div>

                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Minimum Alert</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtminimum_alert" name="txtminimum_alert" placeholder=" Minimum Alert Here" required value="<?php echo $rowedit["minimum_alert"]; ?>" onkeypress="return NumberValidation(event)">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                            <div class="col-sm-3">
                                                <textarea class="form-control" id="txtdescription" name="txtdescription" placeholder="Describe Here" rows="4" required><?php echo $rowedit["description"]; ?></textarea>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=product.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
      $get_productid=$_GET["pk"];

      $sqllastprice="SELECT start_date FROM product_price WHERE product_id='$get_productid' AND end_date IS NULL";
      $resultlastprice=mysqli_query($con,$sqllastprice) or die ("Error in sqllastprice" . mysqli_error($con));
      $rowlastprice=mysqli_fetch_assoc($resultlastprice);
      $today=date("Y-m-d");


      $sqlupdate="UPDATE  product_price SET end_date='$today' WHERE product_id='$get_productid' AND start_date='$rowlastprice[start_date]'";
      $resultupdate=mysqli_query($con,$sqlupdate) or die ("Error in sqlupdate" . mysqli_error($con));

      if ($resultupdate)
      {
        echo '<script> alert("Record is Deleted");
              window.location.href="index.php?pg=product.php&option=view";</script>';
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
