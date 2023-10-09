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
<script>
  //order report start
  function enableenddate_order()
  {
    var startdate=document.getElementById("txtstartdate").value;
    document.getElementById("btnprint_order").disabled=true;//disable button print
    document.getElementById("display_details_order").innerHTML="";//make div as blank
    if(startdate!="")//if any value on there
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=false;//disable read only
      document.getElementById("txtenddate").min=startdate;//start date<=end date
    }
    else
    {
      document.getElementById("txtenddate").value="";//make txtenddate as empty
      document.getElementById("txtenddate").readOnly=true;//enable read only
    }
  }

  

  function generate_order()//it's contain ajax to load contents
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
  
    if(enddate!="")//if end date is not empty
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          var get_response = xmlhttp.responseText.trim();
          document.getElementById("display_details_order").innerHTML=get_response;
          document.getElementById("btnprint_order").disabled=false;//enable button
        }
      };
      xmlhttp.open("GET", "report_ajax.php?option=order&ajaxstartdate=" + startdate+"&ajaxenddate=" + enddate, true);
      xmlhttp.send();
    }
    else
    {
      document.getElementById("btnprint_order").disabled=true;//disable button
      document.getElementById("display_details_order").innerHTML="";//if select start date then end date field is enable
    }  
  }

  function print_order()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var url="print.php?pr=report.php&option=order&printstartdate=" + startdate+"&printenddate=" + enddate;
    window.open(url,"_blank");
  }
  //order report end
</script>

<script>
  //order_status report start
  function enableenddate_order_status()
  {
    var startdate=document.getElementById("txtstartdate").value;
    document.getElementById("btnprint_order_status").disabled=true;/*disable button print*/
    document.getElementById("display_details_order_status").innerHTML="";//div is blank 
    if(startdate!="")
    {
      document.getElementById("txtenddate").value="";//make end date blank
      document.getElementById("txtenddate").readOnly=false;
      document.getElementById("txtenddate").min=startdate;//end date>=start date
    }
    else
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=true;//enable read only
    }
  }


  
  function generate_order_status()
  {
    var startdate=document.getElementById("txtstartdate").value;//for start date field
    var enddate=document.getElementById("txtenddate").value;////for end date field
    var selectedstatus=document.getElementById("txtstatus").value;//selected option in drop down
  
    if(enddate!="")
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          var get_response = xmlhttp.responseText.trim();
         
           document.getElementById("display_details_order_status").innerHTML=get_response;
           document.getElementById("btnprint_order_status").disabled=false;
        }
      };
      xmlhttp.open("GET", "report_ajax.php?option=order_status&ajaxstartdate=" + startdate+"&ajaxenddate=" + enddate+"&ajaxstatus=" + selectedstatus, true);
      xmlhttp.send();
    }
    else
    {
      document.getElementById("btnprint_order_status").disabled=true;//button is disabled
      document.getElementById("display_details_order_status").innerHTML="";//make data div is blank
    }  
  }

  function print_order_status()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedstatus=document.getElementById("txtstatus").value;
    var url="print.php?pr=report.php&option=order_status&printstartdate=" + startdate+"&printenddate=" + enddate+"&printstatus=" + selectedstatus;
    window.open(url,"_blank");  //load within the page                                                            //variable name   //javascriptvariable(white code)
  }
  //order report end
</script>


<script>
  //order_process report start
  function enableenddate_order_process()
  {
    var startdate=document.getElementById("txtstartdate").value;
    document.getElementById("btnprint_order_process").disabled=true;/*disable button print*/
    document.getElementById("display_details_order_process").innerHTML="";//div is blank 
    if(startdate!="")
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=false;
      document.getElementById("txtenddate").min=startdate;//end date>=start date
    }
    else
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=true;//enable read only
    }
  }


  
  function generate_order_process()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedprocess=document.getElementById("txtprocess").value;
  
    if(enddate!="")
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          var get_response = xmlhttp.responseText.trim();
          
           document.getElementById("display_details_order_process").innerHTML=get_response;
           document.getElementById("btnprint_order_process").disabled=false;
        }
      };
      xmlhttp.open("GET", "report_ajax.php?option=order_process&ajaxstartdate=" + startdate+"&ajaxenddate=" + enddate+"&ajaxprocess=" + selectedprocess, true);
      xmlhttp.send();
    }
    else
    {
      document.getElementById("btnprint_order_process").disabled=true;//button is disabled
      document.getElementById("display_details_order_process").innerHTML="";//make data div is blank
    }  
  }

  function print_order_process()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedprocess=document.getElementById("txtprocess").value;
    var url="print.php?pr=report.php&option=order_process&printstartdate=" + startdate+"&printenddate=" + enddate+"&printprocess=" + selectedprocess;
    window.open(url,"_blank");  //load within the page                                                             //variable name   javascriptvariable(white code)
  }
  //order process report end
</script>



