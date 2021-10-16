<?php
include "condb.php";
$mem_password = $_POST['mem_password'];
$mem_name = $_POST['mem_name'];
$mem_address = $_POST['mem_address'];
$mem_tel = $_POST['mem_tel'];
$mem_id = $_POST['mem_id'];
$addnew = $_REQUEST["addnew"];

    
    if(!empty($addnew)){
        $province_id = $_REQUEST['province'];
$amphur_id = $_REQUEST['amphur'];
$district_id = $_REQUEST['district'];
$zipcode = $_REQUEST['postcode'];


    $sql1 = "SELECT * FROM amphur WHERE amphur_id=$amphur_id";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $amphur = $row1["amphur_name"];

    $sql2 = "SELECT * FROM province WHERE province_id=$province_id";
    $result12 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_array($result12);
    $province = $row2["province_name"];

    $sql3 = "SELECT * FROM district WHERE district_id=$district_id";
    $result13 = mysqli_query($con, $sql3);
    $row3 = mysqli_fetch_array($result13);
    $district = $row3["district_name"];
		$sqlUpdatePd="UPDATE member SET mem_password='$mem_password',mem_name='$mem_name',mem_address='$mem_address',mem_add_province='$province',mem_add_amphur='$amphur',mem_add_district='$district',mem_add_zipcode='$zipcode',mem_tel='$mem_tel' WHERE mem_id='$mem_id'";
		$query5	= mysqli_query($con, $sqlUpdatePd);
	
	}else{


$sqlUpdatePd="UPDATE member SET mem_password='$mem_password',mem_name='$mem_name',mem_tel='$mem_tel' WHERE mem_id='$mem_id'";
		$query5	= mysqli_query($con, $sqlUpdatePd);
    }

        if($query5){
	
            
            echo "<script>";
    echo "alert(\"แก้ไขข้อมูลส่วนตัวเรียบร้อย\");";
    echo "window.location='edit_mem.php'"; 
    echo "</script>";
        }else{
            echo "<script>";
    echo "alert(\"เกิดความผิดพลาด\");";
    echo "window.location='edit_mem.php'"; 
    echo "</script>";

        }
?>