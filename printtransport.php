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
<style type="text/css" media="print">
    /*@page { size: landscape; }*/
    * {

        font-size: 40px;
        font-family: 'Angsana new', sans-serif;
        box-sizing: border-box;
        background-color: white;
    }

    table {
        margin: auto auto auto auto;
    }

    @page {
        size: landscape;
        margin: 20px 20px;
    }
</style>

<body onload="window.print();">








    <?php
    session_start();
    include("condb.php");
    $mem_id = $_SESSION['mem_id'];
    $mem_name = $_SESSION['mem_name'];
    $o_id = $_GET['o_id'];
    $admin = $_GET['admin'];
    $page = $_GET['page'];
    $day = date('d/m/Y');
    $sql = "SELECT * FROM orderdt,product,pro_size,pro_type WHERE o_id=$o_id AND orderdt.p_id=product.p_id 
    AND product.ps_id=pro_size.ps_id AND product.pt_id=pro_type.pt_id";
    $result = mysqli_query($con, $sql);
    $sql1 = "SELECT * FROM orders,transport,member WHERE o_id=$o_id AND orders.t_id=transport.t_id AND orders.mem_id=member.mem_id";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $dttm1 = $row1["o_date"];
    $dttm = date('Ymd', strtotime($dttm1));
    $add_detail = $row1["mem_address"] . " " . $row1["mem_add_district"] . " " . $row1["mem_add_amphur"] . " " . $row1["mem_add_province"] .
        " " . $row1["mem_add_zipcode"];
    $addnew = $row1["addnew"];
    ?>



  <br>

    <table width="1000" align="center" >
        <tr>
            <td height="300" width="800"><strong>ชื่อและที่อยู่ผู้ส่ง</strong> เบอร์โทรศัพท์ : 0832234539<br>
                นายนราธิป อาชวโศภณ <br>
                150/107 หมู่บ้านสว่างจิต ซอยสวนผัก 2 ถนนสวนผัก<br>
                แขวงตลิ่งชัน เขตตลิ่งชัน กรุงเทพฯ<br>
                <h3>รหัสไปรษณีย์ : 10170</h3>



            </td>
            <td></td>
        </tr>
    </table>
    <table width="1000" align="center" >
        <tr>

            <td valign="middle" align="center">RIVER@WANGLANG<br>
           
                   เลขที่การสั่งซื้อ : <?php echo $row1["o_id"]; ?><br>

            </td>
            <td height="300" width="500">
                <strong>ชื่อและที่อยู่ผู้รับ</strong> เบอร์โทรศัพท์ : <?php echo $row1["mem_tel"]; ?><br>
                <?php echo $row1["mem_name"]; ?> <br>
                <?php if ($addnew == "1") {
                    $sql211 = "SELECT * FROM orders,address_ WHERE orders.o_id=$o_id AND orders.o_id=address_.o_id";
                    $result211 = mysqli_query($con, $sql211);
                    $row211 = mysqli_fetch_array($result211);
                    $add_detail = $row211["add_address"] . "<br>"
                        . $row211["add_add_district"] . " " . $row211["add_add_amphur"] . " " . $row211["add_add_province"];
                    $zipcode = $row211["add_add_zipcode"];
                } elseif ($addnew == "0") {
                    $add_detail = $row1["mem_address"] . "<br>"
                        . $row1["mem_add_district"] . " " . $row1["mem_add_amphur"] . " " . $row1["mem_add_province"];
                    $zipcode = $row1["mem_add_zipcode"];
                }
                echo $add_detail . "<br>";
                echo "<h3>รหัสไปรษณีย์ : " . $zipcode . "</h3>";
                ?>


            </td>
        </tr>
    </table>




</body>

</html>