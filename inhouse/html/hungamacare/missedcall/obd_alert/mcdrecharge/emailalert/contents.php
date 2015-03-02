<?php
error_reporting(1);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include ("/var/www/html/hungamacare/missedcall/obd_alert/mcdrecharge/emailalert/func.php");
$filepath = 'rechargeEnterpriseMcDw_' . $filedate . '.csv';
$fp=fopen($filepath,'a+');
fwrite($fp,'Msisdn'.','.'RequetDateTime'.','.'RechargeDateTime'.','.'Response'.','.'Operator'.','.'circle'.','.'party'.','.'status'.','.'campgId'.','.'trxid'."\r\n");
  $getwinner_query="select ANI,EntryDate as RequetDateTime,RechargeDate as RechargeDateTime,Response,Operator,circle,party,status,campgId,trxid  from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(EntryDate)='".$PrevDate."' order by EntryDate";
	$result_winner = mysql_query($getwinner_query, $dbConn) or die(mysql_error());
	$result_row_winner = mysql_num_rows($result_winner);	
	
	if ($result_row_winner > 0) {
			while ($result_data = mysql_fetch_array($result_winner))
				  {
				  $circle=$circle_info[$result_data['country_code']];
				  $Response='';
				  $Response=str_replace(",","-",$result_data['Response']);
			fwrite($fp,$result_data['ANI'].','.$result_data['RequetDateTime'].','.$result_data['RechargeDateTime'].','.$Response.','.$result_data['Operator'].','.$result_data['circle'].','.$result_data['party'].','.$result_data['status'].','.$result_data['campgId'].','.$result_data['trxid']."\r\n");
				 }
		}
sleep(10);
		$path = $filepath;
            $files_to_zip = array($path);
            $newZip = 'rechargeEnterpriseMcDw_' . $filedate . '.zip';

           create_zip($files_to_zip, $newZip);
            sleep(2);
		
$inSuccess=0;
$totalSuccessData = mysql_query("select count(ANI) as total from  Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$PrevDate."' and response like '%success%'",$dbConn);
list($inSuccess) = mysql_fetch_array($totalSuccessData);

$inFailure=0;
$totalFailData = mysql_query("select count(ANI) as total from  Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$PrevDate."' and response like '%failure%'",$dbConn);
list($inFailure) = mysql_fetch_array($totalFailData);


$totalcountData = mysql_query("select count(1) as total,status from  Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$PrevDate."' group by status",$dbConn);
$inProcess=0;
$inQueue=0;
$inFailed=0;
$inStatusUpdate=0;
$totalReqs=0;

while($data= mysql_fetch_array($totalcountData))
{
$status=$data['status'];
$total=$data['total'];
$totalReqs=$totalReqs+$total;
	if($status==0)
	$inQueue=$total;
	elseif($status==11)
	$inProcess=$total;
	elseif($status==9 || $status==10)
	$inFailed=$total;
	elseif($status==5)
	$inStatusUpdate=$total;

}


$ctime=date("d,D M H A");
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
 $message .= "<tr><td colspan='8' align='center' >Service Alert - Enterprise - McDowells</td></tr>";
 $message .= "<tr> <td height='47' colspan='8' align='center' ><strong>EnterpriseMcDw - $ctime</strong></td></tr>";
if($i%2==0)
{
$class2='valign="middle" bgcolor="#f2f2f2" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
$class1='valign="middle" bgcolor="#f2f2f2" style="border-left: 1px solid #666;border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
}
else
{
$class2='valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
$class1='valign="middle" bgcolor="#FFFFFF" style="border-left: 1px solid #666;border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
}
$message .= "<tr><td $class1>Total Request</td><td $class2>".number_format($totalReqs)."</td></tr>";
$message .= "<tr><td $class1>Total Recharge Success</td><td $class2>".number_format($inSuccess)."</td></tr>";
$message .= "<tr><td $class1>Total Recharge Failure</td><td $class2>".number_format($inFailure)."</td></tr>";
$message .= "<tr><td $class1>Total In Process</td><td $class2>".number_format($inProcess)."</td></tr>";
$message .= "<tr><td $class1>Total Invalid Request</td><td $class2>".number_format($inFailed)."</td></tr>";
$message .= "<tr><td $class1>Total Queued</td><td $class2>".number_format($inQueue)."</td></tr>";

$message .= "</table>";
$message .="</body></html>";
$htmlfilename='rechargeEnterpriseMcDw_'.$filedate.'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>