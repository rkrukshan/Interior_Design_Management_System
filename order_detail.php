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
if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Worker"||$system_usertype=="Customer")
{//Admin,Clerk,Worker,Customer Can Access This Page/can login into the web
include "config.php";
//insert sql start
if(isset($_POST["btnsave"]))
{
  if ($system_usertype=="Customer")
  {
    $status="Pending";

  }
  else
  {
    $status="Accepted";
  }
  $sqlinsert="INSERT INTO order_detail(order_id,customer_id,create_date,order_address,status,description,finish_date,start_date)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtcustomerid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtcreatedate"])."',
        '".mysqli_real_escape_string($con,$_POST["txtorderaddress"])."',
        '".mysqli_real_escape_string($con,$status)."',
        '".mysqli_real_escape_string($con,$_POST["txtdescription"])."',
        '".mysqli_real_escape_string($con,$_POST["txtfinishdate"])."',
        '".mysqli_real_escape_string($con,$_POST["txtstartdate"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
if($resultinsert)
{
  unset($_SESSION["session_orderid"]);
  echo '<script> alert("Data stored successfully");
window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'";
  </script>';
}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE order_detail SET
          customer_id='".mysqli_real_escape_string($con,$_POST["txtcustomerid"])."',
        create_date='".mysqli_real_escape_string($con,$_POST["txtcreatedate"])."',
        order_address='".mysqli_real_escape_string($con,$_POST["txtorderaddress"])."',
        status='".mysqli_real_escape_string($con,$_POST["txtstatus"])."',
        description='".mysqli_real_escape_string($con,$_POST["txtdescription"])."',
        finish_date='".mysqli_real_escape_string($con,$_POST["txtfinishdate"])."',
        start_date='".mysqli_real_escape_string($con,$_POST["txtstartdate"])."'
        WHERE order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'";</script>';
	}

}
//update code End
?>
<script>
function activefinishdate()
{
  var  startdate= document.getElementById("txtstartdate").value;
  if (startdate!="")
  {
    document.getElementById("txtfinishdate").readOnly=false;
    document.getElementById("txtfinishdate").value="";
    document.getElementById("txtfinishdate").min=startdate;
  }
  else
  {
    document.getElementById("txtfinishdate").readOnly=true;
    document.getElementById("txtfinishdate").value="";
  }
}
</script>

