<?php
session_start();
include("condb.php");
$id = $_SESSION['mem_id'];
$act = $_REQUEST['act'];


if (empty($_SESSION['cart'])) {
    if (empty($id)) {

        echo "<script>";
        echo "alert(\"ไม่มีสินค้าในตะกร้า กรุณกลับไปเลือกสินค้า\");";
        echo "window.location='index.php'";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert(\"ไม่มีสินค้าในตะกร้า กรุณกลับไปเลือกสินค้า\");";
        echo "window.location='index_mem.php'";
        echo "</script>";
    }
}
?>
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
    include("condb.php");
    $id = $_SESSION['mem_id'];
    $name = $_SESSION['mem_name'];
    $level = $_SESSION['mem_type'];

    if (empty($id)) {

        echo "<script>";
        echo "alert(\"กรุณาเข้าสู่ระบบเพื่อสั่งซื้อ\");";
        echo "window.location='login.php'";
        echo "</script>";
    }

    ?>
  <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php
    if(empty($id)){ ?>

        <div class="navbar">
            <div class="navmenu">
                <ul>
                    
                <li><?php
							if($id==""){			

					echo "<a href='index.php'>"."หน้าแรก"."</a>";
							}else{
								echo "<a href='index_mem.php'>"."กลับสู่หน้าหลัก"."</a>";
							} ?>
					</li>
					
                    <li><a href="cart.php">ตะกร้าสินค้า</a></li>
                    <li><a href="#">ช่วยเหลือ</a>
                        <ul>
                            <li><a href="tb_size.php">-ตารางวัดไซส์</a></li>
                            <li><a href="#">-วิธีสั่งสินค้า</a></li>
                            <li><a href="#">-วิธีชำระเงิน</a></li>
                            <li><a href="#">-วิธีสมัครสมาชิก</a></li>
                           
                        </ul>
                    </li>    
                    
                </ul>
            </div>
           <div class="navuser">
                <ul>
                    <li><a href="register.php">สมัครสมาชิก</a></li>
                    <li><a href="login.php">เข้าสู่ระบบ</a></li>   
                </ul>
            </div>
            
        </div>
        <?php }else{ $sql1 = "SELECT * FROM member WHERE mem_id=$id ";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($result1);
    ?>
        
		<?php include "navbarmemin.php"?>
    <?php } ?>
        <div class="conten"><br>
            <h1>ยืนยันการสั่งซื้อ</h1>
            <br>
            <div class="pro_box" align="center">
                <form id="frmcart" name="frmcart" method="post" action="saveorder.php">
                    <table width="800" border="0" align="center" class="square">
                        <tr>
                            <td width="500" colspan="6" bgcolor="#CCCCCC" align="center">
                                <strong>สั่งซื้อสินค้า</strong></td>
                        </tr>
                        <tr>
                            <td bgcolor="#EAEAEA">สินค้า</td>
                            <td align="center" bgcolor="#EAEAEA">ขนาด</td>
                            <td align="center" bgcolor="#EAEAEA">ประเภท</td>
                            <td align="center" bgcolor="#EAEAEA">ราคา(บาท)</td>
                            <td align="center" bgcolor="#EAEAEA">จำนวน(ชิ้น)</td>
                            <td align="center" bgcolor="#EAEAEA">รวม(บาท)</td>
                        </tr>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $p_id => $qty) {
                            $sql    = "SELECT * FROM product,pro_size,pro_type WHERE p_id=$p_id AND product.ps_id=pro_size.ps_id AND product.pt_id=pro_type.pt_id";
                            $query    = mysqli_query($con, $sql);
                            $row    = mysqli_fetch_array($query);
                            $rowprice = $row["p_price"];
				$rowprice_promo = $row["p_price_promotion"];
				if($rowprice_promo >= $rowprice || $rowprice_promo == 0){
					$price = $rowprice;
				}else{
					$price = $rowprice_promo;
				}
					$sum = $price * $qty;
                            $total    += $sum;
                            if ($qty > $row['p_qty']) {
                                echo "<script>";
                                echo "alert(\"สินค้าเกินจำนวนคงเหลือ\");";
                                echo "window.location='cart.php'";
                                echo "</script>";
                            }

                            $sql1    = "select * from member where mem_id=$id";
                            $query1    = mysqli_query($con, $sql1);
                            $row1    = mysqli_fetch_array($query1);
                            echo "<tr>";
                            echo "<td width='334'>" . $row["p_name"] . "</td>";
                            echo "<td align='center'>" . $row['ps_name'] . "</td>";
                            echo "<td align='center'>" . $row['pt_name'] . "</td>";
                            echo "<td align='right'>" . number_format(($price),2) . "</td>";
                            echo "<td align='right'>$qty</td>";
                            echo "<td align='right'>" . number_format(($sum),2) . "</td>";
                            echo "</tr>";
                        }
                        echo "<tr>";
                        echo "<td  align='right' colspan='5' bgcolor='#CEE7FF'><b>รวม</b></td>";
                        echo "<td align='right' bgcolor='#CEE7FF'>" . "<b>" . number_format(($total),2) . "</b>" . "</td>";
                        echo "</tr>";
                        ?>
                    </table>
                    <br>

                    <table>
                        <tr>
                            <td align="center">
                                <h3>การจัดส่ง</h3>
                            </td>
                        </tr>
                        <tr>
                            <td><?php $sql2 = "SELECT * FROM transport ";
                                $rstTemp = mysqli_query($con, $sql2);
                                while ($arr_2 = mysqli_fetch_array($rstTemp)) {
                                    echo "<input type='radio' name='t_id' value='" . $arr_2["t_id"] . "' required '>" . " " . $arr_2["t_name"] . " ราคา " . $arr_2["t_price"] . " บาท" . "<br>";
                                } ?></td>
                        </tr>
                    </table>



                    <br>
                    <table border="0" align="center" class="square">
                        <tr>
                            <td colspan="2" bgcolor="#CCCCCC" align="center">รายละเอียดในการส่งสินค้า</td>
                        </tr>
                        <tr>
                            <td bgcolor="#EEEEEE">ชื่อ</td>
                            <td bgcolor="#EEEEEE"><?php echo $row1["mem_name"]; ?></td>
                        </tr>
                        <tr>
                            <td width="22%" bgcolor="#EEEEEE">ที่อยู่</td>
                            <td width="350" bgcolor="#EEEEEE"><label> <?php echo $row1["mem_address"]; ?></label></td>
                        </tr>
                        <tr>
                            <td width="22%" bgcolor="#EEEEEE">จังหวัด</td>
                            <td width="300" bgcolor="#EEEEEE"><label> <?php echo $row1["mem_add_province"]; ?></label></td>
                        </tr>
                        <tr>
                            <td width="22%" bgcolor="#EEEEEE">เขต/อำเภอ</td>
                            <td width="300" bgcolor="#EEEEEE"><label> <?php echo $row1["mem_add_amphur"]; ?></label></td>
                        </tr>
                        <tr>
                            <td width="22%" bgcolor="#EEEEEE">แขวง/ตำบล</td>
                            <td width="300" bgcolor="#EEEEEE"><label> <?php echo $row1["mem_add_district"]; ?></label></td>
                        </tr>
                        <tr>
                            <td width="22%" bgcolor="#EEEEEE">รหัสไปรษณีย์</td>
                            <td width="300" bgcolor="#EEEEEE"><label> <?php echo $row1["mem_add_zipcode"]; ?></label></td>
                        </tr>
                        <tr>
                            <td bgcolor="#EEEEEE">เบอร์ติดต่อ</td>
                            <td bgcolor="#EEEEEE"><?php echo $row1["mem_tel"]; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><a href="confirm.php?act=addnew"><input type="button" class="btn_main" value="จัดส่งที่อยู่อื่น"></a> </td>
                        </tr>
                        <?php if ($act == "addnew") { ?>
                            <tr>
                                <td><input type="hidden" name="addnew" value="1"></td>

                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>ที่อยู่</label></div>
                                </td>
                                <td>
                                    <div align="left"><textarea name="add_address" cols="30" rows="4" placeholder="กรุณากรอกรายละเอียดที่อยู่" required></textarea></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>จังหวัด</label></div>
                                </td>
                                <td>
                                    <div align="left"><select name="province" id="province">
                                            <option>- กรุณาเลือกจังหวัด -
                                            </option>
                                        </select></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>เขต/อำเภอ</label></div>
                                </td>
                                <td>
                                    <div align="left"><select name="amphur" id="amphur">
                                            <option value="name">- กรุณาเลือกอำเภอ -</option>
                                        </select></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>แขวง/ตำบล</label></div>
                                </td>
                                <td>
                                    <div align="left"><select name="district" id="district">
                                            <option>- กรุณาเลือกตำบล -</option>
                                        </select></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>รหัสไปรษณีย์</label></div>
                                </td>
                                <td>
                                    <div align="left"><input name="postcode" id="postcode" placeholder="รหัสไปรษณีย์"></div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><a href="confirm.php"><input type="button" class="btn_red" value="ปิด"></a></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2" align="center">
                                <a href="cart.php?p_id=$row[p_id]"><input type="button" class="btn_sys" value="กลับไปหน้าตะกร้า" /></a>
                                <input type="submit" name="Submit2" class="btn_green" value="สั่งซื้อ" />

                            </td>
                        </tr>
                    </table>
                    <br>



                </form>
            </div>
        </div>

        <div class="footer">

            <p>© 2020 RIVER @ WANG LANG</p>

        </div>
    </div>
    <script src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="AutoProvince.min.js"></script>
    <script>
        $('body').AutoProvince({
            PROVINCE: '#province', // select div สำหรับรายชื่อจังหวัด
            AMPHUR: '#amphur', // select div สำหรับรายชื่ออำเภอ
            DISTRICT: '#district', // select div สำหรับรายชื่อตำบล
            POSTCODE: '#postcode', // input field สำหรับรายชื่อรหัสไปรษณีย์
            GEOGRAPHY: '#geography', // input field แสดงภาค
            CURRENT_PROVINCE: 1, //  แสดงค่าเริ่มต้น ใส่ไอดีจังหวัดที่เคยเลือกไว้
            CURRENT_AMPHUR: 1, // แสดงค่าเริ่มต้น  ใส่ไอดีอำเภอที่เคยเลือกไว้
            CURRENT_DISTRICT: 1, // แสดงค่าเริ่มต้น  ใส่ไอดีตำบลที่เคยเลือกไว้
            arrangeByName: true // กำหนดให้เรียงตามตัวอักษร
        });
    </script>

    <script type="text/javascript">
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        });
    </script>
</body>

</html>