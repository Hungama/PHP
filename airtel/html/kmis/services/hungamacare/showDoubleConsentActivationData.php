<?php
include("config/dbConnect.php");
include("web_admin.js");
include("header.php");

$logPath = "/var/www/html/kmis/services/hungamacare/log/directAct/DoubleConsentActivation_" . date("Y-m-d") . ".txt";

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAR' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Other', 'HAY' => 'Haryana');
?>
<script language="javascript">

    function validateData() {
	  if(document.getElementById('service').value=='0') {
            alert("Please select service.");
            return false;
        }
        return true;
    }

    function showStatusConfirm(st) { 
        if(st == 'strt') {
            var answer = confirm("Are You Sure To Want Start Selected Time-Slot?");
            if(answer) return true;
            else return false;
        } 
        if(st == 'end') {
            var answer = confirm("Are You Sure To Want End Selected Time-Slot?");
            if(answer) return true;
            else return false;
        }
    }

    function showDeleteConfirm() {
        var answer = confirm("Are You Sure To Want Delete Selected Time-Slot?");
        if(answer) return true;
        else return false;
    }
</script>
<div class='txt' align='right'><a href='DoubleConsentActivation.php'>Add Time-Slots</a>&nbsp;&nbsp;&nbsp;</div><br/>

<form name="tstest" action='showDoubleConsentActivationData.php' method='POST' onSubmit="return validateData();">
    <TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
        <tr>
            <td bgcolor="#FFFFFF" height="30px" width='32%'>&nbsp;&nbsp;<b>Service</b></td>
            <td bgcolor="#FFFFFF">&nbsp;&nbsp;
                <select name='service' id="service">	
					<option value='0'>Select Service</option>
					<option value='1501' <?php if ($_REQUEST['service'] == '1501') echo "SELECTED"; ?>>Airtel-EU</option>	
					<option value='1513' <?php if ($_REQUEST['service'] == '1513') echo "SELECTED"; ?>>Airtel-MND</option>					
                    <!--option value='1507' <?php if ($_REQUEST['service'] == '1507') echo "SELECTED"; ?>>Airtel-VH1</option>
                    <option value='1518' <?php if ($_REQUEST['service'] == '1518') echo "SELECTED"; ?>>Airtel-CMD</option>
                    <option value='1509' <?php if ($_REQUEST['service'] == '1509') echo "SELECTED"; ?>>Airtel-RIA</option>
                    <option value='15091' <?php if ($_REQUEST['service'] == '15091') echo "SELECTED"; ?>>Airtel-RIA-54646169</option>
                    
                    <option value='1503' <?php if ($_REQUEST['service'] == '1503') echo "SELECTED"; ?>>Airtel-MTV</option>
                    <option value='1520' <?php if ($_REQUEST['service'] == '1520') echo "SELECTED"; ?>>Airtel-PK</option>
                    <option value='1515' <?php if ($_REQUEST['service'] == '1515') echo "SELECTED"; ?>>Airtel-DEVO</option>
                    <option value='1514' <?php if ($_REQUEST['service'] == '1514') echo "SELECTED"; ?>>Airtel-PD</option>
                    <option value='1517' <?php if ($_REQUEST['service'] == '1517') echo "SELECTED"; ?>>Airtel-SE</option>
                    <option value='1502' <?php if ($_REQUEST['service'] == '1502') echo "SELECTED"; ?>>Airtel-54646</option>
                    
                    <option value='1511' <?php if ($_REQUEST['service'] == '1511') echo "SELECTED"; ?>>Airtel-GL</option>
                    <option value='1522' <?php if ($_REQUEST['service'] == '1522') echo "SELECTED"; ?>>Airtel-REG TN/KK</option>
                    <option value='15020' <?php if ($_REQUEST['service'] == '15020') echo "SELECTED"; ?>>Hungama Entertainment portal - 546460</option>
                    <option value='15022' <?php if ($_REQUEST['service'] == '15022') echo "SELECTED"; ?>>Luv Guru - 546462</option>
                    <option value='15023' <?php if ($_REQUEST['service'] == '15023') echo "SELECTED"; ?>>Music World - 546463</option>
                    <option value='15031' <?php if ($_REQUEST['service'] == '15031') echo "SELECTED"; ?>>MTV DJ Dial - 546461</option-->
                </select></td>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF" height="30px">&nbsp;&nbsp;<b>Circle</b></td>
            <td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='circle' id='circle' >
                    <option value="0">Select circle</option>
                    <?php foreach ($circle_info as $circle_id => $circle_val) { ?>
                        <option value='<?php echo $circle_id; ?>' <?php if ($_REQUEST['circle'] == $circle_id) echo "SELECTED"; ?>><?php echo $circle_val; ?></option>
                    <?php } ?>
                </select></td>
        </tr>
        <tr><td colspan='2' align='center' bgcolor="#FFFFFF" align="center"><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
    </table>

</form>
<br/><br/><br/>
<?php
if ($_REQUEST['service']) {
    $serviceId = $_REQUEST['service'];
    if ($serviceId == 15020 || $serviceId == 15022 || $serviceId == 15023) {
        $serviceId = 1502;
    }
    if ($serviceId == 15031) {
        $serviceId = 1503;
    }
    if ($_REQUEST['id'] && $_REQUEST['act']) {
        $actionId = $_REQUEST['id'];
        $actionType = $_REQUEST['act'];
        if ($actionType == 'strt') {
            $startQuery = "UPDATE master_db.tbl_doubleconsent_time SET status=1 WHERE id=" . $actionId;
            mysql_query($startQuery);
        } elseif ($actionType == 'end') {
            $endQuery = "UPDATE master_db.tbl_doubleconsent_time SET status=0 WHERE id=" . $actionId;
            mysql_query($endQuery);
        } elseif ($actionType == 'del') {
            //$delQuery = "DELETE FROM master_db.tbl_doubleconsent_time WHERE id=" . $actionId;
			$delQuery = "UPDATE master_db.tbl_doubleconsent_time SET status=5 WHERE id=" . $actionId;
            mysql_query($delQuery);
        }
    }

    $query = "select t.id,s.servicename,s.service_id,t.start_time,t.end_time,t.status,s.circle from master_db.tbl_doubleconsent s INNER JOIN master_db.tbl_doubleconsent_time t ON s.id=t.sId WHERE s.service_id='" . $serviceId . "'";
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
        <div align="center"><b>Time-Slots</b></div></br>
        <table width="60%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">	
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
                $sId = $row['id'];
                $serviceName = $row['servicename'];
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
				elseif ($row['status'] == 5) {
                    $status = 'NA';
                    $action = 'NA';
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
					<?php if ($row['status'] != 5) {?>
					<a href='showDoubleConsentActivationData.php?id=<?php echo $sId; ?>&act=<?php echo $action; ?>&service=<?php echo $serviceId; ?>&circle=<?php echo $circle; ?>' onclick='javascript: return showStatusConfirm("<?php echo $action; ?>");'>Start/Stop</a> | <a href='showDoubleConsentActivationData.php?id=<?php echo $sId; ?>&act=del&service=<?php echo $serviceId; ?>&circle=<?php echo $circle; ?>' onclick='return showDeleteConfirm();'>Delete</a>
					<?php }
					else
					{
					echo 'NA';
					}?>
					</td>
					<!-- return showStatusConfirm(<?php echo $action; ?>); -->
                </tr>
                <?php $i++;
            }
            ?>
        </table>
    <?php } else { ?>
        <div class='txt' align='center'><b>No Record Found</b></div>
        <?php
    }
}
?>