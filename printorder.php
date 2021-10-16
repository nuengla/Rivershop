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
<style type="text/css" media="print">
  /*@page { size: landscape; }*/
    * {
    margin: 0;
    padding: 0;
    font-family: 'Angsana new', sans-serif;
    box-sizing: border-box;
    background-color: white;
}
@page {
  
    margin: 20px 20px;
}
.trow{
    border: 1px solid;
}
.trow table{
    width: 100%
}
</style>

<body onload="window.print();">



    


<?PHP 
function convert($number){ 
$txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
$txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
$number = str_replace(",","",$number); 
$number = str_replace(" ","",$number); 
$number = str_replace("บาท","",$number); 
$number = explode(".",$number); 
if(sizeof($number)>2){ 
return ; 
exit; 
} 
$strlen = strlen($number[0]); 
$convert = ''; 
for($i=0;$i<$strlen;$i++){ 
	$n = substr($number[0], $i,1); 
	if($n!=0){ 
		if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
		elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
		elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
		else{ $convert .= $txtnum1[$n]; } 
		$convert .= $txtnum2[$strlen-$i-1]; 
	} 
} 

$convert .= 'บาท'; 
if($number[1]=='0' OR $number[1]=='00' OR 
$number[1]==''){ 
$convert .= 'ถ้วน'; 
}else{ 
$strlen = strlen($number[1]); 
for($i=0;$i<$strlen;$i++){ 
$n = substr($number[1], $i,1); 
	if($n!=0){ 
	if($i==($strlen-1) AND $n==1){$convert 
	.= 'เอ็ด';} 
	elseif($i==($strlen-2) AND 
	$n==2){$convert .= 'ยี่';} 
	elseif($i==($strlen-2) AND 
	$n==1){$convert .= '';} 
	else{ $convert .= $txtnum1[$n];} 
	$convert .= $txtnum2[$strlen-$i-1]; 
	} 
} 
$convert .= 'สตางค์'; 
} 
return $convert; 
} 
## วิธีใช้งาน
/*$x = '9123568543241.25'; 
echo  $x  . "=>" .convert($x);*/ 
?>

<?php
    session_start();
    include ("condb.php");
    $mem_id = $_SESSION['mem_id'];
    $mem_name = $_SESSION['mem_name'];
    $o_id = $_GET['o_id'];
    $admin = $_GET['admin'];
    $page = $_GET['page'];
    $day = date('d/m/Y');
    $sql = "SELECT * FROM orderdt,product,pro_size,pro_type WHERE o_id=$o_id AND orderdt.p_id=product.p_id 
    AND product.ps_id=pro_size.ps_id AND product.pt_id=pro_type.pt_id";
    $result = mysqli_query($con, $sql);
    $sql1 = "SELECT * FROM orders,transport,member WHERE o_id=$o_id AND orders.t_id=transport.t_id AND orders.mem_id=member.mem_id";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $dttm1 = $row1["o_date"];
            $dttm = date('Ymd', strtotime($dttm1));
            $dayorder = date('d/m/Y', strtotime($dttm1));
            $add_detail = $row1["mem_address"]."<br>".$row1["mem_add_district"]." ".$row1["mem_add_amphur"]." ".$row1["mem_add_province"].
            " ".$row1["mem_add_zipcode"];
    $addnew = $row1["addnew"];
    $bank ="SELECT * FROM bank ";
    $resultbank = mysqli_query($con,$bank);
    
?>

        
      
<div class='trow'>
		<table  align="center"  class="slip">
         <thead>
             <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td width="200">&nbsp;</td>
                 <td width="200">&nbsp;</td>
             </tr>
            <tr>
                <td colspan="8" align="center"><h1>ใบสั่งสินค้า</h1><h4>RIVER@WANGLANG</h4></td>
            </tr>
           <tr> 
               <td colspan="8"  align="center">150/107  หมู่บ้านสว่างจิต ซอยสวนผัก 2 ถนนสวนผัก<br>
               แขวงตลิ่งชัน เขตตลิ่งชัน กรุงเทพฯ 10170
            </td>
            </tr>
            <tr>
                <td colspan="7"></td>
                <td colspan="1">วันที่สั่งสินค้า : <?php echo $dayorder;?></td>
            </tr>
            <tr>
<td colspan="3"  align="left">

เลขที่การสั่งซื้อ : <?php echo $o_id;?><br>
ชื่อลูกค้า : <?php echo $row1["mem_name"];?><br>
ที่อยู่ : <?php echo $add_detail;?><br>
เบอร์โทรศัพท์ : <?php echo $row1["mem_tel"];?><br>

