<?php
if (!isset($_SESSION))
{
    session_start();
}


if(isset($_SESSION["login_usertype"]))
{//some one is login
  $system_usertype=$_SESSION["login_usertype"];
  $system_username=$_SESSION["login_username"];
  $system_userid=$_SESSION["login_userid"];
}
else
{//guest
  $system_usertype="Guest";
}
if ($system_usertype == "Guest")
{//allow only Guest users

include "config.php";
if(isset($_POST["btnrecover"]))
{
  $enterusername=$_POST["txtusername"];
  $entermobilenumber=$_POST["txtmobile"];

  $sqlusername="SELECT * FROM login WHERE user_name='$enterusername'";
  $resultusername=mysqli_query($con,$sqlusername) or die("Error in sqlusername" . mysqli_error($con));
  if (mysqli_num_rows($resultusername)==1)
  {//username is correct
    $rowusername=mysqli_fetch_assoc($resultusername);
    if($rowusername["user_type"]=="Customer")
	  {
		$sqlmobile="SELECT mobile FROM customer WHERE NIC='$enterusername'";//Set NIC as user Name
	  }
	  else
	  {
		$sqlmobile="SELECT mobile FROM staff WHERE NIC='$enterusername'";//Set NIC as user Name
	  }
	  $resultmobile=mysqli_query($con,$sqlmobile) or die ("Error in sqlmobile" . mysqli_error($con));
	  $rowmobile=mysqli_fetch_assoc($resultmobile);

	  if($rowmobile["mobile"]==$entermobilenumber)
	  {//mobile n.o correct
		$verificationcode=rand(1000,9999);//4 digits for OTP Code

		$sqlupdate="UPDATE login SET code='$verificationcode' WHERE user_name='$enterusername'";
		$resultupdate=mysqli_query($con,$sqlupdate) or die ("Error in sqlupdate" . mysqli_error($con));
		//SMS send code
		$user = "94769669804";
		$password = "3100";
		$text = urlencode("Your OTP Code is" .$verificationcode);
		$to = "94" .$rowmobile["mobile"];

		$baseurl ="http://www.textit.biz/sendmsg";
		$url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
		$ret = file($url);

		$res= explode(":",$ret[0]);

		if (trim($res[0])=="OK")
		{//OTP send
		  if(isset($_SESSION["forgetusername"]))
		  {
		  unset($_SESSION["forgetusername"]);
		  }
		  $_SESSION["verificationcode_username"]=$rowusername["user_name"];
		  //location change for verificationcode.php
		  echo '<script> alert ("Please Check Your Mobile");
		  window.location.href="index.php?pg=verificationcode.php";</script>';
		}
		else
		{//OTP isn't send
		echo '<script> alert("Please Check Your Internet Conection"); </script>';
		}

	  }
	  else
	  {//mobile n.o wrong
		echo '<script> alert("The Mobile Number that you Enter is wrong"); </script>';
	  }
}
  else
  {//Internet is connected but OTP isn't send then user name is wrong
    echo '<script> alert("There is no username exist like that"); </script>';
  }
}
if(isset($_SESSION["forgetusername"]))
{//user came from login after 3 attempts (forgetpassword.php)
  $username=$_SESSION["forgetusername"];
  $readonlystatus="readonly";
  //this $readonlystatus variable to assign with html's readonly value because 2 cases of login users(can't change user name)and come through link(make blank)
}
else
{// user came through forgetpassword link
  $username="";
  $readonlystatus="";
}
?>
<body>
  <!-- form section start -->
  <section>
    <div class="container">
      <div class="row">
		<div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="card">
            <form class="form-horizontal" method="POST" action="">
              <div class="card-body">
                <center>
                  <img src="img/pics/forgotPassword.png" height="150" width="150">
                  <h4 class="card-title">Forget Password</h4>
                </center>
                <!-- field start -->
                <div class="form-group row">
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">User Name</label>
                  <div class="col-sm-6">

                    <input type="text" class="form-control" id="txtusername" name="txtusername"
                      placeholder="User Name Here" autocomplete="off" value="<?php  echo $username; ?>" <?php echo $readonlystatus; ?> required>
                  </div>
                  <br><br><br>
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">Mobile</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="txtmobile" name="txtmobile"
                      placeholder="Mobile Number Here" required onkeypress="return NumberValidation(event)" onblur="MobileNumberValidation('txtmobile')">
                  </div>
                </div>
                <!-- field end -->

                <!-- button start -->
                <div class="form-group row">
                  <div class="col-sm-12">
                    <center>
                      <input type="reset" class="btn btn-danger" id="btnclear" name="btnclear" value="Clear">
                      <input type="submit" class="btn btn-success" id="btnrecover" name="btnrecover" value="Recover">
                    </center>
                    <br>
                    <center><a href="index.php?pg=login.php">Back to Login</a></center>
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
    echo '<script>window.location.href="index.php";</script>';
}
?>
