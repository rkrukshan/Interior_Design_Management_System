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
  if($_POST["txtaskenddate"]=="Yes")
  {
    $sqlinsert="INSERT INTO order_pause(order_id,start_date,end_date,reason)
      VALUES('".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
            '".mysqli_real_escape_string($con,$_POST["txtstartdate"])."',
            '".mysqli_real_escape_string($con,$_POST["txtenddate"])."',
            '".mysqli_real_escape_string($con,$_POST["txtreason"])."')";
  }
  else
  {
    $sqlinsert="INSERT INTO order_pause(order_id,start_date,reason)
      VALUES('".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
            '".mysqli_real_escape_string($con,$_POST["txtstartdate"])."',
            '".mysqli_real_escape_string($con,$_POST["txtreason"])."')";
  }
  
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
  if($_POST["txtaskenddate"]=="Yes")
  {
    $sqlupdate="UPDATE order_pause SET
          start_date='".mysqli_real_escape_string($con,$_POST["txtstartdate"])."',
          end_date='".mysqli_real_escape_string($con,$_POST["txtenddate"])."',
          reason='".mysqli_real_escape_string($con,$_POST["txtreason"])."'
          WHERE order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."' AND start_date='".mysqli_real_escape_string($con,$_POST["txtoriginalstartdate"])."'";
  }
  else
  {
    $sqlupdate="UPDATE order_pause SET
          start_date='".mysqli_real_escape_string($con,$_POST["txtstartdate"])."',
          end_date='".mysqli_real_escape_string($con,"0000-00-00")."',
          reason='".mysqli_real_escape_string($con,$_POST["txtreason"])."'
          WHERE order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."' AND start_date='".mysqli_real_escape_string($con,$_POST["txtoriginalstartdate"])."'";
  }
$resultupdate=mysqli_query($con,$sqlupdate) or die ("error in sqledit" . mysqli_error($con));
if($resultupdate)
{
  echo '<script> alert("Successfully Updated");
   window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'";</script>';

}
}
//update code end
?>
<script>
function enable_enddate()
{
  var startdate=document.getElementById("txtstartdate").value;
  var askenddate=document.getElementById("txtaskenddate").value;
  if(startdate!="" && askenddate=="Yes")
  {
    document.getElementById("txtenddate").value="";
    document.getElementById("txtenddate").readOnly=false;
    document.getElementById("txtenddate").min=startdate;
  }
  else
  {
    document.getElementById("txtenddate").value="";
    document.getElementById("txtenddate").readOnly=true;
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
		    ?>
        <!-- form section start -->
        <section class="feature_part padding_top">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form class="form-horizontal" method="POST" action="">
                    <div class="card-body">
                      <center><h4 class="card-title">Pause Order</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order id Here" required>
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
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" onchange="enable_enddate()" placeholder="Start Date Here" required>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Having End Date</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtaskenddate" name="txtaskenddate" onchange="enable_enddate()" required>
                                                  <option vlaue="Yes">Yes</option>
                                                  <option vlaue="No">No</option>
                                                </select>
                                            </div>
                                        
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">End Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtenddate" name="txtenddate" min="<?php echo date("Y-m-d"); ?>" placeholder="End Date Here" required>
                                            </div>
											</div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
											<label for="fname" class="col-sm-3 text-right control-label col-form-label">Reason</label>
                                            <div class="col-sm-3">
                                                <textarea class="form-control" id="txtreason" name="txtreason" placeholder="Reason Here" required></textarea>
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
        <center>  <h5 class="card-title">Order Process View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=order_process.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT order_id,actual_start_date,actual_end_date,status FROM order_process";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  echo'<tr>';
                    echo '<td>'.$rowview["order_id"].'</td>';
                    echo '<td>'.$rowview["actual_start_date"].'</td>';
                    echo '<td>'.$rowview["actual_end_date"].'</td>';
                    echo '<td>'.$rowview["status"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=order_process.php&option=fullview&pk='.$rowview["order_id"].'"><button class="btn btn-success">View</button></a> ';
                      echo '<a href="index.php?pg=order_process.php&option=edit&pk='.$rowview["order_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=order_process.php&option=delete&pk='.$rowview["order_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
      $sqlfullview = "SELECT * FROM order_process WHERE order_id  ='$get_orderid'";
      $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
      $rowfullview=mysqli_fetch_assoc($resultfullview);
      ?>
      <div class="card">
      <div class="card-body">
      <center><h5 class="card-title">Order Process Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Order ID</th><td><?php echo $rowfullview["order_id"]; ?></td></tr>
          <tr><th>Actual Start Date</th><td><?php echo $rowfullview["actual_start_date"]; ?></td></tr>
          <tr><th>Actual End Date</th><td><?php echo $rowfullview["actual_end_date"]; ?></td></tr>
          <tr><th>Status</th><td><?php echo $rowfullview["status"]; ?></td></tr>

          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=order_process.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <a href="index.php?pg=order_process.php&option=edit&pk=<?php echo $rowfullview["order_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

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
        $get_orderid=$_GET["pk1"];
      $get_startdate=$_GET["pk2"];
        $sqledit = "SELECT * FROM order_pause WHERE order_id='$get_orderid' AND start_date='$get_startdate'";
        $resultedit = mysqli_query($con,$sqledit) or die("Sqledit error ".mysqli_error($con));
        $rowedit=mysqli_fetch_assoc($resultedit);

        if($rowedit["start_date"]>date("Y-m-d"))
        {
            $startdate_readonly="";
        }
        else
        {
          $startdate_readonly="readonly";
        }
        ?>
        <!-- form section start -->
        <section class="feature_part padding_top">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form class="form-horizontal" method="POST" action="">
                    <div class="card-body">
                      <center><h4 class="card-title">Edit Order Pause</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order id Here" required readonly>
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
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                            <div class="col-sm-3">
                                                <input type="hidden" class="form-control" id="txtoriginalstartdate" name="txtoriginalstartdate" placeholder="Start Date Here" required value="<?php echo $rowedit["start_date"];?>">
                                                <input type="date" class="form-control" <?php echo $startdate_readonly; ?> min="<?php echo date("Y-m-d"); ?>" onchange="enable_enddate()" id="txtstartdate" name="txtstartdate" placeholder="Start Date Here" required value="<?php echo $rowedit["start_date"];?>">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Have you select end date?</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txtaskenddate" name="txtaskenddate" onchange="enable_enddate()" required>
                                                  <option vlaue="Yes">Yes</option>
                                                  <option vlaue="No">No</option>
                                                </select>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">End Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtenddate" name="txtenddate" placeholder="End Date Here" min="<?php echo $rowedit["start_date"];?>" required value="<?php echo $rowedit["end_date"]; ?>">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">

                                            
                     <label for="fname" class="col-sm-3 text-right control-label col-form-label">Reason</label>
                                            <div class="col-sm-3">
                                                <textarea class="form-control" id="txtreason" name="txtreason" placeholder="reason Here" required><?php echo $rowedit["reason"];?></textarea>
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
      else if ($_GET["option"] == "delete")
      {
      $get_orderid=$_GET["pk1"];
      $get_startdate=$_GET["pk2"];
      $sqldelete = "DELETE FROM order_pause WHERE order_id ='$get_orderid' AND start_date='$get_startdate'";
      $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
      if ($resultdelete)
      {
        echo '<script> alert("Record is Deleted");
              window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$get_orderid.'";</script>';
      }
      }
      
      }
      ?>
      </body>
