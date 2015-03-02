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


//$target = "919811036273";                    // Destination telephone number including the country code without '+' or '00'.
//$target = "919958752620"; //vinod sir
//$target = "919999245707"; //kunal sir
//$result=$w->sendMessage($target, "Satay -Yes We Can...Please send reply..footer removed.");
//print_r($result);
$logPath="/var/www/html/hungamacare/whatsapp/logs/logs_".date('d-m-Y').".log";
$logString="Wait for reply start here ".date('d-m-Y h:i:s')."\r\n";
error_log($logString,3,$logPath);
/*
while (1) {
    $w->pollMessages();
    $msgs = $w->getMessages();
	//print_r($msgs);
	
	
	    if (count($msgs) > 0) {
        $_SESSION["inbound"] = array(); //lock
        foreach ($msgs as $message) {
		print_r($message);
		
		     $data = @$message->getChild("body")->getData();
            if ($data != null && $data != '') {
                $inbound[] = $data;
            }
        }
        $_SESSION["inbound"] = $inbound;
		echo "Received message start here--------";
		print_r($_SESSION["inbound"]);
        session_write_close();
    }
	
	
	
    foreach ($msgs as $m) {
	$w12->processInboundDataNode($m);
	$logString="#Message is- ". $m."#".date('d-m-Y h:i:s')."\r\n";
        # process inbound messages
		error_log($logString,3,$logPath);
       // print($m->NodeString("") . "\n");
    }
	
}
*/


while (true) {
	$w->PollMessages();
	$msgs = $w->GetMessages();
	foreach($msgs as $m){ 
       $attri = $m->getAttributes(); 
       echo $from = str_replace("@s.whatsapp.net", "",$attri['from']); 
       $time = date("m/d/Y H:i",$attri['t']); 
	  echo $name_my = $attri['notify']; 
	   print_r($m);
	   
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
			echo "[$time] From: $from, Name: $name_my, Message: $body\n";
			//echo "From: $from, Name: $name, Message: $body\n";
		}
    }  
	
/*
	foreach ($msgs as $m) {
	print_r($m);
		$time = date("m/d/Y H:i", $m->_attributeHash['t']);
		$from = str_replace("@s.whatsapp.net", "", $m->_attributeHash['from']);
		$name = "(unknown)";
		$body = "";

		foreach ($m->_children as $child) {
			if ($child->_tag == "body") {
				$body = $child->_data;
			}
			else if ($child->_tag == "notify") {
				if (isset($child->_attributeHash) && isset($child->_attributeHash['name'])) {	
					$name = $child->_attributeHash['name'];
				}
			}
		}
//echo "body is".$from."--".$name;
echo "body is".$from;
		if (!empty($body)) {
			//echo "[$time] From: $from, Name: $name, Message: $body\n";
			echo "From: $from, Name: $name, Message: $body\n";
		}

	if (strtolower($body) == "exit") {
			exit;
		}
		// print_r($m);
	}
	*/
}

// IT IS VERY IMPORTANT THAT YOU NOTE AND KEEP YOUR DETAILS.
// YOU WILL NEED TO UPDATE THE SCRIPT WITH THE PASSWORD ETC.

//Use exampleFunctional.php to continue with the examples.
