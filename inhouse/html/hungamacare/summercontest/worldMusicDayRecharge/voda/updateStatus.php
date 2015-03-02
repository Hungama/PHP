<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(1);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");
$reportDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai',
    'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir',
    'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other');

////////////////////////////////////////top 20 of each circle end here /////////////////////////

$get_allwinner = "select ANI,total_question_play,score,circle,level,date_time,SOU,lastChargeAmount,pulses,recharge_retry
from vodafone_radio.tbl_wmdcontest_misdaily_recharged nolock where date_time='" . $reportDate . "' and status=1 and score>=1";
$data = mysql_query($get_allwinner, $dbConnVoda) or die(mysql_error());
$numrows = mysql_num_rows($data);
$isrtry = 0;
if ($numrows == 0) {
    echo "NO Data to process";
} else {
    while ($result_data = mysql_fetch_array($data)) {
        $ani = $result_data['ANI'];
        $circle_org = $result_data['circle'];
        $recharge_retry = $result_data['recharge_retry'];
        $getStatus = mysql_query("select transactionId,response from master_db.tbl_recharged nolock where date(request_time)='" . $rechargeDate . "' and msisdn='" . $ani . "' and status=1 order by id desc limit 1", $dbConn212);
        $rechageStatus = mysql_fetch_array($getStatus);
        $TID = $rechageStatus['transactionId'];
        $response = explode('#', $rechageStatus['response']);
        if ($response[0] == 'FAILURE' && $recharge_retry == 1) {
            //if(($response[0]=='' || $response[0]=='FAILURE') && $recharge_retry==1)
            //retry
            $isrtry = 1;
            $Update_status = "update vodafone_radio.tbl_wmdcontest_misdaily_recharged set Recharge_TID='$TID',Recharge_Status='" . $response[0] . "',recharge_retry=2 where date_time='" . $reportDate . "' and ANI='" . $ani . "'";
            $result2 = mysql_query($Update_status, $dbConnVoda);
            //retry for the current mdn
            //$circle = "Rajasthan";
            $circle = 'Bihar';

            $enc_circle = urlencode($circle);
            $url = "http://119.82.69.218//MIS/API/API.Recharge.php?CampaignID=500059&AuthCode=888705&Circle=" . $enc_circle . "&MSISDN=" . $ani;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $fileResponse = curl_exec($ch);
            curl_close($ch);
        } else {
            $Update_status = "update vodafone_radio.tbl_wmdcontest_misdaily_recharged set Recharge_TID='$TID',Recharge_Status='" . $response[0] . "' where date_time='" . $reportDate . "' and ANI='" . $ani . "'";
            $result2 = mysql_query($Update_status, $dbConnVoda);
        }
    }
}

if ($isrtry) {
    echo "We are retrying some transaction...";
}
//send email file include here
mysql_close($dbConn212);
?>