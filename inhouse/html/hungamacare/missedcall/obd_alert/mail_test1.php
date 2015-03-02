<?php
error_reporting(0);
        $prevdate = date("Y-m-d");
        $rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $reportdate = date('j F ,Y ', strtotime($rechargeDate));
        require '/var/www/html/hungamacare/missedcall/obd_alert/contents_test1.php';
        require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';
       $mail = new PHPMailer();
       $mail->Encoding = 'base64';
        $mail->setFrom('ms.mis@hungama.com', 'MS MIS');
        $mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
		$mail->addAddress('roop.ghosh@jwt.com', 'Roop Ghosh');
        $mail->addAddress('shreya.tyagi@hungama.com', 'Shreya Tyagi');
		$mail->addAddress('rishi.sundd@hungama.com', 'Rishi Sundd');
        $mail->Subject = 'Test email';
       $htmlfilename = 'emailcontenttest_' . date('Ymd') . '.html';
        $mail->msgHTML(file_get_contents($htmlfilename), dirname(__FILE__));
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
            unlink($htmlfilename);
        }
?>