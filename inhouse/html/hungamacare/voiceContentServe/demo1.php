<?php
ini_set("display_errors","1");
//ERROR_REPORTING(E_ALL ^ E_NOTICE);
//http://202.87.41.147/waphung/voiceContentServe/1310880/00757
$successfull="successful content download is subject to the handset compatibility.";
//$date=@date('Ymd H:i:s');
if ($_REQUEST['contid']) {
    $contid = $_REQUEST['contid'];
}
if ($_REQUEST['pin']) {
    $pin = $_REQUEST['pin'];
}
$fileName=$contid.'.mp3';

$ch_execute_pin = 2;
if (($ch_execute_pin != 1) && ($contid) && (is_numeric($contid))) {
   
                $check_pin = "http://192.168.10.127/Reliance/UpdatePIN_status.php";
                $post_fields_pin = "pin=$pin&msisdn=$msisdn&contid=$contid";

                $ch_pin = curl_init("$check_pin?$post_fields_pin");
                curl_setopt($ch_pin, CURLOPT_RETURNTRANSFER, TRUE);
                echo $ch_execute_pin = curl_exec($ch_pin); // updated by Athar On 9th Sep 2012
                //echo '<br>Curl error: ' . curl_error($ch_pin);
                curl_close($ch_pin);
               echo $file = 'http://192.168.100.212/hungamacare/voiceContentServe/contentid/'.$fileName; 
			//	header("Content-type: application/x-file-to-save"); 
				//header("Content-Disposition: attachment; filename=".basename($file)); 
				//readfile($file);

                //echo $actual_file;
 } else { // msisdn and cont id fail.....Arpita
    $content_serve = 0;
    $continue = 0;
    echo $err_msg = "2.Sorry,Invalid Pin.";
    //error_log("\n$date|$msisdn|$err_msg", 3, $error_log_path1);
    //header("location:$error_path?msg=$err_msg");
    exit;
}
//echo $err_msg;
?>