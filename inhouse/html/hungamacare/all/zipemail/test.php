<?php
session_start();
error_reporting(0);
//update charging details start here
$updateStatus="http://10.2.73.156/airtel/updateChrgAmntReferMode.php";
file_get_contents($updateStatus);
//10 sec
sleep(120);
//end here
date_default_timezone_set('Asia/Calcutta');
$pname='satay';
$today = date("y-n-j");
$todaytime = date("H:i:s");
$dattime=$today." ".$todaytime;
//gete data from database and then create zip file.
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}


//if true, good; if false, zip creation failed
//craete a file from data base and then send it for zip file  Airtel_SE_Retailer_UPW_ 
$curdate = date("Y_m_d-H_i_s");
$path='Airtel_SE_Retailer_UPW_'.$curdate.'.csv';
$files_to_zip = array($path);
//make db connection to airtel db to fetch data ussd refer and the write it in to file.
$con = mysql_connect('10.2.73.160', 'team_user','Te@m_us@r987');
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
	$sql_getreferdata = mysql_query("select ANI,friendANI,referDate,endDate,service_id,referfrom,userCircle,status,chrgAmount from master_db.tbl_refer_ussdData where date(referDate)='".$prevdate."' and userCircle='UPW'",$con);
	$totalnoofrecords= mysql_num_rows($sql_getreferdata);
	$getdatafile='Retailer ANI'."#".'Refer ANI'."#".'Refer Date'."#".'EndDate'."#".'Service Id'."#".'Refer From'."#".'Circle'."#".'Status'."#".'Charge Amount'."\r\n";
//error_log($getdatafile,3,$path);

		$fp=fopen($path,'a+');
fwrite($fp,'Retailer ANI'.','.'Refer ANI'.','.'Refer Date'.','.'EndDate'.','.'Service Id'.','.'Refer From'.','.'Circle'.','.'Status'.','.'Charge Amount'."\r\n");

	while($result_data = mysql_fetch_array($sql_getreferdata))
				{
//$getdatafile=$result_data['ANI']."#".$result_data['friendANI']."#".$result_data['referDate']."#".$result_data['endDate']."#".$result_data['service_id']."#".$result_data['referfrom']."#".$result_data['userCircle']."#".$result_data['status']."#".$result_data['chrgAmount']."\r\n";
//error_log($getdatafile,3,$path);			
	fwrite($fp,$result_data['ANI'].','.$result_data['friendANI'].','.$result_data['referDate'].','.$result_data['endDate'].','.$result_data['service_id'].','.$result_data['referfrom'].','.$result_data['userCircle'].','.$result_data['status'].','.$result_data['chrgAmount']."\r\n");
	}
mysql_close($con);


$result = create_zip($files_to_zip,'Airtel_SE_Retailer_UPW_'.$curdate.'.zip');

$path1='Airtel_SE_Retailer_UPW_'.$curdate.'.zip';
unlink($path);
$to = 'satay.tiwari@hungama.com';
$subject = "Airtel Spoken English Retailer Dump of date ".$prevdate;
$random_hash = md5(date('r', time()));
$headers = "From: Voice<voice.mis@hungama.com>\r\nReply-To: voice.mis@hungama.com";
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
$attachment = chunk_split(base64_encode(file_get_contents($path1)));
ob_start(); //Turn on output buffering
?>

--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/plain; charset="UTF-8"
Content-Transfer-Encoding: 7bit

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/html; charset="UTF-8"
Content-Transfer-Encoding: 7bit
<html>
<body>
<table cellspacing="2" cellpadding="8" border="0" width="800">
 <tr><td style="font-family:Verdana, Arial; font-size:11px; color:#333333;width:200px;">Airtel Spoken English Retailer Dump - Total no of records <?php echo $totalnoofrecords;?></td></tr></table>
</body></html>
--PHP-alt-<?php echo $random_hash; ?>--

--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: application/doc; name="<?php echo $path1;?>" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

<?php echo $attachment; ?>
--PHP-mixed-<?php echo $random_hash; ?>--
<?php
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
$path_log='logs/Airtel_SE_Retailer_UPW_EmailReport_'.date("Y-m-d").'.txt';
$mail_sent = @mail( 'satay.tiwari@hungama.com', $subject, $message, $headers );
if($mail_sent)
{
$logdata='Mail sent - satay.tiwari@hungama.com'."#".date("Y-m-d H:i:s")."\r\n";
}
else
{
$logdata='Mail failed- satay.tiwari@hungama.com'."#".date("Y-m-d H:i:s")."\r\n";
}

//save log here 
echo 'done';
//delete zip file from server
unlink($path1);
?>