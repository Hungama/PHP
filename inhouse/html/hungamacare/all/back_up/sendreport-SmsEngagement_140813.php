<?php

error_reporting(1);
//get all email list here

$dbConn_224 = mysql_connect("192.168.100.224", "webcc", "webcc");
if (!$dbConn_224) {
    echo '224- Could not connect';
    die('Could not connect: ' . mysql_error("could not connect to Local"));
}
$emailSmsEngagemntArray = array();

//Voda
//$get_email_voda="select email from master_db.live_user_master where access_service like '%Voda%' and ac_flag=1 and access_sec like '%revenue%' and alert_billing=1";
//$email_list_voda = mysql_query($get_email_voda,$dbConn_224) or die(mysql_error());
//while($row_email = mysql_fetch_array($email_list_voda))
//{
//if($row_email['email']!='anuj.bajpai@hungama.com' and $row_email['email']!='albert.almeida@hungama.com')
//{
////$emailVodaArray[$i]= $row_email['email'];
//$emailVodaArray[]= $row_email['email'];
//}
//}

$emailSmsEngagemntArray[1] = 'jyoti.porwal@hungama.com';
$emailSmsEngagemntArray[2] = 'satya.tiwari@hungama.com';

//mysql_close($dbConn_224);


$curdate = date("d-m-Y");
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
//begin of HTML message 
$get_2dayData = "select count(*) from master_db.tbl_sms_engagement_log where date(added_on)=DATE(NOW()-INTERVAL 2 DAY) and type='2 Days' and status=1";
$data_2day = mysql_query($get_2dayData, $dbConn_224) or die(mysql_error());
$count_2day = mysql_fetch_row($data_2day);
$get_4dayData = "select count(*) from master_db.tbl_sms_engagement_log where date(added_on)=DATE(NOW()-INTERVAL 2 DAY) and type='4 Days' and status=1";
$data_4day = mysql_query($get_4dayData, $dbConn_224) or die(mysql_error());
$count_4day = mysql_fetch_row($data_4day);
$get_8dayData = "select count(*) from master_db.tbl_sms_engagement_log where date(added_on)=DATE(NOW()-INTERVAL 2 DAY) and type='8 Days' and status=1";
$data_8day = mysql_query($get_8dayData, $dbConn_224) or die(mysql_error());
$count_8day = mysql_fetch_row($data_8day);
$get_11dayData = "select count(*) from master_db.tbl_sms_engagement_log where date(added_on)=DATE(NOW()-INTERVAL 2 DAY) and type='11 Days' and status=1";
$data_11day = mysql_query($get_11dayData, $dbConn_224) or die(mysql_error());
$count_11day = mysql_fetch_row($data_11day);
$get_16dayData = "select count(*) from master_db.tbl_sms_engagement_log where date(added_on)=DATE(NOW()-INTERVAL 2 DAY) and type='16 Days' and status=1";
$data_16day = mysql_query($get_16dayData, $dbConn_224) or die(mysql_error());
$count_16day = mysql_fetch_row($data_16day);
$get_19dayData = "select count(*) from master_db.tbl_sms_engagement_log where date(added_on)=DATE(NOW()-INTERVAL 2 DAY) and type='19 Days' and status=1";
$data_19day = mysql_query($get_19dayData, $dbConn_224) or die(mysql_error());
$count_19day = mysql_fetch_row($data_19day);
$get_25dayData = "select count(*) from master_db.tbl_sms_engagement_log where date(added_on)=DATE(NOW()-INTERVAL 2 DAY) and type='25 Days' and status=1";
$data_25day = mysql_query($get_25dayData, $dbConn_224) or die(mysql_error());
$count_25day = mysql_fetch_row($data_25day);
$get_27dayData = "select count(*) from master_db.tbl_sms_engagement_log where date(added_on)=DATE(NOW()-INTERVAL 2 DAY) and type='27 Days' and status=1";
$data_27day = mysql_query($get_27dayData, $dbConn_224) or die(mysql_error());
$count_27day = mysql_fetch_row($data_27day);
$get_29dayData = "select count(*) from master_db.tbl_sms_engagement_log where date(added_on)=DATE(NOW()-INTERVAL 2 DAY) and type='29 Days' and status=1";
$data_29day = mysql_query($get_29dayData, $dbConn_224) or die(mysql_error());
$count_29day = mysql_fetch_row($data_29day);
$total_count = $count_2day[0] + $count_4day[0] + $count_8day[0] + $count_11day[0] + $count_16day[0] + $count_19day[0] + $count_25day[0] + $count_27day[0] + $count_29day[0];
$get_callbackData = "select count(*) from master_db.tbl_sms_engagement_log_recharge where date(added_on)=date(now())";
$data_callback = mysql_query($get_callbackData, $dbConn_224) or die(mysql_error());
$count_callback = mysql_fetch_row($data_callback);
$get_eligibleData = "select count(*) from master_db.tbl_sms_engagement_log_recharge where date(added_on)=date(now()) and mous >= 600";
$data_eligible = mysql_query($get_eligibleData, $dbConn_224) or die(mysql_error());
$count_eligible = mysql_fetch_row($data_eligible);
$get_rechargeData = "select count(*) from master_db.tbl_sms_engagement_log_recharge where date(added_on)=date(now()) and status=1";
$data_recharge = mysql_query($get_rechargeData, $dbConn_224) or die(mysql_error());
$count_recharge = mysql_fetch_row($data_recharge);
$message = '<html><body>';
$message .= '<table border="1" cellpadding="2" width="80%">';
$message .= "<tr bgcolor='#FFB6C1'><td colspan='2' align='center'>CLM Dimensions</tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Bucketing (Days)</td><td style=width=30%>" . $curdate . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Day2</td><td style=width=30%>" . $count_2day[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Day4</td><td style=width=30%>" . $count_4day[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Day8</td><td style=width=30%>" . $count_8day[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Day11</td><td style=width=30%>" . $count_11day[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Day16</td><td style=width=30%>" . $count_16day[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Day19</td><td style=width=30%>" . $count_19day[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Day25</td><td style=width=30%>" . $count_25day[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Day27</td><td style=width=30%>" . $count_27day[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Day29</td><td style=width=30%>" . $count_29day[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Messages Targeted</td><td style=width=30%>" . $total_count . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Called Back</td><td style=width=30%>" . $count_callback[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Eligible</td><td style=width=30%>" . $count_eligible[0] . "</td></tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>Recharge Done</td><td style=width=30%>" . $count_recharge[0] . "</td></tr>";

$message .= "</table>";
$message .= "</body></html>";
echo $message;

//mysql_close($con);
//close database connection here
$to = 'jyoti.porwal@hungama.com';
//$bcc = 'athar.haider@hungama.com';
//$cc = 'vinod.chauhan@hungama.com';
$cc = 'satya.tiwari@hungama.com';
$from = 'jyoti.porwal@hungama.com';
$subject = 'SMS ENGAGEMENT REPORT';
$headers = "From: " . $from . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$curdate = date("Y_m_d");
//$path_log='zipemail/logs/sms_engmnt/SMS_EBGMNT_REPORT_'.$curdate.'.txt';
//$logdata='Operator'."#".$operator.'#Time'."#".date("H:i:s")."\r\n";

foreach ($emailSmsEngagemntArray as $email) {
    mail($email, $subject, $message, $headers);
}
//  mail($to, $subject, $message, $headers);	
//mail($cc, $subject, $message, $headers);
mail($cc, $subject, $message, $headers);
//mail($bcc, $subject, $message, $headers);
//mail($cc_sd, $subject, $message, $headers);
//
//    $logdata = "*************Email Send Error For Tata Service*************" . "#" . date("H:i:s") . "\r\n";
//    ;
//    error_log($logdata, 3, $path_log);
//
//error_log($logdata, 3, $path_log);
//return $message;	 


echo 'done';
?>