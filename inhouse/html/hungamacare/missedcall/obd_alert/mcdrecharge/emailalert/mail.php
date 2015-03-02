<?php
error_reporting(0);
exit;//stopped beacuase service closed-23 Feb 2015

$PrevDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$filedate=date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$PrevDate='2015-01-03';
//$filedate='20150103';
$reportdate=date('j F ,Y ',strtotime($PrevDate));
require '/var/www/html/hungamacare/missedcall/obd_alert/mcdrecharge/emailalert/contents.php';
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Set who the message is to be sent from
//set encoding
$mail->Encoding='base64';
$mail->setFrom('ms.mis@hungama.com', 'MS Mis');
//Set who the message is to be sent to
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('gagandeep.matnaja@hungama.com', 'Gagandeep Matnaja');
$mail->addAddress('shreya.tyagi@hungama.com', 'Shreya Tyagi');
//Set the subject line
$mail->Subject = 'Service Alert - Enterprise - McDowells Recharge Data of date '.$PrevDate;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$htmlfilename='rechargeEnterpriseMcDw_'.$filedate.'.html';
$mail->msgHTML(file_get_contents($htmlfilename), dirname(__FILE__));
//Attach an image file
$mail->addAttachment($newZip);

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
	//delete CSV file from server
	sleep(10);
unlink($filepath);
unlink($htmlfilename);
unlink($newZip);
}
exit;
?>