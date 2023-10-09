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
//insert code start
if(isset($_POST["btnsave"]))
{
  if($system_usertype=="Customer")
  {
    $paystatus="Pending";
    $filecheck="Yes";
  }
  else
  {
    if ($_POST["txtpaymode"]=="Cash")
    {
      $paystatus="Paid";
      $insert="Yes";
      $filecheck="No";
      $filename="";
    }
    else
    {
      $paystatus="Pending";
      $filecheck="Yes";
    }
  }
  if($filecheck=="Yes")
  {
    $target_dir = "file/bill/";
    $target_file = $target_dir . basename($_FILES["txtuploadslip"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
    {
      $insert="No";
      echo '<script>alert("Sorry, only JPG, JPEG & PNG  files are allowed.");</script>';
    }
    else
    {
          $filename=$_POST["txtbillid"].".".$imageFileType;
          $fileupload=$target_dir . $filename;
          move_uploaded_file($_FILES["txtuploadslip"]["tmp_name"], $fileupload);

          $insert="Yes";
    }
  }

  if($insert=="Yes")
  {
    if ($_POST["txtpaymode"]=="Cheque")
    {
      $chequedate=$_POST["txtchequedate"];
    }
    else
    {
      $chequedate="";
    }

        $sqlinsert="INSERT INTO bill(bill_id,order_id,create_date,amount,pay_mode,pay_status,pay_date,upload_slip,cheque_date)
        VALUES('".mysqli_real_escape_string($con,$_POST["txtbillid"])."',
              '".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
              '".mysqli_real_escape_string($con,$_POST["txtcreatedate"])."',
              '".mysqli_real_escape_string($con,$_POST["txtamount"])."',
              '".mysqli_real_escape_string($con,$_POST["txtpaymode"])."',
              '".mysqli_real_escape_string($con,$paystatus)."',
              '".mysqli_real_escape_string($con,$_POST["txtpaydate"])."',
              '".mysqli_real_escape_string($con,$filename)."',
              '".mysqli_real_escape_string($con,$chequedate)."')";
      $resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
      if($resultinsert)
      {
        echo '<script> alert("Data stored successfully");
        window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'";</script>';
      }
    }
}
//insert code end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE bill SET
  order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
  create_date='".mysqli_real_escape_string($con,$_POST["txtcreatedate"])."',
  amount='".mysqli_real_escape_string($con,$_POST["txtamount"])."',
  pay_mode='".mysqli_real_escape_string($con,$_POST["txtpaymode"])."',
  pay_status='".mysqli_real_escape_string($con,$_POST["txtpaystatus"])."',
  pay_date='".mysqli_real_escape_string($con,$_POST["txtpaydate"])."',
  upload_slip='".mysqli_real_escape_string($con,$_POST["txtuploadslip"])."',
  cheque_date='".mysqli_real_escape_string($con,$_POST["txtchequedate"])."'
  WHERE bill_id='".mysqli_real_escape_string($con,$_POST["txtbillid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=bill.php&option=fullview&pk='.$_POST["txtbillid"].'";</script>';
  }

}
//update code End
?>
<script>
function active_payslip()
{
  var paymode=document.getElementById("txtpaymode").value;
  document.getElementById("txtchequedate").value="";
  if(paymode=="Cash")
  {
    document.getElementById("txtuploadslip").type="text";//make input type as (file to text)
    document.getElementById("txtuploadslip").readOnly=true;//make that input type as read only
    document.getElementById("txtchequedate").readOnly=true;//make input type as readonly
  }
  else if(paymode=="Bank")
  {
    document.getElementById("txtuploadslip").type="file";//if paymode is bank make input type as file 
    document.getElementById("txtuploadslip").readOnly=false;//disable read only
    document.getElementById("txtchequedate").readOnly=true;//make that input type as read only
  }
  else
   {
     document.getElementById("txtuploadslip").type="file";//if cheque inputfield as file
     document.getElementById("txtuploadslip").readOnly=false;//disable read only
     document.getElementById("txtchequedate").readOnly=false;//disable read only
   }
}
</script>
<body>
    <?php
