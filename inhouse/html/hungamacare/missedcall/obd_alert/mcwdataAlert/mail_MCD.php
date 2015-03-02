<?php
error_reporting(0);
exit; //stopped service closed-23 Feb2015
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Enterprise - McDowells</title>
</head>
<body>
<?php
//$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$PrevDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$curdate=date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$PrevDate='2014-10-05';
//$curdate='20141005';
//$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$reportdate=date('j F ,Y ',strtotime($rechargeDate));
require '/var/www/html/hungamacare/missedcall/obd_alert/mcwdataAlert/mcwdata_New.php';
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//set encoding
$mail->Encoding='base64';
$mail->setFrom('ms.mis@hungama.com', 'MS Mis');
//Set an alternative reply-to address
//$mail->addReplyTo('ms.mis@hungama.com', 'MS Mis');
//Set who the message is to be sent to
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('rahul.jain@hungama.com', 'Rahul Jain');
$mail->addAddress('gagandeep.matnaja@hungama.com', 'Gagandeep Matnaja');
$mail->addAddress('shreya.tyagi@hungama.com', 'Shreya Tyagi');
//$mail->addAddress('kunalk.arora@hungama.com', 'Kunal Arora');
//Set the subject line
$mail->Subject = 'Enterprise - McDowells Data of date '.$PrevDate;
//$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
$htmlfilename='emailcontent_'.$curdate.'.html';

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
echo "Message sent!";
?>
</body>
</html>
