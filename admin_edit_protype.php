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
<script language="javascript">
    function cancel (){
        if(confirm('ยืนยันการลบประเภทสินค้า')){
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
    <h1>จัดการประเภทสินค้า</h1><br>
    <?php
    $sql = "SELECT * FROM pro_type ";
    $result = mysqli_query($con, $sql);
    
    
    ?>
        <table border="1">
        <tr>
        <td width="100">ประเภท</td>
        <td>รายละเอียด</td>
       <td>แก้ไข</td>
       <td>ลบ</td>
        </tr>
        
        <?php while($row = mysqli_fetch_array($result)){?>
         <tr>
        <td><?php echo $row["pt_name"];?></td>
        <td><?php 
        if($row["pt_size"]=="1"){echo "มีไซส์";}else {
            echo "ไม่มีไซส์";
        }
        ?></td>
        <td><a href="admin_edit_protype.php?act=edit&pt_id=<?php echo $row["pt_id"];?>"><input type="button" class="btn_sys" value="แก้ไข"></a></td>
        <td><a href="admin_edit_protype.php?act=delet&pt_id=<?php echo $row["pt_id"];?>"><input type="button" class="btn_red" value="ลบ" onclick='return cancel();'></a></td>
       
        </tr>
        <?php }?>

        <?php if($act=="edit"){
            $pt_id = $_GET['pt_id'];
            $sql1 = "SELECT * FROM pro_type WHERE pt_id=$pt_id ";
            $result1 = mysqli_query($con, $sql1);
            $row1 = mysqli_fetch_array($result1);
            ?>
            
            </table><br>
      
        <form action="query.php?act=edit_type&pt_id=<?php echo $row1["pt_id"];?>" method="POST">
        <table border="1">
            <tr>
            <td>แก้ไขประเภทสินค้า</td>
            <td><input type="text" name="edit_type1" required value="<?php echo $row1["pt_name"];?>">
            
            <input type="submit" class="btn_sys" value="แก้ไข"></td>
            <td><a href="admin_edit_protype.php"><input type="button" class="btn_red" value="ปิด"></a></td>
            </tr>
        
        </table>
            </form>
           


         <?php   }
            
            
            ?>
        
        </table><br>
      
        <form action="query.php?act=add_type" method="POST">
        <table border="1">
            <tr>
            <td>เพิ่มประเภทสินค้า</td>
            <td><input type="text" name="add_type1" required>
            <input type="radio" name="pt_size" required value="1">มีไซส์
            <input type="radio" name="pt_size" required value="2">ไม่มีไซส์
            <input type="submit" class="btn_green" value="เพิ่ม"></td>
            </tr>
        
        </table><br>
        
        </form>
       

    </div>
  
    
<?php
if($act=="delet"){
    $pt_id = $_GET['pt_id'];
   

$delet1 = "DELETE FROM pro_type WHERE pt_id=$pt_id";
$resultdelet = mysqli_query($con,$delet1);


if($resultdelet){
   
           
   echo "<script>";
   echo "alert(\"ลบประเภทสินค้าเรียบร้อย\");";
echo "window.location='admin_edit_protype.php'"; 
echo "</script>";
}else{
   echo "<script>";
echo "alert(\"เกิดความผิดพลาด\");";
echo "window.location='admin_edit_protype.php'"; 
echo "</script>";

}
}
?>



    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>