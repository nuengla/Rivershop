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

?>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php include "navbarmemin.php"?>
    <div class="conten"><br>
		<h1>ประวัติการสั่งสินค้า</h1>
		<font color="red">! ! ! การสั่งซื้อจะถูกยกเลิกภายใน 24 ชั่วโมงถ้าไม่มีการแจ้งชำระค่าสินค้า ! ! !</font>
		<form action="" method="GET">
                    ค้นหา <input type="text" name="search" placeholder="กรอกเลขที่การสั่งซื้อ"> <input class="btn_sys" type="submit" value="ค้นหา">
                 
                </form>
		<table width="1000" align="center" style=border-radius:8px;>
    <tr>
      <td bgcolor="#00f0ff" width="50"> เลขที่การสั่งซื้อ </td>
      <td align="center" bgcolor="#00f0ff" width="80"> วันที่และเวลาการสั่งสินค้า </td>
	  <td align="center" bgcolor="#00f0ff"width="80"> รายละเอียด </td>
	  <td align="center" bgcolor="#00f0ff"width="150"> สถานะ </td>
	  <td align="center" bgcolor="#00f0ff"width="130"> หมายเลขพัสดุ </td>
	  <td align="center" bgcolor="#00f0ff"width="70"> ติดตามพัสดุ </td>
	  <td align="center" bgcolor="#00f0ff"width="70"> พิมใบเสร็จ </td>
 
    </tr>
		<?php 
		 $search = $_GET['search'];
		 if (!empty($search)) {
			 $sql = "SELECT * FROM orders,status_
	 WHERE mem_id=$mem_id AND orders.s_id=status_.s_id AND orders.o_id LIKE '%$search%' ORDER BY o_date ASC ";
			 $result = mysqli_query($con, $sql);
			 $r = mysqli_num_rows($result);
			 if ($r == 0) {
				 $output = 'ไม่มีสินค้าที่ค้นหา';
			 }}else{
				$sql = "SELECT * FROM orders,status_ WHERE mem_id=$mem_id AND orders.s_id=status_.s_id";
				$result = mysqli_query($con, $sql);
			 }
				
				?>
				
				<?php while ($row = mysqli_fetch_array($result)){
					 $dttm1 = $row["o_date"];
					 $dttm = date('d/m/Y H:i:s', strtotime($dttm1));
				echo "<tr>";
				echo "<td bgcolor='#EEEEEE'>" .$row["o_id"]. "</td>";
				echo "<td bgcolor='#EEEEEE'>" .$dttm. "</td>";
				echo "<td bgcolor='#EEEEEE'>" ."<a href='order_detail.php?o_id=$row[o_id]'><input type='button' class='btn_main'value='รายละเอียด'></a>". "</td>";
				if ($row["s_id"]==1){
					echo "<td bgcolor='#FF0000'>" .$row["s_name"]. "</td>";

				}else if ($row["s_id"]==2){

					echo "<td bgcolor='#FBFF00'>" .$row["s_name"]. "</td>";
				}else if ($row["s_id"]==3){

					echo "<td bgcolor='#1BFF00'>" .$row["s_name"]. "</td>";
				}else if ($row["s_id"]==4){

					echo "<td bgcolor='#ffa100'>" .$row["s_name"]. "</td>";
				}
				echo "<td bgcolor='#EEEEEE'>" .$row["o_parcelnum"]. "</td>";
				if ($row["o_parcelnum"]=="-"){
					echo "<td bgcolor='#EEEEEE'></td>";
				}else{
				echo "<td bgcolor='#EEEEEE'>" ."<a href='http://emsbot.com/#/?s=$row[o_parcelnum]' target='_blank'><input type='button' class='btn_green'value='GO'></a>". "</td>";
				}
				if ($row["o_parcelnum"]=="-"){
					echo "<td bgcolor='#EEEEEE'></td>";
				}else{
				echo "<td bgcolor='#EEEEEE'>" ."<a href='printslip.php?o_id=$row[o_id]' target='_blank'><input type='button' class='btn_sys'value='พิมพ์'></a>". "</td>";
				}
				echo "</tr>";
			}
				?>
	</table><br>
    </div>
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>
