<?php  
ini_set('display_error',1);
$dbConn_224 = mysql_connect("192.168.100.224","webcc","webcc");
if (!$dbConn_224)
 {
 echo '224- Could not connect';
 die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
$msisdn=$_REQUEST['msisdn'];
$operator=$_REQUEST['operator'];
$circle=$_REQUEST['circle'];
$text=$_REQUEST['txt'];
$mode='SMS';
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
	$total_score=$total_score+1;
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