<?php
  function getStatus($number)
    {
        $country = substr($number, 0, 2);
        $number = substr($number, 2);

        $status_url     = "https://sro.whatsapp.net/client/iphone/iq.php?cd=1&cc=".$country."&me=12345&u[]=".$number;
        $status_content = file_get_contents($status_url);
        $status_xml     = simplexml_load_string($status_content);

        if(!$status_xml->array->dict) return null;

        $status            = array();
        $status['text']  = strip_tags($status_xml->array->dict->string[1]->asXML());
        $status['time']   = intval(strip_tags($status_xml->array->dict->integer->asXML()));

        return $status;
    }
	$number='918587800665';
	$a=getStatus($number);
	print_r($a);
?>