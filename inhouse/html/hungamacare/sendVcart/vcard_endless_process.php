<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$curdate = date("d-m-Y_His");
$dndcheckfile='vcardactivebase_'.$curdate;
$remote_file = $dndcheckfile . '.txt';
$filepathdndcheck = '/var/www/html/hungamacare/sendVcart/dndcheck/'.$dndcheckfile . '.txt';
$filename=$filepathdndcheck;
$filepathdndcheck_csv = '/var/www/html/hungamacare/sendVcart/dndcheck/'.$dndcheckfile.'.csv';
$processlog = "/var/www/html/hungamacare/sendVcart/logs/Vcardprocesslog_".date('Ymd').".txt";
unlink($filepathdndcheck);
unlink($filepathdndcheck_csv);
$file_process_status = '******Script start for DocomoVCard Process *********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	

$select_query="select ani from docomo_radio.tbl_radio_subscription nolock where status IN ('1','11') ORDER BY sub_date DESC limit 50";
$select_result = mysql_query($select_query, $dbConn212) or die(mysql_error());
$numRows = mysql_num_rows($select_result);
if($numRows>0)
{
   while (list($msisdn) = mysql_fetch_array($select_result))
   {
    $logData = $msisdn . "\n";
    error_log($logData, 3, $filepathdndcheck);
			
   }
   sleep(10);
 require '/var/www/html/hungamacare/sendVcart/dndCheck_ftp.php';
   sleep(15);
	
	
	$lines = file($filepathdndcheck_csv);
     foreach ($lines as $line_num => $mobno) 
	 {
		$mno = trim($mobno);
        if (!empty($mno)) 
		{
			$sndMsgQuery = "CALL docomo_radio.SEND_VCARD_BULK('" . $msisdn . "','tatm','bulk')";
				if(mysql_query($sndMsgQuery,$dbConn212))
				$res="SUCCESS";
				else
				$res=mysql_error();
				
				if($res!="SUCCESS")
				{
				echo $res;
				$plogerror = $res."#".$sndMsgQuery."#". date('Y-m-d H:i:s') . "\n";
				error_log($plogerror, 3, $processlog); 
                }
   
        }
	 }
}
$file_process_status = '******Script end for DocomoVCard Process *********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
mysql_close($dbConn212);
echo "generated";
?>