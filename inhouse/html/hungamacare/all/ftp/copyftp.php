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
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "successfully uploaded $file\n";
} else {
 echo "There was a problem while uploading $file\n";
}

//sleep(10);
$local_file='logs/out/testftp21_SCRUB140121230538.txt';
$server_file='output/testftp21_SCRUB140121230538.txt';
// try to download $server_file and save to $local_file
if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
    echo "Successfully written to $local_file\n";
} else {
    echo "There was a problem\n";
}


// close the connection
ftp_close($conn_id);
/*
echo date('h:i:s') . "\n";
if(copy('logs/testftp2014.txt', 'ftp://vgt:Vgt_Ndnc@119.82.69.215/testftp2014.txt')) {
  echo "Copy to remote FTP Location..!";
}
// sleep for 10 seconds
sleep(10);
// wake up !
if(copy('ftp://vgt:Vgt_Ndnc@119.82.69.215/output/testftp2014_SCRUB140102153402.txt','logs/testftp2014_out.txt')) {
  echo "Copy output file from remote FTP Location..!";
}
echo date('h:i:s') . "\n";
*/
?>