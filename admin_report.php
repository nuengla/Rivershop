<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="all" href="style.css" />
    <link rel="shortcut icon" href="img_web/favicon.png" />
    
    <title>RIVER-SHOP</title>
</head>
<body>

<?php
    session_start();
    include ("condb.php");
    $mem_id = $_SESSION['mem_id'];
    $mem_name = $_SESSION['mem_name'];
    $id = $_GET['id'];
    $act = $_REQUEST['act'];
   

?>

    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        
        <?php include "navbar_admin.php";?>
    <div class="conten"><br>
   <?php if($id=="1"){
        $sql1 = "SELECT SUM(od_prounit)AS od_prounit,SUM(od_totalprice)AS od_totalprice,p_id,s_id FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 GROUP BY p_id 
        ORDER BY od_prounit DESC ";
        $result = mysqli_query($con, $sql1);
        

      /* $sql1 = "SELECT * FROM orderdt,product WHERE orderdt.p_id=product.p_id GROUP BY orderdt.p_id 
       ORDER BY od_prounit DESC ";
       $result = mysqli_query($con, $sql1);*/
       
      
       
       
       
       ?>
    <h1>รายงานยอดขาย</h1>
    <h4>(ยอดขายจะแสดงเฉพาะการสั่งซื้อที่ชำระเงินและจัดส่งแล้วเท่านั้น)</h4>
    <table>
    <tr>
    <td bgcolor="#00f0ff" width="80">อันดับ</td>
    <td bgcolor="#00f0ff" width="250">สินค้า</td>
    <td bgcolor="#00f0ff" width="80">ขนาด</td>
    <td bgcolor="#00f0ff" width="80">ราคาต่อหน่วย/บาท</td>
    <td bgcolor="#00f0ff" width="100">จำนวน</td>
    <td bgcolor="#00f0ff" width="200">รายได้ทั้งหมด/บาท</td>
    </tr>
    <?php $hight = 1;
    while($row = mysqli_fetch_array($result)){
        /*$sql11 = "SELECT SUM(od_prounit)AS od_prounit FROM orderdt WHERE p_id=$row[2] ";
       $result1 = mysqli_query($con, $sql11);
       $row1 = mysqli_fetch_array($result1);
       $sql111 = "SELECT SUM(od_totalprice)AS od_totalprice FROM orderdt WHERE p_id=$row[2] ";
       $result11 = mysqli_query($con, $sql111);
       $row11 = mysqli_fetch_array($result11);*/
       $sql11 = "SELECT * FROM orderdt,product,pro_size WHERE orderdt.p_id=product.p_id AND product.ps_id=pro_size.ps_id AND orderdt.p_id=$row[2] ";
       $result1 = mysqli_query($con, $sql11);
       $row1 = mysqli_fetch_array($result1);

       $sumprice = $row['od_totalprice'];
                    $total1 += $sumprice;
                    $sumunit = $row['od_prounit'];
                    $total2 += $sumunit;
        ?>
        <tr>
    <td bgcolor="#EAEAEA"><?php echo $hight;?></td>
    <td bgcolor="#EAEAEA" align="left"><?php echo $row1["p_name"];?></td>
    <td bgcolor="#EAEAEA"><?php echo $row1["ps_name"];?></td>
    <td bgcolor="#EAEAEA" align="right"><?php echo number_format($row1["p_price"],2);?></td>
    <td bgcolor="#EAEAEA" align="right"><?php echo number_format($row["od_prounit"]);?></td>
    <td bgcolor="#EAEAEA" align="right"><?php echo number_format($row["od_totalprice"],2);?></td>
    </tr>
    <?php $hight++;}?>
    <tr>
    <td bgcolor="#EAEAEA" align="center" colspan="4">รวม</td>
    <td bgcolor="#EAEAEA" align="right"><?php echo number_format($total2);?></td>
    <td bgcolor="#EAEAEA" align="right"><?php echo number_format($total1,2);?></td>

    </tr>
    </table><br>

<?php }?><br>





</div>

    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>