<? 
//include ("db.php");
$prevdate = date("Ymd", time() - 60 * 60 * 24);
echo date("Y-m-d");
exit;
$getdatasql_108=mysql_query("select count(*) from misdata.tbl_browsing_wap where hitip='125.21.241.108' and date(datetime)='$prevdate'");
$result_108=mysql_fetch_array($getdatasql_108);
	$getdatasql_194=mysql_query("select count(*) from misdata.tbl_browsing_wap where hitip='202.87.41.194' and date(datetime)='$prevdate'");
	$result_194=mysql_fetch_array($getdatasql_194);
	$getdatasql_147=mysql_query("select count(*) from misdata.tbl_browsing_wap where hitip='202.87.41.147' and date(datetime)='$prevdate'");
	$result_147=mysql_fetch_array($getdatasql_147);
	
echo $result_108[0]."##".$result_194[0]."##".$result_147[0];
	//close database connection
mysql_close($con);
/*
$totalcount_108=4;
$totalcount_194=12;
$totalcount_147=2343;

    // PREPARE THE BODY OF THE MESSAGE
	$message = '<html><body>';
		    $message .= '<table rules="all" style="border-color: #666;" border="1" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td><strong>IP:</strong> </td><td><strong>Total Count In Link</strong> </td><td><strong>Total Count In Database</strong> </td></tr>";
			$message .= "<tr style='background: #ADD8E6;'><td><strong>125.21.241.108</strong> </td><td>" . strip_tags($totalcount_108) ."</td><td>".strip_tags($totalcount_108) ."</td></tr>";
			$message .= "<tr style='background: #ADD8E6;'><td><strong>202.87.41.194</strong> </td><td>" . strip_tags($totalcount_194) ."</td><td>".strip_tags($totalcount_194) ."</td></tr>";
			$message .= "<tr style='background: #ADD8E6;'><td><strong>202.87.41.147</strong> </td><td>" . strip_tags($totalcount_147) ."</td><td>".strip_tags($totalcount_147) ."</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
				$to = 'satay.tiwari@hungama.com';
				$from = 'satay.tiwari@hungama.com';
			
			$subject = 'Daily Waplog Report';
			
			$headers = "From: " . $from . "\r\n";
		//	$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            if (mail($to, $subject, $message, $headers)) {
              echo 'Your message has been sent.';
            } else {
              echo 'There was a problem sending the email.';
            }
            
            // DON'T BOTHER CONTINUING TO THE HTML...
			*/
?>