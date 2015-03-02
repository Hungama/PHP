<?php
error_reporting(0);
//$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$PrevDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$curdate=date("Ymd", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
//$PrevDate='2014-09-12';
//$curdate='20140912';
require '/var/www/html/hungamacare/missedcall/obd_alert/mcwdataAlert/cintholData.php';
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';
//Create a new PHPMailer instance
$mail = new PHPMailer();
//set encoding
$mail->Encoding='base64';
$mail->setFrom('voice.mis@hungama.com', 'Voice Mis');
//Set an alternative reply-to address
//$mail->addReplyTo('voice.mis@hungama.com', 'Voice Mis');
//Set who the message is to be sent to
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('rahul.jain@hungama.com', 'Rahul Jain');
$mail->addAddress('vinod.chauhan@hungama.com', 'Vinod Chauhan');
$mail->addAddress('reeju.jain@hungama.com', 'Reeju Jain');
$mail->addAddress('gagandeep.matnaja@hungama.com', 'Gagandeep Matnaja');
$mail->addAddress('shreya.tyagi@hungama.com', 'Shreya Tyagi');
$mail->addAddress('kunalk.arora@hungama.com', 'Kunal Arora');
//Set the subject line
$mail->Subject = 'Enterprise - Cinthol Data of date '.$PrevDate;
$htmlfilename='emailcontentCinthol_'.$curdate.'.html';
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
?>