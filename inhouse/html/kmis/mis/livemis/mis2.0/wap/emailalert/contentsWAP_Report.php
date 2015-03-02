<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
#$prevdate='20141218';
#$prevdatedb='2014-12-18';
echo $prevdate;
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$month=date('m');
$curdate = date("YmdHis");
////////////////////////////////////////Last Day WAP data summary /////////////////////////
////////Vodafone RU /////
$VodaURL_browsing='http://202.87.41.147/hungamawap/uninor/DoubleConsent/';
$VodawaplogFile="AllVodaVisitorRequestMIS_".$prevdate.'.txt';
$Vodaurltohit_browsing=$VodaURL_browsing.$VodawaplogFile;

////////// Aircel /////
$AircelURL_browsing='http://202.87.41.147/hungamawap/aircel/wap_sub/';
$AircelwaplogFile="AllAircelVisitorRequestMIS_".$prevdate.'.txt';
$Aircelurltohit_browsing=$AircelURL_browsing.$AircelwaplogFile;

$AircelStoreURL_browsing='http://202.87.41.147/hungamawap/aircel/wap_sub/';
$AircelStorewaplogFile="AllAircelStore25VisitorRequestMIS_".$prevdate.'.txt';
$AircelStoreurltohit_browsing=$AircelStoreURL_browsing.$AircelStorewaplogFile;
///////idea /////

$ideaURL_browsing='http://202.87.41.147/hungamawap/uninor/DoubleConsent/';
$ideawaplogFile="AllIdeaVisitorRequestMIS_".$prevdate.'.txt';
$ideaurltohit_browsing=$ideaURL_browsing.$ideawaplogFile;
///////Reliance /////
$relURL_browsing='http://202.87.41.147/hungamawap/reliance/wap_sub/';
$relwaplogFile="AllRelianceVisitorRequestMIS_".$prevdate.'.txt';
$relurltohit_browsing=$relURL_browsing.$relwaplogFile;
///////bsnl/////

$bsnlURL_browsing='http://202.87.41.147/hungamawap/uninor/DoubleConsent/';
$bsnlwaplogFile="AllBSNLVisitorRequestMIS_".$prevdate.'.txt';
$bsnlurltohit_browsing=$bsnlURL_browsing.$bsnlwaplogFile;

///////  Tata //////
$TataURL_browsing='http://202.87.41.194/hungamawap/docomo/doubCons/logs/';
$TatawaplogFile="AllTataVisitorRequestMIS_".$prevdate.'.txt';
$Tataurltohit_browsing=$TataURL_browsing.$TatawaplogFile;

///////Airtel ///// 
$airtelURL_browsing='http://117.239.178.108/hungamawap/airtel/CCG/logs/tarfiles/';
$airtelwaplogFile="AllAirtelVisitorRequestMISNew_".$prevdate.'.tar.gz';
$airtelurltohit_browsing=$airtelURL_browsing.$airtelwaplogFile;


$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .='Hi All,<br><br>';
$message .='Please Find Links Urls for WAP services.<br><br>';
$message .= '<table border="1" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';

 $message .= '<tr>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; text-align: center; border-right:
 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">Service Name</td>
 <td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; text-align: center; border-right:
 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">Type</td>
 <td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; text-align: center; border-right:
 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">Link for Browsing Logs</td>
 </tr>';


for($i=0;$i<8;$i++)
{
if($i%2==0)
{
$class2='valign="middle" bgcolor="#f2f2f2" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:left"';
}
else
{
$class2='valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:left"';
}
$type=' Visitor Logs ';
switch($i)
{
	case 0:
           $service='Voda RU 30';
		   $url=$Vodaurltohit_browsing;
		   break;
	case 1:
		   $service='Aircel';
		   $url=$Aircelurltohit_browsing;
		   break;
	case 2:
		   $service='Aircel Store';
		   $url=$AircelStoreurltohit_browsing;
		   break;
	case 3:
		   $service='Tata';
		   $url=$Tataurltohit_browsing;
		   break;
	case 4:
		   $service='BSNL';
		   $url=$bsnlurltohit_browsing;
		   break;
	case 5:
		   $service='AirtelLDR';
		   $url=$airtelurltohit_browsing;
		   break;	
	case 6:
		   $service='IDEA';
		   $url=$ideaurltohit_browsing;
		   break;
	case 7:
		   $service='Reliance';
		   $url=$relurltohit_browsing;
		   break;		
}


$message .= "<tr><td $class2>".$service."</td>
<td $class2>".$type."</td>
<td $class2><a href=".$url." style='background-color:transparent; text-decoration:underline; font-size: 14px; '> Click Here to Download </a></td>
</tr>";

}
$message .= "</table>";
$message .="<br><br>Thanks & Regards <br> Team MIS(Hungama)";
$message .="</body></html>";
//echo $message;
$htmlfilename='emailcontentWAP_Report_'.date('Ymd').'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>