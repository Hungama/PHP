<?php
error_reporting(0);
$PrevDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$filedate=date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$filedate2daysback=date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
//$PrevDate='2014-11-26';
//$filedate='20141126';
$reportdate=date('j F ,Y ',strtotime($PrevDate));
require '/var/www/html/hungamacare/missedcall/admin/html/mis/email/contents.php';
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Set who the message is to be sent from
//set encoding
$mail->Encoding='base64';
$mail->setFrom('ms.mis@hungama.com', 'MS Mis');
//Set who the message is to be sent to
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('reeju.jain@hungama.com', 'Reeju Jain');
$mail->addAddress('vinod.chauhan@hungama.com', 'Vinod Chauhan');
$mail->addAddress('rishi.sundd@hungama.com', 'Rishi Sundd');
$mail->addAddress('gagandeep.matnaja@hungama.com', 'Gagandeep Matnaja');
$mail->addAddress('shreya.tyagi@hungama.com', 'Shreya Tyagi');
$mail->addAddress('arup.dutta@hungamadigitalservices.com', 'Arup Dutta');
$mail->addAddress('prateek.banerjee@hungamadigitalservices.com', 'Prateek Banerjee');
$mail->addAddress('surojit.sen@jwt.com', 'Surojit Sen');
$mail->addAddress('roop.ghosh@jwt.com', 'Roop Ghosh');

//$mail->addAddress('rahul.tripathi@hungama.com', 'Rahul tripathi');

//Set the subject line
$mail->Subject = 'Radio Mitr Report - '.$PrevDate;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$htmlfilename='tisconReportData_'.$filedate.'.html';
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
unlink($filepath_2);
unlink($htmlfilename);
//unlink($newZip);
}

//unlink last 2 days back files
$newZip2daysback = 'Allusertisconreport_' . $filedate2daysback . '.zip';
unlink($newZip2daysback);
exit;
?>
