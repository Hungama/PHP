<?php
set_time_limit(0);
require_once('whatsprot.class.php');
$debug = true;
$username = "919017836900";
$identity = strtolower(urlencode(sha1($username, true)));
$nickname = 'Whatsapp SMS';                         // This is the username displayed by WhatsApp clients.

$logPathReply="/var/www/html/hungamacare/whatsapp/WhatsAPI-master/WhatsAPI-master/src/php/filebase/log/Replylogs_".date('dmY').".log";
$logPath="/var/www/html/hungamacare/whatsapp/WhatsAPI-master/WhatsAPI-master/src/php/filebase/log/log_".date(Ymd).'.txt';
// Create a instance of WhastPort.
$w = new WhatsProt($username, $identity, $nickname, $debug);
$password = "MkU+ypQ92WLnDjGzOYf9AVdcmc0=";
$w->Connect();
$w->LoginWithPassword($password);
$messageme="Salman Khan is back in action, dowload latest song Jumme Ki Raat Hai from the movie Kick ABSOLUTELY FREE. Dial 5432193307 to enjoy favourite songs of Salman Khan";
$file_name="Batch1.txt";
 $file_to_read = "http://192.168.100.212/hungamacare/whatsapp/WhatsAPI-master/WhatsAPI-master/src/php/filebase/".$file_name;
    $file_data = file($file_to_read);
    $file_size = sizeof($file_data);
	  for ($i = 0; $i < $file_size; $i++) {
	   $msisdn = trim($file_data[$i]);
	   $result=$w->sendMessage($msisdn, $messageme);
$logString=$msisdn."#MsgId-".$result."#".date('d-m-Y h:i:s')."\r\n";
error_log($logString,3,$logPath);
//code to get reply start here 
$w->PollMessages();
	$msgs = $w->GetMessages();
	foreach($msgs as $m){ 
	//print_r($m);
	   $attri = $m->getAttributes(); 
       $from = str_replace("@s.whatsapp.net", "",$attri['from']); 
       $time = date("m/d/Y H:i",$attri['t']); 
	  $name_my = $attri['notify']; 
	  foreach (($m->getChildren()) as $child) {
	   
               if (($child->getTag()) == "body") 
                    { echo "Inside Body";
                   $body = $child->getData(); 
               } 
               else if (($child->getTag()) == "notify") 
                    { echo "Inside Notify";
                   $name = $child->getAttribute('name'); 
               } 
        } 
		if (!empty($body)) {
			$logStringReply="#Response-".$from." Name: ".$name_my." Message: ".$body."#".date('d-m-Y h:i:s')."\r\n";
        	error_log($logStringReply,3,$logPathReply);
		
		}  }// check for keyword is not blank

//code to get reply end here 

}
echo "done";
