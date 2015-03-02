<?php
error_reporting(0);
include("incs/db.php");
//delete prev data process logs file
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
$processLogPathPrev="/var/www/html/hungamacare/2.0/MTSCricketEvent/activeBase/filestatus/MTSCricketProcess_".$prevdate.".txt";
if (file_exists($processLogPathPrev)) 
{
unlink($processLogPathPrev);
sleep(2);
}

$processLogPath="/var/www/html/hungamacare/2.0/MTSCricketEvent/activeBase/filestatus/MTSCricketProcess_".date("Ymd").".txt";
$fileLog1 = "Process Start at #".date('Y-m-d H:i:s')."\n";
error_log($fileLog1,3,$processLogPath);

$getMsisdnId="SELECT id FROM MTS_cricket.tbl_msg_history nolock WHERE status = 0 ORDER BY id desc LIMIT 1";
$result_id=mysql_query($getMsisdnId,$dbConn);
$batchList=array();
while(list($id1)=mysql_fetch_array($result_id))
{
$batchList[]=$id1;
$batchPicked="update MTS_cricket.tbl_msg_history set status=1 where id=".$id1;

if(mysql_query($batchPicked,$dbConn))
	{
	$BlockStatus=$batchPicked."|SUCCESS"."\r\n";
	}
	else
	{
	$error= mysql_error();
	$BlockStatus=$batchPicked."|".$error."|Failed"."\r\n";
	}
error_log($BlockStatus,3,$processLogPath);	
}
$totalcount=count($batchList);
$allIds = implode(",", $batchList);
if($totalcount>=1)
{
$smsFileQuery = "SELECT id,message,type,end_time,start_time,filename,senderId 
FROM MTS_cricket.tbl_msg_history WHERE id in($allIds) ORDER BY id";

$fileData1 = mysql_query($smsFileQuery,$dbConn);
while($fileData = mysql_fetch_array($fileData1))
{
$id = $fileData['id'];
$message = trim($fileData['message']);
$msgType = $fileData['type'];
$senderId = $fileData['senderId'];
$endTime = $fileData['end_time'];
$startTime = $fileData['start_time'];
$curndate=date('Y-m-d H:i:s');
$status=0;
$dnis='52444';


$uploaddir = "/var/www/html/hungamacare/2.0/MTSCricketEvent/activeBase/sms/";
$makFileName=$id."_".date('Y-m-d_His')."_log.txt";
$path = $uploaddir.$makFileName;
$isfile=false;

//Read active base data
$activeBaseFileName="activebase_".date('Ymd').'.txt';
$file_to_read="/var/www/html/hungamacare/2.0/MTSCricketEvent/activeBase/MTSSU/".$activeBaseFileName;
$file_data=file($file_to_read);
$file_size=sizeof($file_data);
$sizeOfFile=count($file_data);
$processSMS=false;
if($sizeOfFile>1)
{
$processSMS=true;
}
//Process SMS If Active Base is present
			if($processSMS)
			{
				for($i=0;$i<$sizeOfFile;$i++) {
					$msisdn='';
					$msisdn=$file_data[$i];
					$msisdnval_count_val = strlen($msisdn);
					if ($msisdnval_count_val == 12) {
						$msisdnval2 = substr($msisdn, 2);
					} else {
						$msisdnval2 = $msisdn;
					}

					$getCircle = "select master_db.getCircle(".trim($msisdnval2).") as circle";
					$circle1=mysql_query($getCircle,$dbConn);
					list($circle)=mysql_fetch_array($circle1);
					if(!$circle) { $circle='UND'; }
					if(trim($file_data[$i]!=9821124989))
					{
		$msgData = trim($file_data[$i])."#".$message."#".$curndate."#".$status."#".$dnis."#".'5'."#".$msgType."#".$circle."#".$startTime."#".$endTime."\r\n";
		error_log($msgData,3,$path);
					}

			}
			
//sleep(350);
if (file_exists($path)) {
    $fileishere= "The file $makFileName exists- ".$sizeOfFile;
	$isfile=true;
} else {
    $fileishere= "The file $makFileName does not exist- ".$sizeOfFile;
	$isfile=false;
	
	}

		$file_process_status = "batchid-".$id."#".$fileishere."#datetime#".date("Y-m-d H:i:s"). "\r\n";
		error_log($file_process_status,3,$processLogPath);
if($isfile)
{
$insertDump= 'LOAD DATA LOCAL INFILE "'.$path.'" 
INTO TABLE master_db.tbl_new_sms 
FIELDS TERMINATED BY "#" 
LINES TERMINATED BY "\n" 
(ani,message,date_time, status,dnis,flag, msg_type, circle, start_time, end_time)';
				


				if(mysql_query($insertDump,$dbConn))
				{
				$updateStatusPicked="update MTS_cricket.tbl_msg_history set status=2 where id=".$id;
				mysql_query($updateStatusPicked,$dbConn);
						$isupload=true;
						sleep(5);
						$updateWhitelisting="update master_db.tbl_new_sms  set status=5 where msisdn in('7838551197','9873710296','8373917355') and status=0";
						$updateResult=mysql_query($updateWhitelisting,$dbConn);
				      $file_process_status = 'Load Data query execute successfully for batchid-'.$id.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
					  error_log($file_process_status,3,$processLogPath);
				} 
				else 
				{
					$isupload=false;
					$error= mysql_error();
					$msg = $error;
					$updateStatusPicked="update MTS_cricket.tbl_msg_history set status=9 where id=".$id; //status 9 means fail
					mysql_query($updateStatusPicked,$dbConn);
					$file_process_status = 'batchid-'.$id.' Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
					error_log($file_process_status,3,$processLogPath);

				}	

}
else
{
			$updateStatusPicked="update MTS_cricket.tbl_msg_history set status=0 where id=".$id; //status 9 means fail
			mysql_query($updateStatusPicked,$dbConn);
			$file_process_status = 'batchid-'.$id.'File not ready. Please try again#datetime#'.date("Y-m-d H:i:s"). "\r\n";
			error_log($file_process_status,3,$processLogPath);
}				
			
			}
			else
			{ 
			//Not Process SMS If Active Base is not present
			$updateStatusPicked="update MTS_cricket.tbl_msg_history set status=0 where id=".$id; //status 9 means fail
			mysql_query($updateStatusPicked,$dbConn);
			$file_process_status = 'batchid-'.$id.'Active Base not found. Please try again#datetime#'.date("Y-m-d H:i:s"). "\r\n";
			error_log($file_process_status,3,$processLogPath);
			}
			//error_log($file_process_status,3,$processLogPath);
}
echo "Send SMS";
} else {
	echo "Files are not available";
}
$fileLog1 = "Process End at #".date('Y-m-d H:i:s')."\n";
error_log($fileLog1,3,$processLogPath);
mysql_close($dbConn);
?>