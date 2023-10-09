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
if(isset($_SESSION["register_customerid"]))
{
include "config.php";
if(isset($_POST["btnverify"]))
{
  $entercode=$_POST["txtcode"];
  $enteruserid=$_SESSION["register_customerid"];

  $sqlcode="SELECT code FROM login WHERE user_id='$enteruserid'";
  $resultcode=mysqli_query($con,$sqlcode) or die("Error in sqlcode".mysqli_error($con));
  $rowcode=mysqli_fetch_assoc($resultcode);
  unset($_SESSION["register_customerid"]);
  if($rowcode["code"]==$entercode)
  {//code is Correct

    $sqlupdate="UPDATE login SET
								status='".mysqli_real_escape_string($con,"Active")."'
								WHERE user_id='".mysqli_real_escape_string($con,$enteruserid)."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));


    echo '<script> alert("You Register successfully, Your User Name and password are your NIC");
    window.location.href="index.php?pg=login.php";</script>';
  }
  else
  {//code is wrong
    $sqldelete="DELETE FROM  login
                WHERE user_id='".mysqli_real_escape_string($con,$enteruserid)."'";
  $resultdelete=mysqli_query ($con,$sqldelete) or die("Error in sqldelete" . mysqli_error($con));
  $sqldelete="DELETE FROM  customer
              WHERE customer_id='".mysqli_real_escape_string($con,$enteruserid)."'";
$resultdelete=mysqli_query ($con,$sqldelete) or die("Error in sqldelete" . mysqli_error($con));
      echo '<script> alert("Invalid Code");
        window.location.href="index.php?pg=register_customer.php";</script>';
  }
}
?>
<body>
  <!-- form section start -->
  <section >
    <div class="container">
      <div class="row">
		<div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="card">
            <form class="form-horizontal" method="POST" action="">
              <div class="card-body">
                <center>
                  <img src="img/pics/recoverpassword.png" height="100" width="100">
                  <h4 class="card-title">One Time Password (OTP)</h4>
                </center>
                <!-- field start -->
                <div class="form-group row">
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">Code</label>
                  <div class="col-sm-6">

                    <input type="text" class="form-control" id="txtcode" name="txtcode" onkeypress="return NumberValidation(event)"
                      placeholder="OTP Code Here"  value="" required>
                  </div>
                </div>
                <!-- field end -->

                <!-- button start -->
                <div class="form-group row">
                  <div class="col-sm-12">
                    <center>

                      <input type="reset" class="btn btn-danger" id="btnclear" name="btnclear" value="Clear">
                      <input type="submit" class="btn btn-success" id="btnverify" name="btnverify" value="Verify">
                    </center>
                  </div>
                </div>
                <!-- button end -->
              </div>
            </form>
          </div>
        </div>
		<div class="col-md-2"></div>
      </div>
    </div>
  </section>
  <!-- form section end -->
  </body>
<?php
}
else
{
    echo '<script>window.location.href="index.php?pg=register_customer.php";</script>';
}
?>
