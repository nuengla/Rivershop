<?php
include("condb.php");
$dttm = date('Y-m-d H:i:s');
$beforday = -1;
$dt = new Datetime($dttm);
$dt->modify("{$beforday} days");
$o_date = $dt->format('Y-m-d H:i:s');

$sql41 = "SELECT * FROM orders WHERE o_date<'$o_date' AND s_id=1 ";
$result41 = mysqli_query($con, $sql41);
while ($row41 = mysqli_fetch_array($result41)) {
    $o_id = $row41["o_id"];





    $sql11 = "SELECT * FROM orderdt WHERE o_id=$o_id ";
    $result11 = mysqli_query($con, $sql11);
    while ($row11 = mysqli_fetch_array($result11)) {
        $qty = $row11['od_prounit'];
        $p_id = $row11['p_id'];
        $sql12 = "SELECT * FROM product WHERE p_id=$p_id ";
        $result12 = mysqli_query($con, $sql12);
        $row12 = mysqli_fetch_array($result12);
        $p_qty = $row12['p_qty'];
        $return1 = $p_qty + $qty;

        $sqlUpdatePd = "UPDATE product SET p_qty='$return1' WHERE p_id='$p_id'";
        $query5    = mysqli_query($con, $sqlUpdatePd);
    }
    $delet = "DELETE FROM orderdt WHERE o_id=$o_id";
    $result4 = mysqli_query($con, $delet);
    $delet1 = "DELETE FROM orders WHERE o_id=$o_id";
    $result5 = mysqli_query($con, $delet1);
    $delet6 = "DELETE FROM payment WHERE o_id=$o_id";
    $result6 = mysqli_query($con, $delet6);
}
if ($result4 && $result5 && $query5&&$result6) {
    echo "<script>";

    echo "window.location='admin.php'";
    echo "</script>";
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="img_web/favicon.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="all" href="style.css" />
    <link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">
    <title>RIVER-SHOP</title>
</head>

<style type="text/css" >
  a {
      text-decoration: none;
      
  }
  a :hover{
     
      color: orange;
  }
</style>

<body >

<?php
    session_start();
    include ("condb.php");
    $id = $_SESSION['mem_id'];
    $name = $_SESSION['mem_name'];
    $level = $_SESSION['mem_type'];
    $act = $_REQUEST['act'];
    $day = date('d/m/Y');
    if (empty($id)) {

        echo "<script>";
        echo "alert(\"กรุณาเข้าสู่ระบบ\");";
        echo "window.location='login.php'";
        echo "</script>";
    }
?>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php include "navbar_admin.php";?>
        <div class="conten" >
        <br><br>
        <h1>ยินดีต้อนรับ ADMIN</h1>
        <br>
        <?php
        $sql = "SELECT * FROM orders WHERE s_id='2' ";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        if(empty($row['o_id'])){
            echo "<br>";
        }else{
            
            
            echo " <a href='admin_order.php?id=2'><font color='red'><h3>*** มีการสั่งซื้อที่ชำระเงินแล้วไปตรวจสอบ</h3></font></a>";
        }
        ?>
    
        <br>
        <?php
        $sql = "SELECT * FROM product,pro_type,pro_size WHERE product.pt_id=pro_type.pt_id AND product.ps_id=pro_size.ps_id ORDER BY p_qty";
        $result = mysqli_query($con, $sql);
    




       
          ?>
          
        
            
                <table >
                    <tr>
                        <td colspan="9" align="left">
                            <h3>รายงานเตือนสินค้าคงเหลือไม่พอต่อการขาย</h3><td>
                    </tr>
                <tr>
                <td bgcolor="#00f0ff" width="70">รหัสสินค้า</td>
                <td bgcolor="#00f0ff" width="80">รูปสินค้า</td>
                <td bgcolor="#00f0ff" width="200">ชื่อสินค้า</td>
                <td bgcolor="#00f0ff" width="80">ประเภท</td>
                <td bgcolor="#00f0ff" width="80">ไซส์</td>
                <td bgcolor="#00f0ff" width="100">ราคา</td>
                <td bgcolor="#00f0ff" width="80">จำนวนคงเหลือ</td>
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
                    if($orders<=0){
                        continue;
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
                <td bgcolor="#FF0000">ควรสั่งซื้อเพิ่ม</td>
                <td bgcolor="#EAEAEA"><?php echo $orders;?></td>
                </tr>
                <?php }?>
                </table>
        <br>



        <?php
        $sqlpro = "SELECT * FROM product,pro_type,pro_size WHERE product.p_price_promotion>0 AND product.pt_id=pro_type.pt_id AND product.ps_id=pro_size.ps_id GROUP BY product.p_code";
        $resultpro = mysqli_query($con, $sqlpro);
    
          ?>
          
        
            
                <table width="912">
                    <tr>
                        <td colspan="8" align="left">
                            <h3>รายการสินค้าที่เป็นโปรโมชั่นในตอนนี้</h3><td>
                    </tr>
                
                   
            <tr>
            <td width="50" bgcolor="#00f0ff">ลำดับ</td>
            <td width="100" bgcolor="#00f0ff">รูปภาพ</td>
            <td width="100" bgcolor="#00f0ff">รหัสสินค้า</td>
            <td  bgcolor="#00f0ff">ชื่อสินค้า</td>
            <td width="100" bgcolor="#00f0ff">ประเภท</td>
            <td width="100" bgcolor="#00f0ff">ราคาปกติ</td>
            <td width="100" bgcolor="#00f0ff">ราคาโปรโมชั่น</td>
            <td width="100" bgcolor="#00f0ff">แก้ไข</td>
           
            </tr>
            <?php
            $i = 1;
            while ($rowpro = mysqli_fetch_array($resultpro)){
                $rowprice = $rowpro["p_price"];
                $rowprice_promo = $rowpro["p_price_promotion"];
                if($rowprice_promo > $rowprice||$rowprice_promo==0||$rowprice_promo == $rowprice){
                    continue;
                }
                
                ?>
            <tr>
            <td bgcolor="#EEEEEE"><?php echo $i;?></td>
            <td bgcolor="#EEEEEE"><img src="img/<?php echo $rowpro["p_img"];?>"style=width:90px;height:100px;></td>
            <td bgcolor="#EEEEEE"><?php echo $rowpro["p_code"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $rowpro["p_name"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $rowpro["pt_name"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $rowpro["p_price"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $rowpro["p_price_promotion"];?></td>
            <td bgcolor="#EEEEEE"><a href="admin_edit_pro.php?p_code=<?php echo $rowpro["p_code"];?>&act=edit"><input type="button" class="btn_sys" value="แก้ไข"></a></td>
            
            </tr>
            <?php $i++;
        }
        
        
        ?>

            </table>
       <br>
    </div>
 
    <div class="footer">
        
        <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>