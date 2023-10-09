<?php
if(!isset($_SESSION))//check session start or not
{
	session_start();//if not then start session
}
if(isset($_SESSION["login_user_type"]))
{
	$system_usertype=$_SESSION["login_user_type"];
	$system_username=$_SESSION["login_username"];
}
else
{
	$system_usertype="Guest";
}
include("connection.php");
//insert code start
if(isset($_POST["btnsave"]))
{
	if(isset($_GET["cusorderid"]))
	{
		$get_orderid=$_GET["cusorderid"];
		$get_productid=$_GET["productid"];
		$backpage="custom_order";
		$backid="cusorderid";
	}
	else
	{
		$get_orderid=$_GET["orderid"];
		$get_productid=$_GET["productid"];
		$backpage="order_details";
		$backid="orderid";
	}
	$sqlinsert="INSERT INTO review(review_id, order_id, product_id, date, time, rate, comment)
								VALUES('".mysqli_real_escape_string($con,$_POST["txtreviewid"])."',
										'".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
										'".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
										'".mysqli_real_escape_string($con,$_POST["txtdate"])."',
										'".mysqli_real_escape_string($con,date("H:i:s"))."',
										'".mysqli_real_escape_string($con,$_POST["txtrate"])."',
										'".mysqli_real_escape_string($con,$_POST["txtcomment"])."')";
	$resultinsert=mysqli_query($con,$sqlinsert) or die("sql error in sqlinsert ".mysqli_error($con));
	if($resultinsert)
	{
		echo '<script>alert("successfully insert!!!");
		window.location.href="index.php?pg='.$backpage.'.php&option=fullview&orderid='.$_POST["txtorderid"].'";</script>';
	}
}
//insert code end

//update code start
if(isset($_POST["btnsavechange"]))
{
	$sqlupdate="UPDATE review SET
								order_id='".mysqli_real_escape_string($con,$_POST["txtorderid"])."',
								product_id='".mysqli_real_escape_string($con,$_POST["txtproductid"])."',
								date='".mysqli_real_escape_string($con,$_POST["txtdate"])."',
								time='".mysqli_real_escape_string($con,$_POST["txttime"])."',
								rate='".mysqli_real_escape_string($con,$_POST["txtrate"])."',
								comment='".mysqli_real_escape_string($con,$_POST["txtcomment"])."'
								WHERE review_id='".mysqli_real_escape_string($con,$_POST["txtreviewid"])."'";
	$resultupdate=mysqli_query($con,$sqlupdate) or die("sql error in sqlupdate ".mysqli_error($con));
	if($resultupdate)
	{
		echo '<script>alert("successfully update");
					window.location.href="index.php?pg=review.php&option=fullview&reviewid='.$_POST["txtreviewid"].'";</script>';
	}
}
//update code end

?>
<script>
function change_color(y)
{
	for(var x=1; x<=5; x++)
	{
		if(x<=y)
		{
			document.getElementById("txtstar"+x).className="fa fa-star";
		}
		else
		{
			document.getElementById("txtstar"+x).className="fa fa-star-o";
		}
	}
}

function change_color_out()
{
	var y=document.getElementById("txtrate").value;
	for(var x=1; x<=5; x++)
	{
		if(x<=y)
		{
			document.getElementById("txtstar"+x).className="fa fa-star";
		}
		else
		{
			document.getElementById("txtstar"+x).className="fa fa-star-o";
		}
	}
}

