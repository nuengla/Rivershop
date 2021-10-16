<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="all" href="style.css" />
    <link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="img_web/favicon.png" />
    <link rel="stylesheet" href="dist/css/lightbox.min.css">

    <title>RIVER-SHOP</title>

    <style type="text/css">
        .photo {
            width: 380px;
            height: 420px;
        }

        .photo1 {
            width: 580px;
            height: 620px;
        }
        
      
    </style>
</head>

<body>
    <?php
    session_start();
    include("condb.php");
    $id = $_SESSION['mem_id'];
    $name = $_SESSION['mem_name'];
    $level = $_SESSION['mem_type'];
    ?>
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
                                echo "<a href='index_mem.php'>" . "หน้าแรก" . "</a>";
                            } ?>
                        </li>
                        <li><a href="cart.php">ตะกร้าสินค้า (<?php
                                                                session_start();
                                                                $cart = $_SESSION['cart'];
                                                                if (empty($cart)) {
                                                                    $cart = 0;
                                                                    echo $cart;
                                                                } else {
                                                                    echo count($cart);
                                                                }

                                                                ?>)</a></li>
                        <li><a href="#">ช่วยเหลือ</a>
                            <ul>
                                <li><a href="tb_size.php">-ตารางวัดไซส์</a></li>
                                <li><a href="#">-วิธีสั่งสินค้า</a></li>
                                <li><a href="#">-วิธีชำระเงิน</a></li>
                                <li><a href="#">-วิธีสมัครสมาชิก</a></li>

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

            <div class="navbar">
                <div class="navmenu">
                    <ul>
                        <li><a href="index_mem.php">หน้าแรก</a></li>
                        <li><a href="#">ยินดีต้อนรับคุณ : <b><?php echo $row1['mem_name']; ?></b> </a>
                            <ul>
                                <li><a href="edit_mem.php">-แก้ไขข้อมูลส่วนตัว</a></li>
                                <li><a href="mem_order.php">-ประวัติการสั่งซื้อ</a></li>
                                <li><a href="payment.php">-แจ้งชำระค่าสินค้า</a></li>

                            </ul>
                        </li>
                        <li><a href="cart.php">ตะกร้าสินค้า (<?php
                                                                session_start();
                                                                $cart = $_SESSION['cart'];
                                                                if (empty($cart)) {
                                                                    $cart = 0;
                                                                    echo $cart;
                                                                } else {
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

                        <li><a href="logout.php">ออกจากระบบ</a></li>
                    </ul>
                </div>
            </div>
        <?php } ?>
        <div class="conten"><br>

            <h1>รายละเอียดสินค้า</h1><br>
            <div class="contanner">
                <div class="area_grid">
                    <?php

                    include "condb.php";
                    $p_code = $_GET['p_code'];
                    $p_code1 = $_POST['p_code'];
                    //$ps_id = "2";
                    $sql2 = "SELECT * FROM product,pro_type WHERE product.pt_id=pro_type.pt_id AND p_code=$p_code";
                    $result2 = mysqli_query($con, $sql2);
                    $row2 = mysqli_fetch_array($result2);
                    $sql = "SELECT * FROM product,pro_size,pro_type WHERE p_code=$p_code AND product.ps_id=pro_size.ps_id AND product.pt_id=pro_type.pt_id";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_array($result);
                    $rowprice = $row["p_price"];
                    $rowprice_promo = $row["p_price_promotion"]; ?>
                    <div class="grid_item">
                        <div class="item" align="center">

                        <a class="example-image-link" href="img/<?php echo $row["p_img"]  ?>" 
data-lightbox="example-1"><img src="img/<?php echo $row["p_img"]  ?>" class="photo"></a>
                            
                            
                            
                            <br>
                            คะแนนโดยเฉลี่ย : <?php
                            $rating = "SELECT * FROM rating WHERE p_code='$p_code'";
                            $resultrating = mysqli_query($con, $rating);
                            $rowrati = mysqli_fetch_array($resultrating);
                            $r1 =  $rowrati["rat_1"];
                            $r2 = $rowrati["rat_2"];
                            $r3 = $rowrati["rat_3"];
                            $r4 = $rowrati["rat_4"];
                            $rr1 = $r1 * 1;
                            $rr2 = $r2 * 2;
                            $rr3 = $r3 * 3;
                            $rr4 = $r4 * 4;
                            $rcount = $r1 + $r2 + $r3 + $r4;
                            if($rcount==0){
                                echo "ไม่มีคะแนน";
                            }else{
                            $rrcal =  $rr1 + $rr2 + $rr3 + $rr4;
                            $rcal = $rrcal / $rcount;
                            
                            
                            
                            
                            if($rcal<1.75){
                                echo "<img src='img_web/star.png' style='width:20px;height:20px;''>";
                            }elseif($rcal>1.74&&$rcal<2.5){
                                echo "<img src='img_web/star.png' style='width:20px;height:20px;''>
                                <img src='img_web/star.png' style='width:20px;height:20px;''>";
                            }elseif($rcal>2.4&&$rcal<3.25){
                                echo "<img src='img_web/star.png' style='width:20px;height:20px;''>
                                <img src='img_web/star.png' style='width:20px;height:20px;''>
                                <img src='img_web/star.png' style='width:20px;height:20px;''>";
                            }elseif($rcal>3.24&&$rcal<4.1){
                                echo "<img src='img_web/star.png' style='width:20px;height:20px;''>
                                <img src='img_web/star.png' style='width:20px;height:20px;''>
                                <img src='img_web/star.png' style='width:20px;height:20px;''>
                                <img src='img_web/star.png' style='width:20px;height:20px;''>";
                            }}

                            ?><br><?php
                            if(empty($id)){
                                echo "<br>";
                            }else{
                            ?>
                            ให้คะแนนสินค้า <form action="query.php" method="post">
                                <table>
                                    <tr>
                                        <td align="left">
                                            <input type="radio" name="rating" value="100" required>
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"><input type="radio" name="rating" value="75" required>
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"><input type="radio" name="rating" value="50" required>
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"><input type="radio" name="rating" value="25" required>
                                            <img src="img_web/star.png" style="width:10px;height:10px;">
                                           
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" name="p_code" value="<?php echo $p_code;?>">
                                <input type="hidden" name="act" value="vote">
                                <input type="submit" class="btn_gold" value="ให้คะแนน">
                            </form><br>
                            <?php }?>

                        </div>
                    </div>

                    <div class="grid_item">
                        <div class="item" align="center">

                            <?php
                            echo "<h2>" . $row['p_name'] . "</h2>";
                            if ($rowprice_promo >= $rowprice || $rowprice_promo == 0) {
                                echo "<div class='detail_pro'>" . "ราคา : " . number_format($row["p_price"], 2) . " บาท" . "</div>" . "<br>";
                            } else {
                                $pr =  $rowprice_promo * 100;
                                $pr1 = $pr / $rowprice;
                                $salepercent1  =    100 - $pr1;
                                $salepercent = floor($salepercent1);
                                if ($salepercent == 0) {
                                    $salepercent = number_format($salepercent1, 1);
                                }
                                echo "<div class='detail_pro'><s>" . "ราคา : " . number_format($row["p_price"], 2) . " บาท" . "</s></div>";
                                echo "<div class='detail_pro'>" . "ราคาโปรโมชั่น : <font color='red'>" . number_format($row["p_price_promotion"], 2) . "</font> บาท (-" . $salepercent . "%)" . "</div>" . "<br>";
                            }
                            echo "<div class='detail_pro'>" . "ประเภทสินค้า : " . $row['pt_name'] . "</div>" . "<br>";
                             ?><table>
                                 <tr>
                                     <td width="300" align="left">รายละเอียดสินค้า : <?php echo $row["p_detail"];?></td>
                                 </tr>
                             </table><br>


                            <table border="1">
                                <?php if ($row["pt_size"] == "2") { ?>

                                    <tr>
                                        <td colspan="2" bgcolor="#EEEEEE" width="180">สินค้าคงเหลือ</td>
                                    </tr>
                                    <tr>
                                        <td >จำนวนคงเหลือ</td>
                                        <td  width="50"><?php echo $row["p_qty"]; ?></td>
                                    </tr>

                                <?php
                                } elseif ($row["pt_size"] == "1" || "3") { ?>
                                    <tr>
                                        <td bgcolor="#EEEEEE" colspan="5">สินค้าคงเหลือ</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#EEEEEE">ขนาด</td>
                                        <td bgcolor="#EEEEEE" width="30">S</td>
                                        <td bgcolor="#EEEEEE" width="30">M</td>
                                        <td bgcolor="#EEEEEE" width="30">L</td>
                                        <td bgcolor="#EEEEEE" width="30">XL</td>
                                    </tr>
                                    <tr>
                                        <td>จำนวนคงเหลือ</td>
                                        <?php
                                        include "condb.php";
                                        $sqls = "SELECT * FROM product WHERE p_code=$p_code AND ps_id='1'";
                                        $results = mysqli_query($con, $sqls);
                                        $rows = mysqli_fetch_array($results);
                                        $sqlm = "SELECT * FROM product WHERE p_code=$p_code AND ps_id='2'";
                                        $resultm = mysqli_query($con, $sqlm);
                                        $rowm = mysqli_fetch_array($resultm);
                                        $sqll = "SELECT * FROM product WHERE p_code=$p_code AND ps_id='3'";
                                        $resultl = mysqli_query($con, $sqll);
                                        $rowl = mysqli_fetch_array($resultl);
                                        $sqlxl = "SELECT * FROM product WHERE p_code=$p_code AND ps_id='4'";
                                        $resultxl = mysqli_query($con, $sqlxl);
                                        $rowxl = mysqli_fetch_array($resultxl); ?>
                                        <td><?php echo number_format($rows["p_qty"]); ?></td>
                                        <td><?php echo number_format($rowm["p_qty"]); ?></td>
                                        <td><?php echo number_format($rowl["p_qty"]); ?></td>
                                        <td><?php echo number_format($rowxl["p_qty"]); ?></td>
                                    </tr>

                                <?php } ?>
                            </table>

                            <?php if ($row["pt_size"] == "2") { ?>
                                <form action="query.php" method="POST">
                                    <input type="hidden" name="p_code" value="<?php echo $p_code; ?>">
                                    <input type="hidden" name="size" value="<?php echo $row["ps_id"]; ?>">
                                    <input type="hidden" name="act" value="add">
                                    <br><input type='submit' class='btn_main' value='เพิ่มลงตะกร้า'>
                                </form>


                            <?php } elseif ($row["pt_size"] == "1" || "3") { ?><br>
                            <?php echo "<div >"."<a href='tb_size.php' style='color:blue; text-decoration: none;'>แนะนำในการเลือกไซส์</a>" . "<form action='query.php?act=add' method='POST'>";
                                $sql1 = "SELECT * FROM product,pro_size WHERE p_code=$p_code AND product.ps_id=pro_size.ps_id AND p_qty>0";
                                $result1 = mysqli_query($con, $sql1);

                                echo "<input type='hidden' name='p_code' value='" . $row['p_code'] . "'>";
                                echo "<input type='hidden' name='act' value='add'>";

                                echo "<span>กรุณาเลือกขนาด </span><select name='size'>";
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    echo "<option value='" . $row1['ps_id'] . "'>" . $row1['ps_name'] . "</option>";
                                }
                                echo "</select>";

                                echo "<br><label style=color:#FF0000>*ขนาดที่แสดงขึ้นอยู่กับสินค้าคงเหลือ</label>";

                                //echo "<input type='hidden' name='p_id' value='".$row1['p_id']."'>";
                                echo "<br><br><input type='submit' class='btn_main'  value='เพิ่มลงตะกร้า'>";

                                echo "</form>";
                                echo "<br>";
                                echo "</div>";
                            }

                            ?>



                            <br>


                        </div>
                    </div>

                </div>
            </div>

        </div>
        

        <div class="footer">

            <p>© 2020 RIVER @ WANG LANG</p>

        </div>
    </div>

    <script src="dist/js/lightbox-plus-jquery.min.js"></script>
</body>

</html>