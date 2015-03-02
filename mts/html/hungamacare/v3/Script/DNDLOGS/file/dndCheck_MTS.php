<?php
error_reporting(0);
$fileprocessinfo="/var/www/html/hungamacare/v3/Script/DNDLOGS/process.txt";
$startfiletm = date("Y-m-d H:i:s");
$starttime="file process start"."#".$startfiletm."\n\r";
error_log($starttime,3,$fileprocessinfo);
//$data_date='2013-10-15';
$data_date=date('Y-m-d');
$outputfile_ND='/var/www/html/hungamacare/v3/Script/DNDLOGS/file/test1_ND_107.txt';
$outputfile_DND='/var/www/html/hungamacare/v3/Script/DNDLOGS/file/test1_DND_107.txt';

$lines = file('/var/www/html/hungamacare/v3/Script/DNDLOGS/file/test1.txt');
if($lines)
{
foreach ($lines as $line_num => $mobno)
 {// sleep(1);
$mno=trim($mobno);
$response=curlRespone($mno);
echo $mno."#".$response."<br>";
$mystring = $response;
$findme   = 'opstype:D';
$pos = strpos($mystring, $findme);
if ($pos === false) {
   $response1='DND';
} else {
    $response1='ND';
}


//echo $mno."#".$response."\r\n";
if($response1=='ND')
{
//$message =$mno."#".$response."\r\n";
$message =$mno."\r\n";
error_log($message,3,$outputfile_ND);
}
else
{
$message =$mno."#".$response."\r\n";
error_log($message,3,$outputfile_DND);
}
}
}
else
{
echo "No data found";
}


function curlRespone($mdn)
{
	$ch = curl_init();
	//$callBackUrl="http://119.82.69.215:8080/dndCheck/GetDetail?uname=hundndapi&pwd=hun_dnd_api&mno=".$mdn;
	$dndCheckUrl = "http://192.168.100.238:8080/dndCheck/GetDetail?uname=hundndapi&pwd=hun_dnd_api&mno=".$mdn;
	//echo $dndCheckUrl."\r\n";
	curl_setopt($ch, CURLOPT_URL,$dndCheckUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$CallBackResponse = curl_exec($ch);
	
	return $CallBackResponse;
}

$endtime1 = date("Y-m-d H:i:s");
$endtime="file process end"."#".$endtime1."\n\r";
error_log($endtime,3,$fileprocessinfo);

exit;
?>