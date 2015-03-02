<?php
error_reporting(0);
$headers = array(
    'Accept-Language:eng',
    'Authorization: Basic ' . base64_encode("uninor_contests:Uninor@1462"),
    'x-output-level:255'
);
$content_id='2588763';
$url = "http://publisher.metasea.hungamatech.com/MetaSeaWS/content/id/" . $content_id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $xml = simplexml_load_string($output);
    $json = json_encode($xml);
    $array = json_decode($json, TRUE);
include ("/var/www/html/hungamacare/config/dbConnect.php");
 foreach ($array['files']['file'] as $val) {
    $details = array_values($val);
$ext = $details[2];

if ($ext == 'mp4' || $ext == '3gp'){
    echo  $ext.'<br/>';
// content id save
$contentFileType = $details[5];
$contentFileType_details = array_values($contentFileType);
//content file type id
$contentFileType_details1 = array_values($contentFileType_details[0]);
$subType = $details[6];
$subType_details = array_values($subType);//
$subType_details1 = array_values($subType_details[0]);
$url = "http://mdn.hungama.com/streaming/" . $content_id . "/" . $contentFileType_details1[0] . "/" . $subType_details1[0] . "/contest?duration=PT0H0M3000S&cdn=akamai&agent=application&cms=ms2&protocol=filedl";
echo  $url;
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
echo $output.'<br/>';

//step to end the code
 
 
 //create file section
//$my_file = 'content_id/'.$value.'.json';
//$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicit
//chmod($my_file,0777);
//$d=array();
//$d[]= array('contentfiletypeid' => "$contentFileType_details1[0]",'contentfilesubtypeid' => "$subType_details1[0]");
//$json = json_encode($d);
//$fh = fopen($my_file, 'w');
//fwrite($fh, $json);
//fclose();

}
}






?>
