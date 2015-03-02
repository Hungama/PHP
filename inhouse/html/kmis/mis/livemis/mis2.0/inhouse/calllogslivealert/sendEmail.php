<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
error_reporting(0);
$dbConn=$dbConn212;
$serviceArray = array('1403' => 'MTVUninor', '1402' => 'Uninor54646', '1410' => 'RedFMUninor', '1409' => 'RIAUninor', '1412' => 'UninorRT', '1416' => 'UninorAstro',
    '14021' => 'UninorArtistAloud', '1408' => 'UninorSportsUnlimited', '1418' => 'UninorComedy', '1423' => 'UninorContest'
    , '1430' => 'UninorVABollyAlerts', '1431' => 'UninorVAFilmy', '1432' => 'UninorVABollyMasala', '1433' => 'UninorVAHealth', '1434' => 'UninorVAFashion');
$getCurrentTimeQuery="select hour(now())";
$timequery = mysql_query($getCurrentTimeQuery, $dbConn);
$resulth = mysql_fetch_row($timequery);
$gethour = sprintf("%02s", $resulth[0]);

if($gethour==00)
{
$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$cond="";
$chour="23";
$gethour= $chour;
$subDate=$chour;
}
else
{
$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$cond=" and hour(call_time)<'".$gethour."' ";
//$gethour= date('H', strtotime('-1 hour'));
$subDate=date('H', strtotime('-1 hour'));
$chour=$gethour;
$chour = sprintf("%02s", $chour);
}
echo 'Data for '.$chour."#".$gethour."#".$cond;
//code for zip and send email to Uninor user
$curdate = date("d-m-Y_His");
include('/var/www/html/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/FixZipArchive.php');
$the_folder = "callogs/".$chour."/";
$zip_file_name = 'calllogs_zip_file/'.$chour.'.zip';
if (file_exists($zip_file_name)) {
unlink($zip_file_name);
$za = new FlxZipArchive;
$res = $za->open($zip_file_name, ZipArchive::CREATE);
if($res === TRUE) {
    $za->addDir($the_folder, basename($the_folder));
    $za->close();
    echo 'zip archive has been created successfully';
}
//else
    
//echo 'Could not create a zip archive';
}
else
{
$za = new FlxZipArchive;
$res = $za->open($zip_file_name, ZipArchive::CREATE);
if($res === TRUE) {
    $za->addDir($the_folder, basename($the_folder));
    $za->close();
    //echo 'zip archive has been created successfully';
}
//else
//echo 'Could not create a zip archive';
}
require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer();
$mail->Encoding = 'base64';
$mail->setFrom('ms.mis@hungama.com', 'Ms Mis');
$mail->addReplyTo('ms.mis@hungama.com', 'Ms Mis');
$mail->addAddress('rahul.tripathi@hungama.com', 'Rahul Tripathi');
$mail->addAddress('satay.tiwari@hungama.com', 'Satay Tiwari');
$mail->addAddress('gaurav.bhatnagar@hungama.com', 'Gaurav Bhatnagar');
//$mail->addAddress('kunalk.arora@hungama.com', 'Kunal Arora');
//$mail->addAddress('gaurav.talwar@hungama.com', 'Gaurav Talwar');
$mail->addAddress('manu.sharma@hungama.com', 'Manu Sharma');
$mail->addAddress('arun.singh@hungama.com', 'Arun Singh');
$mail->addAddress('kiran.lakka@hungama.com', 'Kiran Lakka');
$mail->addAddress('piyush.srivastav@hungama.com', 'Piyush Srivastav');
$mail->addAddress('gadadhar.nandan@hungama.com', 'Gadadhar Nandan');

$curdatetime = date("Y-m-d H:i:s");
$dateMonthTime = date('j-M h:i A', strtotime($curdatetime));
$subject = 'Uninor Call logs || Till  ' . $subDate. 'hours';
$mail->Subject = $subject;
$zip_file_path='http://192.168.100.212/kmis/mis/livemis/mis2.0/inhouse/calllogslivealert/'.$zip_file_name;
$attached_link='<a href="'.$zip_file_path.'" target="_blank">Click here to download</a>';
$message="Hi Team,
Please find the link mention in this mail to download calling data till last hour.";
$mail->msgHTML($message.$attached_link);
 //$mail->addAttachment($target_path);
if (!$mail->send()) {
echo "Mailer Error: " . $mail->ErrorInfo;
} else {
echo "mail send successfully";
  }
//end of the code
mysql_close($dbConn);
?>