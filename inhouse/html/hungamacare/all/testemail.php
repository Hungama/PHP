<?php
error_reporting(1);
			$from = 'voice.mis@hungama.com';
			$subject = ' Email Test Script';
			$headers = "From: " . $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$curdate = date("Y_m_d");
$cc_dev = 'satay.tiwari@hungama.com';
$message='Testing Email';

if(mail($cc_dev, $subject, $message, $headers))
			{
			echo "Email Send Successfully";
			}
			else
			{
			echo "Email Send Error";
			}
?>
