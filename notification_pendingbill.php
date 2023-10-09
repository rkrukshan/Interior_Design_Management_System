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
        <center>  <h5 class="card-title">Pending Payment</h5></center>
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
                if($system_usertype=="Customer")
                {
                    $sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE status='Accepted' AND customer_id='$system_userid'";
                }
                else 
                {
                    $sqlview="SELECT order_id,customer_id,order_address,status FROM order_detail WHERE status='Accepted'";
                }
                
                $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                while($rowview=mysqli_fetch_assoc($resultview))
                {
                    $get_orderid=$rowview["order_id"];
					
					$sqlfullview = "SELECT * FROM order_detail WHERE order_id  ='$get_orderid'";
					$resultfullview = mysqli_query($con,$sqlfullview) or die("Sqlfullview error ".mysqli_error($con));
					$rowfullview=mysqli_fetch_assoc($resultfullview);
                    $totalprice=0;
                    $sqlvieworderproduct="SELECT order_id,product_id,quantity FROM order_product WHERE order_id='$get_orderid'";
                    $resultvieworderproduct = mysqli_query($con,$sqlvieworderproduct) or die ("Error in sqlvieworderproduct ".mysqli_error($con));
                    while($rowvieworderproduct=mysqli_fetch_assoc($resultvieworderproduct))
                    {
                        $sqlcheckprice="SELECT price,offer,start_date  FROM product_price WHERE product_id='$rowvieworderproduct[product_id]' ORDER BY start_date DESC ";
                        $resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
                        while($rowcheckprice=mysqli_fetch_assoc($resultcheckprice))
                        {
                            if ($rowfullview["create_date"]>=$rowcheckprice["start_date"])
                            {
                            $price=$rowcheckprice["price"];
                            $offer=$rowcheckprice["offer"];
                            break;
                            }
                        }


                        if($offer>0)
                        {
                            $unitprice=$price-(($price*$offer)/100);
                        }
                        else
                        {
                            $unitprice=$price;
                        }
                        $unitprice=number_format((float)$unitprice, 2, '.', '');
                        if ($rowfullview["status"]=="Accepted")
                        {
                            $sqlfinalquantity="SELECT order_id,product_id,quantity FROM order_product_delivery WHERE order_id='$get_orderid' AND product_id='$rowvieworderproduct[product_id]'";
                            $resultfinalquantity=mysqli_query($con,$sqlfinalquantity) OR die ("Error in sqlfinalquantity" .mysqli_error($con));
                            if(mysqli_num_rows($resultfinalquantity)>0)
                            {
                            $rowfinalquantity=mysqli_fetch_assoc($resultfinalquantity);
                            $finalquantity=$rowfinalquantity["quantity"];
                            $subtotal=$rowfinalquantity["quantity"]*$unitprice;
                            }
                            else
                            {
                            $subtotal=$rowvieworderproduct["quantity"]*$unitprice;
                            $finalquantity="";
                            }
                        }
                        else
                        {
                            $subtotal=$rowvieworderproduct["quantity"]*$unitprice;
                        }

                        $totalprice=$totalprice+$subtotal;                    
                    }
					
					$sqlviewcustomorder = "SELECT * FROM custom_order WHERE order_id='$get_orderid'";
					$resultviewcustomorder = mysqli_query($con, $sqlviewcustomorder) or die("Error in sqlviewcustomorder " . mysqli_error($con));
					while ($rowviewcustomorder = mysqli_fetch_assoc($resultviewcustomorder))
					{
						if($rowviewcustomorder["accept_price"]=="")
						{
						  $subtotal=$rowviewcustomorder["quantity"]*0;
						}
						else
						{
						  $subtotal=$rowviewcustomorder["quantity"]*$rowviewcustomorder["accept_price"];
						}
						if($rowviewcustomorder["status"]=="Accepted")
						{
						$totalprice=$totalprice+$subtotal;
						}						
					}
					
					$sqlpaidamount="SELECT SUM(amount) AS t_amount FROM bill WHERE order_id='$get_orderid' AND pay_status='Paid'";
					$resultpaidamount=mysqli_query($con,$sqlpaidamount) or die ("error in sqlpaidamount" .mysqli_error($con));
					$rowpaidamount=mysqli_fetch_assoc($resultpaidamount);
					
					if ($totalprice>$rowpaidamount["t_amount"])                  
                    {
						$sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowview[customer_id]'";
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