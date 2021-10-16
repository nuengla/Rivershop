<?php
	session_start();
	include "condb.php";
	$p_id = $_GET['p_id'];
	$act = $_GET['act'];
	
	
	
	if($act=='add' && !empty($p_id))
	{
		if(!isset($_SESSION['cart']))
		{
			 
			$_SESSION['cart']=array();
		}else{
		 
		}
		if(isset($_SESSION['cart'][$p_id]))
		{
			$_SESSION['cart'][$p_id]++;
		}
		else
		{
			$_SESSION['cart'][$p_id]=1;
		}
	}

	if($act=='remove' && !empty($p_id))
	{
		
		unset($_SESSION['cart'][$p_id]);
	}

	if($act=='update')
	{
		
		$amount_array = $_POST['amount'];
		if(empty($amount_array)){
			echo "<script>";
            echo "alert(\"ไม่มีสินค้าในตะกร้า\");";
            echo "window.location='cart.php'"; 
            echo "</script>";
		}
		foreach($amount_array as $p_id=>$amount)
		{
			
			$_SESSION['cart'][$p_id]=$amount;
		}
	}
	?>
<?php
	include ("condb.php");
	$id = $_SESSION['mem_id'];
	$name = $_SESSION['mem_name'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="all" href="style.css" />
	<link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="img_web/favicon.png" />
    <title>RIVER-SHOP</title>
</head>
<style>
.conten{
    height: 50vh;
}


</style>
<body>

    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php
    if(empty($id)){ ?>

        <div class="navbar">
            <div class="navmenu">
                <ul>
                    
                <li><?php
							if($id==""){			

					echo "<a href='index.php'>"."หน้าแรก"."</a>";
							}else{
								echo "<a href='index_mem.php'>"."กลับสู่หน้าหลัก"."</a>";
							} ?>
					</li>
					
                    <li><a href="cart.php">ตะกร้าสินค้า(<?php 
                     session_start();
                     $cart = $_SESSION['cart'];
					 if(empty($cart)){
						$cart = 0;
						echo $cart;
					}else{
						echo count($cart);
					}
                    
                    ?>)</a></li>
                    <li><a href="#">ช่วยเหลือ</a>
                        <ul>
                            <li><a href="tb_size.php">-ตารางวัดไซส์</a></li>
                            <li><a href="how.php?page=shop">-วิธีสั่งสินค้า</a></li>
                                <li><a href="how.php?page=pay">-วิธีชำระเงิน</a></li>
                                <li><a href="how.php?page=regis">-วิธีสมัครสมาชิก</a></li>
                           
                        </ul>
                    </li>    
                    <li><a href="#">เกี่ยวกับเรา</a>
                            <ul>
                                <li><a href="about.php?page=me">-ติดต่อเรา</a></li>
                                <li><a href="about.php?page=map">-แผนที่ร้าน</a></li>
                            </ul>
                        </li>
                </ul>
            </div>
           <div class="navuser">
                <ul>
                    <li><a href="register.php">สมัครสมาชิก</a></li>
                    <li><a href="login.php">เข้าสู่ระบบ</a></li>   
                </ul>
            </div>
            
        </div>
    <?php }else{ $sql1 = "SELECT * FROM member WHERE mem_id=$id ";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($result1);
    ?>
        
		<?php include "navbarmemin.php"?>
    <?php } ?>
	<div class="conten"><br>
	<h1>ตะกร้าสินค้า</h1><br>
	<div class="pro_box" align="center">
		<form id="frmcart" name="frmcart" method="post" action="?act=update">
  			<table width="840" align="center" class="square">
    			<tr>
      				<td colspan="8" bgcolor="#CCCCCC" align="center">
      			<b>ตะกร้าสินค้า</span></td>
    			</tr>
    			<tr>
      				<td bgcolor="#EAEAEA" align="center" >สินค้า</td>
					  <td width="150" align="center" bgcolor="#EAEAEA">สินค้าคงเหลือ(ชิ้น)</td>
					<td align="center" width="100" bgcolor="#EAEAEA">ขนาด</td>
					<td align="center" width="100" bgcolor="#EAEAEA">ประเภท</td>
      				<td align="center" width="170" bgcolor="#EAEAEA">ราคา(บาท)</td>
      				<td align="center" bgcolor="#EAEAEA">จำนวน(ชิ้น)</td>
      				<td align="center" bgcolor="#EAEAEA">รวม(บาท)</td>
      				<td align="center" bgcolor="#EAEAEA">ลบ</td>
    			</tr>
		<?php
			$total=0;
			
		if(!empty($_SESSION['cart'])){
			include ("condb.php");
			foreach($_SESSION['cart'] as $p_id=>$qty){
				$sql = "SELECT * FROM product,pro_size,pro_type WHERE p_id=$p_id AND product.ps_id=pro_size.ps_id AND product.pt_id=pro_type.pt_id";
				$query = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($query);
				$rowprice = $row["p_price"];
				$rowprice_promo = $row["p_price_promotion"];
				if($rowprice_promo >= $rowprice || $rowprice_promo == 0){
					$price = $rowprice;
				}else{
					$price = $rowprice_promo;
				}
					$sum = $price * $qty;
					$total += $sum;
					echo "<tr>";
					echo "<td>";
					echo "<tr>";
					echo "<td width='334'>" . $row["p_name"] . "</td>";
					echo "<td align='center'>" . $row["p_qty"] . "</td>";
					echo "<td align='center'>" . $row["ps_name"] . "</td>";
					echo "<td align='center'>" . $row["pt_name"] . "</td>";
					echo "<td width='46' align='right'>" .number_format(($price),2) . "</td>";
					echo "<td width='57' align='right'>";  
					echo "<input type='number' style='width: 50px;text-align: right;' name='amount[$p_id]' value='$qty' max= '".$row["p_qty"]."' min= '1' step= '1' size='2'/></td>";
					echo "<td width='93' align='right'>".number_format(($sum),2)."</td>";
					
					echo "<td width='46' align='center'><a href='cart.php?p_id=$p_id&act=remove'> <input type='button' class='btn_red' value='ลบ'</a></td>";
					
					echo "</tr>";
			}
				echo "<tr>";
  				echo "<td colspan='6' bgcolor='#CEE7FF' align='center'><b>ราคารวม</b></td>";
  				echo "<td align='right' bgcolor='#CEE7FF'>"."<b>".number_format(($total),2)."</b>"."</td>";
  				echo "<td align='left' bgcolor='#CEE7FF'>บาท</td>";
				echo "</tr>";
			}
		?>
<tr>

<td colspan="7" align="right" style="color: rgb(255, 0, 0);font-size:20px;">
	
			***กดปุ่มคำนวณราคาก่อนกดปุ่มยืนยัน
    <input type="submit" name="button"  class="btn_sys" id="button" value="คำนวณราคา" />
	
    <input type="button" name="Submit2" class="btn_green" value="ยืนยัน" onClick="window.location='confirm.php';" />
</td>
</tr>
</table>
<br>
</form>
</div>
</div>
 
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
	
	
	
</body>
</html>