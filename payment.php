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

?>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php include "navbarmemin.php"?>
    <div class="conten"><br>
		<h1>แจ้งชำระค่าสินค้า</h1>
        <font color="red">! ! ! การสั่งซื้อจะถูกยกเลิกภายใน 24 ชั่วโมงถ้าไม่มีการแจ้งชำระค่าสินค้า ! ! !</font>
        <form action="" method="GET">
                    ค้นหา <input type="text" name="search" placeholder="กรอกเลขที่การสั่งซื้อ"> <input class="btn_sys" type="submit" value="ค้นหา">
                 
                </form>
		<table width="700" align="center" class="square">
    <tr>
      <td bgcolor="#00f0ff" width="80"> เลขที่การสั่งซื้อ </td>
      <td align="center" bgcolor="#00f0ff" width="200"> วันที่และเวลาการสั่งสินค้า </td>
	  <td align="center" bgcolor="#00f0ff"width="200"> สถานะ </td>
      <td align="center" bgcolor="#00f0ff"width="100"> ชำระสินค้า </td>
      <td align="center" bgcolor="#00f0ff"width="100"> ยกเลิก </td>
 
    </tr>
        <?php 
         $search = $_GET['search'];
		 if (!empty($search)) {
			 $sql = "SELECT * FROM orders,status_
	 WHERE mem_id=$mem_id AND orders.s_id=status_.s_id AND orders.s_id<3 AND orders.o_id LIKE '%$search%' ORDER BY o_date ASC ";
			 $result = mysqli_query($con, $sql);
			 $r = mysqli_num_rows($result);
			 if ($r == 0) {
				 $output = 'ไม่มีสินค้าที่ค้นหา';
			 }}else{
				$sql = "SELECT * FROM orders,status_ WHERE mem_id=$mem_id AND orders.s_id=status_.s_id AND orders.s_id<3 ";
				$result = mysqli_query($con, $sql);
			 }
                ?>
				<?php while ($row = mysqli_fetch_array($result)){
                     $dttm1 = $row["o_date"];
                     $dttm = date('d/m/Y H:i:s', strtotime($dttm1));
				echo "<tr>";
				echo "<td bgcolor='#EEEEEE'>" .$row["o_id"]. "</td>";
				echo "<td bgcolor='#EEEEEE'>" .$dttm. "</td>";
				if ($row["s_id"]==1){
					echo "<td bgcolor='#FF0000'>" .$row["s_name"]. "</td>";

				}else if ($row["s_id"]==2){

					echo "<td bgcolor='#FBFF00'>" .$row["s_name"]. "</td>";
				}else if ($row["s_id"]==3){

					echo "<td bgcolor='#1BFF00'>" .$row["s_name"]. "</td>";
                }
                
				if ($row["s_id"]==2){
                    echo "<td bgcolor='#EEEEEE'></td>";
                    echo "<td bgcolor='#EEEEEE'></td>";
				}else{
                    echo "<td bgcolor='#EEEEEE'>" ."<a href='payment_detail.php?o_id=$row[o_id]'><input type='button' class='btn_main'value='ชำระเงิน'></a>". "</td>";
                    echo "<td bgcolor='#EEEEEE'>"."<a href='payment.php?act=cancel&o_id=$row[o_id]' onclick='return cancel();'><input type='button' class='btn_red' value='ยกเลิก'></a>"."</td>";
                }
            
                echo "</tr>";
                }
                



                
                





				?>
	</table><br>
    </div>
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
                  
                    $sqlUpdatePd="UPDATE product SET p_qty='$return1' WHERE p_id='$p_id'";
        $query5	= mysqli_query($con, $sqlUpdatePd);
                   

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
            echo "window.location='payment.php'"; 
            echo "</script>";
    }
    
    ?>
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>