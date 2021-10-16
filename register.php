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
    include("condb.php");
    $id = $_SESSION['mem_id'];
    $name = $_SESSION['mem_name'];
    $level = $_SESSION['mem_type'];

    ?>
    <div class="container">
        <div class="banner">
        <img src="img_web/bannernew1.png ">
        </div>
        <div class="navbar">
            <div class="navmenu">
                <ul>
                    <li><a href="index.php">กลับสู่หน้าหลัก</a></li>
                </ul>
            </div>


        </div>
        <div class="conten"><br>
            <h1>สมัครสมาชิก</h1>
            <br>
            <table class="tableregis" align="center" border="1">
                <form name="login" action="checkregister.php" method="POST" id="register">
                    <tr>
                        <td width="150px">
                            <div align="left"><label>ชื่อบัญชี/username</label></div>
                        </td>
                        <td>
                            <div align="left"><input type="text" name="mem_user" required class="form-control" id="Admin_username" placeholder="กรอกชื่อบัญชี/username" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2"><span><font color="red">**</font></span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="left"><label>รหัสผ่าน</label>
                        </td>
                        <td>
                            <div align="left"><input type="password" name="mem_password" required class="form-control" id="Admin_password" placeholder="กรอกรหัสผ่าน" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2"><span><font color="red">**</font></span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="left"><label>ยันยันรหัสผ่าน</label>
                        </td>
                        <td>
                            <div align="left"><input type="password" name="mem_password1" required class="form-control" id="Admin_password" placeholder="ยืนยันรหัสผ่านอีกครั้ง" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2"><span><font color="red">**</font></span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="left"><label>ชื่อ - นามสกุล</label></div>
                        </td>
                        <td>
                            <div align="left"><input type="text" name="mem_name" placeholder="กรอกชื่อและนามสกุล" required></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="left"><label>ที่อยู่</label></div>
                        </td>
                        <td>
                        
                            <div align="left"><textarea name="mem_address" cols="45" rows="5" placeholder="กรอกบ้านเลขที่/ซอย/หมู่บ้าน/ถนน" required></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="left"><label>จังหวัด</label></div>
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
                            <div align="left"><label>เขต/อำเภอ</label></div>
                        </td>
                        <td>
                            <div align="left"><select name="amphur" id="amphur">
                                    <option value="name">- กรุณาเลือกอำเภอ -</option>
                                </select></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="left"><label>แขวง/ตำบล</label></div>
                        </td>
                        <td>
                            <div align="left"><select name="district" id="district">
                                    <option>- กรุณาเลือกตำบล -</option>
                                </select></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="left"><label>รหัสไปรษณี</label></div>
                        </td>
                        <td>
                            <div align="left"><input name="postcode" id="postcode" placeholder="รหัสไปรษณีย์"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="left"><label>เบอร์โทรศัพท์</label></div>
                        </td>
                        <td>
                            <div align="left"><input type="text" name="mem_tel" required class="tel" id="tel" placeholder="กรอกเบอร์โทรศัพท์" pattern="^[0-9]+$" title="กรอกเบอร์โทรศัพท์ให้ถูกต้อง" minlength="10" maxlength="10"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="center">
                                <label><font color="red">กรุณากรอกข้อมูลตามความเป็นจริง</font></label><br>
                                <input type="submit" class="btn_green" name="register" value="สมัครสมาชิก">
                                </div>
                        </td>
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