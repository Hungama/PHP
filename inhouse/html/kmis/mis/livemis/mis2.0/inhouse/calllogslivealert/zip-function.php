<?php
error_reporting(1);
ob_clean();

///////////////////////////////////////// code start for create zip file function @jyoti.porwal /////////////////////////////////////////////////////
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

/*
///////////////////////////////////////// code end for create zip file function @jyoti.porwal /////////////////////////////////////////////////////
$nowtime = date('H:i');
$nowtime = date('h:i A', strtotime($nowtime));
$log_path = 'logs/FILTERED_BASE_' . date("Y_m_d") . '.txt';
$curdate = date("d-m-Y_His");
//$filepathdndcheck = 'callogs/' . $rule_id . '_' . $curdate . '.txt';
$filepathdndcheck_csv = 'callogs/' . $rule_id . '_' . $curdate . '.csv';
            
//////////////////////////////////////////////////////////////////////////////// code start for zip //////////////////////////////////////////////////////
$path = $filepathdndcheck_csv;
$files_to_zip = array($path);
 $newZip = 'Email_Rule_Execution_' . $rule_id . '_' . $curdate . '.zip';
$target_path = "dndcheck/";
$target_path = $target_path . $newZip;
create_zip($files_to_zip, $newZip);
sleep(2);
if (copy($newZip, $target_path)) {
echo "Yes";
unlink($newZip);
} else {
echo "No";
}










$filename = 'Email_Rule_Execution_' . $rule_id . '_' . $curdate . '.zip';
$path1 = 'http://119.82.69.212/kmis/services/hungamacare/EngagemnentBox/UNINOR_NEW_ENGMNT_MAIL/dndcheck/' . $filename;
////////////////////////////////////////////////////////////////////////////////// code end for zip //////////////////////////////////////////////////////
            require '/var/www/html/hungamacare/summercontest/PHPMailer/PHPMailerAutoload.php';

            $lines = file($filepathdndcheck_csv);
            $i = 0;
            $mdncount = 0;
            $totalcount = 0;
            foreach ($lines as $line_num => $mobno) {
                $mno = trim($mobno);
                if (!empty($mno)) {
                    $i++;
                    $mdncount = $mdncount + 1;
                }
            }
            $totalcount = $mdncount;
require '/var/www/html/kmis/services/hungamacare/EngagemnentBox/UNINOR_NEW_ENGMNT_MAIL/contents_2.php';
//Create a new PHPMailer instance
            $mail = new PHPMailer();
//Set who the message is to be sent from
//set encoding
            $mail->Encoding = 'base64';
            $mail->setFrom('voice.mis@hungama.com', 'Voice Mis');
//Set an alternative reply-to address
            $mail->addReplyTo('voice.mis@hungama.com', 'Voice Mis');
//Set who the message is to be sent to

            $mail->addAddress($emailSmsEngagemntArray[0], '');
            for ($i = 0; $i < count($cc_user_array); $i++) {
                $mail->addAddress($cc_user_array[$i], '');
            }
            //$mail->addAddress($emailSmsEngagemntArray[1], '');
            $mail->addAddress('jyoti.porwal@hungama.com', '');
            $mail->addAddress('satay.tiwari@hungama.com', '');
//Set the subject line
            $curdatetime = date("Y-m-d H:i:s");
            $dateMonthTime = date('j-M h:i A', strtotime($curdatetime));
            $subject = $rule_name . "(" . $rule_id . ") executed on " . $dateMonthTime;
            $mail->Subject = $subject;
            //updated for ftp dnd process start here
            $mail->msgHTML(file_get_contents($htmlfilename), dirname(__FILE__));
            //$mail->addAttachment($filepathdndcheck_csv);
            //updated for ftp dnd process end here
//send the message, check for errors

            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {

                $insert_query = "insert into master_db.tbl_new_engagement_data (count,added_on,service_id,status,type,rule_id,filepath) 
            values (" . $totalcount . ",now(),'" . $service_id . "',0,'" . $type . "','$rule_id','$filename')";
                mysql_query($insert_query, $dbConn);
                echo "Message sent!";
                $logdata1 = 'Email' . "#" . $emailSmsEngagemntArray[0] . $emailSmsEngagemntArray[1] . '#Time' . "#" . date("H:i:s") . "\r\n";
                error_log($logdata1, 3, $log_path);

                $UpdateRule = "update master_db.tbl_rule_engagement set last_processed_time=now() where id=" . $rule_id . "";
                $UpdateRuleEXEresult = mysql_query($UpdateRule, $dbConn);
            }
        }
    }
    unlink($filepathdndcheck_csv);
    unlink($filepathdndcheck);
    unlink($htmlfilename);
}
mysql_close($dbConn);
echo "done";
 * 
 * 
 */
?>