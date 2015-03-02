<?php

$headers = array(
    'Accept-Language:eng',
    'Authorization: Basic ' . base64_encode("uninor_contests:Uninor@1462"),
    'x-output-level:255'
);

$contentid_array =  array(2176949);

foreach ($contentid_array as $key => $value) {
    $url = "http://publisher.metasea.hungamatech.com/MetaSeaWS/content/id/" . $value;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    $xml = simplexml_load_string($output);
    $json = json_encode($xml);
    
    
    $array1 = json_decode($json, TRUE);
    
    include ("/var/www/html/hungamacare/config/dbConnect.php");
    $i = 1;
    foreach ($array['files']['file'] as $val) {
        //$contentFileType = $val['contentFileType'];print_r($contentFileType);
        //$subType = $val['subType'];print_r($subType);
        $details = array_values($val);
		$ext = $details[2];

        if ($ext == 'mp4') {
           $contentFileType = $details[5];
            $contentFileType_details = array_values($contentFileType);
            $contentFileType_details1 = array_values($contentFileType_details[0]);
            $subType = $details[6];
            $subType_details = array_values($subType);
            $subType_details1 = array_values($subType_details[0]);
           //$url = "http://mdn.hungama.com/streaming/" . $value . "/" . $contentFileType_details1[0] . "/" . $subType_details1[0] . "/contest?duration=PT0H0M30S&cdn=akamai&agent=application&cms=ms2&protocol=filedl";
$url = "http://mdn.hungama.com/streaming/" . $value . "/" . $contentFileType_details1[0] . "/" . $subType_details1[0] . "/contest?duration=PT0H0M30S&cdn=akamai&agent=application&cms=ms2&protocol=filedl";
            //http:// mdn.hungama.com/download/12345/4/8/Test      //test video url
			echo $url."<br>";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
          echo $output.'<br/>';
   		//print_r($details);
		exit;        
            //echo $value;
            //die();
            $qry = "update uninor_summer_contest.question_bank_wapcontest set video='".$output."' where content_id='". $value ."'";
            $result = mysql_query($qry);
            die();
            
            echo "<br/><br/><br/>";
            break;die('here');
        }
        $i++;
    }
    curl_close($ch);
    //echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
}
//print_r($array['files']['file'][3]['paths']['path'][1]);
?>
