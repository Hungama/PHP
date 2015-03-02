<html>
<head>
<meta name="viewport"  content=" initial-scale=1.0,user-scalable=no, maximum-scale=1.0">
</head>
<body>
<?php
error_reporting(0);
if ($_REQUEST['contid']) {
    $contid = $_REQUEST['contid'];
}
if ($_REQUEST['pin']) {
    $pin = $_REQUEST['pin'];
}
if ($_REQUEST['msisdn']) {
    $msisdn = $_REQUEST['msisdn'];
}
	$err_msg = $msisdn."#".$contid."#".$pin."#".date('H:i:s')."\r\n";
	$error_log_path="/var/www/html/hungamacare/voiceContentServe/logs/log_".date('Ymd').".txt";
    error_log($err_msg, 3, $error_log_path);
$fileName=$contid.'.mp3';

$ch_execute_pin = 2;
if (($ch_execute_pin != 1) && ($contid) && (is_numeric($contid))) {
   
                $check_pin = "http://192.168.10.127/Reliance/UpdatePIN_status.php";
                $post_fields_pin = "pin=$pin&msisdn=$msisdn&contid=$contid";

                $ch_pin = curl_init("$check_pin?$post_fields_pin");
                curl_setopt($ch_pin, CURLOPT_RETURNTRANSFER, TRUE);
				$ch_execute_pin = curl_exec($ch_pin); // updated by Athar On 9th Sep 2012
                //echo '<br>Curl error: ' . curl_error($ch_pin);
                curl_close($ch_pin);
               $file = 'http://omega.hungamavoice.com/hungamacare/voiceContentServe/contentid/'.$fileName; 
			   ?>
			   <a href="<?php echo $file;?>">Click To Download</a>
			<?php
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
?>
</body>
</html>