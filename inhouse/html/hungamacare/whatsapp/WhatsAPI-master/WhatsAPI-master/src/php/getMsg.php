<?php
set_time_limit(0);
error_Reporting(0);
/**
 * This is an example of how you can use the WhatsAPI to request a code
 * from the WhatsAPP server, register that code and retrieve your password.
 *
 * Once you have your password you will then be able to use it in
 * examplefunctional.php to actually send and receive messages.
 *
 */


require_once('whatsprot.class.php');

/**
 * Config data.
 */
$debug = true;
$username = "919873710296";
$identity = strtolower(urlencode(sha1($username, true)));
$nickname = 'Satay Tiwari';                         // This is the username displayed by WhatsApp clients.


// Create a instance of WhastPort.
$w = new WhatsProt($username, $identity, $nickname, $debug);

// How to create an account __ONLY__ if you do not have a associated to our phone number.
// You can test your credentials with: $w->checkCredentials() (BUT ONLY ONLY IF YOU HAVE THE IDENTITY);

/**
 * First request a registration code from WhatsApp.
 *
 * @param $method
 *   Accepts only 'sms' or 'voice' as a value.
 * @param $countryCody
 *   ISO Country Code, 2 Digit.
 * @param $langCode
 *   ISO 639-1 Language Code: two-letter codes.
 *
 * @return object
 *   An object with server response.
 *   - status: Status of the request (sent/fail).
 *   - reason: Reason of the status (e.g. too_recent/missing_param/bad_param).
 *   - length: Registration code length.
 *   - method: Used method.
 *   - retry_after: Waiting time before requesting a new code.
 */
//$w->codeRequest('sms');


// You must wait until you receive a code from WhatsApp, either to your phone via sms
// or phonecall depending on what you selected above.

// The function below will only work once you know your code!


/**
 * Second register account on WhatsApp using the provided code with $w->codeRequest();.
 *
 * @param integer $code
 *   Numeric code value provided on codeRequest().
 *
 * @return object
 *   An object with server response.
 *   - status: Account status.
 *   - login: Phone number with country code.
 *   - pw: Account password.
 *   - type: Type of account.
 *   - expiration: Expiration date in UNIX Timestamp.
 *   - kind: Kind of account.
 *   - price: Formatted price of account.
 *   - cost: Decimal amount of account.
 *   - currency: Currency price of account.
 *   - price_expiration: Price expiration in UNIX Timestamp.
 */
//$resp=$w->codeRegister('747699');
//print_r($resp);
$password = "PRNdxaUltYWZm4l5pqkPlCZRzRg=";
$w->Connect();
$w->LoginWithPassword($password);

$logPath="/var/www/html/hungamacare/whatsapp/logs/logs_".date('dmY').".log";
$logPathCron="/var/www/html/hungamacare/whatsapp/logs/Cronlogs_".date('dmY').".log";
$logStringCron="#ScriptRuns at #".date('d-m-Y h:i:s')."\r\n";
error_log($logStringCron,3,$logPathCron);
			
