<?php
session_start();
error_reporting(1);
require_once("incs/db.php");
require_once("language.php");
//check for existing session$_SESSION['loginId_mts']
if (empty($_SESSION['loginId_mts'])) {
    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
    exit;
} else {
    $uploadeby_mts = $_SESSION['loginId_mts'];
}
/* * ************************added for try and buy section start here*************************** */
if ($_POST['upfor'] == 'tryandbuy') {
// added for tryandbuy interface option
    $serviceId = $_REQUEST['service_info'];
    $tnb_days = $_POST['tnb_days'];
    $tnb_mins = $_POST['tnb_mins'];
    $tnb_prerenewsms = $_POST['tnb_prerenewsms'];
    $auto_type = $_POST['auto_type'];
    $channel = $_POST['channel'];
    $circle_info = $_POST['circle_info'];
    $uploadeby_mts = $_SESSION['loginId_mts'];
    $planId = trim($_REQUEST['price']);

    $queryConfig = "select id from MTS_IVR.tbl_new_tnb_whitelisted_config where service_id='" . $serviceId . "' and circle='" . $circle_info . "' and submode='" . $channel . "' and status=1";
    $getConfig = mysql_query($queryConfig, $dbConn);
    $noc = mysql_num_rows($getConfig);
    if ($noc == 0) {
        $Uploadquery = "insert into MTS_IVR.tbl_new_tnb_whitelisted_config(auto_rew_deact, service_id,tnb_days,tnb_mins,pre_sms,submode,circle,reqs_time,added_by,status,plan_id) values('" . $auto_type . "','" . $serviceId . "', '" . $tnb_days . "', '" . $tnb_mins . "', '" . $tnb_prerenewsms . "', '" . $channel . "', '" . $circle_info . "', now(),'" . $uploadeby_mts . "',1,'" . $planId . "')";
        $queryIns = mysql_query($Uploadquery, $dbConn);
        $msg = "Configuration has been saved successfully.";
    } else {
        $msg = "Configuration already exist for this senerio. Please try another configuration.";
    }
    echo "<div width=\"85%\" align=\"left\" class=\"txt\"><div class=\"alert alert-success\">$msg</div></div>";
    exit;
}

