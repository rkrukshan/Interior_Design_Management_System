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
        <center>  <h5 class="card-title">Approve Payment</h5></center>
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer ID</th>
                  <th>Order Address</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                
                  $sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE status='Accepted'";//order which is accepted by admin
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                    $sqlcheckbill="SELECT bill_id FROM bill WHERE order_id='$rowview[order_id]' AND pay_status='Pending'";//pending bill id
                    $resultcheckbill=mysqli_query($con,$sqlcheckbill) or die ("Error in sqlcheckbill" .mysqli_error($con));
                    if (mysqli_num_rows($resultcheckbill)>0)//if there any pending status
                    {
                            $sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowview[customer_id]'";//pending customer name
                            $resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
                            $rowcustomername=mysqli_fetch_assoc($resultcustomername);
                            echo'<tr>';
                                echo '<td>'.$rowview["order_id"].'</td>';
                                echo '<td>'.$rowcustomername["name"].'</td>';
                                echo '<td>'.$rowview["order_address"].'</td>';
                                echo '<td>'.$rowview["status"].'</td>';
                                echo '<td>';
                                echo '<a href="index.php?pg=order_detail.php&option=fullview&pk='.$rowview["order_id"].'"><button class="btn btn-success">View</button></a> ';
                                
                                echo '</td>';
                            echo'</tr>';
                    }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>