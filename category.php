<?php
if (!isset($_SESSION)) {
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
if (isset($_POST["btnsave"])) {
    $sqlinsert = "INSERT INTO category(category_id,category_name)
			VALUES('" . mysqli_real_escape_string($con, $_POST["txtcategoryid"]) . "',
			'" . mysqli_real_escape_string($con, $_POST["txtcategoryname"]) . "')";
    $resultinsert = mysqli_query($con, $sqlinsert) or die("sql error in sqlinsert" . mysqli_error($con));
    if ($resultinsert)
    {
        echo '<script> alert("Data stored successfully");
        window.location.href="index.php?pg=subcategory.php&option=add&categoryid='.$_POST["txtcategoryid"].'"; </script>';
    }
}
//insert sql end

//update code start
if(isset($_POST["btnsavechanges"]))
{
$sqlupdate="UPDATE category SET
       category_name='".mysqli_real_escape_string($con,$_POST["txtcategoryname"])."'
      WHERE category_id='".mysqli_real_escape_string($con,$_POST["txtcategoryid"])."'";
$resultupdate=mysqli_query($con,$sqlupdate) or die ("error in sqledit" . mysqli_error($con));
if($resultupdate)
{
  echo '<script> alert("Successfully Updated");
   window.location.href="index.php?pg=category.php&option=fullview&pk='.$_POST["txtcategoryid"].'";</script>';

}
}
//update code end
?>

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
                <center>
                  <h4 class="card-title">Add Category</h4>
                </center>
                <!-- field start -->
                <div class="form-group row">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Category ID</label>
                  <div class="col-sm-3">
                    <?php
                    $sqlgenerateid="SELECT category_id FROM category ORDER BY category_id DESC LIMIT 1";
                    $resultgenerateid=mysqli_query($con,$sqlgenerateid) or die ("Error in sqlgenerateid". mysqli_error($con));
                    $n=mysqli_num_rows($resultgenerateid);//count the number of records
                    if($n==1)
                    {//for other than 1st time
                        $rowgenerateid=mysqli_fetch_assoc($resultgenerateid);
                        $generateid=++$rowgenerateid["category_id"];
                    }
                    else
                      {//For 1st time
                          $generateid="CAT01";
                      }
                    ?>
                    <input type="text" class="form-control" id="txtcategoryid" name="txtcategoryid"
                      placeholder="Category ID Here"  value="<?php echo $generateid; ?>" readonly required>
                  </div>

                  <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Category Name</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" id="txtcategoryname" name="txtcategoryname"
                      placeholder="Category Name Here" required onkeypress="return TextValidation(event)">
                  </div>
                </div>
                <!-- field end -->

                <!-- button start -->
                <div class="form-group row">
                  <div class="col-sm-12">
                    <center>
                      <a href="index.php?pg=category.php&option=view"><input type="button" class="btn btn-primary"
                          id="btngoback" name="btngoback" value="Go back"></a>
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
      <center>
        <h5 class="card-title">Category View</h5>
      </center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <a href="index.php?pg=category.php&option=add"><button class="btn btn-primary">Add Record</button></a>
          <br><br>
          <thead>
            <tr>
              <th>Category ID</th>
              <th>Category Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
$sqlview = "SELECT category_id,category_name FROM category";
        $resultview = mysqli_query($con, $sqlview) or die("Error in sqlview " . mysqli_error($con));
        while ($rowview = mysqli_fetch_assoc($resultview)) 
        {
            echo '<tr>';
            echo '<td>' . $rowview["category_id"] . '</td>';
            echo '<td>' . $rowview["category_name"] . '</td>';
            echo '<td>';
            echo '<a href="index.php?pg=category.php&option=fullview&pk='.$rowview["category_id"].'"><button class="btn btn-success">View</button></a> ';
            echo '<a href="index.php?pg=category.php&option=edit&pk='.$rowview["category_id"].'"><button class="btn btn-info">Edit</button></a> ';
            echo '<a onclick="return confirmdelete()" href="index.php?pg=category.php&option=delete&pk='.$rowview["category_id"].'"><button class="btn btn-danger">Delete</button></a> ';
            echo '</td>';
            echo '</tr>';
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
 $get_categoryid =$_GET["pk"];
$sqlfullview = "SELECT * FROM category WHERE category_id ='$get_categoryid'";
$resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
$rowfullview=mysqli_fetch_assoc($resultfullview);
?>
<div class="card">
<div class="card-body">
 <center><h5 class="card-title">Category Full View</h5></center>
 <div class="table-responsive">
   <table id="zero_config" class="table table-striped table-bordered">
     <tr><th>Category ID</th><td><?php echo $rowfullview["category_id"]; ?></td></tr>
     <tr><th>Category Name</th><td><?php echo $rowfullview["category_name"]; ?></td></tr>


     <tr>
       <td colspan="2">
         <center>
           <a href="index.php?pg=category.php&option=view"><button class="btn btn-primary">Go Back</button></a>&nbsp;
           <a href="index.php?pg=category.php&option=edit&pk=<?php echo $rowfullview["category_id"]; ?>"><button class="btn btn-info">Edit</button></a>&nbsp;

         </center>
       </td>
     </tr>
   </table>
 </div>
</div>
</div>
<!--sub categorylist -->
<div class="card">
  <div class="card-body">
  <center>  <h5 class="card-title">Subcategory View</h5></center>
    <div class="table-responsive">
      <table id="zero_config" class="table table-striped table-bordered">
        <a href="index.php?pg=subcategory.php&option=add&categoryid=<?php echo $rowfullview["category_id"]; ?>"><button class="btn btn-primary">Add Record</button></a>
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
          $sqlview="SELECT * FROM subcategory WHERE category_id='$get_categoryid'";
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
                echo '<a href="index.php?pg=subcategory.php&option=edit&pk='.$rowview["subcategory_id"].'"><button class="btn btn-info">Edit</button></a> ';
                // for after Deletion of subcategory have to come back to category so it's ---> &categoryid='.$rowview["category_id"]. needed
                echo '<a onclick="return confirmdelete()" href="index.php?pg=subcategory.php&option=delete&pk='.$rowview["subcategory_id"].'&categoryid='.$rowview["category_id"].'"><button class="btn btn-danger">Delete</button></a> ';
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
else if ($_GET["option"] == "edit")
{
  $get_categoryid =$_GET["pk"];
 $sqledit = "SELECT * FROM category WHERE category_id ='$get_categoryid'";
 $resultedit = mysqli_query($con,$sqledit) or die("Sqlfullview error ".mysqli_error($con));
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
          <center>
            <h4 class="card-title">Edit Category</h4>
          </center>
          <!-- field start -->
          <div class="form-group row">
            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Category ID</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="txtcategoryid" name="txtcategoryid"placeholder="Category ID Here" required readonly value= "<?php echo $rowedit["category_id"]; ?>"></div>

            <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Category Name</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="txtcategoryname" name="txtcategoryname"
                placeholder="Category Name Here" required  value= "<?php echo $rowedit["category_name"]; ?>" onkeypress="return TextValidation(event)">
            </div>
          </div>
          <!-- field end -->

          <!-- button start -->
          <div class="form-group row">
            <div class="col-sm-12">
              <center>
                <a href="index.php?pg=category.php&option=view"><input type="button" class="btn btn-primary"
                    id="btngoback" name="btngoback" value="Go back"></a>
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
 $get_categoryid=$_GET["pk"];
 $sqldelete = "DELETE FROM category WHERE category_id = '$get_categoryid'";
 $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));

 $sqldelete = "DELETE FROM subcategory WHERE category_id = '$get_categoryid'";
 $resultdelete = mysqli_query($con,$sqldelete) or die ("Error in sqldelete ".mysqli_error($con));
 if ($resultdelete)
 {
   echo '<script> alert("Record is Deleted");
         window.location.href="index.php?pg=category.php&option=view";</script>';
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
