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
    $value = $_REQUEST['value'];
    $day = date('d/m/Y');

?>

    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        
        <?php include "navbar_admin.php";?>
    <div class="conten"><br>
  <h1>แนะนำการสั่งซื้อ</h1>
  <h3>ประจำวันที่ <?php  echo $day;?></h3>
  <form action="" method="GET">
                    ค้นหาสินค้า <input type="text" name="search" placeholder="ค้นหาสินค้า"> <input class="btn_sys" type="submit" value="ค้นหา">
                    </form>
  <form action="forecast.php" method="GET">
  <table>
    <tr>
    <td>แสดงสินค้าที่จำนวนคงเหลือที่น้อยกว่า</td>
    <td><input type="number" min="0" name="value" style="width: 80px;text-align:right;"></td>
    <td><input type="submit" class="btn_sys"  value="ค้นหา"></td>
    </tr>
  </table>
  
  </form>
  
  <?php if(empty($value)){
$sql = "SELECT * FROM product,pro_type,pro_size WHERE product.p_qty=0 AND product.pt_id=pro_type.pt_id AND product.ps_id=pro_size.ps_id ORDER BY p_qty";
$result = mysqli_query($con, $sql);


  }else{
    $sql = "SELECT * FROM product,pro_type,pro_size WHERE product.p_qty<$value AND product.pt_id=pro_type.pt_id AND product.ps_id=pro_size.ps_id ORDER BY p_qty";
    $result = mysqli_query($con, $sql);
  }
  
  
  ?>
  
  <?php
            $search = $_GET['search'];
            if (!empty($search)) {
                $sql = "SELECT * FROM product,pro_type,pro_size
        WHERE product.pt_id=pro_type.pt_id AND product.ps_id=pro_size.ps_id AND product.p_name LIKE '%$search%' ORDER BY p_qty ";
                $result = mysqli_query($con, $sql);
                $r = mysqli_num_rows($result);
                if ($r == 0) {
                    $output = 'ไม่มีสินค้าที่ค้นหา';
                }}else{
                    $sql = "SELECT * FROM product,pro_type,pro_size WHERE product.p_qty=0 AND product.pt_id=pro_type.pt_id AND product.ps_id=pro_size.ps_id ORDER BY p_qty";
                    $result = mysqli_query($con, $sql);
                }
        ?>
  
        <table >
        <tr>
        <td bgcolor="#00f0ff" width="70">รหัสสินค้า</td>
        <td bgcolor="#00f0ff" width="80">รูปสินค้า</td>
        <td bgcolor="#00f0ff" width="200">ชื่อสินค้า</td>
        <td bgcolor="#00f0ff" width="80">ประเภท</td>
        <td bgcolor="#00f0ff" width="80">ไซส์</td>
        <td bgcolor="#00f0ff" width="100">ราคา</td>
        <td bgcolor="#00f0ff" width="80">จำนวนคงเหลือ</td>
        <td bgcolor="#00f0ff" width="100">ยอดขาย/ชิ้น</td>
        <td bgcolor="#00f0ff" width="100">คำแนะนำ</td>
        <td bgcolor="#00f0ff" width="100">จำนวนสั่งซื้อที่แนะนำ/ชิ้น</td>
        </tr>
        <?php while($row = mysqli_fetch_array($result)){
            $sql1 = "SELECT SUM(od_prounit)AS od_prounit,p_id,s_id FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 AND orderdt.p_id='$row[p_id]'";
            $result1 = mysqli_query($con, $sql1);
            $row1 = mysqli_fetch_array($result1);
            //forecast
            $dttm = date('Y-m-d H:i:s');
            $beforday = -3;
            $dt = new Datetime($dttm);
            $dt->modify("{$beforday} days");
            $o_date = $dt->format('Y-m-d H:i:s');
            //minimum
            $dttm1 = date('Y-m-d H:i:s');
            $beforday1 = -28;
            $dt1 = new Datetime($dttm1);
            $dt1->modify("{$beforday1} days");
            $o_date1 = $dt1->format('Y-m-d H:i:s');
            //minimum
            $sql41 = "SELECT SUM(od_prounit)AS od_prounit,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id  AND orders.s_id=3 AND orderdt.p_id='$row[p_id]' AND o_date BETWEEN '$o_date1' AND '$dttm1' ";
            $result41 = mysqli_query($con, $sql41);
            $row41 = mysqli_fetch_array($result41);
            //forecast
            $sql4 = "SELECT SUM(od_prounit)AS od_prounit,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id  AND orders.s_id=3 AND orderdt.p_id='$row[p_id]' AND o_date BETWEEN '$o_date' AND '$dttm' ";
            $result4 = mysqli_query($con, $sql4);
            $row4 = mysqli_fetch_array($result4);
            $m = $row41["od_prounit"];
            $minimum1 = $m / 28;
            $minimum   = floor($minimum1);

            $forecast = $row4["od_prounit"];
             $inventory = $row['p_qty'];
             $sum1 = $forecast + $minimum;
            $orders = $sum1 - $inventory;
            if($orders<0){
                $orders= "0";
            }
            ?>
        <tr>
        <td bgcolor="#EAEAEA"><?php echo $row['p_code'];?></td>
        <td bgcolor="#EAEAEA"><input type="image" src="img/<?php echo $row['p_img'];?>" style=width:80px;height:90px;></td>
        <td bgcolor="#EAEAEA"><?php echo $row['p_name'];?></td>
        <td bgcolor="#EAEAEA"><?php echo $row['pt_name'];?></td>
        <td bgcolor="#EAEAEA"><?php echo $row['ps_name'];?></td>
        <td bgcolor="#EAEAEA"><?php echo $row['p_price'];?></td>
        <td bgcolor="#EAEAEA"><?php echo $row['p_qty'];?></td>
        <td bgcolor="#EAEAEA"><?php echo number_format($row1["od_prounit"])?></td>
        <?php 
        $qty = $row["p_qty"];
        $prounit = $row1["od_prounit"];
        if(empty($prounit)){
            $prounit = "0" ;
        }
        
        ?>
            <?php if($orders>0){?>
                <td bgcolor="#FF0000">ควรสั่งซื้อเพิ่ม</td>
           
            <?php }elseif($orders<=0){?>
                <td bgcolor="#1BFF00">ตัดสินใจหรือไม่ต้องสั่งซื้อเพิ่ม</td>
            <?php }?>

                <td bgcolor="#EAEAEA"><?php echo $orders;?></td>
        </tr>
        <?php }?>
        </table><br>

 </div>

    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>