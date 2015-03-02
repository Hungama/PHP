<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$curdate = date("Ymd");

///////////////////////////////////////// code start for create zip file function //////////////////////////////////////////////////
function create_zip($files = array(), $destination = '', $overwrite = false) {
    //if the zip file already exists and overwrite is false, return false
    if (file_exists($destination) && !$overwrite) {
        return false;
    }
    //vars
    $valid_files = array();
    //if files were passed in...
    if (is_array($files)) {
        //cycle through each file
        foreach ($files as $file) {
            //make sure the file exists
            if (file_exists($file)) {
                $valid_files[] = $file;
            }
        }
    }
    //if we have good files...
    if (count($valid_files)) {
        //create the archive
        $zip = new ZipArchive(); //bool ZipArchive::addFile ( string $filename [, string $localname ] )
        if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            return false;
        }
        //add the files
        foreach ($valid_files as $file) {
            $zip->addFile($file, $file);
        }
        //debug
        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
        //close the zip -- done!
        $zip->close();

        //check to make sure the file exists
        return file_exists($destination);
    } else {
        return false;
    }
}

///////////////////////////////////////// code end for create zip file function/////////////////////////////////////////////////////


$filepath = 'UninorSUActiveBase_' . $curdate . '.txt';
$fp=fopen($filepath,'a+');
fwrite($fp,'Msisdn'."\r\n");
  $getwinner_query="select ANI from uninor_cricket.tbl_cricket_subscription nolock where status=1";
	$result_winner = mysql_query($getwinner_query, $dbConn) or die(mysql_error());
	$result_row_winner = mysql_num_rows($result_winner);	
	if ($result_row_winner > 0) {
			while ($result_data = mysql_fetch_array($result_winner))
				  {
			fwrite($fp,$result_data['ANI']."\r\n");
				 }
		}
sleep(10);
		$path = $filepath;
            $files_to_zip = array($path);
            $newZip = 'UninorSUActiveBase_' . $curdate . '.zip';

           create_zip($files_to_zip, $newZip);
            sleep(2);
		
$message ='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= "<table rules='all' style='border-color: #666;font-size:12px;width:100%' border='0' cellpadding='2'>
<tr><td>Hi All,<br><br>
Please find attached base of UninorSU for $reportdate.<br><br>
</td></tr></table>";
	
$message .="</body></html>";
//echo $message;
$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>