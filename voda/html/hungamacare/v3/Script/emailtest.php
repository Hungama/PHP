<?php
	$from = 'satay.tiwari@hungama.com';
    $subject = 'Hi';
    $message = 'Hello';
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    mail("satay.tiwari@hungama.com",$subject,$message,"From: $from\n");
?>