<script>
  //order_product report start
  function enableenddate_order_product()
  {
    var startdate=document.getElementById("txtstartdate").value;
    document.getElementById("btnprint_order_product").disabled=true;/*disable button print*/
    document.getElementById("display_details_order_product").innerHTML="";//div is blank 
    if(startdate!="")
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=false;
      document.getElementById("txtenddate").min=startdate;//end date>=start date
    }
    else
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=true;//enable read only
    }
  }


  
  function generate_order_product()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedproduct=document.getElementById("txtproduct").value;
  
    if(enddate!="")
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          var get_response = xmlhttp.responseText.trim();
          
           document.getElementById("display_details_order_product").innerHTML=get_response;//contents from ajax 
           document.getElementById("btnprint_order_product").disabled=false;//display button
        }
      };
      xmlhttp.open("GET", "report_ajax.php?option=order_product&ajaxstartdate=" + startdate+"&ajaxenddate=" + enddate+"&ajaxproducts=" + selectedproduct, true);
      xmlhttp.send();                                                                                           
    }
    else
    {
      document.getElementById("btnprint_order_product").disabled=true;//button is disabled
      document.getElementById("display_details_order_product").innerHTML="";//make data div is blank
    }  
  }

  function print_order_product()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedproduct=document.getElementById("txtproduct").value;
    var url="print.php?pr=report.php&option=order_product&printstartdate=" + startdate+"&printenddate=" + enddate+"&printproduct=" + selectedproduct;
    window.open(url,"_blank");  //load within the page                                                             //variable name   //javascriptvariable(white code)
  }
  //order product report end
</script>



<script>
  //purchase report start
  function enableenddate_purchase()
  {
    var startdate=document.getElementById("txtstartdate").value;
    document.getElementById("btnprint_purchase").disabled=true;/*disable button print*/
    document.getElementById("display_details_purchase").innerHTML="";//make div as blank
    if(startdate!="")//if any value on there
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=false;//disable read only
      document.getElementById("txtenddate").min=startdate;//start date<=end date
    }
    else
    {
      document.getElementById("txtenddate").value="";//make txtenddate as empty
      document.getElementById("txtenddate").readOnly=true;//enable read only
    }
  }



  function generate_purchase()//it's contain ajax to load contents
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;

    if(enddate!="")//if end date is not empty
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          var get_response = xmlhttp.responseText.trim();
          document.getElementById("display_details_purchase").innerHTML=get_response;
          document.getElementById("btnprint_purchase").disabled=false;//enable button
        }
      };
      xmlhttp.open("GET", "report_ajax.php?option=purchase&ajaxstartdate=" + startdate+"&ajaxenddate=" + enddate, true);
      xmlhttp.send();
    }
    else
    {
      document.getElementById("btnprint_purchase").disabled=true;//disable button
      document.getElementById("display_details_purchase").innerHTML="";//if select start date then end date field is enable
    }
  }

  function print_purchase()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var url="print.php?pr=report.php&option=purchase&printstartdate=" + startdate+"&printenddate=" + enddate;
    window.open(url,"_blank");
  }
  //purchase report end
</script>





<script>
  //purchase_paymode report start
  function enableenddate_purchase_paymode()
  {
    var startdate=document.getElementById("txtstartdate").value;
    document.getElementById("btnprint_purchase_paymode").disabled=true;/*disable button print*/
    document.getElementById("display_details_purchase_paymode").innerHTML="";//div is blank 
    if(startdate!="")
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=false;
      document.getElementById("txtenddate").min=startdate;//end date>=start date
    }
    else
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=true;//enable read only
    }
  }


  
  function generate_purchase_paymode()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedpaymode=document.getElementById("txtpurchasepaymode").value;
  
    if(enddate!="")
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          var get_response = xmlhttp.responseText.trim();
          
           document.getElementById("display_details_purchase_paymode").innerHTML=get_response;//contents from ajax 
           document.getElementById("btnprint_purchase_paymode").disabled=false;//display button
        }
      };
      xmlhttp.open("GET", "report_ajax.php?option=purchase_paymode&ajaxstartdate=" + startdate+"&ajaxenddate=" + enddate+"&ajaxpaymode=" + selectedpaymode, true);
      xmlhttp.send();
    }
    else
    {
      document.getElementById("btnprint_purchase_paymode").disabled=true;//button is disabled
      document.getElementById("display_details_purchase_paymode").innerHTML="";//make data div is blank
    }  
  }

  function print_purchase_paymode()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedpaymode=document.getElementById("txtpurchasepaymode").value;
    var url="print.php?pr=report.php&option=purchase_paymode&printstartdate=" + startdate+"&printenddate=" + enddate+"&printpaymode=" + selectedpaymode;
    window.open(url,"_blank");  //load within the page                                                             //variable name   //javascriptvariable(white code)
  }
  //order product report end
</script>


<script>
  //customerage report start
  function enableenddate_order_product()
  {
    var startdate=document.getElementById("txtstartdate").value;
    document.getElementById("btnprint_order_product").disabled=true;/*disable button print*/
    document.getElementById("display_details_order_product").innerHTML="";//div is blank
    if(startdate!="")
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=false;
      document.getElementById("txtenddate").min=startdate;//end date>=start date
    }
    else
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=true;//enable read only
    }
  }



  function generate_order_product()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedgender=document.getElementById("txtproduct").value;

    if(enddate!="")
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          var get_response = xmlhttp.responseText.trim();

           document.getElementById("display_details_order_product").innerHTML=get_response;//contents from ajax
           document.getElementById("btnprint_order_product").disabled=false;//display button
        }
      };
      xmlhttp.open("GET", "report_ajax.php?option=order_product&ajaxstartdate=" + startdate+"&ajaxenddate=" + enddate+"&ajaxgender=" + selectedgender, true);
      xmlhttp.send();
    }
    else
    {
      document.getElementById("btnprint_order_product").disabled=true;//button is disabled
      document.getElementById("display_details_order_product").innerHTML="";//make data div is blank
    }
  }

  function print_order_product()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedgender=document.getElementById("txtproduct").value;
    var url="print.php?pr=report.php&option=order_product&printstartdate=" + startdate+"&printenddate=" + enddate+"&printproduct=" + selectedgender;
    window.open(url,"_blank");  //load within the page                                                             //variable name   //javascriptvariable(white code)
  }
  //order customerage report end
