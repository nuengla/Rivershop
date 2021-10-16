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
<?php
    session_start();
    include ("condb.php");
    $mem_id = $_SESSION['mem_id'];
    $mem_name = $_SESSION['mem_name'];
    $id = $_GET['id'];

?>
<script language="javascript">
    function deler (){
        if(confirm('ยืนยันการลบ')){
            return true;
            
        }else{
            return false;
        }
    }
</script>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php include "navbar_admin.php";?>
    <div class="conten"><br>
    <?php
    $act = $_REQUEST['act']; 
    if(empty($act)){
    ?>
    <h1>จัดการสมาชิก</h1>
   <br>
   <form action="" method="GET">
                    ค้นหาสมาชิก <input type="text" name="search" placeholder="กรอกชื่อสมาชิกหรือชื่อบัญชี"> <input class="btn_sys" type="submit" value="ค้นหา">
                    </form>
   <table border="1">
   <tr>
   <td width="90" bgcolor="#00fffc">เลขที่สมาชิก</td>
   <td width="100" bgcolor="#00fffc">user</td>
   <td width="200" bgcolor="#00fffc">ชื่อ</td>
   <td width="100" bgcolor="#00fffc">จำนวนการสั่งซื้อ</td>
   <td width="90" bgcolor="#00fffc">ประเภท</td>
  
   <td width="50" bgcolor="#00fffc">ลบ</td>
   
   </tr>
   <?php
   include "condb.php";
   $search = $_GET['search'];
   if (!empty($search)) {
       $sql = "SELECT * FROM member
WHERE NOT mem_id='$mem_id' AND mem_name LIKE '%$search%' OR mem_user LIKE '%$search%' ";
       $result1 = mysqli_query($con,$sql);
       $r = mysqli_num_rows($result1);
       if ($r == 0) {
           $output = 'ไม่มีสินค้าที่ค้นหา';
       }}else{
        $sql ="SELECT * FROM member WHERE NOT mem_id='$mem_id'";
        $result1 = mysqli_query($con,$sql);
       }
   
   while($row = mysqli_fetch_array($result1)){ 
   $mem = $row["mem_id"];
   $sqlnum ="SELECT * FROM orders WHERE mem_id='$mem' AND s_id=3";
   $resultnum = mysqli_query($con,$sqlnum);
   $memcount = mysqli_num_rows($resultnum);
       if($row['mem_type']==1){
           $type = "ผู้ดูแลระบบ";
       }elseif($row['mem_type']==2){
           $type = "สมาชิก";
       }?>
   <tr>
    <td ><?php echo $row['mem_id'];?></td>
   <td><?php echo $row['mem_user'];?></td>
   <td ><?php echo $row['mem_name'];?></td>
   <td ><?php echo $memcount;?></td>
   <td ><?php echo $type;?></td>
  
  
   <td ><a href="admin_edit_mem.php?&mem_id=<?php echo $row['mem_id'];?>&act=delete" onclick="return deler();"> <input type="button" class="btn_red" value="ลบ"></a></td>
   <?php }
?>   
   </tr>
  </table>
<br>
    </div>
    <?php  }?>
    <?php 
    include "condb.php";
    
    $act = $_REQUEST['act'];
    $mem_id = $_GET['mem_id'];
    if($act=="delete"){
        
        $delet = "DELETE FROM member WHERE mem_id=$mem_id";
        $result4 = mysqli_query($con,$delet);
    }
    if($result4){
    echo "<script>";
            
            echo "window.location='admin_edit_mem.php'"; 
            echo "</script>";
    }
    ?>
     <?php
     include "condb.php";
    $act = $_REQUEST['act'];
    $act1 = $_REQUEST['act1'];
    $mem_id = $_GET['mem_id']; 
    if($act=="edit"){
    
    ?>
    <h1>แก้ไขข้อมูลสมาชิก</h1>
        <?php
        $sql = "SELECT * FROM member WHERE mem_id=$mem_id ";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        
        
        ?>
        <br>
            <table  class="tableregis" align="center">
                <form name="login" action="admin_edit_mem.php?act=edit_up" method="POST" id="register">
                <tr>
                        <td><div align="left"><label>Username</label></td>
                        <td><div align="left"><input type="text" value="<?php echo $row['mem_user'];?>" name="mem_user" required class="form-control" id="Admin_password" placeholder="กรุณากรอกPassword" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2" ></div></td>
                    </tr>
                    <tr>
                        <td width="150"><div align="left"><label>Password</label></td>
                        <td><div align="left"><input type="hidden" name="mem_id" value="<?php echo $row['mem_id'];?>"><input type="text" value="<?php echo $row['mem_password'];?>" name="mem_password" required class="form-control" id="Admin_password" placeholder="กรุณากรอกPassword" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2" ></div></td>
                    </tr>
                    <tr>
                        <td ><div  align="left"><label>ชื่อ</label></div></td>
                        <td><div  align="left"><input type="text" value="<?php echo $row['mem_name'];?>" name="mem_name" placeholder="กรุณากรอกชื่อและนามสกุล"required></div></td>
                    </tr>
                   
                    <tr>
                            <td align="left">รายละเอียดที่อยู่</td>
                            <td align="left"><label> <?php echo $row["mem_address"]; ?></label></td>
                        </tr>
                        <tr>
                            <td align="left">จังหวัด</td>
                            <td align="left"><label> <?php echo $row["mem_add_province"]; ?></label></td>
                        </tr>
                        <tr>
                            <td align="left">เขต/อำเภอ</td>
                            <td align="left"><label> <?php echo $row["mem_add_amphur"]; ?></label></td>
                        </tr>
                        <tr>
                            <td align="left">แขวง/ตำบล</td>
                            <td align="left"><label> <?php echo $row["mem_add_district"]; ?></label></td>
                        </tr>
                        <tr>
                            <td align="left">รหัสไปรษณีย์</td>
                            <td align="left"><label> <?php echo $row["mem_add_zipcode"]; ?></label></td>
                        </tr>
                        <?php if ($act1 == "" && $act == "edit") { ?>
                        <tr>
                            <td></td>
                            <td align="left"><a href="admin_edit_mem.php?mem_id=<?php echo $row['mem_id'];?>&act=edit&act1=addnew"><input type="button" class="btn_sys" value="แก้ไขที่อยู่"></a> </td>
                        </tr>
                        <?php }elseif($act1 == "addnew" && $act == "edit")
                        {} ?>
                        <?php if ($act1 == "addnew") { ?>
                        <tr>
                        <td colspan="2"><hr></td>
                        </tr>
                            <tr>
                                <td><input type="hidden" name="addnew" value="1"></td>

                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>รายละเอียดที่อยู่(แก้ไข)</label></div>
                                </td>
                                <td>
                                    <div align="left"><textarea name="mem_address" cols="45" rows="5" placeholder="กรุณากรอกบ้านเลขที่/ซอย/หมู่บ้าน/ถนน" required><?php echo $row["mem_address"]; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>จังหวัด(แก้ไข)</label></div>
                                </td>
                                <td>
                                    <div align="left"><select name="province" id="province">
                                            <option>- กรุณาเลือกจังหวัด -
                                            </option>
                                        </select></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>เขต/อำเภอ(แก้ไข)</label></div>
                                </td>
                                <td>
                                    <div align="left"><select name="amphur" id="amphur">
                                            <option value="name">- กรุณาเลือกอำเภอ -</option>
                                        </select></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>แขวง/ตำบล(แก้ไข)</label></div>
                                </td>
                                <td>
                                    <div align="left"><select name="district" id="district">
                                            <option>- กรุณาเลือกตำบล -</option>
                                        </select></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="left"><label>รหัสไปรษณีย์(แก้ไข)</label></div>
                                </td>
                                <td>
                                    <div align="left"><input name="postcode" id="postcode" placeholder="รหัสไปรษณีย์"></div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td align="left"><a href="admin_edit_mem.php?mem_id=<?php echo $row['mem_id'];?>&act=edit"><input type="button" class="btn_red" value="ปิดหน้าต่างแก้ไขที่อยู่"></a></td>
                            </tr>
                            <tr>
                            <td colspan="2"><hr></td>
                            </tr>
                        <?php } ?>
                        <td><div align="left"><label>เบอร์โทรศัพท์</label></div></td>
                        <td><div align="left"><input type="text" value="<?php echo $row['mem_tel'];?>" name="mem_tel"required class="tel" id="tel" placeholder="กรุณากรอกเบอร์โทรศัพท์" pattern="^[0-9]+$" title="กรอกเบอร์โทรศัพท์ให้ถูกต้อง" minlength="10"maxlength="10" ></div></td>
                    </tr>
                    <tr>
                        <td><div align="left"><label>ประเภทสมาชิก</label></div></td>
                       
                        <td><div align="left">
                        
                        <select name="mem_type">
                        <?php if(($row['mem_type'])==2){ ?>
                           
                            <option value="2">สมาชิก</option><option value="1">ผู้ดูแลระบบ</option>
                          
                        <?php }else{ ?>
                           
                            <option value="1">ผู้ดูแลระบบ</option><option value="2">สมาชิก</option>
                            
                        <?php
                        }
                        ?>
                         
                         </select>
                        
                        
                        </div></td>
                    </tr>
                    <tr>
                    <td colspan="2"><div align="center">
                    <a href="admin_edit_mem.php"><input type="button" name="back" class="btn_sys" value="ย้อนกลับ"></a>
                        <input type="submit" name="register" class="btn_green" value="แก้ไขข้อมูลสมาชิก">
                       </div></td>
                    </tr>
                </form>
            </table>
<br>
    </div>
    <?php  }?>
    <?php
     include "condb.php";
    $act = $_REQUEST['act'];
    if($act=="edit_up"){
        $mem_user = $_POST['mem_user'];
$mem_name = $_POST['mem_name'];
$mem_tel = $_POST['mem_tel'];
$mem_id = $_POST['mem_id'];
$mem_type = $_POST['mem_type'];
$mem_password = $_POST['mem_password'];
$mem_address = $_POST['mem_address'];
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
    $sqlUpdatePd="UPDATE member SET mem_password='$mem_password',mem_name='$mem_name',mem_address='$mem_address',mem_add_province='$province',mem_add_amphur='$amphur',mem_add_district='$district',mem_add_zipcode='$zipcode',mem_tel='$mem_tel',mem_type='$mem_type' WHERE mem_id='$mem_id'";
    $query5	= mysqli_query($con, $sqlUpdatePd);

}else{


    $sqlUpdatePd="UPDATE member SET mem_user='$mem_user',mem_password='$mem_password',mem_name='$mem_name',mem_tel='$mem_tel' ,mem_type='$mem_type' WHERE mem_id='$mem_id'";
    $query5	= mysqli_query($con, $sqlUpdatePd);
}



		$query5	= mysqli_query($con, $sqlUpdatePd);


        if($query5){
	
            
            echo "<script>";
    echo "alert(\"แก้ไขข้อมูลสมาชิกเรียบร้อย\");";
    echo "window.location='admin_edit_mem.php'"; 
    echo "</script>";
        }else{
            echo "<script>";
    echo "alert(\"เกิดความผิดพลาด\");";
    echo "window.location='admin_edit_mem.php'"; 
    echo "</script>";

        }
    }
    ?>
    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
    <script src="jquery/jquery.min.js"></script> 
<script type="text/javascript" src="AutoProvince.min.js"></script> 
<script>
	$('body').AutoProvince({
		PROVINCE:		'#province', // select div สำหรับรายชื่อจังหวัด
		AMPHUR:			'#amphur', // select div สำหรับรายชื่ออำเภอ
		DISTRICT:		'#district', // select div สำหรับรายชื่อตำบล
		POSTCODE:		'#postcode', // input field สำหรับรายชื่อรหัสไปรษณีย์
		GEOGRAPHY:		'#geography', // input field แสดงภาค
		CURRENT_PROVINCE:1, //  แสดงค่าเริ่มต้น ใส่ไอดีจังหวัดที่เคยเลือกไว้
		CURRENT_AMPHUR:1, // แสดงค่าเริ่มต้น  ใส่ไอดีอำเภอที่เคยเลือกไว้
		CURRENT_DISTRICT:1, // แสดงค่าเริ่มต้น  ใส่ไอดีตำบลที่เคยเลือกไว้
		arrangeByName:	true // กำหนดให้เรียงตามตัวอักษร
	});
</script>

<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  });


</script> 
</body>
</html>