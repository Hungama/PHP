<?php
set_time_limit(12000);
error_reporting(0);
// activate full error reporting
//error_reporting(E_ALL & E_STRICT);

include 'XMPPHP/XMPP.php';
require_once 'XMPPHP/Log.php';
#Use XMPPHP_Log::LEVEL_VERBOSE to get more logging for error reports
#If this doesn't work, are you running 64-bit PHP with < 5.2.6?
$curdate = date("Y-m-d");
$logPath = "logs/message_".$curdate.".txt";

function createConnection()
{
//$conn = new XMPPHP_XMPP('talk.google.com', 5222, 'satay.csjm', 'tiwariji39', 'xmpphp', 'gmail.com', $printlog=True, $loglevel=XMPPHP_Log::LEVEL_INFO);
$conn = new XMPPHP_XMPP('talk.google.com', 5222, 'uninormu', 'hungama1234', 'xmpphp', 'gmail.com', $printlog=True, $loglevel=XMPPHP_Log::LEVEL_INFO);
//$conn->connect();
return $conn;
}


function getAllMessages()
 {
  $curdate = date("Y-m-d");
 $logPath = "logs/message_".$curdate.".txt";
 $conn=createConnection();
 $conn->connect();
 $conn->processUntil('session_start');
  //$conn->presence();
  $conn->presence($status="I am here!");
   while(1)
   {			
  $events = $conn->processUntil('message',6);
  foreach($events as $current)
		{
  $data = $current[1]; // [0] contains the event type, here "message"
  //Start get data based on entered keyword from chat window
  $keyword=$data["body"];
  $email  = $data["from"];
  $sname = explode("@", $email);
  $useremail= explode("/", $email);
$sid=$useremail[1];
$semail=$useremail[0];

//check for verification of mobile number start here
if(is_numeric($keyword)) {

     
//check for integere--status-2 and then check for valid mobile number
$checkchatstatus_level="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&sid=$sid&action=6";
$response_status = file_get_contents($checkchatstatus_level);
	if($response_status==2)
						{
						if(strlen($keyword)==10)
						{
$mobileno=$keyword;
$keyword='mobile_sub_start_mu';
$dofinal=true;
						}
						else
						{
			$keyword='mobile_sub_start_mu';
			$dofinal=false;
						}
						}
						
	
//check for verification of mobile number end here
}
  switch($keyword)
					{
			case '1':
						$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=1";
						 error_log($savemessagedata."\n",3,$logPath);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						$message=$savecurrentseesioninfo;
	
						if($message=='NOK')
						{
						$getmessagedata="http://uninor-vas.hungamavoice.com/uninor/web/html/search_jabber.php?stxt=".$keyword."&service=mu";
						$responsemessage = file_get_contents($getmessagedata);
		
						$oupput_message = explode("@", $responsemessage);
		
						$message=$oupput_message[0];
						$link_crbtid=$oupput_message[1];
						//save deatils in database for further process start here 
						$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=2&search_result_menu=".urlencode($message);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						}
						else
						{
						$response_message = explode("|", $message);
						//$rbtname=explode("|", $message);
						if(!empty($response_message[1]))
						{
						$message='Hi mr '.$sname[0].',Pls send Ur Mobile number to set '.$response_message[1];
						
						$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=4";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
						}
						else
						{
						$message='Hi mr '.$sname[0].',Pls reply with valid option ';
						}
						}
			break;
		case '2':
					$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=1";
						 error_log($savemessagedata."\n",3,$logPath);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
					$message=$savecurrentseesioninfo;
	
						if($message=='NOK')
						{
					$getmessagedata="http://uninor-vas.hungamavoice.com/uninor/web/html/search_jabber.php?stxt=".$keyword."&service=mu";
						$responsemessage = file_get_contents($getmessagedata);
						
						$oupput_message = explode("@", $responsemessage);
						
						$message=$oupput_message[0];
						$link_crbtid=$oupput_message[1];
						//save deatils in database for further process start here 
						$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=2&search_result_menu=".urlencode($message);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						}
						else
						{
						$response_message = explode("|", $message);
			/*			$message='Hi mr '.$sname[0].',Pls send Ur Mobile number to set'.$response_message[1];
							$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=4";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
						*/
							if(!empty($response_message[1]))
						{
						$message='Hi mr '.$sname[0].',Pls send Ur Mobile number to set '.$response_message[1];
						
						$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=4";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
						}
						else
						{
						$message='Hi mr '.$sname[0].',Pls reply with valid option ';
						}
						}
						
	
		break;

		case '3':
					$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=1";
						 error_log($savemessagedata."\n",3,$logPath);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						$message=$savecurrentseesioninfo;
						
						if($message=='NOK')
						{
					$getmessagedata="http://uninor-vas.hungamavoice.com/uninor/web/html/search_jabber.php?stxt=".$keyword."&service=mu";
						$responsemessage = file_get_contents($getmessagedata);
						
						$oupput_message = explode("@", $responsemessage);
						
						$message=$oupput_message[0];
						$link_crbtid=$oupput_message[1];
						//save deatils in database for further process start here 
						$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=2&search_result_menu=".urlencode($message);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						}
						else
						{
						$response_message = explode("|", $message);
					/*	$message='Hi mr '.$sname[0].',Pls send Ur Mobile number to set'.$response_message[1];
							$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=4";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
						*/
							if(!empty($response_message[1]))
						{
						$message='Hi mr '.$sname[0].',Pls send Ur Mobile number to set '.$response_message[1];
						
						$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=4";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
						}
						else
						{
						$message='Hi mr '.$sname[0].',Pls reply with valid option ';
						}
						}
						
						
		break;

		case '4':
					$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=1";
						 error_log($savemessagedata."\n",3,$logPath);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						$message=$savecurrentseesioninfo;
						
						if($message=='NOK')
						{
					$getmessagedata="http://uninor-vas.hungamavoice.com/uninor/web/html/search_jabber.php?stxt=".$keyword."&service=mu";
						$responsemessage = file_get_contents($getmessagedata);
						
						$oupput_message = explode("@", $responsemessage);
						
						$message=$oupput_message[0];
						$link_crbtid=$oupput_message[1];
						//save deatils in database for further process start here 
						$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=2&search_result_menu=".urlencode($message);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						}
						else
						{
						$response_message = explode("|", $message);
					/*	$message='Hi mr '.$sname[0].',Pls send Ur Mobile number to set'.$response_message[1];
							$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=4";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
						*/
							if(!empty($response_message[1]))
						{
						$message='Hi mr '.$sname[0].',Pls send Ur Mobile number to set '.$response_message[1];
						
						$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=4";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
						}
						else
						{
						$message='Hi mr '.$sname[0].',Pls reply with valid option ';
						}
						}
						
						
		break;
		case '5':
					$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=1";
						 error_log($savemessagedata."\n",3,$logPath);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						$message=$savecurrentseesioninfo;
						
						if($message=='NOK')
						{
					$getmessagedata="http://uninor-vas.hungamavoice.com/uninor/web/html/search_jabber.php?stxt=".$keyword."&service=mu";
						$responsemessage = file_get_contents($getmessagedata);
						
						$oupput_message = explode("@", $responsemessage);
						
						$message=$oupput_message[0];
						$link_crbtid=$oupput_message[1];
						//save deatils in database for further process start here 
						$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=2&search_result_menu=".urlencode($message);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						}
						else
						{
						$response_message = explode("|", $message);
						
					/*	$message='Hi mr '.$sname[0].',Pls send Ur Mobile number to set'.$response_message[1];
						$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=4";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);						
						*/
						
							if(!empty($response_message[1]))
						{
						$message='Hi mr '.$sname[0].',Pls send Ur Mobile number to set '.$response_message[1];
						
						$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=4";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
						}
						else
						{
						$message='Hi mr '.$sname[0].',Pls reply with valid option ';
						}
						
						}
		break;
		case 'mobile_sub_start_mu':
		
		if($dofinal)
		{
						$message='Hi mr '.$sname[0].',Thanks we have recieved your request';
						$updatemessagestatus="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&sid=$sid&action=5&msisdn=$mobileno";
						$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);	
		}
else
{
$message='Please check the mobile number given is correct .';
}		
						

						
		break;
		default:
		
		$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=1";
		$savecurrentseesioninfo = file_get_contents($savemessagedata);
			$checkforduplicacy=$savecurrentseesioninfo;
								$getmessagedata="http://uninor-vas.hungamavoice.com/uninor/web/html/search_jabber.php?stxt=".$keyword."&service=mu";
						$responsemessage = file_get_contents($getmessagedata);
						
						$oupput_message = explode("@", $responsemessage);
						
						$message=$oupput_message[0];
						if($message!='Ooops no record found')
						{
						$welcomemessage='Hi '.$sname[0].', Welcome to Uninor Music Unlimited My Tunes Chat.'.PHP_EOL;
						$welcomemessage.='Results:'.PHP_EOL;
						$welcomemessage.=$message.PHP_EOL;
						$welcomemessage.='Reply with Song No. 1 - 5 for setting the My Tunes. You can also call 52222 to hear Unlimited Music and set Unlimited My Tunes.';
						}
						
						$link_crbtid=$oupput_message[1];				
						if($checkforduplicacy=='NOK')
						{
					//save deatils in database for further process start here 
					$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=2&search_result_menu=".urlencode($message);
					error_log($savemessagedata.'New Entry'."\n",3,$logPath);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						}
						else
						{
						$savemessagedata="http://localhost/ejabberd/xmpphp-0.1rc2-r77/savedata.php?email=$semail&keyword_search=$keyword&search_result=$link_crbtid&sid=$sid&action=3&search_result_menu=".urlencode($message);
					error_log($savemessagedata.'Update Entry'."\n",3,$logPath);
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						}
						
						
						
						// end here
					//	$testmessage=$message.'@'.$savecurrentseesioninfo;
	break;
					}
  
  //end serach code here
 $message = str_replace("*", "", $message);
 // $message = str_replace("*", "", $welcomemessage);
  
  $conn->message($useremail[0], $message,'chat');
  //$conn->message($data["from"], 'Thanks for your message.Will contact soon. :)','chat');
  $logData1="Auto reply to - From: ".$useremail[0]."sent--.$i"."  ".date("Y-m-d H:i:s")."\n";
  $logData="Message - From: ".$useremail[0].", Text: ".$data["body"]."  ".date("Y-m-d H:i:s")."\n";
  error_log($logData1,3,$logPath);
  error_log($logData,3,$logPath);
       }
  }

// call agaian and again
getAllMessages();
 }

 getAllMessages();

exit;