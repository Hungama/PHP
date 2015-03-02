<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Uninor SU</title>
</head>
<body>
<?php
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
require '/var/www/html/hungamacare/summercontest/uninor/fifa/contents.php';
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Set who the message is to be sent from
//set encoding
$mail->Encoding='base64';
$mail->setFrom('voice.mis@hungama.com', 'Voice Mis');
//Set an alternative reply-to address
$mail->addReplyTo('voice.mis@hungama.com', 'Voice Mis');
//Set who the message is to be sent to
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('rahul.jain@hungama.com', 'Rahul Jain');
$mail->addAddress('gaurav.bhatnagar@hungama.com', 'Gaurav Bhatanagar');
//Set the subject line
$mail->Subject = 'Uninor SU Active Base of date '.$prevdate;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
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
