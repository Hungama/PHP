<?php  
ini_set('display_error',0);
//error_reporting(E_ALL);
require_once("db.php");
$msisdn=$_REQUEST['msisdn'];
$operator=$_REQUEST['operator'];
$circle=$_REQUEST['circle'];
$text=$_REQUEST['txt'];
$logFile="log/requestContest_".date('Ymd').".txt";
$logFile1="log/requestContestAPI_".date('Ymd').".txt";
$logPath="log/AllRequestBNB_".date('Ymd').".txt";
$logData=$msisdn."#".$operator."#".$circle."#".$text."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logFile);
//log all request parameter start here
$filePointer1=fopen($logPath,'a+');
chmod($logPath,0777);
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


//$smskeyword=explode("bnb",$text);
$smskeyword=explode(" ",$text);
$mainkeyword=$smskeyword[0];
$subkeyword=$smskeyword[1];

if($subkeyword=='1' || $subkeyword=='2' || $subkeyword=='3'|| $subkeyword=='4')
{
echo "OK#"."Correct Answer.";
}
else if(!empty($subkeyword))
{
//query to get data from database.
$query="SELECT response FROM master_db.tbl_bnb_sms WHERE sms_keyword='".$subkeyword."' and status=1 limit 1";
$result = mysql_query($query);
$data = mysql_fetch_array($result);
if($data['response'])
echo "OK#".$data['response'];
else
echo "OK#".'This is an Invalid Keyword.';

$logData=$msisdn."#".$query."#".$data['response']."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logFile1);
}
else
{
//query to get data from database.
$query="SELECT response FROM master_db.tbl_bnb_sms WHERE sms_keyword='".$text."' and status=1 limit 1";
$result = mysql_query($query);
$data = mysql_fetch_array($result);
echo "OK#".$data['response'];
$logData=$msisdn."#".$query."#".$data['response']."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logFile1);
}
mysql_close($con);
//echo "OK#"."THANK YOU FOR CONTACTING BRAIN N BRAND LLP. TO KNOW MORE ABOUT US PLEASE LOG ON TO WWW.BNB.ORG.IN";
?>