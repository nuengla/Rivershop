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
                    <li><a href="admin_order.php?id=4">ย้อนกลับ</a></li>
                </ul>
            </div>
           
            
        </div>
    <div class="conten"><br>
    <h1>จัดส่งสินค้า</h1><br>
        <h2>รายละเอียดสินค้า</h2>
        <br>
        <a href="printorder.php?o_id=<?php echo $o_id;?>" target="_blank"><input type="button" class="btn_sys" value="พิมพ์ใบสั่งสินค้า"></a>
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
                echo "<td colspan='4'style='text-align:right'>การจัดส่ง ".$row1["t_name"]." ค่าจัดส่ง</td>";
                echo "<td style='text-align:right'>".number_format(($transport),2)."</td>";
                echo "</tr>";
                echo "<tr style='text-align:right'>";
                echo "<td colspan='4'>ราคารวม</td>";
                echo "<td>".number_format(($total),2)."</td>";
                echo "</tr>";
              
                ?>
    </table><br>
    <h2>ข้อมูลลูกค้า</h2>
    <form action="check_send_parcel.php" method="POST">
    
    <table border="1" align="center"  >
        <?php 
                $sql21 = "SELECT * FROM orders WHERE o_id=$o_id";
                $result21 = mysqli_query($con, $sql21);
                $row21 = mysqli_fetch_array($result21);
                $addnew = $row21["addnew"];
                if($addnew=="1"){
                    $sql211 = "SELECT * FROM orders,address_ WHERE orders.o_id=$o_id AND orders.o_id=address_.o_id";
                    $result211 = mysqli_query($con, $sql211);
                    $row211 = mysqli_fetch_array($result211);
                    $add_detail = $row211["add_address"]."<br>"."จังหวัด:".$row211["add_add_province"]."<br>"."เขต/อำเภอ:".$row211["add_add_amphur"]."<br>"."แขวง/ตำบล:".$row211["add_add_district"]."<br>"."รหัสไปรษณีย์:".$row211["add_add_zipcode"];
                }elseif($addnew=="0"){
                    $sql2111 = "SELECT * FROM payment,member,bank WHERE o_id=$o_id AND payment.mem_id=member.mem_id AND payment.b_id=bank.b_id";
                    $result2111 = mysqli_query($con, $sql2111);
                    $row2111 = mysqli_fetch_array($result2111);
                    $add_detail = $row2111["mem_address"]."<br>"."จังหวัด:".$row2111["mem_add_province"]."<br>"."เขต/อำเภอ:".$row2111["mem_add_amphur"]."<br>"."แขวง/ตำบล:".$row2111["mem_add_district"]."<br>"."รหัสไปรษณีย์:".$row2111["mem_add_zipcode"];
                }

				$sql2 = "SELECT * FROM payment,member,bank WHERE o_id=$o_id AND payment.mem_id=member.mem_id AND payment.b_id=bank.b_id";
                $result2 = mysqli_query($con, $sql2);
                $row2 = mysqli_fetch_array($result2);
            echo "<tr>";
            echo "<td align='left'>"."USERNAME"."</td>";
            echo "<td align='left' width='200'>".$row2["mem_user"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."ชื่อลูกค้า"."</td>";
            echo "<td align='left'>"."คุณ ".$row2["mem_name"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'width='150'>"."ที่อยู่ในการจัดส่ง"."</td>";
            echo "<td align='left' width='300'>".$add_detail."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."เบอร์โทรศัพท์"."</td>";
            echo "<td align='left'>".$row2["mem_tel"]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='left'>"."หมายเลขพัสดุ"."</td>";
            echo "<td align='left'><input type='text' name='o_parcelnum' required><input type='hidden' name='o_id' value='".$o_id."'></td>";
            echo "</tr>";
            echo "</tr>";
            echo "<tr>";
            echo "<td  colspan='2'><a href='printtransport.php?o_id=".$o_id."'  target='_blank'><input type='button' class='btn_sys' value='พิมพ์ใบจ่าหน้าพัสดุ'></a>"." "."<input type='submit' class='btn_green' value='บันทึกการจัดส่ง'></td>";
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