<?php
session_start();
$loginid = $_SESSION['loginId'];
require_once("incs/db.php");
$serviceArray= array('1101' => 'MTSMU', '1111' => 'MTSDevo', '1123' => 'MTSContest', '1110' => 'REDFMMTS', '1116' => 'MTSVA', '1125' => 'MTSJokes',
'1126' => 'MTSReg', '1113' => 'MTSMND', '1102' => 'MTS54646', '1106' => 'MTSFMJ');
/* $serviceArray = array();
foreach ($serviceArray1 as $k => $v) {
    if (in_array($v, $services)) {
        if ($k != '') {
            //	if($Service_DESC[$v]['Operator']=='Uninor') {
            $serviceArray[$k] = $Service_DESC[$v]['Name'];
            //}
        }
    }
}
asort($serviceArray); */

$get_query = "select * from honeybee_sms_engagement.tbl_new_engagement_perior_data order by id desc";
$query = mysql_query($get_query, $dbConn);
$numofrows = mysql_num_rows($query);
if ($numofrows == 0) {
    ?>
    <div width="85%" align="left" class="txt">
        <div class="alert alert-block">
            <h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
        </div>
    </div>
    <?php
} else {
    ?>
    <center><div width="85%" align="left" class="txt">
            <div class="alert alert" >

                <a href="javascript:void(0);eventUploadhistory('me');" id="Refresh"><i class="fui-eye"></i></a>             

                <?php
                //$limit = 20;
                echo " Displaying All records";
                ?>
                </i>
            </div></div></center>
    <TABLE class="table table-condensed table-bordered">
        <thead>
<TR height="30">
<th align="left"></th>
<th align="left"><?php echo 'type Id'; ?></th>
<th align="left"><?php echo 'Event'; ?></th>
<th align="left"><?php echo 'Service id'; ?></th>


<th align="left"><?php echo 'Circle'; ?></th>
<th align="left"><?php echo 'Periortize'; ?></th>
<th align="left"><?php echo 'Added On'; ?></th>

</TR>
        </thead>
<?php
while ($summarydata = mysql_fetch_array($query)) {
?>
            <TR height="30">
<TD>
<TD><?php echo $summarydata['id']; ?></TD>
<TD><?php echo $summarydata['event']; ?></TD>
<TD><?php echo $serviceArray[$summarydata['service_id']]; ?></TD>
<TD><?php echo $summarydata['circle']; ?>
<TD><?php echo $summarydata['periotize']; ?>
<TD><?php
$added_on = $summarydata['added_on'];
echo date('j-M h:i A', strtotime($added_on));
?>
</TD>
</TR>
<?php
}
echo "</TABLE>";
}
mysql_close($dbConn);
    ?>