<?php
// current time
error_reporting(0);
echo date('h:i:s') . "\n";
if(copy('ftp://Hungama_IVRSugarCane:aerial,door.lunacy@180.178.28.76/IVR/GetBal_2014-01-20~13.txt.gz','logs/GetBal_2014-01-20~13.txt.gz')) {
  echo "Copy output file from remote FTP Location..!";
}
echo date('h:i:s') . "\n";
?>