<?php  
ini_set('display_error',0);
ob_start();
include("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");
$ani1=$_REQUEST['ANI'];
$ani=substr($ani1,1);
$dnis=$_REQUEST['realDNIS'];


$getCircle = "select master_db.getCircle(".trim($ani).") as circle";
					$circle=mysql_query($getCircle,$dbConn);
					list($circle)=mysql_fetch_array($circle);
					if(!$circle)
					{ 
					$circle='UND';
					}

$getOperator = "select master_db.getOperator(".trim($ani).") as operator";
					$operator=mysql_query($getOperator,$dbConn);
					list($operator)=mysql_fetch_array($operator);
					if(!$operator)
					{ 
					$operator='UND';
					}					
					
$logpath="/var/www/html/hungamacare/missedcall/api/logs/POCMissedAPIlog_".date('Ymd').".txt";
$logData_SMS='';
$logData_SMS=$ani."#".$dnis."#".$circle."#".$operator."#".$ani1."#".date("Y-m-d H:i:s")."\n";
error_log($logData_SMS,3,$logpath);
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$message='Thanks for reaching out to Hungama Brands. We shall get back to you soon.';
$savemissedcalldata="insert into master_db.tbl_sendsms_tpurl(ani,message,date_time,status,dnis,circle)
	values('$ani', '$message', now(),'0','$dnis','$circle')";
mysql_query($savemissedcalldata, $dbConn);	
	
require '/var/www/html/hungamacare/missedcall/api/contents.php';
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';
//unlink("emailcontent.html");
$mail = new PHPMailer();
$mail->Encoding='base64';
$mail->setFrom('brands.mis@hungama.com', '');
//Set an alternative reply-to address
$mail->addReplyTo('brands.mis@hungama.com', 'HungamaBrands');
//Set who the message is to be sent to
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('rahul.jain@hungama.com', 'Rahul Jain');
$mail->addAddress('Kunalk.arora@hungama.com', 'Kunalk Arora');
$mail->addAddress('Gaurav.talwar@hungama.com', 'Gaurav Talwar');
$mail->addAddress('Rishi.sundd@hungama.com', 'Rishi Sundd');
$mail->addAddress('Ashish.talwar@hungama.com', 'Ashish Talwar');
$mail->addAddress('rishi.misra@hungama.com', 'Rishi Misra');


//Set the subject line
$mail->Subject = 'Missed Call - +91'.$ani;
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('emailcontent.html'), dirname(__FILE__));
//Attach an image file
$mail->addAttachment($filepath);

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
//delete CSV file from server
unlink($filepath);
}
ob_end_clean();
exit;
?>