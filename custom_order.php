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
if (isset($_POST["btnsave"]))
{
  $target_dir = "file/custom_order/";
  $target_file = $target_dir . basename($_FILES["txtimage"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
  {
    echo '<script>alert("Sorry, only JPG, JPEG & PNG  files are allowed.");</script>';
  }
  else
  {
        $filename= $_POST["txtorderid"]."_".$_POST["txtimageid"].".".$imageFileType;
        $fileupload=$target_dir . $filename;
        move_uploaded_file($_FILES["txtimage"]["tmp_name"], $fileupload);
          $sqlinsert = "INSERT INTO custom_order(image_id,order_id,image,description,expect_price,quantity,status)
        VALUES('" . mysqli_real_escape_string($con, $_POST["txtimageid"]) . "',
              '" . mysqli_real_escape_string($con, $_POST["txtorderid"]) . "',
              '" . mysqli_real_escape_string($con, $filename) . "',
              '" . mysqli_real_escape_string($con, $_POST["txtdescription"]) . "',
              '" . mysqli_real_escape_string($con, $_POST["txtexpectprice"]) . "',
              '" . mysqli_real_escape_string($con, $_POST["txtquantity"]) . "',
              '" . mysqli_real_escape_string($con, "Pending") . "')";
          $resultinsert = mysqli_query($con, $sqlinsert) or die("sql error in sqlinsert" . mysqli_error($con));
          if ($resultinsert) {
              echo '<script> alert("Data stored successfully"); </script>';
          }
  }
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
  if(file_exists($_FILES["txtimage"]["tmp_name"])) //Chek if image update
  {
    $target_dir = "file/custom_order/";
    $target_file = $target_dir . basename($_FILES["txtimage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
    {
      echo '<script>alert("Sorry, only JPG, JPEG & PNG  files are allowed.");</script>';
    }
    else
    {
      $sqloldimage="SELECT image FROM custom_order WHERE image_id='".mysqli_real_escape_string($con,$_POST["txtimageid"])."'AND order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."'";
      $resultoldimage=mysqli_query($con,$sqloldimage) or die("Error in sqloldimage" . mysqli_error($con));
      $rowoldimage=mysqli_fetch_assoc($resultoldimage);
      unlink("file/custom_order/".$rowoldimage["image"]);

          $filename= $_POST["txtorderid"]."_".$_POST["txtimageid"].".".$imageFileType;
          $fileupload=$target_dir . $filename;
          move_uploaded_file($_FILES["txtimage"]["tmp_name"], $fileupload);
          $sqlupdate="UPDATE custom_order SET
                                  image='" . mysqli_real_escape_string($con, $filename) . "',
                                  description='" . mysqli_real_escape_string($con, $_POST["txtdescription"]) . "',
                                  quantity='" . mysqli_real_escape_string($con, $_POST["txtquantity"]) . "',
                                  status='" . mysqli_real_escape_string($con, $_POST["txtstatus"]) . "'
        				                  WHERE image_id='".mysqli_real_escape_string($con,$_POST["txtimageid"])."'AND order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."'";
        	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
        	if ($resultupdate)
        	{
        		echo '<script> alert("Data updated Sucessfully");
        				window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'";</script>';
        	}
    }
  }
  else
  {
    $sqlupdate="UPDATE custom_order SET
                            description='" . mysqli_real_escape_string($con, $_POST["txtdescription"]) . "',
                            quantity='" . mysqli_real_escape_string($con, $_POST["txtquantity"]) . "',
                            status='" . mysqli_real_escape_string($con, $_POST["txtstatus"]) . "'
  				                  WHERE image_id='".mysqli_real_escape_string($con,$_POST["txtimageid"])."'AND order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."'";
  	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
  	if ($resultupdate)
  	{
  		echo '<script> alert("Data updated Sucessfully");
  				window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'";</script>';
  	}
  }


}
//update code End

//Assign price code start
if(isset($_POST["btnassignprice"]))
{
  $acceptstatus=$_POST["txtacceptstatus"];

  if($system_usertype=="Admin")
  {
    if($acceptstatus=="Accept")
    {
      $sqlupdate="UPDATE custom_order SET
                              accept_price='" . mysqli_real_escape_string($con, $_POST["txtexpectprice"]) . "',
                              status='" . mysqli_real_escape_string($con, "Accepted") . "'
    				                  WHERE image_id='".mysqli_real_escape_string($con,$_POST["txtimageid"])."'AND order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."'";
    }
    else
    {
      $sqlupdate="UPDATE custom_order SET
                              accept_price='" . mysqli_real_escape_string($con, $_POST["txtyourprice"]) . "',
                              status='" . mysqli_real_escape_string($con, "Pending") . "'
    				                  WHERE image_id='".mysqli_real_escape_string($con,$_POST["txtimageid"])."'AND order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."'";
    }
    $resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
    if ($resultupdate)
    {
      echo '<script> alert("Data updated Sucessfully");
          window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'";</script>';
    }
  }

  if($system_usertype=="Customer")
  {
    if($acceptstatus=="Accept")
    {
      $sqlupdate="UPDATE custom_order SET
                              status='" . mysqli_real_escape_string($con, "Accepted") . "'
    				                  WHERE image_id='".mysqli_real_escape_string($con,$_POST["txtimageid"])."'AND order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."'";
    }
    else
    {
      $sqlupdate="UPDATE custom_order SET
                              expect_price='" . mysqli_real_escape_string($con, $_POST["txtyourprice"]) . "',
                              accept_price='" . mysqli_real_escape_string($con, "") . "',
                              status='" . mysqli_real_escape_string($con, "Pending") . "'
    				                  WHERE image_id='".mysqli_real_escape_string($con,$_POST["txtimageid"])."'AND order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."'";
    }
    $resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
    if ($resultupdate)
    {
      echo '<script> alert("Data updated Sucessfully");
          window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'";</script>';
    }
  }
}
?>
<script>
function enable_yourprice()
{
  var acceptstatus=document.getElementById("txtacceptstatus").value;
    document.getElementById("txtyourprice").value="";

  if(acceptstatus=="Accept")
  {
    document.getElementById("txtyourprice").readOnly=true;
  }
  else
  {
    document.getElementById("txtyourprice").readOnly=false;
  }
}
</script>
<body>
    <?php
if (isset($_GET["option"])) {
     if ($_GET["option"] == "view") {
        ?>
      <div class="card">
        <div class="card-body">
        <center>  <h5 class="card-title">Order Detail View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
            <?php 
              if(!isset($_GET["pr"]))
              {
              ?>
              <a href="print.php?pr=custom_order.php&option=view" target="_blank"><button class="btn btn-primary">Print</button></a>
              <br><br>
              <?php 
              }
              ?>
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer ID</th>
                  <th>Order Address</th>
                  <th>Status</th>
                  <?php
                  if(!isset($_GET["pr"]))
                  {
                  ?>
                  <th>Action</th>
                  <?php
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php
                if($system_usertype=="Admin"||$system_usertype=="Clerk")
                 {
                  $sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE order_id IN (SELECT DISTINCT order_id FROM custom_order)";
                 }
                
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowview[customer_id]'";
                  $resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
                  $rowcustomername=mysqli_fetch_assoc($resultcustomername);
                  echo'<tr>';
                    echo '<td>'.$rowview["order_id"].'</td>';
                    echo '<td>'.$rowcustomername["name"].'</td>';
                    echo '<td>'.$rowview["order_address"].'</td>';
                    echo '<td>'.$rowview["status"].'</td>';
                    if(!isset($_GET["pr"]))
                    {
                    echo '<td>';
                      echo '<a href="index.php?pg=order_detail.php&option=fullview&pk='.$rowview["order_id"].'"><button class="btn btn-success">View</button></a> ';
                      
                    echo '</td>';
                    }
                  echo'</tr>';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php
} else if ($_GET["option"] == "fullview")
{
  $get_imageid=$_GET["pk1"];
  $get_orderid=$_GET["pk2"];
$sqlfullview = "SELECT * FROM custom_order WHERE image_id ='$get_imageid' AND order_id ='$get_orderid'";
$resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
$rowfullview=mysqli_fetch_assoc($resultfullview);
?>
<div class="card">
<div class="card-body">
  <div class="table-responsive">
    <?php
    if(isset($_GET["pg"]))
    {
      ?>
				<a href="print.php?pr=custom_order.php&option=fullview&pk1=<?php echo $rowfullview["image_id"]; ?>&pk2=<?php echo $rowfullview["order_id"]; ?>" target="_blank"><button class="btn btn-info">Print</button></a>
      <?php
    }
    ?>
    <table id="zero_config" class="table table-striped table-bordered">
      <tr><th>Image ID</th><td><?php echo $rowfullview["image_id"]; ?></td></tr>
      <tr><th>Order ID</th><td><?php echo $rowfullview["order_id"]; ?></td></tr>
      <tr><th>Image</th><td><img src="file/custom_order/<?php echo $rowfullview["image"]; ?>?<?php echo date("H:i:s"); ?>" width="100" height="100"></td></tr>
      <tr><th>Description</th><td><?php echo $rowfullview["description"]; ?></td></tr>
      <tr><th>Expect Price</th><td><?php echo $rowfullview["expect_price"]; ?></td></tr>
      <tr><th>Accept Price</th><td><?php echo $rowfullview["accept_price"]; ?></td></tr>
      <tr><th>Quantity</th><td><?php echo $rowfullview["quantity"]; ?></td></tr>
      <tr><th>Status</th><td><?php echo $rowfullview["status"]; ?></td></tr>

    </table>
  </div>
</div>
</div>
<?php
}
 else if ($_GET["option"] == "edit")
{
  $get_imageid =$_GET["pk1"];
  $get_orderid  =$_GET["pk2"];
$sqledit = "SELECT * FROM custom_order WHERE image_id ='$get_imageid' AND order_id ='$get_orderid'";
$resultedit = mysqli_query($con,$sqledit) or die("Sqledit error ".mysqli_error($con));
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
              <center><h4 class="card-title">Edit Custom Order</h4></center>
              <!-- field start -->
              <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Image ID</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="txtimageid" name="txtimageid" placeholder="Image ID Here" required readonly value="<?php echo $rowedit["image_id"];?>">
                                    </div>

                <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Order ID</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order ID Here" required readonly>
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
                                </div>
              <!-- field end -->
              <!-- field start -->
              <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Image</label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control" id="txtimage" name="txtimage" placeholder="Upload Image Here">
                                    </div>

                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="txtdescription" name="txtdescription" placeholder="Describe Here" required value="<?php echo $rowedit["description"];?>">
                                    </div>
                                </div>
              <!-- field end -->
              <!-- field start -->
              <div class="form-group row">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Quantity</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" id="txtquantity" name="txtquantity" placeholder="Put Quantity Here" required value="<?php echo $rowedit["quantity"];?>" onkeypress="return NumberValidation(event)">
                                    </div>
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="txtstatus" name="txtstatus" placeholder="Status Here" readonly required value="<?php echo $rowedit["status"];?>">
                                    </div>
                                  </div>
              <!-- field end -->
              <!-- button start -->
              <div class="form-group row">
                  <div class="col-sm-12">
                  <center>
                    <a href ="index.php?pg=order_detail.php&option=fullview&pk=<?php echo $get_orderid; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
else if ($_GET["option"] == "assign_price")
{
 $get_imageid =$_GET["pk1"];
 $get_orderid  =$_GET["pk2"];
$sqledit = "SELECT * FROM custom_order WHERE image_id ='$get_imageid' AND order_id ='$get_orderid'";
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
             <center><h4 class="card-title">Edit Custom Order</h4></center>
             <!-- field start -->
             <div class="form-group row">
                                   <label for="fname" class="col-sm-3 text-right control-label col-form-label">Image ID</label>
                                   <div class="col-sm-3">
                                       <input type="text" class="form-control" id="txtimageid" name="txtimageid" placeholder="Image ID Here" required readonly value="<?php echo $rowedit["image_id"];?>">
                                   </div>

               <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Order ID</label>
                                   <div class="col-sm-3">
                                       <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order ID Here" required readonly>
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
                               </div>
             <!-- field end -->
             <!-- field start -->
               <div class="form-group row">
                                     <label for="fname" class="col-sm-3 text-right control-label col-form-label">Expect Price</label>
                                     <div class="col-sm-3">
                                         <input type="text" class="form-control" id="txtexpectprice" name="txtexpectprice" placeholder="Expect Price Here" required readonly value="<?php echo $rowedit["expect_price"];?>" onkeypress="return NumberValidation(event)">
                                     </div>
                                     <label for="fname" class="col-sm-3 text-right control-label col-form-label">Accept Price</label>
                                     <div class="col-sm-3">
                                         <input type="text" class="form-control" id="txtacceptprice" name="txtacceptprice" placeholder="Still not Assign Accept Price" readonly required value="<?php echo $rowedit["accept_price"];?>" onkeypress="return NumberValidation(event)">
                                     </div>

                                 </div>
               <!-- field end -->
             <!-- field start -->
             <div class="form-group row">
               <label for="fname" class="col-sm-3 text-right control-label col-form-label">Quantity</label>
                                   <div class="col-sm-3">
                                       <input type="number" class="form-control" id="txtquantity" name="txtquantity" placeholder="Put Quantity Here" readonly required value="<?php echo $rowedit["quantity"];?>" onkeypress="return NumberValidation(event)">
                                   </div>
               <label for="fname" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                   <div class="col-sm-3">
                                       <input type="text" class="form-control" id="txtstatus" name="txtstatus" placeholder="Status Here" readonly required value="<?php echo $rowedit["status"];?>">
                                   </div>
                                 </div>
             <!-- field end -->

             <!-- field start -->
               <div class="form-group row">
                                     <label for="fname" class="col-sm-3 text-right control-label col-form-label">Are You Accept/Reject Price?</label>
                                     <div class="col-sm-3">
                                         <select class="form-control" id="txtacceptstatus" name="txtacceptstatus" onchange="enable_yourprice()" placeholder="Expect Price Here" required>
                                           <option value="Accept">Accept</option>
                                           <option value="Reject">Reject</option>
                                         </select>
                                     </div>
                                     <label for="fname" class="col-sm-3 text-right control-label col-form-label">Your Price</label>
                                     <div class="col-sm-3">
                                         <input type="text" class="form-control" id="txtyourprice" name="txtyourprice" placeholder="Type Your Price" readonly required onkeypress="return NumberValidation(event)">
                                     </div>

                                 </div>
               <!-- field end -->

             <!-- button start -->
             <div class="form-group row">
                 <div class="col-sm-12">
                 <center>
                   <a href ="index.php?pg=order_detail.php&option=fullview&pk=<?php echo $get_orderid; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
                   <input type="reset" class="btn btn-danger" id="btncancel" name="btncancel" value="Cancel">
                   <input type="submit" class="btn btn-success" id="btnassignprice" name="btnassignprice" value="Assign Price">
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
    $get_imageid =$_GET["pk1"];
    $get_orderid  =$_GET["pk2"];

    $sqloldimage="SELECT image FROM custom_order WHERE image_id = '$get_imageid' AND order_id = '$get_orderid'";
    $resultoldimage=mysqli_query($con,$sqloldimage) or die ("Error in $sqloldimage" . mysqli_error($con));
    $rowoldimage=mysqli_fetch_assoc($resultoldimage);
    unlink("file/custom_order/".$rowoldimage["image"]);
  $sqldelete = "DELETE FROM custom_order WHERE image_id = '$get_imageid' AND order_id = '$get_orderid'";
  $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
  if ($resultdelete)
  {
    echo '<script> alert("Record is Deleted");
          window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$get_orderid.'";</script>';
  }
  }
  else if ($_GET["option"] == "reject")
 {
   $get_imageid =$_GET["pk1"];
   $get_orderid  =$_GET["pk2"];


 $sqldelete = "UPDATE custom_order SET status='Rejected' WHERE image_id = '$get_imageid' AND order_id = '$get_orderid'";
 $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
 if ($resultdelete)
 {
   echo '<script> alert("Price is Rejected");
         window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$get_orderid.'";</script>';
 }
 }
}
?>
</body>
