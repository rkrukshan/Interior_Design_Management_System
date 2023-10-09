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
if($system_usertype=="Admin"||$system_usertype=="Clerk"||$system_usertype=="Worker")
{//Admin,Clerk,Worker Can Access This Page

include "config.php";
//insert code start
if(isset($_POST["btnsave"]))
{
	$sqlinsert="INSERT INTO staff(staff_id,name,nic,dob,gender,mobile,email,designation,join_date,address)
							VALUES('".mysqli_real_escape_string($con,$_POST["txtstaffid"])."',
									'".mysqli_real_escape_string($con,$_POST["txtname"])."',
									'".mysqli_real_escape_string($con,$_POST["txtnic"])."',
									'".mysqli_real_escape_string($con,$_POST["txtdob"])."',
									'".mysqli_real_escape_string($con,$_POST["txtgender"])."',
									'".mysqli_real_escape_string($con,$_POST["txtmobile"])."',
									'".mysqli_real_escape_string($con,$_POST["txtemail"])."',
									'".mysqli_real_escape_string($con,$_POST["txtdesignation"])."',
									'".mysqli_real_escape_string($con,$_POST["txtjoindate"])."',
									'".mysqli_real_escape_string($con,$_POST["txtaddress"])."')";
	$resultinsert = mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert ". mysqli_error($con));

	//insertinto login
	$password=md5($_POST["txtnic"]);
	$sqlinsertlogin="INSERT INTO login(user_name,user_id,password,user_type,status,attempt,code)
							VALUES('".mysqli_real_escape_string($con,$_POST["txtnic"])."',
									'".mysqli_real_escape_string($con,$_POST["txtstaffid"])."',
									'".mysqli_real_escape_string($con,$password)."',
									'".mysqli_real_escape_string($con,$_POST["txtdesignation"])."',
									'".mysqli_real_escape_string($con,"Active")."',
									'".mysqli_real_escape_string($con,0)."',
									'".mysqli_real_escape_string($con,0)."')";
	$resultinsertlogin = mysqli_query($con,$sqlinsertlogin) or die ("sql error in sqlinsertlogin ". mysqli_error($con));
	if ($resultinsert)
	{
		echo '<script> alert(" Data stored success "); </script>';
	}

}
//insert code end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE staff SET
								name='".mysqli_real_escape_string($con,$_POST["txtname"])."',
								nic='".mysqli_real_escape_string($con,$_POST["txtnic"])."',
								dob='".mysqli_real_escape_string($con,$_POST["txtdob"])."',
								gender='".mysqli_real_escape_string($con,$_POST["txtgender"])."',
								mobile='".mysqli_real_escape_string($con,$_POST["txtmobile"])."',
								email='".mysqli_real_escape_string($con,$_POST["txtemail"])."',
								designation='".mysqli_real_escape_string($con,$_POST["txtdesignation"])."',
								join_date='".mysqli_real_escape_string($con,$_POST["txtjoindate"])."',
								address='".mysqli_real_escape_string($con,$_POST["txtaddress"])."'
								WHERE staff_id='".mysqli_real_escape_string($con,$_POST["txtstaffid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=staff.php&option=fullview&pk='.$_POST["txtstaffid"].'";</script>';
	}

}
//update code End
?>
<script>
//mobile number exist or not in option add,EDIT
function mobileexist(mobile_text_box_name,option_name)
{
	var mobileno=document.getElementById(mobile_text_box_name).value;
	if(option_name=="edit")
	{//if option edit get staffid 
		var staffid=document.getElementById("txtstaffid").value;
	}
	else
	{//otherwise no need staffid
		var staffid="";
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
	xmlhttp.open("GET", "ajaxpage.php?frompage=staff_mobile&ajaxmobile=" + mobileno+"&ajaxoption="+option_name+"&ajaxstaffid="+staffid, true);
	xmlhttp.send();
}
</script>

<script>
//load designation
function loaddesignation()
{
	
	var designation=document.getElementById("txtdesignations").value;
	
	
	var xmlhttp = new XMLHttpRequest();//start ajax
	xmlhttp.onreadystatechange = function()//check if ready
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)//checkresponce
		{
			var get_response = xmlhttp.responseText.trim();//get responce
			location.reload();//reload page while select each options
		}
	};
	xmlhttp.open("GET", "ajaxpage.php?frompage=staff_designation&ajaxdesignation=" + designation, true);//send ajax
	xmlhttp.send();
}
</script>


