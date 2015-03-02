<?php 
$MOBILENO=$_GET['MOBILENO'];
$MESSAGE=$_GET['MESSAGE'];
$KEYWORD=$_GET['KEYWORD'];
$SHORTCODE=$_GET['SHORTCODE'];
$SERVICETYPE=$_GET['SERVICETYPE'];
$curdate = date("Y-m-d");
if ($MOBILENO=='' || $MESSAGE=='' || $KEYWORD=='' || $SHORTCODE=='' || $SERVICETYPE=='')
{
	echo "Please provide complete parameter";
	exit;
}
switch($SERVICETYPE)
{
	case "CDMA":
		$db="indicom_radio";
		$dbProcedure="indicom_xxxx";
		break;
	case "GSM":
		$db="docomo_radio";
		$dbProcedure="docomo_xxxx";
		break;
}
/*$con = mysql_connect("119.82.69.210","weburl","weburl");
if(!$con)
{
	die('We are facing some temporarily Problem , please try later : ');
}*/

$mo_log_file_path="mologs/mologs_".$curdate.".txt";
$file=fopen($mo_log_file_path,"a") or die('ERROR');
echo "SUCCESS";
fwrite($file,$MOBILENO . "#" . $MESSAGE . "#" . $KEYWORD . "#" . $SHORTCODE . "#" . $SERVICETYPE . "#" . date('H:i:s') . "\r\n" );
fclose($file);


/*$call="call ".$dbProcedure."('".$MOBILENO."','".$MESSAGE."','".$KEYWORD."','".$SHORTCODE."','".$SERVICETYPE."')";
$qry1=mysql_query($call) or die( mysql_error() );
mysql_close($con);*/
?>