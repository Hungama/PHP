
<?php
extract($_REQUEST);

if( ! isset( $appid)){
	echo "false\n Please Check Appid Parameter. \n";
	//echo("!!!!!get_url_req!!!!!!---parameters are not correct kindly check all the parameters---false");
	exit();
}

$shortUrl=getShort("http://220.226.188.56:9091/fbstartalk/index.php?appid=$appid&msisdn=$mobile_no");
echo("app.url=$shortUrl");


function getShort($longUrl) {
	$apiKey="AIzaSyAG3ps4C7rlknmUbzRw4xYHTNoGDQGcM5w";
	//Get API key from : http://code.google.com/apis/console/

	$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
	$jsonData = json_encode($postData);

	$curlObj = curl_init();
	
	curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
	curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curlObj, CURLOPT_HEADER, 0);
	curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	curl_setopt($curlObj, CURLOPT_POST, 1);
	curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

	$response = curl_exec($curlObj);
	$json = json_decode($response);
	curl_close($curlObj);
	//echo("### short url=$json->id");
	return $json->id;
}
?>