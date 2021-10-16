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
                    <li><a href="admin_order.php?id=2">ย้อนกลับ</a></li>
                </ul>
            </div>
           
            
        </div>
    <div class="conten"><br>
        
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
				
                }
                ?>
    
    <h1>รายละเอียดการแจ้งชำระเงิน</h1>
   
    
        <table  border="1" align="center" class="square" >
        <?php 
				$sql1 = "SELECT * FROM payment,member,bank WHERE o_id=$o_id AND payment.mem_id=member.mem_id AND payment.b_id=bank.b_id";
                $result1 = mysqli_query($con, $sql1);
                $row1 = mysqli_fetch_array($result1);
            echo "<tr>";
            echo "<td width='210' align='left'>"." เลขที่การสั่งซื้อ"."</td>";
            echo "<td  align='left'width='250' >".$row1["o_id"]."</td>";
            echo "<td  align='center' rowspan='8'><img src='img_pay/".$row1["pay_img"]."' ></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."ชื่อลูกค้า"."</td>";
            echo "<td  align='left'>"."คุณ ".$row1["mem_name"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."จำนวนเงินที่ต้องชำระ"."</td>";
            echo "<td  align='left'>".number_format($total)." บาท"."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."ชื่อบัญชีผู้โอนเงิน"."</td>";
            echo "<td c align='left'>".$row1["pay_name"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."เลือกธนาคาร"."</td>";
            echo "<td c align='left'>"."ธนาคาร : ".$row1["b_name"]."<br>"."เลขบัญชี : ".$row1["b_number"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."วันที่โอนเงิน"."</td>";
            echo "<td  align='left'>".$row1["pay_date"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."เวลาที่โอนเงิน"."</td>";
            echo "<td  align='left'>".$row1["pay_time"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."หมายเลขอ้างอิงการโอนเงิน"."</td>";
            echo "<td  align='left'>".$row1["pay_numref"]."</td>";
            echo "</tr>";
                
    ?>

    </table>     
    <a href="query.php?o_id=<?php echo $o_id;?>&act=checkorder"><input type="button" class="btn_main" value="ยืนยันการชำระเงิน"></a><br>

    <br>
     
    </div>
 
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>