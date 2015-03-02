<?php
$ftp_server='192.168.100.238';
$ftp_user_name='vgt';
$ftp_user_pass='Vgt_Ndnc';

$file = 'logs/testftp.txt';
$remote_file = 'testftp.txt';

//$conn_id = ftp_connect($ftp_server);
$conn_id = ftp_connect("10.2.34.54",8080);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
if (!$conn_id || !$login_result)
 { die('Connection attempt failed!');
}
else
{
echo "connected";
}

// upload a file on remote FTP Server
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "successfully uploaded $file\n";
} else {
 echo "There was a problem while uploading $file\n";
}

?>
