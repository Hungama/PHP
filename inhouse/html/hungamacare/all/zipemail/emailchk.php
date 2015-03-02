<?php
session_start();
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
//craete a file from data base and then send it for zip file
$curdate = date("Y_m_d-H_i_s");
$path='datazipfile_'.$curdate.'.txt';
$files_to_zip = array($path);
//make db connection to fetch data from database and the write it in to file.
 $DB_HOST_M224     = '192.168.100.224'; //'172.28.106.4'; //DB HOST
 $DB_USERNAME_M224 = 'webcc';  //DB Username
 $DB_PASSWORD_M224 = 'webcc';  //DB Password 'Te@m_us@r987';
 $DB_DATABASE_M224 = 'master_db';  //Datbase Name  hul_hungama
 $db_m224 = $DB_DATABASE_M224;
$dbConn = mysql_connect($DB_HOST_M224,$DB_USERNAME_M224,$DB_PASSWORD_M224);
if (!$dbConn)
 {
  die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
	$sql_getmsisdnlist = mysql_query("select batch_id,channel from master_db.bulk_upload_history limit 10");
	while($result_data = mysql_fetch_array($sql_getmsisdnlist))
				{
$getdatafile=$result_data['batch_id']."#".$result_data['channel']."\r\n";
error_log($getdatafile,3,$path);			
				}
mysql_close($dbConn);


$result = create_zip($files_to_zip,'datazipfile_'.$curdate.'.zip');

$path1='datazipfile_'.$curdate.'.zip';
unlink($path);
$to = 'satay.tiwari@hungama.com';
$subject = "Airtel Spoken English Retailer Dump";
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
 <tr bgcolor="#DFE3EB"><td style="font-family:Verdana, Arial; font-size:11px; color:#333333;width:200px;">Testing Email</td><td><?php echo 'Testing' ?></td></tr></table>
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
$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "Mail sent" : "Mail failed";

?>