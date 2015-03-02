<?php
error_reporting(0);
// activate full error reporting
//error_reporting(E_ALL & E_STRICT);

include 'XMPPHP/XMPP.php';
require_once 'XMPPHP/Log.php';
#Use XMPPHP_Log::LEVEL_VERBOSE to get more logging for error reports
#If this doesn't work, are you running 64-bit PHP with < 5.2.6?
$conn = new XMPPHP_XMPP('talk.google.com', 5222, 'satay.csjm', 'tiwariji39', 'xmpphp', 'gmail.com', $printlog=True, $loglevel=XMPPHP_Log::LEVEL_INFO);
$conn->connect();
$logPath = "logs/message_".$curdate.".txt";
while(1)
{
 try { 
while(1)
{ $conn->processUntil('session_start');
  $conn->presence();
  $events = $conn->processUntil('message');
foreach($events as $current)
{
  $data = $current[1]; // [0] contains the event type, here "message"
  //echo "Message - From: ".$data["from"].", Text: ".$data["body"];
   $logData="Message - From: ".$data["from"].", Text: ".$data["body"].date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
}
}
}
 catch(XMPPHP_Exception $e) {
    $error = $e->getMessage();
	  $logData="Error Message - From: ".$error.date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
}
  }

 
  
  exit;
try {
    $conn->connect();
    $conn->processUntil('session_start');
    $conn->presence();
   $conn->message('vinod.9007@gmail.com', 'Welcome in test chat again.');
  //  print_r($conn);
$events = $conn->processUntil('message');
foreach($events as $current)
{
  $data = $current[1]; // [0] contains the event type, here "message"
  echo "Message - From: ".$data["from"].", Text: ".$data["body"];
}
	//echo "messsgae send";
    //$conn->disconnect();
} catch(XMPPHP_Exception $e) {
    die($e->getMessage());
}
