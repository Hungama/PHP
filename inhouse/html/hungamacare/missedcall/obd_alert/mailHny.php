<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>OBD Missed Call Alert</title>
    </head>
    <body>
        <?php
        $prevdate = date("Y-m-d");
        $rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $reportdate = date('j F ,Y ', strtotime($rechargeDate));
        //require '/var/www/html/hungamacare/missedcall/obd_alert/contents_HNY.php';
		require '/var/www/html/hungamacare/missedcall/obd_alert/contents_HNY_All.php';
        require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
        $mail = new PHPMailer();
//Set who the message is to be sent from
//set encoding
        $mail->Encoding = 'base64';
        $mail->setFrom('ms.mis@hungama.com', 'MS MIS');
//Set an alternative reply-to address
//$mail->addReplyTo('ms.dev@hungama.com', 'MS Dev');
//Set who the message is to be sent to
        $mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
        $mail->addAddress('rahul.jain@hungama.com', 'Rahul Jain');
      $mail->addAddress('vinod.chauhan@hungama.com', 'Vinod Chauhan');
//    $mail->addAddress('jyoti.porwal@hungama.com', 'Jyoti Porwal');
	//	$mail->addAddress('gaurav.talwar@hungama.com', 'Gaurav Talwar');
	//$mail->addAddress('kunalk.arora@hungama.com', 'Kunal Arora');
	//$mail->addAddress('shreya.tyagi@hungama.com', 'Shreya Tyagi');
	$mail->addAddress('rishi.sundd@hungama.com', 'Rishi Sundd');
		
//Set the subject line
        $mail->Subject = 'Missed Call Campaign - Happy New Year Alert- ' . $prevdate;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $htmlfilename = 'EnterpriseMovieHNY_PAN.html';
        $mail->msgHTML(file_get_contents($htmlfilename), dirname(__FILE__));
//send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
			$error=$mail->ErrorInfo;
			$reqDataLog = "Mailer Error:#".$error."#".date("Y-m-d H:i:s")."\r\n";
        } else {
            echo "Message sent!";
			$reqDataLog = "Mailer sent:#SUCCESS".date("Y-m-d H:i:s")."\r\n";
            unlink($htmlfilename);
        }
		
error_log($reqDataLog, 3, $querylog);
        ?>
    </body>
</html>