<?php
if (!isset($_SESSION))
{
    session_start();
}
if (isset($_SESSION["login_usertype"])) 
{ //if some one is logon
    $system_usertype = $_SESSION["login_usertype"];
    $system_username = $_SESSION["login_username"];
    $system_userid = $_SESSION["login_userid"];
}
else 
{ //guest
    $system_usertype = "Guest";
}
if ($system_usertype != "Guest") 
{//allow only login users
    include "config.php";
//insert sql start
    if (isset($_POST["btnsave"]))
    {
        $sqlinsert = "INSERT INTO message(message_id,from_id,to_id,message_date,message_time,subject,message,inbox_delete,send_delete,read_status)
  VALUES('" . mysqli_real_escape_string($con, $_POST["txtmessageid"]) . "',
        '" . mysqli_real_escape_string($con, $system_userid) . "',
        '" . mysqli_real_escape_string($con, $_POST["txttoid"]) . "',
        '" . mysqli_real_escape_string($con, date("Y-m-d")) . "',
        '" . mysqli_real_escape_string($con, date("H:i:s")) . "',
        '" . mysqli_real_escape_string($con, $_POST["txtsubject"]) . "',
        '" . mysqli_real_escape_string($con, $_POST["txtmessage"]) . "',
        '" . mysqli_real_escape_string($con, 1) . "',
        '" . mysqli_real_escape_string($con, 1) . "',
        '" . mysqli_real_escape_string($con, 1) . "')";
        $resultinsert = mysqli_query($con, $sqlinsert) or die("sql error in sqlinsert" . mysqli_error($con));
        if ($resultinsert)
        {
            echo '<script> alert("Message Send successfully"); </script>';
        }
    }
//insert sql end

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
                      <center><h4 class="card-title">Compose Message</h4></center>
                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Message ID</label>
                                            <div class="col-sm-3">
                                              <?php
            $sqlgenerateid = "SELECT message_id FROM message ORDER BY message_id DESC LIMIT 1";
            $resultgenerateid = mysqli_query($con, $sqlgenerateid) or die("Error in sqlgenerateid" . mysqli_error($con));
            $n = mysqli_num_rows($resultgenerateid);//count the number of records
            if (mysqli_num_rows($resultgenerateid) == 1)
            {//for other than 1st time
                $rowgenerateid = mysqli_fetch_assoc($resultgenerateid);
                $generateid = ++$rowgenerateid["message_id"];
            }
             else 
            {//For 1st time
                $generateid = "MSG0001";
            }
            ?>
                                                <input type="text" class="form-control" id="txtmessageid" name="txtmessageid" placeholder="Message id Here"  value="<?php echo $generateid; ?>" readonly required>
                                            </div>

                        <label for="fname" class="col-sm-3 text-right control-label col-form-label"> From ID</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtfromid" name="txtfromid" value="<?php echo $system_username; ?>" readonly placeholder="From ID Here" required>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">To ID</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="txttoid" name="txttoid" placeholder="To ID Here"  required>
													<option value="select_option">Select User</option>
													<?php
			if($system_usertype=="Customer")
			{
				$sqluser = "SELECT user_name,user_id,user_type FROM login WHERE status='Active' AND (user_type='Admin' OR user_type='Clerk')";
			}
			else
			{
				$sqluser = "SELECT user_name,user_id,user_type FROM login WHERE status='Active'";
			}

            $resultuser = mysqli_query($con, $sqluser) or die("Error in sqluser" . mysqli_error($con));
            while ($rowuser = mysqli_fetch_assoc($resultuser)) {
                if ($rowuser["user_type"] == "Customer") {
                    $sqlusername = "SELECT name FROM customer WHERE customer_id='$rowuser[user_id]'";
                } else {
                    $sqlusername = "SELECT name FROM staff WHERE staff_id='$rowuser[user_id]'";
                }
                $resultusername = mysqli_query($con, $sqlusername) or die("Error in sqlusername" . mysqli_error($con));
                $rowusername = mysqli_fetch_assoc($resultusername);
                echo '<option value="' . $rowuser["user_id"] . '">' . $rowuser["user_id"] . ' - ' . $rowusername["name"] . '</option>';
            }
            ?>
												</select>
                                            </div>

                        <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Message Date</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="txtmessagedate" name="txtmessagedate" placeholder="Message Date Here" value="<?php echo date("Y-m-d"); ?>" readonly required>
                                            </div>
                                        </div>
                      <!-- field end -->

                      <!-- field start -->
                      <div class="form-group row">
							<label for="fname" class="col-sm-3 text-right control-label col-form-label">Subject</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="txtsubject" name="txtsubject" placeholder="Subject Here" required>
                                            </div>

											<label for="fname" class="col-sm-3 text-right control-label col-form-label">Message</label>
                                            <div class="col-sm-3">
                                                <textarea class="form-control" id="txtmessage" name="txtmessage" placeholder="Message Here" required></textarea>
                                            </div>

                                        </div>
                      <!-- field end -->



                      <!-- button start -->
                      <div class="form-group row">
                                            <div class="col-sm-12">
                          <center>
                            <a href ="index.php?pg=message.php&option=view"><input type="button" class="btn btn-primary" id="btngoback" name="btngoback" value="Go back"></a>
                            <input type="reset" class="btn btn-danger" id="btnclear" name="btnclear" value="Clear">
                            <input type="submit" class="btn btn-success" id="btnsave" name="btnsave" value="Send">
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
  				<center><h5 class="card-title">Inbox</h5></center>
  				<div class="table-responsive">
  					<table id="zero_config" class="table table-striped table-bordered">
  						<a href="index.php?pg=message.php&option=add"><button class="btn btn-primary">Compose Message</button></a>&nbsp;
  						<a href="index.php?pg=message.php&option=send"><button class="btn btn-info">Send Message</button></a>
  						<br><br>
  						<thead>
  							<tr>
  								<th>Message ID</th>
								<th>From ID</th>
								<th>Date</th>
  								<th>Subject</th>
  								<th>Action</th>
  							</tr>
  						</thead>
  						<tbody>
  							<?php                                                                             //inbox_delete='1 means message is not deleted yet
            $sqlview = "SELECT message_id,subject,from_id,message_date,read_status FROM message WHERE to_id='$system_userid' AND inbox_delete='1'";
            $resultview = mysqli_query($con, $sqlview) or die("Error in sqlview " . mysqli_error($con));
            while ($rowview = mysqli_fetch_assoc($resultview)) 
            {
                $sqlusertype_from = "SELECT user_type FROM login WHERE user_id='$rowview[from_id]'";//sql for person who sent message
                $resultusertype_from = mysqli_query($con, $sqlusertype_from) or die("Error in sqlusertype_from" . mysqli_error($con));
                $rowusertype_from = mysqli_fetch_assoc($resultusertype_from);

                if ($rowusertype_from["user_type"] == "Customer")
                {//if any customer send message
                    $sqlusername_from = "SELECT name FROM customer WHERE customer_id='$rowview[from_id]'";//name of the sender
                }
                 else//if any staff send message
                  {
                    $sqlusername_from = "SELECT name FROM staff WHERE staff_id='$rowview[from_id]'";//name of the sender
                  }
                $resultusername_from = mysqli_query($con, $sqlusername_from) or die("Error in sqlusername_from" . mysqli_error($con));
                $rowusername_from = mysqli_fetch_assoc($resultusername_from);
                echo '<tr>';
                if ($rowview["read_status"] == 1)
                {//color change for unread messages
                    echo '<td> <font color="red">' . $rowview["message_id"] . '</font></td>';
                }
                 else
                 {
                    echo '<td>' . $rowview["message_id"] . '</td>';
                 }

                echo '<td>' . $rowview["from_id"] . ' - ' . $rowusername_from["name"] . '</td>';
                echo '<td>' . $rowview["message_date"] . '</td>';
                echo '<td>' . $rowview["subject"] . '</td>';

                echo '<td>';
                echo '<a href="index.php?pg=message.php&option=fullview&pk_inbox=' . $rowview["message_id"] . '"><button class="btn btn-success">View</button></a> ';
                echo '<a onclick="return confirmdelete()" href="index.php?pg=message.php&option=delete&pk_inbox=' . $rowview["message_id"] . '"><button class="btn btn-danger">Delete</button></a> ';
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
 else if ($_GET["option"] == "send") 
 {
            ?>
  		<div class="card">
  			<div class="card-body">
  				<center><h5 class="card-title">Sent Message </h5></center>
  				<div class="table-responsive">
  					<table id="zero_config" class="table table-striped table-bordered">
  						<a href="index.php?pg=message.php&option=add"><button class="btn btn-primary">Compose Message</button></a>&nbsp;
  						<a href="index.php?pg=message.php&option=view"><button class="btn btn-info">Inbox</button></a>
  						<br><br>
  						<thead>
  							<tr>
  								<th>Message ID</th>
								<th>To ID</th>
								<th>Date</th>
  								<th>Subject</th>
  								<th>Action</th>
  							</tr>
  						</thead>
  						<tbody>
  							<?php                                                                              //send_delete='1 means not delete the message yet
            $sqlview = "SELECT message_id,subject,to_id,message_date FROM message WHERE from_id='$system_userid' AND send_delete='1'";
            $resultview = mysqli_query($con, $sqlview) or die("Error in sqlview " . mysqli_error($con));
            while ($rowview = mysqli_fetch_assoc($resultview)) 
            {
                $sqlusertype_to = "SELECT user_type FROM login WHERE user_id='$rowview[to_id]'";//for receive
                $resultusertype_to = mysqli_query($con, $sqlusertype_to) or die("Error in sqlusertype_to" . mysqli_error($con));
                $rowusertype_to = mysqli_fetch_assoc($resultusertype_to);

                if ($rowusertype_to["user_type"] == "Customer") 
                {
                    $sqlusername_to = "SELECT name FROM customer WHERE customer_id='$rowview[to_id]'";
                } 
                else 
                {
                    $sqlusername_to = "SELECT name FROM staff WHERE staff_id='$rowview[to_id]'";
                }
                $resultusername_to = mysqli_query($con, $sqlusername_to) or die("Error in sqlusername_to" . mysqli_error($con));
                $rowusername_to = mysqli_fetch_assoc($resultusername_to);
                echo '<tr>';
                echo '<td>' . $rowview["message_id"] . '</td>';
                echo '<td>' . $rowview["to_id"] . ' - ' . $rowusername_to["name"] . '</td>';
                echo '<td>' . $rowview["message_date"] . '</td>';
                echo '<td>' . $rowview["subject"] . '</td>';

                echo '<td>';
                echo '<a href="index.php?pg=message.php&option=fullview&pk_send=' . $rowview["message_id"] . '"><button class="btn btn-success">View</button></a> ';
                echo '<a onclick="return confirmdelete()" href="index.php?pg=message.php&option=delete&pk_send=' . $rowview["message_id"] . '"><button class="btn btn-danger">Delete</button></a> ';
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
            if (isset($_GET["pk_inbox"])) 
            { //if come from inbox message
                $get_messageid = $_GET["pk_inbox"];
                $backoption = "view"; //back to view option

                $sqlupdate_readstatus = "UPDATE message SET read_status='0' WHERE message_id ='$get_messageid'";
                                                                                  //sent id    fullview&pk_inbox
                $resultupdate_readstatus = mysqli_query($con, $sqlupdate_readstatus) or die("sqlupdate_readstatus error " . mysqli_error($con));
            } 
            else 
            { //if come from send message
                $get_messageid = $_GET["pk_send"];//for sent message
                $backoption = "send"; //back to send option
            }

            $sqlfullview = "SELECT * FROM message WHERE message_id ='$get_messageid'";
            $resultfullview = mysqli_query($con, $sqlfullview) or die("Sqlfullview error " . mysqli_error($con));
            $rowfullview = mysqli_fetch_assoc($resultfullview);

            //name for from id
            $sqlusertype_from = "SELECT user_type FROM login WHERE user_id='$rowfullview[from_id]'";
            $resultusertype_from = mysqli_query($con, $sqlusertype_from) or die("Error in sqlusertype_from" . mysqli_error($con));
            $rowusertype_from = mysqli_fetch_assoc($resultusertype_from);

            if ($rowusertype_from["user_type"] == "Customer") 
            {
                $sqlusername_from = "SELECT name FROM customer WHERE customer_id='$rowfullview[from_id]'";
            } 
            else 
            {
                $sqlusername_from = "SELECT name FROM staff WHERE staff_id='$rowfullview[from_id]'";
            }
            $resultusername_from = mysqli_query($con, $sqlusername_from) or die("Error in sqlusername_from" . mysqli_error($con));
            $rowusername_from = mysqli_fetch_assoc($resultusername_from);

            //name for to id
            $sqlusertype_to = "SELECT user_type FROM login WHERE user_id='$rowfullview[to_id]'";
            $resultusertype_to = mysqli_query($con, $sqlusertype_to) or die("Error in sqlusertype_to" . mysqli_error($con));
            $rowusertype_to = mysqli_fetch_assoc($resultusertype_to);

            if ($rowusertype_to["user_type"] == "Customer") 
            {
                $sqlusername_to = "SELECT name FROM customer WHERE customer_id='$rowfullview[to_id]'";
            }
             else 
            {
                $sqlusername_to = "SELECT name FROM staff WHERE staff_id='$rowfullview[to_id]'";
            }
            $resultusername_to = mysqli_query($con, $sqlusername_to) or die("Error in sqlusername_to" . mysqli_error($con));
            $rowusername_to = mysqli_fetch_assoc($resultusername_to);
            ?>
    <div class="card">
    <div class="card-body">
      <center><h5 class="card-title">Message Full View</h5></center>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <tr><th>Message ID</th><td><?php echo $rowfullview["message_id"]; ?></td></tr>
          <tr><th>From ID</th><td><?php echo $rowfullview["from_id"] . ' - ' . $rowusername_from["name"]; ?></td></tr>
          <tr><th>To ID</th><td><?php echo $rowfullview["to_id"] . ' - ' . $rowusername_to["name"]; ?></td></tr>
          <tr><th>Message Date</th><td><?php echo $rowfullview["message_date"]; ?></td></tr>
          <tr><th>Message Time</th><td><?php echo $rowfullview["message_time"]; ?></td></tr>
          <tr><th>Subject</th><td><?php echo $rowfullview["subject"]; ?></td></tr>
          <tr><th>Message</th><td><?php echo $rowfullview["message"]; ?></td></tr>


          <tr>
            <td colspan="2">
              <center>
                <a href="index.php?pg=message.php&option=<?php echo $backoption; ?>"><button class="btn btn-primary">Go Back</button></a>
              </center>
            </td>
          </tr>
        </table>
      </div>
    </div>
    </div>
    <?php
} 
else if ($_GET["option"] == "delete") 
{
            if (isset($_GET["pk_inbox"])) 
            { //if come from inbox message
                $get_messageid = $_GET["pk_inbox"];
                $backoption = "view"; //back to view option

                $sqldelete = "UPDATE message SET inbox_delete='0', read_status='0' WHERE message_id ='$get_messageid'";
            }
             else 
             { //if come from send message
                $get_messageid = $_GET["pk_send"];
                $backoption = "send"; //back to send option

                $sqldelete = "UPDATE message SET send_delete='0' WHERE message_id ='$get_messageid'";
            }
            $resultdelete = mysqli_query($con, $sqldelete) or die("Error in sqldelete " . mysqli_error($con));
            
            if ($resultdelete)
            {
                echo '<script> alert("Message is Deleted");
				window.location.href="index.php?pg=message.php&option=' . $backoption . '";</script>';
            }
        }
    }
    ?>
    </body>
	<?php
}
else
{
    echo '<script>window.location.href="index.php";</script>';
}
?>
