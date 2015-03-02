<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
$date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$allcircle = array();
$circle_mts = array('KAR', 'KER', 'GUJ', 'RAJ', 'KOL', 'UPW', 'DEL', 'TNU');
$getwinner_query = "select distinct(ANI), total_question_play,score,date_time,circle,SOU,lastChargeAmount,pulses from mts_radio.tbl_wmdcontest_misdaily 
				where date(date_time)='" . $date . "'  and circle not in('null','') and score>=1 order by score desc limit 1";
$result_winner = mysql_query($getwinner_query, $dbConn) or die(mysql_error());
$result_row_winner = mysql_num_rows($result_winner);
if ($result_row_winner > 0) {

    $deletequery = "delete from mts_radio.tbl_wmdcontest_misdaily_recharged where date(date_time)='" . $date . "' ";
    $result_delete = mysql_query($deletequery, $dbConn) or die(mysql_error());
    while ($winner_details = mysql_fetch_array($result_winner)) {
        //insert in recharge table to process
        $insert_query = "insert into mts_radio.tbl_wmdcontest_misdaily_recharged (ANI,total_question_play,score,date_time,circle,status,level,SOU,lastChargeAmount,pulses) 
		values ('" . $winner_details['ANI'] . "','" . $winner_details['total_question_play'] . "','" . $winner_details['score'] . "','" . $winner_details['date_time'] . "','" . $winner_details['circle'] . "',0,'1','" . $winner_details['SOU'] . "','" . $winner_details['lastChargeAmount'] . "','" . $winner_details['pulses'] . "')";
        mysql_query($insert_query, $dbConn);
    }

    mysql_close($dbConn);
} else {
    mysql_close($dbConn);
    echo 'No records found';
    exit;
}
echo 'done';
?>  