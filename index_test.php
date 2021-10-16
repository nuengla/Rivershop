<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="all" href="style.css" />
    

    <title>RIVER-SHOP</title>
</head>
<body>
<?php
    session_start();
    include ("condb.php");
    $id = $_SESSION['mem_id'];
?>
    <div class="container">
        <div class="banner">
        <img  src="img/banner.jpg ">
        </div>
        <div class="navbar">
            <div class="navmenu">
                <ul>
                    
                    <li><a href="#">RIVER@WANGLANG</a></li>
                    <li><a href="cart.php">ตะกร้าสินค้า (<?php 
                     session_start();
                     $cart = $_SESSION['cart'];
                    echo count($cart); 
                    
                    ?>)</a></li>
                    <li><a href="#">ช่วยเหลือ</a>
                        <ul>
                            <li><a href="#">-ตารางวัดไซส์</a></li>
                            <li><a href="#">-วิธีสั่งสินค้า</a></li>
                            <li><a href="#">-วิธีชำระเงิน</a></li>
                            <li><a href="#">-วิธีสมัครสมาชิก</a></li>
                           
                        </ul>
                    </li>    
                    <li><form action="#">
                    <input type="text" name="search" placeholder="ค้นหาสินค้า"> <input class="btn_ok" type="submit" value="ค้นหา">
                    </form></li>
                </ul>
            </div>
           <div class="navuser">
                <ul>
                    <li><a href="register.php">สมัครสมาชิก</a></li>
                    <li><a href="login.php">เข้าสู่ระบบ</a></li>   
                </ul>
            </div>
            
        </div>
        <div class="conten">
        <br>
        
        <h1>สินค้า</h1>
        <?php
        
        
            
        $search=isset($_GET['search'])?$_GET['search']:'';
        if(!empty($search)){
            $sql = "SELECT * FROM product
            WHERE p_name LIKE '%$search%' AND p_qty>0 GROUP BY p_code";
        $result = mysqli_query($con, $sql);
        $r = mysqli_num_rows($result);
        if($r == 0){
            $output = 'ไม่มีสินค้าที่ค้นหา';
        }
        }else{
            $sql = "SELECT * FROM product WHERE p_qty>0 GROUP BY p_code";
        $result = mysqli_query($con, $sql);
        }
        echo $output;
        ?>
        <div class="contanner"  >
            <div class="area_grid">
                    <?php
                    while($row = mysqli_fetch_array($result)){
                        $rowprice = $row["p_price"];
                        $rowprice_promo = $row["p_price_promotion"];
                        ?>
                <div class="grid_item">
                    <div class="item" align="center">
            
                        <?php
                    echo "<br>"."<table  align='center' class='tb_product' >";
                        echo "<tr>"; 
                            echo "<td align='center'><img class='resize' src='img/" . $row["p_img"] ." 
                            ' width='50'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td align='center' width='200'><h3>" . $row["p_name"] . "</h3></td>";
                        echo "</tr>";
                        

                        if($rowprice_promo==0){
                            echo "<tr>"; 
                            echo "<td align='center'>"."ราคา " .number_format($row["p_price"],2)." บาท". "</td>";
                            echo "</tr>";
                            echo "<tr>"; 
                            echo "<td align='center'>โปรโมชั่น : -</td>";
                            echo "</tr>";
                        }else{
                            echo "<tr>"; 
                            echo "<td align='center'><s>"."ราคา " .number_format($row["p_price"],2)." บาท". "</s></td>";
                            echo "</tr>"; 
                            echo "<tr>"; 
                            echo "<td align='center'>โปรโมชั่น : ".number_format($row["p_price_promotion"],2)." บาท". "</td>";
                            echo "</tr>";
                        }
                            



                       
                        echo "<tr'>"; 

                            echo "<td align='center'><a href='product_detail.php?p_code=$row[p_code]'><input type='button' class='btn_main' value='เลือกสินค้า'></a></td>";
                            
                        echo "</tr>";
                        echo "<tr'>"; 
                            echo "<td align='center' height='10' > </td>";
                            
                        echo "</tr>";
                        
                    echo "</table>";
                    
                    ?>
                    
                    </div>
                </div>
                    <?php }?>
            </div>
        </div>
    </div>
 
    <div class="footer">
        
    <p>RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>