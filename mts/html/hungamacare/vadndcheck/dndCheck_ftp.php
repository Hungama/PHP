<?php
error_reporting(0);
//$getActivebBaseForScrub='/var/www/html/hungamacare/vadndcheck/activebase/1VA_07042014125846.txt';
//$filepathdndcheckOutput='1VA_OUT_07042014125846.txt';;
$ftp_server = '192.168.100.238';
$ftp_user_name = 'vgt';
$ftp_user_pass = 'Vgt_Ndnc';


$conn_id = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
if (!$conn_id || !$login_result) {
    die('Connection attempt failed!');
}
if (ftp_put($conn_id, $remote_file, $getActivebBaseForScrub, FTP_ASCII)) {
    echo "successfully uploaded $file\n";
} else {
    echo "There was a problem while uploading $file\n";
}
sleep(300);
shell_exec("sh getftpfile.sh $filepathdndcheckOutput");
?>