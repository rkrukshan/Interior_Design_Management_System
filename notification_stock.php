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
		<center><h5 class="card-title">Stock View</h5></center>
		<div class="table-responsive">
			<table id="zero_config" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>product ID</th>
						<th>quantity</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlview="SELECT product_id,name,minimum_alert FROM product";
					$resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
					while($rowview=mysqli_fetch_assoc($resultview))
					{
						$sqlcheckprice="SELECT product_id  FROM product_price WHERE product_id='$rowview[product_id]' AND end_date IS NULL";
						$resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
						$m=mysqli_num_rows($resultcheckprice);
						if($m==0)//not sale
						{
							$pricemessage='<font color="orange">Currently not Sale</font>';
						}
						else
						{
							$pricemessage="";
						}

						$sqlstockcheck="SELECT quantity FROM stock WHERE product_id='$rowview[product_id]'";
						$resultstockcheck=mysqli_query($con,$sqlstockcheck) or die ("Error in sqlstockcheck" . mysqli_error($con));
						$n=mysqli_num_rows($resultstockcheck);
						if($n==0)
						{
						$quantity='<font color="red"> Still not Purchase</font>';
							echo'<tr>';
									echo '<td>'.$rowview["name"].' '.$pricemessage.'</td>';
									echo '<td>'.$quantity.'</td>';
								echo'</tr>';
						}
						else
						{
							$rowstockcheck=mysqli_fetch_assoc($resultstockcheck);
							if($rowview["minimum_alert"]>$rowstockcheck["quantity"])
							{
								$quantity=$rowstockcheck["quantity"].'<font color="red"> Want to Purchase</font>';								
								echo'<tr>';
										echo '<td>'.$rowview["name"].' '.$pricemessage.'</td>';
										echo '<td>'.$quantity.'</td>';
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