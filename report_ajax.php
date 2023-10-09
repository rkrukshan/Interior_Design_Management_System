<?php
if (!isset($_SESSION)) 
{
    session_start();
}
date_default_timezone_set("Asia/Colombo");
include "config.php";
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
?>
<body>
    <?php 
    if(isset($_GET["option"]))
    {       
        if($_GET["option"]=="order")
        {
            $get_ajaxstartdate=$_GET["ajaxstartdate"];
            $get_ajaxenddate=$_GET["ajaxenddate"];

            ?>
            <div class="card">
                <div class="card-body">
                <center>  <h5 class="card-title">Order Detail</h5></center>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlview="SELECT * FROM order_detail WHERE create_date>='$get_ajaxstartdate' AND create_date<='$get_ajaxenddate'";
                                         //for all order details with date range
                        $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                        while($rowview=mysqli_fetch_assoc($resultview))
                        {
                        $sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowview[customer_id]'";
                        $resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
                        $rowcustomername=mysqli_fetch_assoc($resultcustomername);
                        echo'<tr>';
                            echo '<td>'.$rowview["order_id"].'</td>';
                            echo '<td>'.$rowcustomername["name"].'</td>';
                            echo '<td>'.$rowview["create_date"].'</td>';
                            echo '<td>'.$rowview["status"].'</td>';
                            echo '<td>'.$rowview["start_date"].'</td>';
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
        else if($_GET["option"]=="order_status")
        {
            $get_ajaxstartdate=$_GET["ajaxstartdate"];
            $get_ajaxenddate=$_GET["ajaxenddate"];
            $get_ajaxstatus=$_GET["ajaxstatus"];

            ?>
            <div class="card">
                <div class="card-body">
                <center>  <h5 class="card-title">Order Detail</h5></center>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($get_ajaxstatus=="All")
                        {
                            $sqlview="SELECT * FROM order_detail WHERE create_date>='$get_ajaxstartdate' AND create_date<='$get_ajaxenddate'";
                        }
                        else 
                        {
                            $sqlview="SELECT * FROM order_detail WHERE create_date>='$get_ajaxstartdate' AND create_date<='$get_ajaxenddate' AND status='$get_ajaxstatus'";
                        }
                       
                        $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                        while($rowview=mysqli_fetch_assoc($resultview))
                        {
                        $sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowview[customer_id]'";
                        $resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
                        $rowcustomername=mysqli_fetch_assoc($resultcustomername);
                        echo'<tr>';
                            echo '<td>'.$rowview["order_id"].'</td>';
                            echo '<td>'.$rowcustomername["name"].'</td>';
                            echo '<td>'.$rowview["create_date"].'</td>';
                            echo '<td>'.$rowview["status"].'</td>';
                            echo '<td>'.$rowview["start_date"].'</td>';
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
        else if($_GET["option"]=="order_process")
        {
            $get_ajaxstartdate=$_GET["ajaxstartdate"];
            $get_ajaxenddate=$_GET["ajaxenddate"];
            $get_ajaxprocess=$_GET["ajaxprocess"];

            ?>
            <div class="card">
                <div class="card-body">
                <center>  <h5 class="card-title">Order Detail</h5></center>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                        <th>Order Date</th>
                        <th>Accept Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Process Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($get_ajaxprocess=="All")
                        {
                            $sqlview="SELECT * FROM order_detail WHERE create_date>='$get_ajaxstartdate' AND create_date<='$get_ajaxenddate' AND order_id IN (SELECT order_id FROM order_process)";
                        }
                        else 
                        {
                            $sqlview="SELECT * FROM order_detail WHERE create_date>='$get_ajaxstartdate' AND create_date<='$get_ajaxenddate' AND order_id IN (SELECT order_id FROM order_process WHERE status='$get_ajaxprocess')";
                        }
                       
                        $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                        while($rowview=mysqli_fetch_assoc($resultview))//to list down order details
                        {
                            $sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowview[customer_id]'";
                            $resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
                            $rowcustomername=mysqli_fetch_assoc($resultcustomername);

                            $sqlorderprocess="SELECT * FROM order_process WHERE order_id='$rowview[order_id]'";
                            $resultorderprocess=mysqli_query($con,$sqlorderprocess) or die ("Error in sqlorderprocess" . mysqli_error($con));
                            $roworderprocess=mysqli_fetch_assoc($resultorderprocess);
                            echo'<tr>';
                                echo '<td>'.$rowview["order_id"].'</td>';
                                echo '<td>'.$rowcustomername["name"].'</td>';
                                echo '<td>'.$rowview["create_date"].'</td>';
                                echo '<td>'.$rowview["status"].'</td>';
                                echo '<td>'.$roworderprocess["actual_start_date"].'</td>';
                                echo '<td>'.$roworderprocess["actual_end_date"].'</td>';
                                echo '<td>'.$roworderprocess["status"].'</td>';
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

        else if($_GET["option"]=="order_product")
        {
            $get_ajaxstartdate=$_GET["ajaxstartdate"];
            $get_ajaxenddate=$_GET["ajaxenddate"];
            $get_ajaxproduct=$_GET["ajaxproducts"];

            ?>
            <div class="card">
                <div class="card-body">
                <center>  <h5 class="card-title">Order Detail</h5></center>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                        <th>Order Date</th>
                        <th>Accept Status</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $sqlview="SELECT * FROM order_detail WHERE create_date>='$get_ajaxstartdate' AND create_date<='$get_ajaxenddate'";
                        $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                        while($rowview=mysqli_fetch_assoc($resultview))
                        {
                            if($get_ajaxproduct=="All")
                            {
                                $sqlorderproduct="SELECT * FROM order_product WHERE order_id='$rowview[order_id]'";
                            }
                            else 
                            {
                                $sqlorderproduct="SELECT * FROM order_product WHERE order_id='$rowview[order_id]' AND product_id='$get_ajaxproduct'";
                            }
                            
                            $resultorderproduct=mysqli_query($con,$sqlorderproduct) or die ("Error in sqlorderproduct" . mysqli_error($con));
                            while($roworderproduct=mysqli_fetch_assoc($resultorderproduct))
                            {
                                $sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowview[customer_id]'";
                                $resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
                                $rowcustomername=mysqli_fetch_assoc($resultcustomername);

                                $sqlproductname="SELECT name FROM product WHERE product_id='$roworderproduct[product_id]'";
                                $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                                $rowproductname=mysqli_fetch_assoc($resultproductname);

                            
                                echo'<tr>';
                                    echo '<td>'.$rowview["order_id"].'</td>';
                                    echo '<td>'.$rowcustomername["name"].'</td>';
                                    echo '<td>'.$rowview["create_date"].'</td>';
                                    echo '<td>'.$rowview["status"].'</td>';
                                    echo '<td>'.$rowproductname["name"].'</td>';
                                    echo '<td>'.$roworderproduct["quantity"].'</td>';
                                echo'</tr>';
                            }
                        }
                        ?>
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
            <?php
        }





        else  if($_GET["option"]=="purchase")
        {
            $get_ajaxstartdate=$_GET["ajaxstartdate"];
            $get_ajaxenddate=$_GET["ajaxenddate"];

            ?>
            <div class="card">
                <div class="card-body">
                <center>  <h5 class="card-title">Purchase Detail</h5></center>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>Purchase ID</th>
                        <th>Supplier ID</th>
                        <th>Amount</th>
                        <th>Pay Mode</th>
                        <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlview="SELECT * FROM purchase WHERE purchase_date>='$get_ajaxstartdate' AND purchase_date<='$get_ajaxenddate'";
                                         //for all order details with date range
                        $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                        while($rowview=mysqli_fetch_assoc($resultview))
                        {
                        echo'<tr>';
                            echo '<td>'.$rowview["purchase_id"].'</td>';
                            echo '<td>'.$rowview["supplier_id"].'</td>';
                            echo '<td>'.$rowview["amount"].'</td>';
                            echo '<td>'.$rowview["pay_mode"].'</td>';
                            echo '<td>'.$rowview["pay_status"].'</td>';
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


        else  if($_GET["option"]=="purchase_paymode")
        {
            $get_ajaxstartdate=$_GET["ajaxstartdate"];
            $get_ajaxenddate=$_GET["ajaxenddate"];
            $get_ajaxpaymode=$_GET["ajaxpaymode"];

            ?>
            <div class="card">
                <div class="card-body">
                <center>  <h5 class="card-title">Purchase Paymode Detail Report</h5></center>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>Purchase ID</th>
                        <th>Supplier ID</th>
                        <th>Purchase Date</th>
                        <th>Amount</th>
                        <th>Pay Mode</th>
                        <th>Status</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($get_ajaxpaymode=="All")
                        {
                        $sqlview="SELECT * FROM purchase WHERE purchase_date>='$get_ajaxstartdate' AND purchase_date<='$get_ajaxenddate'";
                                         //for all order details with date range
                        }
                        else
                        {
                        $sqlview="SELECT * FROM purchase WHERE purchase_date>='$get_ajaxstartdate' AND purchase_date<='$get_ajaxenddate' AND (pay_mode='$get_ajaxpaymode')";
                        }
                        $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                        while($rowview=mysqli_fetch_assoc($resultview))
                        {
                        echo'<tr>';
                            echo '<td>'.$rowview["purchase_id"].'</td>';
                            echo '<td>'.$rowview["supplier_id"].'</td>';
                            echo '<td>'.$rowview["purchase_date"].'</td>';
                            echo '<td>'.$rowview["amount"].'</td>';
                            echo '<td>'.$rowview["pay_mode"].'</td>';
                            echo '<td>'.$rowview["pay_status"].'</td>';
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


        else  if($_GET["option"]=="staffjoin")
        {
            $get_ajaxstartdate=$_GET["ajaxstartdate"];
            $get_ajaxenddate=$_GET["ajaxenddate"];
            $get_ajaxstaffjoin=$_GET["ajaxstaffjoin"];

            ?>
            <div class="card">
                <div class="card-body">
                <center>  <h5 class="card-title">Staff's Join Date Details Report</h5></center>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>Staff Name</th>
                        <th>Staff ID</th>
                        <th>DOB</th>
                        <th>NIC</th>
                        <th>Join Date</th>
                        <th>Designation</th>                       
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($get_ajaxstaffjoin=="All")
                        {
                        $sqlview="SELECT * FROM staff WHERE join_date>='$get_ajaxstartdate' AND join_date<='$get_ajaxenddate'";
                                         //for all order details with date range
                        }
                        else
                        {
                        $sqlview="SELECT * FROM staff WHERE join_date>='$get_ajaxstartdate' AND join_date<='$get_ajaxenddate' AND (designation='$get_ajaxstaffjoin')";
                        }
                        $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                        while($rowview=mysqli_fetch_assoc($resultview))
                        {
                        echo'<tr>';
                            echo '<td>'.$rowview["name"].'</td>';
                            echo '<td>'.$rowview["staff_id"].'</td>';
                            echo '<td>'.$rowview["dob"].'</td>';
                            echo '<td>'.$rowview["nic"].'</td>';
                            echo '<td>'.$rowview["join_date"].'</td>';
                            echo '<td>'.$rowview["designation"].'</td>';
                            
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


        if($_GET["option"]=="customer")
        {
            $get_ajaxstartdate=$_GET["ajaxstartdate"];
            $get_ajaxenddate=$_GET["ajaxenddate"];

            ?>
            <div class="card">
                <div class="card-body">
                <center>  <h5 class="card-title">customer Detail</h5></center>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>customer ID</th>
                        <th>Customer ID</th>
                        <th>DOB</th>
                        <th>NIC</th>
                        <th>Gender</th>
                        <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlview="SELECT * FROM customer WHERE dob>='$get_ajaxstartdate' AND dob<='$get_ajaxenddate'";
                                         //for all customer details with date range
                        $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                        while($rowview=mysqli_fetch_assoc($resultview))
                        {
                        $sqlcustomername="SELECT name FROM customer WHERE customer_id='$rowview[customer_id]'";
                        $resultcustomername=mysqli_query($con,$sqlcustomername) or die ("Error in sqlcustomername" . mysqli_error($con));
                        $rowcustomername=mysqli_fetch_assoc($resultcustomername);
                        echo'<tr>';
                            echo '<td>'.$rowview["customer_id"].'</td>';
                            echo '<td>'.$rowcustomername["name"].'</td>';
                            echo '<td>'.$rowview["dob"].'</td>';
                            echo '<td>'.$rowview["nic"].'</td>';
                            echo '<td>'.$rowview["gender"].'</td>';
                            echo '<td>'.$rowview["age"].'</td>';
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


        if($_GET["option"]=="customer_age")
        {
            $get_ajaxstartdate=$_GET["ajaxstartdate"];
            $get_ajaxenddate=$_GET["ajaxenddate"];
            $get_ajaxgender=$_GET["ajaxgender"];

            ?>
            <div class="card">
                <div class="card-body">
                <center>  <h5 class="card-title">customer DOB Detail Report</h5></center>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>customer ID</th>
                        <th>Customer Name</th>
                        <th>DOB</th>
                        <th>NIC</th>
                        <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                       
                                         //for all customer details with date range
                                         if($get_ajaxgender=="All")
                        {
                            $sqlview="SELECT * FROM customer WHERE dob>='$get_ajaxstartdate' AND dob<='$get_ajaxenddate'";
                        }
                        else
                        {
                            $sqlview="SELECT * FROM customer WHERE dob>='$get_ajaxstartdate' AND dob<='$get_ajaxenddate' AND (gender='$get_ajaxgender')";
                        }
                            $resultview = mysqli_query($con,$sqlview) or die ("Error in sqlview ".mysqli_error($con));
                        while($rowview=mysqli_fetch_assoc($resultview))
                        {
                                              
                        echo'<tr>';
                            echo '<td>'.$rowview["customer_id"].'</td>';
                            echo '<td>'.$rowview["name"].'</td>';
                            echo '<td>'.$rowview["dob"].'</td>';
                            echo '<td>'.$rowview["nic"].'</td>';
                            echo '<td>'.$rowview["gender"].'</td>';
                           
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




        

    }
    ?>
</body>