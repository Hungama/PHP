<?php
$headers = array(
    'Accept-Language:eng',
    'Authorization: Basic ' . base64_encode("uninor_contests:Uninor@1462"),
    'x-output-level:255'
);

//$fetch_array=array('780','782','793','794','850');
$fetch_array=array('780');
foreach( $fetch_array as $value)
{
echo $url="http://mdn.hungama.com/streaming/2588763/5/".$value."/contest?duration=PT0H0M3000S&cdn=akamai&agent=application&cms=ms2&protocol=filedl";
//$url = "http://mdn.hungama.com/download/2446646/1/2/abc";
//$url = "http://mdn.hungama.com/streaming/2588763/5/780/abc?duration=PT0H0M30S&cdn=akamai&agent=application&cms=ms2&protocol=filedl";

//http:// mdn.hungama.com/download/12345/4/8/Test      //test video url
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
echo $output.'<br/>';
curl_close($ch);
}
?>
