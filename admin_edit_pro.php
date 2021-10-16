<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="all" href="style.css" />
    <link rel="shortcut icon" href="img_web/favicon.png" />
    <link rel="stylesheet" href="dist/css/lightbox.min.css">
    <title>RIVER-SHOP</title>
</head>
<body>
<script language="javascript">
    function cancel (){
        if(confirm('ยืนยันการลบสินค้า')){
            return true;
            
        }else{
            return false;
        }
    }
</script>
<?php
    session_start();
    include ("condb.php");
    $mem_id = $_SESSION['mem_id'];
    $mem_name = $_SESSION['mem_name'];
    $id = $_GET['id'];
    $act = $_REQUEST['act'];
    $p_code = $_REQUEST['p_code']; 
   
?>

    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        
        <?php include "navbar_admin.php";?>
    <div class="conten"><br>
   
    <?php 
    include "condb.php";?>
    <h1>แก้ไขข้อมูลสินค้า</h1>
    
                   
               
                
        <?php
        if(empty($act)){
           ?>
           <form action="" method="GET">
                    <input type="text" name="search" placeholder="ค้นหาสินค้า"> <input class="btn_sys" type="submit" value="ค้นหา">
                    </form>
           <?php
            $search = $_GET['search'];
            if (!empty($search)) {
                $sql = "SELECT * FROM product,pro_type
        WHERE product.pt_id=pro_type.pt_id AND p_name LIKE '%$search%'  GROUP BY p_code";
                $result = mysqli_query($con, $sql);
                $r = mysqli_num_rows($result);
                if ($r == 0) {
                    $output = 'ไม่มีสินค้าที่ค้นหา';
                }}else{
        $sql = "SELECT * FROM product,pro_type WHERE product.pt_id=pro_type.pt_id  GROUP BY p_code ORDER BY datesave DESC";
        $result = mysqli_query($con, $sql);
                }
        ?>
       
            <table >
            <tr>
            <td width="100" bgcolor="#00f0ff">รูปภาพ</td>
            <td width="100" bgcolor="#00f0ff">รหัสสินค้า</td>
            <td width="200" bgcolor="#00f0ff">ชื่อสินค้า</td>
            <td width="100" bgcolor="#00f0ff">ประเภท</td>
            <td width="100" bgcolor="#00f0ff">ราคา(บาท)</td>
            <td width="100" bgcolor="#00f0ff">จำนวนคงเหลือ</td>
            <td width="100" bgcolor="#00f0ff">แก้ไขสินค้า</td>
            <td width="100" bgcolor="#00f0ff">ลบสินค้า</td>
           
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)){
                $code =  $row["p_code"];
                            $s = "SELECT SUM(p_qty) AS qty FROM product  WHERE p_code = '$code' ";
                            $res = mysqli_query($con, $s);
                            $qty = mysqli_fetch_array($res);
                ?>
            <tr>
            <td bgcolor="#EEEEEE"><img src="img/<?php echo $row["p_img"];?>"style=width:90px;height:100px;></td>
            <td bgcolor="#EEEEEE"><?php echo $row["p_code"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $row["p_name"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $row["pt_name"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $row["p_price"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $qty["qty"];?></td>
                                          
            <td bgcolor="#EEEEEE"><a href="admin_edit_pro.php?p_code=<?php echo $row["p_code"];?>&act=edit"><input type="button" class="btn_sys" value="แก้ไข"></a></td>
            <td bgcolor="#EEEEEE"><a href="admin_edit_pro.php?p_code=<?php echo $row["p_code"];?>&act=delete"><input type="button" class="btn_red" value="ลบ" onclick='return cancel();'></a></td>
           
        </tr>
            <?php
        }
        
        
        ?>

            </table>
            <br>
    <?php }elseif($act=="edit"){?>
 
       
    <?php
    

    $sql = "SELECT * FROM product,pro_type WHERE product.pt_id=pro_type.pt_id AND p_code=$p_code";
    $result = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($result);
   /*$sql2 = "SELECT * FROM product,pro_type WHERE product.pt_id=pro_type.pt_id AND p_code=$p_code";
    $result2 = mysqli_query($con, $sql2);
   $row2 = mysqli_fetch_array($result2);*/?>
    <form action="admin_edit_pro.php?act=up_pro" method="POST"> 
        <table >
        <tr>
        <td align="center" bgcolor="#EEEEEE"> รูปภาพ </td>
        <td bgcolor="#EEEEEE" ><input type="hidden" name="p_code" value="<?php echo $row["p_code"];?>">
        <a class="example-image-link" href="img/<?php echo $row["p_img"];?>"
data-lightbox="example-1"><img src="img/<?php echo $row["p_img"];?>"style="width:100px;height:110px;"></a>
        </td>
        </tr>
        <tr>
        <td align="center" bgcolor="#EEEEEE">รหัสสินค้า </td>
        <td bgcolor="#EEEEEE"><?php echo $row["p_code"];?></td>
        </tr>
        <tr>
        <td align="center" bgcolor="#EEEEEE">ชื่อสินค้า </td>
        <td bgcolor="#EEEEEE"><input type="text" name="p_name" value="<?php echo $row["p_name"];?>"></td>
        </tr>
        <tr>
        <td align="center" bgcolor="#EEEEEE">รายละเอียดสินค้า </td>
        <td bgcolor="#EEEEEE"><textarea name="p_detail"  cols="45" rows="5"><?php echo $row['p_detail'];?></textarea></td>
        </tr>
        <tr>
        <td align="center" bgcolor="#EEEEEE">ราคา </td>
        <td bgcolor="#EEEEEE"><input type="number" required name="p_price" value="<?php echo $row["p_price"];?>" min="1" title="ใส่ราคาให้ถูกต้อง" style="width:60px;text-align:right;">บาท</td>
        </tr>
        <tr>
        <td align="center" bgcolor="#EEEEEE">ราคา(โปรโมชั่น) </td>
        <td bgcolor="#EEEEEE"><input type="number" required name="p_price_promotion" value="<?php echo $row["p_price_promotion"];?>" style="width:60px;text-align:right;" min="0" max="<?php $i =  $row["p_price"] - 1; echo $i;?>"  title="ใส่ราคาให้ถูกต้อง">บาท</td>
        </tr>
        <tr>
        <td align="center" bgcolor="#EEEEEE">ประเภท </td>
        <td bgcolor="#EEEEEE"><?php echo $row["pt_name"];?></td>
        </tr>
        <tr>
        <td align="center" bgcolor="#EEEEEE">สินค้าแนะนำ</td>
        <td bgcolor="#EEEEEE">
            <select name="p_sug">
            <?php if($row["p_sug"]==0){?>
            <option value="0">ไม่แนะนำสินค้า</option>
            <option value="1">แนะนำสินค้า</option>
            <?php }else{?>
            <option value="1">แนะนำสินค้า</option>
            <option value="0">ไม่แนะนำสินค้า</option>
            <?php }?>
            </select>
        
        
        </td>
        </tr>
    </table><br>
        <table >
        <?php 
        if($row["pt_size"]=="2"){?>
        
        <tr>
        <td colspan="2" bgcolor="#EEEEEE">แก้ไขสินค้าคงเหลือ</td>
        </tr>
        <tr>
        <td bgcolor="#EEEEEE">จำนวนคงเหลือ</td>
        <td bgcolor="#EEEEEE"><input type="number" min="0" required name="p_qty" value="<?php echo $row["p_qty"];?>" style="width:60px;text-align:right;"><input type="hidden" name="p_code" value="<?php echo $row["p_code"];?>"></td>
        </tr>
       
            <?php
        }elseif($row["pt_size"]=="1"||"3"){?>
        <tr>
        <td  bgcolor="#EEEEEE" colspan="5">แก้ไขสินค้าคงเหลือ</td>
        </tr>
        <tr>
        <td bgcolor="#EEEEEE">ขนาด</td>
        <td bgcolor="#EEEEEE" width="20">S</td>
        <td bgcolor="#EEEEEE" width="20">M</td>
        <td bgcolor="#EEEEEE" width="20">L</td>
        <td bgcolor="#EEEEEE" width="20">XL</td>
        </tr>
        <tr>
        <td bgcolor="#EEEEEE">จำนวนคงเหลือ</td>
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
    $rowxl = mysqli_fetch_array($resultxl);?>
   <td><input type="number" name="p_qtys" width="20" min="0" style="width:60px;text-align:right;" required value="<?php echo $rows["p_qty"];?>" pattern="^[0-9]+$" title="ใส่จำนวนให้ถูกต้อง" ><input type="hidden" name="p_ids" value="<?php echo $rows["p_id"];?>"></td>
   <td><input type="number" name="p_qtym" width="20" min="0" style="width:60px;text-align:right;" required value="<?php echo $rowm["p_qty"];?>"  pattern="^[0-9]+$" title="ใส่จำนวนให้ถูกต้อง" ><input type="hidden" name="p_idm" value="<?php echo $rowm["p_id"];?>"></td>
   <td><input type="number" name="p_qtyl" width="20" min="0" style="width:60px;text-align:right;" required value="<?php echo $rowl["p_qty"];?>"   pattern="^[0-9]+$" title="ใส่จำนวนให้ถูกต้อง"><input type="hidden" name="p_idl" value="<?php echo $rowl["p_id"];?>"></td>
   <td><input type="number" name="p_qtyxl" width="20" min="0" style="width:60px;text-align:right;" required value="<?php echo $rowxl["p_qty"];?>" pattern="^[0-9]+$" title="ใส่จำนวนให้ถูกต้อง" ><input type="hidden" name="p_idxl" value="<?php echo $rowxl["p_id"];?>"></td>
     </tr>
   

        <?php
        }
        ?>
        

        </table><br>
        <input type="submit" class="btn_green" value="ยินยัน">
        <input type="reset" value="ล้างข้อมูล" class="btn_red">
       
        </form>
        <br>
<?php }elseif($act=="delete"){
     $p_code = $_GET['p_code'];
     $pdel = "SELECT * FROM product WHERE p_code=$p_code";
     $resdel = mysqli_query($con,$pdel);
     $pro_img = mysqli_fetch_array($resdel);
     $filename = $pro_img["p_img"];
     @unlink('img/'.$filename); 

$delet1 = "DELETE FROM product WHERE p_code=$p_code";
$resultdelet = mysqli_query($con,$delet1);
$delet11 = "DELETE FROM insert_product WHERE p_code=$p_code";
$resultdelet1 = mysqli_query($con,$delet11);
$delet12 = "DELETE FROM rating WHERE p_code=$p_code";
$resultdelet12 = mysqli_query($con,$delet12);

if($resultdelet&&$resultdelet1){
	
            
    echo "<script>";
    echo "alert(\"ลบสินค้าเรียบร้อย\");";
echo "window.location='admin_edit_pro.php'"; 
echo "</script>";
}else{
    echo "<script>";
echo "alert(\"เกิดความผิดพลาด\");";
echo "window.location='admin_edit_pro.php'"; 
echo "</script>";

}
}?>





        
    </div>
    <?php
     include "condb.php";
    $act = $_REQUEST['act'];
    if($act=="up_pro"){
        
        $p_code = $_POST['p_code'];
        $p_name = $_POST['p_name'];
        $p_detail = $_POST['p_detail'];
        $p_price = $_POST['p_price'];
        $p_sug = $_POST['p_sug'];
        $p_price_promotion = $_POST['p_price_promotion'];
        $p_qtys = $_POST['p_qtys'];
        $p_qtym = $_POST['p_qtym'];
        $p_qtyl = $_POST['p_qtyl'];
        $p_qtyxl = $_POST['p_qtyxl'];
        $p_qty = $_POST['p_qty'];
        $p_ids = $_POST['p_ids'];
        $p_idm = $_POST['p_idm'];
        $p_idl = $_POST['p_idl'];
        $p_idxl = $_POST['p_idxl'];
        if($p_price_promotion > $p_price || $p_price_promotion == $p_price){
            echo "<script>";
            echo "alert(\"ผิดพลาด!!ราคาโปรโมชั่นมากกว่าราคาปกติหรือราคาโปรโมชั่นเท่ากับราคาปกติ\");";
    echo "window.location='admin_edit_pro.php?p_code=".$p_code."&act=edit'"; 
    echo "</script>";
        }else{
       /*echo $p_code;
        echo "<br>";
        echo $p_name;
        echo "<br>";
        echo $p_detail;
        echo "<br>";
        echo $p_price;
        echo "<br>";
        echo $p_qtys;
        echo "<br>";
        echo $p_qtym;
        echo "<br>";
        echo $p_qtyl;
        echo "<br>";
        echo $p_qtyxl;
        echo "<br>";
        echo $p_ids;
        echo "<br>";
        echo $p_idm;
        echo "<br>";
        echo $p_idl;
        echo "<br>";
        echo $p_idxl;
        echo "<br>";*/
        /*$product = "SELECT * FROM product";
        $result55 = mysqli_query($con, $product);
        $productall = mysqli_fetch_array($result55);
            if($productall["pt_id"]=="2"){
                $productbag = "SELECT * FROM product WHERE p_name='$p_name' LIMIT 1";
                $result1 = mysqli_query($con, $productbag);
                $productbag1 = mysqli_fetch_array($result1);
                    if($productbag1['p_name'] === $p_name){
                        echo "<script>";
                        echo "alert(\"ชื่อสินค้าซ้ำ\");";
                        echo "window.location='admin_edit_pro.php'"; 
                        echo "</script>";
                    }
            }elseif($productall["pt_id"]=="1"||"3"){
                $productt = "SELECT * FROM product WHERE p_name='$p_name' LIMIT 4";
                $result1t = mysqli_query($con, $productt);
                $productt1 = mysqli_fetch_array($result1t);
                    if($productt1['p_name'] === $p_name){
                        echo "<script>";
                        echo "alert(\"ชื่อสินค้าซ้ำ\");";
                        echo "window.location='admin_edit_pro.php'"; 
                        echo "</script>";
                    }
                    
                }*/
                
$sqlUpdatePd="UPDATE product SET p_name='$p_name',p_detail='$p_detail',p_price='$p_price',p_price_promotion='$p_price_promotion',p_sug='$p_sug' WHERE p_code='$p_code'";
        $query5	= mysqli_query($con, $sqlUpdatePd);
        
        
        $sqlUpdatePd41="UPDATE product SET  p_qty='$p_qty' WHERE p_code='$p_code'";
		$query541 = mysqli_query($con, $sqlUpdatePd41);
        $sqlUpdatePd1="UPDATE product SET p_qty='$p_qtys' WHERE p_id='$p_ids'";
        $query51 = mysqli_query($con, $sqlUpdatePd1);
        $sqlUpdatePd2="UPDATE product SET  p_qty='$p_qtym' WHERE p_id='$p_idm'";
        $query52 = mysqli_query($con, $sqlUpdatePd2);
        $sqlUpdatePd3="UPDATE product SET  p_qty='$p_qtyl' WHERE p_id='$p_idl'";
        $query53 = mysqli_query($con, $sqlUpdatePd3); 
        $sqlUpdatePd4="UPDATE product SET  p_qty='$p_qtyxl' WHERE p_id='$p_idxl'";
        $query54 = mysqli_query($con, $sqlUpdatePd4);
        


        if($query5&&$query51&&$query52&&$query53&&$query54){
	
            
            echo "<script>";
            echo "alert(\"แก้ไขข้อมูลสินค้าเรียบร้อย\");";
    echo "window.location='admin_edit_pro.php?p_code=".$p_code."&act=edit'"; 
    echo "</script>";
        }else{
            echo "<script>";
    echo "alert(\"เกิดความผิดพลาด\");";
    echo "window.location='admin_edit_pro.php'"; 
    echo "</script>";

        }}
    }
    ?>
    
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
    <script src="dist/js/lightbox-plus-jquery.min.js"></script>
</body>
</html>