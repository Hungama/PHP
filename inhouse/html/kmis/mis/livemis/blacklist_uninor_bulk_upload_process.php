<?php
session_start();
require_once("incs/db.php");
require_once("language.php");
print_r($_REQUEST);
exit;

if($_SERVER['REQUEST_METHOD']=="POST")
{

        $selMaxId = "select max(batch_id)+1 from master_db.bulk_upload_history_blacklist";
        $qryBatch = mysql_query($selMaxId, $dbConn);
        list($batchId) = mysql_fetch_array($qryBatch);
        if($batchId == '\n')
		{
		  $batchId=1;
		}








}

/*
  $action=$_REQUEST['action'];
  $service_info=$_REQUEST['service_info'];
  $channel=$_REQUEST['channel'];
  $price=$_REQUEST['price'];
  $upfor=$_REQUEST['upfor'];
  $usrId=$_REQUEST['usrId'];
  $file=$_FILES['upfile']['name'];
 */
/* * ****************************************Upload process start here********************************************** */
/*$loginid = $_SESSION['loginId'];
if (!isset($loginid)) {
    ?>
    <div width="85%" align="left" class="txt">
        <div class="alert alert-danger">
            <h4>Ooops!</h4>Hey,  Your session have been timeout. <a href="index.php" style="text-decoration:none">Click here</a> to login again.
        </div>
    </div>
    <?php
    exit;
}

        $selMaxId = "select max(batch_id)+1 from master_db.bulk_upload_history_blacklist";
        $qryBatch = mysql_query($selMaxId, $dbConn);
        list($batchId) = mysql_fetch_array($qryBatch);
        if($batchId == '\n')
		{
		  $batchId=1;
		}
		 ?>
		 <div class="alert alert-danger"><?php echo $batchId; ?></div>
		 <?php
		
		$remoteAdd = trim($_SERVER['REMOTE_ADDR']);
		$serviceId = trim($_REQUEST['service_info']);
		
	/*	
	 if (isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
    $orgfilename = $_FILES['upfile']['name'];
    //check for valid file content start here 
    $lines = file($_FILES['upfile']['tmp_name']);
    $isok;
    $count = 0;
    foreach ($lines as $line_num => $mobno) {
        $mno = trim($mobno);
        if (!empty($mno)) {
            if (is_numeric($mno) && strlen($mno) == 10) {
                $isok = 1;
                $count++;
            } else {
                $isok = 2;
                break;
            }
        }
    }
    if ($isok == 2) {
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">";
        ?>
        <div class="alert alert-danger"><?php echo FILEUPLOADEERROR; ?></div></div>
        <?php
        exit;
    } else if ($count > 20000) {
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Please upload file of less than 20,000 numbers otherwise it will not process.</div></div>";
        exit;
    }

    //check for valid file content end here
   // $subservice = $_POST['subservice'];
    $channel = $_POST['channel'];

   /* $planId = trim($_REQUEST['price']);
    $planData = explode("-", $planId);
    if (count($planData) == 2) {
        $planId = $planData[0];
        $getAmount = $planData[1];
    }


    if (!$planId)
        $planId = "";
*/
  /*  if ($subservice) {
        $channel = $channel . "-" . $subservice;
    }

    $file = $_FILES['upfile'];
    $allowedExtensions = array("txt");

    function isAllowedExtension($fileName) {
        global $allowedExtensions;
        return in_array(end(explode(".", $fileName)), $allowedExtensions);
    }

    if (isAllowedExtension($file['name']) && $_REQUEST['service_info'] && $_REQUEST['upfor']) {
        $serviceId = trim($_REQUEST['service_info']);
        $uploadedFor = trim($_REQUEST['upfor']);

        //$remoteAdd = trim($_SERVER['REMOTE_ADDR']);
        if (!$channelDec)
            $channelDec = 'NA';

       // $afltId = 0;

        /*if ($uploadedFor == 'doubleConsentUninor') {
            $flag = trim($_REQUEST['service_shcode']);
        }*/


        /*if ($uploadedFor == 'Blacklist') {
            $type1 = 'SUB';
            $selaftId = "select aftId from master_db.tbl_affiliate_detail where service_id='" . $serviceId . "' and status=1 and event_type='" . $type1 . "' and mode='Bulk'";
            $qryAflt = mysql_query($selaftId, $dbConn);
            while ($aftRow = mysql_fetch_array($qryAflt)) {
                $afltId = $aftRow['aftId'];
            }
        }*/
        //elseif($uploadedFor == 'deactive') $type1= 'UNSUB'; 
        //echo "AftId:".$afltId;

  /*      $selMaxId = "select max(batch_id)+1 from master_db.bulk_upload_history";
        $qryBatch = mysql_query($selMaxId, $dbConn);
        list($batchId) = mysql_fetch_array($qryBatch); 

        if (!$getAmount) {
            $selAmount = "select iAmount from master_db.tbl_plan_bank where plan_id=" . $planId;
            $qryAmount = mysql_query($selAmount, $dbConn);
            list($getAmount) = mysql_fetch_array($qryAmount); */
        }

    /*    if (strtolower($uploadedFor) == 'topup' && $serviceId == 1402)
            $getAmount = 10;

        $SafeFile = explode(".", $_FILES['upfile']['name']);

        $makFileName = str_replace(" ", "_", $SafeFile[0]) . "_" . $batchId . "_" . $serviceId . "_" . $channel . "_" . $channelDec . "_" . $uploadedFor . "." . $Now();

        $errorFileName = $batchId . ".txt";

        $dbMakFileName = str_replace(" ", "_", $SafeFile[0]) . "_" . $batchId . "_" . $serviceId . "_" . $channel . "_" . $channelDec . "_" . $uploadedFor;

        $makLckFileName = str_replace(" ", "_", $SafeFile[0]) . "_" . $batchId . "_" . $serviceId . "_" . $channel . "_" . $channelDec . "_" . $uploadedFor . ".lck";

        $uploaddir = "../bulkuploads/" . $serviceId . "/";
       /* if (!is_dir($uploaddir)) {
            mkdir($uploaddir);
            chmod($uploaddir, 0777);
        }

        $uploadlogdir = "../bulkuploads/" . $serviceId . "/log/";
        if (!is_dir($uploadlogdir)) {
            mkdir($uploadlogdir);
            chmod($uploadlogdir, 0777);
        }

        $errorlogdir = "../bulkuploads/" . $serviceId . "/error/";
        if (!is_dir($errorlogdir)) {
            mkdir($errorlogdir);
            chmod($errorlogdir, 0777);
        }

		
        $path = $uploaddir . $makFileName;
        $lckpath = $uploaddir . $makLckFileName;
        $errorpath = $errorlogdir . $errorFileName;

        if (move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
            $file_to_read = "http://192.168.100.212/kmis/services/hungamacare/bulkuploads/" . $serviceId . "/" . $makFileName;

            //if($_SESSION['usrId']==219 || $_SESSION['usrId']==221){
            if (0) {
                $selectTotalCount = "select sum(total_file_count) from master_db.bulk_upload_history_blacklist where added_by='" . $_SESSION['loginId'] . "' and date(added_on)=date(now())";
                $selectCounrResult = mysql_query($selectTotalCount, $dbConn);
                list($totalCount1) = mysql_fetch_row($selectCounrResult);
            }
            $file_data = file($file_to_read);
            $file_size = sizeof($file_data);
            $totalFileCount12 = $file_size + $totalCount1;

            //if(($_SESSION['usrId']==219 || $_SESSION['usrId']==221) && $totalFileCount12>1000) {
            if (0) {
                $msg = "File contain more than 1000 numbers/you have reached your today limit.<br/><br/>";
            } else {
                $msg = "File uploaded successfully.<br/><br/>";
              /*  $fp = fopen($path, "r") or die("Couldn't open $filename");
                $succCount = 0;
                $failCount = 0;
                $thisTime = date("Y-m-d H:i:s");

                $fileData1 = file($path);
                $sizeOfFile = count($fileData1);
                $filetowriteFp = fopen($path, 'w+');
                $errrFiletowrite = fopen($errorpath, 'w+');

                $fileCount = 0;

                if (substr($serviceId, 0, 2) == 10) {
                    $tableName = "tbl_mobisur_tatm_ani";
                } elseif (substr($serviceId, 0, 2) == 16) {
                    $tableName = "tbl_mobisur_tatc_ani";
                } elseif (substr($serviceId, 0, 2) == 12) {
                    $tableName = "tbl_mobisur_relc_ani";
                } elseif (substr($serviceId, 0, 2) == 14) {
                    $tableName = "tbl_mobisur_unim_ani";
                }

                if ($afltId)
                    $channel = $channel . "|" . $afltId;

                for ($k = 0; $k < $sizeOfFile; $k++) {
                    if ($channel == 'OBD-MS' || $channel == 'IVR-MS' || $channel == 'USSD-MS' || $channel == 'Net-MS') {
                        $number = $fileData1[$k];
                        $query = "SELECT count(*) FROM master_db." . $tableName . " WHERE msisdn='" . $number . "'";
                        $result = mysql_query($query, $dbConn);
                        list($numberChk) = mysql_fetch_row($result);
                        if (trim($fileData1[$k]) != '' && (strlen($fileData1[$k]) == 12 || strlen($fileData1[$k]) == 10) && $numberChk == 0) {
                            fwrite($filetowriteFp, trim($fileData1[$k]) . "#" . $batchId . "#" . $serviceId . "#" . $planId . "#" . $getAmount . "#" . $channel . "#" . $channelDec . "#" . $uploadedFor . "\r\n");
                            $fileCount++;
                        } else {
                            fwrite($errrFiletowrite, $fileData1[$k] . "#" . $batchId . "#" . $serviceId . "#" . $planId . "#" . $getAmount . "#" . $channel . "#" . $channelDec . "#" . $uploadedFor . "\r\n");
                        }
                    } else {
                        if (trim($fileData1[$k]) != '' && (strlen($fileData1[$k]) == 12 || strlen($fileData1[$k]) == 10)) {
                            fwrite($filetowriteFp, trim($fileData1[$k]) . "#" . $batchId . "#" . $serviceId . "#" . $planId . "#" . $getAmount . "#" . $channel . "#" . $channelDec . "#" . $uploadedFor . "\r\n");
                            $fileCount++;
                        } else {
                            fwrite($errrFiletowrite, $fileData1[$k] . "#" . $batchId . "#" . $serviceId . "#" . $planId . "#" . $getAmount . "#" . $channel . "#" . $channelDec . "#" . $uploadedFor . "\r\n");
                        }
                    }
                }
                fclose($filetowriteFp);
                fclose($errrFiletowrite);

                $lckFile = fopen($lckpath, 'w+');
                fclose($lckFile);
//$_SESSION[dbaccess]
                /*                 * ******************************************** start add scheduler code here @jyoti.porwal ************************************************************ 
                if ($_POST[upfor] == 'active') {
                    $add_scheduler = $_POST['add_scheduler'];
                    $scheduledOn = $_POST['dpd2'];
                } else if ($_POST[upfor] == 'topup') {
                    $add_scheduler = $_POST['add_scheduler_topup'];
                    $scheduledOn = $_POST['dpd2topup'];
                } else if ($_POST[upfor] == 'event') {
                    $add_scheduler = $_POST['add_scheduler_event'];
                    $scheduledOn = $_POST['dpd2event'];
                } else if ($_POST[upfor] == 'deactive') {
                    $add_scheduler = $_POST['add_scheduler_deactive'];
                    $scheduledOn = $_POST['dpd2deactive'];
                } else if ($_POST[upfor] == 'event_active') {
                    $add_scheduler = $_POST['add_scheduler_event_active'];
                    $scheduledOn = $_POST['dpd2EventActive'];
                } else if ($_POST[upfor] == 'doubleConsentUninor') {
                    $add_scheduler = $_POST['add_scheduler_doubleconUninor'];
                    $scheduledOn = $_POST['dpd2DoubleConscentUninor'];
                }
                if ($add_scheduler == 1) {
                     $status = 11;
                } else {
                    $scheduledOn = '';
                    $status = 0;
                }
                /*                 * ******************************************** end add scheduler code here @jyoti.porwal ************************************************************  

                $Uploadquery = "insert into master_db.bulk_upload_history_blacklist(batch_id, channel, file_name, added_by, added_on, upload_for,status,operator,total_file_count,service_id,ip)
                                                                 values('$batchId','$channel','$dbMakFileName','$loginid','$thisTime', '$_POST[upfor]','$status','uninor_hungama','$fileCount','$serviceId','$remoteAdd')";
                //echo $Uploadquery;
                $queryIns = mysql_query($Uploadquery, $dbConn);

                $msg = "$orgfilename has been successfully uploaded. Generated Reference ID is $batchId";
                echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
            }
        } else {
            // echo $msg = "File cannot be uploaded successfully.";
            echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">There seem to be error in the contents of the file. Please check the file you selected for upload.</div></div>";
       }
    } else {
        //	echo $msg = "Invalid file type/Parameter. Please try again!!.";
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">There seem to be error in the contents of the file. Please check the file you selected for upload.</div></div>";
    }
	
	*/

?>