<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require_once("incs/db.php");
$arr=array();
$result=mysql_query("SELECT email FROM master_db.live_user_master WHERE email LIKE '%".mysql_real_escape_string($_GET['chars'])."%' LIMIT 0, 10",$dbConn) or die(mysql_error());
if(mysql_num_rows($result)>0){
    while($data=mysql_fetch_row($result)){
        // Store data in array
        $arr[]=$data[1];
    }
}

mysql_close($con);

// Encode it with JSON format
echo json_encode($arr);
?>