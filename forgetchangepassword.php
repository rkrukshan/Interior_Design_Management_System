<?php
if (!isset($_SESSION))
{
    session_start();
}
if(isset($_SESSION["forgetchange_username"]))
{
include "config.php";
$enterusername=$_SESSION["forgetchange_username"];
if(isset($_POST["btnchangepassword"]))
{//password is match
  $newpassword=md5($_POST["txtnewpassword"]);
  $cnewpassword=md5($_POST["txtcnewpassword"]);
  if($newpassword==$cnewpassword)
  {
    $sqlupdate="UPDATE login SET password='$newpassword' WHERE user_name='$enterusername'";
    $resultupdate=mysqli_query($con,$sqlupdate) or die ("Error in sqlupdate" . mysqli_error($con));
    unset($_SESSION["forgetchange_username"]);
    echo '<script> alert ("Your New Password is Updated");
			window.location.href="index.php?pg=login.php";</script>';

  }
  else
  {//password is not match
    echo '<script> alert("Your Password is not Match");</script>';
  }
}
?>
<!--confirm passwrd validation-->
<script>
function confirmpassword()
{
var newpassword=document.getElementById("txtnewpassword").value;
var cnewpassword=document.getElementById("txtcnewpassword").value;
if (newpassword==cnewpassword)
  {
  return true;
  }
else
  {
  alert("Your Password is not Match");
  document.getElementById("txtnewpassword").value="";
  document.getElementById("txtcnewpassword").value="";
  return false;
  }
}
</script>
<body>
  <!-- form section start -->
  <section >
    <div class="container">
      <div class="row">
		<div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="card">
            <form class="form-horizontal" method="POST" action="" onsubmit="return confirmpassword()">
              <div class="card-body">
                <center>
                  <img src="img/pics/forgetchangePassword.png" height="100" width="100">
                  <h4 class="card-title">Forget Change Password</h4>
                </center>
                <!-- field start -->
                <div class="form-group row">
                  <label for="fname"  class="col-sm-4 text-right control-label col-form-label">User Name</label>
                  <div class="col-sm-6">

                    <input type="text" class="form-control" id="txtusername" name="txtusername" value="<?php echo $enterusername; ?>" readonly
                      placeholder="User Name Here"  value="" required>
                  </div>
                  <br><br><br>
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">Password</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="txtnewpassword" name="txtnewpassword"
                      placeholder="Password Here" required>
                  </div>
                  <br><br><br>
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">Confirm Password</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control"  id="txtcnewpassword" name="txtcnewpassword"
                      placeholder="Password Here" required>
                  </div>
                </div>
                <!-- field end -->

                <!-- button start -->
                <div class="form-group row">
                  <div class="col-sm-12">
                    <center>

                      <input type="reset" class="btn btn-danger" id="btnclear" name="btnclear" value="Clear">
                      <input type="submit" class="btn btn-success" id="btnchangepassword" name="btnchangepassword" value="Change Password">
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
