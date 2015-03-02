<?php
$msisdn = trim($_REQUEST['msisdn']);
$mode = trim($_REQUEST['mode']);
$reqtype = trim($_REQUEST['reqtype']);
$planid = trim($_REQUEST['planid']);
$seviceId = trim($_REQUEST['serviceid']);
$subchannel = trim($_REQUEST['subchannel']);
$rcode = trim($_REQUEST['rcode']);
$CCGID = trim($_REQUEST['CCGID']);
$ac = trim($_REQUEST['ac']);
$param = trim($_REQUEST['param']);
$test = trim($_REQUEST['test']);
$online = trim($_REQUEST['online']);
$catId1 = trim($_REQUEST['cat1']);
$catId2 = trim($_REQUEST['cat2']);
$lang1 = trim($_REQUEST['lang']);
$batchId = trim($_REQUEST['batchid']);
$transid = trim($_REQUEST['TCID']);
$UCT = $_REQUEST['UCT'];
$rel=$_REQUEST['rel'];

if ($transid=='') {
    $transid = 0;
}
//for voicegate trx_id
$transid_new = $_REQUEST['trx_id'];
if ($transid_new=='') {
    $transid = $transid_new;
}
if ($transid=='') {
    $transid = 0;
}

if ($catId1 || $catId2) {
    if (!$catId1)
        $catId1 = "NA";
    if (!$catId2)
        $catId2 = "NA";
}
$remoteAdd = trim($_SERVER['REMOTE_ADDR']);
//log landing request for each request start here 
$logDir="/var/www/html/MTS/logs/";
$logFile_dump="log_".date('Ymd');
$logPath=$logDir.$logFile_dump.".txt";
$filePointer1=fopen($logPath,'a+');

$logFile_dump2="urllog_".date('Ymd');
$logPath2=$logDir.$logFile_dump2.".txt";

chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer1,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer1,date('H:i:s').'|'.$remoteAdd."\n");
//end here


//10.130.14.107/MTS/MTS.php?msisdn=8587800665&mode=197_OBD&reqtype=1&planid=37&serviceid=1113&
//subchannel=OBD&rcode=100,101,102&CCGID=12345555
//Added for combopack details
$comboPackArray=array(120,121,122,123,124,125,126,127,128,129,130,131,132);
		if(in_array($planid,$comboPackArray))
			{
			$pagename='MTS_Telecall.php';
			}
			else
			{
			$pagename='MTS.php';
			}
			
$url = "http://10.130.14.107/MTS/$pagename?msisdn=".$msisdn."&mode=".$mode."&reqtype=".$reqtype."&planid=".$planid."&serviceid=".$seviceId;
$url.="&subchannel=".$subchannel."&rcode=".$rcode."&CCGID=".$CCGID."&ac=".$ac."&test=".$test."&online=".$online;
$url.="&cat1=".$catId1."&cat2=".$catId2."&lang=".$lang1."&batchid=".$batchId."&TCID=".$transid."&UCT=".$UCT."&rel=".$rel;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo $data = curl_exec($ch);
$log_str_new = date("his")."|".$url."|".$data."|end|\n";
error_log($log_str_new,3,$logPath2);
?>