<body>
<?php
if (isset($_GET["option"]))
{
    if ($_GET["option"] == "add")
    {
		if($system_usertype=="Admin"||$system_usertype=="Clerk")
		{//Admin,Clerk can go to this Option
        //add form
		?>
		<!-- form section start -->
		<section class="feature_part padding_top">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<form class="form-horizontal" method="POST" action="">
								<div class="card-body">
								<center><img src="img/pics/staff.png" height="100" width="100"></center>
									<center><h4 class="card-title">Add Staff</h4></center>

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Staff ID</label>
                                        <div class="col-sm-3">
											<?php
                      $sqlgenerateid="SELECT staff_id FROM staff ORDER BY staff_id DESC LIMIT 1";
                      $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                      $n=mysqli_num_rows($resultgenerateid);//count the number of records
                      if($n==1)
                      {//for other than 1st time
                          $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                          $generateid=++$rowgenerateid["staff_id"];
                      }
                      else
                        {//For 1st time
                            $generateid="ST001";
                        }
                      ?>
                                            <input type="text" class="form-control" id="txtstaffid" name="txtstaffid" placeholder="staff id Here" value="<?php echo $generateid; ?>" readonly required>
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Name</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Name Here" onkeypress="return TextValidation(event)">
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">NIC</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtnic" name="txtnic" placeholder="NICHere" required onblur="NICexist()">
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> DOB</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="txtdob" name="txtdob" placeholder="Date of birth Here" readonly >
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Gender</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtgender" name="txtgender" placeholder="Gender Here" readonly onkeypress="return TextValidation(event)">
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Mobile</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtmobile" name="txtmobile" placeholder="Mobile Here" onkeypress="return NumberValidation(event)"  onblur="mobileexist('txtmobile','add')">
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                                        <div class="col-sm-3">
                                            <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email Here" required onblur="EmailValidation()">
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Designation</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="txtdesignation" name="txtdesignation" placeholder="Designation Here">
                                              <option value="Select" >Select The Designation </option>
                                              <?php
											  if($system_usertype=="Admin")
											  {
												?>
												  <option value="Admin" >Admin </option>
												  <option value="Clerk" >Clerk </option>
												  <option value="Worker" >Worker </option>
												<?php												
											  }
											  else
											  {
												?>
												  <option value="Worker" >Worker </option>
												<?php  
											  }
												  
											  ?>

											  
                                            </select>
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- field start -->
									<div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Join Date</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="txtjoindate" name="txtjoindate" value="<?php echo date("Y-m-d"); ?>"max="<?php echo date("Y-m-d"); ?>"  placeholder="Join Date Here">
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Address</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtaddress" name="txtaddress" placeholder="Address Here" required>
                                        </div>
                                    </div>
									<!-- field end -->

									<!-- button start -->
									<div class="form-group row">
                                        <div class="col-sm-12">
											<center>
												<a href ="index.php?pg=staff.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
			</div>.
		</section>
		<!-- form section end -->
		<?php
		}
		else 
		{
			echo '<script> window.location.href="index.php?pg=staff.php&option=view";</script>';
		}
    }
    else if ($_GET["option"] == "view")
    {
        //table view
		?>
		<div class="card">
			<div class="card-body">
				<center><h5 class="card-title">Staff View</h5></center>
				<div class="table-responsive">
					<table id="zero_config" class="table table-striped table-bordered">
						<?php 
						if(isset($_GET["pg"]))
						{
							if($system_usertype=="Admin"||$system_usertype=="Clerk")
							{//Admin,Clerk can see the Button
							?>
								<a href="index.php?pg=staff.php&option=add"><button class="btn btn-primary">Add Record</button></a> &nbsp;
								<a href="print.php?pr=staff.php&option=view" target="_blank"><button class="btn btn-primary">Print</button></a>
								
                                        <div class="col-sm-3">
										<label> Designation</label>
											<select class="form-control" id="txtdesignations" onchange="loaddesignation()" name="txtdesignations" >
											<option value="All">All</option>
											<?php 
											$designationarray=array("Admin","Clerk","Worker");//designation array
											for($x=0;$x<count($designationarray);$x++)//loop array
											{
												if(isset($_SESSION["staffdesignation"]))//check ession
												{
													if($designationarray[$x]==$_SESSION["staffdesignation"])//chece 
													{
														echo'<option selected value="'.$designationarray[$x].'" >'.$designationarray[$x].' </option>';
													}
													else 
													{
														echo'<option value="'.$designationarray[$x].'" >'.$designationarray[$x].' </option>';
													}
													
												}
												else //if not set session display all
												{
													echo'<option value="'.$designationarray[$x].'" >'.$designationarray[$x].' </option>';
												}
												
											}
											?>
											</select>
                                        </div>
								<lable>
								<br><br>
							<?php 
							}
						}
						?>
						<thead>
							<tr>
								<th>Staff ID</th>
								<th>Name</th>
								<th>NIC</th>
								<th>Mobile</th>
								<th>Designation</th>
								<?php 
								if(isset($_GET["pg"]))
								{
									?>
									
									<th>Action</th>
								<?php 
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
							if(isset($_SESSION["staffdesignation"]))//if session was set 
							{
								if($_SESSION["staffdesignation"]=="All")//session's value all display all
								{
									$sqlview="SELECT staff_id,name,nic,mobile,designation FROM staff";
								}
								else 
								{//if not  session value's all then display perticular designation staff
									$sqlview="SELECT staff_id,name,nic,mobile,designation FROM staff WHERE designation ='$_SESSION[staffdesignation]'";
								}
								
							}
							else //if not set session show all staff
							{
								$sqlview="SELECT staff_id,name,nic,mobile,designation FROM staff";
							}
							
							$resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
							while($rowview=mysqli_fetch_assoc($resultview))
							{
								echo'<tr>';
									echo '<td>'.$rowview["staff_id"].'</td>';
									echo '<td>'.$rowview["name"].'</td>';
									echo '<td>'.$rowview["nic"].'</td>';
									echo '<td>'.$rowview["mobile"].'</td>';
									echo '<td>'.$rowview["designation"].'</td>';
									if(isset($_GET["pg"]))
									{
										echo '<td>';
											echo '<a href="index.php?pg=staff.php&option=fullview&pk='.$rowview["staff_id"].'"><button class="btn btn-success">View</button></a> ';
											
											$sqlchecklogin="SELECT status FROM login WHERE user_id='$rowview[staff_id]'";
											$resultchecklogin=mysqli_query($con,$sqlchecklogin) or die ("Error in sqlchecklogin" . mysqli_error($con));
											$rowchecklogin=mysqli_fetch_assoc($resultchecklogin);
											if($rowchecklogin["status"]=="Active")
											{	
												if($system_usertype=="Admin"||$system_usertype=="Clerk")
												{//Admin,Clerk can see the Button		
													echo '<a href="index.php?pg=staff.php&option=edit&pk='.$rowview["staff_id"].'"><button class="btn btn-info">Edit</button></a> ';
													echo '<a onclick="return confirmdelete()" href="index.php?pg=staff.php&option=delete&pk='.$rowview["staff_id"].'"><button class="btn btn-danger">Delete</button></a> ';
												}
											}
										echo '</td>';
									}
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
        //table full view
		$get_staffid=$_GET["pk"];
		$sqlfullview = "SELECT * FROM staff WHERE staff_id='$get_staffid'";
		$resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
		$rowfullview=mysqli_fetch_assoc($resultfullview);
		?>
		<div class="card">
			<div class="card-body">
				<center><h5 class="card-title">Staff Full View</h5></center>
				<div class="table-responsive">
					<table id="zero_config" class="table table-striped table-bordered">
						<tr><th>Staff Id</th><td><?php echo $rowfullview["staff_id"]; ?></td></tr>
						<tr><th>Name</th><td><?php echo $rowfullview["name"]; ?></td></tr>
						<tr><th>NIC</th><td><?php echo $rowfullview["nic"]; ?></td></tr>
						<tr><th>Date of Birth</th><td><?php echo $rowfullview["dob"]; ?></td></tr>
						<tr><th>Gender</th><td><?php echo $rowfullview["gender"]; ?></td></tr>
						<tr><th>Mobile</th><td>0<?php echo $rowfullview["mobile"]; ?></td></tr>
						<tr><th>Email</th><td><?php echo $rowfullview["email"]; ?></td></tr>
						<tr><th>Designation</th><td><?php echo $rowfullview["designation"]; ?></td></tr>
						<tr><th>Join Date</th><td><?php echo $rowfullview["join_date"]; ?></td></tr>
						<tr><th>Address</th><td><?php echo $rowfullview["address"]; ?></td></tr>
						<?php
						if(isset($_GET["pg"]))
						{
						?>
							<tr>
								<td colspan="2">
									<center>
										<a href="index.php?pg=staff.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
										<?php
										$sqlchecklogin="SELECT status FROM login WHERE user_id='$rowfullview[staff_id]'";
										$resultchecklogin=mysqli_query($con,$sqlchecklogin) or die ("Error in sqlchecklogin" . mysqli_error($con));
										$rowchecklogin=mysqli_fetch_assoc($resultchecklogin);
										if($rowchecklogin["status"]=="Active")
										{
											if($system_usertype=="Admin"||$system_usertype=="Clerk")
											{//Admin,Clerk can see the Button	
										?>
											<a href="index.php?pg=staff.php&option=edit&pk=<?php echo $rowfullview["staff_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;
											<a href="print.php?pr=staff.php&option=fullview&pk=<?php echo $rowfullview["staff_id"]; ?>" target="_blank"><button class="btn btn-info">Print</button></a>&nbsp;
										<?php
											}
										}
										?>
									</center>
								</td>
							</tr>
						<?php 
						}
						?>
					</table>
				</div>
			</div>
		</div>
		<?php
    }
    else if ($_GET["option"] == "edit")
    {
		if($system_usertype=="Admin"||$system_usertype=="Clerk")
		{//Admin,Clerk can go to this Option
        //edit form
		$get_staffid=$_GET["pk"];
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
									<center><h4 class="card-title">Edit Staff</h4></center>

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
                                            <input type="text" class="form-control" id="txtnic" name="txtnic" placeholder="NICHere" value="<?php echo $rowedit["nic"]; ?>" readonly required onblur="NICNumberValidation()">
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
                                            <input type="text" class="form-control" id="txtgender" name="txtgender" placeholder="Gender Here" value="<?php echo $rowedit["gender"]; ?>" readonly required onkeypress="return TextValidation(event)">
                                        </div>

										<label for="fname" class="col-sm-3 text-right control-label col-form-label"> Mobile</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="txtmobile" name="txtmobile" placeholder="Mobile Here" value="0<?php echo $rowedit["mobile"]; ?>" required onkeypress="return NumberValidation(event)"  onblur="mobileexist('txtmobile','edit')">
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
												<a href ="index.php?pg=staff.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
			</div>.
		</section>
		<!-- form section end -->
		<?php
		}
		else //for other actors
		{
			echo '<script> window.location.href="index.php?pg=staff.php&option=view";</script>';
		}
    }
    else if ($_GET["option"] == "delete")
    {
		if($system_usertype=="Admin"||$system_usertype=="Clerk")
		{//Admin,Clerk can go to this Option
			//sql code
			$get_staffid=$_GET["pk"];
			$sqldelete = "UPDATE login SET status='Deleted' WHERE user_id = '$get_staffid'";
			$resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
			if ($resultdelete)
			{
				echo '<script> alert("Record is Deleted");
							window.location.href="index.php?pg=staff.php&option=view";</script>';
			}
		}
		else 
		{
			echo '<script> window.location.href="index.php?pg=staff.php&option=view";</script>';
		}
    }
}
?>
</body>
<?php 
} 
else 
{//Others Will Redirect to Index Page
    echo '<script>window.location.href="index.php";</script>';
}
?>
