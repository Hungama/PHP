<?php  
ini_set('display_error',0);
include_once("/var/www/html/hungamacare/BNB/API/contestApi.php");
exit;
//error_reporting(E_ALL);
$dbConn_224 = mysql_connect("192.168.100.224","webcc","webcc");
if (!$dbConn_224)
 {
 echo '224- Could not connect';
 die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
$mode='SMS';
 //$con = mysql_connect('10.2.73.160', 'team_user','Te@m_us@r987'); //Airtel
 //$con = mysql_connect('database.master_mts', 'billing','billing'); //MTS
$msisdn=$_REQUEST['msisdn'];
$operator=$_REQUEST['operator'];
$circle=$_REQUEST['circle'];
$text=$_REQUEST['txt'];

$logFile="/var/www/html/hungamacare/BNB/logs/SMS/".$operator."/requestContest_".date('Ymd').".txt";
$logFile1="/var/www/html/hungamacare/BNB/logs/SMS/".$operator."/requestContestAPI_".date('Ymd').".txt";

$logPath="/var/www/html/hungamacare/BNB/logs/SMS/AllRequestBNB_".date('Ymd').".txt";
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
//919930069715#VODAFONE#MUMBAI#bnb CONTEST#2013-10-24 18:25:53
switch($operator)
{
	case 'VODAFONE':
		$sc='54646';
		$db="Hungama_BNB";
		$getdataProcedure="BNB_CONTEST_GET";
		$setdataProcedure="BNB_CONTEST_SET";
		$DIFFLEVEL=1;
		$con = mysql_connect('203.199.126.129', 'team_user','teamuser@voda#123'); //Voda
	break;
}



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
$result = mysql_query($query,$dbConn_224);
$data = mysql_fetch_array($result);

if($subkeyword=='CONTEST')
{
	$qry="CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "','" . $operator . "',@id)";
	$res= mysql_query("CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "','" . $operator . "',@id)",$con);
	$contest_data  = mysql_query("SELECT @id",$con);
	while($row=mysql_fetch_array($contest_data))
		{//76#01_HUN-CON-000068#Indian Government ke dwar veerta ke liye kaun sa sabse bada samman diya jata hai?Shaurya Chakra, Maha vir Chakra, Param Vir Chakra, Kirti Chakra#3#0#7#HPD#1#
			$responsedata=explode("#",$row[0]);
			$ques_no=$responsedata[0];
			$ques_desc=$responsedata[2];
			$ans_key=$responsedata[3];
			$total_score=$responsedata[4];
			$availble_ques=$responsedata[5];
			$DIFFLEVEL=$responsedata[7];
		}
		if($availble_ques>=1)		
		{
		$response='Q. '.$ques_desc."\n";
		}
}

if($data['response'])
echo "OK#".$data['response'].$response;
else
echo "OK#".'This is an Invalid Keyword.';

$logData=$msisdn."#".$query."#".$data['response']."#".$qry."#".$response."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logFile1);
}
else
{
//query to get data from database.
$query="SELECT response FROM master_db.tbl_bnb_sms WHERE sms_keyword='".$text."' and status=1 limit 1";
$result = mysql_query($query,$dbConn_224);
$data = mysql_fetch_array($result);
echo "OK#".$data['response'];
$logData=$msisdn."#".$query."#".$data['response']."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logFile1);
}
mysql_close($dbConn_224);
mysql_close($con);
//echo "OK#"."THANK YOU FOR CONTACTING BRAIN N BRAND LLP. TO KNOW MORE ABOUT US PLEASE LOG ON TO WWW.BNB.ORG.IN";
?>