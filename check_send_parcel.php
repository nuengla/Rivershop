<?php  
   session_start();
   include ("condb.php");

   $o_id = $_POST['o_id'];
   $o_parcelnum	 = $_POST['o_parcelnum'];
    $s_id="3";
    
    $sqlUpdatePd="UPDATE orders SET o_parcelnum='$o_parcelnum',s_id='$s_id' WHERE o_id='$o_id'";
    $query5	= mysqli_query($con, $sqlUpdatePd);
    $sqlUpdatePd2="UPDATE payment SET s_id='$s_id' WHERE o_id='$o_id'";
    $query2	= mysqli_query($con, $sqlUpdatePd2);
    
    if($query5&&$query2){
        
        echo "<script>";
        echo "alert(\"บันทึกข้อมูลเรียบร้อย\");";
        echo "window.location='admin.php'"; 
        echo "</script>";
       }
        else{
          echo "<script>";
            echo "บันทึกข้อมูลไม่สำเร็จ กรุณาติดต่อเจ้าหน้าที่ครับ ";
            echo "window.history.back()";
            echo "</script>";
            	
        }
?>