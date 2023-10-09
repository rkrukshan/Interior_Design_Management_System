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
//login submit start
if(isset($_POST["btnlogin"]))
{
  $enterusername=$_POST["txtusername"];
  $enterpassword=md5($_POST["txtpassword"]);

	//check user name with Database's value start

  $sqlusername="SELECT * FROM login WHERE user_name='$enterusername'";//compare database's value and the value entered on login page's input field
  $resultusername=mysqli_query($con,$sqlusername) or die("Error in sqlusername" . mysqli_error($con));
  if(mysqli_num_rows($resultusername)==1)
  {//for checking if correct username enter
    $rowusername=mysqli_fetch_assoc($resultusername);

	//check user name with Database's value end



	//check user name and password with Database's value start

	$sqlpassword="SELECT * FROM login WHERE user_name='$enterusername' AND password='$enterpassword'";
    $resultpassword=mysqli_query($con,$sqlpassword) or die("Error in sqlpassword" . mysqli_error($con));
    if(mysqli_num_rows($resultpassword)==1)//for checking if correct password enter
    {//if username and password both are correct
      $sqlupdate="UPDATE login SET attempt=0 WHERE user_name='$enterusername' AND password='$enterpassword'";
      $resultupdate=mysqli_query($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));

	 //check user name and password with Database's value end

	  //status=Active means if a registered user is login into the system (person who registered into the system except the banned/blocked user )
	  if ($rowusername["status"]=="Active")
      {
        $_SESSION["login_username"]=$rowusername["user_name"];
        $_SESSION["login_userid"]=$rowusername["user_id"];
        $_SESSION["login_usertype"]=$rowusername["user_type"];
        if(isset($_SESSION["session_addtocart"]))//if session set on add to cart
        {//for Active user access
          echo '<script> window.location.href="index.php?pg=order_product.php&option=add";</script>';
        }
        else 
        {//for Guest user access
          echo '<script>window.location.href="index.php";</script>';
        }
        
      }
      else
      {
          echo '<script> alert("Your Account has been Deleted"); </script>';

      }
    }
    else if($rowusername["attempt"]<3)
    {//username is correct password is wrong and less than 3 attempt
      $sqlupdate="UPDATE login SET attempt=attempt+1 WHERE user_name='$enterusername'";
      $resultupdate=mysqli_query($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
      echo '<script> alert("Invalid Password"); </script>';
    }
    else
    { //If username is correct password is wrong Assign SESSION for Username with Forget Username
      $_SESSION["forgetusername"]=$rowusername['user_name']; //To display the username in  forgetpassword.php within the field of username
      echo '<script>alert("Sorry, you try more than three times please recover your password!!");
					window.location.href="index.php?pg=forgetpassword.php";</script>';
    }

  }
  else
  {//username wrong
      echo '<script> alert("There is no username exist like that"); </script>';
  }
}
//login submit end
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
                  <img src="img/pics/lock1.png" height="100" width="100">
            <h4 class="card-title">Login</h4>
                </center>

                <!-- field start -->
                <div class="form-group row">
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">User Name</label>
                  <div class="col-sm-6">

                    <input type="text" class="form-control" id="txtusername" name="txtusername"
                      placeholder="User Name Here" autocomplete="on" value="" required>
                  </div>
                  <br><br><br>
                  <label for="fname" class="col-sm-4 text-right control-label col-form-label">Password</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="txtpassword" name="txtpassword"
                      placeholder="Password Here" autocomplete="on" required>
                  </div>
                </div>
                <!-- field end -->

                <!-- button start -->
                <div class="form-group row">
                  <div class="col-sm-12">
                    <center>

                      <input type="reset" class="btn btn-danger" id="btnclear" name="btnclear" value="Clear">
                      <input type="submit" class="btn btn-success" id="btnlogin" name="btnlogin" value="Login">
                    </center>
                    <br>
                    <center><a href="index.php?pg=forgetpassword.php">Forget Your Password?</a></center>
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
{// For Guest
    echo '<script>window.location.href="index.php";</script>';
}
?>
