<?php
    session_start();
    include ("condb.php");
    $id = $_SESSION['mem_id'];
    $name = $_SESSION['mem_name'];
    $level = $_SESSION['mem_type'];
   $cart = $_SESSION['cart'];
  

if (empty($id)) {

    echo "<script>";
    echo "alert(\"กรุณาเข้าสู่ระบบ\");";
    echo "window.location='login.php'";
    echo "</script>";
}
    $sql1 = "SELECT * FROM member WHERE mem_id=$id ";
        $result1 = mysqli_query($con, $sql1);
        $row1 = mysqli_fetch_array($result1);

?>

<div class="navbar">
            <div class="navmenu">
                <ul>

                  
                    <li><a href="#">ยินดีต้อนรับคุณ : <b><?php echo $row1['mem_name']; ?></b> </a>
                    <ul>
                            <li><a href="edit_mem.php">-แก้ไขข้อมูลส่วนตัว</a></li>
                            <li><a href="mem_order.php">-ประวัติการสั่งซื้อ</a></li>
                            <li><a href="payment.php">-แจ้งชำระค่าสินค้า</a></li>
                           
                        </ul>
                    </li>
                    <li><a href="cart.php">ตะกร้าสินค้า (<?php 
                     
                     
                     if(empty($cart)){
                        $cart = 0;
                        echo $cart;
                    }else{
                        echo count($cart);
                    }
                    
                    ?>)</a></li>
                    
                    <li><form action="" method="GET">
                    <input type="text" name="search" placeholder="ค้นหาสินค้า"> <input class="btn_ok" type="submit" value="ค้นหา">
                    </form></li>
                    <li><a href="#">ช่วยเหลือ</a>
                        <ul>
                            <li><a href="tb_size.php">-ตารางวัดไซส์</a></li>
                            <li><a href="how.php?page=shop">-วิธีสั่งสินค้า</a></li>
                                <li><a href="how.php?page=pay">-วิธีชำระเงิน</a></li>
                                <li><a href="how.php?page=regis">-วิธีสมัครสมาชิก</a></li>
                           
                        </ul>
                    </li>
                    <li><a href="#">เกี่ยวกับเรา</a>
                        <ul>
                            <li><a href="about.php?page=me">-ติดต่อเรา</a></li>
                            <li><a href="about.php?page=map">-แผนที่ร้าน</a></li>
                        </ul>
                    </li>
                    <li><a href="complaint.php">แนะนำ ติ/ชม</a></li>
                </ul>
            </div>
           <div class="navuser">
               <ul>
                    
                    <li><a href="logout.php">ออกจากระบบ</a></li>   
                </ul>
            </div>
            
        </div>