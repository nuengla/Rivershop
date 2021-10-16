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
<script language="javascript">
    function cancel (){
        if(confirm('ยืนยันการลบคำแนะนำ')){
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
    $value = $_REQUEST['value'];
    $day = date('d/m/Y');

?>

    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        
        <?php include "navbar_admin.php";?>
    <div class="conten"><br>
  <h1>จัดการโปรโมชั่น</h1><br>
  <?php
        if(empty($act)){
       ?>
      <form action="" method="GET">
                    <input type="text" name="search" placeholder="ค้นหาสินค้า"> <input class="btn_sys" type="submit" value="ค้นหา">
                    </form>
            <table >
            <tr>
            <td width="100" bgcolor="#00f0ff">รูปภาพ</td>
            <td width="100" bgcolor="#00f0ff">รหัสสินค้า</td>
            <td width="200" bgcolor="#00f0ff">ชื่อสินค้า</td>
            <td width="100" bgcolor="#00f0ff">ประเภท</td>
            <td width="100" bgcolor="#00f0ff">ราคาปกติ</td>
            <td width="100" bgcolor="#00f0ff">ราคาโปรโมชั่น</td>
            <td width="100" bgcolor="#00f0ff">แก้ไข</td>
            </tr>
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
        $sql = "SELECT * FROM product,pro_type WHERE product.pt_id=pro_type.pt_id GROUP BY p_code ORDER BY datesave DESC";
        $result = mysqli_query($con, $sql);
     }
            
            while ($row = mysqli_fetch_array($result)){?>
             <form action="query.php?act=update_promotion" method="post">
            <tr>
            <td bgcolor="#EEEEEE"><img src="img/<?php echo $row["p_img"];?>"style=width:90px;height:100px;></td>
            <td bgcolor="#EEEEEE"><?php echo $row["p_code"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $row["p_name"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $row["pt_name"];?></td>
            <td bgcolor="#EEEEEE"><?php echo $row["p_price"];?></td>
            <input type="hidden" name="p_code" value="<?php echo  $row["p_code"];?>">
            <input type="hidden" name="act" value="update_promotion">
            
            <td bgcolor="#EEEEEE"><input type="number" required name="p_price_promotion" value="<?php echo $row["p_price_promotion"];?>" min="0" max="<?php $i =  $row["p_price"] - 1; echo $i;?>"
            style="width:50px;text-align:center;"></td>
            <td bgcolor="#EEEEEE"><input type="submit" class="btn_sys" value="แก้ไข" ></td>
            </tr>
            </form>
            <?php
        }}
        
        
        ?>

            </table>
           
           <br>
 </div>

    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>