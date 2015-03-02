<?php
error_reporting(0);
// activate full error reporting
//error_reporting(E_ALL & E_STRICT);

include 'XMPPHP/XMPP.php';
require_once 'XMPPHP/Log.php';
#Use XMPPHP_Log::LEVEL_VERBOSE to get more logging for error reports
#If this doesn't work, are you running 64-bit PHP with < 5.2.6?
$conn = new XMPPHP_XMPP('talk.google.com', 5222, 'uninormu', 'hungama1234', 'xmpphp', 'gmail.com', $printlog=False, $loglevel=XMPPHP_Log::LEVEL_INFO);
//
try {
    $conn->connect();
    $conn->processUntil('session_start');
    $conn->presence();
   //$conn->message('tiwarispt85@gmail.com', 'Welcome in test chat.');
  //  print_r($conn);
  /*
$events = $conn->processUntil('message');
foreach($events as $current)
{
  $data = $current[1]; // [0] contains the event type, here "message"
  echo "Message - From: ".$data["from"].", Text: ".$data["body"];
}
*/
//$conn->getRoster();
//print_r($conn);
	//echo "messsgae send";
    $conn->disconnect();
} catch(XMPPHP_Exception $e) {
    die($e->getMessage());
}
