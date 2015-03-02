<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$month=date('m');

$curdate = date("YmdHis");
/*
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
*/
////////////////////////////////////////Last Day WAP data summary /////////////////////////
$get_LastDayWAPData = "select TOTAL_HITS,UNIQUE_HITS,MISSING_MSISDN,ACTIVATION_SUCCESS,AFFID,AFFID_NAME from Hungama_WAP_Logging.tbl_wapActivationDailyReportS2S where date(date)='".$rechargeDate."'";
$data = mysql_query($get_LastDayWAPData, $dbConn) or die(mysql_error());
$ctime=date("d,D M H A");
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
$message .= "<tr><td colspan='6' align='center' >Service Alert - WAPAirtelLDR</td></tr>";
 $message .= '<tr>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">AFFLIATE</td>
 <td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">AFFLIATE NAME</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">TOTAL HITS</td>
 <td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">UNIQUE HITS</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 
1px solid #666; border-top: 1px solid #666"> MISSING MSISDN</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">ACTIVATION SUCCESS</td>
 </tr>';

$i=0;
while(list($TOTAL_HITS,$UNIQUE_HITS,$MISSING_MSISDN,$ACTIVATION_SUCCESS,$AFFID,$AFFID_NAME) = mysql_fetch_array($data))
{
if($i%2==0)
{
$class2='valign="middle" bgcolor="#f2f2f2" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
}
else
{
$class2='valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
}
$message .= "<tr><td $class2>".$AFFID."</td>
<td $class2>".$AFFID_NAME."</td>
<td $class2>".number_format($TOTAL_HITS)."</td>
<td $class2>".number_format($UNIQUE_HITS)."</td>
<td $class2>".number_format($MISSING_MSISDN)."</td>
<td $class2>".number_format($ACTIVATION_SUCCESS)."</td>
</tr>";
$i++;
}
$message .= "</table>";
$message .="</body></html>";
//echo $message;
$htmlfilename='emailcontentWAP_S2S_ActReport_'.date('Ymd').'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>