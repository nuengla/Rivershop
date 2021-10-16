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
            $YY = $_POST['select'];
            if (empty($YY)) {
            $sql1 = "SELECT SUM(od_prounit)AS od_prounit,SUM(od_totalprice)AS od_totalprice,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 AND YEAR(orders.o_date) = '2020' GROUP BY DATE_FORMAT(orders.o_date,'%M%') ORDER BY orders.o_date  ";
            $result = mysqli_query($con, $sql1);
            $sql11 = "SELECT SUM(od_prounit)AS od_prounit,SUM(od_totalprice)AS od_totalprice,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 AND YEAR(orders.o_date) = '2020' GROUP BY DATE_FORMAT(orders.o_date,'%M%') ORDER BY orders.o_date  ";
            $result1 = mysqli_query($con, $sql11);
        }
            else {
                $sql1 = "SELECT SUM(od_prounit)AS od_prounit,SUM(od_totalprice)AS od_totalprice,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 AND YEAR(orders.o_date) = '$YY' GROUP BY DATE_FORMAT(orders.o_date,'%M%') ORDER BY orders.o_date  ";
                $result = mysqli_query($con, $sql1);
                $sql11 = "SELECT SUM(od_prounit)AS od_prounit,SUM(od_totalprice)AS od_totalprice,p_id,s_id,o_date FROM orderdt,orders WHERE orderdt.o_id=orders.o_id AND orders.s_id=3 AND YEAR(orders.o_date) = '$YY' GROUP BY DATE_FORMAT(orders.o_date,'%M%') ORDER BY orders.o_date  ";
                $result1 = mysqli_query($con, $sql11);
            }
            
            ?>

            <h1>รายงานกราฟ</h1>
            <h4>(ยอดขายจะแสดงเฉพาะการสั่งซื้อที่ชำระเงินและจัดส่งแล้วเท่านั้น)</h4>
            <form action="" method="POST">
                    <label for="select"></label>
                    <select name="select" size="1" id="select">
                    <option value="">กรุณาเลือกปี</option>
                        <?php 
                        $dttmop = date('Y');
                        for($i=$dttmop; $i>=2006; $i--){?>
                        
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php }?>
                    </select>
                    &nbsp;<input type="submit" value="เลือก">
                </form>
            <?php
            //for chart
            $datesave = array();
            $totol = array();

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

            
                $datesave[] = "\"" . $datnew . "\"";
                $totol[] = "\"" . $rs['od_prounit'] . "\"";
                $totol1[] = "\"" . $rs['od_totalprice'] . "\"";
            }
            $datesave = implode(",", $datesave);
            $totol = implode(",", $totol);
            if(empty($totol1)){
                $totol2 = 0;
            }else{
                $totol2 = implode(",", $totol1);
            }
           
            ?>
           <br><div>ประจำปี <?php if(empty($YY)){ echo "2020"; } else { echo $YY; }?></div>
            <table width=50% border="1" cellpadding="0" cellspacing="0" align="center" style="border-color: white;">
                <thead>
                    <tr>
                        <th width="20%" bgcolor="#00f0ff">เดือน</th>
                        <th width="30%" bgcolor="#00f0ff">จำนวนยอดขาย(ชิ้น)</th>
                        <th width="50%" bgcolor="#00f0ff">จำนวนยอดขาย(บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($row = mysqli_fetch_array($result1)) {
                        $dttm1 = $row["o_date"];
                        $dttm = date('m', strtotime($dttm1));
                        if ($dttm == "02") {
                            $m = "กุมภาพันธ์";
                        } elseif ($dttm == "03") {
                            $m = "มีนาคม";
                        } elseif ($dttm == "01") {
                            $m = "มกราคม";
                        } elseif ($dttm == "04") {
                            $m = "เมษายน";
                        } elseif ($dttm == "05") {
                            $m = "พฤษภาคม";
                        } elseif ($dttm == "06") {
                            $m = "มิถุนายน";
                        } elseif ($dttm == "07") {
                            $m = "กรกฎาคม";
                        } elseif ($dttm == "08") {
                            $m = "สิงหาคม";
                        } elseif ($dttm == "09") {
                            $m = "กันยายน";
                        } elseif ($dttm == "10") {
                            $m = "ตุลาคม";
                        } elseif ($dttm == "11") {
                            $m = "พฤศจิกายน";
                        } elseif ($dttm == "12") {
                            $m = "ธันวาคม";
                        }
                    ?>
                        <tr>
                            <td align="center" bgcolor="#EAEAEA"><?php echo $m; ?></td>
                            <td align="right" bgcolor="#EAEAEA"><?php echo number_format($row['od_prounit']); ?>&nbsp;</td>
                            <td align="right" bgcolor="#EAEAEA"><?php echo number_format($row['od_totalprice']); ?>&nbsp;</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
<div>
    <br>
</div>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
            <hr>
            <p align="center">

              

                <canvas id="myChart" width="80%" height="25%"></canvas>
                <script>
                    var ctx = document.getElementById("myChart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: [<?php
                                        $d = date('d', strtotime($datesave));
                                        $m1 = date('m', strtotime($datesave));
                                        $y = date('Y', strtotime($datesave));
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
                                        echo $datesave ?>

                            ],
                            datasets: [{
                                label: 'รายงานยอดขายภาพรวม แยกตามเดือน (ชิ้น)' ,
                                data: [<?php echo $totol; ?>],
                               
                              
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(0,0,255,1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 5
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                </script>
            </p>
         
<hr>
<br>
<p align="center">

              

<canvas id="myChart1" width="80%" height="25%"></canvas>
<script>
    var ctx1 = document.getElementById("myChart1").getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: [<?php
                        $d = date('d', strtotime($datesave));
                        $m1 = date('m', strtotime($datesave));
                        $y = date('Y', strtotime($datesave));
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
                        echo $datesave ?>

            ],
            datasets: [{
                label: 'รายงานยอดขายภาพรวม แยกตามเดือน (บาท)' ,
                data: [<?php echo $totol2; ?>],
               
              
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(0,0,255,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 5
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

</script>
</p>



        </div>

        <div class="footer">

            <p>© 2020 RIVER @ WANG LANG</p>

        </div>
    </div>
</body>

</html>