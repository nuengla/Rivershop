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
  <h1>คำแนะนำ ติ/ชม จากลูกค้า</h1><br>
  <?php 
  $sql = "SELECT * FROM member,complaint WHERE member.mem_id=complaint.mem_id ORDER BY complaint.com_datesave DESC";
  $result = mysqli_query($con,$sql);

  ?>
<table  width="912">
    <?php while($row = mysqli_fetch_array($result)){
        $com_img = $row["com_img"];?>
<tr>
    <td width="150" bgcolor="#EEEEEE" align="left">วันที่และเวลา</td>
    <td bgcolor="#EEEEEE"align="left"><?php echo $row["com_datesave"];?></td>    
    <td rowspan="5" width="100" bgcolor="#EEEEEE"><a href="admin_complaint.php?act=delete&com_id=<?php echo $row["com_id"];?>"onclick="return cancel();">
        <input type="button" class="btn_red" value="ลบ">
</a></td>
</tr>
<tr>
<td bgcolor="#EEEEEE"align="left">จากคุณ</td>
<td bgcolor="#EEEEEE"align="left"><?php echo $row["mem_name"];?></td>
</tr>
<tr>
    <td bgcolor="#EEEEEE"align="left">หัวข้อ/เรื่อง</td>
    <td bgcolor="#EEEEEE"align="left"><?php echo $row["com_subject"];?></td>
</tr>
<tr>
    <td bgcolor="#EEEEEE"align="left">รายละเอียด</td>
    <td bgcolor="#EEEEEE"align="left"><?php echo $row["com_detail"];?></td>
</tr>
<tr>
    <td bgcolor="#EEEEEE"align="left">รูปภาพประกอบ</td>

<?php if(empty($com_img)){?>
    <td bgcolor="#EEEEEE"align="left">-</td>
<?php }else{?>
    <td bgcolor="#EEEEEE" align="left"><img src="img_complaint/<?php echo$com_img;?>" style="width:350px;height: auto;" ></td>
<?php }?>
</tr>
<tr>
    <td height="40"></td>
    <td></td>
    <td></td>
</tr>

    <?php }?>


</table>

  <br>

 </div>
 <?php 
    include "condb.php";
    
    
  
    if($act=="delete"){
        $com_id = $_GET['com_id'];
        $sql11 = "SELECT * FROM complaint WHERE com_id=$com_id ";
        $result11 = mysqli_query($con, $sql11);
        $pro_img = mysqli_fetch_array($result11);
        $filename = $pro_img["com_img"];
        @unlink('img_complaint/'.$filename); 

        $delet = "DELETE FROM complaint WHERE com_id=$com_id";
        $result4 = mysqli_query($con,$delet);
        
    }
    if($result4&&$result5){
    echo "<script>";
    echo "alert(\"ลบคำแนะนำเรียบร้อย\");";
    
            echo "</script>";
            echo "header('location:webpage.php');";
    }
    
    ?>

    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>