<?php
session_start();
include "condb.php";
$p_id = $_GET['p_id'];
$act = $_GET['act'];
$page = $_REQUEST["page"];



if ($act == 'add' && !empty($p_id)) {
    if (!isset($_SESSION['cart'])) {

        $_SESSION['cart'] = array();
    } else {
    }
    if (isset($_SESSION['cart'][$p_id])) {
        $_SESSION['cart'][$p_id]++;
    } else {
        $_SESSION['cart'][$p_id] = 1;
    }
}

if ($act == 'remove' && !empty($p_id)) {

    unset($_SESSION['cart'][$p_id]);
}

if ($act == 'update') {

    $amount_array = $_POST['amount'];
    if (empty($amount_array)) {
        echo "<script>";
        echo "alert(\"ไม่มีสินค้าในตะกร้า\");";
        echo "window.location='cart.php'";
        echo "</script>";
    }
    foreach ($amount_array as $p_id => $amount) {

        $_SESSION['cart'][$p_id] = $amount;
    }
}
?>
<?php
include("condb.php");
$id = $_SESSION['mem_id'];
$name = $_SESSION['mem_name'];

?>
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

    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
       
<?php include "navbarmemin.php"?>
      
        <div class="conten"><br>

            <h1>แนะนำ ติ/ชม ร้าน</h1>
            <form action="complaint.php" method="POST" enctype="multipart/form-data">
                <table border="1">
                    <tr>
                        <td>หัวข้อ/เรื่อง</td>
                        <td><input type="text" name="com_subject" required><input type="hidden" name="mem_id"
                        value="<?php echo $id;?>"></td>
                    </tr>
                    <td>รายละเอียด</td>
                    <td><textarea name="com_detail" cols="45" rows="5" required></textarea></td>
                    <tr>
                        <td>รูปภาพ</td>
                        <td><input type="file" name="com_img"><input type="hidden" name="act" value="complaint"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" class="btn_green" value="ส่ง" style="width:70px;"></td>
                    </tr>

                </table>

            </form>

            <?php
            include "condb.php";
            
            $act = $_POST["act"];
           
                if($act=="complaint"){
                    $com_detail = $_POST["com_detail"];
            $com_subject = $_POST["com_subject"];
            $com_img = $_FILES["com_img"];
            $mem_id = $_POST["mem_id"];

                        
                   
                        $ext = pathinfo(basename($_FILES['com_img']['name']), PATHINFO_EXTENSION);
                
                if(empty($ext)){
                    $sql4	= "INSERT INTO complaint VALUES(null,'$mem_id','$com_subject', '$com_detail','',sysdate() )";
                        $query4	= mysqli_query($con, $sql4);
                }else{
                    $new_img_name = 'com_'.uniqid().".".$ext;
                    $img_path = "img_complaint/";
        $upload_path = $img_path.$new_img_name;

move_uploaded_file($_FILES['com_img']['tmp_name'],$upload_path);
$com_img1 = $new_img_name;

$sql4	= "INSERT INTO complaint VALUES(null,'$mem_id','$com_subject', '$com_detail','$com_img1',sysdate() )";
                        $query4	= mysqli_query($con, $sql4);
                       

                    }

                    echo "<script>";
                    echo "alert(\"ขอบคุณสำหรับคำแนะนำครับ\");";
                    echo "window.location='complaint.php'"; 
                    echo "</script>";
                }
            


            ?>
            <br>
            <br>
        </div>


        <div class="footer">

            <p>© 2020 RIVER @ WANG LANG</p>


        </div>

    </div>

</body>

</html>