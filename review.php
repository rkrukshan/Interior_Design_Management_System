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
  $sqlinsert="INSERT INTO review(order_id,review_date,rate,comment)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtreview_date"])."',
        '".mysqli_real_escape_string($con,$_POST["txtrate"])."',
        '".mysqli_real_escape_string($con,$_POST["txtcomment"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
if($resultinsert)
{
  echo '<script> alert("Data stored successfully");
  window.location.href="index.php?pg=order_detail.php&option=fullview&pk='.$_POST["txtorderid"].'"; </script>';
}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE review SET
            review_date='".mysqli_real_escape_string($con,$_POST["txtreview_date"])."',
            rate='".mysqli_real_escape_string($con,$_POST["txtrate"])."',
          comment='".mysqli_real_escape_string($con,$_POST["txtcomment"])."'
								WHERE order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=review.php&option=fullview&pk='.$_POST["txtorderid"].'";</script>';
	}

}
//update code End
?>

<script>
function change_color(y)
{
	for(var x=1; x<=5; x++)
	{
		if(x<=y)
		{
			document.getElementById("txtstar"+x).className="fa fa-star";
		}
		else
		{
			document.getElementById("txtstar"+x).className="far fa-star";
		}
	}
}

function change_color_out()
{
	var y=document.getElementById("txtrate").value;
	for(var x=1; x<=5; x++)
	{
		if(x<=y)
		{
			document.getElementById("txtstar"+x).className="fa fa-star";
		}
		else
		{
			document.getElementById("txtstar"+x).className="far fa-star";
		}
	}
}

function assign_rate(y)
{
	document.getElementById("txtrate").value=y;
	for(var x=1; x<=5; x++)
	{
		if(x<=y)
		{
			document.getElementById("txtstar"+x).className="fa fa-star";
		}
		else
		{
			document.getElementById("txtstar"+x).className="far fa-star";
		}
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
                      <center><h4 class="card-title">Add Review</h4></center>
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
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Review Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly id="txtreview_date" name="txtreview_date" placeholder="Review  Here" required>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">

                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Rate</label>
                                            <div class="col-sm-3">
                                                <input type="hidden" class="form-control" id="txtrate" name="txtrate" placeholder="Rate Here" required onkeypress="return NumberValidation(event)">
                                                <?php
                                  								for($x=1; $x<=5; $x++)
                                  								{
                                  									echo '<i class="far fa-star" id="txtstar'.$x.'" onmouseover="change_color('.$x.')" onmouseout="change_color_out()" onclick="assign_rate('.$x.')" ></i>';
                                  								}
                                  								?>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Comment</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtcomment" name="txtcomment" placeholder="Comment Here" required>
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
        <center>  <h5 class="card-title">Review View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=review.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Review Date</th>
                  <th>Rate</th>
                  <th>Comment</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT order_id ,review_date,rate,comment FROM review";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  echo'<tr>';
                    echo '<td>'.$rowview["order_id"].'</td>';
                    echo '<td>'.$rowview["review_date"].'</td>';
                    echo '<td>'.$rowview["rate"].'</td>';
                    echo '<td>'.$rowview["comment"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=review.php&option=fullview&pk='.$rowview["order_id"].'"><button class="btn btn-success">View</button></a> ';
                      echo '<a href="index.php?pg=review.php&option=edit&pk='.$rowview["order_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=review.php&option=delete&pk='.$rowview["order_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
      $sqlfullview = "SELECT * FROM review WHERE order_id='$get_orderid'";
      $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
      $rowfullview=mysqli_fetch_assoc($resultfullview);
      ?>
      <div class="card">
      <div class="card-body">
      <center><h5 class="card-title">Review Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Order ID</th><td><?php echo $rowfullview["order_id"]; ?></td></tr>
          <tr><th>Review Date</th><td><?php echo $rowfullview["review_date"]; ?></td></tr>
          <tr><th>Rate</th><td><?php echo $rowfullview["rate"]; ?></td></tr>
          <tr><th>Comment</th><td><?php echo $rowfullview["comment"]; ?></td></tr>


          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=review.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <a href="index.php?pg=review.php&option=edit&pk=<?php echo $rowfullview["order_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

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
        $get_orderid =$_GET["pk"];
        $sqledit = "SELECT * FROM review WHERE order_id='$get_orderid'";
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
                      <center><h4 class="card-title">Edit Review</h4></center>
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
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Review Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtreview_date" name="txtreview_date" placeholder="Review  Here" required value="<?php echo $rowedit["review_date"]; ?>">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">

                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Rate</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="txtrate" name="txtrate" placeholder="Rate Here" required value="<?php echo $rowedit["rate"]; ?>" onkeypress="return NumberValidation(event)">
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Comment</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtcomment" name="txtcomment" placeholder="Comment Here" required value="<?php echo $rowedit["comment"]; ?>">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- button start -->
                      <div class="form-group row">
                          <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=review.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
      $get_orderid =$_GET["pk"];
      $sqldelete = "DELETE FROM review WHERE order_id='$get_orderid'";
      $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
      if ($resultdelete)
      {
        echo '<script> alert("Record is Deleted");
              window.location.href="index.php?pg=review.php&option=view";</script>';
      }
      }
      }
      ?>
      </body>
