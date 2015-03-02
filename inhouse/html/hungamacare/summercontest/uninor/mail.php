<?php
//exit;
?>
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
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
require '/var/www/html/hungamacare/summercontest/uninor/contents.php';
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
$mail->addAddress('mukesh.malav@hungama.com', 'Mukesh Malav');

$mail->addAddress('kunalk.arora@hungama.com', 'Kunalk Arora');
$mail->addAddress('monika.patel@hungama.com', 'Monika Patel');

$mail->addAddress('gagandeep.dhall@hungama.com', 'Gagandeep Dhall');
$mail->addAddress('gadadhar.nandan@hungama.com', 'Gadadhar Nandan');
$mail->addAddress('uninor@contesthungama.com', 'Uninor - Contesthungama');

$mail->addAddress('anand.rao@hungama.com', 'Anand Rao');
$mail->addAddress('piyush.srivastav@hungama.com', 'Piyush Srivastav');
$mail->addAddress('arun.singh@hungama.com', 'Arun Singh');
$mail->addAddress('aditya.upadhyay@hungama.com', 'Aditya Upadhyay');


$mail->addAddress('vipin@surevin.net', 'Vipin');
$mail->addAddress('varsha@surevin.net', 'Varsha');
$mail->addAddress('ravish@surevin.net', 'Ravish');


//Set the subject line
$mail->Subject = 'Uninor Kehlo India Jeeto India top Scorer of date '.$prevdate;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
$mail->msgHTML(file_get_contents($htmlfilename), dirname(__FILE__));
//Attach an image file
$mail->addAttachment($filepath);

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
//delete CSV file from server
unlink($filepath);
unlink($htmlfilename);
}
?>
</body>
</html>
