<?php
$headers = array(
    'Accept-Language:eng',
    'Authorization: Basic ' . base64_encode("uninor_contests:Uninor@1462"),
    'x-output-level:255'
);
$content_id = $_REQUEST['contentid'];
$exists = file_exists('/var/www/html/hungamacare/contest/html/content_id/'.$content_id.'.json');
if(!$exists) {
echo "fail to access the file";
}
else
{
$file='/var/www/html/hungamacare/contest/html/content_id/'.$content_id.'.json';
$json_decode_data = json_decode(file_get_contents($file), true);
$url = "http://mdn.hungama.com/streaming/" . $content_id . "/" . $json_decode_data[0]['contentfiletypeid'] . "/" . $json_decode_data[0]['contentfilesubtypeid'] . "/contest?duration=PT0H0M3000S&cdn=akamai&agent=application&cms=ms2&protocol=filedl";
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
echo $output;
}
?>