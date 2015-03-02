<?php
include("../config/dbConnect.php");
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAR' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other', 'HAY' => 'Haryana');
if ($_REQUEST['service']) {
    $serviceId = $_REQUEST['service'];
    $circle = $_REQUEST['circle'];
    if ($serviceId == 1507)
            $serviceName = 'VH1';
        elseif ($serviceId == 1503)
            $serviceName = 'MTV';
        
    if ($_REQUEST['id'] && $_REQUEST['act']) {
        $actionId = $_REQUEST['id'];
        $actionType = $_REQUEST['act'];
        if ($actionType == 'strt') {
            $startQuery = "UPDATE airtel_radio.tbl_cross_sell SET status=1 WHERE id=" . $actionId;
            mysql_query($startQuery);
        } elseif ($actionType == 'end') {
            $endQuery = "UPDATE airtel_radio.tbl_cross_sell SET status=0 WHERE id=" . $actionId;
            mysql_query($endQuery);
        } elseif ($actionType == 'del') {
		//$delQuery = "DELETE FROM master_db.tbl_doubleconsent_time WHERE id=" . $actionId;
		$delQuery = "UPDATE airtel_radio.tbl_cross_sell SET status=5 WHERE id=" . $actionId;
            mysql_query($delQuery);
        }
    }

   $query = "select id,service,circle,start_time,end_time,status from airtel_radio.tbl_cross_sell where service='" . $serviceName . "' and status !=5 ";
    if ($_REQUEST['circle']) {
        $circle = $_REQUEST['circle'];
        $query .= " and circle='" . $circle . "'";
    } else
        $circle = '';
		
    $result = mysql_query($query);
    $count = mysql_num_rows($result);
    if ($count) {
        $i = 1;
        ?>
        <div width="85%" align="left" class="txt">
            <div class="alert alert" >
                <?php echo "Time-Slots "; ?>
                </i>
            </div></div>
        <table class="table table-condensed table-bordered">	
            <tr>
                <td bgcolor="#FFFFFF" height="30px" align="center"><b>S.No.</b></td>
                <td bgcolor="#FFFFFF" height="30px" align="center"><b>Service Name</b></td>
                <td bgcolor="#FFFFFF" height="30px" align="center"><b>Circle</b></td>
                <td bgcolor="#FFFFFF" height="30px" align="center"><b>Start Time</b></td>
                <td bgcolor="#FFFFFF" height="30px" align="center"><b>End Time</b></td>
                <td bgcolor="#FFFFFF" height="30px" align="center"><b>Status</b></td>
                <td bgcolor="#FFFFFF" height="30px" align="center"><b>Action</b></td>
            </tr>
            <?php
            while ($row = mysql_fetch_array($result)) {
                $serviceId = $row['service_id'];
                $Id = $row['id'];
                $serviceName = $row['service'];
                $circleCode = $row['circle'];
                $circleName = $circle_info[$circleCode];
                $startTime = $row['start_time'];
                $endTime = $row['end_time'];
                if ($row['status'] == 1) {
                    $status = 'Start';
                    $action = 'end';
                } elseif ($row['status'] == 0) {
                    $status = 'Stop';
                    $action = 'strt';
                }
                ?>	
                <tr>
                    <td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $i; ?></td>
                    <td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<?php echo $serviceName; ?></td>
                    <td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<?php echo $circleName; ?></td>
                    <td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $startTime; ?></td>
                    <td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $endTime; ?></td>
                    <td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $status; ?></td>
                    <td bgcolor="#FFFFFF" height="30px" align="center">
                        <a href="#" onclick="showStatusConfirm('<?php echo $Id ?>','<?php echo $action ?>','<?php echo $serviceName ?>','<?php echo $circle; ?>');">Start/Stop</a> | 
                        <a href="#" onclick="showDeleteConfirm('<?php echo $Id; ?>','del','<?php echo $serviceName; ?>','<?php echo $circle; ?>');">Delete</a>  
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </table>
    <?php } else { ?>
        <div width="85%" align="left" class="txt">
            <div class="alert alert-block">
                <h4>Ooops!</h4>Hey,  we couldn't seem to find any record.</div>
        </div>
        <?php
    }
}
?>