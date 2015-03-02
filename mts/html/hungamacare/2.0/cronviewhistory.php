<?php
session_start();
//include("config/dbConnect.php");
require_once("language.php");
require_once("incs/db.php");
require_once("base.php");
//	$serviceId = $_GET['sid'];
$todaydate=date("Y-m-d");

$uploadfor = $_GET['type'];
//$uploadfor = 'sms';
$uploadvaluearray = array('active' => 'Activation', 'deactive' => 'Deactivation', 'topup' => 'Top-Up', 'renewal' => 'Renewal', 'sms' => 'SMS');
//$uploadedby='uni.bulk';
$serviceDescArray = array('1123' => 'MTS - Monsoon Dhamaka', '1423' => 'Uninor - Khelo India Jeeto India');
$uploadedby = $_SESSION[loginId];
//check for existing session$_SESSION['loginId_mts']
//echo "<pre>";print_r($_GET);die('here');
if (empty($_SESSION['loginId'])) {
    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
    exit;
} else {
    $uploadeby_mts = $_SESSION['loginId'];
}

$get_query = "select id,schedule_time,added_on,service_id,status,dnd_scrubing,date(lastmodify) as lastmodify from master_db.tbl_cron_schedule_contest order by id desc";
if($uploadfor == 'sms'){
    $get_query .= " limit 10";
}
$query = mysql_query($get_query, $dbConn);
$viewhistoryfor = ucfirst($uploadvaluearray[$uploadfor]);
$numofrows = mysql_num_rows($query);
if ($_REQUEST['id'] && $_REQUEST['act']) {
    $actionId = $_REQUEST['id'];
    $actionType = $_REQUEST['act'];
	$sid = $_REQUEST['sid'];
    if ($actionType == 'strt') {
       $startQuery = "UPDATE master_db.tbl_cron_schedule_contest SET status=1 ,lastmodify=now() WHERE id=" . $actionId;
        mysql_query($startQuery, $dbConn);
		$stpQuery = "UPDATE master_db.tbl_cron_schedule_contest SET status=0,lastmodify=now() WHERE service_id='".$sid."' and id!='".$actionId."'";
        mysql_query($stpQuery, $dbConn);
    } elseif ($actionType == 'stp') {
        echo $endQuery = "UPDATE master_db.tbl_cron_schedule_contest SET status=0,lastmodify=now() WHERE id=" . $actionId;
        mysql_query($endQuery, $dbConn);
    }
}
if ($numofrows == 0) {
    ?>
    <div width="85%" align="left" class="txt">
        <div class="alert alert-block">
            <?php // echo ALERT_NO_RECORD_FOUND; ?>
            <h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
        </div>
    </div>
    <?php
} else {
    ?>
    <center><div width="85%" align="left" class="txt">
            <div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewSMSUploadhistory('<?php echo $uploadfor; ?>')" id="Refresh"><i class="icon-refresh"></i></a>
                <?php
                //$limit = 10;
//echo ALERT_VIEW_UPLOAD_HISTORY;
                if($uploadfor == 'sms'){ $showallfile=0;
                echo "Cron schedule history for " . ucfirst($uploadvaluearray[$uploadfor]) . " Displaying last 10 records";
                }else{ $showallfile=1;
                    echo "Cron schedule history for " . ucfirst($uploadvaluearray[$uploadfor]) . " Displaying All records";
                }
                ?>
                </i>
            </div></div><center>
            <TABLE class="table table-condensed table-bordered">
                <thead>
                    <TR height="30">
                        <th align="left"><?php echo TH_BATCHID; ?></th>
                        <th align="left"><?php echo 'Schedule Time'; ?></th>
                        <th align="left"><?php echo 'Added_On'; ?></th>
                        <th align="left"><?php echo TH_SERVICENAME; ?></th>
                        <th align="left"><?php echo 'Message'; ?></th>
                        <th align="left"><?php echo 'DND Scrubbing'; ?></th>
                        <th align="left"><?php echo 'Status'; ?></th>
                        <th align="left"><?php echo 'Action'; ?></th>
                        <th align="left"><?php echo 'Output File'; ?></th>
                    </TR>
                </thead>
                <?php
                while (list($id, $schedule_time, $added_on, $service_id, $status,$dnd_scrubing,$lastmodify) = mysql_fetch_array($query)) {

                    $sname_ks = array_flip($serviceArray);
                    ?>
                    <TR height="30">

                        <TD>
                            <?php echo $id; ?>    
                        </TD>

                        <TD><?php echo $schedule_time; ?></TD>
                        <TD><?php
                    echo date('j-M \'y g:i a', strtotime($added_on));
                            ?></TD>
                        <TD><?php echo $serviceDescArray[$service_id]; ?></TD>
                        <TD><?php
                    $get_message_query = "select service_id,message from master_db.tbl_cron_schedule_footer_msg where service_id='".$service_id."'";
                    $query_execute = mysql_query($get_message_query, $dbConn);
                    $sms_details = mysql_fetch_array($query_execute);
                    echo $sms_details['message'];
                            ?></TD>
                        <td>
                            <?php
                            if ($dnd_scrubing == 0)
                                $fileStatus = '<span class="label">No</span>';
                            else if ($dnd_scrubing == 1)
                                $fileStatus = '<span class="label label-success">Yes</span>';

                            echo $fileStatus;
                            ?>
                        </td>
                        <td>
                            <?php
                            if (isset($status) && $status == 0)
                                $fileStatus = '<span class="label">DeActive</span>';
                            else if ($status == 1)
                                $fileStatus = '<span class="label label-success">Active</span>';

                            echo $fileStatus;
                            ?>
                        </td>
                        <td>
                            <?php
                            $currTime = date("H:i:s");
                            //if (strtotime($schedule_time) > strtotime($currTime)) {
                                if (isset($status) && $status == 0) {
                                    ?>
<!--                                    <a href="#" onclick="showStatusConfirm('<?php echo $id ?>','strt');">Start</a> -->
                                    <button class="btn btn-success" style="float:left;bgcolor:green"  id="<?php echo 'btn_action_kill_'.$id?>" onclick="javascript:showStatusConfirm('<?php echo $id ?>','strt','<?php echo $uploadfor ?>','<?php echo $service_id ?>');">Start</button>
                                <?php } else if ($status == 1) {
                                    ?>
<!--                                    <a href="#" onclick="showStatusConfirm('<?php echo $id ?>','stp');">Stop</a> -->
                                    <button class="btn btn-danger" style="float:left"  id="<?php echo 'btn_action_kill_'.$id?>" onclick="javascript:showStatusConfirm('<?php echo $id ?>','stp','<?php echo $uploadfor ?>','<?php echo $service_id ?>');">Stop</button>
                                <?
                                }
                           // } 
							//else {
                              //  echo "NA";
                            //}
                            ?>
                        </td>
                        <td>
						<?php
				$url="http://10.130.14.106/cotestlogs/".$service_id.'_'.$id.'_'.$todaydate.'.txt';
						?>
                         <a href="<?php echo $url;?>" target="_blank"><?php echo $service_id.'_'.$id.'_'.$todaydate.'.txt';?></a>
 <?php
 $added_on_date=explode(" ",$added_on);
 //$Allfileurl="http://119.82.69.212/kmis/services/hungamacare/2.0/cronviewhistory_All.php?sid=$service_id&bid=$id&Added_On=$added_on_date[0]&lastmodify=$lastmodify";  
  $Allfileurl="cronviewhistory_All.php?sid=$service_id&bid=$id&Added_On=$added_on_date[0]&lastmodify=$todaydate";  
if($showallfile)
{
 ?>
<a href="<?php echo $Allfileurl;?>" target="_blank">|All</a>
<?php
}
?>
					  </td>
                        <?php
                    }
                    echo "</TABLE>";
                }
                mysql_close($dbConn);
                ?>