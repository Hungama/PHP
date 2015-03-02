<?php
error_reporting(0);
$ftp_server='119.82.69.215';
$ftp_user_name='vgt';
$ftp_user_pass='Vgt_Ndnc';
$file = 'logs/181_18-01_08-2014.txt';
$remote_file = '181_18-01_08-2014.txt';
$dndcheckfile='181_18-01_08-2014';
$log_path = 'logs/processtime_' . date("Ymd") . '.txt';
$logData = 'Process start at ' .date("H:i:s") ."\r\n";
error_log($logData, 3, $log_path);

// file copy to ftp location start here
// set up basic connection
$conn_id = ftp_connect($ftp_server);
// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
if (!$conn_id || !$login_result) { die('Connection attempt failed!'); }
// upload a file on remote FTP Server
$logData = 'File copied to FTP location start at ' .date("H:i:s") ."\r\n";
error_log($logData, 3, $log_path);
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "successfully uploaded $file\n";
} else {
 echo "There was a problem while uploading $file\n";
}
$logData = 'File copied to FTP location end at ' .date("H:i:s") ."\r\n";
error_log($logData, 3, $log_path);
// file copy to ftp location end here
sleep (50);
$logData = 'File copied from FTP location start at ' .date("H:i:s") ."\r\n";
error_log($logData, 3, $log_path);
shell_exec("sh getftpfile.sh $dndcheckfile");
$logData = 'File copied from FTP location end at ' .date("H:i:s") ."\r\n";
error_log($logData, 3, $log_path);
?>