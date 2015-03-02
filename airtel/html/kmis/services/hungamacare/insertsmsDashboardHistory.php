<?php
        include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
//Path- /home/ivr/javalogs/BillingMnger/SMS/YYYYMM/YYYYMMDD.log
//Server – 156-158
            $fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
			$basepath="/home/ivr/javalogs/BillingMnger/SMS/".date("Ym")."/";
			$filename=$fileDate.".log";
			echo $filePath=$basepath.$filename;
			$insertDump = 'LOAD DATA LOCAL INFILE "' . $filePath . '" INTO TABLE Airtel_tmp.smsdashboardhistory FIELDS TERMINATED BY "#" LINES TERMINATED BY "\n" 	(datetime,filename,transactionid,msisdn,message,systemtime,cli,message_type,operator,circle,status,dnd_status)';
			if(mysql_query($insertDump,$dbConn))
			{
			$file_process_status = 'Data saved successfully';
			}
			else
			{
			$error= mysql_error();
			$file_process_status = 'Load Dara Error-'.$error;
			}

mysql_close($dbConn);
//insert data on  MTS database			
echo "done";
?>