<?php
require_once("incs/db.php");
if ($dbConn) {
    $circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other');
    if ($_REQUEST['service']) {
        $serviceId = $_REQUEST['service'];

        if ($_REQUEST['id'] && $_REQUEST['act']) {
            $actionId = $_REQUEST['id'];
            $actionType = $_REQUEST['act'];
            if ($actionType == 'strt') {
                $startQuery = "UPDATE Vodafone_IVR.tbl_doubleconsent_time SET status=1 WHERE id=" . $actionId;
                mysql_query($startQuery);
            } elseif ($actionType == 'end') {
                $endQuery = "UPDATE Vodafone_IVR.tbl_doubleconsent_time SET status=0 WHERE id=" . $actionId;
                mysql_query($endQuery);
            } elseif ($actionType == 'del') {
                $delQuery = "UPDATE Vodafone_IVR.tbl_doubleconsent_time SET status=5 WHERE id=" . $actionId;
                mysql_query($delQuery);
            }
        }

        $query = "select t.id,s.servicename,s.service_id,t.start_time,t.end_time,t.status,s.circle,t.switchtype,s.shortCode from Vodafone_IVR.tbl_doubleconsent s INNER JOIN Vodafone_IVR.tbl_doubleconsent_time t ON s.id=t.sId WHERE t.status!=5 and s.service_id='" . $serviceId . "'";
        if ($_REQUEST['circle']) {
            $circle = $_REQUEST['circle'];
            $query .= "and s.circle='" . $circle . "'";
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
                    <td bgcolor="#FFFFFF" height="30px" align="center"><b>ShortCode</b></td>					
                    <td bgcolor="#FFFFFF" height="30px" align="center"><b>Circle</b></td>
                    <td bgcolor="#FFFFFF" height="30px" align="center"><b>Switch Type</b></td>
                    <td bgcolor="#FFFFFF" height="30px" align="center"><b>Start Time</b></td>
                    <td bgcolor="#FFFFFF" height="30px" align="center"><b>End Time</b></td>
                    <td bgcolor="#FFFFFF" height="30px" align="center"><b>Status</b></td>
                    <td bgcolor="#FFFFFF" height="30px" align="center"><b>Action</b></td>
                </tr>
                <?php
                while ($row = mysql_fetch_array($result)) {
                    $serviceId = $row['service_id'];
                    $sId = $row['id'];
                    $serviceName = $row['servicename'];
                    $shortCode = $row['shortCode'];
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
                    $switchtype = $row['switchtype'];
                    if ($switchtype == 1) {
                        $switchdesc = '1S';
                    } elseif ($switchtype == 2) {
                        $switchdesc = '2S';
                    } elseif ($switchtype == 3) {
                        $switchdesc = 'Both';
                    } else {
                        $switchdesc = 'NOS';
                    }
                    ?>	
                    <tr>
                        <td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $i; ?></td>
                        <td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<?php echo $serviceName; ?></td>
                        <td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<?php echo $shortCode; ?></td>						
                        <td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<?php echo $circleName; ?></td>
                        <td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<?php echo $switchdesc; ?></td>
                        <td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $startTime; ?></td>
                        <td bgcolor="#FFFFFF" height="30px" align="center"><?php echo $endTime; ?></td>
                        <td bgcolor="#FFFFFF" height="30px" align="center"><?php
                ///////////////////// start code to stop the switch when current time is greater than the switch time @jyoti.porwal /////////////////////////////////////                        
                $getCurrentTimeQuery = "select now()";
                $timequery2 = mysql_query($getCurrentTimeQuery);
                $currentTime = mysql_fetch_row($timequery2);
                
                if ($currentTime[0] >= $endTime) {
                    echo 'Stop';
//                    $endQuery = "UPDATE  Vodafone_IVR.tbl_doubleconsent_time SET status=0 WHERE id=" . $sId;
//                    mysql_query($endQuery);
                } else {
                    echo $status;
                }
///////////////////// end code to stop the switch when current time is greater than the switch time @jyoti.porwal /////////////////////////////////////
                    ?></td>
                        <td bgcolor="#FFFFFF" height="30px" align="center">
                            <a href="#" onclick="showStatusConfirm('<?php echo $sId ?>','<?php echo $action ?>','<?php echo $serviceId ?>','<?php echo $circle; ?>');">Start/Stop</a> | 
                            <a href="#" onclick="showDeleteConfirm('<?php echo $sId; ?>','del','<?php echo $serviceId; ?>','<?php echo $circle; ?>');">Delete</a>  
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
} else {
    echo "Database not connected";
}
?>