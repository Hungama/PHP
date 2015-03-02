<?php
include ("/var/www/html/hungamacare/config/dbConnect.php");
error_reporting(0);
$curdatetime = date("dmYHis");

$getActivebBaseForScrub = "/var/www/html/hungamacare/vadndcheck/activebase/VA_".$curdatetime.".txt";
$filepathdndcheckOutput = "VA_OUT_" . $curdatetime;
$remote_file = $filepathdndcheckOutput.'.txt';
$FinalScrubbedFile='/var/www/html/hungamacare/vadndcheck/dndcheck/'.$remote_file;
$FinalScrubbedFileQuery='/var/www/html/hungamacare/vadndcheck/dndcheck/query_'.$remote_file;

$query = "select ANI from mts_voicealert.tbl_voice_subscription nolock";
$queryExe = mysql_query($query, $dbConn);

while ($rows = mysql_fetch_array($queryExe)) {
    
    $logData = $rows['ANI'] . "\n";
    error_log($logData, 3, $getActivebBaseForScrub);
}
sleep(10);
require '/var/www/html/hungamacare/vadndcheck/dndCheck_ftp.php';
sleep(50);
//$FinalScrubbedFile='/var/www/html/hungamacare/vadndcheck/dndcheck/VA_OUT_14042014050001.txt';
$lines = file($FinalScrubbedFile);
$totalFileCount=count($lines);
if($totalFileCount>=1)
{
$isDNDUpdate = "update mts_voicealert.tbl_voice_subscription set IsDND=1";
mysql_query($isDNDUpdate, $dbConn);

$isDNDUpdate = "update mts_voicealert.tbl_voice_category set IsDND=1";
mysql_query($isDNDUpdate, $dbConn);

foreach ($lines as $line_num => $mobno) {
    $mno = trim($mobno);
    if (!empty($mno)) {
	 $updateDndStatus= "CALL mts_voicealert.VA_DND_STATUS('".$mno."')";
	 mysql_query($updateDndStatus, $dbConn);
	
   }
}
}
else
{
echo "DND File Is Blank";
}
echo "Done";
mysql_close($dbConn);
?>