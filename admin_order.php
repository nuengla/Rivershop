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
<script language="javascript">
    function cancel (){
        if(confirm('ยืนยันการยกเลิกการสั่งสินค้า')){
            return true;
            
        }else{
            return false;
        }
    }
    function canceldata3 (){
        if(confirm('ยืนยันการยกเลิกการสั่งสินค้า')){
            return true;
            
        }else{
            return false;
        }
    }
</script>
<?php
    session_start();
    include ("condb.php");
    $mem_id = $_SESSION['mem_id'];
    $mem_name = $_SESSION['mem_name'];
    $id = $_GET['id'];

?>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php include "navbar_admin.php";?>
    <div class="conten"><br>
    <?php
        if ($id==1){
           echo "<h1>"."รายการสั่งซื้อที่ยังไม่ได้ชำระเงิน"."</h1>";?>
           <form action="admin_order.php" method="GET">
                    ค้นหา <input type="text" name="search" placeholder="กรอกเลขที่การสั่งซื้อ"> <input class="btn_sys" type="submit" value="ค้นหา">
                <input type="hidden" name="id" value="1">   
                </form>
           <table width="700" border="1" align="center" class="square">
    <tr>
      <td bgcolor="#00f0ff" width="100"> เลขที่การสั่งซื้อ </td>
      <td align="center" bgcolor="#00f0ff" width="200"> วันที่และเวลาการสั่งสินค้า </td>
	  <td align="center" bgcolor="#00f0ff"width="200"> ผู้สั่งซื้อ </td>
      <td align="center" bgcolor="#00f0ff"width="100"> รายละเอียด </td>
	  <td align="center" bgcolor="#00f0ff"width="100"> ยกเลิกการสั่ง </td>

 
    </tr>
    <?php
            $search = $_GET['search'];
            if (!empty($search)) {
                $sql = "SELECT * FROM orders,member
        WHERE s_id=$id AND orders.mem_id=member.mem_id AND orders.o_id LIKE '%$search%' ORDER BY o_date ASC ";
                $result = mysqli_query($con, $sql);
                $r = mysqli_num_rows($result);
                if ($r == 0) {
                    $output = 'ไม่มีสินค้าที่ค้นหา';
                }}else{
                    $sql = "SELECT * FROM orders,member WHERE s_id=$id AND orders.mem_id=member.mem_id ORDER BY o_date ASC";
                $result = mysqli_query($con, $sql);
                }
        ?>
        <?php 
        
				
                
				while ($row = mysqli_fetch_array($result)){
                    $dttm1 = $row["o_date"];
                   $dttm = date('d/m/Y H:i:s', strtotime($dttm1));
				echo "<tr>";
				echo "<td >" .$row["o_id"]. "</td>";
				echo "<td >" .$dttm. "</td>";
                echo "<td>" .$row["mem_name"]. "</td>";
                echo "<td >" ."<a href='admin_order_detail.php?page=1&o_id=$row[o_id]'><input type='button' class='btn_sys' value='รายละเอียด'></a>". "</td>";
				echo "<td >"."<a href='admin_order.php?act=cancel&o_id=$row[o_id]' onclick='return cancel();'><input type='button' class='btn_red' value='ยกเลิก'></a>"."</td>";
				
				echo "</tr>";
			}
				?>
                
    </table><br>
<?php }
  else if($id==2){

    echo "<h1>"."รายการสั่งซื้อรอการตรวจสอบ"."</h1>";?>
    <form action="admin_order.php" method="GET">
                    ค้นหา <input type="text" name="search" placeholder="กรอกเลขที่การสั่งซื้อ"> <input class="btn_sys" type="submit" value="ค้นหา">
                <input type="hidden" name="id" value="2">   
                </form>
    <table width="800" border="1" align="center" class="square">
<tr>
<td bgcolor="#00f0ff" width="100">  เลขที่การสั่งซื้อ </td>
<td align="center" bgcolor="#00f0ff" width="200"> วันที่และเวลาการสั่งสินค้า </td>
<td align="center" bgcolor="#00f0ff"width="150"> ชื่อผู้สั่ง </td>
<td align="center" bgcolor="#00f0ff"width="100"> รายละเอียดการแจ้งชำระเงิน </td>


</tr>
 <?php 
         $search = $_GET['search'];
         if (!empty($search)) {
             $sql = "SELECT * FROM orders,member
     WHERE s_id=$id AND orders.mem_id=member.mem_id AND orders.o_id LIKE '%$search%' ORDER BY o_date ASC ";
             $result = mysqli_query($con, $sql);
             $r = mysqli_num_rows($result);
             if ($r == 0) {
                 $output = 'ไม่มีสินค้าที่ค้นหา';
             }}else{
                 $sql = "SELECT * FROM orders,member WHERE s_id=$id AND orders.mem_id=member.mem_id ORDER BY o_date ASC";
             $result = mysqli_query($con, $sql);
             }
         while ($row = mysqli_fetch_array($result)){
            $dttm1 = $row["o_date"];
            $dttm = date('d/m/Y H:i:s', strtotime($dttm1));
            echo "<tr>";
            echo "<td >" .$row["o_id"]. "</td>";
            echo "<td >" .$dttm. "</td>";
            echo "<td>" .$row["mem_name"]. "</td>";
            echo "<td >" ."<a href='admin_payment_detail.php?o_id=$row[o_id]'><input type='button' class='btn_sys' value='ตรวจสอบ'></a>". "</td>";
           
            echo "</tr>";
        }
         ?>
</table><br>
<?php

  }else if($id==3){
    echo "<h1>"."รายการสั่งซื้อที่ชำระเงินแล้ว"."</h1>";?>
    <form action="admin_order.php" method="GET">
                    ค้นหา <input type="text" name="search" placeholder="กรอกเลขที่การสั่งซื้อ"> <input class="btn_sys" type="submit" value="ค้นหา">
                <input type="hidden" name="id" value="3">   
                </form>
    <table  border="1" align="center" class="square">
<tr>
<td bgcolor="#00f0ff" width="100">  เลขที่การสั่งซื้อ </td>
<td align="center" bgcolor="#00f0ff" width="200"> วันที่และเวลาการสั่งสินค้า </td>
<td align="center" bgcolor="#00f0ff" width="200"> ชื่อผู้สั่งซื้อ </td>
<td align="center" bgcolor="#00f0ff"width="100"> รายละเอียด </td>
<td align="center" bgcolor="#00f0ff"width="200"> หมายเลขพัสดุ </td>
<td align="center" bgcolor="#00f0ff"width="95"> พิมพ์ใบจ่าหน้าพัสดุ </td>
<td align="center" bgcolor="#00f0ff"width="95"> พิมพ์ใบเสร็จ </td>


</tr>
 <?php 
         $search = $_GET['search'];
         if (!empty($search)) {
             $sql = "SELECT * FROM orders,member
     WHERE s_id=$id AND orders.mem_id=member.mem_id AND orders.o_id LIKE '%$search%' ORDER BY o_date ASC ";
             $result = mysqli_query($con, $sql);
             $r = mysqli_num_rows($result);
             if ($r == 0) {
                 $output = 'ไม่มีสินค้าที่ค้นหา';
             }}else{
                 $sql = "SELECT * FROM orders,member WHERE s_id=$id AND orders.mem_id=member.mem_id ORDER BY o_date ASC";
             $result = mysqli_query($con, $sql);
             }
         while ($row = mysqli_fetch_array($result)){
            $dttm1 = $row["o_date"];
            $dttm = date('d/m/Y H:i:s', strtotime($dttm1));
         echo "<tr>";
         echo "<td >" .$row["o_id"]. "</td>";
         echo "<td >" .$dttm. "</td>";
         echo "<td >" .$row["mem_name"]. "</td>";   
         echo "<td >" ."<a href='admin_order_detail.php?page=3&o_id=$row[o_id]'><input type='button' class='btn_main' value='รายละเอียด'></a>". "</td>";
         echo "<td >" .$row["o_parcelnum"]. "</td>";   
         echo "<td >" ."<a href='printtransport.php?o_id=$row[o_id]' target='_blank'><input type='button' class='btn_sys' value='พิมพ์'></a>". "</td>";
         echo "<td >" ."<a href='printslip.php?o_id=$row[o_id]' target='_blank'><input type='button' class='btn_sys' value='พิมพ์'></a>". "</td>";
         
         echo "</tr>";
     }
         ?>
</table><br>
<?php

  }else if($id==4){
    echo "<h1>"."รายการสั่งซื้อที่เตรียมการจัดส่ง"."</h1>";?>
    <form action="admin_order.php" method="GET">
                    ค้นหา <input type="text" name="search" placeholder="กรอกเลขที่การสั่งซื้อ"> <input class="btn_sys" type="submit" value="ค้นหา">
                <input type="hidden" name="id" value="4">   
                </form>
    <table width="800" border="1" align="center" class="square">
<tr>
<td bgcolor="#00f0ff" width="100">  เลขที่การสั่งซื้อ </td>
<td align="center" bgcolor="#00f0ff" width="200"> วันที่และเวลาการสั่งสินค้า </td>
<td align="center" bgcolor="#00f0ff"width="150"> ชื่อผู้สั่ง </td>

<td align="center" bgcolor="#00f0ff"width="100"> แจ้งเลขพัสดุและจัดส่ง </td>

</tr>
 <?php 
         $search = $_GET['search'];
         if (!empty($search)) {
             $sql = "SELECT * FROM orders,member
     WHERE s_id=$id AND orders.mem_id=member.mem_id AND orders.o_id LIKE '%$search%' ORDER BY o_date ASC ";
             $result = mysqli_query($con, $sql);
             $r = mysqli_num_rows($result);
             if ($r == 0) {
                 $output = 'ไม่มีสินค้าที่ค้นหา';
             }}else{
                 $sql = "SELECT * FROM orders,member WHERE s_id=$id AND orders.mem_id=member.mem_id ORDER BY o_date ASC";
             $result = mysqli_query($con, $sql);
             }
         while ($row = mysqli_fetch_array($result)){
            $dttm1 = $row["o_date"];
            $dttm = date('d/m/Y H:i:s', strtotime($dttm1));
            echo "<tr>";
            echo "<td >" .$row["o_id"]. "</td>";
            echo "<td >" .$dttm. "</td>";
            echo "<td>" .$row["mem_name"]. "</td>";
            echo "<td >"."<a href='admin_send_parcel.php?o_id=$row[o_id]'><input type='button'class='btn_green' value='GO'></a>"."</td>";
            echo "</tr>";
        }
         ?>
</table><br>
<?php

  }

  ?>
