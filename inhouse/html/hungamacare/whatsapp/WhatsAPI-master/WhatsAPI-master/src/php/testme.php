<?php
//require_once('WhatsAPI/src/php/whatsprot.class.php');
require_once('whatsprot.class.php');
//$destinationPhone = "xxxxxxxxxxxxxx";//Cesar
//$destinationPhone = "919999245707";//Jose
$destinationPhone = "918447186664";//Jose
//$destinationPhone = "919820506255"; //   919821124989
$username = "919017836900";
$token = md5($username);
$nickname = 'Whatsapp SMS Test';
$password = "MkU+ypQ92WLnDjGzOYf9AVdcmc0=";
$filepath = "/var/www/html/hungamacare/whatsapp/WhatsAPI-master/WhatsAPI-master/src/php/Gift/1157474.jpg";


$w = new WhatsProt($username, $token, $nickname,true);
$w->Connect();
$w->LoginWithPassword($password);
//$messageme="Hey Al, This is a test message I am sending from our new Automated system which can braodcast messages to whatsapp users across the globe. Please do call me when u read this. Anuj".PHP_EOL;
$messageme="Test";
$result=$w->SendMessage($destinationPhone, $messageme);
echo "done";
print_r($result);
?>





