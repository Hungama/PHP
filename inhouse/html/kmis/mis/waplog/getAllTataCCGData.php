<?php
error_reporting(1);
include ("db_224.php");
//$prevdate=$_REQUEST['date'];
$prevdate = date("Ymd", time() - 60 * 60 * 24);
$reqsdate = date("Y-m-d", time() - 60 * 60 * 24);

	$filename="http://202.87.41.194/hungamawap/docomo/doubCons/logs/CCGResponse_".$prevdate.".txt";
    $fGetContents = file_get_contents($filename);
    $e = explode("\n", $fGetContents);
    $totalcount=count($e);
   //MSISDN=>9029780801|Result=>SUCCESS|productId=>GSMENDLESSMONTHLY60|transID=>201408200050208|TPCGID=>140820004923260460|Reason=>|Songname=>|00:50:30
    for ($i = 0; $i < $totalcount; $i++) {
	$data = explode("|", $e[$i]);
	$msisdn=explode("=>",$data[0]);
	$Result=explode("=>",$data[1]);
	$service=explode("=>",$data[2]);
	$trnxid=explode("=>",$data[3]);
	$ccgid=explode("=>",$data[4]);
	$rqdate=explode("=>",$data[7]);
	$dateTime=$reqsdate.' '.$rqdate[0];
	if($Result[1]=='SUCCESS'){
		$sql="INSERT INTO Hungama_WAP_Logging.tbl_wap_logs(date,service,msisdn,reqs_date,charging_date,ccgid,trnxid,status) VALUES('".$reqsdate."','".$service[1]."','".$msisdn[1]."','".$dateTime."','','".$ccgid[1]."','".$trnxid[1]."',0)";
		//echo $sql."<br>";
		if(!mysql_query($sql,$con)){
		//	die(" Error: ".mysql_error());
		echo "Error: ".mysql_error();
		}
	 }
}
echo "Done";
mysql_close($con);
?>