</script>



<script>
  //customerage report start
  function enableenddate_staffjoin()
  {
    var startdate=document.getElementById("txtstartdate").value;
    document.getElementById("btnprint_staffjoin").disabled=true;/*disable button print*/
    document.getElementById("display_details_staffjoin").innerHTML="";//div is blank
    if(startdate!="")
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=false;
      document.getElementById("txtenddate").min=startdate;//end date>=start date
    }
    else
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=true;//enable read only
    }
  }



  function generate_staffjoin()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedstaffjoin=document.getElementById("txtstaffjoin").value;

    if(enddate!="")
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          var get_response = xmlhttp.responseText.trim();

           document.getElementById("display_details_staffjoin").innerHTML=get_response;//contents from ajax
           document.getElementById("btnprint_staffjoin").disabled=false;//display button
        }
      };
      xmlhttp.open("GET", "report_ajax.php?option=staffjoin&ajaxstartdate=" + startdate+"&ajaxenddate=" + enddate+"&ajaxstaffjoin=" + selectedstaffjoin, true);
      xmlhttp.send();
    }
    else
    {
      document.getElementById("btnprint_staffjoin").disabled=true;//button is disabled
      document.getElementById("display_details_staffjoin").innerHTML="";//make data div is blank
    }
  }

  function print_staffjoin()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedstaffjoin=document.getElementById("txtstaffjoin").value;
    var url="print.php?pr=report.php&option=staffjoin&printstartdate=" + startdate+"&printenddate=" + enddate+"&printstaffjoin=" + selectedstaffjoin;
    window.open(url,"_blank");  //load within the page                                                             //variable name   //javascriptvariable(white code)
  }
  //order customerage report end
</script>


<script>
  //customer_age report start
  function enableenddate_customer_age()
  {
    var startdate=document.getElementById("txtstartdate").value;
    document.getElementById("btnprint_customer_age").disabled=true;/*disable button print*/
    document.getElementById("display_details_customer_age").innerHTML="";//div is blank
    if(startdate!="")
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=false;
      document.getElementById("txtenddate").min=startdate;//end date>=start date
    }
    else
    {
      document.getElementById("txtenddate").value="";
      document.getElementById("txtenddate").readOnly=true;//enable read only
    }
  }



  function generate_customer_age()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedgender=document.getElementById("txtgender").value;

    if(enddate!="")
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          var get_response = xmlhttp.responseText.trim();

           document.getElementById("display_details_customer_age").innerHTML=get_response;
           document.getElementById("btnprint_customer_age").disabled=false;
        }
      };
      xmlhttp.open("GET", "report_ajax.php?option=customer_age&ajaxstartdate=" + startdate+"&ajaxenddate=" + enddate+"&ajaxgender=" + selectedgender, true);
      xmlhttp.send();
    }
    else
    {
      document.getElementById("btnprint_customer_age").disabled=true;//button is disabled
      document.getElementById("display_details_customer_age").innerHTML="";//make data div is blank
    }
  }

  function print_customer_age()
  {
    var startdate=document.getElementById("txtstartdate").value;
    var enddate=document.getElementById("txtenddate").value;
    var selectedgender=document.getElementById("txtgender").value;
    var url="print.php?pr=report.php&option=customer_age&printstartdate=" + startdate+"&printenddate=" + enddate+"&printgender=" + selectedgender;
    window.open(url,"_blank");  //load within the page                                                             //variable name   //javascriptvariable(white code)
  }
  //order process report end
</script>



