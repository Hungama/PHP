<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai',
    'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir',
    'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other');
$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

$query = "select id,ANI,level,circle from vodafone_radio.tbl_wmdcontest_misdaily_recharged
			where date(date_time)='" . $date . "' and status=0";
$result = mysql_query($query, $dbConnVoda);
$result_row = mysql_num_rows($result);

if ($result_row > 0) {

    while ($smsRecord = mysql_fetch_array($result)) {
        $circle_org = $smsRecord['circle'];
        $circle = $circle_info[$circle_org];
        $circle = 'Bihar';
        $enc_circle = urlencode($circle);
        $fileResponse = '';
        $msisdn = $smsRecord['ANI'];
        $level = $smsRecord['level'];
        $id = $smsRecord['id'];
        switch ($level) {
            case '1':
                $url = "http://119.82.69.218//MIS/API/API.Recharge.php?CampaignID=500059&AuthCode=888705&Circle=" . $enc_circle . "&MSISDN=" . $msisdn;
                break;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $fileResponse = curl_exec($ch);
        curl_close($ch);


        $logFile = "logs/VodarechargeContest_" . date('Ymd') . ".txt";
        $logData = $msisdn . "#" . $level . "#" . $url . "#" . $fileResponse . "#" . date("Y-m-d H:i:s") . "\n";
        if ($fileResponse == 'Success') {
            $Update_status = "update vodafone_radio.tbl_wmdcontest_misdaily_recharged set status=1 where id='" . $id . "' and ANI='" . $msisdn . "'";
            $result2 = mysql_query($Update_status, $dbConnVoda);
        } else {
            $Update_status = "update vodafone_radio.tbl_wmdcontest_misdaily_recharged set status=10 where id='" . $id . "' and ANI='" . $msisdn . "'";
            $result2 = mysql_query($Update_status, $dbConnVoda);
        }
        error_log($logData, 3, $logFile);
    }

    echo "Done";
} else {
    echo "Recharge not applicable";
}
?> 