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

<style>
.conten{
    height: 50vh;
}


</style>
<body>
<?php
    session_start();
    include ("condb.php");
    $id = $_SESSION['mem_id'];

    if(isset($id)){

        unset($_SESSION['mem_id']);
    }

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
        <h1>เข้าสู่ระบบ</h1>
        <br><table>
        <form name="login" action="checklogin.php" method="POST" id="login">
        <tr >
            <td align="right"> <label>ชื่อบัญชี : </label></td>
            <td><input type="text" name="username" placeholder="ชื่อบัญชี/username"></td>
        </tr>
        <tr>
            <td align="right"><label>รหัสผ่าน : </label></td>
            <td><input type="password" name="password" method="POST" placeholder="รหัสผ่าน" ></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" class ="btn_main" value="เข้าสู่ระบบ" style=width:280px; >  </td>
        </tr>
        <tr>
        <td colspan="2"> <a href="register.php"><input type="button" class ="btn_sys" style=width:280px; value="สมัครสมาชิก" /></a></td>
        </tr>
        </form>

        </table>
        <br>
      
               
                
        
    </div>

    <div class="footer">
        
    <p>© 2020 RIVER @ WANG LANG</p>
   
    </div>
    </div>
</body>
</html>