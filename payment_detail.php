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
<body>
<?php
    session_start();
    include ("condb.php");
    $mem_id = $_SESSION['mem_id'];
    $mem_name = $_SESSION['mem_name'];
    $o_id = $_GET['o_id'];
  

?>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <div class="navbar">
            <div class="navmenu">
                <ul>
                    <li><a href="payment.php">ย้อนกลับ</a></li>
                </ul>
            </div>
           
            
        </div>
    <div class="conten"><br>
        <h1>รายละเอียดการสั่งสินค้า</h1>
		<br>
		<table width="600" border="1" align="center" class="square">
           <tr> 
               <td colspan="5" bgcolor="#00fffc" align="center"> เลขที่การสั่งซื้อ <?php echo $o_id;?> </td>
            </tr>
           <tr>
      <td bgcolor="#00fffc" width="200"> ชื่อสินค้า </td>
      <td align="center" bgcolor="#00fffc" width="100"> ประเภท </td>
      <td align="center" bgcolor="#00fffc"width="100"> ขนาด </td>
	  <td align="center" bgcolor="#00fffc"width="100"> จำนวน(ชิ้น) </td>
	  <td align="center" bgcolor="#00fffc"width="150"> ราคา(บาท) </td>

 
    </tr>
		<?php 
				$sql = "SELECT * FROM orderdt,product,pro_size,pro_type WHERE o_id=$o_id AND orderdt.p_id=product.p_id 
                AND product.ps_id=pro_size.ps_id AND product.pt_id=pro_type.pt_id";
                $result = mysqli_query($con, $sql);
                $sql1 = "SELECT * FROM orders,transport WHERE o_id=$o_id AND orders.t_id=transport.t_id";
                $result1 = mysqli_query($con, $sql1);
                $row1 = mysqli_fetch_array($result1);
                while ($row = mysqli_fetch_array($result)){
                    $sum = $row['od_totalprice'];
                    $total1 += $sum;
                    $transport = $row1['t_price'];
                    $total =$total1 + $transport;
				echo "<tr>";
				echo "<td align='left'>" .$row["p_name"]. "</td>";
				echo "<td>" .$row["pt_name"]. "</td>";
                echo "<td>" .$row["ps_name"]. "</td>";
                echo "<td align='right'>" .$row["od_prounit"]. "</td>";
                echo "<td style='text-align:right'>" .number_format($row["od_totalprice"],2). "</td>";
                echo "</tr>";
                
                }
                echo "<tr>";
                echo "<td colspan='4'style='text-align:right'>ค่าจัดส่ง</td>";
                echo "<td style='text-align:right'>".number_format(($transport),2)."</td>";
                echo "</tr>";
                echo "<tr style='text-align:right'>";
                echo "<td colspan='4'>ราคารวม</td>";
                echo "<td>".number_format(($total),2)."</td>";
                echo "</tr>";
              
                ?>
    </table><br>
    <h1>แจ้งชำระเงิน</h1>
    <form action="check_payment.php" method="POST" enctype="multipart/form-data"> 
    
        <table width="600" border="1" align="center"  >
        <?php 
				$sql1 = "SELECT * FROM payment,member,bank WHERE o_id=$o_id AND payment.mem_id=member.mem_id 
                ";
                $result1 = mysqli_query($con, $sql1);
                $row1 = mysqli_fetch_array($result1);
            echo "<tr>";
            echo "<td width='210' align='left'>"."เลขที่การสั่งซื้อ"."</td>";
            echo "<td class='tbpay'>".$row1["o_id"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."ชื่อลูกค้า"."</td>";
            echo "<td class='tbpay'>"."คุณ ".$row1["mem_name"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."จำนวนเงินที่ต้องชำระ"."</td>";
            echo "<td class='tbpay'>".number_format($total)." บาท"."<input type='hidden' name='pay_total' value='".$total."'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."ชื่อบัญชีผู้โอนเงิน"."</td>";
            echo "<td class='tbpay'><input type='text' name='pay_name'required ><input type='hidden' name='o_id' value='".$row1["o_id"]."'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."เลือกช่องทางการขำระ"."</td>";
            echo "<td class='tbpay' width='250' style=text-align:center;>";
            $sql2="SELECT * FROM bank Order By b_id ASC";
            $rstTemp=mysqli_query($con,$sql2);
            while($arr_2=mysqli_fetch_array($rstTemp)){
            echo "<input type='radio' name='b_id' value='".$arr_2["b_id"]."'>"."<br>"."<img style=width:65px;height:65px; src='imgbank/" . $arr_2["b_logo"] ."' >"."<br>"
            ."ธนาคาร : ".$arr_2["b_name"]."<br>"."สาขา : ".$arr_2["bn_name"]."<br>"."ชื่อบัญชี : ".$arr_2["b_owner"]."<br>"."เลขที่บัญชี : ".$arr_2["b_number"]."<hr>";}
            echo "</td>";
            echo "</tr>";

?>
            <tr>
            <td align="left">วันที่โอนเงิน</td>
            <td class="tbpay"><input type="date" name="pay_date" value="<?php echo date("Y/m/d");?>" required ></td>
            </tr>

<?php
            echo "<tr>";
            echo "<td align='left'>"."เวลาที่โอนเงิน"."</td>";
            echo "<td class='tbpay'><input type='time' name='pay_time'required></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."รูปภาพยืนยันการโอนเงิน"."</td>";
            echo "<td class='tbpay'><input type='file' name='pay_img'required></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."หมายเลขอ้างอิงการโอนเงิน"."</td>";
            echo "<td class='tbpay'><input type='text' name='pay_numref'required></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class='square' colspan='2'><input type='submit' name='submit' class='btn_green' value='บันทึกการชำระเงิน'></td>";
            echo "</tr>";
                
    ?>

    </table>     
    </form>
    <br>
     
    </div>
 
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>