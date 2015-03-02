<?php
$msisdn=$_REQUEST['msisdn'];
$model=$_REQUEST['handset'];
$Remote_add=$_REQUEST['remoteip'];

//echo $url = 'http://202.87.41.147/hungamawap/reliance/voice/dconsentFailRes.php';
$url = 'http://202.87.41.194/waphung/common_download_functions/reliance_create_session.php';

$fields = array('user' => 'reldom','password' => 'domrail','clienttype' => 'Cmania','msisdn' => $msisdn,'rate' => 544,'typeid' => 21,'contentid' =>0,'contentname' =>"Wallpaper",				'zoneid' => 123456,
'billingid' => 544,'handset' => $model,'remoteip' => $Remote_add,'transid' => date('dmyhis'),'other1' => "subs",'other2' => "sam",'productid' => 0);

foreach($fields as $key=>$value) 
{
	$fields_string .= $key.'='.$value.'&'; 
}
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
echo $result = curl_exec($ch);  //execute post

//echo $result.'athar';

//close connection
curl_close($ch);

?>