<?php 
// Timeout in seconds 
$timeout = 5; 

$fp = fsockopen("10.2.73.156", 80, $errno, $errstr, $timeout); 

if ($fp) { 
     /*   fwrite($fp, "GET /file.php HTTP/1.0\r\n"); 
        fwrite($fp, "Host: www.server.com\r\n"); 
        fwrite($fp, "Connection: Close\r\n\r\n"); 

        stream_set_blocking($fp, TRUE); 
        stream_set_timeout($fp,$timeout); 
        $info = stream_get_meta_data($fp); 

        while ((!feof($fp)) && (!$info['timed_out'])) { 
                $data .= fgets($fp, 4096); 
                $info = stream_get_meta_data($fp); 
                ob_flush; 
                flush(); 
        } 

        if ($info['timed_out']) { 
                echo "Connection Timed Out!"; 
        } else { 
                echo $data; 
        } 
		*/
}
else
{
echo 'Not Connected';
}
?>