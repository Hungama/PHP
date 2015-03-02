<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Uninor Kehlo India Jeeto India</title>
</head>
<body>
<?php
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$date=$_REQUEST['date'];
//$prevdate='2013-10-29';
//$rechargeDate='2013-10-29';
$prevdate=$date;
$rechargeDate=$date;

$reportdate=date('j F ,Y ',strtotime($rechargeDate));


require '/var/www/html/hungamacare/summercontest/uninor/contents_qa.php';
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
//$mail->addAddress('puneet.mehta@hungama.com', 'Puneet Mehta');
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('kunalk.arora@hungama.com', 'Kunalk Arora');
$mail->addAddress('monika.patel@hungama.com', 'Monika Patel');
//$mail->addAddress('mukesh.malav@hungama.com', 'Mukesh Malav');
$mail->addAddress('gagandeep.dhall@hungama.com', 'Gagandeep Dhall');
$mail->addAddress('gadadhar.nandan@hungama.com', 'Gadadhar Nandan');
$mail->addAddress('deepak.bawa@hungama.com', 'Deepak Bawa');



//Set the subject line
$mail->Subject = 'Uninor Kehlo India Jeeto India top Scorer of date '.$prevdate;
//Read an HTML message body from an external file, convert referenced images to embedded,
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
?>
</body>
</html>
