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


?>
 <div class="card">
        <div class="card-body">
        <center>  <h5 class="card-title">Works On Progress</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer ID</th>
                  <th>Order Address</th>
                  <th>Workers</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                
                  $sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE status='Accepted'";
                
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                    $sqlcheck="SELECT order_id FROM order_process WHERE order_id='$rowview[order_id]' AND status='Progress'";
                    $resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck".mysqli_error($con));
                   if(mysqli_num_rows($resultcheck)>0)
                   {
					   $sqlcheck_worker="SELECT worker_id FROM order_worker WHERE order_id='$rowview[order_id]' AND worker_id='$system_userid'";
						$resultcheck_worker=mysqli_query($con,$sqlcheck_worker) or die ("Error in sqlcheck_worker".mysqli_error($con));
					   if(mysqli_num_rows($resultcheck_worker)>0)
					   {
						$sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowview[customer_id]'";
						$resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
						$rowcustomername=mysqli_fetch_assoc($resultcustomername);
						
						$displayworker="";
						$sqlworker="SELECT worker_id FROM order_worker WHERE order_id='$rowview[order_id]'";
						$resultworker=mysqli_query($con,$sqlworker) or die ("Error in sqlworker".mysqli_error($con));
						while($rowworker=mysqli_fetch_assoc($resultworker))
						{
							$sqlworkername="SELECT name FROM staff WHERE staff_id='$rowworker[worker_id]'";
							$resultworkername=mysqli_query($con,$sqlworkername) or die ("Error in sqlworkername" . mysqli_error($con));
							$rowworkername=mysqli_fetch_assoc($resultworkername);
							$displayworker=$displayworker.$rowworkername["name"].", ";
						}
						echo'<tr>';
							echo '<td>'.$rowview["order_id"].'</td>';
							echo '<td>'.$rowcustomername["name"].'</td>';
							echo '<td>'.$rowview["order_address"].'</td>';
							echo '<td>'.$displayworker.'</td>';
							echo '<td>';
							echo '<a href="index.php?pg=order_detail.php&option=fullview&pk='.$rowview["order_id"].'"><button class="btn btn-success">View</button></a> ';
							
							echo '</td>';
						echo'</tr>';
					   }
                   }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>