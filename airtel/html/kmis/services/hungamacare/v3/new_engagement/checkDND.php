<?php
function checkDND($mdn) {
    $ch = curl_init();
    $dndCheckUrl = "http://119.82.69.215:8080/dndCheck/GetDetail?uname=hundndapi&pwd=hun_dnd_api&mno=" . $mdn;
    curl_setopt($ch, CURLOPT_URL, $dndCheckUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_PROXY, '10.2.34.54:8080');
	 $CallBackResponse = curl_exec($ch);
    return $CallBackResponse;
}
$mdn='8587800665';
echo $out=checkDND($mdn);
?>  