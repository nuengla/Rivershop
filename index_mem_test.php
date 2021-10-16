<!DOCTYPE html>
<html lang="en">
<head>
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
        <img  src="img/banner.jpg ">
        </div>
        <?php include "navbarmem.php"?>
        <div class="conten">
        <br>
        
        <h1>สินค้า</h1>
        <?php
        
        
            
        $search=isset($_GET['search'])?$_GET['search']:'';
        if(!empty($search)){
            $sql = "SELECT * FROM product
            WHERE p_name  LIKE '%$search%' AND p_qty>0 GROUP BY p_code";
        $result = mysqli_query($con, $sql);
        $r = mysqli_num_rows($result);
        if($r == 0){
            $output = 'ไม่มีสินค้าที่ค้นหา';
        }
        }else{
            $sql = "SELECT * FROM product WHERE p_qty>0 GROUP BY p_code";
        $result = mysqli_query($con, $sql);
        }
        echo $output."<br>"."<br>";
        ?>
        <div class="contanner"  >
            <div class="area_grid">
                    <?php
                    while($row = mysqli_fetch_array($result)){?>
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
                        echo "<tr>"; 
                            echo "<td align='center'>"."ราคา " .number_format($row["p_price"],2)." บาท". "</td>";
                        echo "</tr>";
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
