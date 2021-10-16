<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img_web/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="all" href="style.css" />
    <link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">
    <title>RIVER-SHOP</title>
</head>
<body>
<script language="javascript">
    function cancel (){
        if(confirm('ยืนยันการลบธนาคาร')){
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
    <h1>จัดการธนาคาร</h1><br>
    <?php
    $sql = "SELECT * FROM bank ";
    $result = mysqli_query($con, $sql);
    
    
    ?>
        <table border="1">
        <tr>
        <td width="100">รูปภาพ</td>
        <td width="100">ธนาคาร</td>
       <td width="200">เลขที่บัญชี</td>
       <td width="200">ชื่อบัญชี</td>
       <td width="100">สาขา</td>
       <td>แก้ไข</td>
       <td>ลบ</td>
        </tr>
        
        <?php while($row = mysqli_fetch_array($result)){?>
         <tr>
        <td><img src="imgbank/<?php echo $row["b_logo"];?>" style=width:65px;height:65px;></td>
        <td><?php echo $row["b_name"];?></td>
        <td><?php echo $row["b_number"];?></td>
        <td><?php echo $row["b_owner"];?></td>
        <td><?php echo $row["bn_name"];?></td>
        <td><a href="admin_bank.php?act=edit_bank&b_id=<?php echo $row["b_id"];?>"><input type="button" class="btn_sys" value="แก้ไข"></a></td>
        <td><a href="admin_bank.php?act=delete&b_id=<?php echo $row["b_id"];?>"><input type="button" class="btn_red" value="ลบ" onclick='return cancel();'></a></td>
       
        </tr>
        <?php }?>

            </table><br>
            <?php 
            include "condb.php";
            if($act=="edit_bank"){
            $b_id = $_GET['b_id'];
            $sql1 = "SELECT * FROM bank WHERE b_id=$b_id ";
            $result1 = mysqli_query($con, $sql1);
            $row1 = mysqli_fetch_array($result1);
            ?>
      
        <form action="admin_bank.php?act=up_bank" method="POST">
        <table border="1" class="bank">
            <tr>
            <td colspan="7">แก้ไขธนาคาร</td></tr>
            <tr>
            <tr>
            <td width="100">รูปภาพ</td>
            <td >ธนาคาร</td>
            <td >เลขที่บัญชี</td>
            <td >ชื่อบัญชี</td>
            <td>สาขา</td>
            <td>แก้ไข</td>
            <td>ปิด</td>
            </tr>
            
         <tr>
        <td><img src="imgbank/<?php echo $row1["b_logo"];?>" style=width:65px;height:65px;></td>
        <input type="hidden" name="b_id" value="<?php echo $row1["b_id"];?>">
        <td ><input type="text" name="b_name" value="<?php echo $row1["b_name"];?>"></td>
        <td><input type="text" name="b_number" value="<?php echo $row1["b_number"];?>"></td>
        <td><input type="text" name="b_owner" value="<?php echo $row1["b_owner"];?>"></td>
        <td><input type="text" name="bn_name" value="<?php echo $row1["bn_name"];?>"></td>
        <td><a href="admin_bank.php"><input type="submit" class="btn_green" value="ยืนยัน"></a></td>
        <td><a href="admin_bank.php"><input type="button" class="btn_red" value="ปิด"></a></td>
       
        </tr>
        
        </table>
            </form>
         <?php   }
            
            
            ?>
        
        </table><br>
      
        <form action="admin_bank.php?act=add_bank" method="POST" enctype="multipart/form-data">
        <table border="1" class="bank">
            <tr>
            <td colspan="2">เพิ่มธนาคาร</td>
            </tr>
            <tr>
            <td width="100">รูปภาพ</td>
            <td width="100"><input type="file" name="b_logo" required></td>
            </tr>
            <tr>
            <td width="100">ชื่อธนาคาร</td>
            <td width="100"><input type="text" name="b_name" required></td>
            </tr>
            <tr>
            <td width="100">เลขที่บัญชี</td>
            <td width="100"><input type="text" name="b_number" required></td>
            </tr>
            <tr>
            <td width="100">ชื่อบัญชี</td>
            <td width="100"><input type="text" name="b_owner" required></td>
            </tr>
            <tr>
            <td width="100">สาขา</td>
            <td width="100"><input type="text" name="bn_name" required></td>
            </tr>
         <tr>
       
        <td colspan="2"><a href="admin_bank.php"><input type="submit" class="btn_green" value="ยืนยัน"></a>
        <input type="reset" class="btn_red" value="ล้างข้อมูล"></td>
       
        </tr>
        
        </table><br>
            </form>
       

    </div>
  
    
<?php
if($act=="up_bank"){
    $b_id = $_POST['b_id'];
    $bn_name = $_POST['bn_name'];
    $b_owner = $_POST['b_owner'];
    $b_number = $_POST['b_number'];
    $b_name = $_POST['b_name'];
    /*echo $b_id;
    echo "<br>";
    echo $bn_name;
    echo "<br>";
    echo $b_owner;
    echo "<br>";
    echo $b_number;
    echo "<br>";
    echo $b_name;*/
   
    $sqlUpdatePd="UPDATE bank SET bn_name='$bn_name',b_owner='$b_owner',b_number='$b_number',b_name='$b_name' WHERE b_id='$b_id'";
    $query5	= mysqli_query($con, $sqlUpdatePd);
    if($query5){
    echo "<script>";
    echo "alert(\"แก้ไขธนาคารเรียบร้อย\");";
    echo "window.location='admin_bank.php'"; 
    echo "</script>";
    }else{
    echo "<script>";
    echo "alert(\"เกิดความผิดพลาด\");";
    echo "window.location='admin_bank.php'"; 
    echo "</script>";
    
    }

}elseif($act=="add_bank"){
    
    $bn_name = $_POST['bn_name'];
    $b_owner = $_POST['b_owner'];
    $b_number = $_POST['b_number'];
    $b_name = $_POST['b_name'];
    $ext = pathinfo(basename($_FILES['b_logo']['name']), PATHINFO_EXTENSION);
               $new_img_name = 'img_'.uniqid().".".$ext;
               $img_path = "imgbank/";
               $upload_path = $img_path.$new_img_name;
            
               move_uploaded_file($_FILES['b_logo']['tmp_name'],$upload_path);
               $b_logo = $new_img_name;
    /*echo $b_id;
    echo "<br>";
    echo $bn_name;
    echo "<br>";
    echo $b_owner;
    echo "<br>";
    echo $b_number;
    echo "<br>";
    echo $b_name;*/
   
    $sql4	= "INSERT INTO bank VALUES(null,'$b_name','$b_number','$b_owner','$b_logo','$bn_name')";
    $query4	= mysqli_query($con, $sql4);
    if($query4){
    echo "<script>";
    echo "alert(\"เพิ่มธนาคารเรียบร้อย\");";
    echo "window.location='admin_bank.php'"; 
    echo "</script>";
    }else{
    echo "<script>";
    echo "alert(\"เกิดความผิดพลาด\");";
    echo "window.location='admin_bank.php'"; 
    echo "</script>";
    
    }

}elseif($act=="delete"){
    $b_id = $_GET['b_id'];
    $pdel = "SELECT * FROM bank WHERE b_id=$b_id";
    $resdel = mysqli_query($con,$pdel);
    $pro_img = mysqli_fetch_array($resdel);
    $filename = $pro_img["b_logo"];
    @unlink('imgbank/'.$filename); 

$delet1 = "DELETE FROM bank WHERE b_id=$b_id";
$resultdelet = mysqli_query($con,$delet1);


if($resultdelet){
   
           
   echo "<script>";
   echo "alert(\"ลบธนาคารเรียบร้อย\");";
echo "window.location='admin_bank.php'"; 
echo "</script>";
}else{
   echo "<script>";
echo "alert(\"เกิดความผิดพลาด\");";
echo "window.location='admin_bank.php'"; 
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