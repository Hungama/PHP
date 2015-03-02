<?php
//msisdn,mode,planid,serviceid,rcode
error_reporting(0);
$msisdn = $_REQUEST['msisdn'];
$mode = $_REQUEST['mode'];
$reqtype = $_REQUEST['reqtype'];
$planid = $_REQUEST['planid'];
$subchannel = $_REQUEST['subchannel'];
$rcode = $_REQUEST['rcode'];
$seviceId = $_REQUEST['serviceid'];
$ac = $_REQUEST['ac'];
$param = $_REQUEST['param'];
$aftId = $_REQUEST['aftid'];
$b_id = 0;
$curdate = date("Y-m-d");

$log_file_path = "/var/www/html/reliance/logs/relianceMM/relianceMM_" . $curdate . ".txt";
$file = fopen($log_file_path, "a");
chmod($log_file_path, 0777);
fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid ."#" . $seviceId . "#" . date('H:i:s') . "\r\n");
fclose($file);

if (!isset($rcode)) {
    $rcode = "SUCCESS,FAILURE,FAILURE";
}
$abc = explode(',', $rcode);

if (!is_numeric("$planid")) {
    echo $rcode = $abc[1];
    $file = fopen($log_file_path, "a");
    chmod($log_file_path, 0777);
    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
    fclose($file);
    exit;
}

function checkmsisdn($msisdn, $abc, $seviceId) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            } else {
                echo $abc[1];
                $rcode = $abc[1];
                $file = fopen($log_file_path, "a");
                chmod($log_file_path, 0777);
                fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
                fclose($file);
                exit;
            }
        }
    } elseif (strlen($msisdn) != 10) {
        echo $abc[1];
        $rcode = $abc[1];
        $file = fopen($log_file_path, "a");
        chmod($log_file_path, 0777);
        fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
        fclose($file);
        exit;
    } elseif (!is_numeric($msisdn)) {
        echo $abc[1];
        $rcode = $abc[1];
        $file = fopen($log_file_path, "a");
        chmod($log_file_path, 0777);
        fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
        fclose($file);
        exit;
    }

    return $msisdn;
}

$msisdn = checkmsisdn(trim($msisdn), $abc, $seviceId);

if (($msisdn == "") || ($mode == "") || ($planid == "") || ($seviceId == "")) {
    echo "Please provide the complete parameter";
} else {
    $con = mysql_connect("192.168.100.224", "billing", "billing");
    if (!$con) {
        die('we are facing some temporarily problem please try later');
    }

    if (!$getAmount) {
        $amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'");
        List($getAmount) = mysql_fetch_row($amt);
    }
    
	$qry = "call reliance_music_mania.music_topupBulk('$msisdn','01','$mode','543219','$getAmount','$seviceId','$planid','$b_id')";
    if (mysql_query($qry)) {
        echo $rcode = $abc[0];
        $file = fopen($log_file_path, "a");
        chmod($log_file_path, 0777);
        fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $seviceId."#".$qry . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
        fclose($file);
    } else {
        echo $rcode = $abc[1];
        $file = fopen($log_file_path, "a");
        chmod($log_file_path, 0777);
        fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $seviceId."#".$qry . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
        fclose($file);
    }
}
?>   