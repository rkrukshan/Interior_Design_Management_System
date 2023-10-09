<?php
if(!isset($_SESSION))
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
if($system_usertype=="Admin"||$system_usertype=="Clerk")
{//Admin,Clerk Can Access This Page
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
	$sqlinsertlogin="INSERT INTO login(user_name,user_id,password,user_type,status,attempt,code)
							VALUES('".mysqli_real_escape_string($con,$_POST["txtnic"])."',
									'".mysqli_real_escape_string($con,$_POST["txtcustomerid"])."',
									'".mysqli_real_escape_string($con,$password)."', 
									'".mysqli_real_escape_string($con,"Customer")."',
									'".mysqli_real_escape_string($con,"Active")."',
									'".mysqli_real_escape_string($con,0)."',
									'".mysqli_real_escape_string($con,0)."')";
	$resultinsertlogin = mysqli_query($con,$sqlinsertlogin) or die ("sql error in sqlinsertlogin ". mysqli_error($con));
if($resultinsert)
{
  echo '<script> alert("Data stored successfully"); </script>';
}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE customer SET
								name='".mysqli_real_escape_string($con,$_POST["txtname"])."',
								nic='".mysqli_real_escape_string($con,$_POST["txtnic"])."',
								dob='".mysqli_real_escape_string($con,$_POST["txtdob"])."',
								gender='".mysqli_real_escape_string($con,$_POST["txtgender"])."',
								mobile='".mysqli_real_escape_string($con,$_POST["txtmobile"])."',
								email='".mysqli_real_escape_string($con,$_POST["txtemail"])."',
								address='".mysqli_real_escape_string($con,$_POST["txtaddress"])."'
								WHERE customer_id='".mysqli_real_escape_string($con,$_POST["txtcustomerid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=customer.php&option=fullview&pk='.$_POST["txtcustomerid"].'";</script>';
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
<body>
  <?php
  if (isset($_GET["option"]))
  {
    if ($_GET["option"] == "add")
    {
		    ?>
        <!-- form section start -->
        <section class="feature_part padding_top">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <form class="form-horizontal" method="POST" action="">
                    <div class="card-body">
                      <center><h4 class="card-title">Add Customer</h4></center>
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

                        <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Date of Birth</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtdob" name="txtdob" placeholder="Date of Birth Here" required readonly>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Gender</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtgender" name="txtgender" placeholder="Gender Here" required readonly onkeypress="return TextValidation(event)">
                                            </div>

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
                            <a href ="index.php?pg=customer.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
          </div>
        </section>
        <!-- form section end -->


        <?php
    }
    else if ($_GET["option"] == "view")
    {
      ?>
      <div class="card">
        <div class="card-body">
          <center><h5 class="card-title">Customer View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <?php 
              if(isset($_GET["pg"]))
              {
              ?>
                <a href="index.php?pg=customer.php&option=add"><button class="btn btn-primary">Add Record</button></a>&nbsp;
                <a href="print.php?pr=customer.php&option=view" target="_blank"><button class="btn btn-primary">Print</button></a>
                <br><br>
            <?php 
              }
            ?>
              <thead>
                <tr>
                  <th>Customer ID</th>
                  <th>Name</th>
                  <th>NIC</th>
                  <th>Date of Birth</th>
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
                $sqlview="SELECT customer_id,name,nic,dob FROM customer";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  echo'<tr>';
                    echo '<td>'.$rowview["customer_id"].'</td>';
                    echo '<td>'.$rowview["name"].'</td>';
                    echo '<td>'.$rowview["nic"].'</td>';
                    echo '<td>'.$rowview["dob"].'</td>';
                    if(isset($_GET["pg"]))
                    {
                      echo '<td>';
                        echo '<a href="index.php?pg=customer.php&option=fullview&pk='.$rowview["customer_id"].'"><button class="btn btn-success">View</button></a> ';
              
                        $sqlchecklogin="SELECT status FROM login WHERE user_id='$rowview[customer_id]'";
                        $resultchecklogin=mysqli_query($con,$sqlchecklogin) or die ("Error in sqlchecklogin" . mysqli_error($con));
                        $rowchecklogin=mysqli_fetch_assoc($resultchecklogin);
                        if($rowchecklogin["status"]=="Active")
                        {
                          echo '<a href="index.php?pg=customer.php&option=edit&pk='.$rowview["customer_id"].'"><button class="btn btn-info">Edit</button></a> ';
                          echo '<a onclick="return confirmdelete()" href="index.php?pg=customer.php&option=delete&pk='.$rowview["customer_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
      $get_customerid =$_GET["pk"];
      $sqlfullview = "SELECT * FROM customer WHERE customer_id  ='$get_customerid'";
      $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
      $rowfullview=mysqli_fetch_assoc($resultfullview);
      ?>
      <div class="card">
      <div class="card-body">
      <center><h5 class="card-title">customer Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>customer ID</th><td><?php echo $rowfullview["customer_id"]; ?></td></tr>
          <tr><th>Name</th><td><?php echo $rowfullview["name"]; ?></td></tr>
          <tr><th>NIC</th><td><?php echo $rowfullview["nic"]; ?></td></tr>
          <tr><th>Date of Brith</th><td><?php echo $rowfullview["dob"]; ?></td></tr>
          <tr><th>Gender</th><td><?php echo $rowfullview["gender"]; ?></td></tr>
          <tr><th>mobile</th><td>0<?php echo $rowfullview["mobile"]; ?></td></tr>
          <tr><th>Email</th><td><?php echo $rowfullview["email"]; ?></td></tr>
          <tr><th>Address</th><td><?php echo $rowfullview["address"]; ?></td></tr>
          <?php
          if(isset($_GET["pg"]))
          {
            ?>
              <tr>
                <td colspan="2">
                  <center>
                    <a href="index.php?pg=customer.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                    <?php
                    $sqlchecklogin="SELECT status FROM login WHERE user_id='$rowfullview[customer_id]'";
                    $resultchecklogin=mysqli_query($con,$sqlchecklogin) or die ("Error in sqlchecklogin" . mysqli_error($con));
                    $rowchecklogin=mysqli_fetch_assoc($resultchecklogin);
                    if($rowchecklogin["status"]=="Active")
                    {
                    ?>
                    
                      <a href="index.php?pg=customer.php&option=edit&pk=<?php echo $rowfullview["customer_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;
                      <a href="print.php?pr=customer.php&option=fullview&pk=<?php echo $rowfullview["customer_id"]; ?>"target="_blank"><button class="btn btn-info">Print</button></a>
                    
                      <?php
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
        //edit form
    $get_customerid=$_GET["pk"];
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
                        <center><h4 class="card-title">Edit Customer</h4></center>
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
                                                  <input type="text" class="form-control" id="txtnic" name="txtnic" placeholder="NIC Here" required  value="<?php echo $rowedit["nic"]; ?>" readonly onblur="NICNumberValidation()">
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
                                                  <input type="text" class="form-control" id="txtmobile" name="txtmobile" placeholder="Mobile N.O Here" required  value="0<?php echo $rowedit["mobile"]; ?>" onkeypress="return NumberValidation(event)" onblur="mobileexist('txtmobile','edit')">
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
                              <a href ="index.php?pg=customer.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
            </div>
          </section>
          <!-- form section end -->
          <?php

      }
      else if ($_GET["option"] == "delete")
      {
      $get_customerid=$_GET["pk"];
      $sqldelete = "UPDATE login SET status='Deleted' WHERE user_id = '$get_customerid'";
      $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
      if ($resultdelete)
      {
        echo '<script> alert("Record is Deleted");
              window.location.href="index.php?pg=customer.php&option=view";</script>';
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
