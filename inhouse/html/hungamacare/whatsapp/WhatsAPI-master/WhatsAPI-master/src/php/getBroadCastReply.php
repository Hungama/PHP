<?php
set_time_limit(0);
error_Reporting(0);
require_once('whatsprot.class.php');
$debug = false;
$username = "919017836900";
$identity = strtolower(urlencode(sha1($username, true)));
$nickname = 'Whatsapp SMS';  
$w = new WhatsProt($username, $identity, $nickname, $debug);
$password = "MkU+ypQ92WLnDjGzOYf9AVdcmc0=";
$w->Connect();
$w->LoginWithPassword($password);

$logPath="/var/www/html/hungamacare/whatsapp/WhatsAPI-master/WhatsAPI-master/src/php/filebase/log/Replylogs_".date('dmY').".log";
	
while (1) {
	$w->PollMessages();
	$msgs = $w->GetMessages();
	foreach($msgs as $m){ 
	//print_r($m);
	$logStringCron="GetMessages#".trim($m)."#".date('d-m-Y h:i:s')."\r\n";
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
			$logString="#Response-".$from." Name: ".$name_my." Message: ".$body."#".date('d-m-Y h:i:s')."\r\n";
        	error_log($logString,3,$logPath);
		
		}  }// check for keyword is not blank

    }  
	   sleep(1);