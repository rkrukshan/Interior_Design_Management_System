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
include "config.php";
//insert sql start
if(isset($_POST["btnsave"]))
{
  $sqlinsert="INSERT INTO subcategory(subcategory_id,category_id,subcategory_name)
  VALUES('".mysqli_real_escape_string($con,$_POST["txtsubcategoryid"])."',
         '".mysqli_real_escape_string($con,$_POST["txtcategoryid"])."',
        '".mysqli_real_escape_string($con,$_POST["txtsubcategoryname"])."')";
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
	$sqlupdate="UPDATE subcategory SET
                                  category_id='".mysqli_real_escape_string($con,$_POST["txtcategoryid"])."',
                                  subcategory_name='".mysqli_real_escape_string($con,$_POST["txtsubcategoryname"])."'
				                  WHERE subcategory_id='".mysqli_real_escape_string($con,$_POST["txtsubcategoryid"])."'";
	$resultupdate=mysqli_query ($con,$sqlupdate) or die("Error in sqlupdate" . mysqli_error($con));
	if ($resultupdate)
	{
		echo '<script> alert("Data updated Sucessfully");
				window.location.href="index.php?pg=category.php&option=fullview&pk='.$_POST["txtcategoryid"].'";</script>';
	}

}
//update code End
?>
<body>
    <?php
