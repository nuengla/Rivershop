<?php
session_start();
include "condb.php";
$p_id = $_GET['p_id'];
$act = $_GET['act'];



?>
<?php
include("condb.php");
$id = $_SESSION['mem_id'];
$name = $_SESSION['mem_name'];

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
            <font size="9"><b> ตารางวัดไซส์</b></font>
            <br>
ิ<br>
            <div align="center">
                <a href="tb_size.php?act=t"><img src="img_web/เสื้อ.png"></a><a href="tb_size.php?act=l"><img src="img_web/กางเกง.png"></a>
            </div>
            <?php if($act=="t"){?>
                <div align = "center">
                    <?php include "size.php";?>
                </div>
            <?php }elseif($act=="l"){?>
                <div align = "center">
                    <?php include "size1.php";?>
                </div>
            <?php }?>
          <br>
          <br>
        </div>


        <div class="footer">

            <p>© 2020 RIVER @ WANG LANG</p>
          

        </div>

</div>

</body>

</html>