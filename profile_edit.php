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
if ($system_usertype != "Guest")
{//allow only login users
    include "config.php";

	//customer update start
	if(isset($_POST["btnsavechanges_customer"]))
	{// Get mobile number in a variable
		$sqlmobile="SELECT mobile FROM customer WHERE customer_id='$system_userid'";
		$resultmobile=mysqli_query($con,$sqlmobile) or die ("Error in sqlmobile . mysqli_error($con)");
		$rowmobile=mysqli_fetch_assoc($resultmobile);

		$sqlupdate="UPDATE customer SET
									name='".mysqli_real_escape_string($con,$_POST["txtname"])."',
									nic='".mysqli_real_escape_string($con,$_POST["txtnic"])."',
									dob='".mysqli_real_escape_string($con,$_POST["txtdob"])."',
									gender='".mysqli_real_escape_string($con,$_POST["txtgender"])."',
									email='".mysqli_real_escape_string($con,$_POST["txtemail"])."',
									address='".mysqli_real_escape_string($con,$_POST["txtaddress"])."'
									WHERE customer_id='".mysqli_real_escape_string($con,$_POST["txtcustomerid"])."'";
		$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
		if ($resultupdate)
		{
			if($rowmobile["mobile"]==$_POST["txtmobile"])
			{
				echo '<script> alert("Data updated Sucessfully");
					window.location.href="index.php?pg=profile.php";</script>';
			}
			else
			{
				$newmobile=substr($_POST["txtmobile"], 1,9);

				$verificationcode=rand(1000,9999);

				$sqlupdate="UPDATE login SET code='$verificationcode' WHERE user_id='$system_userid'";
				$resultupdate=mysqli_query($con,$sqlupdate) or die ("Error in sqlupdate" . mysqli_error($con));
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
				  $_SESSION["profile_mobile"]=$newmobile;
				  //location change for verificationcode_profile.php
				  echo '<script> alert ("Please Check Your Mobile");
				  window.location.href="index.php?pg=verificationcode_profile.php";</script>';
				}
				else
				{//OTP isn't send
				echo '<script> alert("Please Check Your Internet Conection"); </script>';
				}
			}
		}
	}
	//customer update end

	//staff update start
	if(isset($_POST["btnsavechanges_staff"]))
	{
		$sqlmobile="SELECT mobile FROM staff WHERE staff_id='$system_userid'";
		$resultmobile=mysqli_query($con,$sqlmobile) or die ("Error in sqlmobile . mysqli_error($con)");
		$rowmobile=mysqli_fetch_assoc($resultmobile);

		$sqlupdate="UPDATE staff SET
									name='".mysqli_real_escape_string($con,$_POST["txtname"])."',
									nic='".mysqli_real_escape_string($con,$_POST["txtnic"])."',
									dob='".mysqli_real_escape_string($con,$_POST["txtdob"])."',
									gender='".mysqli_real_escape_string($con,$_POST["txtgender"])."',
									email='".mysqli_real_escape_string($con,$_POST["txtemail"])."',
									designation='".mysqli_real_escape_string($con,$_POST["txtdesignation"])."',
									join_date='".mysqli_real_escape_string($con,$_POST["txtjoindate"])."',
									address='".mysqli_real_escape_string($con,$_POST["txtaddress"])."'
									WHERE staff_id='".mysqli_real_escape_string($con,$_POST["txtstaffid"])."'";
		$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
		if ($resultupdate)
		{
			if($rowmobile["mobile"]==$_POST["txtmobile"])
			{
				echo '<script> alert("Data updated Sucessfully");
					window.location.href="index.php?pg=profile.php";</script>';
			}
			else
			{
				$newmobile=substr($_POST["txtmobile"], 1,9);

				$verificationcode=rand(1000,9999);

				$sqlupdate="UPDATE login SET code='$verificationcode' WHERE user_id='$system_userid'";
				$resultupdate=mysqli_query($con,$sqlupdate) or die ("Error in sqlupdate" . mysqli_error($con));
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
				  $_SESSION["profile_mobile"]=$newmobile;
				  //location change for verificationcode_profile.php
				  echo '<script> alert ("Please Check Your Mobile");
				  window.location.href="index.php?pg=verificationcode_profile.php";</script>';
				}
				else
				{//OTP isn't send
				echo '<script> alert("Please Check Your Internet Conection"); </script>';
				}
			}
		}

	}
	//staff update end


	if ($system_usertype== "Customer")
	{//for customer
		$get_customerid=$system_userid;
		$sqledit="SELECT * FROM customer WHERE customer_id ='$get_customerid'";
		$resultedit=mysqli_query($con,$sqledit) or die ("Error in sqlediit" . mysqli_error($con));
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
						<center><h4 class="card-title">Profile Edit</h4></center>
						<!-- field start -->
						<div class="form-group row">
											  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Customer ID</label>
											  <div class="col-sm-3">
												  <input type="text" class="form-control" id="txtcustomerid" name="txtcustomerid" placeholder="Customer id Here" required readonly value="<?php echo $rowedit["customer_id"]; ?>">
											  </div>

						  <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Name</label>
											  <div class="col-sm-3">
												  <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Name Here" required  value="<?php echo $rowedit["name"]; ?>" onkeypress="return TextValidation(event)">
											  </div>
										  </div>
						<!-- field end -->

						<!-- field start -->
						<div class="form-group row">
											  <label for="fname" class="col-sm-3 text-right control-label col-form-label">NIC</label>
											  <div class="col-sm-3">
												  <input type="text" class="form-control" id="txtnic" name="txtnic" placeholder="NIC Here" required readonly value="<?php echo $rowedit["nic"]; ?>" onblur="NICNumberValidation()">
											  </div>

						  <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Date of Birth</label>
											  <div class="col-sm-3">
												  <input type="date" class="form-control" id="txtdob" name="txtdob" placeholder="Date of Birth Here" required readonly value="<?php echo $rowedit["dob"]; ?>">
											  </div>
										  </div>
						<!-- field end -->

						<!-- field start -->
						<div class="form-group row">
											  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Gender</label>
											  <div class="col-sm-3">
												  <input type="text" class="form-control" id="txtgender" name="txtgender" placeholder="Gender Here" required readonly value="<?php echo $rowedit["gender"]; ?>" onkeypress="return TextValidation(event)">
											  </div>

						  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile N.O</label>
											  <div class="col-sm-3">
												  <input type="number" class="form-control" id="txtmobile" name="txtmobile" placeholder="Mobile N.O Here" required  value="0<?php echo $rowedit["mobile"]; ?>" onkeypress="return NumberValidation(event)" onblur="MobileNumberValidation('txtmobile')">
											  </div>
										  </div>
						<!-- field end -->

						<!-- field start -->
						<div class="form-group row">
											  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
											  <div class="col-sm-3">
												  <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email Address Here" required  value="<?php echo $rowedit["email"]; ?>" onblur="EmailValidation()">
											  </div>

						  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
											  <div class="col-sm-3">
												  <input type="text" class="form-control" id="txtaddress" name="txtaddress" placeholder="Address Here" required  value="<?php echo $rowedit["address"]; ?>">
											  </div>
										  </div>
						<!-- field end -->

						<!-- button start -->
						<div class="form-group row">
											  <div class="col-sm-12">
							<center>
							  <a href ="index.php?pg=profile.php"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
							  <input type="reset" class="btn btn-danger" id="btncancel" name="btncancel" value="Cancel">
							  <input type="submit" class="btn btn-success" id="btnsavechanges_customer" name="btnsavechanges_customer" value="Save Changes">
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
	else
	{//for staff
		$get_staffid=$system_userid;
		$sqledit="SELECT * FROM staff WHERE staff_id ='$get_staffid'";
		$resultedit=mysqli_query($con,$sqledit) or die ("Error in sqlediit" . mysqli_error($con));
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
									<center><h4 class="card-title">Profile Edit </h4></center>

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Staff ID</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtstaffid" name="txtstaffid" placeholder="staff id Here" value="<?php echo $rowedit["staff_id"]; ?>" readonly required>
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Name</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Name Here" value="<?php echo $rowedit["name"]; ?>" required onkeypress="return TextValidation(event)">
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">NIC</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtnic" name="txtnic" placeholder="NICHere" value="<?php echo $rowedit["nic"]; ?>" required readonly onblur="NICNumberValidation()">
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> DOB</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="txtdob" name="txtdob" placeholder="Date of birth Here" value="<?php echo $rowedit["dob"]; ?>" readonly required>
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Gender</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtgender" name="txtgender" placeholder="Gender Here" value="<?php echo $rowedit["gender"]; ?>" required readonly onkeypress="return TextValidation(event)">
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Mobile</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" id="txtmobile" name="txtmobile" placeholder="Mobile Here" value="0<?php echo $rowedit["mobile"]; ?>" required onkeypress="return NumberValidation(event)"  onblur="MobileNumberValidation('txtmobile')">
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                                        <div class="col-sm-3">
                                            <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email Here" value="<?php echo $rowedit["email"]; ?>" required onblur="EmailValidation()">
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Designation</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtdesignation" name="txtdesignation" placeholder="Designation Here" value="<?php echo $rowedit["designation"]; ?>" readonly required>
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Join Date</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="txtjoindate" name="txtjoindate" placeholder="Join Date Here" value="<?php echo $rowedit["join_date"]; ?>" readonly required>
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Address</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtaddress" name="txtaddress" placeholder="Address Here" value="<?php echo $rowedit["address"]; ?>" required>
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- button start -->
									<div class="form-group row">
                                        <div class="col-sm-12">
											<center>
												<a href ="index.php?pg=profile.php"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
												<input type="reset" class="btn btn-danger" id="btncancel" name="btncancel" value="Cancel">
												<input type="submit" class="btn btn-success" id="btnsavechanges_staff" name="btnsavechanges_staff" value="Save Changes">
											</center>
                                        </div>
                                    </div>
									<!-- button end -->

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>.
		</section>
		<!-- form section end -->
		<?php
	}
}
else
{
    echo '<script>window.location.href="index.php";</script>';
}
?>
