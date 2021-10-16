<?php
include "condb.php";
$mem_id = $_SESSION['mem_id'];
$mem_name = $_SESSION['mem_name'];
$p_code = $_POST['p_code'];
$ps_id = $_POST['size'];
$act = $_REQUEST['act'];

if ($act == "add") {
    $sql1 = "SELECT p_id FROM product WHERE ps_id=$ps_id AND p_code=$p_code";
    $result1 = mysqli_query($con, $sql1);
    $row11 = mysqli_fetch_array($result1);
    $p_id = $row11['p_id'];
    echo "<script>";
    echo "window.location='cart.php?p_id=" . $p_id . "&act=add'";
    echo "</script>";
} elseif ($act == "edit_type") {
    $pt_id = $_REQUEST['pt_id'];
    $edit_type = $_POST['edit_type1'];
    $pt_size = $_POST['pt_size'];
    $ckprotype = "SELECT * FROM pro_type WHERE pt_name='$edit_type' LIMIT 1";
    $result1 = mysqli_query($con, $ckprotype);
    $protypename = mysqli_fetch_array($result1);
    if ($protypename['pt_name'] === $edit_type) {
        echo "<script>";
        echo "alert(\"ชื่อประเภทซ้ำ\");";
        echo "window.location='admin_edit_protype.php'";
        echo "</script>";
    } else {
        $sqlUpdatePd = "UPDATE pro_type SET pt_name='$edit_type',pt_size='$pt_size' WHERE pt_id='$pt_id'";
        $query5    = mysqli_query($con, $sqlUpdatePd);
        if ($query5) {
            echo "<script>";
            echo "alert(\"แก้ไขประเภทสินค้าเรียบร้อย\");";
            echo "window.location='admin_edit_protype.php'";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert(\"เกิดความผิดพลาด\");";
            echo "window.location='admin_edit_protype.php'";
            echo "</script>";
        }
    }
} elseif ($act == "add_type") {
    $pt_id = $_REQUEST['pt_id'];
    $add_type = $_POST['add_type1'];
    $pt_size = $_POST['pt_size'];
    $ckprotype = "SELECT * FROM pro_type WHERE pt_name='$add_type' LIMIT 1";
    $result1 = mysqli_query($con, $ckprotype);
    $protypename = mysqli_fetch_array($result1);
    if ($protypename['pt_name'] === $add_type) {
        echo "<script>";
        echo "alert(\"ชื่อประเภทซ้ำ\");";
        echo "window.location='admin_edit_protype.php'";
        echo "</script>";
    } else {
        $sql4    = "INSERT INTO pro_type VALUES(null,'$add_type','$pt_size')";
        $query6    = mysqli_query($con, $sql4);
        if ($query6) {
            echo "<script>";
            echo "alert(\"เพิ่มประเภทสินค้าเรียบร้อย\");";
            echo "window.location='admin_edit_protype.php'";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert(\"เกิดความผิดพลาด\");";
            echo "window.location='admin_edit_protype.php'";
            echo "</script>";
        }
    }
} elseif ($act=="update_promotion"){
    $p_pric_pro = $_POST['p_price_promotion'];
  
    $sqlUpdatePd="UPDATE product SET p_price_promotion='$p_pric_pro' WHERE p_code='$p_code'";
    $query5	= mysqli_query($con, $sqlUpdatePd);

    if($query5){
	
            
        echo "<script>";
        echo "alert(\"แก้ไขราคาโปรโมชั่นเรียบร้อย\");";
        echo "window.location='admin_promotion.php'";
echo "</script>";
    }else{
        echo "<script>";
echo "alert(\"เกิดความผิดพลาด\");";
echo "window.location='admin_promotion.php'";
echo "</script>";

    }


}elseif($act=="vote"){
    $rating = $_POST["rating"];
    $p_code1 = $_POST["p_code"];
    $sel = "SELECT * FROM rating WHERE p_code='$p_code1'";
    $resultse = mysqli_query($con, $sel);
    $rowra = mysqli_fetch_array($resultse);
    
    if($rating=="25"){
        $sel25 = "SELECT rat_1 FROM rating WHERE p_code='$p_code1'";
    $resultse25 = mysqli_query($con, $sel25);
    $row25 = mysqli_fetch_array($resultse25);
    $up = $row25["rat_1"] + 1 ;
        $vote = "UPDATE rating SET rat_1='$up' WHERE p_code='$p_code1'";
        $queryrat = mysqli_query($con, $vote);
    }elseif($rating=="50"){
        $sel50 = "SELECT rat_2 FROM rating WHERE p_code='$p_code1'";
    $resultse50 = mysqli_query($con, $sel50);
    $row50 = mysqli_fetch_array($resultse50);
    $up = $row50["rat_2"] + 1 ;
        $vote = "UPDATE rating SET rat_2='$up'WHERE p_code='$p_code1'";
        $queryrat = mysqli_query($con, $vote);
    }elseif($rating=="75"){
        $sel75 = "SELECT rat_3 FROM rating WHERE p_code='$p_code1'";
    $resultse75 = mysqli_query($con, $sel75);
    $row75 = mysqli_fetch_array($resultse75);
    $up = $row75["rat_3"] + 1 ;
        $vote = "UPDATE rating SET rat_3='$up'WHERE p_code='$p_code1'";
        $queryrat = mysqli_query($con, $vote);
    }elseif($rating=="100"){
        $sel100 = "SELECT rat_4 FROM rating WHERE p_code='$p_code1'";
    $resultse100 = mysqli_query($con, $sel100);
    $row100 = mysqli_fetch_array($resultse100);
    $up = $row100["rat_4"] + 1 ;
        $vote = "UPDATE rating SET rat_4='$up'WHERE p_code='$p_code1'";
        $queryrat = mysqli_query($con, $vote);
    }
    
        echo "<script>";
        echo "alert(\"ขอบคุณสำหรับการให้คะแนนครับ\");";
        echo "window.location='product_detail.php?p_code=".$p_code1."'"; 
        echo "</script>";
} elseif ($act == "checkorder") {
    $o_id = $_REQUEST['o_id'];
    $ck = "UPDATE orders SET s_id='4' WHERE o_id='$o_id'";
        $queryck = mysqli_query($con, $ck);
    
       
        if ($queryck) {
            echo "<script>";
            echo "alert(\"บันทึกเรียบร้อย\");";
            echo "window.location='admin_order.php?id=2'";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert(\"เกิดความผิดพลาด\");";
            echo "window.location='admin_order.php?id=2'";
            echo "</script>";
        }
    
}
