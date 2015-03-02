<?php
if($_REQUEST['submit']==1)
{
    echo "<pre>";
    print_r($_REQUEST);
      echo $xml_post = file_get_contents('php://input');
    exit;
}

$xml_builder = '<?xml version="1.0" encoding="UTF-8"?>
<cg_request>
	<msisdn>98766543210</msisdn>
	<vas_id>M-Gaming</vas_id>
	<trx_id>mg1234</trx_id>
	<cg_id>cgw987888</cg_id>
	<error_code>0</error_code>
	<error_desc>Success_waitingNotify</error_desc>
	<consnt_status>1</consnt_status>
	<consnt_time>17-09-2013 11:23:07</consnt_time>
	<opt1></opt1>
	<opt2></opt2>
	<opt3></opt3>
</cg_request>

                 ';
  // We send XML via CURL using POST with a http header of text/xml.
  $ch = curl_init('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'].'?submit=1');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_builder);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $ch_result = curl_exec($ch);
  curl_close($ch);
  echo $ch_result;

?>