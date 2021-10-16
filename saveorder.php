
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Confirm</title>
</head>
<body>

<?php
 include ("condb.php"); 
$day = date('Y-m-d');
$ckod = "SELECT * FROM count_order ";
$resultckod = mysqli_query($con, $ckod);
	$rowckod = mysqli_fetch_array($resultckod);
	$dayck = $rowckod["datesave"];
	if($dayck<$day){
		$out = "TRUNCATE TABLE count_order ";
$resultout = mysqli_query($con, $out);
	

	}





session_start();



	$mem_id = $_SESSION["mem_id"];
	$total_qty = $_REQUEST["total_qty"];
	$total = $_REQUEST["total"];
	$dttm = date('d-m-Y H:i:s');
	$o_parcelnum = "-";
	$s_id = "1";
	$t_id = $_REQUEST["t_id"];
	$addnew = $_REQUEST["addnew"];
	

	
	

	if(!empty($addnew)){
		$add_address = $_REQUEST["add_address"];
	$province_id = $_REQUEST['province'];
    $amphur_id = $_REQUEST['amphur'];
    $district_id = $_REQUEST['district'];
	$zipcode = $_REQUEST['postcode'];
	
    $sql1 = "SELECT * FROM amphur WHERE amphur_id=$amphur_id";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $amphur = $row1["amphur_name"];

    $sql2 = "SELECT * FROM province WHERE province_id=$province_id";
    $result12 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_array($result12);
    $province = $row2["province_name"];

    $sql3 = "SELECT * FROM district WHERE district_id=$district_id";
    $result13 = mysqli_query($con, $sql3);
    $row3 = mysqli_fetch_array($result13);
	$district = $row3["district_name"];

	$sqlinor	= "INSERT INTO count_order (count_order_id, datesave) VALUES (NULL,SYSDATE())";
	$queryinor	= mysqli_query($con, $sqlinor);
	$sqlor = "SELECT * FROM count_order ORDER BY count_order_id DESC LIMIT 1";
	$queryor	= mysqli_query($con, $sqlor);
	$rowor = mysqli_fetch_array($queryor);
	$dttminor = $rowor["datesave"];
	$countorder = $rowor["count_order_id"];
	$dttmor = date('Ymd', strtotime($dttminor));
	$o_idnew = "$dttmor"."$countorder";


		$sql1	= "INSERT INTO orders (o_id, mem_id, o_date, s_id, t_id, o_parcelnum ,addnew) VALUES ('$o_idnew', '$mem_id',SYSDATE(),'$s_id','$t_id','$o_parcelnum' ,'$addnew')";
		$query1	= mysqli_query($con, $sql1);
		
	$sql41	= "INSERT INTO address_ VALUES (null, '$mem_id', '$o_idnew', '$add_address', '$province', '$amphur', '$district', '$zipcode')";
	$query41	= mysqli_query($con, $sql41);
	



	}else {
		include ("condb.php");
		$addnew = "0";
		$sqlinor	= "INSERT INTO count_order (count_order_id, datesave) VALUES (NULL,SYSDATE())";
	$queryinor	= mysqli_query($con, $sqlinor);
	$sqlor = "SELECT * FROM count_order ORDER BY count_order_id DESC LIMIT 1";
	$queryor	= mysqli_query($con, $sqlor);
	$rowor = mysqli_fetch_array($queryor);
	$dttminor = $rowor["datesave"];
	$countorder = $rowor["count_order_id"];
	$dttmor = date('Ymd', strtotime($dttminor));
	$o_idnew = "$dttmor"."$countorder";


		$sql1	= "INSERT INTO orders (o_id, mem_id, o_date, s_id, t_id, o_parcelnum ,addnew) VALUES ('$o_idnew', '$mem_id',SYSDATE(),'$s_id','$t_id','$o_parcelnum' ,'$addnew')";
		$query1	= mysqli_query($con, $sql1);


	}


		
		
	
	

	include ("condb.php");
			foreach($_SESSION['cart'] as $p_id=>$qty){
				$sql = "select * from product where p_id=$p_id";
				$query = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($query);
				$rowprice = $row["p_price"];
				$rowprice_promo = $row["p_price_promotion"];
				if($rowprice_promo > $rowprice||$rowprice_promo==0||$rowprice_promo == $rowprice){
					$price = $rowprice;
				}else{
					$price = $rowprice_promo;
				}
					$sum = $price * $qty;
					$total += $sum;
		
		$sql4	= "INSERT INTO orderdt VALUES(null, '$o_idnew', '$p_id', '$qty', '$sum')";
		$query4	= mysqli_query($con, $sql4);

		$sql5	= "INSERT INTO payment VALUES(null, '$o_idnew',
		 '$mem_id','','','','','','','$s_id')";
		$query6	= mysqli_query($con, $sql5);

		$sqlUpdatePd="UPDATE product SET p_qty=p_qty-".$qty." WHERE p_id=".$p_id."";
		$query5	= mysqli_query($con, $sqlUpdatePd);
	}
	
	if($query1&&$query4&&$query5&&$query6){
	
		$msg = "สั่งซื้อเรียบร้อยแล้ว (กรุณาแจ้งชำระค่าสินค้าภายใน 24 ชั่วโมง)";
		foreach($_SESSION['cart'] as $p_id)
		{	

			unset($_SESSION['cart']);
		}
	}
	else{
	  
		$msg = "บันทึกข้อมูลไม่สำเร็จ กรุณาติดต่อเจ้าหน้าที่ครับ ";	
	}
?>
<script type="text/javascript">
	alert("<?php echo $msg;?>");
	window.location ='index_mem.php';
</script>

 




</body>
</html>