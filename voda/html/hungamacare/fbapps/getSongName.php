<?php

/////////////////////////////// File Pupose-> return content name according to song unique code @jyoti.porwal ////////////////////////////////////////////
error_reporting(0);
$op = $_REQUEST['op'];
$cid = $_REQUEST['cid'];

if ($op == 'vodm') {
    include("../dbConnect.php"); // vodafone db connection @jyoti.porwal
}
switch ($op) {
    case 'vodm':
        $DBnTable = 'vodafone_radio.tbl_song_details';
        $dbconname = $dbConn;
        break;
}
$query = "select content_name from " . $DBnTable . "  nolock 
        where songuniquecode = '" . trim(substr($cid, 4)) . "'";
$result = mysql_query($query, $dbconname) or die(mysql_error());
$deatils = mysql_fetch_array($result);
echo $deatils['content_name'];
mysql_close($dbconname);
exit;
?>