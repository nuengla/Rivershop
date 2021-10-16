






<?php 
session_start();
include ("condb.php");
$mem_id = $_SESSION['mem_id'];
$mem_name = $_SESSION['mem_name'];
$o_id = $_POST['o_id'];
$pay_name = $_POST['pay_name'];
$b_id = $_POST['b_id'];
$pay_date = $_POST['pay_date'];
$pay_time = $_POST['pay_time'];
$pay_numref = $_POST['pay_numref'];
$pay_total = $_POST['pay_total'];
$pay_img = $_POST['pay_img'];

$s_id= "2";
if(!isset($_POST['b_id'])){	
    
    echo "<script>";
    echo "alert(\"กรุณาเลือกรูปแบบการชำระเงิน\");";
    echo "window.history.back()";
    echo "</script>";

}

$bank = "SELECT * FROM bank WHERE b_id=$b_id ";
$resultbank = mysqli_query($con, $bank);
$rowbank = mysqli_fetch_array($resultbank);

$ext = pathinfo(basename($_FILES['pay_img']['name']), PATHINFO_EXTENSION);
$new_img_name = 'pay_'.uniqid().".".$ext;
$img_path = "img_pay/";
$upload_path = $img_path.$new_img_name;

move_uploaded_file($_FILES['pay_img']['tmp_name'],$upload_path);
$pay_img = $new_img_name;

$sqlUpdatePd="UPDATE payment SET b_id='$b_id',pay_name='$pay_name',pay_date='$pay_date',pay_time='$pay_time',pay_img='$pay_img',pay_numref='$pay_numref',s_id='$s_id'WHERE o_id='$o_id'";
$query5	= mysqli_query($con, $sqlUpdatePd);
$sqlUpdatePd2="UPDATE orders SET s_id='$s_id'WHERE o_id='$o_id'";
$query2	= mysqli_query($con, $sqlUpdatePd2);


    $header = "แจ้งเตือนการชำระเงินของลูกค้า";
   

    $message = $header.
                "\n". "รหัสการสั่งสินค้า: " . $o_id .
                "\n". "ชื่อลูกค้า: " . $mem_name .
                "\n". "จำนวนเงินที่ต้องชำระ: " . $pay_total .
                "\n". "ชื่อบัญชีผู้โอนเงิน: " . $pay_name .
                "\n". "เลือกธนาคาร: " . $rowbank["b_name"] .
                "\n". "วันที่โอนเงิน: " . $pay_date .
                "\n". "เวลาที่โอนเงิน: " . $pay_time .
                "\n". "หมายเลขอ้างอิงการโอนเงิน: " . $pay_numref;

    if (isset($_POST["submit"])) {
        if ( $mem_name <> "" ||  $o_id <> "" ||  $pay_time <> "" ||  $pay_numref <> "" ) {
            sendlinemesg();
            header('Content-Type: text/html; charset=utf8');
            $res = notify_message($message);
            
            echo "<script>";
            echo "alert(\"บันทึกข้อมูลเรียบร้อย ทีมงานกำลังดำเนินการตรวจสอบ\");";
            echo "window.location='payment.php'"; 
            echo "</script>";
        } else {
            echo "<script>alert('บันทึกข้อมูลไม่สำเร็จ กรุณาติดต่อเจ้าหน้าที่ครับ');</script>";
            header("location: payment.php");
        }
    }

    function sendlinemesg() {
		// LINE LINE_API https://notify-api.line.me/api/notify
		// LINE TOKEN Gje4sZEioc6R4Z76G3S2pRqxfaC6TGUblOkmUm3BjKy แนะนำให้ใช้ของตัวเองนะครับเพราะของผมยกเลิกแล้วไม่สามารถใช้ได้
        define('LINE_API',"https://notify-api.line.me/api/notify");
        define('LINE_TOKEN',"Gje4sZEioc6R4Z76G3S2pRqxfaC6TGUblOkmUm3BjKy");

        function notify_message($message) {
            $queryData = array('message' => $message);
            $queryData = http_build_query($queryData,'','&');
            $headerOptions = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                                ."Authorization: Bearer ".LINE_TOKEN."\r\n"
                                ."Content-Length: ".strlen($queryData)."\r\n",
                    'content' => $queryData
                )
            );
            $context = stream_context_create($headerOptions);
            $result = file_get_contents(LINE_API, FALSE, $context);
            $res = json_decode($result);
            return $res;
        }
    }


?>
