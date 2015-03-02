#!/bin/sh
#Shell Script for createBulkFileSummary
echo "Start `date` " >> createBulkFileSummary.txt
#/usr/bin/php /var/www/html/hungamacare/bulkuploadcreatelog.php & 
/usr/bin/php /var/www/html/hungamacare/createBulkLogFile_qa.php & 
echo "End  `date` " >> createBulkFileSummary.txt