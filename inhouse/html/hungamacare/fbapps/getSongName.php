<?php
error_reporting(0);
$op = $_REQUEST['op'];
$cid = $_REQUEST['cid'];
/////////////////////////////// File Pupose-> return content name according to song unique code @jyoti.porwal //////////////////////////////////////////// 
if($op=='relm')
{
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php"); // inhouse db connection @jyoti.porwal
}
else if($op=='vodm')
{
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php"); // vodafone db connection @jyoti.porwal
}

if ($op == '' || $cid == '') {
    //echo "invalid parameter";
    exit;
}
switch ($op) {
    case 'vodm':
        $DBnTable = 'vodafone_radio.tbl_song_details';
        $dbconname = $dbConnVoda;
        break;
    case 'relm':
        $DBnTable = 'reliance_radio.tbl_song_details';
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