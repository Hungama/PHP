<?php
error_reporting(0);
        $prevdate = date("Y-m-d");
        $rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $reportdate = date('j F ,Y ', strtotime($rechargeDate));
        require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';
//Create a new PHPMailer instance
        $mail = new PHPMailer();
//Set who the message is to be sent from
//set encoding
        $mail->Encoding = 'base64';
        $mail->setFrom('ms.mis@hungama.com', 'MS MIS');
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('ms.ops@hungama.com', 'MS Ops');
$mail->addAddress('ms.noc@hungama.com', 'MS Noc');
$mail->addAddress('rahul.tripathi@hungama.com', 'Rahul Tripathi');
$mail->addAddress('rahul.jain@hungama.com', 'Rahul Jain');
$mail->addAddress('reeju.jain@hungama.com', 'Reeju Jain');
//Set the subject line
       $mail->Subject = 'SMS Application Alert -Enterprise Mcdowells -'. $prevdate;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $htmlfilename = 'EnterpriseMcDw_sms_alert.html';
        $mail->msgHTML(file_get_contents($htmlfilename), dirname(__FILE__));
//send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
			$error=$mail->ErrorInfo;
        } else {
            echo "Message sent!";
            unlink($htmlfilename);
        }
?>