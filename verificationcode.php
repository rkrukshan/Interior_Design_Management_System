<?php
if (!isset($_SESSION))
{
      session_start();
}
if(isset($_SESSION["verificationcode_username"]))
{
include "config.php";
if(isset($_POST["btnverify"]))
{
  $entercode=$_POST["txtcode"];
  $enterusername=$_SESSION["verificationcode_username"];

  $sqlcode="SELECT code FROM login WHERE user_name='$enterusername'";
  $resultcode=mysqli_query($con,$sqlcode) or die("Error in sqlcode".mysqli_error($con));
  $rowcode=mysqli_fetch_assoc($resultcode);

  if($rowcode["code"]==$entercode)
  {//code is Correct
    unset($_SESSION["verificationcode_username"]);
    $_SESSION["forgetchange_username"]=$enterusername;
    echo '<script> alert("Please Change Your Password");
    window.location.href="index.php?pg=forgetchangepassword.php";</script>';
  }
  else
  {//code is wrong
      echo '<script> alert("Invalid Code"); </script>';
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
    echo '<script>window.location.href="index.php?pg=forgetpassword.php";</script>';
}
?>
