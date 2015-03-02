<?php


require_once("../../Public/database.class.php");
require_once("../../ContentBI/base.php");
require_once("../../cmis/base.php");
require_once("../incs/core2.php");

$RAND = makePin();


$Name = strtolower($_REQUEST['username']);
// Create File for Storage
					$Filename = "MDNStatus____".$_REQUEST['Tbl']."____".$RAND.".txt";
					$target_file = "../../cmis/tmp/".$Filename;
					$IN = explode("\n",$_REQUEST['Numbers']);
					$FLO = '';
					$count=0;
					foreach($IN as $Nm) {
					
					$FLO .= $Nm.",";
					$count++;
						
					}
					$FLO = rtrim($FLO,"\r\n");
					$FLO = rtrim($FLO,"\n");
					$FLO = rtrim($FLO,",");
					
					$fp = fopen($target_file,"a");
					fwrite($fp,$FLO);


//////
//echo $filename;exit;


$QUERY_DATA = $_REQUEST["Tbl"]."|".$count;

//echo $QUERY_DATA;exit;



	mysql_query("insert into public_acts (id, username, email, mobile, type, filename, status, response, added, mdn_in) values(NULL, '$Name','$Name@hungama.com', '', 'MDNDump','$Filename','Queued','',now(),'$count') ") or ($ERROR = mysql_error());
	$ID = mysql_insert_id();
	//echo $ID;exit;

	$URL = "http://127.0.0.1/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/Cron.MDNDump.Process.php?ID=".$ID;
	//echo $URL;exit;
	$ST =date("H:i:s", mktime(date("H"),date("i")+1,date("s")+30,date("m"),date("d"),date("y")));
	shell_exec("schtasks /create /ru \"".$MACHINE_USERNAME."\" /rp \"".$MACHINE_PASSWORD."\" /sc ONCE /st ".$ST." /tn \"".$Name."-".time()."\" /tr \"c:\\wget.exe -b -q ".$URL."\"");
	//exit;
	
	
	


if($ERROR) {
	
	mysql_query("insert into public_acts (id, username, email, mobile, type, filename, status, response, added) values(NULL, '$Name','$Name@hungama.com', '', 'MDNDump','$Filename','ERROR','$ERROR',now()) ") or (mysql_error());
	$ID = mysql_insert_id();

}
@mysql_close();
echo "Your request has been registered with ID: ".$ID;exit;


?>