while (1) {
	$w->PollMessages();
	$msgs = $w->GetMessages();
	foreach($msgs as $m){ 
	print_r($m);
	$logStringCron="GetMessages#".trim($m)."#".date('d-m-Y h:i:s')."\r\n";
//error_log($logStringCron,3,$logPathCron);
       $attri = $m->getAttributes(); 
       $from = str_replace("@s.whatsapp.net", "",$attri['from']); 
       $time = date("m/d/Y H:i",$attri['t']); 
	  $name_my = $attri['notify']; 
	 //  print_r($m);
	   
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
			//$target = "918587800665";//my
			//$result=$w->sendMessage($target, "Satay -Using whatsapp ...Please send reply.");
			echo "[$time] From: $from, Name: $name_my, Message: $body\n";
			$logString="#Response-".$from." Name: ".$name_my." Message: ".$body."#".date('d-m-Y h:i:s')."\r\n";
        	error_log($logString,3,$logPath);
		
		}
		/**********************************************************Start Search & send code here **********************************/
$keyword=$body;
$posturl="http://192.168.100.212/hungamacare/whatsapp/WhatsAPI-master/WhatsAPI-master/src/php";
if(!empty($keyword))
{
$logStringCron="#ScriptKeyword is #".$keyword."#".date('d-m-Y h:i:s')."\r\n";
error_log($logStringCron,3,$logPathCron);
 $target  = $from;
 $target_name  = $name_my;
 
 $checkchatstatus_level=$posturl."/savedata.php?ANI=$target&action=6";
$response_status = file_get_contents($checkchatstatus_level);
$response_status_db = explode("|", $response_status);
	if($response_status_db[0]==2)
						{
						if(strlen($keyword)==10)
						{
$mobileno=$keyword;
$keyword='mobile_sub_start_mu';
$dofinal=true;
$settunefor=$response_status_db[1];
						}
						else
						{
			$keyword='mobile_sub_start_mu';
			$dofinal=false;
$settunefor=$response_status_db[1];
						}
						}
						
	
//check for verification of mobile number end here



  switch($keyword)
					{
				case '1':
				case '2':
				case '3':
				case '4':
				case '5':
						$savemessagedata=$posturl."/savedata.php?ANI=$target&keyword_search=$keyword&search_result=$link_crbtid&action=1";
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						$message=$savecurrentseesioninfo;
						//$message='NOK';
						if($message=='NOK')
						{
						$getmessagedata="http://uninor-vas.hungamavoice.com/uninor/web/html/search_jabber.php?stxt=".$keyword."&service=mu";
						$responsemessage = file_get_contents($getmessagedata);
		
						$oupput_message = explode("@", $responsemessage);
		
						$message=$oupput_message[0];
						
							if($message==404)
							{
							$push_message="Hey $target_name, we tried searching for what you are looking for but couldn't seem to find it. Would you like us to search us anything else for you?";
							}
							else
							{
							$push_message='Hi '.$target_name.', Welcome to Uninor Music Unlimited My Tunes Chat.'.PHP_EOL;
								$push_message.='Results:'.PHP_EOL;
								$push_message.=$message.PHP_EOL;
								$push_message.='Reply with Song No. 1 - '.$oupput_message[2].' for setting the My Tunes. You can also call 52222 to hear Unlimited Music and set Unlimited My Tunes.';
						
								$link_crbtid=$oupput_message[1];
								//save deatils in database for further process start here 
								$savemessagedata=$posturl."/savedata.php?ANI=$target&keyword_search=$keyword&search_result=$link_crbtid&action=2&search_result_menu=".urlencode($message);
								$savecurrentseesioninfo = file_get_contents($savemessagedata);
								
							}
						
						}
						else
						{
						$response_message = explode("|", $message);
							if(!empty($response_message[1]))
							{
							$push_message='To set this song '.$response_message[1].' as your Caller Tune, reply with your Uninor mobile number. If you are not a Uninor Music Unlimited subscriber, you will be charged @ Rs 2.5/day.'; 					
							$updatemessagestatus=$posturl."/savedata.php?ANI=$target&keyword_search=$keyword&action=4";
							echo $updatemessagestatus;
							$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
							}
							else
							{
							$push_message='Hi '.$target_name.', This is not a valid option. Reply with song no. 1 - 5 for setting any song as your Caller Tune.';
							}
						}
			break;		
		case 'mobile_sub_start_mu':
					if($dofinal)
					{
					$updatemessagestatus=$posturl."/savedata.php?ANI=$target&keyword_search=$keyword&action=5&msisdn=$mobileno";
					$updatecurrentstatusinfo = file_get_contents($updatemessagestatus);
					$push_message="We have received your request to set this song '.$settunefor.' as your Caller Tune. It will be activated soon. If you are already a MU subscriber, this Caller Tune is absolutely Free for you!";
					}
					else
					{
					$push_message='This mobile number is incorrect. Please check the number.'.PHP_EOL;
					}		
		break;
		
			default:
						$savemessagedata=$posturl."/savedata.php?ANI=$target&keyword_search=$keyword&search_result=$link_crbtid&action=1";
						$savecurrentseesioninfo = file_get_contents($savemessagedata);
						$checkforduplicacy=$savecurrentseesioninfo;
						$getmessagedata="http://uninor-vas.hungamavoice.com/uninor/web/html/search_jabber.php?stxt=".$keyword."&service=mu";
						$responsemessage = file_get_contents($getmessagedata);
						$oupput_message = explode("@", $responsemessage);
						$message=$oupput_message[0];
					
					if($message==404)
					{
					$push_message="Hey $target_name, we tried searching for what you are looking for but couldn't seem to find it. Would you like us to search us anything else for you?";
					}
					else
					{
						$push_message='Hi '.$target_name.', Welcome to Uninor Music Unlimited My Tunes Chat.'.PHP_EOL;
						$push_message.='Results:'.PHP_EOL;
						$push_message.=$message.PHP_EOL;
						$push_message.='Reply with Song No. 1 - '.$oupput_message[2].' for setting the My Tunes. You can also call 52222 to hear Unlimited Music and set Unlimited My Tunes.';
						
						$link_crbtid=$oupput_message[1];				
						if($checkforduplicacy=='NOK')
						{
					//save deatils in database for further process start here 
						$savemessagedata=$posturl."/savedata.php?ANI=$target&keyword_search=$keyword&search_result=$link_crbtid&action=2&search_result_menu=".urlencode($message);
						}
						else
						{
						$savemessagedata=$posturl."/savedata.php?ANI=$target&keyword_search=$keyword&search_result=$link_crbtid&action=3&search_result_menu=".urlencode($message);
						}
						echo $savemessagedata;
					$savecurrentseesioninfo = file_get_contents($savemessagedata);
					}
					
						// end here
			break;
					}
  
  //end serach code here
   $message = str_replace("*", "", $push_message);
  if(!empty($message))
  {
  $result=$w->sendMessage($target, $message);
  }
  $logData1="Auto reply To :".$target."#MessageBody:".$message."#".date("Y-m-d H:i:s")."\n";
  $logData="Message - From: ".$target.",  Text:  ".$keyword."  ".date("Y-m-d H:i:s")."\n";
  error_log($logData1,3,$logPath);
  error_log($logData,3,$logPath);
  }// check for keyword is not blank
//for each end here
		/***********************************************************End here***********************************************/
		
    }  
	   sleep(1);
}
