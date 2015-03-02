<?php

error_reporting(1);
//get all email list here

$dbConn_106 = mysql_connect("10.130.14.106", "billing", "billing");
if (!$dbConn_106) {
    echo '224- Could not connect';
    die('Could not connect: ' . mysql_error("could not connect to Local"));
}

$rule_id = $_REQUEST['rule_id'];
$rule_id = '2';

//$emailSmsEngagemntArray = array('jyoti.porwal@hungama.com','satay.tiwari@hungama.com','gagandeep.matnaja@hungama.com','shreya.tyagi@hungama.com',
//                                'ashish.talwar@hungama.com','anand.shukla@hungama.com','ankur.saxena@hungama.com','athar.haider@hungama.com');
$emailSmsEngagemntArray = array('jyoti.porwal@hungama.com');
$curdate = date("d-m-Y");
$NewDate = Date('d-m-Y', strtotime("-2 days"));
//$flag = 0;
//begin of HTML message 

$query = "select scenerios,service_id,circle from master_db.tbl_rule_engagement where id='" . $rule_id . "'";
$rule_result = mysql_query($query, $dbConn_106);
$ruleData = mysql_fetch_array($rule_result);
$type = $ruleData[0];
$service_id = $ruleData[1];
$sms_circle = $ruleData[2];
//$Numberquery = "select ANI from master_db.tbl_new_engagement_number where date(added_on)=date(now()) 
//    and Type='" . $type . "' and service_id='" . $service_id . " and circle='" . $sms_circle . "'";//
$Numberquery = "select ANI from master_db.tbl_new_engagement_number where date(added_on)='2013-11-27' 
    and Type='" . $type . "' and service_id='" . $service_id . "' and circle='" . $sms_circle . "'";
$result = mysql_query($Numberquery, $dbConn_106);

$message = '<html><body>';
$message .= '<table border="1" cellpadding="2" width="40%">';
$message .= "<tr bgcolor='#FFB6C1'><td colspan='2' align='center'>Filtered Base</tr>
             <tr bgcolor='#F5DEB3'><td style=width=50%>ANI</td></tr>";
while ($aniRecord = mysql_fetch_row($result)) {
    $message .="<tr bgcolor='#F5DEB3'><td style=width=50%>" . $aniRecord[0] . "</td></tr>";
}
$message .= "</table>";
$message .= "</body></html>";
echo $message;

//close database connection here
mysql_close($dbConn_106);

$from = 'jyoti.porwal@hungama.com';
$subject = 'SMS ENGAGEMENT REPORT-' . $curdate;
$headers = "From: " . $from . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$curdate = date("Y_m_d");

//$path_log = 'zipemail/logs/sms_engmnt/SMS_EBGMNT_REPORT_' . $curdate . '.txt';


foreach ($emailSmsEngagemntArray as $email) {

    $logdata = 'Email' . "#" . $email . '#Time' . "#" . date("H:i:s") . "\r\n";
    // error_log($logdata, 3, $path_log);

    mail($email, $subject, $message, $headers);
}

echo "done";
?>