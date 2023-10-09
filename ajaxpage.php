<?php
if(!isset($_SESSION))
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
include("config.php");
if(isset($_GET["frompage"]))
{
	if($_GET["frompage"]=="dob")
	{
		$selnic = $_GET["dobcal"];
		if(strlen($selnic)==10)
		{
			$bdayyear=substr($selnic, 0,2);
			$bdayyear=$bdayyear+1900;
			$bdaynum=substr($selnic, 2,3);
		}
		else if(strlen($selnic)==12)
		{
			$bdayyear=substr($selnic, 0,4);
			$bdaynum=substr($selnic, 4,3);
		}

		$bdaynum1=0;
		if($bdaynum>500)
		{
			$bdaynum1=$bdaynum-500;

		}
		else
		{
			$bdaynum1=$bdaynum;
		}

		$bdaydate;

		$month=array(31,29,31,30,31,30,31,31,30,31,30,31);
		$day_cal=0;//add total days of months
		$bdaymonth=0;
		$bdayday=0;
		for($x=0;$x<count($month);$x++)
		{
			$day_cal=$day_cal+$month[$x];
			if($day_cal>=$bdaynum1)
			{
				$bdayday=$bdaynum1-(($day_cal)-($month[$x]));
				$bdaymonth=++$x;
				break;
			}
		}
		$bdaydate=$bdayyear."-".$bdaymonth."-".$bdayday;
		$bdaydate=date("Y-m-d", strtotime($bdaydate));
		echo $bdaydate;
	}
	else if($_GET["frompage"]=="NICexist")
	{
		$get_ajaxnic = $_GET["ajaxnic"];

		$sqlcheck="SELECT user_name FROM login WHERE user_name='$get_ajaxnic'";
		$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" . mysqli_error($con));
		$n=mysqli_num_rows($resultcheck);
		if($n==1)
		{
			echo "YES";
		}
		else
		{
			echo "NO";
		}
	}
	else if($_GET["frompage"]=="staff_mobile")
	{
		$get_ajaxmobile = $_GET["ajaxmobile"];
		$get_ajaxoption = $_GET["ajaxoption"];
		$get_ajaxstaffid = $_GET["ajaxstaffid"];

		if($get_ajaxoption=="add")
		{
			$sqlcheck="SELECT staff_id FROM staff WHERE mobile='$get_ajaxmobile'";
			$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" . mysqli_error($con));
			$n=mysqli_num_rows($resultcheck);

			if($n>0)
			{
				echo "YES";
			}
			else
			{
				echo "NO";
			}
		}
		else
		{
			$sqlcheck="SELECT staff_id FROM staff WHERE mobile='$get_ajaxmobile' AND staff_id!='$get_ajaxstaffid'";
			$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" . mysqli_error($con));
			$n=mysqli_num_rows($resultcheck);

			if($n==0)
			{
				echo "NO";
			}
			else
			{
				echo "YES";
			}
		}
	}
	else if($_GET["frompage"]=="customer_mobile")
	{
		$get_ajaxmobile = $_GET["ajaxmobile"];
		$get_ajaxoption = $_GET["ajaxoption"];
		$get_ajaxcustomerid = $_GET["ajaxcustomerid"];

		if($get_ajaxoption=="add")
		{
			$sqlcheck="SELECT customer_id FROM customer WHERE mobile='$get_ajaxmobile'";
			$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" . mysqli_error($con));
			$n=mysqli_num_rows($resultcheck);

			if($n>0)
			{
				echo "YES";
			}
			else
			{
				echo "NO";
			}
		}
		else
		{
			$sqlcheck="SELECT customer_id FROM customer WHERE mobile='$get_ajaxmobile' AND customer_id!='$get_ajaxcustomerid'";
			$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" . mysqli_error($con));
			$n=mysqli_num_rows($resultcheck);

			if($n==0)
			{
				echo "NO";
			}
			else
			{
				echo "YES";
			}
		}
	}
	else if($_GET["frompage"]=="supplier_mobile")
	{
		$get_ajaxmobile = $_GET["ajaxmobile"];
		$get_ajaxoption = $_GET["ajaxoption"];
		$get_ajaxsupplierid = $_GET["ajaxsupplierid"];

		if($get_ajaxoption=="add")
		{
			$sqlcheck="SELECT supplier_id FROM supplier WHERE mobile='$get_ajaxmobile'";
			$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" . mysqli_error($con));
			$n=mysqli_num_rows($resultcheck);

			if($n>0)
			{
				echo "YES";
			}
			else
			{
				echo "NO";
			}
		}
		else
		{
			$sqlcheck="SELECT supplier_id FROM supplier WHERE mobile='$get_ajaxmobile' AND supplier_id!='$get_ajaxsupplierid'";
			$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" . mysqli_error($con));
			$n=mysqli_num_rows($resultcheck);

			if($n==0)
			{
				echo "NO";
			}
			else
			{
				echo "YES";
			}
		}
	}
	else if($_GET["frompage"]=="product_category")
	{//<------- same functions for purchace product , product and  order product
		$get_ajaxcategoryid =$_GET["ajaxcategoryid"];
		echo '<option value="select_option">Select The Sub Category ID</option>';

		$sqlload="SELECT subcategory_id,subcategory_name FROM subcategory WHERE category_id='$get_ajaxcategoryid'";
		$resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
		while( $rowload=mysqli_fetch_assoc($resultload))
		{
			echo '<option value="'.$rowload["subcategory_id"].'">'.$rowload["subcategory_name"].'</option>';
		}
	}

	else if($_GET["frompage"]=="purchase_product_subcategory")
	{//<-------come from purchace product
		$get_ajaxsubcategoryid =$_GET["ajaxsubcategoryid"];
		echo '<option value="select_option">Select product ID</option>';

		$sqlload="SELECT product_id,name FROM product WHERE subcategory_id='$get_ajaxsubcategoryid'";
		$resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
		while( $rowload=mysqli_fetch_assoc($resultload))
		{
			  if (isset($_SESSION["session_purchaseid"]))
				{
					$sqlcheck="SELECT product_id FROM purchase_product WHERE product_id='$rowload[product_id]' AND purchase_id ='$_SESSION[session_purchaseid]'";
					$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" .mysqli_error($con));
					$n=mysqli_num_rows($resultcheck);
					if($n==0)
					{
						echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
					}

				}
				else
				{
						echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
				}

		}
	}

	else if($_GET["frompage"]=="order_product_subcategory")
	{//<-------come from order product
		$get_ajaxsubcategoryid =$_GET["ajaxsubcategoryid"];
		$get_ajaxorderid=$_GET["ajaxorderid"];
		echo '<option value="select_option">Select product ID</option>';

		$sqlload="SELECT product_id,name FROM product WHERE subcategory_id='$get_ajaxsubcategoryid'";
		$resultload=mysqli_query($con,$sqlload) or die ("Error in sqlload" . mysqli_error($con));
		while( $rowload=mysqli_fetch_assoc($resultload))
		{
			$sqlcheckprice="SELECT product_id  FROM product_price WHERE product_id='$rowload[product_id]' AND end_date IS NULL";
			$resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
			$m=mysqli_num_rows($resultcheckprice);
			if($m>0)
			{
				  if (isset($_SESSION["session_orderid"]))
					{
						$sqlcheck="SELECT product_id FROM order_product WHERE product_id='$rowload[product_id]' AND order_id ='$_SESSION[session_orderid]'";
						$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" .mysqli_error($con));
						$n=mysqli_num_rows($resultcheck);
						if($n==0)
						{
							echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
						}

					}
					else
					{
						$sqlcheck="SELECT product_id FROM order_product WHERE product_id='$rowload[product_id]' AND order_id ='$get_ajaxorderid'";
						$resultcheck=mysqli_query($con,$sqlcheck) or die ("Error in sqlcheck" .mysqli_error($con));
						$n=mysqli_num_rows($resultcheck);
						if($n==0)
						{
							echo '<option value="'.$rowload["product_id"].'">'.$rowload["name"].'</option>';
						}
					}
				}

		}
	}
	else if($_GET["frompage"]=="order_product_product")
	{//<-------come from order product
		$get_ajaxproductid =$_GET["ajaxproductid"];

		$sqlcheckprice="SELECT price,offer  FROM product_price WHERE product_id='$get_ajaxproductid' AND end_date IS NULL";
		$resultcheckprice=mysqli_query($con,$sqlcheckprice) or die ("Error in sqlcheckprice" . mysqli_error($con));
		$rowcheckprice=mysqli_fetch_assoc($resultcheckprice);

		if($rowcheckprice["offer"]>0)
		{
			$unitprice=$rowcheckprice["price"]-(($rowcheckprice["price"]*$rowcheckprice["offer"])/100);
		}
		else
		{
			$unitprice=$rowcheckprice["price"];
		}
		 $unitprice=number_format((float)$unitprice, 2, '.', '');
		echo $unitprice;
	}



	else if($_GET["frompage"]=="staff_designation")
	{
		$get_ajaxdesignation =$_GET["ajaxdesignation"];
		$_SESSION["staffdesignation"]=$get_ajaxdesignation;//set session
	}
	
	else if($_GET["frompage"]=="paymode")
	{
		$get_ajaxpaymode =$_GET["ajaxpaymode"];
		$_SESSION["pay_mode"]=$get_ajaxpaymode;//set session
	}

	else if($_GET["frompage"]=="discount")
	{
		$get_ajaxdiscount =$_GET["ajaxdiscount"];
		$_SESSION["discount"]=$get_ajaxdiscount;//set session
	}
	
}
?>
