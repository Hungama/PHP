<?php
	       $con = mysql_connect("119.82.69.210","Shashank","Shashank123");
	       error_reporting(ALL);
	      if(!$con)
           {
		     die('could not connect1: ' . mysql_error());
		    }
            echo "Connection Established";
			$view_date1= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
			//$view_date1='20120213';
			echo $view_date1;
			$filedir="/var/www/html/TataSong/";
			$filename='Calling_Data_'.$view_date1.'.csv';
			echo $filename;
			$filedata=file($filename);
			//print_r($filedata);
			$size=count($filedata);
			$filesize=$size-1;
			//echo $filesize;
			for ($i=0; $i<=$filesize; $i++ )
			{   
				$output=explode(',',$filedata[$i]);
				//print_r($output);
				if(trim($output[0])!= " ")
				{
					
					echo $sql="insert into  mis_db.IVR_MIS_TATASONGBOOK(transaction_id,start_date,MSISDN ,duration,circle,DNIS) values ('".trim($output[0])."','".trim($output[1])."','".trim($output[2])."','".trim($output[3])."','".trim($output[4])."','".trim($output[5])."')";

				/*	echo $sql="insert into  mis_db.TataSong_Intial_Data(TransactionID,TXNDATE,MSISDN ,DURATION_SEC,CIRCLE,DNIS) values ('".trim($output[0])."','".trim($output[1])."','".trim($output[2])."','".trim($output[3])."','".trim($output[4])."','".trim($output[5])."')";*/
					
					echo $sql;
					//$sql .= trim($output[3])."','".trim($output[4])."','".trim($output[5])."')";
					echo "Data Inserted for ";
					echo $view_date1;
					mysql_query($sql,$con) or die(mysql_error()); 
					
				//echo "Database connection Closed" ;
				// end of if(trim($output[2])!= " ")
				} 
				
				else
				{
					echo "no" ;
				}
			}
?>
				
