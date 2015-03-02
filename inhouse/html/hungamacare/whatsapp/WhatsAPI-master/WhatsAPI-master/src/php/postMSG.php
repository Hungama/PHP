<?php
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
//$target = "919999195002"; //vikrant
/*if($_REQUEST['ani']!='')
$target = "918587800665";
else
$target = "91".$_REQUEST['ani'];
*///
//919711596769 //client
$targetArray=array('918587800665','919711596769');
//$targetArray=array('918447186664');
//$target = "918587800665";
//$target = "919650777632";
foreach($targetArray as $target)
{
$result=$w->sendMessage($target, "Welcome to Uninor Music Unlimited My Tunes Chat .Search songs...");
print_r($result);
}

/*$logPath="/var/www/html/hungamacare/temp/logs/ReplyVisitorLogs.log";
$logString="Wait for reply start here ".date('d-m-Y h:i:s')."\r\n";
error_log($logString,3,$logPath);
while (1) {
    $w->pollMessages();
    $msgs = $w->getMessages();
    foreach ($msgs as $m) {
	$logString="Message is- ". $m."#".date('d-m-Y h:i:s')."\r\n";
        # process inbound messages
		error_log($logString,3,$logPath);
        print($m->NodeString("") . "\n");
    }
}
*/

// IT IS VERY IMPORTANT THAT YOU NOTE AND KEEP YOUR DETAILS.
// YOU WILL NEED TO UPDATE THE SCRIPT WITH THE PASSWORD ETC.

//Use exampleFunctional.php to continue with the examples.
