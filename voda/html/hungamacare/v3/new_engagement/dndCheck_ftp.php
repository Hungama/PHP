<?php

error_reporting(0);
$filename = $filepathdndcheck;
$filename_new = $filepathdndcheck_csv;

$ftp_server = '10.2.34.54:8080';
$ftp_user_name = 'vgt';
$ftp_user_pass = 'Vgt_Ndnc';

$file = $filename;
$log_path_ftp = 'logs/processFtpBase_' . date("Ymd") . '.txt';
$logData_ftp = 'Process start at ' . date("H:i:s") . "\r\n";
error_log($logData_ftp, 3, $log_path_ftp);

$conn_id = ftp_connect($ftp_server, '119.82.69.215'); //ftp_connect($ftp_server, 2121);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
if (!$conn_id || !$login_result) {
    die('Connection attempt failed!');
}
$logData_ftp = 'File copied to FTP location start at ' . date("H:i:s") . "\r\n";
error_log($logData_ftp, 3, $log_path_ftp);
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
    echo "successfully uploaded $file\n";
} else {
    echo "There was a problem while uploading $file\n";
}
$logData_ftp = 'File copied to FTP location end at ' . date("H:i:s") . "\r\n";
error_log($logData_ftp, 3, $log_path_ftp);
sleep(240);
$logData = 'File copied from FTP location start at ' . date("H:i:s") . "\r\n";
error_log($logData_ftp, 3, $log_path_ftp);

shell_exec("sh getftpfile_csv.sh $dndcheckfile");

$logData = 'File copied from FTP location end at ' . date("H:i:s") . "\r\n";
error_log($logData_ftp, 3, $log_path_ftp);
?>