<?php 
    include "condb.php";
    
    $act = $_REQUEST['act'];
    $o_id = $_GET['o_id'];
    if($act=="cancel"){
        $sql11 = "SELECT * FROM orderdt WHERE o_id=$o_id ";
                $result11 = mysqli_query($con, $sql11);
                while($row11 = mysqli_fetch_array($result11)){
                    $qty = $row11['od_prounit'];
                    $p_id = $row11['p_id'];
                $sql12 = "SELECT * FROM product WHERE p_id=$p_id ";
                $result12 = mysqli_query($con, $sql12);
                $row12 = mysqli_fetch_array($result12);
                $p_qty = $row12['p_qty'];
                $return1= $p_qty+$qty;
                  /* echo  "จำนวน".$qty;
                    echo "<br>";
                    echo "รหัสสินค้า".$p_id;
                    echo "<br>";*/
                    $sqlUpdatePd="UPDATE product SET p_qty='$return1' WHERE p_id='$p_id'";
        $query5	= mysqli_query($con, $sqlUpdatePd);
                    /*echo "รหัสสินค้า".$row12['p_id'];
                    echo "<br>";
                    echo "รหัสสินค้า".$p_id;
                    echo "<br>";
                    echo  "จำนวน".$qty;
                    echo "<br>";
                    echo "คืนค่า".$return1;
                    echo "<br>";
                    echo "<br>";*/

                }
        $delet = "DELETE FROM orderdt WHERE o_id=$o_id";
        $result4 = mysqli_query($con,$delet);
        $delet1 = "DELETE FROM orders WHERE o_id=$o_id";
        $result5 = mysqli_query($con,$delet1);

        $delet6 = "DELETE FROM payment WHERE o_id=$o_id";
        $result6 = mysqli_query($con, $delet6);
        $delet7 = "DELETE FROM address_ WHERE o_id=$o_id";
    $result7 = mysqli_query($con,$delet7);
    }
    if ($result4 && $result5 && $query5&&$result6&&$result7) {
    echo "<script>";
    echo "alert(\"ยกเลิกการสั่งเรียบร้อยแล้ว\");";
            echo "window.location='admin_order.php?id=1'"; 
            echo "</script>";
    }
    
    ?>


    </div>
 
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>