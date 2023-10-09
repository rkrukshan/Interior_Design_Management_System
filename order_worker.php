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
  $sqlinsert="INSERT INTO order_worker(order_id,worker_id,assign_date)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
         '".mysqli_real_escape_string($con,$_POST["txtworkerid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtassigndate"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
if($resultinsert)
{
  echo '<script> alert("Data stored successfully"); </script>';
}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE order_worker SET
          assign_date='".mysqli_real_escape_string($con,$_POST["txtassigndate"])."'
        WHERE order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."' AND worker_id='".mysqli_real_escape_string($con,$_POST["txtworkerid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=order_worker.php&option=fullview&pk1='.$_POST["txtorderid"].'&pk2='.$_POST["txtworkerid"].'";</script>';

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
                    <center><h4 class="card-title">Assign Workers</h4></center>
                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtorderid" name="txtorderid" placeholder="Order ID Here" required>
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

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Worker ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtworkerid" name="txtworkerid" placeholder="Worker ID Here" required>
                                                <option>Select Worker</option>
                                              <?php
                                              $sqlload="SELECT staff_id,name FROM staff WHERE designation='Worker'";
                                              $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                            while( $rowload=mysqli_fetch_assoc($resultload))
                                            {
                                              $sqlcheckworker="SELECT * FROM order_worker WHERE order_id='$get_orderid' AND worker_id='$rowload[staff_id]'";
                                              $resultcheckworker=mysqli_query($con,$sqlcheckworker) or die ("Error in sqlcheckworker". mysqli_error($con));
                                              if (mysqli_num_rows($resultcheckworker)==0)
                                              {
                                                echo '<option value="'.$rowload["staff_id"].'">'.$rowload["name"].'</option>';
                                              }

                                            }

                                              ?>
                                            </select>
                                          </div>
                                      </div>
                    <!-- field end -->
                    <!-- field start -->
                    <div class="form-group row">

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Assign Date</label>
                                          <div class="col-sm-3">
                                              <input type="date" class="form-control" id="txtassigndate" value="<?php echo date("Y-m-d"); ?>" readonly name="txtassigndate" placeholder="Assign Date Here" required>
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
        <center>  <h5 class="card-title">Order Worker View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=order_worker.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
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
                $sqlview="SELECT order_id,worker_id,assign_date FROM order_worker";
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
                      echo '<a href="index.php?pg=order_worker.php&option=fullview&pk1='.$rowview["order_id"].'&pk2='.$rowview["worker_id"].'"><button class="btn btn-success">View</button></a> ';
                      echo '<a href="index.php?pg=order_worker.php&option=edit&pk1='.$rowview["order_id"].'&pk2='.$rowview["worker_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=order_worker.php&option=delete&pk1='.$rowview["order_id"].'&pk2='.$rowview["worker_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
       $get_workerid =$_GET["pk2"];
       $sqlfullview = "SELECT * FROM order_worker WHERE order_id  ='$get_orderid' AND worker_id='$get_workerid'";
       $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
       $rowfullview=mysqli_fetch_assoc($resultfullview);

	   $sqlstaffname="SELECT name FROM staff WHERE staff_id = '$rowfullview[worker_id]'";
	   $resultstaffname=mysqli_query($con,$sqlstaffname) or die ("Error in sqlstaffname" . mysqli_error($con));
	   $rowstaffname=mysqli_fetch_assoc($resultstaffname);
       ?>
       <div class="card">
       <div class="card-body">
       <center><h5 class="card-title">Order Worker View</h5></center>
       <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
           <tr><th>Order ID</th><td><?php echo $rowfullview["order_id"]; ?></td></tr>
           <tr><th>Worker ID</th><td><?php echo $rowstaffname["name"]; ?></td></tr>
           <tr><th>Assign Date</th><td><?php echo $rowfullview["assign_date"]; ?></td></tr>

           <tr>
             <td colspan="2">
               <center>
                 <a href="index.php?pg=order_worker.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                 <a href="index.php?pg=order_worker.php&option=edit&pk1=<?php echo $rowfullview["order_id"]; ?>&pk2=<?php echo $rowfullview["worker_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

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
         $get_orderid =$_GET["pk1"];
         $get_workerid =$_GET["pk2"];
         $sqledit = "SELECT * FROM order_worker WHERE order_id  ='$get_orderid' AND worker_id='$get_workerid'";
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
                       <center><h4 class="card-title">Edit Order Workers</h4></center>
                       <!-- field start -->
                       <div class="form-group row">
                                             <label for="fname" class="col-sm-3 text-right control-label col-form-label">Order ID</label>
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

                         <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Worker ID</label>
                                             <div class="col-sm-3">
                                                 <select class="form-control" id="txtworkerid" name="txtworkerid" placeholder="Worker ID Here" required readonly>
                                                 <?php
                                                 $sqlload="SELECT staff_id,name FROM staff WHERE staff_id='$rowedit[worker_id]' ";
                                                 $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                               while( $rowload=mysqli_fetch_assoc($resultload))
                                               {
                                                 echo '<option value="'.$rowload["staff_id"].'">'.$rowload["name"].'</option>';
                                               }

                                                 ?>
                                               </select>
                                             </div>
                                         </div>
                       <!-- field end -->
                       <!-- field start -->
                       <div class="form-group row">

                         <label for="fname" class="col-sm-3 text-right control-label col-form-label">Assign Date</label>
                                             <div class="col-sm-3">
                                                 <input type="date" class="form-control" id="txtassigndate" name="txtassigndate" placeholder="Assign Date Here" required value="<?php echo $rowedit["assign_date"]; ?>">
                                             </div>
                                         </div>
                       <!-- field end -->

                       <!-- button start -->
                       <div class="form-group row">
                           <div class="col-sm-12">
                           <center>
                             <a href ="index.php?pg=order_worker.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
       $get_workerid=$_GET["pk2"];
       $sqldelete = "DELETE FROM order_worker WHERE order_id ='$get_orderid' AND worker_id='$get_workerid'";
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
