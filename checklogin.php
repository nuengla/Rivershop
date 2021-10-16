<?php 
session_start();

        if(isset($_POST['username'])){
                  include("condb.php");
                  $username = $_POST['username'];
                  $password = $_POST['password'];

                  $sql="SELECT * FROM member 
                  WHERE  mem_user='".$username."' 
                  AND  mem_password='".$password."' ";
                  $result = mysqli_query($con,$sql);
				
                  if(mysqli_num_rows($result)){
                      $row = mysqli_fetch_array($result);

                      $_SESSION["mem_id"] = $row["mem_id"];
                      $_SESSION["mem_name"] = $row["mem_name"];
                      $_SESSION["mem_type"] = $row["mem_type"];

                      if($_SESSION["mem_type"]=="1"){ 

                        Header("Location: admin.php");
                      }
                  if ($_SESSION["mem_type"]=="2"){ 
                    

                        Header("Location: index_mem.php");
                    
                      }
                  }else{
                    echo "<script>";
                        echo "alert(\" user หรือ  password ไม่ถูกต้อง\");"; 
                        echo "window.history.back()";
                    echo "</script>";
 
                  }
                  
        }else{


             Header("Location: index_mem.php");
 
        }
?>
