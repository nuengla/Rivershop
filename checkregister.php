<?php
include ("condb.php");
$mem_user = $_POST['mem_user'];
$mem_password= $_POST['mem_password'];
$mem_password1= $_POST['mem_password1'];
$mem_name= $_POST['mem_name'];
$mem_address= $_POST['mem_address'];
$mem_tel= $_POST['mem_tel'];
$mem_type = 2;
$province_id = $_REQUEST['province'];
$amphur_id = $_REQUEST['amphur'];
$district_id = $_REQUEST['district'];
$postcode = $_REQUEST['postcode'];
if($mem_password === $mem_password1){
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

$userchk = "SELECT * FROM member WHERE mem_user = '$mem_user' LIMIT 1";
$result1 = mysqli_query($con, $userchk);
$user = mysqli_fetch_array($result1);
if($user['mem_user'] === $mem_user){
            echo "<script>";
            echo "alert(\"มีผู้ใข้ Username นี้แล้ว\");";
            echo "window.history.back()"; 
            echo "</script>";
}else{
$sql="INSERT INTO member (mem_user,mem_password,mem_name,mem_address,mem_add_province,mem_add_amphur,mem_add_district,mem_add_zipcode,mem_tel,mem_type) 
VALUES ('$mem_user','$mem_password','$mem_name','$mem_address','$province','$amphur','$district','$postcode','$mem_tel','$mem_type')" ;
$result = mysqli_query($con,$sql);

if($result){
    echo "<script>";
            echo "alert(\"สมัครสมาชิกเรียบร้อย\");";
            echo "window.location='index.php'"; 
            echo "</script>";

               
    
}

}}else{
    echo "<script>";
            echo "alert(\"รหัสผ่านที่ยืนยันไม่ตรงกัน\");";
            echo "history.back();"; 
            echo "</script>";

}
            mysqli_close ($con);

?>





