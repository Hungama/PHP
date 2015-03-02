<center><div width="85%" align="left" class="txt">
        <div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewUploadhistory('<?php echo $uploadfor; ?>')" id="Refresh"><i class="icon-refresh"></i></a>
            <?php
            $limit = 20;
//echo ALERT_VIEW_UPLOAD_HISTORY;
            echo "Config history for " . ucfirst($uploadvaluearray[$uploadfor]) . " Displaying last " . $limit . " records";
            $authtypevaluearray = array('deact' => 'Auto deactivation', 'renew' => 'Auto renewal');
            ?>
            </i>
        </div></div></center>
<TABLE class="table table-condensed table-bordered">
    <thead>
        <TR height="30">
            <th align="left"><?php echo 'ID'; ?></th>
            <th align="left"><?php echo 'Type'; ?></th>
            <th align="left"><?php echo TH_ADDEDON; ?></th>
            <th align="left"><?php echo TH_SERVICENAME; ?></th>
            <th align="left"><?php echo 'Days'; ?></th>
            <th align="left"><?php echo 'Minutes'; ?></th>
            <th align="left"><?php echo 'Pre Renewal SMS'; ?></th>
            <th align="left"><?php echo 'Mode'; ?></th>
            <th align="left"><?php echo 'Circle'; ?></th>
            <th align="left"><?php echo 'Action'; ?></th>
        </TR>
    </thead>
    <?php
    while (list($id, $status, $auto_rew_deact, $serviceId, $tnb_days, $tnb_mins, $pre_sms, $mode, $circle, $reqs_time) = mysql_fetch_array($query)) {

        foreach ($serviceArray as $key => $value) {
            if ($value == $serviceId) {
                $servicename = $key;
                break;
            }
        }
        ?>
        <TR height="30">
            <TD><?php echo $id; ?></TD>
            <TD><?php echo $authtypevaluearray[$auto_rew_deact]; ?></TD>
            <TD><?php if (!empty($reqs_time)) {
        echo date('j-M \'y g:i a', strtotime($reqs_time));
    } ?></TD>
            <TD><?php echo $Service_DESC[$servicename]['Name']; ?></TD>
            <TD><?php echo $tnb_days . ' days'; ?></TD>
            <TD><?php if ($tnb_mins) {
        echo $tnb_mins . ' mins';
    } else {
        echo 'NA';
    }; ?></TD>
            <TD><?php echo $pre_sms; ?></TD>
            <TD><?php echo $mode; ?></TD>
            <TD><?php echo $circle_info[$circle]; ?></TD>
            <TD>
                <?php if ($status == 0) { ?> 
                    <button class="btn btn-danger" style="float:right"  onclick="javascript:stopBulkFile('<?php echo $id; ?>','<?php echo 'tryandbuy'; ?>')">Stop</button>
    <?php } else {
        echo 'NA';
    }
    ?>
                <button class="btn btn-danger" style="float:right"  onclick="javascript:editBulkFile('<?php echo $id; ?>','<?php echo 'tryandbuy'; ?>')">Edit</button>
                <button class="btn btn-danger" style="float:right"  onclick="javascript:deleteBulkFile('<?php echo $id; ?>','<?php echo 'tryandbuy'; ?>')">Delete</button>
            </TD>

        </TR>	
    <?php
}
echo "</TABLE>";