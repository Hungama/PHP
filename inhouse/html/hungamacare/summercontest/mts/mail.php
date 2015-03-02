<?php
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
require '/var/www/html/hungamacare/summercontest/mts/contents.php';
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//set encoding
$mail->Encoding='base64';
//Set who the message is to be sent from
$mail->setFrom('ms.mis@hungama.com', 'MS Mis');
//Set an alternative reply-to address
$mail->addReplyTo('ms.mis@hungama.com', 'MS Mis');
//Set who the message is to be sent to
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('vinod.chauhan@hungama.com', 'Vinod Chauhan');
$mail->addAddress('kunalk.arora@hungama.com', 'Kunalk Arora');
$mail->addAddress('monika.patel@hungama.com', 'Monika Patel');
$mail->addAddress('vikrant.garg@hungama.com', 'Vikrant Garg');
$mail->addAddress('rajneesh.srivastava@hungama.com', 'Rajneesh Srivastava');
$mail->addAddress('gagandeep.singh@hungama.com', 'Gagandeep Singh');
$mail->addAddress('mts@contesthungama.com', 'MTS - Contesthungama');

//Set the subject line
$mail->Subject = 'MTS Contest Zone top Scorer of date '.$prevdate;
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
