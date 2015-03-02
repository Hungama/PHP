<?php
set_time_limit(0);
require_once('whatsprot.class.php');
/**
 * Config data.
 */
$debug = false;
$username = "919017836900";
$identity = strtolower(urlencode(sha1($username, true)));
$nickname = 'Whatsapp SMS';                         // This is the username displayed by WhatsApp clients.

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
$logPath="/var/www/html/hungamacare/whatsapp/WhatsAPI-master/WhatsAPI-master/src/php/filebase/log/log_".date(Ymd).'.txt';
$logString=$msisdn."#MsgId-".$result."#".date('d-m-Y h:i:s')."\r\n";
error_log($logString,3,$logPath);
				}
echo "done";
fclose($fp);