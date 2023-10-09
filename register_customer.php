<?php
if(!isset($_SESSION))
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
//insert sql start
if(isset($_POST["btnsave"]))
{
  $sqlinsert="INSERT INTO customer(customer_id,name,nic,dob,gender,mobile,email,address)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtcustomerid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtname"])."',
        '".mysqli_real_escape_string($con,$_POST["txtnic"])."',
        '".mysqli_real_escape_string($con,$_POST["txtdob"])."',
        '".mysqli_real_escape_string($con,$_POST["txtgender"])."',
        '".mysqli_real_escape_string($con,$_POST["txtmobile"])."',
        '".mysqli_real_escape_string($con,$_POST["txtemail"])."',
        '".mysqli_real_escape_string($con,$_POST["txtaddress"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));

//insertinto login
	$password=md5($_POST["txtnic"]);
  $verificationcode=rand(1000,9999);
	$sqlinsertlogin="INSERT INTO login(user_name,user_id,password,user_type,status,attempt,code)
							VALUES('".mysqli_real_escape_string($con,$_POST["txtnic"])."',
									'".mysqli_real_escape_string($con,$_POST["txtcustomerid"])."',
									'".mysqli_real_escape_string($con,$password)."',
									'".mysqli_real_escape_string($con,"Customer")."',
									'".mysqli_real_escape_string($con,"Pending")."',
									'".mysqli_real_escape_string($con,0)."',
									'".mysqli_real_escape_string($con,$verificationcode)."')";
	$resultinsertlogin = mysqli_query($con,$sqlinsertlogin) or die ("sql error in sqlinsertlogin ". mysqli_error($con));
if($resultinsert)
{
  $newmobile=substr($_POST["txtmobile"], 1,9);
  //SMS send code
  $user = "94769669804";
  $password = "3100";
  $text = urlencode("Your OTP Code is" .$verificationcode);
  $to = "94" .$newmobile;

  $baseurl ="http://www.textit.biz/sendmsg";
  $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
  $ret = file($url);

  $res= explode(":",$ret[0]);

  if (trim($res[0])=="OK")
  {//OTP send
    $_SESSION["register_customerid"]=$_POST["txtcustomerid"];
    //location change for verificationcode_profile.php
    echo '<script> alert ("Please Check Your Mobile");
    window.location.href="index.php?pg=verificationcode_register.php";</script>';
  }
  else
  {//OTP isn't send
  echo '<script> alert("Please Check Your Internet Conection"); </script>';
  }
}
}
//insert sql end
?>
<script>
//mobile number exist or not in option add,EDIT
function mobileexist(mobile_text_box_name,option_name)
{
	var mobileno=document.getElementById(mobile_text_box_name).value;
	if(option_name=="edit")
	{//if option edit get customerid
		var customerid=document.getElementById("txtcustomerid").value;
	}
	else
	{//otherwise no need customerid
		var customerid="";
	}

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var get_response = xmlhttp.responseText.trim();
			if(get_response=="YES")
			{
				alert("Sorry This Mobile number is already Entered");
				document.getElementById(mobile_text_box_name).value="";
				document.getElementById(mobile_text_box_name).focus();
			}
			else
			{
				MobileNumberValidation(mobile_text_box_name);
			}
		}
	};
	xmlhttp.open("GET", "ajaxpage.php?frompage=customer_mobile&ajaxmobile=" + mobileno+"&ajaxoption="+option_name+"&ajaxcustomerid="+customerid, true);
	xmlhttp.send();
}
</script>
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
                <img src="img/pics/newcustomer.png" height="100" width="100">
                <h4 class="card-title">Register Customer</h4></center>
              <!-- field start -->
              <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Customer ID</label>
                                    <div class="col-sm-3">
                                      <?php
                                      $sqlgenerateid="SELECT customer_id FROM customer ORDER BY customer_id DESC LIMIT 1";
                                      $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                                      $n=mysqli_num_rows($resultgenerateid);//count the number of records
                                      if($n==1)
                                      {//for other than 1st time
                                          $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                                          $generateid=++$rowgenerateid["customer_id"];
                                      }
                                      else
                                        {//For 1st time
                                            $generateid="CUS0001";
                                        }
                                      ?>
                                        <input type="text" class="form-control" id="txtcustomerid" name="txtcustomerid" placeholder="Customer id Here" value="<?php echo $generateid; ?>" readonly required >
                                    </div>

                <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Name Here" required onkeypress="return TextValidation(event)">
                                    </div>
                                </div>
              <!-- field end -->

              <!-- field start -->
              <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">NIC</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="txtnic" name="txtnic" placeholder="NIC Here" required onblur="NICexist()">
                                    </div>
                                    <input type="hidden" class="form-control" id="txtdob" name="txtdob" placeholder="Date of Birth Here" required readonly>
                                    <input type="hidden" class="form-control" id="txtgender" name="txtgender" placeholder="Gender Here" required readonly onkeypress="return TextValidation(event)">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile N.O</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="txtmobile" name="txtmobile" placeholder="Mobile N.O Here" required onkeypress="return NumberValidation(event)" onblur="mobileexist('txtmobile','add')">
                                                        </div>
                                </div>
              <!-- field end -->

              <!-- field start -->
              <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                                    <div class="col-sm-3">
                                        <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email Address Here" required onblur="EmailValidation()">
                                    </div>

                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="txtaddress" name="txtaddress" placeholder="Address Here" required>
                                    </div>
                                </div>
              <!-- field end -->

              <!-- button start -->
              <div class="form-group row">
                                    <div class="col-sm-12">
                  <center>
                    <a href ="index.php"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
                    <input type="reset" class="btn btn-danger" id="btnclear" name="btnclear" value="Clear">
                    <input type="submit" class="btn btn-success" id="btnsave" name="btnsave" value="Register">
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

<?php
}
else
{
  echo '<script>window.location.href="index.php";</script>';
}
?>