<?php 
 if(isset($_GET["pg"]))
 {
  echo '<body>';
  //for display data of the report page
 }
 else
 {
  if($_GET["option"]=="order")//order report
  {
    echo '<body onload="generate_order()">';
  }
  else if($_GET["option"]=="order_status")//order status report
  {
    echo '<body onload="generate_order_status()">';
  }
  else if($_GET["option"]=="order_process")//order process report
  {
    echo '<body onload="generate_order_process()">';
  }
  else if($_GET["option"]=="order_product")//order product report
  {
    echo '<body onload="generate_order_product()">';
  }
  else if($_GET["option"]=="purchase")
  {
    echo '<body onload="generate_purchase()">';//order purchase report
  }
  else if($_GET["option"]=="purchase_paymode")
  {
    echo '<body onload="generate_purchase_paymode()">';//order purchase report
  }
  else if($_GET["option"]=="staffjoin")
  {
    echo '<body onload="generate_staffjoin()">';//order purchase report
  }
  else if($_GET["option"]=="customer_age")
  {
    echo '<body onload="generate_customer_age()">';// customer_age report
  }

 }

    if(isset($_GET["option"]))
    {
        if($_GET["option"]=="order")
        {
  ?>
  <!-- form section start -->
  <section class="feature_part padding_top">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            
              <div class="card-body">
              <center><img src="img/pics/report.png" height="100" width="100"></center>
                <center><h4 class="card-title">Order Details</h4></center>

                                <!-- field start -->
                <div class="form-group row">
                                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                      <div class="col-sm-3">
                                        <?php 
                                        if(isset($_GET["printstartdate"]))
                                        {
                                          echo $_GET["printstartdate"]; //for display start date in report page (after click print button on order report)
                                          ?> 
                                          <input type="hidden" class="form-control" id="txtstartdate" name="txtstartdate" value="<?php echo $_GET["printstartdate"]; ?>" required>
                                          <?php
                                        }
                                        else
                                        {
                                          ?> 
                                          <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" onchange="enableenddate_order()" required><!--end date enable after enter start date-->
                                          <?php
                                        }
                                        ?>
                                          
                                      </div>

                  <label for="fname" class="col-sm-3 text-right control-label col-form-label"> End Date</label>
                                      <div class="col-sm-3">
                                      <?php 
                                        if(isset($_GET["printenddate"]))
                                        {
                                          echo $_GET["printenddate"];//for display end  date in report page (after click print button on order report)
                                          ?> 
                                          <input type="hidden" class="form-control" id="txtenddate" name="txtenddate" required value="<?php echo $_GET["printenddate"]; ?>" readonly>
                                          <?php
                                        }
                                        else
                                        {
                                          ?> 
                                          <input type="date" class="form-control" id="txtenddate" name="txtenddate" required onchange="generate_order()" readonly><!--enable print button after enter values of start and end dates-->
                                          <?php
                                        }
                                        ?>
                                          
                                      </div>
                                  </div>
                <!-- field end -->
                <?php 
                  if(isset($_GET["pg"]))//hide print button on printing page
                  {
                    ?>
                                <!-- button start -->
                <div class="form-group row">
                                      <div class="col-sm-12">
                    <center>
                      <input type="button" class="btn btn-primary" id="btnprint_order" onclick="print_order()" name="btnprint_order" value="print" disabled><!--For print-->
                      
                    </center>
                                      </div>
                                  </div>
                <!-- button end -->
                <?php 
                  }
                ?>

              </div>
            
          </div>
        </div>
      </div>
    </div>
      </section>
  <!-- form section end -->
  <div id="display_details_order"></div> <!--for End Date field-->
  <?php
        }






        
        else if($_GET["option"]=="order_status")
        {
      ?>
      <!-- form section start -->
      <section class="feature_part padding_top">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                
                  <div class="card-body">
                  <center><img src="img/pics/report.png" height="100" width="100"></center>
                    <center><h4 class="card-title">Order Status Details</h4></center>
    
                                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                          <div class="col-sm-3">
                                            <?php 
                                            if(isset($_GET["printstartdate"]))
                                            {
                                              echo $_GET["printstartdate"];
                                              ?> 
                                              <input type="hidden" class="form-control" id="txtstartdate" name="txtstartdate" value="<?php echo $_GET["printstartdate"]; ?>" required>
                                              <?php
                                            }
                                            else
                                            {
                                              ?> 
                                              <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" onchange="enableenddate_order_status()" required>
                                              <?php
                                            }
                                            ?>
                                              
                                          </div>
    
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label"> End Date</label>
                                          <div class="col-sm-3">
                                          <?php 
                                            if(isset($_GET["printenddate"]))
                                            {
                                              echo $_GET["printenddate"];
                                              ?> 
                                              <input type="hidden" class="form-control" id="txtenddate" name="txtenddate" required value="<?php echo $_GET["printenddate"]; ?>" readonly >
                                              <?php
                                            }
                                            else
                                            {
                                              ?> 
                                              <input type="date" class="form-control" id="txtenddate" name="txtenddate" required onchange="generate_order_status()" readonly >
                                              <?php
                                            }
                                            ?>
                                              
                                          </div>
                                      </div>
                    <!-- field end -->
                              <div class="form-group row">

                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                    <div class="col-sm-3">
                              <?php 
                                      if(isset($_GET["printstatus"]))
                                      {
                                        echo $_GET["printstatus"];
                                        ?>
                                        <input type="hidden" name="txtstatus" id="txtstatus" value="<?php echo $_GET["printstatus"]; ?>">
                                        <?php
                                      }
                                      else 
                                      {
                                        ?>
                                        <select class="form-control" id="txtstatus" name="txtstatus" placeholder="Status" required onchange="generate_order_status()">
                                          <option value="All">All</option>
                                          <option value="Accepted">Accepted</option>
                                          <option value="Rejected">Rejected</option>
                                          <option value="Pending">Pending</option>
                                        </select>
                                        <?php
                                      }
                                        ?>  
                                        
                                    </div>

                              </div>
                      </div>
                    <?php 
                      if(isset($_GET["pg"]))//just for load page
                      {
                        ?>
                        
                                    <!-- button start -->
                    <div class="form-group row">
                                          <div class="col-sm-12">
                        <center>
                          <input type="button" class="btn btn-primary" id="btnprint_order_status" onclick="print_order_status()" name="btnprint_order_status" value="print" disabled>
                          
                        </center>
                                          </div>
                                      </div>
                    <!-- button end -->
                    <?php 
                      }
                    ?>
    
                  </div>
                
              </div>
            </div>
          </div>
        </div>
          </section>
      <!-- form section end -->
      <div id="display_details_order_status"></div> <!--for End Date field-->
      <?php
            }

            





            else if($_GET["option"]=="order_process")
        {
      ?>
      <!-- form section start -->
      <section class="feature_part padding_top">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                
                  <div class="card-body">
                  <center><img src="img/pics/report.png" height="100" width="100"></center>
                    <center><h4 class="card-title">Order Process Details</h4></center>
    
                                    <!-- field start -->
                    <div class="form-group row">
                                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                          <div class="col-sm-3">
                                            <?php 
                                            if(isset($_GET["printstartdate"]))
                                            {
                                              echo $_GET["printstartdate"];
                                              ?> 
                                              <input type="hidden" class="form-control" id="txtstartdate" name="txtstartdate" value="<?php echo $_GET["printstartdate"]; ?>" required>
                                              <?php
                                            }
                                            else
                                            {
                                              ?> 
                                              <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" onchange="enableenddate_order_process()" required>
                                              <?php
                                            }
                                            ?>
                                              
                                          </div>
    
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label"> End Date</label>
                                          <div class="col-sm-3">
                                          <?php 
                                            if(isset($_GET["printenddate"]))
                                            {
                                              echo $_GET["printenddate"];
                                              ?> 
                                              <input type="hidden" class="form-control" id="txtenddate" name="txtenddate" required value="<?php echo $_GET["printenddate"]; ?>" readonly >
                                              <?php
                                            }
                                            else
                                            {
                                              ?> 
                                              <input type="date" class="form-control" id="txtenddate" name="txtenddate" required onchange="generate_order_process()" readonly >
                                              <?php
                                            }
                                            ?>
                                              
                                          </div>
                                      </div>
                    <!-- field end -->
                              <div class="form-group row">

                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Process</label>
                                    <div class="col-sm-3">
                              <?php 
                                      if(isset($_GET["printprocess"]))
                                      {
                                        echo $_GET["printprocess"];
                                         //for display  process in process report(print.php)
                                        ?>
                                        <input type="hidden" name="txtprocess" id="txtprocess" value="<?php echo $_GET["printprocess"]; ?>">
                                        <!--display product id and details in the product page-->
                                        <?php
                                      }
                                      else 
                                      {
                                        ?>
                                        <select class="form-control" id="txtprocess" name="txtprocess" placeholder="Process" required onchange="generate_order_process()">
                                        <!-- in here without generate_order_process() doesn't display appropriate contents-->
                                          <option value="All">All</option>
                                          <option value="Completed">Completed</option>
                                          <option value="Progress">Progress</option>
                                          </select>
                                        <?php
                                      }
                                        ?>  
                                        
                                    </div>

                              </div>
                      </div>
                    <?php 
                      if(isset($_GET["pg"]))
                      //just for load page
                      {
                        ?>
                        
                                    <!-- button start -->
                    <div class="form-group row">
                                          <div class="col-sm-12">
                        <center>
                          <input type="button" class="btn btn-primary" id="btnprint_order_process" onclick="print_order_process()" name="btnprint_order_process" value="print" disabled>
                          <!--btnprint_order_process (id) to enable end date and print_order_process() to print report without print_order_process() print button is not work-->
                          
                        </center>
                                          </div>
                                      </div>
                    <!-- button end -->
                    <?php 
                      }
                    ?>
    
                  </div>
                
              </div>
            </div>
          </div>
        </div>
          </section>
      <!-- form section end -->
      <div id="display_details_order_process"></div>
       <!--display contents for both generate report and report print-->
      <?php
            }






            
            else if($_GET["option"]=="order_product")
            {
          ?>
          <!-- form section start -->
          <section class="feature_part padding_top">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    
                      <div class="card-body">
                      <center><img src="img/pics/report.png" height="100" width="100"></center>
                        <center><h4 class="card-title">Order Product Details</h4></center>
        
                                        <!-- field start -->
                        <div class="form-group row">
                                              <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                              <div class="col-sm-3">
                                                <?php 
                                                if(isset($_GET["printstartdate"]))
                                                {
                                                  echo $_GET["printstartdate"];
                                                  ?> 
                                                  <input type="hidden" class="form-control" id="txtstartdate" name="txtstartdate" value="<?php echo $_GET["printstartdate"]; ?>" required>
                                                  <!--for send value $_GET["printstartdate"]; to URL-->
                                                  <?php
                                                }
                                                
                                                else
                                                {
                                                  ?> 
                                                  <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" onchange="enableenddate_order_product()" required>
                                                  <?php
                                                }
                                                ?>
                                                  
                                              </div>
        
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label"> End Date</label>
                                              <div class="col-sm-3">
                                              <?php 
                                                if(isset($_GET["printenddate"]))
                                                //get value from URL
                                                {
                                                  echo $_GET["printenddate"];
                                                  //print that value which is come from URL
                                                  ?> 
                                                  <input type="hidden" class="form-control" id="txtenddate" name="txtenddate" required value="<?php echo $_GET["printenddate"]; ?>" readonly >
                                                  <!--for send value $_GET["printenddate"]; to URL-->
                                                  <?php
                                                }
                                                else
                                                {
                                                  ?> 
                                                  <input type="date" class="form-control" id="txtenddate" name="txtenddate" required onchange="generate_order_product()" readonly >
                                                  <!--generate_order_product() for get contents from ajax-->
                                                  <?php
                                                }
                                                ?>
                                                  
                                              </div>
                                          </div>
                        <!-- field end -->
                                  <div class="form-group row">
    
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">product</label>
                                        <div class="col-sm-3">
                                  <?php 
                                          if(isset($_GET["printproduct"]))
                                          {
                                            echo $_GET["printproduct"];
                                            //for display  product id in product report(print.php)
                                            ?>
                                            <input type="hidden" name="txtproduct" id="txtproduct" value="<?php echo $_GET["printproduct"]; ?>">
                                             <!--display product id and details in the product page-->
                                            <?php
                                          }
                                          else 
                                          {
                                            ?>
                                            <select class="form-control" id="txtproduct" name="txtproduct" placeholder="Product" required onchange="generate_order_product()">
                                            <!-- in here without generate_order_product() doesn't display appropriate contents-->
                                              <option value="All">All</option>
                                              <?php
                                              $sqlproductname="SELECT name,product_id FROM product";
                                              $resultproductname=mysqli_query($con,$sqlproductname) or die ("Error in sqlproductname" . mysqli_error($con));
                                              while($rowproductname=mysqli_fetch_assoc($resultproductname))
                                              {
                                                echo '<option value="'.$rowproductname["product_id"].'">'.$rowproductname["name"].'</option>';
                                                //send option value to the database get the product name and  display that product name
                                              }
    
                                              ?>
                                              </select>
                                            <?php
                                          }
                                            ?>  
                                            
                                        </div>
    
                                  </div>
                          </div>
                        <?php 
                          if(isset($_GET["pg"]))
                          //just for load page
                          {
                            ?>
                            
                                        <!-- button start -->
                        <div class="form-group row">
                                              <div class="col-sm-12">
                            <center>
                              <input type="button" class="btn btn-primary" id="btnprint_order_product" onclick="print_order_product()" name="btnprint_order_product" value="print" disabled>
                              <!--btnprint_order_product (id) to enable end date and print_order_product() to print report without print_order_product() print button is not work-->
                            </center>
                                              </div>
                                          </div>
                        <!-- button end -->
                        <?php 
                          }
                        ?>
        
                      </div>
                    
                  </div>
                </div>
              </div>
            </div>
              </section>
          <!-- form section end -->
          <div id="display_details_order_product"></div>
          <!--display contents for both generate report and report print-->
          <?php
                }






                



                          else if($_GET["option"]=="purchase")
                          {
                          ?>
                          <!-- form section start -->
                          <section class="feature_part padding_top">
                          <div class="container">
                          <div class="row">
                          <div class="col-md-12">
                            <div class="card">
          
                                <div class="card-body">
                                <center><img src="img/pics/report.png" height="100" width="100"></center>
                                  <center><h4 class="card-title">purchase Details</h4></center>
          
                                                  <!-- field start -->
                                  <div class="form-group row">
                                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                                        <div class="col-sm-3">
                                                          <?php
                                                          if(isset($_GET["printstartdate"]))
                                                          {
                                                            echo $_GET["printstartdate"]; //for display start date in report page (after click print button on purchase report)
                                                            ?>
                                                            <input type="hidden" class="form-control" id="txtstartdate" name="txtstartdate" value="<?php echo $_GET["printstartdate"]; ?>" required>
                                                            <?php
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                            <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" onchange="enableenddate_purchase()" required><!--end date enable after enter start date-->
                                                            <?php
                                                          }
                                                          ?>
          
                                                        </div>
          
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label"> End Date</label>
                                                        <div class="col-sm-3">
                                                        <?php
                                                          if(isset($_GET["printenddate"]))
                                                          {
                                                            echo $_GET["printenddate"];//for display end  date in report page (after click print button on purchase report)
                                                            ?>
                                                            <input type="hidden" class="form-control" id="txtenddate" name="txtenddate" required value="<?php echo $_GET["printenddate"]; ?>" readonly>
                                                            <?php
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                            <input type="date" class="form-control" id="txtenddate" name="txtenddate" required onchange="generate_purchase()" readonly><!--enable print button after enter values of start and end dates-->
                                                            <?php
                                                          }
                                                          ?>
          
                                                        </div>
                                                    </div>
                                  <!-- field end -->
                                  <?php
                                    if(isset($_GET["pg"]))//hide print button on printing page
                                    {
                                      ?>
                                                  <!-- button start -->
                                  <div class="form-group row">
                                                        <div class="col-sm-12">
                                      <center>
                                        <input type="button" class="btn btn-primary" id="btnprint_purchase" onclick="print_purchase()" name="btnprint_purchase" value="print" disabled><!--For print-->
          
                                      </center>
                                                        </div>
                                                    </div>
                                  <!-- button end -->
                                  <?php
                                    }
                                  ?>
          
                                </div>
          
                            </div>
                          </div>
                          </div>
                          </div>
                          </section>
                          <!-- form section end -->
                          <div id="display_details_purchase"></div> <!--for End Date field-->
                          <?php
                          }










                          


                          else if($_GET["option"]=="purchase_paymode")
                          {
                          ?>
                          <!-- form section start -->
                          <section class="feature_part padding_top">
                          <div class="container">
                          <div class="row">
                          <div class="col-md-12">
                            <div class="card">
          
                                <div class="card-body">
                                <center><img src="img/pics/report.png" height="100" width="100"></center>
                                  <center><h4 class="card-title">Purchase Paymode Details</h4></center>
          
                                                  <!-- field start -->
                                  <div class="form-group row">
                                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                                        <div class="col-sm-3">
                                                          <?php
                                                          if(isset($_GET["printstartdate"]))
                                                          {
                                                            echo $_GET["printstartdate"]; //for display start date in report page (after click print button on purchase_paymode report)
                                                            ?>
                                                            <input type="hidden" class="form-control" id="txtstartdate" name="txtstartdate" value="<?php echo $_GET["printstartdate"]; ?>" required>
                                                            <?php
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                            <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" onchange="enableenddate_purchase_paymode()" required><!--end date enable after enter start date-->
                                                            <?php
                                                          }
                                                          ?>
          
                                                        </div>
          
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label"> End Date</label>
                                                        <div class="col-sm-3">
                                                        <?php
                                                          if(isset($_GET["printenddate"]))
                                                          {
                                                            echo $_GET["printenddate"];//for display end  date in report page (after click print button on purchase_paymode report)
                                                            ?>
                                                            <input type="hidden" class="form-control" id="txtenddate" name="txtenddate" required value="<?php echo $_GET["printenddate"]; ?>" readonly>
                                                            <?php
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                            <input type="date" class="form-control" id="txtenddate" name="txtenddate" required onchange="generate_purchase_paymode()" readonly><!--enable print button after enter values of start and end dates-->
                                                            <?php
                                                          }
                                                          ?>
          
                                                        </div>
                                                        
                                       
                                  
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Paymode</label>
                                    <div class="col-sm-3">
                              <?php 
                                      if(isset($_GET["printpaymode"]))
                                      {
                                        echo $_GET["printpaymode"];
                    
                                        ?>
                                        <input type="hidden" name="txtpurchasepaymode" id="txtpurchasepaymode" value="<?php echo $_GET["printpaymode"]; ?>">
                                  
                                        <?php
                                      }
                                          else 
                                          {
                                            ?>                                                                        
                                        <select class="form-control" id="txtpurchasepaymode" name="txtpurchasepaymode" required onchange="generate_purchase_paymode()">
                                          <option value="All">All</option>
                                          <option value="Cash">Cash</option>
                                          <option value="Bank">Bank</option>
                                          </select>
                                                        
                                                    </div>
                                                </div>
                                                <?php 
                                      }
                                      ?>
                              <!-- field end -->
                              <?php
                                if(isset($_GET["pg"]))//hide print button on printing page
                                {
                                  ?>
                                              <!-- button start -->
                              <div class="form-group row">
                              <div class="col-sm-12">
                                  <center>
                                    <input type="button" class="btn btn-primary" id="btnprint_purchase_paymode" onclick="print_purchase_paymode()" name="btnprint_purchase_paymode" value="print" disabled><!--For print-->
      
                                  </center>
                                                    </div>
                                                </div>
                              <!-- button end -->
                              <?php
                                }
                              ?>
      
                            </div>
      
                        </div>
                      </div>
                      </div>
                      </div>
                      </section>
                      <!-- form section end -->
                      <div id="display_details_purchase_paymode"></div> <!--for End Date field-->
                      <?php
                      }





                      else if($_GET["option"]=="staffjoin")
                      {
                      ?>
                      <!-- form section start -->
                      <section class="feature_part padding_top">
                      <div class="container">
                      <div class="row">
                      <div class="col-md-12">
                        <div class="card">
      
                            <div class="card-body">
                            <center><img src="img/pics/report.png" height="100" width="100"></center>
                              <center><h4 class="card-title">Staff's Join Date Details Report</h4></center>
      
                                              <!-- field start -->
                              <div class="form-group row">
                                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                                                    <div class="col-sm-3">
                                                      <?php
                                                      if(isset($_GET["printstartdate"]))
                                                      {
                                                        echo $_GET["printstartdate"]; //for display start date in report page (after click print button on staffjoin report)
                                                        ?>
                                                        <input type="hidden" class="form-control" id="txtstartdate" name="txtstartdate" value="<?php echo $_GET["printstartdate"]; ?>" required>
                                                        <?php
                                                      }
                                                      else
                                                      {
                                                        ?>
                                                        <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" onchange="enableenddate_staffjoin()" required><!--end date enable after enter start date-->
                                                        <?php
                                                      }
                                                      ?>
      
                                                    </div>
      
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label"> End Date</label>
                                                    <div class="col-sm-3">
                                                    <?php
                                                      if(isset($_GET["printenddate"]))
                                                      {
                                                        echo $_GET["printenddate"];//for display end  date in report page (after click print button on staffjoin report)
                                                        ?>
                                                        <input type="hidden" class="form-control" id="txtenddate" name="txtenddate" required value="<?php echo $_GET["printenddate"]; ?>" readonly>
                                                        <?php
                                                      }
                                                      else
                                                      {
                                                        ?>
                                                        <input type="date" class="form-control" id="txtenddate" name="txtenddate" required onchange="generate_staffjoin()" readonly><!--enable print button after enter values of start and end dates-->
                                                        <?php
                                                      }
                                                      ?>
      
                                                    </div> 
                                                                         
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Gender</label>
                                <div class="col-sm-3">
                                  
                          <?php 
                                  if(isset($_GET["printstaffjoin"]))
                                  {
                                    echo $_GET["printstaffjoin"];
                
                                    ?>
                                    <input type="hidden" name="txtstaffjoin" id="txtstaffjoin" value="<?php echo $_GET["printstaffjoin"]; ?>">
                              
                                    <?php
                                  }
                                      else 
                                      {
                                        ?>                                                                        
                                    <select class="form-control" id="txtstaffjoin" name="txtstaffjoin" required onchange="generate_staffjoin()">
                                      <option value="All">All</option>
                                      <option value="Admin">Admin</option>
                                      <option value="Clerk">Clerk</option>
                                      <option value="Worker">Worker</option>
                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                  }
                                  ?>
                          <!-- field end -->
                          <?php
                            if(isset($_GET["pg"]))//hide print button on printing page
                            {
                              ?>
                                          <!-- button start -->
                          <div class="form-group row">
                          <div class="col-sm-12">
                              <center>
                                <input type="button" class="btn btn-primary" id="btnprint_staffjoin" onclick="print_staffjoin()" name="btnprint_staffjoin" value="print" disabled><!--For print-->
  
                              </center>
                                                </div>
                                            </div>
                          <!-- button end -->
                          <?php
                            }
                          ?>
  
                        </div>
  
                    </div>
                  </div>
                  </div>
                  </div>
                  </section>
                  <!-- form section end -->
                  <div id="display_details_staffjoin"></div> <!--for End Date field-->
                  <?php
                  }

                      



                  else if($_GET["option"]=="customer_age")
                    {
              ?>
              <!-- form section start -->
              <section class="feature_part padding_top">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
            
                          <div class="card-body">
                          <center><img src="img/pics/report.png" height="100" width="100"></center>
                            <center><h4 class="card-title">customer DOB Details</h4></center>
            
                                            <!-- field start -->
                            <div class="form-group row">
                                                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Min DOB</label>
                                                  <div class="col-sm-3">
                                                    <?php
                                                    if(isset($_GET["printstartdate"]))
                                                    {
                                                      echo $_GET["printstartdate"]; //for display start date in report page (after click print button on customer_age report)
                                                      ?>
                                                      <input type="hidden" class="form-control" id="txtstartdate" name="txtstartdate" value="<?php echo $_GET["printstartdate"]; ?>" required>
                                                      <?php
                                                    }
                                                    else
                                                    {
                                                      ?>
                                                      <input type="date" class="form-control" id="txtstartdate" name="txtstartdate" onchange="enableenddate_customer_age()" required><!--end date enable after enter start date-->
                                                      <?php
                                                    }
                                                    ?>
            
                                                  </div>
            
                              <label for="fname" class="col-sm-3 text-right control-label col-form-label"> Max DOB</label>
                                                  <div class="col-sm-3">
                                                  <?php
                                                    if(isset($_GET["printenddate"]))
                                                    {
                                                      echo $_GET["printenddate"];//for display end  date in report page (after click print button on customer_age report)
                                                      ?>
                                                      <input type="hidden" class="form-control" id="txtenddate" name="txtenddate" required value="<?php echo $_GET["printenddate"]; ?>" readonly>
                                                      <?php
                                                    }
                                                    else
                                                    {
                                                      ?>
                                                      <input type="date" class="form-control" id="txtenddate" name="txtenddate" required onchange="generate_customer_age()" readonly><!--enable print button after enter values of start and end dates-->
                                                      <?php
                                                    }
                                                    ?>
            
                                                  </div>
                                                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Gender</label>
                                                  <div class="col-sm-3">
                                                    
                                                    <?php
                                                    if(isset($_GET["printgender"]))
                                                    {
                                                      echo $_GET["printgender"]; //for display start date in report page (after click print button on customer_age report)
                                                      ?>
                                                      <input type="hidden" class="form-control" id="txtgender" name="txtgender" value="<?php echo $_GET["printgender"]; ?>" required>
                                                      <?php
                                                    }
                                                    else
                                                    {
                                                      ?>
                                          <select class="form-control" id="txtgender" name="txtgender" placeholder="" required onchange="generate_customer_age()">
                                        <!-- in here without generate_order_process() doesn't display appropriate contents-->
                                          <option value="All">All</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                          </select>
                                                      <?php
                                                    }
                                                    ?>
            
                                                  </div>
                                              </div>
                            <!-- field end -->
                            <?php
                              if(isset($_GET["pg"]))//hide print button on printing page
                              {
                                ?>
                                            <!-- button start -->
                            <div class="form-group row">
                                                  <div class="col-sm-12">
                                <center>
                                  <input type="button" class="btn btn-primary" id="btnprint_customer_age" onclick="print_customer_age()" name="btnprint_customer_age" value="print" disabled><!--For print-->
            
                                </center>
                                                  </div>
                                              </div>
                            <!-- button end -->
                            <?php
                              }
                            ?>
            
                          </div>
            
                      </div>
                    </div>
                  </div>
                </div>
                  </section>
              <!-- form section end -->
              <div id="display_details_customer_age"></div> <!--for End Date field-->
              <?php
                    }

            
    }
    ?>
</body>