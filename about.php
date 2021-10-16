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
<?php if($page=="map"){?>
            <h1>แผนที่ร้าน</h1>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d968.8477949378882!2d100.4845039291747!3d13.755267802038944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29907acb2db1b%3A0x173e6fbaa6883e02!2z4LiV4Lil4Liy4LiU4LmA4Lin4Li04LmJ4LiH4Lib4Lij4Liw4LiV4Li54LmA4LiC4Li14Lii4Lin!5e0!3m2!1sth!2sth!4v1579759400716!5m2!1sth!2sth" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
            <?php }elseif($page=="me"){?>
                <h1>ติดต่อเรา</h1>
                <p>เจ้าของร้าน : นายนราธิป อาชวโศภณ</p>
                <p>เบอร์โทรศัพท์ : 0832234539</p>
                <p>LINE : 0832234539</p>
                <P>E-MAIL : calypso153@hotmail.com</P>
            <?php }?>
            </div>
          <br>
          <br>
        </div>


        <div class="footer">

            <p>© 2020 RIVER @ WANG LANG</p>
          

        </div>

</div>

</body>

</html>