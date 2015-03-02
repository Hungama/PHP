<?php
//ini_set('memory_limit', '700M');
//set_time_limit (0);
$SKIP = 1;
require_once("../../Public/database.class.php");
require_once("../../ContentBI/base.php");
require_once("../../cmis/base.php");
require_once("../incs/core2.php");
$RAND = makePin();

$Name = strtolower($_REQUEST['username']);

$CIRCLES = join($_REQUEST['Circle'],",");

$QUERY_DATA = $CIRCLES."|".$From."|".$To."|".$_REQUEST['DumpType']."|".addslashes($_REQUEST['Tbl']);

//echo $QUERY_DATA;exit;



	mysql_query("insert into public_acts (id, username, email, mobile, type, filename, status, response, added) values(NULL, '$Name','$Name@hungama.com', '', 'BillDump','$QUERY_DATA','Queued','',now()) ") or ($ERROR = mysql_error());
	$ID = mysql_insert_id();

	$URL = "http://127.0.0.1/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/Cron.Billing.Process.php?ID=".$ID;
	//echo $URL;exit;
	$ST =date("H:i:s", mktime(date("H"),date("i")+1,date("s")+30,date("m"),date("d"),date("y")));
	shell_exec("schtasks /create /ru \"".$MACHINE_USERNAME."\" /rp \"".$MACHINE_PASSWORD."\" /sc ONCE /st ".$ST." /tn \"".$Name."-".time()."\" /tr \"c:\\wget.exe -b -q ".$URL."\"");
	//exit;
	
	
	


if($ERROR) {
	
	mysql_query("insert into public_acts (id, username, email, mobile, type, filename, status, response, added) values(NULL, '$Name','$Name@hungama.com', '', 'BillDump','$Filename','ERROR','$ERROR',now()) ") or (mysql_error());
	$ID = mysql_insert_id();

}

echo "Your request has been registered with ID: ".$ID;exit;

?>