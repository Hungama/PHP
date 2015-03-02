<?php
// current time
error_reporting(0);
echo date('h:i:s') . "\n";
if(copy('logs/testftp2014.txt', 'ftp://vgt:Vgt_Ndnc@119.82.69.215/testftp2014.txt')) {
  echo "Copy to remote FTP Location..!";
}
// sleep for 10 seconds
sleep(30);
// wake up !
if(copy('ftp://vgt:Vgt_Ndnc@119.82.69.215/output/testftp2014_SCRUB140102153402.txt','logs/testftp2014_out.txt')) {
  echo "Copy output file from remote FTP Location..!";
}
echo date('h:i:s') . "\n";
?>