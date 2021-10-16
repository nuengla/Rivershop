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
<?php
    session_start();
    include ("condb.php");
    $mem_id = $_SESSION['mem_id'];
    $mem_name = $_SESSION['mem_name'];
    $act = $_REQUEST['act'];

?>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <?php include "navbarmemin.php"?>
        <div class="conten"><br>
        <h1>แก้ไขข้อมูลส่วนตัว</h1>
        <?php
        $sql = "SELECT * FROM member WHERE mem_id=$mem_id ";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        ?>
        <br>
            <table  class="tableregis" align="center">
                <form name="login" action="update_mem.php" method="POST" id="register">
                    
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
                        <?php if ($act == "") { ?>
                        <tr>
                            <td></td>
                            <td align="left"><a href="edit_mem.php?act=addnew"><input type="button" class="btn_sys" value="แก้ไขที่อยู่"></a> </td>
                        </tr>
                        <?php }else{} ?>
                        <?php if ($act == "addnew") { ?>
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
                                    <div align="left"><textarea name="mem_address" cols="45" rows="5" placeholder="กรุณากรอกบ้านเลขที่/ซอย/หมู่บ้าน/ถนน" required> <?php echo $row["mem_address"]; ?></textarea>
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
                                <td align="left"><a href="edit_mem.php"><input type="button" class="btn_red" value="ปิดหน้าต่างแก้ไขที่อยู่"></a></td>
                            </tr>
                            <tr>
                            <td colspan="2"><hr></td>
                            </tr>
                        <?php } ?>
                    <tr>
                        <td><div align="left"><label>เบอร์โทรศัพท์</label></div></td>
                        <td><div align="left"><input type="text" value="<?php echo $row['mem_tel'];?>" name="mem_tel"required class="tel" id="tel" placeholder="กรุณากรอกเบอร์โทรศัพท์" pattern="^[0-9]+$" title="กรอกเบอร์โทรศัพท์ให้ถูกต้อง" minlength="10"maxlength="10" ></div></td>
                    </tr>
                    <tr>
                    <td colspan="2"><div align="center"><br>
                        <input type="submit" name="register" class="btn_green" value="แก้ไขข้อมูลส่วนตัว">
                        </div></td>
                    </tr>
                </form>
            </table>
    </div>
 
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