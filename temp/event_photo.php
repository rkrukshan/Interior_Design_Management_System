<?php
if(!isset($_SESSION))
{
	session_start();
}
if(isset($_SESSION["login_usertype"]))
{
	$systemusertype=$_SESSION["login_usertype"];
	$systemusername=$_SESSION["login_username"];
}
else
{
	$systemusertype="guest";
}

include("connection.php");
if(isset($_POST["btnsubmitadd"]))
{	
	$target_dir = "upload_event_photos/";
	$target_file = $target_dir . basename($_FILES["txtphoto_name"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
	{
		echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");</script>';
	}
	else
	{
		$filename=$_POST["txtphoto_id"].".".$imageFileType;
		$fileupload=$target_dir . $filename;
		move_uploaded_file($_FILES["txtphoto_name"]["tmp_name"], $fileupload);
		$sqlinsert="INSERT INTO event_photo(event_id, photo_id, name)
							VALUES('".mysql_real_escape_string($_POST["txtevent_id"])."',
									'".mysql_real_escape_string($_POST["txtphoto_id"])."',
									'".mysql_real_escape_string($filename)."')";
		$resultinsert=mysql_query($sqlinsert) or die("sql error in sqlinsert ".mysql_error());
		if($resultinsert)
		{
			echo '<script>alert("Success");</script>';
		}
	}
}
if(isset($_POST["btnsubmitedit"]))
{
	$target_dir = "upload_event_photos/";
	$target_file = $target_dir . basename($_FILES["txtphoto_name"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
	{
		echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");</script>';
	}
	else
	{
		$filename=$_POST["txtphoto_id"].".".$imageFileType;
		$fileupload=$target_dir . $filename;
		move_uploaded_file($_FILES["txtphoto_name"]["tmp_name"], $fileupload);
		$sqlupdate="UPDATE event_photo SET
							name='".mysql_real_escape_string($filename)."'
							WHERE photo_id='".mysql_real_escape_string($_POST["txtphoto_id"])."'";
		$resultupdate=mysql_query($sqlupdate) or die("sql error in sqlupdate ".mysql_error());
		if($resultupdate)
		{
			echo '<script>alert("Success");
				window.location.href="index.php?pg=event_details.php&option=fullview&f_eventid='.$_POST["txtevent_id"].'";</script>';
		}
	}	
}
?>
<html>
	<body>
	<?php
		if(isset($_GET["option"]))
		{
			if($_GET["option"]=="add")
			{
				?>
				<form method="POST" action="" enctype="multipart/form-data">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									Event Photo
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">
											<tr>
												<th>Event ID</th>
												<td>
													<select name="txtevent_id" id="txtevent_id" class="form-control" required>
														<?php
														$get_addeventid=$_GET["addeventid"];
														$sqlload="SELECT event_id, name FROM event_details WHERE event_id='$get_addeventid'";
														$resultload=mysql_query($sqlload) or die("sql error in sqlload ".mysql_error());
														while($rowload=mysql_fetch_assoc($resultload))
														{
															echo '<option value="'.$rowload["event_id"].'">'.$rowload["name"].'</option>';
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<th>Photo ID</th>
												<td>
												<?php
													$sqlgenerateid="SELECT photo_id FROM event_photo ORDER BY photo_id DESC LIMIT 1";
													$resultgenerate=mysql_query($sqlgenerateid) or die("sql error in sqlgenerateid ".mysql_error());
													if(mysql_num_rows($resultgenerate)==1)
													{
														//for other times
														$rowgenerate=mysql_fetch_assoc($resultgenerate);
														$photoid=++$rowgenerate["photo_id"];
													}
													else
													{
														//for first time
														$photoid="PHO01";
													}
													?>
		   
													<input type="text" value="<?php echo $photoid; ?>" readonly name="txtphoto_id" id="txtphoto_id" class="form-control" required>
												</td>
											</tr>
											<tr>
												<th>Photo Name</th>
												<td>
													<input type="file" name="txtphoto_name" onkeypress="return isTextKey(event)" id="txtphoto_name" class="form-control" required>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<center>
														<a href="index.php?pg=event_details.php&option=fullview&f_eventid=<?php echo $get_addeventid; ?>"><input type="button" name="btngoback" id="btngoback" value="Go Back" class="btn btn-primary"></a>
														<input type="reset" name="btnreset" id="btnreset" value="Clear" class="btn btn-danger">
														<input type="submit" name="btnsubmitadd" id="btnsubmitadd" value="Save" class="btn btn-success">
													</center>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				<?php
			}
			else if($_GET["option"]=="view")
			{
			echo '<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									Event Photo Details
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
										echo '<a href="index.php?pg=event_photo.php&option=add"><button class="btn btn-primary">Add New Event Photo</button></a>';
											echo '<thead>';
												echo '<tr>';
													echo '<th>Event ID</th>';
													echo '<th>Photo ID</th>';
	                         				        echo '<th>Name</th>';
													echo '<th>Action</th>';
												echo '</tr>';
											echo '</thead>';
											echo '<tbody>';
												$sqlview="SELECT * FROM event_photo";
												$resultview=mysql_query($sqlview) or die("sql error in sqlview ".mysql_error());
												while($rowview=mysql_fetch_assoc($resultview))
												{
													echo '<tr>';
														echo '<td>'.$rowview["event_id"].'</td>';
														echo '<td>'.$rowview["photo_id"].'</td>';
														echo '<td>'.$rowview["name"].'</td>';
														echo '<td>';
															echo '<a href="index.php?pg=event_photo.php&option=fullview&f_photoid='.$rowview["photo_id"].'"><button class="btn btn-success"><i class="fa fa-eye"></i> View</button></a> ';
															echo '<a href="index.php?pg=event_photo.php&option=edit&e_photoid='.$rowview["photo_id"].'"><button class="btn btn-info"><i class="fa fa-pencil"></i> Edit</button></a> ';
															echo '<a onclick="return deletedata()" href="index.php?pg=event_photo.php&option=delete&d_photoid='.$rowview["photo_id"].'"><button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button></a>';
														echo '</td>';
													echo '</tr>';
												}
											echo '</tbody>';
										echo '</table>
									</div>
								</div>
							</div>
						</div>
					</div>';	
			}
			else if($_GET["option"]=="fullview")
			{
				
			}
			else if($_GET["option"]=="edit")
			{
				$get_e_photoid=$_GET["e_photoid"];
				$get_e_eventid=$_GET["e_eventid"];
				$sqledit="SELECT * FROM event_photo WHERE photo_id='$get_e_photoid'";
				$resultedit=mysql_query($sqledit) or die("sql error in sqledit ".mysql_error());
				$rowedit=mysql_fetch_assoc($resultedit);				
				?>
				<form method="POST" action="" enctype="multipart/form-data">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									Event Photo
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">
											<tr>
												<th>Event ID</th>
												<td>
													<select name="txtevent_id" id="txtevent_id" class="form-control" required>
														
														<?php
														$sqlload="SELECT event_id, name FROM event_details WHERE event_id='$get_e_eventid'";
														$resultload=mysql_query($sqlload) or die("sql error in sqlload ".mysql_error());
														while($rowload=mysql_fetch_assoc($resultload))
														{
															echo '<option value="'.$rowload["event_id"].'">'.$rowload["name"].'</option>';
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<th>Photo ID</th>
												<td>
													<input type="text" value="<?php echo $rowedit["photo_id"]; ?>" readonly name="txtphoto_id" id="txtphoto_id" class="form-control" required>
												</td>
											</tr>
											<tr>
												<th>Photo Name</th>
												<td>
													<input type="file" name="txtphoto_name" onkeypress="return isTextKey(event)" id="txtphoto_name" class="form-control" required>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<center>
														<a href="index.php?pg=event_details.php&option=fullview&f_eventid=<?php echo $get_e_eventid; ?>"><input type="button" name="btngoback" id="btngoback" value="Go Back" class="btn btn-primary"></a>
														<input type="reset" name="btnreset" id="btnreset" value="Clear" class="btn btn-danger">
														<input type="submit" name="btnsubmitedit" id="btnsubmitedit" value="Save Changes" class="btn btn-success">
													</center>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				<?php
			}
			else if($_GET["option"]=="delete")
			{				
				$get_d_photoid=$_GET["d_photoid"];
				$get_d_eventid=$_GET["d_eventid"];
				$sqldelete="DELETE FROM event_photo WHERE photo_id='$get_d_photoid'";
				$resultdelete=mysql_query($sqldelete) or die("sql error in sqldelete ".mysql_error());
				if($resultdelete)
				{
					echo '<script>alert("Successfully deleted"); 
					window.location.href="index.php?pg=event_details.php&option=fullview&f_eventid='.$get_d_eventid.'";</script>';
				} 
			}
		}
	?>
	</body>
</html>