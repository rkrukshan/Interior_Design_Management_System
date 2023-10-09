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
    $target_dir = "file/product/";
    $target_file = $target_dir . basename($_FILES["txtimage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
    {
      echo '<script>alert("Sorry, only JPG, JPEG & PNG  files are allowed.");</script>';
    }
    else
    {
          $filename=$_POST["txtimageid"].".".$imageFileType;
          $fileupload=$target_dir . $filename;
          move_uploaded_file($_FILES["txtimage"]["tmp_name"], $fileupload);

          $sqlinsert="INSERT INTO product_image(image_id,product_id,image)
          VALUES('".mysqli_real_escape_string($con,$_POST["txtimageid"])."',
                '".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
                '".mysqli_real_escape_string($con,$filename)."')";
        $resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
        if($resultinsert)
        {
          echo '<script> alert("Data stored successfully"); </script>';
        }
    }
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
  $target_dir = "file/product/";
  $target_file = $target_dir . basename($_FILES["txtimage"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
  {
    echo '<script>alert("Sorry, only JPG, JPEG & PNG  files are allowed.");</script>';
  }
  else
  {
      $sqloldimage="SELECT image FROM product_image WHERE image_id='$_POST[txtimageid]'";
      $resultoldimage=mysqli_query($con,$sqloldimage) or die ("Error in $sqloldimage" . mysqli_error($con));
      $rowoldimage=mysqli_fetch_assoc($resultoldimage);
      unlink("file/product/".$rowoldimage["image"]);
        $filename=$_POST["txtimageid"].".".$imageFileType;
        $fileupload=$target_dir . $filename;
        move_uploaded_file($_FILES["txtimage"]["tmp_name"], $fileupload);
        $sqlupdate="UPDATE product_image SET
               image='".mysqli_real_escape_string($con,$filename)."',
               product_id='".mysqli_real_escape_string($con,$_POST["txtproductid"])."'
              WHERE image_id='".mysqli_real_escape_string($con,$_POST["txtimageid"])."'";
        $resultupdate=mysqli_query($con,$sqlupdate) or die ("error in sqledit" . mysqli_error($con));
        if($resultupdate)
        {
          echo '<script> alert("Successfully Updated");
           window.location.href="index.php?pg=product.php&option=fullview&pk='.$_POST["txtproductid"].'";</script>';

        }
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
        $get_productid=$_GET["productid"];
		    ?>
        <!-- form section start -->
        <section class="feature_part padding_top">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                    <div class="card-body">
                      <center><h4 class="card-title">Add Product Image</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Image ID</label>
                                            <div class="col-sm-3">
                                              <?php
                                              $sqlgenerateid="SELECT image_id FROM product_image ORDER BY image_id DESC LIMIT 1";
                                              $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                                              $n=mysqli_num_rows($resultgenerateid);//count the number of records
                                              if($n==1)
                                              {//for other than 1st time
                                                  $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                                                  $generateid=++$rowgenerateid["image_id"];
                                              }
                                              else
                                                {//For 1st time
                                                    $generateid="IMG00001";
                                                }
                                              ?>
                                                <input type="text" class="form-control" id="txtimageid" name="txtimageid" placeholder="Image id Here" readonly  value="<?php echo $generateid; ?>" required>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtproductid" name="txtproductid" placeholder="Product ID Here" required>
                                                <?php
                                                $sqlload="SELECT product_id,name FROM product  WHERE product_id='$get_productid'";
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

                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Image</label>
                                            <div class="col-sm-3">
                                                <input type="file" class="form-control" id="txtimage" name="txtimage" placeholder="Image Here" required>
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
        <center>  <h5 class="card-title">Product Image View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=product_image.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Image ID</th>
                  <th>Product id</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT image_id,product_id,image FROM product_image";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlproductname="SELECT name FROM product WHERE product_id='$rowview[product_id]'";
                  $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                  $rowproductname=mysqli_fetch_assoc($resultproductname);
                  echo'<tr>';
                    echo '<td>'.$rowview["image_id"].'</td>';
                    echo '<td>'.$rowproductname["name"].'</td>';
                    echo '<td>'.$rowview["image"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=product_image.php&option=fullview&pk='.$rowview["image_id"].'"><button class="btn btn-success">View</button></a> ';
                      echo '<a href="index.php?pg=product_image.php&option=edit&pk='.$rowview["image_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=product_image.php&option=delete&pk='.$rowview["image_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
      $get_imageid =$_GET["pk"];
      $sqlfullview = "SELECT * FROM product_image WHERE image_id  ='$get_imageid'";
      $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
      $rowfullview=mysqli_fetch_assoc($resultfullview);

      $sqlproductname="SELECT name FROM product WHERE product_id='$rowfullview[product_id]'";
      $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
      $rowproductname=mysqli_fetch_assoc($resultproductname);
      ?>
      <div class="card">
      <div class="card-body">
      <center><h5 class="card-title">Product Image Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Image ID</th><td><?php echo $rowfullview["image_id"]; ?></td></tr>
          <tr><th>Product ID</th><td><?php echo $rowproductname["name"]; ?></td></tr>
          <tr><th>Image</th><td><?php echo $rowfullview["image"]; ?></td></tr>

          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=product_image.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <a href="index.php?pg=product_image.php&option=edit&pk=<?php echo $rowfullview["image_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

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
        $get_imageid =$_GET["pk"];
        $sqledit = "SELECT * FROM product_image WHERE image_id='$get_imageid'";
        $resultedit = mysqli_query($con,$sqledit) or die("Sqlfullview error ".mysqli_error($con));
        $rowedit=mysqli_fetch_assoc($resultedit);
        ?>
        <!-- form section start -->
        <section class="feature_part padding_top">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                    <div class="card-body">
                      <center><h4 class="card-title">Edit Product Image</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Image ID</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtimageid" name="txtimageid" placeholder="Image id Here" required value="<?php echo $rowedit["image_id"]; ?>" readonly>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Product ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtproductid" name="txtproductid" placeholder=" Product ID Here" required >
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

                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Image</label>
                                            <div class="col-sm-3">
                                                <input type="file" class="form-control" id="txtimage" name="txtimage" placeholder="Image Here" required value="<?php echo $rowedit["image"]; ?>">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=product.php&option=fullview&pk=<?php echo $rowedit["product_id"]; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        $get_imageid=$_GET["pk"];

        $sqloldimage="SELECT image,product_id FROM product_image WHERE image_id='$get_imageid'";
        $resultoldimage=mysqli_query($con,$sqloldimage) or die ("Error in $sqloldimage" . mysqli_error($con));
        $rowoldimage=mysqli_fetch_assoc($resultoldimage);
        unlink("file/product/".$rowoldimage["image"]);

        $sqldelete = "DELETE FROM product_image WHERE image_id ='$get_imageid'";
        $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
        if ($resultdelete)
        {
          echo '<script> alert("Record is Deleted");
                window.location.href="index.php?pg=product.php&option=fullview&pk='.$rowoldimage["product_id"].'";</script>';
        }
      }
      }
      ?>
      </body>
