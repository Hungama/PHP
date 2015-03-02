<?php  
ini_set('display_error',1);
$dbConn_224 = mysql_connect("192.168.100.224","webcc","webcc");
if (!$dbConn_224)
 {
 echo '224- Could not connect';
 die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
$msisdn=$_REQUEST['msisdn'];
if(strlen($msisdn)==12)
	{
	if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
	}
	
	

	
$operator=$_REQUEST['operator'];
$circle=$_REQUEST['circle'];
$text=$_REQUEST['txt'];
$mode='SMS';
$operator='UNINOR';
$subkeyword=$text;
$KeywordTrnasactionReport="/var/www/html/hungamacare/contest/API/logs/keywords_".date('Ymd').".txt";
$req_received=date("Y-m-d H:i:s");


$logFile="/var/www/html/hungamacare/contest/API/logs/requestContest_".date('Ymd').".txt";
$logFile1="/var/www/html/hungamacare/contest/API/logs/requestContestAPI_".date('Ymd').".txt";

$logPath="/var/www/html/hungamacare/contest/API/logs/AllRequestBNB_".date('Ymd').".txt";
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
switch($operator)
{
	case 'UNINOR':
		$sc='54646';
		$db="Hungama_BNB";
		$getdataProcedure="BNB_CONTEST_GET";
		$setdataProcedure="BNB_CONTEST_SET";
		$DIFFLEVEL=1;
		$con = mysql_connect("192.168.100.224","webcc","webcc");//UNINOR
	break;
	
}

if($subkeyword=='1' || $subkeyword=='2' || $subkeyword=='3'|| $subkeyword=='4')
{
$user_anskey=$subkeyword;
//make a call to check answer
	$qry="CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "','" . $operator . "',@id)";
	mysql_query("CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "','" . $operator . "',@id)",$con);
	$logData="Check Answer#".$qry."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logFile1);
	$contest_data  = mysql_query("SELECT @id",$con);
	while($row=mysql_fetch_row($contest_data))
		{
			$responsedata=explode("#",$row[0]);
			$ques_no=$responsedata[0];
			$ques_desc=$responsedata[2];
			$ans_key=$responsedata[3];
			$total_score=$responsedata[4];
			$availble_ques=$responsedata[5];
			$DIFFLEVEL=$responsedata[7];
		}
		
	$duration="5";
	if($ans_key==$user_anskey)
	{
	$msg="Correct Answer";
	$IN_FLAG='1';
	$total_score=$total_score+10;
	$ansMsg='Correct ans. Your total points is '.$total_score;
	}
	else
	{
	$msg="Wrong Answer";
	$IN_FLAG='2';
	$total_score=$total_score+0;
	$ansMsg='Incorrect ans. Your total points is '.$total_score;
	}
	mysql_query("CALL " . $db . "." . $setdataProcedure . "($msisdn,'".$DIFFLEVEL."','".$total_score."','".$user_anskey."','".$IN_FLAG."','" . $duration . "')",$con);
	$qry="CALL " . $db . "." . $setdataProcedure . "($msisdn,'".$DIFFLEVEL."','".$total_score."','".$user_anskey."','".$IN_FLAG."','" . $duration . "')";
	$logData="After Check Answer#".$qry."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logFile1);
	$logData=$msisdn."#".$serviceId."#Available#".$availble_ques."#".$reqtype."#TotalScore:".$total_score."#AnsKey:".$ans_key."#UserAnswerKey:#".$user_anskey."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logFile1);
	//send req to get more question   			
	$qry="CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "','" . $operator . "',@id)";
	mysql_query("CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "','" . $operator . "',@id)",$con);
	$contest_data  = mysql_query("SELECT @id",$con);
	$logData="Get Next Question-#".$qry."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logFile1);
	while($row=mysql_fetch_row($contest_data))
		{
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
		$response=$ansMsg."\n".'Q. '.$ques_desc."\n";
		}
	$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#Available#".$availble_ques."#DiffLevel:".$DIFFLEVEL."#CorrectAns:".$ans_key."#".$response."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logFile1);
		
echo "OK#"."\n".$response;
$res_submited=date("Y-m-d H:i:s");
$logData_keyword=$msisdn."#".$operator."#".$circle."#".$mainkeyword."#".$subkeyword."#".$req_received."#".$res_submited."\n";
error_log($logData_keyword,3,$KeywordTrnasactionReport);

}
else
{
//query to get data from database.
$res_submited=date("Y-m-d H:i:s");
$logData_keyword=$msisdn."#".$operator."#".$circle."#".$mainkeyword."#".$subkeyword."#".$req_received."#".$res_submited."\n";
error_log($logData_keyword,3,$KeywordTrnasactionReport);

	$qry="CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "','" . $operator . "',@id)";
	$res= mysql_query("CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "','" . $operator . "',@id)",$con);
	$contest_data  = mysql_query("SELECT @id",$con);
	while($row=mysql_fetch_array($contest_data))
		{
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

if(!empty($response))
echo "OK#".$response;
else
echo "OK#".'This is an Invalid Keyword.';

$logData=$msisdn."#".$query."#".$data['response']."#".$qry."#".$response."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logFile1);
}
mysql_close($dbConn_224);
mysql_close($con);
?>