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
{//Admin and clerk can access this page
include "config.php";
//insert sql start
if(isset($_POST["btnsave"]))
{
  if($_POST["txtpaymode"]=="Cash")
  {
      $sqlinsert="INSERT INTO purchase(purchase_id,supplier_id,purchase_date,amount,pay_mode,pay_status)
      VALUES('".mysqli_real_escape_string($con,$_POST["txtpurchaseid"])."',
            '".mysqli_real_escape_string($con,$_POST["txtsupplierid"])."',
            '".mysqli_real_escape_string($con,$_POST["txtpurchasedate"])."',
            '".mysqli_real_escape_string($con,$_POST["txtamount"])."',
            '".mysqli_real_escape_string($con,$_POST["txtpaymode"])."',
            '".mysqli_real_escape_string($con,"Paid")."')";
    $resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
    if($resultinsert)
    {
      $sqlpurchaseproduct="SELECT product_id,quantity FROM purchase_product WHERE purchase_id='$_POST[txtpurchaseid]'";
      $resultpurchaseproduct=mysqli_query($con,$sqlpurchaseproduct) or die ("Error in sqlpurchaseproduct" . mysqli_error($con));
      while ($rowpurchaseproduct=mysqli_fetch_assoc($resultpurchaseproduct))
      {
        $sqlcheckstock="SELECT product_id,quantity FROM stock WHERE product_id='$rowpurchaseproduct[product_id]'";
        $resultcheckstock=mysqli_query($con,$sqlcheckstock) or die ("Error in sqlcheckstock" . mysqli_error($con));
        $n=mysqli_num_rows($resultcheckstock);
        if($n>0)
        {
          $rowcheckstock = mysqli_fetch_assoc($resultcheckstock);
          $newstock=$rowcheckstock["quantity"]+$rowpurchaseproduct["quantity"];

          $sqlupdate="UPDATE stock SET
                        quantity='".mysqli_real_escape_string($con,$newstock)."'
                        WHERE product_id='".mysqli_real_escape_string($con,$rowpurchaseproduct["product_id"])."'";
          $resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
        }
        else
        {
          $sqlinsert="INSERT INTO stock(product_id,quantity)
          VALUES('".mysqli_real_escape_string($con,$rowpurchaseproduct["product_id"])."',
                '".mysqli_real_escape_string($con,$rowpurchaseproduct["quantity"])."')";
        $resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
        }
      }


      unset($_SESSION["session_purchaseid"]);
      unset($_SESSION["session_purchase_amount"]);
      echo '<script> alert("Data stored successfully");
      window.location.href="index.php?pg=purchase.php&option=fullview&pk='.$_POST["txtpurchaseid"].'"; </script>';
    }
  }
  else
  {
    $target_dir = "file/purchase/";
    $target_file = $target_dir . basename($_FILES["txtuploadslip"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
    {
      echo '<script>alert("Sorry, only JPG, JPEG & PNG  files are allowed.");</script>';
    }
    else
    {
          $filename=$_POST["txtpurchaseid"].".".$imageFileType;
          $fileupload=$target_dir . $filename;
          move_uploaded_file($_FILES["txtuploadslip"]["tmp_name"], $fileupload);
          $sqlinsert="INSERT INTO purchase(purchase_id,supplier_id,purchase_date,amount,pay_mode,pay_status,upload_slip)
          VALUES('".mysqli_real_escape_string($con,$_POST["txtpurchaseid"])."',
                '".mysqli_real_escape_string($con,$_POST["txtsupplierid"])."',
                '".mysqli_real_escape_string($con,$_POST["txtpurchasedate"])."',
                '".mysqli_real_escape_string($con,$_POST["txtamount"])."',
                '".mysqli_real_escape_string($con,$_POST["txtpaymode"])."',
                '".mysqli_real_escape_string($con,"Paid")."',
                '".mysqli_real_escape_string($con,$filename)."')";
        $resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
        if($resultinsert)
        {
          $sqlpurchaseproduct="SELECT product_id,quantity FROM purchase_product WHERE purchase_id='$_POST[txtpurchaseid]'";
          $resultpurchaseproduct=mysqli_query($con,$sqlpurchaseproduct) or die ("Error in sqlpurchaseproduct" . mysqli_error($con));
          while ($rowpurchaseproduct=mysqli_fetch_assoc($resultpurchaseproduct))
          {
            $sqlcheckstock="SELECT product_id,quantity FROM stock WHERE product_id='$rowpurchaseproduct[product_id]'";
            $resultcheckstock=mysqli_query($con,$sqlcheckstock) or die ("Error in sqlcheckstock" . mysqli_error($con));
            $n=mysqli_num_rows($resultcheckstock);
            if($n>0)
            {
              $rowcheckstock = mysqli_fetch_assoc($resultcheckstock);
              $newstock=$rowcheckstock["quantity"]+$rowpurchaseproduct["quantity"];

              $sqlupdate="UPDATE stock SET
                            quantity='".mysqli_real_escape_string($con,$newstock)."'
                            WHERE product_id='".mysqli_real_escape_string($con,$rowpurchaseproduct["product_id"])."'";
              $resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
            }
            else
            {
              $sqlinsert="INSERT INTO stock(product_id,quantity)
              VALUES('".mysqli_real_escape_string($con,$rowpurchaseproduct["product_id"])."',
                    '".mysqli_real_escape_string($con,$rowpurchaseproduct["quantity"])."')";
            $resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
            }
          }


          unset($_SESSION["session_purchaseid"]);
          unset($_SESSION["session_purchase_amount"]);
          echo '<script> alert("Data stored successfully");
          window.location.href="index.php?pg=purchase.php&option=fullview&pk='.$_POST["txtpurchaseid"].'";</script>';
        }
      }
  }

}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE purchase SET
                              supplier_id='".mysqli_real_escape_string($con,$_POST["txtsupplierid"])."',
                              purchase_date='".mysqli_real_escape_string($con,$_POST["txtpurchasedate"])."',
                              amount='".mysqli_real_escape_string($con,$_POST["txtamount"])."',
                              pay_mode='".mysqli_real_escape_string($con,$_POST["txtpaymode"])."',
                              pay_status='".mysqli_real_escape_string($con,$_POST["txtpaystatus"])."',
                              upload_slip='".mysqli_real_escape_string($con,$_POST["txtuploadslip"])."'
								WHERE purchase_id='".mysqli_real_escape_string($con,$_POST["txtpurchaseid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=purchase.php&option=fullview&pk='.$_POST["txtpurchaseid"].'";</script>';
	}

}
//update code End
?>
<script>
function active_slip()
{
  var paymode=document.getElementById("txtpaymode").value;
  if(paymode=="Cash")
  {
    document.getElementById("txtuploadslip").type="text";
    document.getElementById("txtuploadslip").readOnly=true;
  }
  else
  {
    document.getElementById("txtuploadslip").type="file";
    document.getElementById("txtuploadslip").readOnly=false;
  }
}
</script>



<script>
//load paymode
function loadpaymode()
{
	
	var paymode=document.getElementById("txtpaymode").value;
	var xmlhttp = new XMLHttpRequest();//start ajax
	xmlhttp.onreadystatechange = function()//check if ready
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)//checkresponce
		{
			var get_response = xmlhttp.responseText.trim();//get responce
			location.reload();//action
		}
	};
	xmlhttp.open("GET", "ajaxpage.php?frompage=paymode&ajaxpaymode=" + paymode, true);//send ajax
	xmlhttp.send();
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
                  <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                    <div class="card-body">
                      <center><h4 class="card-title">Add Purchase Details</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Purchase ID</label>
                                            <div class="col-sm-3">
                                              <?php
                                              $generateid=$_SESSION["session_purchaseid"];
                                              ?>
                                                <input type="text" class="form-control" id="txtpurchaseid" name="txtpurchaseid" placeholder="Purchase id Here" readonly  value="<?php echo $generateid; ?>" required>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Supplier ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtsupplierid" name="txtsupplierid" placeholder="Supplier ID Here" required>
                                                  <option value="select_option">Select The Supplier ID</option>
                                                <?php
                                                $sqlload="SELECT supplier_id,name FROM Supplier";
                                                $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                              while( $rowload=mysqli_fetch_assoc($resultload))
                                              {
                                                echo '<option value="'.$rowload["supplier_id"].'">'.$rowload["name"].'</option>';
                                              }

                                                ?>
                                              </select>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Purchase Date</label>
                                          <div class="col-sm-3">
                                              <input type="date" class="form-control" id="txtpurchasedate" name="txtpurchasedate" value="<?php echo date("Y-m-d"); ?>" readonly placeholder="Purchase Date Here" required>
                                          </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Amount</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="txtamount" name="txtamount" placeholder="Amount Here" value=<?php echo $_SESSION["session_purchase_amount"]; ?> readonly required onkeypress="return NumberValidation(event)">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Pay Mode</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtpaymode" name="txtpaymode" onchange="active_slip()" placeholder="Pay Mode Here" required>
                                                <option value="Cash">Cash</option>
                                                <option value="Bank">Bank</option>
                                              </select>
                                          </div>
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Upload Slip</label>
                                          <div class="col-sm-3">
                                              <input type="text" readonly class="form-control" id="txtuploadslip" name="txtuploadslip" placeholder=" Upload Slip Here" required>
                                          </div>
                                        </div>
                      <!-- field end -->



                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=purchase_product.php&option=add"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        <center>  <h5 class="card-title">Purchase View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=purchase_product.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>


              <div class="col-sm-3">
										<label> Paymode</label>
											<select class="form-control" id="txtpaymode" onchange="loadpaymode()" name="txtpaymode" >
											<option value="All">All</option>
											<?php 
											$paymodearray=array("Cash","Bank");//designation array
											for($x=0;$x<count($paymodearray);$x++)//loop array
											{
												if(isset($_SESSION["pay_mode"]))//check session
												{
													if($paymodearray[$x]==$_SESSION["pay_mode"])//check
													{
														echo'<option selected value="'.$paymodearray[$x].'" >'.$paymodearray[$x].' </option>';
													}
													else 
													{//if not set session display all
														echo'<option value="'.$paymodearray[$x].'" >'.$paymodearray[$x].' </option>';
													}
													
												}
												else //if not set session display all
												{
													echo'<option value="'.$paymodearray[$x].'" >'.$paymodearray[$x].' </option>';
												}
												
											}
											?>
											</select>
              </div>


              <thead>
                <tr>
                  <th>Purchase ID</th>
                  <th>Supplier id</th>
                  <th>Amount</th>
                  <th>Pay Mode</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php

          if(isset($_SESSION["pay_mode"]))//if session was set 
							{
								if($_SESSION["pay_mode"]=="All")//session's value all display all
								{
									$sqlview="SELECT purchase_id,supplier_id,amount,pay_mode FROM purchase";
								}
								else 
								{//if not  session value's all then display perticular paymode
									$sqlview="SELECT purchase_id,supplier_id,amount,pay_mode FROM purchase WHERE pay_mode='$_SESSION[pay_mode]'";
								}
								
							}
							else //if not set session show all paymode
							{
								$sqlview="SELECT purchase_id,supplier_id,amount,pay_mode FROM purchase";
							}
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlsuppliername="SELECT name FROM supplier WHERE supplier_id='$rowview[supplier_id]'";
                  $resultsuppliername=mysqli_query($con,$sqlsuppliername) or die ("Error in sqlsuppliername" . mysqli_error($con));
                  $rowsuppliername=mysqli_fetch_assoc($resultsuppliername);
                  echo'<tr>';
                    echo '<td>'.$rowview["purchase_id"].'</td>';
                    echo '<td>'.$rowsuppliername["name"].'</td>';
                    echo '<td>'.$rowview["amount"].'</td>';
                    echo '<td>'.$rowview["pay_mode"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=purchase.php&option=fullview&pk='.$rowview["purchase_id"].'"><button class="btn btn-success">View</button></a> ';
                    //  echo '<a href="index.php?pg=purchase.php&option=edit&pk='.$rowview["purchase_id"].'"><button class="btn btn-info">Edit</button></a> ';
                    //  echo '<a onclick="return confirmdelete()" href="index.php?pg=purchase.php&option=delete&pk='.$rowview["purchase_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
      $get_purchaseid =$_GET["pk"];
      $sqlfullview = "SELECT * FROM purchase WHERE purchase_id='$get_purchaseid'";
      $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
      $rowfullview=mysqli_fetch_assoc($resultfullview);

      $sqlsuppliername="SELECT name FROM supplier WHERE supplier_id='$rowfullview[supplier_id]'";
      $resultsuppliername=mysqli_query($con,$sqlsuppliername) or die ("Error in sqlsuppliername" . mysqli_error($con));
      $rowsuppliername=mysqli_fetch_assoc($resultsuppliername);
      ?>
      <div class="card">
      <div class="card-body">
      <center><h5 class="card-title">Purchase View</h5></center>
      <div class="table-responsive">
        <table  class="table table-striped table-bordered">
          <tr><th>Purchase ID</th><td><?php echo $rowfullview["purchase_id"]; ?></td></tr>
          <tr><th>Supplier ID</th><td><?php echo $rowsuppliername["name"]; ?></td></tr>
          <tr><th>Purchase Date</th><td><?php echo $rowfullview["purchase_date"]; ?></td></tr>
          <tr><th>Amount</th><td><?php echo $rowfullview["amount"]; ?></td></tr>
          <tr><th>Pay Mode</th><td><?php echo $rowfullview["pay_mode"]; ?></td></tr>
          <tr><th>Pay status</th><td><?php echo $rowfullview["pay_status"]; ?></td></tr>
          <?php
          if ($rowfullview["upload_slip"]!="")
           {
             ?>
                <tr><th>Upload Slip</th>
                  <td>
                    <a href="file/purchase/<?php echo $rowfullview["upload_slip"]; ?>?<?php echo date("H:i:s"); ?>" class="img-pop-up img-gal">
                      <div class="single-gallery-image" style="background: url(file/purchase/<?php echo $rowfullview["upload_slip"]; ?>?<?php echo date("H:i:s"); ?>);"></div>
                    </a>
                  </td>
                </tr>
             <?php
          }
          ?>



          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=purchase.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <!--<a href="index.php?pg=purchase.php&option=edit&pk=<?php echo $rowfullview["purchase_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;-->

              </center>
            </td>
          </tr>
        </table>
      </div>
      </div>
      </div>
      <!-- purchase product details-->
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Purchase ID</th>
              <th>Product id</th>
              <th>Quantity</th>
              <th>Purchase Price</th>
              <th>Sub Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $totalprice=0;
            $sqlview="SELECT purchase_id ,product_id,quantity,purchase_price FROM purchase_product WHERE purchase_id='$rowfullview[purchase_id]'";
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
              echo'</tr>';
            }
            echo'<tr>';
              echo '<td>Total price</td>';
              echo '<td></td>';
              echo '<td></td>';
              echo '<td></td>';
              echo '<td>'.$totalprice.'</td>';
          echo'</tr>';
            ?>
          </tbody>
        </table>
      </div>
      <?php
      }
      else if ($_GET["option"] == "edit")
      {
        $get_purchaseid =$_GET["pk"];
        $sqledit = "SELECT * FROM purchase WHERE purchase_id='$get_purchaseid'";
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
                      <center><h4 class="card-title">Edit Purchase Details</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Purchase ID</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtpurchaseid" name="txtpurchaseid" placeholder="Purchase id Here" required readonly value="<?php echo $rowedit["purchase_id"]; ?>">
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Supplier ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtsupplierid" name="txtsupplierid" placeholder="Supplier ID Here" required  >
						                                     <?php
                                                $sqlload="SELECT supplier_id,name FROM Supplier";
                                                $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                              while( $rowload=mysqli_fetch_assoc($resultload))
                                              {
												  if($rowedit["supplier_id"]==$rowload["supplier_id"])
												  {
													echo '<option selected value="'.$rowload["supplier_id"].'">'.$rowload["name"].'</option>';
												  }
												  else
												  {
													echo '<option value="'.$rowload["supplier_id"].'">'.$rowload["name"].'</option>';
												  }

                                              }

                                                ?>
												</select>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Purchase Date</label>
                                          <div class="col-sm-3">
                                              <input type="date" class="form-control" id="txtpurchasedate" name="txtpurchasedate" placeholder="Purchase Date Here" required value="<?php echo $rowedit["purchase_date"]; ?>">
                                          </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Amount</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="txtamount" name="txtamount" placeholder="Amount Here" required value="<?php echo $rowedit["amount"]; ?>" onkeypress="return NumberValidation(event)">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Pay Mode</label>
                                          <div class="col-sm-3">
                                              <input type="text" class="form-control" id="txtpaymode" name="txtpaymode" placeholder="Pay Mode Here" required value="<?php echo $rowedit["pay_mode"]; ?>">
                                          </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Pay Status</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtpaystatus" name="txtpaystatus" placeholder="Pay Status Here" required value="<?php echo $rowedit["pay_status"]; ?>">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Upload Slip</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtuploadslip" name="txtuploadslip" placeholder=" Upload Slip Here" required value="<?php echo $rowedit["upload_slip"]; ?>">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=purchase.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
      $get_purchaseid=$_GET["pk"];
      $sqldelete = "DELETE FROM purchase WHERE purchase_id='$get_purchaseid'";
      $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
      if ($resultdelete)
      {
        echo '<script> alert("Record is Deleted");
              window.location.href="index.php?pg=purchase.php&option=view";</script>';
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
