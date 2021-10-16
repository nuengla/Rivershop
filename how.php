<?php
session_start();
include "condb.php";
$p_id = $_GET['p_id'];
$act = $_GET['act'];
$page = $_REQUEST["page"];



if ($act == 'add' && !empty($p_id)) {
    if (!isset($_SESSION['cart'])) {

        $_SESSION['cart'] = array();
    } else {
    }
    if (isset($_SESSION['cart'][$p_id])) {
        $_SESSION['cart'][$p_id]++;
    } else {
        $_SESSION['cart'][$p_id] = 1;
    }
}

if ($act == 'remove' && !empty($p_id)) {

    unset($_SESSION['cart'][$p_id]);
}

if ($act == 'update') {

    $amount_array = $_POST['amount'];
    if (empty($amount_array)) {
        echo "<script>";
        echo "alert(\"ไม่มีสินค้าในตะกร้า\");";
        echo "window.location='cart.php'";
        echo "</script>";
    }
    foreach ($amount_array as $p_id => $amount) {

        $_SESSION['cart'][$p_id] = $amount;
    }
}
?>
<?php
include("condb.php");
$id = $_SESSION['mem_id'];
$name = $_SESSION['mem_name'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="shortcut icon" href="img_web/favicon.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="all" href="style.css" />
    <link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/lightbox.min.css">
    <title>RIVER-SHOP</title>
</head>

<body>

    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php
        if (empty($id)) { ?>

            <div class="navbar">
                <div class="navmenu">
                    <ul>

                        <li><?php
                            if ($id == "") {

                                echo "<a href='index.php'>" . "หน้าแรก" . "</a>";
                            } else {
                                echo "<a href='index_mem.php'>" . "กลับสู่หน้าหลัก" . "</a>";
                            } ?>
                        </li>

                        <li><a href="cart.php">ตะกร้าสินค้า(<?php
                                                    session_start();
                                                    $cart = $_SESSION['cart'];
                                                    if(empty($cart)){
                                                        $cart = 0;
                                                        echo $cart;
                                                    }else{
                                                        echo count($cart);
                                                    }

                                                    ?>)</a></li>
                        <li><a href="#">ช่วยเหลือ</a>
                            <ul>
                                <li><a href="tb_size.php">-ตารางวัดไซส์</a></li>
                                <li><a href="how.php?page=shop">-วิธีสั่งสินค้า</a></li>
                                <li><a href="how.php?page=pay">-วิธีชำระเงิน</a></li>
                                <li><a href="how.php?page=regis">-วิธีสมัครสมาชิก</a></li>

                            </ul>
                        </li>
                        <li><a href="#">เกี่ยวกับเรา</a>
                        <ul>
                            <li><a href="about.php?page=me">-ติดต่อเรา</a></li>
                            <li><a href="about.php?page=map">-แผนที่ร้าน</a></li>
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
        <?php } else {
            $sql1 = "SELECT * FROM member WHERE mem_id=$id ";
            $result1 = mysqli_query($con, $sql1);
            $row1 = mysqli_fetch_array($result1);
        ?>

<?php include "navbarmemin.php"?>
        <?php } ?>
        <div class="conten"><br>
            
            <br>

            <div align="center">
<?php if($page=="regis"){?>
            <h1>วิธีสมัครสมาชิก</h1>
            <table width="700" >
                <tr>
                    <td align="left">1. กดปุ่มสมัครสมาชิก<br><br></td>
                </tr>
                <tr>
                    <td  align="center">
                    <a class="example-image-link" href="img_web/regis1.png" 
data-lightbox="example-1"><img src="img_web/regis1.png" style="width:700px;height:auto;"></a>
                       <br><br><hr>
                </td>
            </tr>
            <tr>
                    <td align="left"><br>
                        2. กรอกรายละเอียดในแต่ละช่องให้ครบ<br><br></td>
                </tr>
                <tr>
                    <td align="center">
                    <a class="example-image-link" href="img_web/regis2.png" 
data-lightbox="example-1"><img src="img_web/regis2.png" style="width:700px;height:auto;"></a>
                   <br><br><hr>
                </td>
            </tr><tr>
                    <td align="left"><br> 3. กดปุ่มสมัครสมาชิก<br><br></td>
                </tr>
                <tr>
                    <td align="center">
                    <a class="example-image-link" href="img_web/regis3.png" 
data-lightbox="example-1"><img src="img_web/regis3.png" style="width:700px;height:auto;"></a><br><br><hr>
                </td>
            </tr><tr>
                    <td align="left"><br> 4. เสร็จสิ้น<br><br></td>
                </tr>
                <tr>
                    <td align="center">
                    <a class="example-image-link" href="img_web/regis4.png" 
data-lightbox="example-1"><img src="img_web/regis4.png" style="width:700px;height:auto;"></a>
                </td>
            </tr>
            </table>
            
            <?php }elseif($page=="pay"){?>
                <h1>วิธีแจ้งชำระเงิน</h1>
                <table width="700" >
                <tr>
                    <td align="left"><br> 1. เข้าสู่ระบบ <a href="how.php?page=regis" style="color:red;">(เรียนรู้การสมัครสมาชิก)</a>
                   <br><br>
                 </td>
                </tr>
                <tr>
                    <td  align="center">
                    <a class="example-image-link" href="img_web/howorder1.png" 
data-lightbox="example-1"><img src="img_web/howorder1.png" style="width:700px;height:auto;"></a><br><br>
<a class="example-image-link" href="img_web/howorder1-1.png" 
data-lightbox="example-1"><img src="img_web/howorder1-1.png" style="width:700px;height:auto;"></a>
                       <br><br><hr>
                </td>
            </tr>
            <tr>
                    <td align="left"><br>
                        2. กดปุ่มแจ้งชำระค่าสินค้า<br><br></td>
                </tr>
                <tr>
                    <td align="center">
                    <a class="example-image-link" href="img_web/howpay2.png" 
data-lightbox="example-1"><img src="img_web/howpay2.png" style="width:700px;height:auto;"></a>
                   <br><br><hr>
                </td>
            </tr><tr>
                    <td align="left"><br> 3. เลือกการสั่งซื้อที่ต้องการชำค่าสินค้าและกดปุ่มชำระเงิน<br><br></td>
                </tr>
                <tr>
                    <td align="center">
                    <a class="example-image-link" href="img_web/howpay3.png" 
data-lightbox="example-1"><img src="img_web/howpay3.png" style="width:700px;height:auto;"></a><br><br><hr>
                </td>
            </tr><tr>
                    <td align="left"><br> 4. ตรวจสอบรายละเอียดการสั่งสินค้า<br><br></td>
                </tr>
                <tr>
                    <td align="center">
                    <a class="example-image-link" href="img_web/howpay4.png" 
data-lightbox="example-1"><img src="img_web/howpay4.png" style="width:700px;height:auto;"></a><br><br><hr>
                </td>
            </tr>
            <tr>
                    <td align="left"><br> 5. กรอกข้อมูลในการชำระค่าสินค้าพร้อมแนบหลักฐานการโอนเงิน<br><br></td>
                </tr>
                <tr>
                    <td align="center">
                    <a class="example-image-link" href="img_web/howpay5.png" 
data-lightbox="example-1"><img src="img_web/howpay5.png" style="width:700px;height:auto;"></a><br><br><hr>
                </td>
            </tr>
            <tr>
                    <td align="left"><br> 6. เสร็จสิ้น<br><br></td>
                </tr>
                <tr>
                    <td align="center">
                    <a class="example-image-link" href="img_web/howpay6.png" 
data-lightbox="example-1"><img src="img_web/howpay6.png" style="width:700px;height:auto;"></a>
                </td>
            </tr>
            
            </table>
            <?php }elseif($page=="shop"){?>
                <h1>วิธีสั่งสินค้า</h1>
                <table width="700" >
                <tr>
                    <td align="left"><br> 1. เข้าสู่ระบบ <a href="how.php?page=regis" style="color:red;">(เรียนรู้การสมัครสมาชิก)</a>
                   <br><br>
                 </td>
                </tr>
                <tr>
                    <td  align="center">
                    <a class="example-image-link" href="img_web/howorder1.png" 
data-lightbox="example-1"><img src="img_web/howorder1.png" style="width:700px;height:auto;"></a><br><br>
<a class="example-image-link" href="img_web/howorder1-1.png" 
data-lightbox="example-1"><img src="img_web/howorder1-1.png" style="width:700px;height:auto;"></a>
                       <br><br><hr>
                </td>
            </tr>
            
            <tr>
                    <td align="left"><br> 2. เลือกสินค้า 
                   <br><br> </td>
                </tr>
                <tr>
                    <td  align="center">
                    <a class="example-image-link" href="img_web/howorder2.png" 
data-lightbox="example-1"><img src="img_web/howorder2.png" style="width:700px;height:auto;"></a>
                       <br><br><hr>
                </td>
            </tr>
            <tr>
                    <td align="left"> <br> 3. เลือกไซส์และกดปุ่มเพิ่มลงตะกร้า <br><br>
                    </td>
                </tr>
                <tr>
                    <td  align="center">
                    <a class="example-image-link" href="img_web/howorder3.png" 
data-lightbox="example-1"><img src="img_web/howorder3.png" style="width:700px;height:auto;"></a>
                       <br><br><hr>
                </td>
            </tr>
            <tr>
                    <td align="left"> <br> 4. เลือกจำนวนและถ้าไม่ต้องการสินค้ากดปุ่มลบสินค้าได้ กรณีลูกค้าเพิ่มหรือลดจำนวนสินค้ากรุณากดปุ่มคำนวณราคาด้วย เสร็จแล้วกดปุ่มยืนยัน
                   <br><br> </td>
                </tr>
                <tr>
                    <td  align="center">
                    <a class="example-image-link" href="img_web/howorder4.png" 
data-lightbox="example-1"><img src="img_web/howorder4.png" style="width:700px;height:auto;"></a>
                       <br><br><hr>
                </td>
            </tr>
            <tr>
                    <td align="left"><br> 5. เลือกรูปแบบการจัดส่ง ตรวจสอบสินค้าและที่อยู่ในการจัดส่ง
                   <br><br> </td>
                </tr>
                <tr>
                    <td  align="center">
                    <a class="example-image-link" href="img_web/howorder5.png" 
data-lightbox="example-1"><img src="img_web/howorder5.png" style="width:700px;height:auto;"></a><br><br>
                <p>กรณีจัดส่งที่อยู่อื่นกดปุ่มจัดส่งที่อยู่อื่นและกรอกข้อมูลที่อยู่ในการจัดส่ง เสร็จแล้วกดปุ่มยืนยัน</p><br>
                <a class="example-image-link" href="img_web/howorder5.1.png" 
data-lightbox="example-1"><img src="img_web/howorder5.1.png" style="width:700px;height:auto;"></a>

                       <br><br><hr>
                </td>
            </tr>
            <tr>
                    <td align="left"><br> 6. เสร็จสิ้น
                   <br><br> </td>
                </tr>
                <tr>
                    <td  align="center">
                    <a class="example-image-link" href="img_web/howorder6.png" 
data-lightbox="example-1"><img src="img_web/howorder6.png" style="width:700px;height:auto;"></a>
                       <br><br>
                </td>
            </tr>
            </table>
            <?php }?>
            </div>
          <br>
          <br>
        </div>


        <div class="footer">

            <p>© 2020 RIVER @ WANG LANG</p>
          

        </div>

</div>
<script src="dist/js/lightbox-plus-jquery.min.js"></script>
</body>

</html>