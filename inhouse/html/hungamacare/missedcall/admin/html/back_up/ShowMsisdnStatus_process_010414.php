<?php
//print_r($_POST);
ob_start();
session_start();
require_once("../../../db.php");
?>
<TABLE class="table table-condensed table-bordered">
    <thead>
        <TR height="30">
            <th align="left"><?php echo 'Missed call received'; ?></th>
            <th align="left"><?php echo 'Date'; ?></th>
            <th align="left"><?php echo 'OBD received'; ?></th>
            <th align="left"><?php echo 'Date'; ?></th>
        </TR>
    </thead>
    <?php
    if ($_POST['msisdn'] != '' && $_POST['rangeA'] == '') {
        $msisdn = $_POST['msisdn'];
        echo $get_missedcall_query = "select count(*),date(date_time) from hul_hungama.tbl_hul_pushobd_sub nolock where service='HUL' and ANI='" . $msisdn . "' group by date(date_time)";
        $query = mysql_query($get_missedcall_query, $con);
        //$missedcall_data_array = mysql_fetch_array($query);
        //$numofmissedcallrows = mysql_num_rows($query);
        echo $get_obd_query = "select count(*),date(date_time) from hul_hungama.tbl_hulobd_success_fail_details nolock  where  service='HUL' and ANI='" . $msisdn . "' and status=2 group by date(date_time)";
        $obd_query = mysql_query($get_obd_query, $con);
        //$obd_data_array = mysql_fetch_array($obd_query);
        //$numofobdrows = mysql_num_rows($obd_query);
        ?>
        <?php
    } else if ($_POST['rangeA'] != '' and $_POST['msisdn'] == '') {
        $rangeA = $_POST['rangeA'];
        $date_array = explode("-", $rangeA);
        $date1 = $date_array[0];
        $date1 = date("Y-m-d", strtotime($date1));
        $date2 = $date_array[1];
        $date2 = date("Y-m-d", strtotime($date2));
        echo $get_missedcall_query = "select count(*),date(date_time) from hul_hungama.tbl_hul_pushobd_sub nolock where service='HUL' and date(date_time) between '" . $date1 . "' and '" . $date2 . "' group by date(date_time)";
        $query = mysql_query($get_missedcall_query, $con);
        //$missedcall_data_array = mysql_fetch_array($query);
        //$numofmissedcallrows = mysql_num_rows($query);
        echo $get_obd_query = "select count(*),date(date_time) from hul_hungama.tbl_hulobd_success_fail_details nolock  where  service='HUL' and date(date_time) between '" . $date1 . "' and '" . $date2 . "' and status=2 group by date(date_time)";
        $obd_query = mysql_query($get_obd_query, $con);
        //$obd_data_array = mysql_fetch_array($obd_query);
        //$numofobdrows = mysql_num_rows($obd_query);
    } else {
        $msisdn = $_POST['msisdn'];
        $rangeA = $_POST['rangeA'];
        $date_array = explode("-", $rangeA);
        $date1 = $date_array[0];
        $date1 = date("Y-m-d", strtotime($date1));
        $date2 = $date_array[1];
        $date2 = date("Y-m-d", strtotime($date2));
        echo $get_missedcall_query = "select count(*),date(date_time) from hul_hungama.tbl_hul_pushobd_sub nolock where service='HUL' and date(date_time) between '" . $date1 . "' and '" . $date2 . "' and ANI='" . $msisdn . "' group by date(date_time)";
        $query = mysql_query($get_missedcall_query, $con);
        //$missedcall_data_array = mysql_fetch_array($query);
        //$numofmissedcallrows = mysql_num_rows($query);
        echo $get_obd_query = "select count(*),date(date_time) from hul_hungama.tbl_hulobd_success_fail_details nolock  where  service='HUL' and date(date_time) between '" . $date1 . "' and '" . $date2 . "' and ANI='" . $msisdn . "' and status=2 group by date(date_time)";
        $obd_query = mysql_query($get_obd_query, $con);
        //$obd_data_array = mysql_fetch_array($obd_query);
        //$numofobdrows = mysql_num_rows($obd_query);
    }
    ?>

    <?php while ($missedcall_data = mysql_fetch_array($query)) { ?>
        <TR height="30">
            <TD><?php echo $missedcall_data[0]; ?></TD>
            <TD><?php echo $missedcall_data[1]; ?></TD>
        </TR>
    <?php } while ($obd_data = mysql_fetch_array($obd_query)) { ?>
        <TR height="30">
            <TD><?php echo $obd_data[0]; ?></TD>
            <TD><?php echo $obd_data[1]; ?></TD>
        </TR>
    <?php } ?>

    <?php echo "</TABLE>";
    ?>

    <?php mysql_close($con);
    ?>