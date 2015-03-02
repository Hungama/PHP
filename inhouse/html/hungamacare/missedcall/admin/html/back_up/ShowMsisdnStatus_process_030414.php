<?php
//print_r($_POST);
ob_start();
session_start();
require_once("../../../db.php");
?>
<TABLE class="table table-condensed table-bordered">
    <thead>
        <TR height="30">
            <th align="left"><?php echo 'Date'; ?></th>
            <th align="left"><?php echo 'Missed call received'; ?></th>            
        </TR>
    </thead>
    <?php
    if ($_POST['msisdn'] != '' && $_POST['rangeA'] == '') {
        $msisdn = $_POST['msisdn'];
        $get_missedcall_query = "select count(*),date(date_time) from hul_hungama.tbl_hul_pushobd_sub nolock where service='HUL' and ANI='" . $msisdn . "' group by date(date_time)";
        $query = mysql_query($get_missedcall_query, $con);
        ?>
        <?php
    } else if ($_POST['rangeA'] != '' and $_POST['msisdn'] == '') {
        $rangeA = $_POST['rangeA'];
        $date_array = explode("-", $rangeA);
        $date1 = $date_array[0];
        $date1 = date("Y-m-d", strtotime($date1));
        $date2 = $date_array[1];
        $date2 = date("Y-m-d", strtotime($date2));
        $get_missedcall_query = "select count(*),date(date_time) from hul_hungama.tbl_hul_pushobd_sub nolock where service='HUL' and date(date_time) between '" . $date1 . "' and '" . $date2 . "' group by date(date_time)";
        $query = mysql_query($get_missedcall_query, $con);
    } else {
        $msisdn = $_POST['msisdn'];
        $rangeA = $_POST['rangeA'];
        $date_array = explode("-", $rangeA);
        $date1 = $date_array[0];
        $date1 = date("Y-m-d", strtotime($date1));
        $date2 = $date_array[1];
        $date2 = date("Y-m-d", strtotime($date2));
        $get_missedcall_query = "select count(*),date(date_time) from hul_hungama.tbl_hul_pushobd_sub nolock where service='HUL' and date(date_time) between '" . $date1 . "' and '" . $date2 . "' and ANI='" . $msisdn . "' group by date(date_time)";
        $query = mysql_query($get_missedcall_query, $con);
    }
    ?>

    <?php
    $numofrows = mysql_num_rows($query);
    if ($numofrows > 0) {
        while ($missedcall_data = mysql_fetch_array($query)) {
            ?>
            <TR height="30">
                <TD><?php echo date('j-M \'y ', strtotime($missedcall_data[1])); ?></TD>
                <TD><?php echo $missedcall_data[0]; ?></TD>            
            </TR>
        <?php }
    } else {
        ?>
        <TR height="30">
            <TD><?php echo 'NA'; ?></TD>
            <TD><?php echo 'NA'; ?></TD>            
        </TR>
    <?php } echo "</TABLE>";
    ?>

    <?php mysql_close($con);
    ?>