if (isset($_GET["option"]))
{
    if ($_GET["option"] == "add")
    {
      $get_categoryid=$_GET["categoryid"];
      ?>
      <!-- form section start -->
      <section class="feature_part padding_top">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form class="form-horizontal" method="POST" action="">
                  <div class="card-body">
                    <center><h4 class="card-title">Add Sub Category</h4></center>
                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Sub Category ID</label>
                                          <div class="col-sm-3">
                                            <?php
                                            $sqlgenerateid="SELECT subcategory_id FROM subcategory ORDER BY subcategory_id DESC LIMIT 1";
                                            $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                                            $n=mysqli_num_rows($resultgenerateid);//count the number of records
                                            if($n==1)
                                            {//for other than 1st time
                                                $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                                                $generateid=++$rowgenerateid["subcategory_id"];
                                            }
                                            else
                                              {//For 1st time
                                                  $generateid="SCAT001";
                                              }
                                            ?>
                                              <input type="text" class="form-control" id="txtsubcategoryid" name="txtsubcategoryid" placeholder="Sub Category ID Here" readonly  value="<?php echo $generateid; ?>" required>
                                          </div>

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Category ID</label>
                                          <div class="col-sm-3">
                                              <select class="form-control" id="txtcategoryid" name="txtcategoryid" placeholder="Category ID Here" required>

                                                <?php
                                                $sqlload="SELECT category_id,category_name FROM category WHERE category_id='$get_categoryid'";
                                                $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                              while( $rowload=mysqli_fetch_assoc($resultload))
                                              {
                                                echo '<option value="'.$rowload["category_id"].'">'.$rowload["category_name"].'</option>';
                                              }

                                                ?>
                                              </select>
                                          </div>
                                      </div>
                    <!-- field end -->
                    <!-- field start -->
                    <div class="form-group row">

                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Sub Category Name</label>
                                          <div class="col-sm-3">
                                              <input type="text" class="form-control" id="txtsubcategoryname" name="txtsubcategoryname" placeholder="Sub Category Name Here" required onkeypress="return TextValidation(event)">
                                          </div>
                                      </div>
                    <!-- field end -->

                    <!-- button start -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                        <center>
                          <a href ="index.php?pg=category.php&option=fullview&pk=<?php echo $get_categoryid; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
        <center>  <h5 class="card-title">Subcategory View</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <a href="index.php?pg=subcategory.php&option=add"><button class="btn btn-primary">Add Record</button></a>
              <br><br>
              <thead>
                <tr>
                  <th>Subcategory ID</th>
                  <th>Category ID</th>
                  <th>Subcategory Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlview="SELECT * FROM subcategory";
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                  $sqlcategoryname="SELECT category_name FROM category WHERE category_id='$rowview[category_id]'";
                  $resultcategoryname=mysqli_query($con,$sqlcategoryname) or die ("Error in sqlcategoryname" . mysqli_error($con));
                  $rowcategoryname=mysqli_fetch_assoc($resultcategoryname);
                  echo'<tr>';
                    echo '<td>'.$rowview["subcategory_id"].'</td>';
                    echo '<td>'.$rowcategoryname["category_name"].'</td>';
                    echo '<td>'.$rowview["subcategory_name"].'</td>';
                    echo '<td>';
                      echo '<a href="index.php?pg=subcategory.php&option=fullview&pk='.$rowview["subcategory_id"].'"><button class="btn btn-success">View</button></a> ';
                      echo '<a href="index.php?pg=subcategory.php&option=edit&pk='.$rowview["subcategory_id"].'"><button class="btn btn-info">Edit</button></a> ';
                      echo '<a onclick="return confirmdelete()" href="index.php?pg=subcategory.php&option=delete&pk='.$rowview["subcategory_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
       $get_subcategoryid =$_GET["pk"];
       $sqlfullview = "SELECT * FROM subcategory WHERE subcategory_id='$get_subcategoryid'";
       $resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
       $rowfullview=mysqli_fetch_assoc($resultfullview);

       $sqlcategoryname="SELECT category_name FROM category WHERE category_id='$rowfullview[category_id]'";
       $resultcategoryname=mysqli_query($con,$sqlcategoryname) or die ("Error in sqlcategoryname" . mysqli_error($con));
       $rowcategoryname=mysqli_fetch_assoc($resultcategoryname);
       ?>
       <div class="card">
       <div class="card-body">
       <center><h5 class="card-title">Subcategory Full View</h5></center>
       <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
           <tr><th>Subcategory ID</th><td><?php echo $rowfullview["subcategory_id"]; ?></td></tr>
           <tr><th>Category ID</th><td><?php echo $rowcategoryname["category_name"]; ?></td></tr>
           <tr><th>Subcategory Name</th><td><?php echo $rowfullview["subcategory_name"]; ?></td></tr>

           <tr>
             <td colspan="2">
               <center>
                 <a href="index.php?pg=subcategory.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
                 <a href="index.php?pg=subcategory.php&option=edit&pk=<?php echo $rowfullview["subcategory_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

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
         $get_subcategoryid =$_GET["pk"];
         $sqledit = "SELECT * FROM subcategory WHERE subcategory_id='$get_subcategoryid'";
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
                       <center><h4 class="card-title">Edit Sub Category</h4></center>
                       <!-- field start -->
                       <div class="form-group row">
                                             <label for="fname" class="col-sm-3 text-right control-label col-form-label">Sub Category ID</label>
                                             <div class="col-sm-3">
                                                 <input type="text" class="form-control" id="txtsubcategoryid" name="txtsubcategoryid" placeholder="Sub Category ID Here" required readonly value="<?php echo $rowedit["subcategory_id"];?>">
                                             </div>

                         <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Category ID</label>
                                             <div class="col-sm-3">
                                                 <select class="form-control" id="txtcategoryid" name="txtcategoryid" placeholder="Category ID Here" required >
                                                   <?php
                                                   $sqlload="SELECT category_id,category_name FROM category WHERE category_id = '$rowedit[category_id]'";
                                                   $resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
                                                 while( $rowload=mysqli_fetch_assoc($resultload))
                                                 {
                                                   echo '<option value="'.$rowload["category_id"].'">'.$rowload["category_name"].'</option>';


                                                 }

                                                   ?>

                                                 </select>
                                             </div>
                                         </div>
                       <!-- field end -->
                       <!-- field start -->
                       <div class="form-group row">

                         <label for="fname" class="col-sm-3 text-right control-label col-form-label">Sub Category Name</label>
                                             <div class="col-sm-3">
                                                 <input type="text" class="form-control" id="txtsubcategoryname" name="txtsubcategoryname" placeholder="Sub Category Name Here" required value="<?php echo $rowedit["subcategory_name"];?>" onkeypress="return TextValidation(event)">
                                             </div>
                                         </div>
                       <!-- field end -->

                       <!-- button start -->
                       <div class="form-group row">
                           <div class="col-sm-12">
                           <center>
                             <a href ="index.php?pg=category.php&option=fullview&pk=<?php echo $rowedit["category_id"]; ?>"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
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
       $get_subcategoryid =$_GET["pk"];
       $get_categoryid=$_GET["categoryid"];
       $sqldelete = "DELETE FROM subcategory WHERE subcategory_id='$get_subcategoryid'";
       $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
       if ($resultdelete)
       {
         echo '<script> alert("Record is Deleted");
               window.location.href="index.php?pg=category.php&option=fullview&pk='.$get_categoryid.'";</script>';
       }
       }
       }
       ?>
       </body>
