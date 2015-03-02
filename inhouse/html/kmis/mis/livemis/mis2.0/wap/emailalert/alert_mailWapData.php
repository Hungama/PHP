<?php 
error_reporting(0);
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);

$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
require '/var/www/html/kmis/mis/livemis/mis2.0/wap/emailalert/contentsWAP_Report.php';
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Set who the message is to be sent from
//set encoding
$mail->Encoding='base64';
$mail->setFrom('ms.mis@hungama.com', 'MS Mis');
//Set an alternative reply-to address
$mail->addReplyTo('ms.mis@hungama.com', 'MS Mis');
//Set who the message is to be sent to
$mail->addAddress('atul.khatri@hungama.com', 'Atul Singh Khatri');
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('rahul.tripathi@hungama.com', 'Rahul Tripathi');

$mail->addAddress('salil.mahajan@hungama.com', 'Salil Mahajan');


//Set the subject line
$mail->Subject = 'Daily Logs URL for Wap Services-'.$prevdatedb;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$htmlfilename='emailcontentWAP_Report_'.date('Ymd').'.html';
$mail->msgHTML(file_get_contents($htmlfilename), dirname(__FILE__));
//Attach an image file
//$mail->addAttachment($filepath);
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
//delete CSV file from server
//unlink($filepath);
unlink($htmlfilename);
}
?>