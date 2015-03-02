<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$month=date('m');

$curdate = date("YmdHis");
$filepath = 'airtel_ads_click_report_updated' . $curdate . '.csv';
////////////////////////////////////////All Missed Call data start here /////////////////////////
   $getData_query="select date,service,TOTAL_HITS,UNIQUE_HITS,MISSING_MSISDN,OPERATOR_NOT_FOUND,ALREADY_SUBSCRIBED,SENT_TO_CG,UNIQUE_SENT_TO_CG,CG_RETURN,ACTIVATION_SUCCESS,ACTIVATION_LOW_BALANCE from Hungama_WAP_Logging.tbl_wapActivationDailyReport  where month(date)='".$month."' order by date";
	$result_winner = mysql_query($getData_query, $dbConn) or die(mysql_error());
	$result_row_winner = mysql_num_rows($result_winner);	
	if ($result_row_winner > 0) {

	$fp=fopen($filepath,'a+');

fwrite($fp,'DATE'.','.'TOTAL_HITS'.','.'UNIQUE_HITS'.','.'MISSING_MSISDN'.','.'OPERATOR_NOT_FOUND'.','.'ALREADY_SUBSCRIBED'.','.'SENT_TO_CG'.','.'UNIQUE_SENT_TO_CG'.','.'CG_RETURN'.','.'ACTIVATION_SUCCESS'.','.'ACTIVATION_LOW_BALANCE'."\r\n");

			while ($result_data = mysql_fetch_array($result_winner))
				  {
			fwrite($fp,$result_data['date'].','.$result_data['TOTAL_HITS'].','.$result_data['UNIQUE_HITS'].','.$result_data['MISSING_MSISDN'].','.$result_data['OPERATOR_NOT_FOUND'].','.$result_data['ALREADY_SUBSCRIBED'].','.$result_data['SENT_TO_CG'].','.$result_data['UNIQUE_SENT_TO_CG'].','.$result_data['CG_RETURN'].','.$result_data['ACTIVATION_SUCCESS'].','.$result_data['ACTIVATION_LOW_BALANCE']."\r\n");
				 }
		
		}
else
{
exit;
}

////////////////////////////////////////Last Day WAP data summary /////////////////////////
$get_LastDayWAPData = "select TOTAL_HITS,UNIQUE_HITS,MISSING_MSISDN,OPERATOR_NOT_FOUND,ALREADY_SUBSCRIBED,SENT_TO_CG,UNIQUE_SENT_TO_CG,CG_RETURN,ACTIVATION_SUCCESS,ACTIVATION_LOW_BALANCE,MULTIPLECLICK_CCGCOUNT,BACK_FROM_CG from Hungama_WAP_Logging.tbl_wapActivationDailyReport where date(date)='".$rechargeDate."'";
$data = mysql_query($get_LastDayWAPData, $dbConn) or die(mysql_error());
list($TOTAL_HITS,$UNIQUE_HITS,$MISSING_MSISDN,$OPERATOR_NOT_FOUND,$ALREADY_SUBSCRIBED,$SENT_TO_CG,$UNIQUE_SENT_TO_CG,$CG_RETURN,$ACTIVATION_SUCCESS,$ACTIVATION_LOW_BALANCE,$MULTIPLECLICK_CCGCOUNT,$BACK_FROM_CG) = mysql_fetch_array($data); 

$ctime=date("d,D M H A");
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
 $message .= "<tr><td colspan='8' align='center' >Service Alert - WAPAirtelLDR</td></tr>";
 //$message .= "<tr> <td height='47' colspan='8' align='center' ><strong>EnterpriseMcDw - $ctime</strong></td></tr>";
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
$message .= "<tr><td $class1>TOTAL HITS</td><td $class2>".number_format($TOTAL_HITS)."</td></tr>";
$message .= "<tr><td $class1>UNIQUE HITS</td><td $class2>".number_format($UNIQUE_HITS)."</td></tr>";
$message .= "<tr><td $class1>MISSING MSISDN</td><td $class2>".number_format($MISSING_MSISDN)."</td></tr>";
$message .= "<tr><td $class1>OPERATOR NOT FOUND</td><td $class2>".number_format($OPERATOR_NOT_FOUND)."</td></tr>";
$message .= "<tr><td $class1>ALREADY SUBSCRIBED</td><td $class2>".number_format($ALREADY_SUBSCRIBED)."</td></tr>";
$message .= "<tr><td $class1>SENT TO CG</td><td $class2>".number_format($SENT_TO_CG)."</td></tr>";
$message .= "<tr><td $class1>UNIQUE_SENT TO CG</td><td $class2>".number_format($UNIQUE_SENT_TO_CG)."</td></tr>";
$message .= "<tr><td $class1>CG RETURN</td><td $class2>".number_format($CG_RETURN)."</td></tr>";
$message .= "<tr><td $class1>ACTIVATION SUCCESS</td><td $class2>".number_format($ACTIVATION_SUCCESS)."</td></tr>";
$message .= "<tr><td $class1>ACTIVATION LOW BALANCE</td><td $class2>".number_format($ACTIVATION_LOW_BALANCE)."</td></tr>";
$message .= "<tr><td $class1>User has clicked multiple times</td><td $class2>".number_format($MULTIPLECLICK_CCGCOUNT)."</td></tr>";
$message .= "<tr><td $class1>User has clicked BACK</td><td $class2>".number_format($BACK_FROM_CG)."</td></tr>";
$message .= "</table>";
$message .="</body></html>";

$htmlfilename='emailcontentWAPActReport_'.date('Ymd').'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>