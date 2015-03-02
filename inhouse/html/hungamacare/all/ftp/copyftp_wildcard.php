<?php
error_reporting(0);
$ftp_server='119.82.69.215';
$ftp_user_name='vgt';
$ftp_user_pass='Vgt_Ndnc';
$file = 'logs/testftp21.txt';
$remote_file = 'testftp21.txt';

// set up basic connection
$conn_id = ftp_connect($ftp_server);
// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
if (!$conn_id || !$login_result) { die('Connection attempt failed!'); }

// upload a file on remote FTP Server
/*
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "successfully uploaded $file\n";
} else {
 echo "There was a problem while uploading $file\n";
}
*/
//sleep(10);
//$one = $_REQUEST["term"] . "%";
$local_file='logs/out/testftp21_SCRUB2.txt';
//$server_file="output/testftp21_*";
//$server_file = glob("testftp21_SCRUB140121231206.*");
$server_file="/^testftp21_/";

$server_file_path="output/".$server_file;

// try to download $server_file and save to $local_file
if (ftp_get($conn_id, $local_file, $server_file_path, FTP_BINARY)) {
    echo "Successfully written to $local_file\n";
} else {
    echo "There was a problem\n";
}
/*
if(copy('ftp://vgt:Vgt_Ndnc@119.82.69.215/output/testftp21_SCRUB140121231206.txt','logs/out/testftp21_SCRUB.txt')) {
  echo "Copy output file from remote FTP Location..!";
}
*/

// close the connection
ftp_close($conn_id);
?>