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
if ($system_usertype != "Guest") 
{//allow only login users
    include "config.php";
	
	if ($system_usertype== "Customer") 
	{//for customer
		$get_customerid =$system_userid;
		$sqlfullview = "SELECT * FROM customer WHERE customer_id  ='$get_customerid'";
		$resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
		$rowfullview=mysqli_fetch_assoc($resultfullview);
		?>
		<div class="card">
		<div class="card-body">
		<center><h5 class="card-title">Profile</h5></center>
		<div class="table-responsive">
		<table id="zero_config" class="table table-striped table-bordered">
		  <tr><th>customer ID</th><td><?php echo $rowfullview["customer_id"]; ?></td></tr>
		  <tr><th>Name</th><td><?php echo $rowfullview["name"]; ?></td></tr>
		  <tr><th>NIC</th><td><?php echo $rowfullview["nic"]; ?></td></tr>
		  <tr><th>Date of Brith</th><td><?php echo $rowfullview["dob"]; ?></td></tr>
		  <tr><th>Gender</th><td><?php echo $rowfullview["gender"]; ?></td></tr>
		  <tr><th>mobile</th><td><?php echo $rowfullview["mobile"]; ?></td></tr>
		  <tr><th>Email</th><td><?php echo $rowfullview["email"]; ?></td></tr>
		  <tr><th>Address</th><td><?php echo $rowfullview["address"]; ?></td></tr>

		  <tr>
			<td colspan="2">
			  <center>
				<a href="index.php"><button class="btn btn-primary">Go Back</button></a>&nbsp;
				<a href="index.php?pg=profile_edit.php"><button class="btn btn-info">Edit</button></a>&nbsp;

			  </center>
			</td>
		  </tr>
		</table>
		</div>
		</div>
		</div>
		<?php
	}
	else
	{//for staff
		$get_staffid=$system_userid;
		$sqlfullview = "SELECT * FROM staff WHERE staff_id='$get_staffid'";
		$resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
		$rowfullview=mysqli_fetch_assoc($resultfullview);
		?>
		<div class="card">
			<div class="card-body">
				<center><h5 class="card-title">Profile</h5></center>
				<div class="table-responsive">
					<table id="zero_config" class="table table-striped table-bordered">
						<tr><th>Staff Id</th><td><?php echo $rowfullview["staff_id"]; ?></td></tr>
						<tr><th>Name</th><td><?php echo $rowfullview["name"]; ?></td></tr>
						<tr><th>NIC</th><td><?php echo $rowfullview["nic"]; ?></td></tr>
						<tr><th>Date of Birth</th><td><?php echo $rowfullview["dob"]; ?></td></tr>
						<tr><th>Gender</th><td><?php echo $rowfullview["gender"]; ?></td></tr>
						<tr><th>Mobile</th><td><?php echo $rowfullview["mobile"]; ?></td></tr>
						<tr><th>Email</th><td><?php echo $rowfullview["email"]; ?></td></tr>
						<tr><th>Designation</th><td><?php echo $rowfullview["designation"]; ?></td></tr>
						<tr><th>Join Date</th><td><?php echo $rowfullview["join_date"]; ?></td></tr>
						<tr><th>Address</th><td><?php echo $rowfullview["address"]; ?></td></tr>
						<tr>
							<td colspan="2">
								<center>
									<a href="index.php"><button class="btn btn-primary">Go Back</button></a>&nbsp;
									<a href="index.php?pg=profile_edit.php"><button class="btn btn-info">Edit</button></a>&nbsp;
								</center>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<?php
	}
} 
else 
{
    echo '<script>window.location.href="index.php";</script>';
}
?>