</td>
<td colspan="5" valign="top" align="left">
ที่อยู่ในการจัดส่ง<br>
ที่อยู่ :  <?php if ($addnew == "1") {
                    $sql211 = "SELECT * FROM orders,address_ WHERE orders.o_id=$o_id AND orders.o_id=address_.o_id";
                    $result211 = mysqli_query($con, $sql211);
                    $row211 = mysqli_fetch_array($result211);
                    $add_detail = $row211["add_address"] . "<br>"
                        . $row211["add_add_district"] . " " . $row211["add_add_amphur"] . " " . $row211["add_add_province"];
                    $zipcode = $row211["add_add_zipcode"];
                } elseif ($addnew == "0") {
                    $add_detail = $row1["mem_address"] . "<br>"
                        . $row1["mem_add_district"] . " " . $row1["mem_add_amphur"] . " " . $row1["mem_add_province"];
                    $zipcode = $row1["mem_add_zipcode"];
                }
                echo $add_detail." ";
                echo $zipcode;
                ?>

</td>
            </tr>
            </table>
            </div>
            <div class='trow'>
            <table  align="center"  class="slip"  >
           <tr>
               <td  align="center" width="50"><strong>ลำดับ</strong></td>
      <td align="center" width="300"><strong> รายการสินค้า </strong></td>
      <td align="center" width="100"><strong> ประเภท </strong></td>
      <td align="center" width="100"><strong> ขนาด </strong></td>
      <td align="right" width="80"><strong> ราคา/ชิ้น </strong></td>
      <td align="right" width="80"><strong> จำนวน(ชิ้น) </strong></td>
      <td align="right" width="80"><strong> ส่วนลด(%) </strong></td>
	  <td align="right" width="100"><strong> ราคารวม(บาท) </strong></td>

 
    </tr>
    </thead>
		<?php 
				
               $i = 1;
                while ($row = mysqli_fetch_array($result)){
                    $price = $row["p_price"];
                    $unit = $row['od_prounit'];
                    $sum = $row['od_totalprice'];
                    $pricedis = $sum / $unit;
                   
                    $total1 += $sum;
                    $transport = $row1['t_price'];
                    $total =$total1 + $transport;
                    $x = $total;
                    $pr =  $pricedis * 100;
                    $pr1 = $pr / $price;
                    $salepercent1  = 100 - $pr1;
                    $salepercent = floor($salepercent1)."%";
                    if($salepercent==0){
                        $salepercent = number_format($salepercent1,1)."%" ;
                    }
                    if($salepercent==0.0){
                        $salepercent = " ";
                    }
                   
                echo "<tr >";
                echo "<td align='center'>" .$i. "</td>";
				echo "<td>" .$row["p_name"]. "</td>";
				echo "<td align='center'>" .$row["pt_name"]. "</td>";
                echo "<td align='center'>" .$row["ps_name"]. "</td>";
                echo "<td align='right'>" .number_format(($row["p_price"]),2). "</td>";
                echo "<td align='right'>" .$row["od_prounit"]. "</td>";
                echo "<td align='right'>" .$salepercent. "</td>";
                echo "<td style='text-align:right'>" .number_format($row["od_totalprice"],2)."</td>";
                echo "</tr>";
               $i++;
                }
               
                
                echo "<tr>";
                echo "<td colspan='7'style='text-align:left'>การจัดส่ง : ".$row1["t_name"]."</td>";
                echo "<td style='text-align:right'>".number_format(($transport),2)."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='7'style='text-align:left'>จำนวนเงินรวมทั้งสิ้น : ".convert($x)." </td>";
                echo "<td style='text-align:right'>".number_format(($total),2)."</td>";
                echo "</tr></table></div>";
                ?>
                <div class='trow'>
                <table  align="center"  class="slip"  >
                <tr>
                 <td>หมายเหตุ</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
             </tr>
               
                <tr>
                    <td colspan="4">ช่องทางการโอนเงิน <br>
                    <?php while($rowb = mysqli_fetch_array($resultbank)){?>
                        ธนาคาร : <?php echo $rowb["b_name"];?> สาขา : <?php echo $rowb["bn_name"];?> เลขบัญชี : <?php echo $rowb["b_number"];?><br>


                    <?php }?>

                </td>
                    <td colspan="2" valign="bottom" align="center">-------------------------<br>( <?php echo $row1["mem_name"];?>) <br>ผู้สั่งซื้อ</td>
                    <td colspan="2" valign="bottom" align="center">-------------------------<br>นราธิป อาชวโศภณ ) <br>ผู้ตรวจสอบ</td>
                </tr>
    </table>
    </div><br>
    
 
    
    
</body>
</html>
