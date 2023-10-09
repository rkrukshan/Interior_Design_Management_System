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
  $sqlinsert="INSERT INTO supplier(supplier_id,name,mobile,land,email,address)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtsupplierid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtname"])."',
        '".mysqli_real_escape_string($con,$_POST["txtmobile"])."',
        '".mysqli_real_escape_string($con,$_POST["txtland"])."',
        '".mysqli_real_escape_string($con,$_POST["txtemail"])."',
        '".mysqli_real_escape_string($con,$_POST["txtaddress"])."')";
$resultinsert=mysqli_query($con,$sqlinsert) or die ("sql error in sqlinsert" . mysqli_error($con));
if($resultinsert)
{
  echo '<script> alert("Data stored successfully"); </script>';
}
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
	$sqlupdate="UPDATE supplier SET
                            name='".mysqli_real_escape_string($con,$_POST["txtname"])."',
                            mobile='".mysqli_real_escape_string($con,$_POST["txtmobile"])."',
                            land='".mysqli_real_escape_string($con,$_POST["txtland"])."',
                            email='".mysqli_real_escape_string($con,$_POST["txtemail"])."',
                            address='".mysqli_real_escape_string($con,$_POST["txtaddress"])."'
								WHERE supplier_id='".mysqli_real_escape_string($con,$_POST["txtsupplierid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=supplier.php&option=fullview&pk='.$_POST["txtsupplierid"].'";</script>';
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
		var supplierid=document.getElementById("txtsupplierid").value;
	}
	else
	{//otherwise no need staffid
		var supplierid="";
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
	xmlhttp.open("GET", "ajaxpage.php?frompage=supplier_mobile&ajaxmobile=" + mobileno+"&ajaxoption="+option_name+"&ajaxsupplierid="+supplierid, true);
	xmlhttp.send();
}
</script>
<body>
  <?php
  if (isset($_GET["option"]))
  {
    if ($_GET["option"] == "add")
    {
      if($system_usertype=="Admin")
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
                      <center><h4 class="card-title">Add Supplier Details</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Supplier ID</label>
                                            <div class="col-sm-3">
                                              <?php
                                              $sqlgenerateid="SELECT supplier_id FROM supplier ORDER BY supplier_id DESC LIMIT 1";
                                              $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                                              $n=mysqli_num_rows($resultgenerateid);//count the number of records
                                              if($n==1)
                                              {//for other than 1st time
                                                  $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                                                  $generateid=++$rowgenerateid["supplier_id"];
                                              }
                                              else
                                                {//For 1st time
                                                    $generateid="SUP001";
                                                }
                                              ?>
                                                <input type="text" class="form-control" id="txtsupplierid" name="txtsupplierid" placeholder="Supplier ID Here"  value="<?php echo $generateid; ?>" readonly required>
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Name Here" required onkeypress="return TextValidation(event)">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                                          <div class="col-sm-3">
                                              <input type="text" class="form-control" id="txtmobile" name="txtmobile" placeholder="Mobile N.O Here" required onkeypress="return NumberValidation(event)" onblur="mobileexist('txtmobile','add')">
                                          </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Land</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="txtland" name="txtland" placeholder="Land N.O Here" required onkeypress="return NumberValidation(event)" onblur="LandPhoneNumberValidation('txtland')">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                                          <div class="col-sm-3">
                                              <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email Here" required onblur="EmailValidation()">
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
                            <a href ="index.php?pg=supplier.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        else 
        {//Others Will Redirect to option View
          echo '<script>window.location.href="index.php?pg=supplier.php&option=view";</script>';
        }

    }
    else if ($_GET["option"] == "view")
    {
      ?>
      <div class="card">
        <div class="card-body">
        <center>  <h5 class="card-title">Supplier View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <?php
              if($system_usertype=="Admin")
              {
              ?>
                <a href="index.php?pg=supplier.php&option=add"><button class="btn btn-primary">Add Record</button></a>
                <br><br>
              <?php  
              }
              ?>
              <thead>
                <tr>
                  <th>Supplier ID</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Land</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT supplier_id,name,mobile,land FROM supplier";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  echo'<tr>';
                    echo '<td>'.$rowview["supplier_id"].'</td>';
                    echo '<td>'.$rowview["name"].'</td>';
                    echo '<td>'.$rowview["mobile"].'</td>';
                    echo '<td>'.$rowview["land"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=supplier.php&option=fullview&pk='.$rowview["supplier_id"].'"><button class="btn btn-success">View</button></a> ';
                      if($system_usertype=="Admin")
                      {
                      echo '<a href="index.php?pg=supplier.php&option=edit&pk='.$rowview["supplier_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=supplier.php&option=delete&pk='.$rowview["supplier_id"].'"><button class="btn btn-danger">Delete</button></a> ';
                      }
                    echo '</td>';
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
      $get_supplierid =$_GET["pk"];
      $sqlfullview = "SELECT * FROM supplier WHERE supplier_id='$get_supplierid'";
      $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
      $rowfullview=mysqli_fetch_assoc($resultfullview);
      ?>
      <div class="card">
      <div class="card-body">
      <center><h5 class="card-title">supplier Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Supplier ID</th><td><?php echo $rowfullview["supplier_id"]; ?></td></tr>
          <tr><th>Name</th><td><?php echo $rowfullview["name"]; ?></td></tr>
          <tr><th>Mobile</th><td><?php echo $rowfullview["mobile"]; ?></td></tr>
          <tr><th>Land</th><td><?php echo $rowfullview["land"]; ?></td></tr>
          <tr><th>Email</th><td><?php echo $rowfullview["email"]; ?></td></tr>
          <tr><th>Address</th><td><?php echo $rowfullview["address"]; ?></td></tr>

          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=supplier.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                <?php
                if($system_usertype=="Admin")
                      {
                  ?>
                <a href="index.php?pg=supplier.php&option=edit&pk=<?php echo $rowfullview["supplier_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;
                      
                      <?php 
                      }
                      ?>
              </center>
            </td>
          </tr>
        </table>
      </div>
      </div>
      </div>
      <?php
      }
      else if ($_GET["option"] == "edit")
      {
        if($system_usertype=="Admin")
        {
        $get_supplierid =$_GET["pk"];
        $sqledit = "SELECT * FROM supplier WHERE supplier_id='$get_supplierid'";
        $resultedit = mysqli_query($con,$sqledit) or die("Sqledit error ".mysqli_error($con));
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
                      <center><h4 class="card-title">Edit Supplier Details</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Supplier ID</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtsupplierid" name="txtsupplierid" placeholder="Supplier ID Here" required readonly value="<?php echo $rowedit["supplier_id"]; ?>">
                                            </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtname" name="txtname" placeholder="Name Here" required value="<?php echo $rowedit["name"]; ?>" onkeypress="return TextValidation(event)">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                                          <div class="col-sm-3">
                                              <input type="text" class="form-control" id="txtmobile" name="txtmobile" placeholder="Mobile N.O Here" required value="0<?php echo $rowedit["mobile"]; ?>" onkeypress="return NumberValidation(event)" onblur="mobileexist('txtmobile','edit')">
                                          </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Land</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="txtland" name="txtland" placeholder="Land N.O Here" required value="0<?php echo $rowedit["land"]; ?>" onkeypress="return NumberValidation(event)" onblur="LandPhoneNumberValidation('txtland')">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                                          <div class="col-sm-3">
                                              <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Email Here" required value="<?php echo $rowedit["email"]; ?>" onblur="EmailValidation()">
                                          </div>
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtaddress" name="txtaddress" placeholder="Address Here" required value="<?php echo $rowedit["address"]; ?>">
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=supplier.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        else 
        {//Others Will Redirect to option View
          echo '<script>window.location.href="index.php?pg=supplier.php&option=view";</script>';
        }
      }
      else if ($_GET["option"] == "delete")
      {
        if($system_usertype=="Admin")
        {
              $get_supplierid =$_GET["pk"];
              $sqldelete = "DELETE FROM supplier WHERE supplier_id='$get_supplierid'";
              $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete".mysqli_error($con));
              if ($resultdelete)
              {
                echo '<script> alert("Record is Deleted");
                      window.location.href="index.php?pg=supplier.php&option=view";</script>';
              }
        }
        else 
        {//Others Will Redirect to option View
          echo '<script>window.location.href="index.php?pg=supplier.php&option=view";</script>';
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