<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$host="10.130.14.106";
$username="billing";
$password="billing";
$str=$_GET['chars'];
$FC= substr($str, 0, 1);  // abcd
if($FC=='@')
{
$con=mysql_connect($host,$username,$password) or die(mysql_error());
$MS= substr($str, 1);
$arr=array();
$result=mysql_query("SELECT email FROM master_db.live_user_master WHERE email LIKE '%".mysql_real_escape_string($MS)."%' LIMIT 0, 10",$con) or die(mysql_error());
if(mysql_num_rows($result)>0){
    while($data=mysql_fetch_row($result)){
        // Store data in array
		 $arr[]=$data[0];
    }
}

mysql_close($con);
// Encode it with JSON format
echo json_encode($arr);
}
?>