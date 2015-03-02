<?php
error_reporting(1);
include ("db.php");
$prevdate = date("Ymd", time() - 60 * 60 * 24);
$prevdate_email = date("Y-m-d", time() - 60 * 60 * 24);

//$prevdate=20121215;
//$prevdate_email='2012-12-15';
function getTotalCount($prevdate)
 {
$baseurl_1='http://125.21.241.108/common/getLogs.php?date=';
//$baseurl_2='http://202.87.41.194/common/getLogs.php?date=';
$baseurl_3='http://202.87.41.147/common/getLogs.php?date=';
$baseurl_4='http://202.87.41.147/hungamawap/uninor/164531/subsLog/';
$baseurl_5='http://202.87.41.147/hungamawap/airtel/154036/visitorLogVoice/';
$baseurl_6='http://202.87.41.147/hungamawap/aircel/134685/subsLog/';
$baseurl_7='http://202.87.41.147/hungamawap/uninor/DoubleConsent/CCGVisitorRequest_';

$urltohit_1=$baseurl_1.$prevdate;
//$urltohit_2=$baseurl_2.$prevdate;
$urltohit_2="http://202.87.41.194/hungamawap/docomo/130734/logs/".$prevdate.'_log1.log';
$urltohit_3=$baseurl_3.$prevdate;
$urltohit_4=$baseurl_4.$prevdate.'_log1.log';
$urltohit_5=$baseurl_5.$prevdate.'_log1.log';
$urltohit_6=$baseurl_6.$prevdate.'_log1.log';
$urltohit_7=$baseurl_7.$prevdate.'.txt';
//Direct Charging hits
$urltohit_2="http://202.87.41.194/hungamawap/docomo/130734/logs/".$prevdate.'_log1.log';

$urltohit_ccg1="http://202.87.41.147/hungamawap/uninor/DoubleConsent/AllVodaVisitorRequestMIS_".$prevdate.'.txt';
$urltohit_ccg2="http://202.87.41.147/hungamawap/aircel/wap_sub/AllAircelVisitorRequestMIS_".$prevdate.'.txt';
$urltohit_ccg3="http://202.87.41.147/hungamawap/aircel/wap_sub/AllAircelStore25VisitorRequestMIS_".$prevdate.'.txt';
$urltohit_ccg4="http://202.87.41.147/hungamawap/uninor/DoubleConsent/AllBSNLVisitorRequestMIS_".$prevdate.'.txt';
$urltohit_ccg5="http://202.87.41.147/hungamawap/airtel/dconsent/AllAirtelSendCCGVisitorResponseMIS_".$prevdate.'.txt';

$urltohit_ccg6="http://202.87.41.194/hungamawap/docomo/doubCons/logs/AllTataVisitorRequestMIS_".$prevdate.'.txt';

  $fGetContents_ccg1 = file_get_contents($urltohit_ccg1);
   $e_ccg1_147 = explode("\n", trim($fGetContents_ccg1));
   $totalcount_ccg1=count($e_ccg1_147);

   $fGetContents_ccg2 = file_get_contents($urltohit_ccg2);
   $e_ccg2_147 = explode("\n", trim($fGetContents_ccg2));
   $totalcount_ccg2=count($e_ccg2_147);
   
   $fGetContents_ccg3 = file_get_contents($urltohit_ccg3);
   $e_ccg3_147 = explode("\n", trim($fGetContents_ccg3));
   $totalcount_ccg3=count($e_ccg3_147);
   
   $fGetContents_ccg4 = file_get_contents($urltohit_ccg4);
   $e_ccg4_147 = explode("\n", trim($fGetContents_ccg4));
   $totalcount_ccg4=count($e_ccg4_147);
   
   
   $fGetContents_ccg5 = file_get_contents($urltohit_ccg5);
   $e_ccg5_147 = explode("\n", trim($fGetContents_ccg5));
   $totalcount_ccg5=count($e_ccg5_147);
   
  $fGetContents_ccg6 = file_get_contents($urltohit_ccg6);
   $e_ccg1_194 = explode("\n", trim($fGetContents_ccg6));
   $totalcount_ccg6=count($e_ccg1_194);





//get total count for 125.21.241.108
   $fGetContents_108 = file_get_contents($urltohit_1);
   $e_108 = explode("\n", trim($fGetContents_108));
   $totalcount_108=count($e_108);
//get total count for 202.87.41.194
  $fGetContents_194 = file_get_contents($urltohit_2);
    $e_194 = explode("\n", trim($fGetContents_194));
   $totalcount_194=count($e_194);
   $totalcount_194=$totalcount_194+$totalcount_ccg6;
   
//get total count for 202.87.41.147
  $fGetContents_147 = file_get_contents($urltohit_3);
    $e_147 = explode("\n", trim($fGetContents_147));
   $totalcount_147=count($e_147);
     $fGetContents_147_uninor = file_get_contents($urltohit_4);
    $e_147_uninor = explode("\n", trim($fGetContents_147_uninor));
   $totalcount_147_uninor=count($e_147_uninor);
  
  $fGetContents_147_airtel = file_get_contents($urltohit_5);
    $e_147_airtel = explode("\n", trim($fGetContents_147_airtel));
   $totalcount_147_airtel=count($e_147_airtel);
   
   $fGetContents_147_aircel = file_get_contents($urltohit_6);
    $e_147_aircel = explode("\n", trim($fGetContents_147_aircel));
   $totalcount_147_aircel=count($e_147_aircel);
   
   $fGetContents_147_uninorccg = file_get_contents($urltohit_7);
    $e_147_uninorccg = explode("\n", trim($fGetContents_147_uninorccg));
   $totalcount_147_uninorccg=count($e_147_uninorccg);
   
   $totalcount_147=$totalcount_147+$totalcount_147_uninor+$totalcount_147_airtel+$totalcount_147_aircel+$totalcount_147_uninorccg+$totalcount_ccg1+$totalcount_ccg2+$totalcount_ccg3+$totalcount_ccg4+$totalcount_ccg5;
//retrive data from database

$getdatasql_108=mysql_query("select count(*) from misdata.tbl_browsing_wap where hitip='125.21.241.108' and date(datetime)='$prevdate'");
$result_108=mysql_fetch_array($getdatasql_108);
	$getdatasql_194=mysql_query("select count(*) from misdata.tbl_browsing_wap where hitip='202.87.41.194' and date(datetime)='$prevdate'");
	$result_194=mysql_fetch_array($getdatasql_194);
	$getdatasql_147=mysql_query("select count(*) from misdata.tbl_browsing_wap where hitip='202.87.41.147' and date(datetime)='$prevdate'");
	$result_147=mysql_fetch_array($getdatasql_147);

//begin of HTML message 
$message = '<html><body>';
		    $message .= '<table rules="all" style="border-color: #666;" border="0" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td><strong>IP:</strong> </td><td><strong>Total Count In Link</strong> </td><td><strong>Total Count In Database</strong> </td></tr>";
			$message .= "<tr style='background: #ADD8E6;'><td><strong>125.21.241.108</strong> </td><td>" . strip_tags($totalcount_108) ."</td><td>".strip_tags($result_108[0]) ."</td></tr>";
			$message .= "<tr style='background: #ADD8E6;'><td><strong>202.87.41.194</strong> </td><td>" . strip_tags($totalcount_194) ."</td><td>".strip_tags($result_194[0]) ."</td></tr>";
			$message .= "<tr style='background: #ADD8E6;'><td><strong>202.87.41.147</strong> </td><td>" . strip_tags($totalcount_147) ."</td><td>".strip_tags($result_147[0]) ."</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
   //end of message 
	
return $message;
	
   }

$resultset=getTotalCount($prevdate);
//echo $resultset;
//exit;
//close database connection here
 mysql_close($con);
				$to = 'vinod.k@hungama.com';
				$cc = 'satay.tiwari@hungama.com';
				$from = 'ms.mis@hungama.com';
			
			$subject = 'Daily Waplog Report Of date'.'-'.$prevdate_email;
			
			$headers = "From: " . $from . "\r\n";
		//	$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

if (mail($to, $subject, $resultset, $headers)) {
              echo 'Your message has been sent.';
            } else {
              echo 'There was a problem sending the email.';
            }

		if (mail($cc, $subject, $resultset, $headers)) {
              echo 'Your message has been sent.';
            } else {
              echo 'There was a problem sending the email.';
            }
            
?>