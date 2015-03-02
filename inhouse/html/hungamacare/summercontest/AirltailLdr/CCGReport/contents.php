<?php
error_reporting(0);
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$fileurl="http://117.239.178.108/hungamawap/airtel/CCG/CCGReport/airtelCCGLogs_".$rechargeDate.".zip";
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= "<table border='0' cellspacing='0' cellpadding='2' style='font-family: Century Gothic, Arial'>
<tr><td>Hi,<br><br>
<a href='".$fileurl."'>Click here to download report.</a>
<br><br>
</td></tr></table>";
$message .="</body></html>";
//echo  $message;
$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn212);
?>