if (isset($_GET["option"]))
{
    if ($_GET["option"] == "add")
    {
      $get_orderid =$_GET["pk"];
      $get_totalprice =$_GET["totalprice"];
      $sqlpaidamount="SELECT SUM(amount) AS t_amount FROM bill WHERE order_id='$get_orderid' AND pay_status='Paid'";
      $resultpaidamount=mysqli_query($con,$sqlpaidamount) or die ("error in sqlpaidamount" .mysqli_error($con));
      $rowpaidamount=mysqli_fetch_assoc($resultpaidamount);
      if ($rowpaidamount["t_amount"]==0)
      {
        $sofarpaid=0;//if not paid anything
      }
      else
      {
        $sofarpaid=$rowpaidamount["t_amount"];//for total payment
      }

    $balanceamount=$get_totalprice-$rowpaidamount["t_amount"];//for remaining payment

    $balanceamount=number_format((float)$balanceamount, 2, '.', '');//for price
      ?>
      <!-- form section start -->
      <section class="feature_part padding_top">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                  <div class="card-body">
                    <center><h4 class="card-title">Add Bill</h4></center>
                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Bill ID</label>
                                          <div class="col-sm-3">
                                            <?php
                                            $sqlgenerateid="SELECT bill_id FROM bill ORDER BY bill_id DESC LIMIT 1";
                                            $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                                            $n=mysqli_num_rows($resultgenerateid);//count the number of records
                                            if($n==1)
                                            {//for except 1st time
                                                $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                                                $generateid=++$rowgenerateid["bill_id"];
                                            }
                                            else
                                              {//For 1st time
                                                  $generateid="B00001";
                                              }
                                            ?>
                                              <input type="text" class="form-control" id="txtbillid" name="txtbillid" placeholder="Bill ID Here" readonly  value="<?php echo $generateid; ?>" required>
                                          </div>

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Order ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order ID Here" required>

                                            <?php
                                            $sqlload="SELECT order_id FROM order_detail WHERE order_id='$get_orderid'";//for load a perticular orderid
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
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Created Date</label>
                                          <div class="col-sm-3">
                                              <input type="date" class="form-control" id="txtcreatedate" name="txtcreatedate" placeholder="Created Date Here" value="<?php echo date("Y-m-d"); ?>" readonly required>
                                          </div>

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Total Amount</label>
                                          <div class="col-sm-3">
                                              <input type="number" class="form-control" id="txttotalamount" name="txttotalamount" placeholder="Amount Here" value="<?php echo $get_totalprice; ?>" readonly required onkeypress="return NumberValidation(event)">
                                          </div>
                                      </div>
                    <!-- field end -->


                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">So Far Paid Amount</label>
                                          <div class="col-sm-3">
                                              <input type="number" class="form-control" id="txtpaidamount" name="txtpaidamount" placeholder="Created Date Here" value="<?php echo $sofarpaid; ?>" readonly required>
                                          </div>

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Balance Amount</label>
                                          <div class="col-sm-3">
                                              <input type="number" class="form-control" id="txtbalanceamount" name="txtbalanceamount" placeholder="Amount Here" value="<?php echo $balanceamount; ?>" readonly required onkeypress="return NumberValidation(event)">
                                          </div>
                                      </div>
                    <!-- field end -->
                    <!-- field start -->
                    <div class="form-group row">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Amount</label>
                                          <div class="col-sm-3">
                                              <input type="number" class="form-control" id="txtamount" name="txtamount" placeholder="Amount Here" step="0.01" min="1" max="<?php echo $balanceamount; ?>" required onkeypress="return NumberValidation(event)">
                                          </div>
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Pay date</label>
                                                              <div class="col-sm-3">
                                                                  <input type="date" class="form-control" id="txtpaydate" name="txtpaydate" placeholder="Pay Date Here" value="<?php echo date("Y-m-d"); ?>" readonly required>
                                                              </div>


                                      </div>
                    <!-- field end -->
                    <!-- field start -->
                    <div class="form-group row">

                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Pay Mode</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtpaymode" name="txtpaymode" placeholder="Pay Mode Here" onchange="active_payslip()" required>
                                                <?php
                                                  if($system_usertype=="Customer")
                                                  {
                                                    echo '<option value="Bank"> Bank</option>';
                                                    echo '<option value="Cheque"> Cheque</option>';

                                                    $inputtype="file";
                                                    $readonlystatus="";
                                                  }
                                                  else
                                                  {
                                                    echo '<option value="Cash"> Cash</option>';
                                                    echo '<option value="Bank"> Bank</option>';
                                                    echo '<option value="Cheque"> Cheque</option>';
                                                    $inputtype="text";
                                                    $readonlystatus="readonly";
                                                  }
                                                ?>
                                              </select>
                                          </div>
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Upload Slip</label>
                                          <div class="col-sm-3">
                                              <input type="<?php echo $inputtype; ?>" <?php echo $readonlystatus; ?>  class="form-control" id="txtuploadslip" name="txtuploadslip" placeholder="Upload Slip Here" required>
                                          </div>
                                          
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Cheque Date</label>
                                          <div class="col-sm-3">
                                              <input type="date" readonly class="form-control" min="<?php echo date("Y-m-d"); ?>" id="txtchequedate" name="txtchequedate" placeholder="Cheque Date Here" required>
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
        <center>  <h5 class="card-title">Bill View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=bill.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Bill ID</th>
                  <th>Order id</th>
                  <th>Amount</th>
                  <th>Pay Mode</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody><!--within the table-->
                <?php
                $sqlview="SELECT bill_id ,order_id,amount,pay_mode FROM bill";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  echo'<tr>';
                    echo '<td>'.$rowview["bill_id"].'</td>';
                    echo '<td>'.$rowview["order_id"].'</td>';
                    echo '<td>'.$rowview["amount"].'</td>';
                    echo '<td>'.$rowview["pay_mode"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=bill.php&option=fullview&pk='.$rowview["bill_id"].'"><button class="btn btn-success">View</button></a> ';//go to specific billid's view
                      echo '<a href="index.php?pg=bill.php&option=edit&pk='.$rowview["bill_id"].'"><button class="btn btn-info">Edit</button></a> ';//go to specific billid's edit
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=bill.php&option=delete&pk='.$rowview["bill_id"].'"><button class="btn btn-danger">Delete</button></a> ';//go to specific billid's delete
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
      $get_billid =$_GET["pk"];
  $sqlfullview = "SELECT * FROM bill WHERE bill_id  ='$get_billid'";
  $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
  $rowfullview=mysqli_fetch_assoc($resultfullview);
  ?>
  <div class="card">
    <div class="card-body">
      <center><h5 class="card-title">Bill Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Bill ID</th><td><?php echo $rowfullview["bill_id"]; ?></td></tr>
          <tr><th>Order ID</th><td><?php echo $rowfullview["order_id"]; ?></td></tr>
          <tr><th>Create Date</th><td><?php echo $rowfullview["create_date"]; ?></td></tr>
          <tr><th>Amount</th><td><?php echo $rowfullview["amount"]; ?></td></tr>
          <tr><th>Pay Mode</th><td><?php echo $rowfullview["pay_mode"]; ?></td></tr>
          <tr><th>Pay Status</th><td><?php echo $rowfullview["pay_status"]; ?></td></tr>
          <tr><th>Pay Date</th><td><?php echo $rowfullview["pay_date"]; ?></td></tr>
          <tr><th>Upload Slip</th><td><?php echo $rowfullview["upload_slip"]; ?></td></tr>
          <tr><th>Cheque Date</th><td><?php echo $rowfullview["cheque_date"]; ?></td></tr>
          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=bill.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <a href="index.php?pg=bill.php&option=edit&pk=<?php echo $rowfullview["bill_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

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
      $get_billid=$_GET["pk"];
      $sqledit="SELECT * FROM bill WHERE bill_id = '$get_billid'";
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
               <center><h4 class="card-title">Edit Bill</h4></center>
               <!-- field start -->
               <div class="form-group row">
                                     <label for="fname" class="col-sm-3 text-right control-label col-form-label">Bill ID</label>
                                     <div class="col-sm-3">
                                         <input type="text" class="form-control" id="txtbillid" name="txtbillid" placeholder="Bill ID Here" required readonly value="<?php echo $rowedit["bill_id"]; ?>">

                                     </div>

                 <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Order ID</label>
                                     <div class="col-sm-3">
                                         <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order ID Here" required >
                                     <?php
                                            $sqlload="SELECT order_id FROM order_detail";
                                            $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                          while( $rowload=mysqli_fetch_assoc($resultload))
                                          {
											  if($rowedit["order_id"]==$rowload["order_id"])
											  {
												echo '<option selected value="'.$rowload["order_id"].'">'.$rowload["order_id"].'</option>';//for the specific id
											  }
                        else
											  {
												echo '<option value="'.$rowload["order_id"].'">'.$rowload["order_id"].'</option>';
											  }

                                          }

                                            ?>
											</select>
									 </div>
                                 </div>
               <!-- field end -->
               <!-- field start -->
               <div class="form-group row">
                                     <label for="fname" class="col-sm-3 text-right control-label col-form-label">Created Date</label>
                                     <div class="col-sm-3">
                                         <input type="date" class="form-control" id="txtcreatedate" name="txtcreatedate" placeholder="Created Date Here" required value="<?php echo $rowedit["create_date"]; ?>">
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
                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Pay date</label>
                                     <div class="col-sm-3">
                                         <input type="date" class="form-control" id="txtpaydate" name="txtpaydate" placeholder="Pay Date Here" required value="<?php echo $rowedit["pay_date"]; ?>">
                                     </div>
                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Upload Slip</label>
                                     <div class="col-sm-3">
                                         <input type="text" class="form-control" id="txtuploadslip" name="txtuploadslip" placeholder="Upload Slip Here" required value="<?php echo $rowedit["upload_slip"]; ?>">
                                     </div>
                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Cheque Date</label>
                                     <div class="col-sm-3">
                                         <input type="date" class="form-control" id="txtchequedate" name="txtchequedate" placeholder="Cheque Date Here" required value="<?php echo $rowedit["cheque_date"]; ?>">
                                     </div>
                                   </div>
               <!-- field end -->
               <!-- button start -->
               <div class="form-group row">
                   <div class="col-sm-12">
                   <center>
                     <a href ="index.php?pg=bill.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
      $get_billid=$_GET["pk"];
      $sqldelete = "DELETE FROM bill WHERE bill_id = '$get_billid'";
      $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
      if ($resultdelete)
      {
        echo '<script> alert("Record is Deleted");
              window.location.href="index.php?pg=bill.php&option=view";</script>';
      }
    }
    else if ($_GET["option"] == "paystatus")
   {
     $get_billid=$_GET["pk"];
     $get_orderid=$_GET["orderid"];
     $get_status=$_GET["status"];
     if($get_status=="Accept")
     {
       $paystatus="Paid";
     }
     else
     {
        $paystatus="Reject";
     }
     $sqldelete = "UPDATE bill SET pay_status='$paystatus' WHERE bill_id = '$get_billid'";//for assign paystatus value (Paid/Reject) to specific bill_id
     $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
     if ($resultdelete)
     {
       echo '<script> alert("Record is '.$get_status.'");
             window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$get_orderid.'";</script>';
     }
   }                                       //get_orderid variable contains the values which are Accept and Reject
}
?>
</body>