/* * ************************added for try and buy section end here*************************** */
if (isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
//$bulklimit=$_POST['bulklimit'];
    $bulklimit = 19000;
    $orgfilename = $_FILES['upfile']['name'];
    //check for valid file content start here 
    $lines = file($_FILES['upfile']['tmp_name']);
    $isok;
    $count = 0;
    foreach ($lines as $line_num => $mobno) {
        $mno = trim($mobno);
        if (!empty($mno)) {
			if($_POST['upfor']=='act_tnb')
			{
			$count++;
			}
		else
		{
            if (is_numeric($mno) && strlen($mno) == 10) {
                $isok = 1;
                $count++;
            } else {
                $isok = 2;
                break;
            }
        }
		}
    }
    if ($isok == 2) {
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">";
        ?>
        <div class="alert alert-danger"><?php echo FILEUPLOADEERROR; ?></div></div>
        <?php
        exit;
    }
//else if($count>20000)
    else if ($count > $bulklimit) {
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Please upload file of less than " . number_format($bulklimit) . " numbers otherwise it will not process.</div></div>";
        exit;
    }

    //check for valid file content end here
    $newamount = "";
    $channel = $_POST['channel'];
    $upfor = $_POST['upfor'];
    $add_scheduler = $_POST['add_scheduler'];
    if ($upfor == 'event_unsub' && $add_scheduler == 1) {
        $scheduledOn = $_POST['dpd2'];
        $status = 11;
    } else {
        $scheduledOn = '';
        $status = 0;
    }
    $act_date = '';
    $renew_date = '';

    if ($_POST['upfor'] == 'active') {
        if ($_REQUEST['service_info'] == '1116') {
            $lang_id = $_POST['lang'];
        } else {
            $lang_id = $_POST['lang_active'];
        }
    } else if ($_POST['upfor'] == 'deactive') {
        $lang_id = $_POST['lang_deactive'];
    } else if ($_POST['upfor'] == 'renewal') {
        if ($_REQUEST['service_info'] == '1116') {
            $lang_id = $_POST['lang'];
        } else {
            $lang_id = $_POST['lang_renewal'];
        }
        $data_schedule = explode('-', trim($_REQUEST['schedule_date']));
        $act_date1 = explode('/', $data_schedule[0]);
        $renew_date1 = explode('/', $data_schedule[1]);
        $ctime = date('H:i:s');
        $act_date = trim($act_date1[2]) . '-' . trim($act_date1[0]) . '-' . trim($act_date1[1]) . ' ' . $ctime;
        $renew_date = trim($renew_date1[2]) . '-' . trim($renew_date1[0]) . '-' . trim($renew_date1[1]) . ' ' . $ctime;
    } else {
        $lang_id = "01";
    }

    $planId = trim($_REQUEST['price']);
    $planData = explode("-", $planId);
    if (count($planData) == 2) {
        $planId = $planData[0];
        $getAmount = $planData[1];
    }

    if (!$planId)
        $planId = "";


    $subtype = "";

    if ($_REQUEST['service_info'] == '11011')
        $serviceId = '1101';
    else
        $serviceId = $_REQUEST['service_info'];

    if ($serviceId == 1116) {
        $cat1 = $_POST['cat1'];
        if ($cat1)
            $subtype = $cat1;
        else
            $subtype = "N";

        $cat2 = $_POST['cat2'];
        if ($cat2)
            $subtype .="-" . $cat2;
        else
            $subtype .="-N";

        //$lang=$_POST['lang'];
        $lang = $lang_id;
        if ($lang)
            $subtype .="-" . $lang;
        else
            $subtype .="-N";

        //if($_POST['lang']) $lang=$_POST['lang'];
        if ($lang_id)
            $lang = $lang_id;
        else
            $lang = "01";
    } else {
        //if($_POST['lang']) $lang=$_POST['lang'];
        if ($lang_id)
            $lang = $lang_id;
        else
            $lang = "01";
    }

    if ($_POST['upfor'] == 'tryandbuy') {
// added for tryandbuy interface option
        $act_date = $_POST['tnb_days'];
        $renew_date = $_POST['tnb_mins'];
        $tnb_prerenewsms = $_POST['tnb_prerenewsms'];
        $subtype = $_POST['auto_type'];
    }

    $file = $_FILES['upfile'];
    $qryBatch = mysql_query("select max(batch_id) from billing_intermediate_db.bulk_upload_history", $dbConn);
    list($batchId) = mysql_fetch_array($qryBatch);
    if ($batchId)
        $batchId = $batchId + 1;
    else
        $batchId = 1;

    if (!$getAmount) {
        $selAmount = "select iAmount from master_db.tbl_plan_bank where plan_id=" . $planId;
        $qryAmount = mysql_query($selAmount, $dbConn);
        list($getAmount) = mysql_fetch_array($qryAmount);
    }
    $SafeFile = explode(".", $_FILES['upfile']['name']);
    $makFileName = str_replace(" ", "_", $SafeFile[0]) . "_" . $batchId . "_" . date("YmdHis") . "." . $SafeFile[1];

    $uploaddir = "/var/www/html/hungamacare/bulkuploads/" . $serviceId . "/";
    $path = $uploaddir . $makFileName;

    if (move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
        $succCount = 0;
        $failCount = 0;
        $file_size = $count;
        $thisTime = date("Y-m-d H:i:s");
        $dbaccess = 'mts';
        $Uploadquery = "insert into billing_intermediate_db.bulk_upload_history(batch_id,service_type,channel,price_point,file_name,added_by,added_on,upload_for,status,operator,total_file_count,service_id,amount,language,act_date,renew_date,smsFlag,scheduledOn) 
                                                                         values('" . $batchId . "','" . $subtype . "', '" . $channel . "', '" . $planId . "', '" . $makFileName . "', '" . $uploadeby_mts . "', '" . $thisTime . "', '" . $upfor . "',$status,'" . $dbaccess . "','" . $file_size . "','" . $serviceId . "','" . $getAmount . "','" . $lang . "','" . $act_date . "','" . $renew_date . "','" . $tnb_prerenewsms . "','" . $scheduledOn . "')";
        $queryIns = mysql_query($Uploadquery, $dbConn);
        $msg = $orgfilename . " has been successfully uploaded. Generated Reference ID is " . $batchId;
        echo "<div width=\"85%\" align=\"left\" class=\"txt\"><div class=\"alert alert-success\">$msg</div></div>";
    } else {

        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-danger\">There seem to be error in the contents of the file. Please check the file you selected for upload1.</div></div>";
    }
}

exit;
?>