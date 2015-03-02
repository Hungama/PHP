<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>EnterpriseAfricaGSK</title>
</head>
<body>
<?php
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
//$prevdate = date("Y-m-d");
#$PrevDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
#$curdate=date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
#$PrevDate='2014-09-02';
#$curdate='20140902';
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
require '/var/www/html/hungamacare/missedcall/obd_alert/mcwdataAlert/GSKdata.php';
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Set who the message is to be sent from
//set encoding
$mail->Encoding='base64';
$mail->setFrom('ms.mis@hungama.com', 'MS Mis');
//Set an alternative reply-to address
//$mail->addReplyTo('ms.mis@hungama.com', 'MS Mis');
//Set who the message is to be sent to
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('vinod.chauhan@hungama.com', 'Vinod Chauhan');
$mail->addAddress('rahul.jain@hungama.com', 'Rahul Jain');
$mail->addAddress('gagandeep.matnaja@hungama.com', 'Gagandeep Matnaja');
$mail->addAddress('shreya.tyagi@hungama.com', 'Shreya Tyagi');
$mail->addAddress('kunalk.arora@hungama.com', 'Kunal Arora');

//Set the subject line
$mail->Subject = 'Enterprise - GSK (Africa) Data of date '.$prevdate;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$htmlfilename='emailcontentGSK_'.date('Y_m_d').'.html';
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
</body>
</html>