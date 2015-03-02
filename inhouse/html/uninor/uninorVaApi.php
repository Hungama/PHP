<?php  
error_reporting(1);
$msisdn=$_REQUEST['msisdn'];
if(strlen($msisdn)==12  || strlen($msisdn)==10)
	{
	if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
	}
	
	
$circle=$_REQUEST['circle'];
$text=$_REQUEST['txt'];
$SCHN='SMS';
//$smskeyword=explode(" ",$text);
//$mainkeyword=$smskeyword[0];
//$subkeyword=$smskeyword[1];
$mainkeyword=strtoupper($text);
$KeywordTrnasactionReport="/var/www/html/Uninor/logs/UninorVA/keywords_".date('Ymd').".txt";
$req_received=date("Y-m-d H:i:s");


$logFile="/var/www/html/Uninor/logs/UninorVA/logs_".date('Ymd').".txt";
//log all request parameter start here
$filePointer1=fopen($KeywordTrnasactionReport,'a+');
chmod($KeywordTrnasactionReport,0777);
$arrCnt=sizeof($_REQUEST);
$str='';
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer1,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer1,date('H:i:s')."\n");
//log all request parameter end here
$randno=rand();
$CPTID="TX123456789".$randno;
$cdatetime=date('Y-m-d h:i:s:m');
$DT=str_replace(" ","T",$cdatetime);
switch($mainkeyword)
{
	case 'BA':		
		$CPPID="HUI0043970";
		$PRICE=3000;
		$PMARKNAME=urlencode("BollyAlerts");		
		$PD=urlencode('BollyAlerts');
		break;
	case 'FMW':		
		$CPPID="HUI0043971";
		$PRICE=3000;
		$PMARKNAME=urlencode("FilmiWords");
		$PD=urlencode('FilmiWords');
		break;
	case 'FASS':		
		$CPPID="HUI0043974";
		$PRICE=3000;
		$PMARKNAME=urlencode("CelebrityFashion");
		$PD=urlencode('CelebrityFashion');
		break;
	case 'FITT':		
		$CPPID="HUI0043973";
		$PRICE=3000;
		$PMARKNAME=urlencode("FilmiHeath");
		$PD=urlencode('FilmiHeath');
		break;
	case 'BWDM':		
		$CPPID="HUI0043972";
		$PRICE=3000;
		$PMARKNAME=urlencode("Bollywood Masala");
		$PD=urlencode('Bollywood Masala');
		break;
}
if(!empty($mainkeyword))
{
//hit with CPPID
$ccgurl="http://180.178.28.62:7001/ContentPartner/ContentPartnerSynchPS?SCHN=$SCHN&CP=HUNGAMA&MSISDN=$msisdn&CPPID=$CPPID&";
$ccgurl.="PRODTYPE=SUB&PMARKNAME=$PMARKNAME&PRICE=$PRICE&SE=HUNGAMA&CPTID=$CPTID";
$ccgurl.="&DT=$DT&PD=$PD&SCODE=abc&RSV=&RSV2=&END";
$ch_result=curl_init($ccgurl);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$response= curl_exec($ch_result);
curl_close($ch_result);

	$xml = simplexml_load_string($response);
	$Resp_CGID = $xml->CGID;
	$Resp_RESULT = $xml->RESULT;
	$Resp_REASON = $xml->REASON;
	$Resp_CODE = $xml->CODE;
	$Resp_CPTID = $xml->CPTID;
	
	
$logData=$msisdn."#".$mainkeyword."#".$CPPID."#".$PRICE."#".$PMARKNAME."#".$PD."#".$CPTID."#".$DT."#".$Resp_CGID."#".$Resp_REASON."#".$Resp_CODE."#".$Resp_CPTID."#".trim($response)."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logFile);
}
if(!empty($Resp_REASON))
echo "OK#".$Resp_REASON;
else
echo "OK#".'Request failed.Please try again later.';
?>