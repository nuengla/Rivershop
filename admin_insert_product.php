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
<?php
    session_start();
    include ("condb.php");
  


?>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php include "navbar_admin.php";?>
    <div class="conten"><br>
    <h1>เพิ่มสินค้า/ลงทะเบียนสินค้า</h1><br>
    <table  border="1" >
                <form name="login" action="admin_insert_product.php?act=add" method="POST" id="register" enctype="multipart/form-data">
                    <tr>
                        <td width="150px"><div align="center"><label>ชื่อสินค้า</label></div></td>
                        <td style="text-align:left"><input type="text" name="pro_name" required></td>
                    </tr>
                    <tr>
                        <td><div align="center"><label>รูปภาพ</label></td>
                        <td style="text-align:left"><input type="file" name="pro_img" required></td>
                    </tr>
                    <tr>
                        <td><div align="center"><label>รายละเอียด</label></div></td>
                        <td style="text-align:left"><textarea name="pro_detail" cols="45" rows="5" required></textarea></td>
                    </tr>
                    <tr>
                        <td><div align="center"><label>ราคา</label></div></td>
                        <td style="text-align:left"><input type="text" name="pro_price"  pattern="^[0-9]+$"  required>บาท</td>
                    </tr>
                    <tr>
                        <td><div align="center"><label>ราคา(โปรโมชั่น)</label></div></td>
                        <td style="text-align:left"><input type="text" name="pro_price_promotion"  pattern="^[0-9]+$"  required>บาท</td>
                    </tr>
                    <tr>
                        <td ><div align="center"><label>ประเภทสินค้า</label></div></td>
                        <td style="text-align:left">
                        <?php
                        $sql1 = "SELECT * FROM pro_type ";
                        $result1 = mysqli_query($con, $sql1);
        echo "<select name='pro_type'>";             
        while ($row1 = mysqli_fetch_array($result1)){
            echo "<option value='".$row1['pt_id']."'>".$row1['pt_name']."</option>";   
        }
            echo "</select>";
                        ?>  (เลือกประเภทสินค้าให้ถูกต้อง)
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2"><div align="center">
                        <input type="submit" name="register" class="btn_green" value="เพิ่มสินค้า">
                        <input type="reset" class="btn_red" value="ล้างข้อมูล"></div></td>
                    </tr>
                </form>
            </table>
    <br>
     
    </div>
   <?php
   $act = $_REQUEST['act'];
   if($act=="add"){
    $pro_name = $_POST['pro_name'];
    $pro_detail= $_POST['pro_detail'];
    $pro_price= $_POST['pro_price'];
    $pro_price_promotion= $_POST['pro_price_promotion'];
    $pro_type= $_POST['pro_type'];
    $pro_qty = "0";
    if($pro_price_promotion > $pro_price || $pro_price_promotion == $pro_price){
    echo "<script>";
    echo "alert(\"ผิดพลาด!!ราคาโปรโมชั่นมากกว่าราคาปกติหรือราคาโปรโมชั่นเท่ากับราคาปกติ\");";
echo "window.location='admin_insert_product.php'"; 
echo "</script>";
}else{
    $pt = "SELECT pt_size FROM pro_type WHERE pt_id='$pro_type'";
    $resultpt = mysqli_query($con, $pt);
    $pt1 = mysqli_fetch_array($resultpt);
        
                $productbag = "SELECT * FROM product WHERE p_name='$pro_name' LIMIT 1";
                $result1 = mysqli_query($con, $productbag);
                $productbag1 = mysqli_fetch_array($result1);
                    if($productbag1['p_name'] === $pro_name){
                        echo "<script>";
                        echo "alert(\"ชื่อสินค้าซ้ำ\");";
                        echo "window.location='admin_insert_product.php'"; 
                        echo "</script>";
                    }
            else {
                
                if($pt1["pt_size"]==="2"){
                    $ps_id = "5";
            
               $ext = pathinfo(basename($_FILES['pro_img']['name']), PATHINFO_EXTENSION);
               $new_img_name = 'img_'.uniqid().".".$ext;
               $img_path = "img/";
               $upload_path = $img_path.$new_img_name;
            
               move_uploaded_file($_FILES['pro_img']['tmp_name'],$upload_path);
               $pro_img = $new_img_name;
            
               $sql1	= "INSERT INTO insert_product VALUES (NULL)";
                $query1	= mysqli_query($con, $sql1);
                
                $sql2 = "SELECT p_code FROM insert_product ORDER BY p_code DESC LIMIT 1";
                $query2	= mysqli_query($con, $sql2);
                $row = mysqli_fetch_array($query2);
                $p_code = $row['p_code'];
               
                $sql4	= "INSERT INTO product VALUES(null,'$p_code','$pro_name','$pro_img','$pro_detail','$pro_price','$pro_price_promotion','$pro_qty','$ps_id','$pro_type',SYSDATE())";
                    $query4	= mysqli_query($con, $sql4);
                    $sqlrat	= "INSERT INTO rating VALUES(null,'$p_code','0','0','0','0')";
                    $queryrat	= mysqli_query($con, $sqlrat);
                   if($query4){
                
                        
                        echo "<script>";
                echo "alert(\"เพิ่มสินค้าและลงทะเบียนสินค้าเรียบร้อย\");";
                echo "window.location='admin_insert_product.php'"; 
                echo "</script>";
                    }else{
                        echo "<script>";
                echo "alert(\"เกิดความผิดพลาด\");";
                echo "window.location='admin_insert_product.php'"; 
                echo "</script>";
            
                    }
                }elseif($pt1["pt_size"]==="1"){
                    
                    //$ps_id = "5";
            
               $ext = pathinfo(basename($_FILES['pro_img']['name']), PATHINFO_EXTENSION);
               $new_img_name = 'img_'.uniqid().".".$ext;
               $img_path = "img/";
               $upload_path = $img_path.$new_img_name;
            
               move_uploaded_file($_FILES['pro_img']['tmp_name'],$upload_path);
               $pro_img = $new_img_name;
            
               $sql1	= "INSERT INTO insert_product VALUES (NULL)";
                $query1	= mysqli_query($con, $sql1);
                
                $sql2 = "SELECT p_code FROM insert_product ORDER BY p_code DESC LIMIT 1";
                $query2	= mysqli_query($con, $sql2);
                $row = mysqli_fetch_array($query2);
                $p_code = $row['p_code'];
                for($i=1; $i<=4; $i++){
                
                $sql4	= "INSERT INTO product VALUES(null,'$p_code','$pro_name','$pro_img','$pro_detail','$pro_price','$pro_price_promotion','$pro_qty','$i','$pro_type',SYSDATE())";
                    $query4	= mysqli_query($con, $sql4);
                    
            
                }
                $sqlrat	= "INSERT INTO rating VALUES(null,'$p_code','0','0','0','0')";
                $queryrat	= mysqli_query($con, $sqlrat);
                   if($query4){
                
                        
                        echo "<script>";
                echo "alert(\"เพิ่มสินค้าและลงทะเบียนสินค้าเรียบร้อย\");";
                echo "window.location='admin_insert_product.php'"; 
                echo "</script>";
                    }else{
                        echo "<script>";
                echo "alert(\"เกิดความผิดพลาด\");";
                echo "window.location='admin_insert_product.php'"; 
                echo "</script>";
            
            
                }
                }


            }
        }
        }
    

   ?>
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>