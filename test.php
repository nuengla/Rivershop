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

    <?php
    session_start();
    include("condb.php");
    $mem_id = $_SESSION['mem_id'];
    $mem_name = $_SESSION['mem_name'];
    $id = $_GET['id'];
    $act = $_REQUEST['act'];


    ?>

    <div class="container">
        <div class="banner">
            <img src="img_web/bannernew1.png ">
        </div>

        <?php include "navbar_admin.php"; ?>
        <div class="conten"><br>
            <?php


            $sql1 = "SELECT SUM(od_prounit)AS od_prounit,SUM(od_totalprice)AS od_totalprice,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 AND YEAR(orders.o_date) = '2020' GROUP BY DATE_FORMAT(orders.o_date,'%M%') ORDER BY orders.o_date  ";
            $result = mysqli_query($con, $sql1);
            // $sql11 = "SELECT SUM(od_prounit)AS od_prounit,SUM(od_totalprice)AS od_totalprice,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 AND YEAR(orders.o_date) = '2020' GROUP BY orderdt.p_id ORDER BY od_prounit DESC";
            //$result1 = mysqli_query($con, $sql11);


            ?>

            <h1>รายงานกราฟ</h1>

            <?php
            //for chart
            $datesave = array();
            $totol = array();

            ?>

            <table border="1">
                <tr>
                    <td>เดือน</td>
                    <td>p_id</td>

                </tr><?php
                        // // while ($rs = mysqli_fetch_array($result)) {
                        //     $dttm1 = $rs["o_date"];
                        //     $dttm = date('d/m/Y', strtotime($dttm1));
                        //     $d = date('d', strtotime($dttm1));
                        //     $m1 = date('m', strtotime($dttm1));
                        //     $y = date('Y', strtotime($dttm1));
                        //     if ($m1 == "02") {
                        //         $m2 = "กุมภาพันธ์";
                        //     } elseif ($m1 == "03") {
                        //         $m2 = "มีนาคม";
                        //     } elseif ($m1 == "01") {
                        //         $m2 = "มกราคม";
                        //     } elseif ($m1 == "04") {
                        //         $m2 = "เมษายน";
                        //     } elseif ($m1 == "05") {
                        //         $m2 = "พฤษภาคม";
                        //     } elseif ($m1 == "06") {
                        //         $m2 = "มิถุนายน";
                        //     } elseif ($m1 == "07") {
                        //         $m2 = "กรกฎาคม";
                        //     } elseif ($m1 == "08") {
                        //         $m2 = "สิงหาคม";
                        //     } elseif ($m1 == "09") {
                        //         $m2 = "กันยายน";
                        //     } elseif ($m1 == "10") {
                        //         $m2 = "ตุลาคม";
                        //     } elseif ($m1 == "11") {
                        //         $m2 = "พฤศจิกายน";
                        //     } elseif ($m1 == "12") {
                        //         $m2 = "ธันวาคม";
                        //     }
                        //     $datnew = $m2;



                        //     $sql11 = "SELECT SUM(od_prounit)AS od_prounit,SUM(od_totalprice)AS od_totalprice,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 AND MONTH(orders.o_date) = '$m1' GROUP BY orderdt.p_id ORDER BY od_prounit DESC";
                        //     $result1 = mysqli_query($con, $sql11);

                        ?>
                    <tr>
                        <td><?php //echo $datnew; ?></td>
                        <td><?php 
                        // while ($row = mysqli_fetch_array($result1)) {
                        //         $p = $row['p_id'];
                        //         $sql111 = "SELECT * FROM product WHERE p_id='$p' ";
                        //         $result11 = mysqli_query($con, $sql111);
                        //         $row1 = mysqli_fetch_array($result11);

                        //         echo $row1["p_code"] . " ";
                        //     } ?></td>

                    </tr>
                <?php //} ?>
            </table>










            <div class="contanner1">
                    <br>

                    <?php
                        while ($rs = mysqli_fetch_array($result)) {
                            $dttm1 = $rs["o_date"];
                            $dttm = date('d/m/Y', strtotime($dttm1));
                            $d = date('d', strtotime($dttm1));
                            $m1 = date('m', strtotime($dttm1));
                            $y = date('Y', strtotime($dttm1));
                            if ($m1 == "02") {
                                $m2 = "กุมภาพันธ์";
                            } elseif ($m1 == "03") {
                                $m2 = "มีนาคม";
                            } elseif ($m1 == "01") {
                                $m2 = "มกราคม";
                            } elseif ($m1 == "04") {
                                $m2 = "เมษายน";
                            } elseif ($m1 == "05") {
                                $m2 = "พฤษภาคม";
                            } elseif ($m1 == "06") {
                                $m2 = "มิถุนายน";
                            } elseif ($m1 == "07") {
                                $m2 = "กรกฎาคม";
                            } elseif ($m1 == "08") {
                                $m2 = "สิงหาคม";
                            } elseif ($m1 == "09") {
                                $m2 = "กันยายน";
                            } elseif ($m1 == "10") {
                                $m2 = "ตุลาคม";
                            } elseif ($m1 == "11") {
                                $m2 = "พฤศจิกายน";
                            } elseif ($m1 == "12") {
                                $m2 = "ธันวาคม";
                            }
                            $datnew = $m2;

                            echo "สินค้าขายดีประจำเดือน ".$m2;

                            $sql11 = "SELECT SUM(od_prounit)AS od_prounit,SUM(od_totalprice)AS od_totalprice,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 AND MONTH(orders.o_date) = '$m1' GROUP BY orderdt.p_id ORDER BY od_prounit DESC";
                            $result1 = mysqli_query($con, $sql11);

                        ?>
                    <div class="area_grid1">

                        <?php $i=1;
                        while ($row = mysqli_fetch_array($result1)) {
                            $p = $row['p_id'];
                             $sql111 = "SELECT * FROM product WHERE p_id='$p' ";
                          $result11 = mysqli_query($con, $sql111);
                         $row1 = mysqli_fetch_array($result11);
                         $code =  $row1["p_code"];
                         $sql1111 = "SELECT * FROM product WHERE p_code='$code' ";
                         $result111 = mysqli_query($con, $sql1111);
                        $row11 = mysqli_fetch_array($result111);

                      
                         
                            $s = "SELECT * FROM product  WHERE p_code = '$code' AND p_qty>0";
                            $res = mysqli_query($con, $s);
                            $ckqty = mysqli_num_rows($res);
                            

                          
                            

                            $rowprice1 = $row11["p_price"];
                            $rowprice_promo1 = $row11["p_price_promotion"]; ?>
                            <div class="grid_item1">
                                <div class="item1" align="center">

                                    <?php
                                    echo "<br>" . "<table  align='center' class='tb_product' >";
                                    echo "<tr>";
                                    echo "<td align='center'>
                                    <a class='example-image-link' href='img/".$row11["p_img"]."' 
data-lightbox='example-".$i."'><img class='resize' src='img/" . $row11["p_img"] . " 
' width='50'></a></td>";
                                    
                                    
                                    
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td align='center' width='200'><h3>" . $row11["p_name"] . "</h3></td>";
                                    echo "</tr>";
                                    if ($rowprice_promo1>$rowprice1||$rowprice_promo1==0||$rowprice_promo1==$rowprice1) {
                                        echo "<tr>";
                                        echo "<td align='center'>" . "ราคา " . number_format($row11["p_price"], 2) . " บาท" . "</td>";
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
                                        echo "<td align='center'><s>" . "ราคา " . number_format($row11["p_price"], 2) . " บาท" . "</s></td>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        echo "<td align='center'>โปรโมชั่น : <font color='red'>" . number_format($row11["p_price_promotion"], 2) . "</font> บาท (-".$salepercent."%)" . "</td>";
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
                                            <?php }?>
                </div>




        </div>

        <div class="footer">

            <p>© 2020 RIVER @ WANG LANG</p>

        </div>
    </div>
</body>

</html>