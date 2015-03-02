<?php
session_start();
error_reporting(1);
require_once("incs/db.php");
require_once("language.php");
$serviceArray = array('Vodafone - Radio Unlimited' => '1301');
$remoteAdd = $_SERVER['REMOTE_ADDR'];
$serviceArray = array_flip($serviceArray);
$switchArray = array('circle' => 'C', 'file' => 'F');
//$circleArray = array('APD' => 'Andhra Pradesh', 'BIH' => 'Bihar', 'GUJ' => 'Gujarat', 'MAH' => 'Maharashtra', 'UPE' => 'UP EAST', 'UPW' => 'UP WEST');
$circleArray = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh','All' => 'All');

if (empty($_SESSION['loginId'])) {
    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
    exit;
} else {
    $uploadeby = $_SESSION['loginId'];
}

$startdatetime = $_POST['timestamp'];
$enddatetime = $_POST['timestamp1'];
$mode = $_POST['via_type'];
$switchType=$_POST['switch_info'];
$uploadeby=$_POST['usrId'];
$serviceid=$_POST['service_info'];
$old_startdatetime_timestamp = strtotime($startdatetime);
$new_startdatetime = date('Y-m-d H:i:s', $old_startdatetime_timestamp);
$old_enddatetime_timestamp = strtotime($enddatetime);
$new_enddatetime = date('Y-m-d H:i:s', $old_enddatetime_timestamp);
$circle=$_POST['circle_info'];
//check for existing switch for the same time for same service
if(!empty($circle))
{
	if($circle=='All')
	$cond="";
	else
	$cond="and circle='".$circle."'";
}
else
{
$cond="";
}
$getSwitch = "select swid from Vodafone_IVR.tbl_vodm_switch_config where serviceid='".$serviceid."' and status=1 $cond
and ((startdatetime between '".$new_startdatetime."' and '".$new_enddatetime."') 
or enddatetime between '".$new_startdatetime."' and '".$new_enddatetime."') ";


$result = mysql_query($getSwitch, $dbConn);
$getSwitchId= mysql_num_rows($result);
if($getSwitchId>=1)
{?>
<div width="85%" align="left" class="txt">
<div class="alert alert-danger">Switch already on the given time slot for this service.</div>
</div>
<?php
exit;
}
	

if ($circle == 'All') {
    foreach ($circleArray as $key => $value) {
        $insert_query = "insert into Vodafone_IVR.tbl_vodm_switch_config(serviceid,servicename,startdatetime,enddatetime,addondatetime,editby,editon,ipaddr,STATUS,mode,switchtype,circle,filename,lastmodify)
                     Values('" . $serviceid. "','" .  $serviceArray[$_POST['service_info']] . "','" . $new_startdatetime . "','" . $new_enddatetime . "',
                            now(),'" . $uploadeby . "',now(),'" . $remoteAdd . "',1,'" . $switchArray[$mode] . "','" . $switchType . "','" . $key . "',
                            '" . $_FILES['upfile']['name'] . "',now())";
        $qryMsg = mysql_query($insert_query, $dbConn);
    }
} else {
    $insert_query = "insert into Vodafone_IVR.tbl_vodm_switch_config(serviceid,servicename,startdatetime,enddatetime,addondatetime,editby,editon,ipaddr,STATUS,mode,switchtype,circle,filename,lastmodify)
                     Values('" .$serviceid. "','" . $serviceArray[$_POST['service_info']] . "','" . $new_startdatetime . "','" . $new_enddatetime . "',
                            now(),'" . $uploadeby . "',now(),'" . $remoteAdd . "',1,'" . $switchArray[$mode]. "','" . $switchType . "','" . $circle . "',
                            '" . $_FILES['upfile']['name'] . "',now())";
    $qryMsg = mysql_query($insert_query, $dbConn);
}
if ($mode == 'circle') {
    if ($qryMsg == 1) {
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-success\">Configuration has been saved successfully.</div></div>";
    } else {
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-danger\">Configuration could not save. Please try again.</div></div>";
    }
    exit();
}

if (isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
    $bulklimit = $_POST['bulklimit'];
    $orgfilename = $_FILES['upfile']['name'];
    //check for valid file content start here 
    $lines = file($_FILES['upfile']['tmp_name']);
    $isok;
    $count = 0;
    $status = 0;
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
    } else if ($count > 50000) {
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Please upload file of less than 50,000 numbers otherwise it will not process.</div></div>";
        exit;
    }
    $file = $_FILES['upfile'];
    $SafeFile = explode(".", $_FILES['upfile']['name']);

    $makFileName = str_replace(" ", "_", $SafeFile[0]) . "_".date('His')."_".$serviceid."." . $SafeFile[1];

    $uploaddir = "vodaTIVRswitch/" . $serviceid . "/";
    if (!is_dir($uploaddir)) {
        mkdir($uploaddir);
        chmod($uploaddir, 0777);
    }

   $path = $uploaddir . $makFileName;

    if (move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
        $file_to_read = "vodaTIVRswitch/" . $serviceid . "/" . $makFileName;
        $file_data = file($path);
        $file_size = count($file_data);
        if ($file_size <= 50000) {
            $selMsgId = "select max(swid) from Vodafone_IVR.tbl_vodm_switch_config";
            $qryMsg = mysql_query($selMsgId, $dbConn);
            list($swid) = mysql_fetch_array($qryMsg);
			
		$updateQuery = "UPDATE Vodafone_IVR.tbl_vodm_switch_config SET filename='".$makFileName."' WHERE swid=".$swid;
        mysql_query($updateQuery, $dbConn);
		
            $isupload = true;
            $fileData1 = file($path);
            $sizeOfFile = count($fileData1);
            $filetowriteFp = fopen($path, 'w+');

            for ($i = 0; $i < $sizeOfFile; $i++) {
                fwrite($filetowriteFp, trim($fileData1[$i]) . "#" . $swid . "\r\n");
            }

            $insertDump = 'LOAD DATA LOCAL INFILE "' . $path . '" 
						INTO TABLE Inhouse_IVR.tbl_unim_switch_base 
						FIELDS TERMINATED BY "#" 
						LINES TERMINATED BY "\n" 
						(ani,swid)';

            /*if (mysql_query($insertDump, $dbConn)) {
                $isupload = true;
            } else {
                $isupload = false;
            }*/
			$isupload = true;
            if ($isupload == true) {
                echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-danger\">File <b>$makFileName<b> uploaded successfully.<br/></div></div>";
            } else {
                echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-danger\">File cannot be uploaded successfully.</div></div>";
            }
        } else {
            echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-danger\">File contain more than 50,000 MDNs, Please try again!!</div></div>";
        }
    } else {
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-danger\">There seem to be error in the contents of the file. Please check the file you selected for upload.</div></div>";
    }
}
exit;
?>