<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
//$PrevDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($PrevDate));
//$curdate = date("Ymd",strtotime($PrevDate));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

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
//tbl_mcdowell_pushobd_promotion_6   
//tbl_mcdowell_success_fail_promotion_details_6oct   //tbl_mcdowell_success_fail_promotion_details
$tablename='Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_promotion_details';
$filepath = 'McwPromotionalBase_' . $curdate . '.csv';
$fp=fopen($filepath,'a+');
fwrite($fp,'Msisdn'.','.'Circle'.','.'Duration'.','.'ActualDuration'.','.'DateTime'.','.'Dial-DID'."\r\n");
  $getwinner_query="select ani,circle,duration,actual_duration,date_time,dial_did from $tablename nolock where date(date_time)='".$PrevDate."' and status=2 and ANI!=''";
	$result_winner = mysql_query($getwinner_query, $dbConn) or die(mysql_error());
	$result_row_winner = mysql_num_rows($result_winner);	
	if ($result_row_winner > 0) {
			while ($result_data = mysql_fetch_array($result_winner))
				  {
			fwrite($fp,$result_data['ani'].','.$circle_info[$result_data['circle']].','.$result_data['duration'].','.$result_data['actual_duration'].','.$result_data['date_time'].','.$result_data['dial_did']."\r\n");
				 }
		}
sleep(10);
		$path = $filepath;
            $files_to_zip = array($path);
            $newZip = 'McwPromotionalBase_' . $curdate . '.zip';

           create_zip($files_to_zip, $newZip);
            sleep(2);
		
//$queryUniqueSubscribersAttempted="select count(distinct ANI) from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_promotion nolock where date(obd_sent_date_time)='".$PrevDate."' and status!=0";
$queryUniqueSubscribersAttempted="select count(distinct ANI) from $tablename nolock where date(date_time)='".$PrevDate."'";
$result1=mysql_query($queryUniqueSubscribersAttempted, $dbConn);
list($TotalUniqueSubscribersAttempted) = mysql_fetch_array($result1);

$queryUniqueSubscribersConnected="select count(distinct ANI) from $tablename nolock where date(date_time)='".$PrevDate."' and status=2";
$result2=mysql_query($queryUniqueSubscribersConnected, $dbConn);
list($TotalUniqueSubscribersConnected) = mysql_fetch_array($result2);

$queryDurationConnected="select sum(duration) as Totalduration from $tablename nolock where date(date_time)='".$PrevDate."' and status=2";
$result3=mysql_query($queryDurationConnected, $dbConn);
list($TotalDuration) = mysql_fetch_array($result3);

$queryStarPressed="select count(ANI) as TotalPressed from Hungama_ENT_MCDOWELL.tbl_AgeVerification_Promo nolock where date(LastUpdateDate)='".$PrevDate."' and isAgeVerified=1";
$result4=mysql_query($queryStarPressed, $dbConn);
list($TotalStarPressed) = mysql_fetch_array($result4);

$queryStarPressedSkip="select count(ANI) as TotalPressed from Hungama_ENT_MCDOWELL.tbl_AgeVerification_Promo nolock where date(LastUpdateDate)='".$PrevDate."' and isAgeVerified=2";
$result5=mysql_query($queryStarPressedSkip, $dbConn);
list($TotalStarPressedSkip) = mysql_fetch_array($result5);


$TotalOBDfailure=$TotalUniqueSubscribersAttempted-$TotalUniqueSubscribersConnected;
	
$ctime=date("d,D M H A");
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
 $message .= "<tr><td colspan='8' align='center' >Service Alert - Enterprise - McDowells</td></tr>";
 $message .= "<tr> <td height='47' colspan='8' align='center' ><strong>EnterpriseMcDw - $ctime</strong></td></tr>";
if($i%2==0)
{
$class2='valign="middle" bgcolor="#f2f2f2" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
$class1='valign="middle" bgcolor="#f2f2f2" style="border-left: 1px solid #666;border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
}
else
{
$class2='valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
$class1='valign="middle" bgcolor="#FFFFFF" style="border-left: 1px solid #666;border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
}
$message .= "<tr><td $class1>Total Unique Subscribers Attempted</td><td $class2>".number_format($TotalUniqueSubscribersAttempted)."</td></tr>";
$message .= "<tr><td $class1>Total Unique Subscribers Connected</td><td $class2>".number_format($TotalUniqueSubscribersConnected)."</td></tr>";
$message .= "<tr><td $class1>Total OBD failure</td><td $class2>".number_format($TotalOBDfailure)."</td></tr>";
$message .= "<tr><td $class1>Total Seconds consumed</td><td $class2>".number_format($TotalDuration)."</td></tr>";
$message .= "<tr><td $class1>Total Unique Subscribers who Confirmed (Pressed Star)</td><td $class2>".number_format($TotalStarPressed)."</td></tr>";
$message .= "<tr><td $class1>Total Unique Subscribers who skipped age verification</td><td $class2>".number_format($TotalStarPressedSkip)."</td></tr>";


$message .= "</table>";
$message .="</body></html>";



//echo $message;
//$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
$htmlfilename='emailcontent_'.$curdate.'.html';

$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>