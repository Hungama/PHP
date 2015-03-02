<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$host="192.168.100.224";
$username="webcc";
$password="webcc";
$str=$_GET['chars'];
//$FC= substr($str, 0, 1);  // abcd
//if($FC=='@')
if(1)
{
$con=mysql_connect($host,$username,$password) or die(mysql_error());
//$MS= substr($str, 1);
$MS=$str;

$arr=array();
$result=mysql_query("SELECT dnis FROM Inhouse_IVR.tbl_missedcall_config WHERE dnis LIKE '%".mysql_real_escape_string($MS)."%' LIMIT 0, 10",$con) or die(mysql_error());
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