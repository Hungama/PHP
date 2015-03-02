<?php
error_reporting(0);
include ("db.php");
$prevdate = date("Ymd", time() - 60 * 60 * 24);
$prevdate_email = date("Y-m-d", time() - 60 * 60 * 24);

$prevdate=20121221;
//$prevdate_email='2012-12-15';
function getTotalCount($prevdate)
 {
$baseurl_1='http://125.21.241.108/common/getLogs.php?date=';
$baseurl_2='http://202.87.41.194/common/getLogs.php?date=';
$baseurl_3='http://202.87.41.147/common/getLogs.php?date=';

$urltohit_1=$baseurl_1.$prevdate;
$urltohit_2=$baseurl_2.$prevdate;
$urltohit_3=$baseurl_3.$prevdate;
//get total count for 125.21.241.108
   $fGetContents_108 = file_get_contents($urltohit_1);
   $e_108 = explode("\n", trim($fGetContents_108));
   $totalcount_108=count($e_108);
   
//get total count for 202.87.41.194
  $fGetContents_194 = file_get_contents($urltohit_2);
    $e_194 = explode("\n", trim($fGetContents_194));
 $totalcount_194=count($e_194);
 $j=0;    
	for ($i = 0; $i < $totalcount_194; $i++) {
	$data = explode("|", $e_194[$i]);
	if($data[0])
	{
	echo $i."##".$data[0]."<br>";
	$j++;
	}
	}
	echo $totalcount_194=$j;
	
//get total count for 202.87.41.147
  $fGetContents_147 = file_get_contents($urltohit_3);
    $e_147 = explode("\n", trim($fGetContents_147));
   $totalcount_147=count($e_147);
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
echo $resultset;
//close database connection here
 mysql_close($con);
exit;
 $to = 'vinod.k@hungama.com';
				$cc = 'satay.tiwari@hungama.com';
				$from = 'voice.mis@hungama.com';
			
			$subject = 'Daily Waplog Report Of date'.'-'.$prevdate_email;
			
			$headers = "From: " . $from . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            if (mail($to, $subject, $resultset, $headers)) {
              echo 'Your message has been sent.';
            } else {
              echo 'There was a problem sending the email.';
            }
		/*	 if (mail($cc, $subject, $resultset, $headers)) {
              echo 'Your message has been sent.';
            } else {
              echo 'There was a problem sending the email.';
            }
          */  
?>
