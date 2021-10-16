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
    $delet7 = "DELETE FROM address_ WHERE o_id=$o_id";
    $result7 = mysqli_query($con,$delet7);
}
if ($result4 && $result5 && $query5&&$result6&&$result7) {
    echo "<script>";

    echo "window.location='index_mem.php'";
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
    <link rel="stylesheet" href="owl-carousel/owl.theme.css">
    <link rel="stylesheet" href="owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="dist/css/lightbox.min.css">


    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

    <title>RIVER-SHOP</title>
</head>
<style type="text/css">
    .link1 a {
        text-decoration: none;
        display: block;



    }

    .link1 a :hover {

        color: white;
        background-color: blue;
        border-radius: 10px;
        /* text-shadow: none;
        display: block;*/
        display: block;

        text-align: center;


    }

    .link2 a {
        text-decoration: none;
    }

    .link2 a :hover {
        color: black;

    }
</style>

<body>

    <div class="container">
        <div class="banner">
            <img src="img_web/bannernew1.png ">
        </div>
        <?php include "navbarmem.php" ?>


        <div class="containernew">
            <div class="sidebar1">
                <br>
                <div align="center" class="link1">
                    <a href="?pro_new=1&pro_select=สินค้ามาใหม่">
                        <font color="black">
                            <h4> สินค้ามาใหม่ (NEW)<span>
                                    <img src="img_web/new.png" style="width:35px;height:30px;">
                                </h4>
                        </font>
                    </a><br>
                    <hr><br>
                    <a href="?pro_pro=1&pro_select=สินค้าโปรโมชั่น">
                        <font color="black">
                            <h4> สินค้าโปรโมชั่น (PROMOTION)<span>
                                    <img src="img_web/sale.png" style="width:35px;height:30px;">
                                </span> </h4>
                        </font>
                    </a><br>
                    <hr><br>
                    <a href="?pro_top=1&pro_select=สินค้าแนะนำ">
                        <font color="black">
                            <h4> สินค้าแนะนำ <br>(SUGGEST)<span>
                                    <img src="img_web/star.png" style="width:25px;height:25px;">
                                </span> </h4>
                        </font>
                    </a>

                </div>
                <br>
                <hr>
                <br>
                <h3><u>ประเภทสินค้า</u> </h3>

                <?php $sql2 = "SELECT * FROM pro_type";
                $result2 = mysqli_query($con, $sql2); ?>
                <div align="center" class="link2">
                    <table>
                        <?php
                        while ($row2 = mysqli_fetch_array($result2)) { ?>
                            <tr>
                                <td align="left"><a href="index_mem.php?pt_id=<?php echo $row2["pt_id"]; ?>&pro_select=<?php echo $row2["pt_name"]; ?>">
                                        <font color="blue">- <?php echo $row2["pt_name"]; ?></font>
                                    </a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <br>






            </div>
            <div class="conten1">
                <br>
                <?php
                $pro_select = isset($_GET['pro_select']) ? $_GET['pro_select'] : '';
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                ?>
                <h1>
                    <?php
                    if (empty($pro_select) && empty($search)) {
                        echo "สินค้ามาใหม่";
                    } elseif (!empty($pro_select)) {
                        echo $pro_select;
                    } elseif (!empty($search) && empty($pro_select)) {
                        echo "ผลการค้นหา";
                    }
                    ?>
                </h1>
                <?php
                $pro_pro = isset($_GET['pro_pro']) ? $_GET['pro_pro'] : '';
                $pro_top = isset($_GET['pro_top']) ? $_GET['pro_top'] : '';
                $pro_new = isset($_GET['pro_new']) ? $_GET['pro_new'] : '';
                $pt_id = isset($_GET['pt_id']) ? $_GET['pt_id'] : '';


                if (!empty($search)) {
                    $sql = "SELECT * FROM product
            WHERE p_name LIKE '%$search%'  GROUP BY p_code";
                    $result = mysqli_query($con, $sql);
                    $r = mysqli_num_rows($result);
                    if ($r == 0) {
                        $output = 'ไม่มีสินค้าที่ค้นหา';
                    }
                } elseif (!empty($pt_id)) {

                    $sql = "SELECT * FROM product WHERE  pt_id=$pt_id GROUP BY p_code";
                    $result = mysqli_query($con, $sql);
                    $r = mysqli_num_rows($result);
                    if ($r == 0) {
                        $output = 'ไม่มีสินค้าที่ค้นหา';
                    }
                } elseif (!empty($pro_top)) {

                    $sql = "SELECT * FROM product WHERE  p_sug=1 GROUP BY p_code";
                    $result = mysqli_query($con, $sql);
                } elseif (!empty($pro_new)) {

                    $sql = "SELECT * FROM product  GROUP BY p_code ORDER BY datesave DESC LIMIT 6";
                    $result = mysqli_query($con, $sql);
                } elseif (!empty($pro_pro)) {
                    $sql = "SELECT * FROM product WHERE p_price_promotion>0  GROUP BY p_code ";
                    $result = mysqli_query($con, $sql);

                } elseif (empty($search) && empty($pt_id) && empty($pro_top) && empty($pro_new)) {
                    $sql = "SELECT * FROM product   GROUP BY p_code ORDER BY datesave DESC LIMIT 6";
                    $result = mysqli_query($con, $sql);
                }
                echo $output;

              
                ?>

<marquee><font color="red">! ! ! การสั่งซื้อจะถูกยกเลิกภายใน 24 ชั่วโมงถ้าไม่มีการแจ้งชำระค่าสินค้า ! ! !</font></marquee>
                <section>

                    <div id="carousel">
                        <div id="owl-demo" class="owl-carousel owl-theme">

                            <?php

                                while ($row = mysqli_fetch_array($result)) {
                                    $code =  $row["p_code"];
                                    $s = "SELECT * FROM product  WHERE p_code = '$code' AND p_qty>0";
                                    $res = mysqli_query($con, $s);
                                    $ckqty = mysqli_num_rows($res);
                                    $rowprice = $row["p_price"];
                                    $rowprice_promo = $row["p_price_promotion"];
                                ?>


                                    <div class="item">
                                        <?php
                                        echo "<table  align='center' class='tb_product' >";
                                        echo "<tr>";
                                        echo "<td align='center'><img class='resize' src='img/" . $row["p_img"] . " 
                            ' width='50'></td>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        echo "<td align='center' width='200'><h3>" . $row["p_name"] . "</h3></td>";
                                        echo "</tr>";
                                        if ($rowprice_promo>$rowprice||$rowprice_promo==0||$rowprice_promo==$rowprice) {
                                            echo "<tr>";
                                            echo "<td align='center'>" . "ราคา " . number_format($row["p_price"], 2) . " บาท" . "</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td align='center'>โปรโมชั่น : -</td>";
                                            echo "</tr>";
                                        } else{
                                            $pr =  $rowprice_promo * 100;
                                            $pr1 = $pr / $rowprice;
                                            $salepercent1  =    100 - $pr1 ;
                                            $salepercent = floor($salepercent1);
                                            if($salepercent==0){
                                                $salepercent = number_format($salepercent1,1) ;
                                            }
                                            echo "<tr>";
                                            echo "<td align='center'><s>" . "ราคา " . number_format($row["p_price"], 2) . " บาท" . "</s></td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td align='center'>โปรโมชั่น : <font color='red'>" . number_format($row["p_price_promotion"], 2) . "</font> บาท (-".$salepercent."%)" . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                
                                        <tr>
                                            <?php if($ckqty=="0"||$ckqty<0){?>
                                                <td align='center'><input type='button' class='btn_red' value='สินค้าหมด'></td>
                                            <?php }else{?>
                                   <td align='center'><a href="product_detail.php?p_code=<?php echo $row["p_code"];?>"><input type='button' class='btn_main' value='เลือกสินค้า'></a></td>
                                            <?php }?>
                                </tr>   
                              <?php
                                       
                                        echo "<tr>";
                                        echo "<td align='center' height='10' > </td>";

                                        echo "</tr>";

                                        echo "</table>";

                                        ?>
                                        <div class="carousel-text">
                                            <div class="line">

                                            </div>
                                        </div>
                                    </div>
                            <?php  }
                             ?>


                        </div>
                    </div>
                </section>



            </div>
            <script type="text/javascript" src="owl-carousel/owl.carousel.js"></script>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $("#owl-demo").owlCarousel({
                        slideSpeed: 10,
                        autoPlay: true,
                        navigation: false,
                        pagination: false,
                        singleItem: true
                    });
                    $("#owl-demo2").owlCarousel({
                        slideSpeed: 10,
                        autoPlay: true,
                        navigation: false,
                        pagination: true,
                        singleItem: true
                    });
                });
            </script>


        </div>
        <div class="conten_side">
            <?php

            if (!empty($pt_id)) {
                $sqlmore = "SELECT * FROM product WHERE pt_id=$pt_id GROUP BY p_code ";
                $resultmore = mysqli_query($con, $sql);
                $row11 = mysqli_num_rows($resultmore);
            }elseif (!empty($pro_pro)) {
                $sqlmore = "SELECT * FROM product WHERE p_price_promotion>0  GROUP BY p_code ";
                $resultmore = mysqli_query($con, $sqlmore);
            }elseif (!empty($search)) {
                $sqlmore = "SELECT * FROM product
        WHERE p_name LIKE '%$search%'  GROUP BY p_code";
                $resultmore = mysqli_query($con, $sqlmore);
                
            }elseif (!empty($pro_new)) {

                $sqlmore = "SELECT * FROM product  GROUP BY p_code ORDER BY datesave DESC LIMIT 6";
                $resultmore = mysqli_query($con, $sqlmore);
            }elseif (!empty($pro_top)) {

                $sqlmore = "SELECT * FROM product WHERE p_sug=1 GROUP BY p_code";
                $resultmore = mysqli_query($con, $sqlmore);
            }
            
            elseif(empty($pro_new)&&empty($search)&&empty($pro_pro)&&empty($pt_id)&&empty($pro_new)){
                $sqlmore = "SELECT * FROM product  GROUP BY p_code ORDER BY datesave DESC LIMIT 0";
                $resultmore = mysqli_query($con, $sqlmore);
            }
            ?>
       
                <div class="contanner1">
                    <br>


                    <div class="area_grid1">

                        <?php $i=1;
                        while ($row1 = mysqli_fetch_array($resultmore)) {
                         $code =  $row1["p_code"];
                            $s = "SELECT * FROM product  WHERE p_code = '$code' AND p_qty>0";
                            $res = mysqli_query($con, $s);
                            $ckqty = mysqli_num_rows($res);
                            

                            
                            

                            $rowprice1 = $row1["p_price"];
                            $rowprice_promo1 = $row1["p_price_promotion"]; ?>
                            <div class="grid_item1">
                                <div class="item1" align="center">

                                    <?php
                                    echo "<br>" . "<table  align='center' class='tb_product' >";
                                    echo "<tr>";
                                    echo "<td align='center'>
                                    <a class='example-image-link' href='img/".$row1["p_img"]."' 
data-lightbox='example-".$i."'><img class='resize' src='img/" . $row1["p_img"] . " 
' width='50'></a></td>";
                                    
                                    
                                    
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td align='center' width='200'><h3>" . $row1["p_name"] . "</h3></td>";
                                    echo "</tr>";
                                    if ($rowprice_promo1>$rowprice1||$rowprice_promo1==0||$rowprice_promo1==$rowprice1) {
                                        echo "<tr>";
                                        echo "<td align='center'>" . "ราคา " . number_format($row1["p_price"], 2) . " บาท" . "</td>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        echo "<td align='center'>โปรโมชั่น : -</td>";
                                        echo "</tr>";
                                    } else{
                                        $pr =  $rowprice_promo1 * 100;
                                        $pr1 = $pr / $rowprice1;
                                        $salepercent1  =    100 - $pr1 ;
                                        $salepercent = floor($salepercent1);
                                        if($salepercent==0){
                                            $salepercent = number_format($salepercent1,1) ;
                                        }
                                        echo "<tr>";
                                        echo "<td align='center'><s>" . "ราคา " . number_format($row1["p_price"], 2) . " บาท" . "</s></td>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        echo "<td align='center'>โปรโมชั่น : <font color='red'>" . number_format($row1["p_price_promotion"], 2) . "</font> บาท (-".$salepercent."%)" . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                
                                        <tr>
                                            <?php if($ckqty=="0"||$ckqty<0){?>
                                                <td align='center'><input type='button' class='btn_red' value='สินค้าหมด'></td>
                                            <?php }else{?>
                                   <td align='center'><a href="product_detail.php?p_code=<?php echo $code;?>"><input type='button' class='btn_main' value='เลือกสินค้า'></a></td>
                                            <?php }?>
                                </tr>   
                              <?php
                                    
                                    echo "<tr>";
                                    echo "<td align='center' height='10' ></td>";

                                    echo "</tr>";

                                    echo "</table>";

                                    ?>

                                </div>
                            </div>
                        <?php $i++;} ?>
                    </div>
                </div>
                                          
          
        </div>
        <div class="cf"></div>
        <div class="footer">

            <p>© 2020 RIVER @ WANG LANG</p>

        </div>
    </div>
    <script src="dist/js/lightbox-plus-jquery.min.js"></script>
</body>

</html>