function assign_rate(y)
{
	document.getElementById("txtrate").value=y;
	for(var x=1; x<=5; x++)
	{
		if(x<=y)
		{
			document.getElementById("txtstar"+x).className="fa fa-star";
		}
		else
		{
			document.getElementById("txtstar"+x).className="fa fa-star-o";
		}
	}
}
</script>
<body>
	<?php
	if(isset($_GET["option"]))
	{
		if($_GET["option"]=="add")
		{
			//add form
			if(isset($_GET["cusorderid"]))
			{
				$get_orderid=$_GET["cusorderid"];
				$get_productid=$_GET["productid"];
				$backpage="custom_order";
				$backid="cusorderid";
			}
			else
			{
				$get_orderid=$_GET["orderid"];
				$get_productid=$_GET["productid"];
				$backpage="order_details";
				$backid="orderid";
			}
			?>
			<section class="related-product-area section_gap_bottom">
				<div class="container">
					<div class="col-lg-12 text-center">
						<div class="section-title">
							<h1>Review Add</h1>
						</div>
					</div>
					<form action="" method="POST">

						<div class="row">
							<div class="col-lg-4">Review ID</div>
							<div class="col-lg-8">
								<?php
								$sqlgenerateid="SELECT review_id FROM review ORDER BY review_id DESC LIMIT 1";
								$resultgenerateid=mysqli_query($con,$sqlgenerateid) or die("sql error in sqlgenerateid ".mysqli_error($con));
								if(mysqli_num_rows($resultgenerateid)==1)//if any record found in review table
								{
									$rowgeneerateid=mysqli_fetch_assoc($resultgenerateid);
									$generateid=++$rowgeneerateid["review_id"];
								}
								else//for first time
								{
									$generateid="RE00001";
								}
								?>
								<input type="text" name="txtreviewid" id="txtreviewid" value="<?php echo $generateid; ?>" readonly required class="form-control">
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Order ID</div>
							<div class="col-lg-8">
								<select name="txtorderid" id="txtorderid" required class="form-control">
									<?php
									$sqlloadorder_details="SELECT order_id FROM $backpage WHERE order_id='$get_orderid'";
									$resultloadorder_details=mysqli_query($con,$sqlloadorder_details) or die("sql error in sqlloadorder_details ".mysqli_error($con));
									while($rowloadorder_details=mysqli_fetch_assoc($resultloadorder_details))
									{
										echo '<option value="'.$rowloadorder_details["order_id"].'">'.$rowloadorder_details["order_id"].'</option>';
									}
									?>
								</select>
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Product ID</div>
							<div class="col-lg-8">
								<select name="txtproductid" id="txtproductid" required class="form-control">
									<?php
									if(isset($_GET["cusorderid"]))
									{
										echo '<option value="'.$get_productid.'">'.$get_productid.'</option>';
									}
									else
									{
										$sqlloadproduct="SELECT product_id,name FROM product WHERE product_id='$get_productid'";
										$resultloadproduct=mysqli_query($con,$sqlloadproduct) or die("sql error in sqlloadproduct ".mysqli_error($con));
										while($rowloadproduct=mysqli_fetch_assoc($resultloadproduct))
										{
											echo '<option value="'.$rowloadproduct["product_id"].'">'.$rowloadproduct["name"].'</option>';
										}
									}

									?>
								</select>
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Date</div>
							<div class="col-lg-8">
								<input type="date" name="txtdate" id="txtdate" value ="<?php echo date("Y-m-d");?>" readonly required class="form-control">
							</div>
						</div><br>

						<!--<div class="row">
							<div class="col-lg-4">Time</div>
							<div class="col-lg-8">
								<input type="time" name="txttime" id="txttime" required class="form-control">
							</div>
						</div><br>-->

						<div class="row">
							<div class="col-lg-4">Rate</div>
							<div class="col-lg-8">
								<input type="hidden" name="txtrate" id="txtrate" value="0" onkeypress="return isNumberKey(event)" required class="form-control">
								<?php
								for($x=1; $x<=5; $x++)
								{
									echo '<i class="fa fa-star-o" id="txtstar'.$x.'" onmouseover="change_color('.$x.')" onmouseout="change_color_out()" onclick="assign_rate('.$x.')" ></i>';
								}
								?>
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Comment</div>
							<div class="col-lg-8">
								<input type="text" name="txtcomment" id="txtcomment" required class="form-control">
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-12">
								<center>
									<a href="index.php?pg=<?php echo $backpage;?>.php&option=fullview&orderid=<?php echo $get_orderid;?>"><input type="button" name="btngoback" id="btngoback" value="Go Back" class="btn btn-primary"></a>&nbsp;
									<input type="reset" name="btnclear" id="btnclear" value="Clear" class="btn btn-danger">&nbsp;
									<input type="submit" name="btnsave" id="btnsave" value="Save" class="btn btn-success">
								</center>
							</div>
						</div>

					</form>
				</div>
			</section>
			<?php
		}
		else if($_GET["option"]=="view")
		{
			//table
			?>
			<section class="related-product-area section_gap_bottom">
				<div class="container">
					<div class="col-lg-12 text-center">
						<div class="section-title">
							<h1>Review View</h1>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="table-responsive">
										<a href="index.php?pg=review.php&option=add"><button class="btn btn-primary">Add Review</button></a><br><br>
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">
											<thead>
												<tr>
													<th>Review ID</th>
													<th>Order ID</th>
													<th>Date</th>
													<th>Time</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sqlview="SELECT review_id,order_id,date,time FROM review";
												$resultview=mysqli_query($con,$sqlview) or die("sql error in sqlview ".mysqli_error($con));
												while($rowview=mysqli_fetch_assoc($resultview))
												{
													echo '<tr>';
														echo '<td>'.$rowview["review_id"].'</td>';
														echo '<td>'.$rowview["order_id"].'</td>';
														echo '<td>'.$rowview["date"].'</td>';
														echo '<td>'.$rowview["time"].'</td>';
														echo '<td>';
															echo '<a href="index.php?pg=review.php&option=fullview&reviewid='.$rowview["review_id"].'"><button class="btn btn-success">View</button></a>&nbsp;';
															echo '<a href="index.php?pg=review.php&option=edit&reviewid='.$rowview["review_id"].'"><button class="btn btn-info">Edit</button></a>&nbsp;';
															echo '<a onclick="return askdelete()" href="index.php?pg=review.php&option=delete&reviewid='.$rowview["review_id"].'"><button class="btn btn-danger">Delete</button></a>';
														echo '</td>';
													echo '</tr>';
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</section>
			<?php
		}
		else if($_GET["option"]=="fullview")
		{
			//table
			$get_reviewid=$_GET["reviewid"];

			$sqlfullview="SELECT * FROM review WHERE review_id='$get_reviewid'";
			$resultfullview=mysqli_query($con,$sqlfullview) or die("sql error in sqlfullview ".mysqli_error($con));
			$rowfullview=mysqli_fetch_assoc($resultfullview);

			if(isset($_GET["cusorderid"]))
			{
				$get_orderid=$_GET["cusorderid"];
				$backpage="custom_order";
				$backid="cusorderid";

				$productname=$rowfullview["product_id"];
			}
			else
			{
				$get_orderid=$_GET["orderid"];
				$backpage="order_details";
				$backid="orderid";

				$sqlproductname="SELECT name FROM product WHERE product_id='$rowfullview[product_id]'";
				$resultproductname=mysqli_query($con,$sqlproductname) or die("sql error in sqlproductname ".mysqli_error($con));
				$rowproductname=mysqli_fetch_assoc($resultproductname);

				$productname=$rowproductname["name"];
			}

			?>
			<section class="related-product-area section_gap_bottom">
				<div class="container">
					<div class="col-lg-12 text-center">
						<div class="section-title">
							<h1>Review Fullview</h1>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">
											<tr><th>Review ID</th><td><?php echo $rowfullview["review_id"]; ?></td></tr>
											<tr><th>Order ID</th><td><?php echo $rowfullview["order_id"]; ?></td></tr>
											<tr><th>Product ID</th><td><?php echo $productname; ?></td></tr>
											<tr><th>Date</th><td><?php echo $rowfullview["date"]; ?></td></tr>
											<tr><th>Time</th><td><?php echo $rowfullview["time"]; ?></td></tr>
											<tr><th>Rate</th>
												<td>
													<?php
													for($x=1; $x<=5; $x++)
													{
														if($x<=$rowfullview["rate"])
														{
															echo '<i class="fa fa-star"></i>';
														}
														else
														{
															echo '<i class="fa fa-star-o"></i>';
														}
													}
													?>
												</td>
											</tr>
											<tr><th>Comment</th><td><?php echo $rowfullview["comment"]; ?></td></tr>
											<tr>
												<td colspan="2">
													<center>
														<a href="index.php?pg=<?php echo $backpage;?>.php&option=fullview&orderid=<?php echo $rowfullview["order_id"];?>"><button class="btn btn-primary">Go Back</button></a>&nbsp;
													</center>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</section>
			<?php
		}
		else if($_GET["option"]=="edit")
		{
			//edit from
			$get_reviewid=$_GET["reviewid"];

			$sqledit="SELECT * FROM review WHERE review_id='$get_reviewid'";
			$resultedit=mysqli_query($con,$sqledit) or die("sql error in sqledit ".mysqli_error($con));
			$rowedit=mysqli_fetch_assoc($resultedit);

			?>
			<section class="related-product-area section_gap_bottom">
				<div class="container">
					<div class="col-lg-12 text-center">
						<div class="section-title">
							<h1>Review Edit</h1>
						</div>
					</div>
					<form action="" method="POST">

						<div class="row">
							<div class="col-lg-4">Review ID</div>
							<div class="col-lg-8">
								<input type="text" name="txtreviewid" id="txtreviewid" value="<?php echo $rowedit["review_id"]; ?>" readonly required class="form-control">
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Order ID</div>
							<div class="col-lg-8">
								<select name="txtorderid" id="txtorderid" required class="form-control">
									<?php
									$sqlloadorder_details="SELECT order_id,order_id FROM order_details";
									$resultloadorder_details=mysqli_query($con,$sqlloadorder_details) or die("sql error in sqlloadorder_details ".mysqli_error($con));
									while($rowloadorder_details=mysqli_fetch_assoc($resultloadorder_details))
									{
										if($rowloadorder_details["order_id"]==$rowedit["order_id"])
										{
											echo '<option selected value="'.$rowloadorder_details["order_id"].'">'.$rowloadorder_details["order_id"].'</option>';
										}
										else
										{
											echo '<option value="'.$rowloadorder_details["order_id"].'">'.$rowloadorder_details["order_id"].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Product ID</div>
							<div class="col-lg-8">
								<select name="txtorderid" id="txtorderid" required class="form-control">
									<?php
									$sqlloadproduct="SELECT product_id,name FROM product";
									$resultloadproduct=mysqli_query($con,$sqlloadproduct) or die("sql error in sqlloadproduct ".mysqli_error($con));
									while($rowloadproduct=mysqli_fetch_assoc($resultloadproduct))
									{
										if($rowloadproduct["product_id"]==$rowedit["product_id"])
										{
											echo '<option selected value="'.$rowloadproduct["product_id"].'">'.$rowloadproduct["name"].'</option>';
										}
										else
										{
											echo '<option value="'.$rowloadproduct["product_id"].'">'.$rowloadproduct["name"].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Date</div>
							<div class="col-lg-8">
								<input type="date" name="txtdate" id="txtdate" value="<?php echo $rowedit["date"]; ?>" required class="form-control">
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Time</div>
							<div class="col-lg-8">
								<input type="text" name="txttime" id="txttime" value="<?php echo $rowedit["time"]; ?>" required class="form-control">
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Rate</div>
							<div class="col-lg-8">
								<input type="text" name="txtrate" id="txtrate" value="<?php echo $rowedit["rate"]; ?>" onkeypress="return isNumberKey(event)" required class="form-control">
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-4">Comment</div>
							<div class="col-lg-8">
								<input type="text" name="txtcomment" id="txtcomment" value="<?php echo $rowedit["comment"]; ?>" required class="form-control">
							</div>
						</div><br>

						<div class="row">
							<div class="col-lg-12">
								<center>
									<a href="index.php?pg=review.php&option=view"><input type="button" name="btngoback" id="btngoback" value="Go Back" class="btn btn-primary"></a>&nbsp;
									<input type="reset" name="btnclear" id="btnclear" value="Cancel Changes" class="btn btn-danger">&nbsp;
									<input type="submit" name="btnsavechange" id="btnsavechange" value="Save Changes" class="btn btn-success">
								</center>
							</div>
						</div>

					</form>
				</div>
			</section>
			<?php
		}
		else if($_GET["option"]=="delete")
		{
			//delete code
			$get_reviewid=$_GET["reviewid"];

			$sqldelete="DELETE FROM review WHERE review_id='$get_reviewid'";
			$resultdelete=mysqli_query($con,$sqldelete) or die("sql error in sqldelete ".mysqli_error($con));

			if($resultdelete)
			{
				echo '<script>alert("Successfully deleted!!!");
						window.location.href="index.php?pg=review.php&option=view";</script>';
			}
		}
	}
	?>
</body>
