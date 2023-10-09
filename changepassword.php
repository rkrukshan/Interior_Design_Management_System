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
if($system_usertype!="Guest")
{//allow only login users
include "config.php";
if(isset($_POST["btnchangepassword"]))
{
  $currentpassword=md5($_POST["txtpassword"]);
  $newpassword=md5($_POST["txtnewpassword"]);
  $cnewpassword=md5($_POST["txtcnewpassword"]);

  $sqlpassword= "SELECT password FROM login WHERE user_name='$system_username'";
  $resultpassword= mysqli_query($con,$sqlpassword) or die ("Error in sqlpassword" . myssqli_error($con));
  $rowpassword= mysqli_fetch_assoc($resultpassword);

  if($rowpassword["password"]==$currentpassword)
  {//current password correct
    if($newpassword==$cnewpassword)
    {//new passwordis match
      $sqlupdate="UPDATE login SET password='$newpassword' WHERE user_name='$system_username'";
      $resultupdate= mysqli_query($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
      session_destroy();
      echo '<script> alert("Login With Your New Password");
            window.location.href="index.php?pg=login.php";</script>';
    }
    else
    {//new passwordis is not match
          echo '<script> alert("Your new Password is not Match"); </script>';
    }
  }
  else
  {//current password wrong
    echo '<script> alert("Your current Password is Wrong"); </script>';
  }
}
?>
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
                  <img src="img/pics/changepassword.png" height="100" width="100">
                  <h4 class="card-title">Change Password</h4>
                </center>
                <!-- field start -->
                <div class="form-group row">
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">User Name</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="txtusername" name="txtusername"
                      placeholder="User Name Here"  value="<?php echo $system_username; ?>" readonly required>
                  </div>
                  <br><br><br>
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">Current Password</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="txtpassword" name="txtpassword"
                      placeholder="Current Password Here" required>
                  </div>
                  <br><br><br>
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">New Password</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="txtnewpassword" name="txtnewpassword"
                      placeholder="New Password Here" required>
                  </div>
                  <br><br><br>
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">Confirm New Password</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="txtcnewpassword" name="txtcnewpassword"
                      placeholder="Confirm New Password Here" required>
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
	echo '<script> window.location.href="index.php";</script>';
}
?>
