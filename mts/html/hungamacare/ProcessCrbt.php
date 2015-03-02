<?php
include("config/dbConnect.php");
$DB='mts_radio';
$subscriptionProcedure='RADIO_CHKCRBT';

$getCrbt="select ani,crbt_id from mts_radio.tbl_radiocrbt_reqs where status=0 ";
$queryIns = mysql_query($getCrbt,$dbConn);
while($row=mysql_fetch_array($queryIns))
{
	$qry="call ".$DB.".". $subscriptionProcedure." ('".$row['ani']."','".$row['crbt_id']."',@output)";
	$qry1=mysql_query($qry,$dbConn) or die( mysql_error());
	$q2=mysql_query("select @output",$dbConn) or die( mysql_error());
	$result=mysql_fetch_row($q2);

	$explodeResult=explode("#",$result[0]);
	$url="http://10.130.14.106:8088/hungama/radio_cRBT?ANI=".$row['ani']."&TOKEN=USERSTATUS&OPERATOR=MTSM";
	$response=file_get_contents($url);

	if($response=="UserStatus1.value=\'NEW\'" || strpos($response,'NEW'))
	{
		$url1  ="http://10.130.14.106:8088/hungama/radio_dbinteraction?PROCEDURE=RADIO_CRBTRNGREQS&INTOKEN=5&OUTTOKEN=0";
		$url1 .="&INPARAM[0]=".$row['ani']."&INPARAM[1]=".$explodeResult[0]."&INPARAM[2]=".$row['crbt_id'];
		$url1 .="&INPARAM[3]=crbtACTIVATE&INPARAM[4]=".$explodeResult[1];
		file_get_contents($url1);

		$url2  ="http://10.130.14.106:8088/hungama/radio_dbinteraction?PROCEDURE=RADIO_CRBTRNGREQS&INTOKEN=5&OUTTOKEN=0";
		$url2 .="&INPARAM[0]=".$row['ani']."&INPARAM[1]=".$explodeResult[0]."&INPARAM[2]=".$row['crbt_id'];
		$url2 .="&INPARAM[3]=crbtDOWNLOAD&INPARAM[4]=".$explodeResult[1];
		file_get_contents($url2);

		$qry="call ".$DB.".". $subscriptionProcedure." ('".$row['ani']."','ACTIVE',@output)";
		$qry1=mysql_query($qry,$dbConn) or die( mysql_error());
		$q2=mysql_query("select @output",$dbConn) or die( mysql_error());
		$result=mysql_fetch_row($q2);

	}
	elseif($response=="UserStatus1.value='RBT_ACT'" || strpos($response,'RBT_ACT'))
	{

		$url1  ="http://10.130.14.106:8088/hungama/radio_dbinteraction?PROCEDURE=RADIO_CRBTRNGREQS&INTOKEN=5&OUTTOKEN=0";
		$url1 .="&INPARAM[0]=".$row['ani']."&INPARAM[1]=".$explodeResult[0]."&INPARAM[2]=".$row['crbt_id'];
		$url1 .="&INPARAM[3]=crbtMIGRATE&INPARAM[4]=".$explodeResult[1];
		file_get_contents($url1);

		$url2  ="http://10.130.14.106:8088/hungama/radio_dbinteraction?PROCEDURE=RADIO_CRBTRNGREQS&INTOKEN=5&OUTTOKEN=0";
		$url2 .="&INPARAM[0]=".$row['ani']."&INPARAM[1]=".$explodeResult[0]."&INPARAM[2]=".$row['crbt_id'];
		$url2 .="&INPARAM[3]=crbtDOWNLOAD&INPARAM[4]=".$explodeResult[1];
		file_get_contents($url2);

		$qry="call ".$DB.".". $subscriptionProcedure." ('".$row['ani']."','MIGRATE',@output)";
		$qry1=mysql_query($qry,$dbConn) or die( mysql_error());
		$q2=mysql_query("select @output",$dbConn) or die( mysql_error());
		$result=mysql_fetch_row($q2);
	}
	elseif($response=="UserStatus1.value='EAUC'" || strpos($response,'EAUC'))
	{
		$url2  ="http://10.130.14.106:8088/hungama/radio_dbinteraction?PROCEDURE=RADIO_CRBTRNGREQS&INTOKEN=5&OUTTOKEN=0";
		$url2 .="&INPARAM[0]=".$row['ani']."&INPARAM[1]=".$explodeResult[0]."&INPARAM[2]=".$row['crbt_id'];
		$url2 .="&INPARAM[3]=crbtDOWNLOAD&INPARAM[4]=".$explodeResult[1];
		file_get_contents($url2);

		$qry="call ".$DB.".". $subscriptionProcedure." ('".$row['ani']."','DOWNLOAD',@output)";
		$qry1=mysql_query($qry,$dbConn) or die( mysql_error());
		$q2=mysql_query("select @output",$dbConn) or die( mysql_error());
		$result=mysql_fetch_row($q2);
	}
	else
	{
		$qry="call ".$DB.".". $subscriptionProcedure." ('".$row['ani']."','NOACTION',@output)";
		$qry1=mysql_query($qry,$dbConn) or die( mysql_error());
		$q2=mysql_query("select @output",$dbConn) or die( mysql_error());
		$result=mysql_fetch_row($q2);
	}

}
echo "done";

?>