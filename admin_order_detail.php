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
    $admin = $_GET['admin'];
    $page = $_GET['page'];

?>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <div class="navbar">
            <div class="navmenu">
                <ul>
                    <li><?php if($page==1){

                       echo "<a href='admin_order.php?id=1'>ย้อนกลับ</a></li>";
                    }else{
                        echo "<a href='admin_order.php?id=3'>ย้อนกลับ</a></li>";
                    }
                    ?>
                    
                </ul>
            </div>
           
            
        </div>
    <div class="conten"><br>
        <h1>รายละเอียดการสั่งสินค้า</h1>
        <br>
        <a href="printorder.php?o_id=<?php echo $o_id;?>" target="_blank"><input type="button" class="btn_sys" value="พิมพ์ใบสั่งสินค้า"></a>
		<table width="600" border="1" align="center" class="square">
           <tr> 
               <td colspan="5" bgcolor="#00fffc" align="center">รหัสการสั่งสินค้า <?php echo $o_id;?> </td>
            </tr>
           <tr>
      <td bgcolor="#00fffc" width="200"> ชื่อสินค้า </td>
      <td align="center" bgcolor="#00fffc" width="100"> ประเภท </td>
      <td align="center" bgcolor="#00fffc"width="100"> ขนาด </td>
	  <td align="center" bgcolor="#00fffc"width="100"> จำนวน(ชิ้น) </td>
	  <td align="center" bgcolor="#00fffc"width="200"> ราคา(บาท) </td>

 
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
                echo "<td colspan='4'style='text-align:right'>การจัดส่ง ".$row1["t_name"]." ค่าจัดส่ง</td>";
                echo "<td style='text-align:right'>".number_format(($transport),2)."</td>";
                echo "</tr>";
                echo "<tr style='text-align:right'>";
                echo "<td colspan='4'>ราคารวม</td>";
                echo "<td>".number_format(($total),2)."</td>";
                echo "</tr>";
				?>
	</table><br>
    </div>
 
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>