<script>
function popup_fulldetails(orderid,imageid)
{
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function()
  {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
    {
      var get_response = xmlhttp.responseText.trim();
      document.getElementById("deco_popup_heading").innerHTML="fulldetails";
      document.getElementById("deco_popup_content").innerHTML=get_response;
    }
  };
  xmlhttp.open("GET", "custom_order.php?option=fullview&pk1=" + imageid+"&pk2="+orderid, true);
  xmlhttp.send();
}
</script>
<body>
  <?php
  if (isset($_GET["option"]))//get from url
  {
    if ($_GET["option"] == "add")//redirect or load option add
    {
        $session_orderid=$_SESSION["session_orderid"];//set session to order id
		    ?>
        <!-- form section start -->
        <section class="feature_part padding_top">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form class="form-horizontal" method="POST" action="">
                    <div class="card-body">
                      <center><h4 class="card-title">Add Order Details</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
                                            <div class="col-sm-3">
                                              <?php
                                              $generateid=$session_orderid;//variable created for echo value in the input field

                                              ?>
                                                <input type="text" class="form-control" id="txtorderid" name="txtorderid" placeholder="Order id Here" readonly  value="<?php echo $generateid; ?>" required>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Customer ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtcustomerid" name="txtcustomerid" placeholder="Customer ID Here" required>

                                                <?php
                                                if($system_usertype=="Customer")
                                                {
                                                  $sqlload="SELECT customer_id,name FROM customer WHERE customer_id='$system_userid'";//name,id of an individual
                                                }
                                                else
                                                {
                                                  $sqlload="SELECT customer_id,name FROM customer";//sql for list all customers
                                                  echo '<option value="select_option">Select Customer</option>';
                                                }

                                                $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                              while( $rowload=mysqli_fetch_assoc($resultload))
                                              {
                                                echo '<option value="'.$rowload["customer_id"].'">'.$rowload["name"].'</option>';//list all customers in the drop down
                                              }

                                                ?>
                                              </select>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Created Date</label>
                                          <div class="col-sm-3">
                                              <input type="date" class="form-control" id="txtcreatedate" name="txtcreatedate" placeholder="Created Date Here" value="<?php echo date("Y-m-d"); ?>" readonly required>
                                          </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order Address</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtorderaddress" name="txtorderaddress" placeholder="Order Address Here" required>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">

                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" min="<?php echo date("Y-m-d"); ?>" onchange="activefinishdate()" placeholder="Start Date Here" required>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Finish Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtfinishdate" name="txtfinishdate" placeholder="Finished Date Here" readonly required>
                                            </div>


                                        </div>
                      <!-- field end -->
                      <!-- field start -->
                      <div class="form-group row">

                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                            <div class="col-sm-3">
                                                <textarea class="form-control" id="txtdescription" name="txtdescription" placeholder="Describe Here" required></textarea>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=order_product.php&option=add"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        <center>  <h5 class="card-title">Order Detail View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <?php 
              if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Customer")
              {
              ?>
              <a href="index.php?pg=order_product.php&option=add"><button class="btn btn-primary">Add Record</button></a>
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
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                 if($system_usertype=="Customer")
                 {
                  $sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE customer_id='$system_userid'";
                 }
                 else  if($system_usertype=="Admin"||$system_usertype=="Clerk")
                 {
                  $sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail";
                 }
                 else 
                 {
                  $sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE order_id IN (SELECT order_id FROM order_worker WHERE worker_id='$system_userid')";
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
                    echo '<td>';
                      echo '<a href="index.php?pg=order_detail.php&option=fullview&pk='.$rowview["order_id"].'"><button class="btn btn-success">View</button></a> ';
                      if ($rowview["status"]=="Pending")
                       {
                        if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Customer")
                        {
                      echo '<a href="index.php?pg=order_detail.php&option=edit&pk='.$rowview["order_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=order_detail.php&option=delete&pk='.$rowview["order_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
      <?php
    }
    else if ($_GET["option"] == "fullview")
    {
      $get_orderid =$_GET["pk"];
      $sqlfullview = "SELECT * FROM order_detail WHERE order_id  ='$get_orderid'";
      $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
      $rowfullview=mysqli_fetch_assoc($resultfullview);

      $sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowfullview[customer_id]'";
      $resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
      $rowcustomername=mysqli_fetch_assoc($resultcustomername);
      ?>
      <div class="card">
      <div class="card-body">
      <center><h5 class="card-title">Order Detail Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Order ID</th><td><?php echo $rowfullview["order_id"]; ?></td></tr>
          <tr><th>Customer ID</th><td><?php echo $rowcustomername["name"]; ?></td></tr>
          <tr><th>Create Date</th><td><?php echo $rowfullview["create_date"]; ?></td></tr>
          <tr><th>Order Address</th><td><?php echo $rowfullview["order_address"]; ?></td></tr>
          <tr><th>Status</th><td><?php echo $rowfullview["status"]; ?></td></tr>
          <tr><th>Description</th><td><?php echo $rowfullview["description"]; ?></td></tr>
          <tr><th>Expected Start Date</th><td><?php echo $rowfullview["start_date"]; ?></td></tr>
          <tr><th>Expected Finish Date</th><td><?php echo $rowfullview["finish_date"]; ?></td></tr>

          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=order_detail.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <?php
                if ($rowfullview["status"]=="Pending")
                {
                  if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Customer")
                  {
                 ?>
                <a href="index.php?pg=order_detail.php&option=edit&pk=<?php echo $rowfullview["order_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;
                <?php 
                  }

                  if($system_usertype=="Admin"||$system_usertype=="Clerk")
                  {
                ?>
                <a onclick="return confirmaccept()" href="index.php?pg=order_detail.php&option=status&pk=<?php echo $rowfullview["order_id"]; ?>&status=Accepted"><button class="btn btn-success">Accept</button></a>&nbsp;
                <a onclick="return confirmreject()" href="index.php?pg=order_detail.php&option=status&pk=<?php echo $rowfullview["order_id"]; ?>&status=Rejected"><button class="btn btn-danger">Reject</button></a>&nbsp;
                <?php
                  }
                }
                  if ($rowfullview["status"]=="Accepted")
                  {
                    $sqlcheckorderprocess="SELECT * FROM order_process WHERE order_id='$get_orderid'";
                    $resultcheckorderprocess=mysqli_query($con,$sqlcheckorderprocess) or die ("Error in sqlcheckorderprocess" .mysqli_error($con));
                    if (mysqli_num_rows($resultcheckorderprocess)==0)
                    {
                      if($system_usertype=="Admin"||$system_usertype=="Clerk")
                      {
                    ?>
                      <a href="index.php?pg=order_process.php&option=start&pk=<?php echo $rowfullview["order_id"]; ?>"><button class="btn btn-primary">Start Work</button></a>&nbsp;
                    <?php
                      }
                    }
                  }
                ?>
              </center>
            </td>
            <?php
            if ($rowfullview["status"]=="Accepted")
            {
              if (mysqli_num_rows($resultcheckorderprocess)>0)
              {
                $rowcheckorderprocess=mysqli_fetch_assoc($resultcheckorderprocess);
                ?>
                <tr><th colspan="2"> <center>Order Progress</center></th></tr>
                <tr><th>Actual Start Date</th><td><?php echo $rowcheckorderprocess["actual_start_date"]; ?></td></tr>
                <tr><th>Actual End Date</th><td><?php echo $rowcheckorderprocess["actual_end_date"]; ?></td></tr>
                <tr><th>Status</th><td><?php echo $rowcheckorderprocess["status"]; ?>
                  <?php
                   $sqlcheckorderproduct="SELECT order_id,product_id,quantity FROM order_product WHERE order_id='$get_orderid'";
                   $resultcheckorderproduct=mysqli_query($con,$sqlcheckorderproduct) or die ("Error in sqlcheckorderproduct" . mysqli_error($con));

                   $sqlcheckorderproductdelivery="SELECT order_id,product_id,quantity FROM order_product_delivery WHERE order_id='$get_orderid'";
                   $resultcheckorderproductdelivery=mysqli_query($con,$sqlcheckorderproductdelivery) or die ("Error in sqlcheckorderproductdelivery" . mysqli_error($con));

                   $sqlcheckcustomorder="SELECT order_id,image_id,quantity FROM custom_order WHERE order_id='$get_orderid' AND status='Pending'";
                   $resultchecustomckorder=mysqli_query($con,$sqlcheckcustomorder) or die ("Error in sqlcheckcustomorder" . mysqli_error($con));
                  
                   if($rowcheckorderprocess["status"]!="Completed")
                  {
                    if($system_usertype=="Admin"||$system_usertype=="Clerk")
                    {
                     

                      if((mysqli_num_rows($resultcheckorderproduct)==mysqli_num_rows($resultcheckorderproductdelivery)) && (mysqli_num_rows($resultchecustomckorder)==0))
                      {

                    ?>
                      <a href="index.php?pg=order_process.php&option=end&pk=<?php echo $rowfullview["order_id"]; ?>"><button class="btn btn-primary">Finish Work</button></a>&nbsp;
                    <?php
                      }
                    }
                  }
                  else
                  {
                    $sqlcheckreview="SELECT * FROM review WHERE order_id='$get_orderid'";
                    $resultcheckreview=mysqli_query($con,$sqlcheckreview) or die ("Error in sqlcheckreview" .mysqli_error($con));
                    if (mysqli_num_rows($resultcheckreview)==0)
                    {
                      if($system_usertype=="Customer")
                      {
                    ?>
                      <a href="index.php?pg=review.php&option=add&pk=<?php echo $rowfullview["order_id"]; ?>"><button class="btn btn-primary">Make Review</button></a>&nbsp;
                    <?php
                      }
                    }
                  }
                  ?>
                </td></tr>
                <?php
                $sqlcheckreview="SELECT * FROM review WHERE order_id='$get_orderid'";
                $resultcheckreview=mysqli_query($con,$sqlcheckreview) or die ("Error in sqlcheckreview" .mysqli_error($con));
                if (mysqli_num_rows($resultcheckreview)>0)
                {
                  $rowcheckreview=mysqli_fetch_assoc($resultcheckreview);
                  ?>
                  <tr><th colspan="2"> <center>Review</center></th></tr>
                  <tr><th>Review Date</th><td><?php echo $rowcheckreview["review_date"]; ?></td></tr>
                  <tr><th>Rate</th><td>
                    <?php
                    for($rate=1;$rate<=5;$rate++)
                    {
                      if($rate<=$rowcheckreview["rate"])
                      {
                        echo '<i class="fa fa-star"></i>';
                      }
                      else
                      {
                        echo '<i class="far fa-star"></i>';
                      }
                    }
                    ?>
                  </td></tr>
                  <tr><th>Comment</th><td><?php echo $rowcheckreview["comment"]; ?></td></tr>
                  <?php
                }
              }
            }
            ?>
          </tr>
        </table>
      </div>
      </div>
      </div>
	  
	  <!-- order pause details -->
      <?php
      if ($rowfullview["status"]=="Accepted")
      {
        if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Worker"||$system_usertype=="Customer")
        {
        ?>
        <div class="card">
          <div class="card-body">
          <center>  <h5 class="card-title">Paused Order Info</h5></center>
            <div class="table-responsive">
              <table id="zero_config" class="table table-striped table-bordered">
                <?php
                
                if(mysqli_num_rows($resultcheckorderprocess)==0 || (mysqli_num_rows($resultcheckorderprocess)>0 && $rowcheckorderprocess["status"]!="Completed"))
                {
                  if($system_usertype=="Admin"||$system_usertype=="Clerk")
                  {
                    $today=date("Y-m-d");
                    $sqlcheckorder_pause="SELECT * FROM order_pause WHERE order_id='$get_orderid' AND (end_date>='$today' OR end_date='0000-00-00' OR end_date IS NULL )";
                    $resultcheckorder_pause = mysqli_query($con,$sqlcheckorder_pause) or die ("Error in sqlcheckorder_pause ".mysqli_error($con));	
                    if(mysqli_num_rows($resultcheckorder_pause)==0)	  
                    {
                  ?>
                <a href="index.php?pg=order_pause.php&option=add&pk=<?php echo $get_orderid; ?>"><button class="btn btn-warning ">Pause Order</button></a>
                <br><br>
                <?php
                    }
                  }
                }
                ?>
                <thead>
                  <tr>
                    <th>Order id</th>
                    <th>Start Date ID</th>
                    <th>End Date</th>
                    <th>No of Days</th>
                    <th>Reason</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlview="SELECT * FROM order_pause WHERE order_id='$get_orderid' ORDER BY start_date DESC";
                  $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                  while($rowview=mysqli_fetch_assoc($resultview))
                  {
                    if($rowview["start_date"]>=date("Y-m-d"))
                    {
                      if($rowview["end_date"]=="" || $rowview["end_date"]=="0000-00-00")
                      {
                        $no_of_days="Still Not Confirm";
                      }
                      else
                      {
                        $enddate=$rowview["end_date"];
                        $no_of_days=((strtotime($enddate) - strtotime($rowview["start_date"]))/(3600*24)) + 1;
                      }                      
                    }
                    else
                    {
                      if($rowview["end_date"]=="" || $rowview["end_date"]=="0000-00-00")
                      {
                        $enddate=date("Y-m-d");
                      }
                      else
                      {
                        $enddate=$rowview["end_date"];
                      }
                      $no_of_days=((strtotime($enddate) - strtotime($rowview["start_date"]))/(3600*24)) + 1;
                    }
                    echo'<tr>';
                      echo '<td>'.$rowview["order_id"].'</td>';
                      echo '<td>'.$rowview["start_date"].'</td>';
                      echo '<td>'.$rowview["end_date"].'</td>';
                      echo '<td>'.$no_of_days.'</td>';
                      echo '<td>'.$rowview["reason"].'</td>';
                      echo '<td>';
                      if($rowview["start_date"]>=date("Y-m-d"))
                      {
                        if($system_usertype=="Admin"||$system_usertype=="Clerk")
                        {
                          echo '<a href="index.php?pg=order_pause.php&option=edit&pk1='.$rowview["order_id"].'&pk2='.$rowview["start_date"].'"><button class="btn btn-info">Edit</button></a> ';
                          echo '<a onclick="return confirmdelete()" href="index.php?pg=order_pause.php&option=delete&pk1='.$rowview["order_id"].'&pk2='.$rowview["start_date"].'"><button class="btn btn-danger">Delete</button></a> ';
                        }
                      }
                      else if(($rowview["end_date"]=="" || $rowview["end_date"]=="0000-00-00") || $rowview["end_date"]>=date("Y-m-d"))
                      {
                        if($system_usertype=="Admin"||$system_usertype=="Clerk")
                        {
                          echo '<a href="index.php?pg=order_pause.php&option=edit&pk1='.$rowview["order_id"].'&pk2='.$rowview["start_date"].'"><button class="btn btn-info">Edit</button></a> ';
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
        <?php
        }
      }
      ?>

      <!-- order worker details -->
      <?php
      if ($rowfullview["status"]=="Accepted")
      {
        if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Worker"||$system_usertype=="Customer")
        {
        ?>
        <div class="card">
          <div class="card-body">
          <center>  <h5 class="card-title">Order Worker Details</h5></center>
            <div class="table-responsive">
              <table id="zero_config" class="table table-striped table-bordered">
                <?php
                
                if(mysqli_num_rows($resultcheckorderprocess)>0 && $rowcheckorderprocess["status"]!="Completed")
                {
                  if($system_usertype=="Admin"||$system_usertype=="Clerk")
                  {
                  ?>
                <a href="index.php?pg=order_worker.php&option=add&pk=<?php echo $get_orderid; ?>"><button class="btn btn-primary">Add Worker</button></a>
                <br><br>
                <?php
                  }
                }
                ?>
                <thead>
                  <tr>
                    <th>Order id</th>
                    <th>Worker ID</th>
                    <th>Assign Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlview="SELECT order_id,worker_id,assign_date FROM order_worker WHERE order_id='$get_orderid'";
                  $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                  while($rowview=mysqli_fetch_assoc($resultview))
                  {
  					$sqlstaffname="SELECT name FROM staff WHERE staff_id = '$rowview[worker_id]'";
  				    $resultstaffname=mysqli_query($con,$sqlstaffname) or die ("Error in sqlstaffname" . mysqli_error($con));
  				    $rowstaffname=mysqli_fetch_assoc($resultstaffname);
                    echo'<tr>';
                      echo '<td>'.$rowview["order_id"].'</td>';
                      echo '<td>'.$rowstaffname["name"].'</td>';
                      echo '<td>'.$rowview["assign_date"].'</td>';
                      echo '<td>';
                      if($rowcheckorderprocess["status"]!="Completed")
                      {
                        if($system_usertype=="Admin"||$system_usertype=="Clerk")
                        {
                        echo '<a onclick="return confirmdelete()" href="index.php?pg=order_worker.php&option=delete&pk1='.$rowview["order_id"].'&pk2='.$rowview["worker_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
        <?php
        }
      }
      ?>

      <!--order product Details-->
      <div class="card">
        <div class="card-body">
        <center>  <h5 class="card-title">Order Product Details</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <?php
              if ($rowfullview["status"]=="Pending")
              {
                if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Customer")
                {
               ?>
              <a href="index.php?pg=order_product.php&option=add&edit_pk1=<?php echo $rowfullview["order_id"]; ?>"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <?php
                }
              }
              ?>
              <thead>
                <tr>
                  <th>Order id</th>
                  <th>Product ID</th>
                  <?php
                  if ($rowfullview["status"]=="Accepted")
                  {
                    echo "<th>Initial Quantity</th>";
                    echo "<th>Final Quantity</th>";

                  }
                  else
                  {
                    echo "<th>Quantity</th>";
                  }
                   ?>
                  <th>Unit Price</th>
                  <th>Sub Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $totalprice=0;
                $sqlview="SELECT order_id,product_id,quantity FROM order_product WHERE order_id='$get_orderid'";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlproductname="SELECT name FROM product WHERE product_id='$rowview[product_id]'";
                  $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                  $rowproductname=mysqli_fetch_assoc($resultproductname);

                  $sqlcheckprice="SELECT price,offer,start_date  FROM product_price WHERE product_id='$rowview[product_id]' ORDER BY start_date DESC ";
                  $resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
                  while($rowcheckprice=mysqli_fetch_assoc($resultcheckprice))
                  {
                    if ($rowfullview["create_date"]>=$rowcheckprice["start_date"])
                    {
                      $price=$rowcheckprice["price"];
                      $offer=$rowcheckprice["offer"];
                      break;
                    }
                  }


                  if($offer>0)
                  {
                    $unitprice=$price-(($price*$offer)/100);
                  }
                  else
                  {
                    $unitprice=$price;
                  }
                   $unitprice=number_format((float)$unitprice, 2, '.', '');
                   if ($rowfullview["status"]=="Accepted")
                   {
                     $sqlfinalquantity="SELECT order_id,product_id,quantity FROM order_product_delivery WHERE order_id='$get_orderid' AND product_id='$rowview[product_id]'";
                     $resultfinalquantity=mysqli_query($con,$sqlfinalquantity) OR die ("Error in sqlfinalquantity" .mysqli_error($con));
                     if(mysqli_num_rows($resultfinalquantity)>0)
                     {
                       $rowfinalquantity=mysqli_fetch_assoc($resultfinalquantity);
                       $finalquantity=$rowfinalquantity["quantity"];
                       $subtotal=$rowfinalquantity["quantity"]*$unitprice;
                     }
                     else
                     {
                       $subtotal=$rowview["quantity"]*$unitprice;
                       $finalquantity="";
                     }
                   }
                   else
                   {
                     $subtotal=$rowview["quantity"]*$unitprice;
                   }

                   $totalprice=$totalprice+$subtotal;
                  echo'<tr>';
                    echo '<td>'.$rowview["order_id"].'</td>';
                    echo '<td>'.$rowproductname["name"].'</td>';
                    if ($rowfullview["status"]=="Accepted")
                    {
                      echo '<td>'.$rowview["quantity"].'</td>';
                      echo '<td>'.$finalquantity.'</td>';
                    }
                    else
                    {
                        echo '<td>'.$rowview["quantity"].'</td>';
                    }

                    echo '<td>'.$unitprice.'</td>';
                    echo '<td>'.$subtotal.'</td>';
                    echo '<td>';
                    if ($rowfullview["status"]=="Pending")
                    {
                      if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Customer")
                      {
                      echo '<a href="index.php?pg=order_product.php&option=edit&edit_pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=order_product.php&option=delete&edit_pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-danger">Delete</button></a> ';
                      }
                    }
                    else if ($rowfullview["status"]=="Accepted")
                    {
                      if(mysqli_num_rows($resultfinalquantity)>0)
                      {
                        echo "Delievered";
                      }
                      else
                      {
                        if($system_usertype=="Admin"||$system_usertype=="Clerk")
                        {
                        echo '<a href="index.php?pg=order_product_delivery.php&option=add&pk1='.$rowview["order_id"].'&pk2='.$rowview["product_id"].'"><button class="btn btn-success">Deliver</button></a> ';
                        }
                      }
                    }
                    echo '</td>';
                  echo'</tr>';
                }
                echo'<tr>';
                  echo '<td>Total Price</td>';
                  echo '<td></td>';
                  if ($rowfullview["status"]=="Accepted")
                  {
                    echo '<td></td>';
                    echo '<td></td>';
                  }
                  else
                  {
                    echo '<td></td>';
                  }

                  echo '<td></td>';
                  echo '<td>'.$totalprice.'</td>';
                    echo '<td>';
                    echo '</td>';
                echo'</tr>';
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!--custom order-->

      <div class="card">
        <div class="card-body">
        <center><h5 class="card-title">Custom Order View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <?php
              $sqlcheckorderprocess="SELECT * FROM order_process WHERE order_id='$get_orderid' AND status='Completed'";
              $resultcheckorderprocess=mysqli_query($con,$sqlcheckorderprocess) or die ("Error in sqlcheckorderprocess" .mysqli_error($con));
              if ($rowfullview["status"]!="Rejected" && mysqli_num_rows($resultcheckorderprocess)==0)
              {
                if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Customer")
                {
              ?>
              <a href="index.php?pg=custom_order.php&option=add&pk=<?php echo $get_orderid; ?>"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <?php
                }
              }
              ?>
              <thead>
                <tr>
                  <th>Image ID</th>
                  <th>Image</th>
                  <th>Expected Price</th>
                  <th>Accept Price</th>
                  <th>Quantity</th>
                  <th>Sub Total</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
		$sqlview = "SELECT * FROM custom_order WHERE order_id='$get_orderid'";
        $resultview = mysqli_query($con, $sqlview) or die("Error in sqlview " . mysqli_error($con));
        while ($rowview = mysqli_fetch_assoc($resultview))
        {
            if($rowview["accept_price"]=="")
            {
              $subtotal=$rowview["quantity"]*0;
            }
            else
            {
              $subtotal=$rowview["quantity"]*$rowview["accept_price"];
            }
            if($rowview["status"]=="Accepted")
            {
            $totalprice=$totalprice+$subtotal;
            }

            echo '<tr>';
            echo '<td>' . $rowview["image_id"] . '</td>';
            echo '<td>';
            ?>
            <a href="file/custom_order/<?php echo $rowview["image"]; ?>?<?php echo date("H:i:s"); ?>" class="img-pop-up img-gal">
              <div class="single-gallery-image" style="background: url(file/custom_order/<?php echo $rowview["image"]; ?>?<?php echo date("H:i:s"); ?>); width:100; height:100;"></div>
            </a>
            <?php
            echo '</td>';
            echo '<td>' . $rowview["expect_price"] . '</td>';
            echo '<td>' . $rowview["accept_price"] . '</td>';
            echo '<td>' . $rowview["quantity"] . '</td>';
            echo '<td>' . $subtotal . '</td>';
            echo '<td>' . $rowview["status"] . '</td>';
            echo '<td>';
            ?>
            <a href="#" data-toggle="modal" data-target="#deco_popup" onclick="popup_fulldetails('<?php echo $rowview["order_id"]; ?>','<?php echo $rowview["image_id"]; ?>')">
            <button class="btn btn-success">View</button></a>
            <?php
            if($rowview["status"]=="Pending")
            {

              if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Customer")
              {
            echo '<a href="index.php?pg=custom_order.php&option=edit&pk1='.$rowview["image_id"].'&pk2='.$rowview["order_id"].'"><button class="btn btn-info">Edit</button></a> ';
            echo '<a onclick="return confirmdelete()" href="index.php?pg=custom_order.php&option=delete&pk1='.$rowview["image_id"].'&pk2='.$rowview["order_id"].'"><button class="btn btn-danger">Delete</button></a> ';
              }
            if($rowview["status"]=="Pending" && $rowview["accept_price"]=="")
            {
              //for Admin
              if($system_usertype=="Admin")
              {
              echo '<a href="index.php?pg=custom_order.php&option=assign_price&pk1='.$rowview["image_id"].'&pk2='.$rowview["order_id"].'"><button class="btn btn-info">Assign Price</button></a> ';
              }
            }
            if($rowview["status"]=="Pending" && $rowview["accept_price"]!="")
            {
              //for Customer
              if($system_usertype=="Customer")
              {
              echo '<a href="index.php?pg=custom_order.php&option=assign_price&pk1='.$rowview["image_id"].'&pk2='.$rowview["order_id"].'"><button class="btn btn-info">Negotiate Price</button></a> ';
              }
            }
            if($system_usertype=="Admin"||$system_usertype=="Customer")
            {
            echo '<a onclick="return confirmreject()" href="index.php?pg=custom_order.php&option=reject&pk1='.$rowview["image_id"].'&pk2='.$rowview["order_id"].'"><button class="btn btn-danger">Reject Price</button></a> ';
            }
            }
            echo '</td>';
            echo '</tr>';
        }
        echo'<tr>';
          echo '<td>Final Price</td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td>'.$totalprice.'</td>';
          echo '<td></td>';
          echo '<td></td>';
        echo'</tr>';
        ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php
      //show the payment Details
      $sqlcheckorderprocess="SELECT * FROM order_process WHERE order_id='$get_orderid'";
                    $resultcheckorderprocess=mysqli_query($con,$sqlcheckorderprocess) or die ("Error in sqlcheckorderprocess" .mysqli_error($con));
        if ($rowfullview["status"]=="Accepted" && mysqli_num_rows($resultcheckorderprocess)>0)
        {
          if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Customer")
          {
          $sqlpaidamount="SELECT SUM(amount) AS t_amount FROM bill WHERE order_id='$get_orderid' AND pay_status='Paid'";
          $resultpaidamount=mysqli_query($con,$sqlpaidamount) or die ("error in sqlpaidamount" .mysqli_error($con));
          $rowpaidamount=mysqli_fetch_assoc($resultpaidamount);

          if((mysqli_num_rows($resultcheckorderproduct)==mysqli_num_rows($resultcheckorderproductdelivery)) && (mysqli_num_rows($resultchecustomckorder)==0))
          {
            $maximumprice=$totalprice;
          }
          else 
          {
            $maximumprice=$totalprice*0.4;
          }
          ?>
          <div class="card">
            <div class="card-body">
            <center>  <h5 class="card-title">Bill View</h5></center>
              <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                <?php
                if ($maximumprice>$rowpaidamount["t_amount"])
                {
                  ?>
                  <a href="index.php?pg=bill.php&option=add&pk=<?php echo $get_orderid; ?>&totalprice=<?php echo $maximumprice; ?>"><button class="btn btn-primary">Make Payment</button></a>
                  <?php
                }
                ?>

                  <br><br>
                  <thead>
                    <tr>
                      <th>Bill ID</th>
                      <th>Amount</th>
                      <th>Pay Mode</th>
                      <th>Pay Status</th>
                      <th>Pay Date</th>
                      <th>Upload Slip</th>
                      <th>Cheque Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sqlview="SELECT * FROM bill WHERE order_id='$get_orderid'";
                    $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                    while($rowview=mysqli_fetch_assoc($resultview))
                    {
                      echo'<tr>';
                        echo '<td>'.$rowview["bill_id"].'</td>';
                        echo '<td>'.$rowview["amount"].'</td>';
                        echo '<td>'.$rowview["pay_mode"].'</td>';
                        echo '<td>'.$rowview["pay_status"].'</td>';
                        echo '<td>'.$rowview["pay_date"].'</td>';
                        if($rowview["pay_mode"]=="Cash")
                        {
                          echo '<td></td>';
                        }
                        else
                        {
                          echo '<td>';
                          ?>
                          <a href="file/bill/<?php echo $rowview["upload_slip"]; ?>?<?php echo date("H:i:s"); ?>" class="img-pop-up img-gal">
              							<div class="single-gallery-image" style="background: url(file/bill/<?php echo $rowview["upload_slip"]; ?>?<?php echo date("H:i:s"); ?>);"></div>
              						</a>
                          <?php
                          echo '</td>';
                        }

                        if($rowview["pay_mode"]=="Cheque")
                        {
                            echo '<td>'.$rowview["cheque_date"].'</td>';
                        }
                        else
                        {
                            echo '<td></td>';
                        }

                        echo '<td>';
                        if($rowview["pay_status"]=="Pending")
                        {
                          if($system_usertype=="Admin"||$system_usertype=="Clerk")
                          {
                          echo '<a onclick="return confirmaccept()" href="index.php?pg=bill.php&option=paystatus&pk='.$rowview["bill_id"].'&status=Accept&orderid='.$rowview["order_id"].'"><button class="btn btn-success">Accept</button></a> ';
                          echo '<a onclick="return confirmreject()" href="index.php?pg=bill.php&option=paystatus&pk='.$rowview["bill_id"].'&status=Reject&orderid='.$rowview["order_id"].'"><button class="btn btn-danger">Reject</button></a> ';
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
          <?php
          }
        }
      }
      else if ($_GET["option"] == "edit")
      {
      $get_orderid =$_GET["pk"];
        $sqledit="SELECT * FROM order_detail WHERE order_id='$get_orderid'";
        $resultedit=mysqli_query($con,$sqledit) or die("Error in sqledit" . mysqli_error($con));
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
                      <center><h4 class="card-title">Edit Order Details</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtorderid" name="txtorderid" placeholder="Order id Here" required readonly value="<?php echo $rowedit["order_id"];?>">
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Customer ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtcustomerid" name="txtcustomerid" placeholder="Customer ID Here" required>
                                                <?php
                                                $sqlload="SELECT customer_id,name FROM customer WHERE customer_id='$rowedit[customer_id]'";
                                                $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                              while( $rowload=mysqli_fetch_assoc($resultload))
                                              {
													                     echo '<option value="'.$rowload["customer_id"].'">'.$rowload["name"].'</option>';
												                      }

                                                ?>
                                              </select>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Created Date</label>
                                          <div class="col-sm-3">
                                              <input type="date" class="form-control" id="txtcreatedate" name="txtcreatedate" placeholder="Created Date Here" readonly required value="<?php echo $rowedit["create_date"];?>">
                                          </div>
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                          <div class="col-sm-3">
                                              <input type="text" class="form-control" id="txtstatus" name="txtstatus" placeholder="Status Here" readonly required value="<?php echo $rowedit["status"];?>">
                                          </div>

                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" placeholder="Start Date Here" required min="<?php echo date("Y-m-d"); ?>" value="<?php echo $rowedit["start_date"];?>" onchange="activefinishdate()">
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Finish Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtfinishdate" name="txtfinishdate" placeholder=" Finished Date Here" required min="<?php echo $rowedit["start_date"];?>" value="<?php echo $rowedit["finish_date"];?>">
                                            </div>


                                        </div>
                      <!-- field end -->
                      <!-- field start -->
                      <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order Address</label>
                        <div class="col-sm-3">
                            <textarea class="form-control" id="txtorderaddress" name="txtorderaddress" placeholder="Order Address Here" required><?php echo $rowedit["order_address"];?></textarea>
                        </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                            <div class="col-sm-3">
                                                <textarea class="form-control" id="txtdescription" name="txtdescription" placeholder="Describe Here" required><?php echo $rowedit["description"];?></textarea>
                                            </div>
                                        </div>
                      <!-- field end -->



                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=order_detail.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
      else if ($_GET["option"] == "status")
      {
        $get_orderid=$_GET["pk"];
        $get_status=$_GET["status"];
        $sqldelete = "UPDATE order_detail SET status='$get_status' WHERE order_id = '$get_orderid'";
        $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
        if ($resultdelete)
        {
          echo '<script> alert("Record is '.$get_status.'");
                window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$get_orderid.'";</script>';
        }
      }
      else if ($_GET["option"] == "delete")
      {
      $get_orderid=$_GET["pk"];
      $sqldelete = "DELETE FROM order_detail WHERE order_id = '$get_orderid'";
      $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));

      $sqldelete = "DELETE FROM order_product WHERE order_id = '$get_orderid'";
      $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
      if ($resultdelete)
      {
        echo '<script> alert("Record is Deleted");
              window.location.href="index.php?pg=order_detail.php&option=view";</script>';
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
