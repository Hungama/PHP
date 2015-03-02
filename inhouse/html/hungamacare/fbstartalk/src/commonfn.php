<?php
include("config/config.php");

/*
 function execute_ffmpeg($userTempDir,$userRecording,$media_url,$fb_supportFormat){
global $userTempDir,$userRecording,$media_url,$baseDir,$temp_ConvertPath,$fb_supportFormat;

$ffmpeg_cmd="ffmpeg -r 3 -loop_input -t 125 -i ".$userTempDir."/A-%03d.jpg -r 3 ".$userTempDir."/".$userRecording.".avi";
echo("ffmpeg command to add image in video-->".$ffmpeg_cmd);
$ret_var	=	trim(exec($ffmpeg_cmd));
var_dump($ret_var);

$ffmpeg_cmd2="ffmpeg -shortest -i ".$userTempDir."/".$userRecording.".avi -i ".$baseDir.$media_url." -vcodec copy ".$userTempDir."/".$userRecording."avi.avi";
echo("ffmpeg command to add audio wav to avi-->".$ffmpeg_cmd2);
$ret_var	=	trim(exec($ffmpeg_cmd2));
var_dump($ret_var);

$ffmpeg_cmd3="ffmpeg -i ".$userTempDir."/".$userRecording."avi.avi -s qcif -vcodec h263 -acodec aac -strict experimental -ac 1 -ar 8000 -ab 12.2k -y ".$userTempDir."/".$userRecording.$fb_supportFormat;
echo("ffmpeg command to convert avi to 3gp-->".$ffmpeg_cmd3);
$ret_var	=	trim(exec($ffmpeg_cmd3));
var_dump($ret_var);
}*/

function execute_ffmpeg($userTempDir,$userRecording,$media_url,$fb_supportFormat){
	global $userTempDir,$userRecording,$media_url,$baseDir,$temp_ConvertPath,$fb_supportFormat;
	
$ffmpeg_cmd="ffmpeg -r 1 -loop_input -shortest -y -i ".$userTempDir."/A-%03d.jpg -i ".$media_url." -acodec copy -vcodec mjpeg ".$userTempDir."/".$userRecording.".avi";
	echo("ffmpeg command to add images in audio-->".$ffmpeg_cmd)."\n";
	log_action("!!!!!commonfn--->execute_ffmpeg!!!!!!---command to add images in avi file-->".$ffmpeg_cmd);
	
	$ret_var	=	trim(exec($ffmpeg_cmd));
	log_action("!!!!!commonfn--->execute_ffmpeg!!!!!!---images in avi file ret_var-->".$ret_var);
	var_dump($ret_var);

	$ffmpeg_cmd3="ffmpeg -i ".$userTempDir."/".$userRecording.".avi -s 16cif -aspect 4:3 -vcodec h263 -acodec aac -strict experimental -ac 1 -ar 8000 -ab 12.2k -y ".$userTempDir."/".$userRecording.$fb_supportFormat;
	echo("ffmpeg command to convert avi to 3gp-->".$ffmpeg_cmd3."\n");
	log_action("!!!!!commonfn--->execute_ffmpeg!!!!!!---command to convert avi to 3gp-->".$ffmpeg_cmd3);
	
	$ret_var	=	trim(exec($ffmpeg_cmd3));
	log_action("!!!!!commonfn--->execute_ffmpeg!!!!!!---avi to 3gp ret_var-->".$ret_var);
	var_dump($ret_var);
	/*
	$ffmpeg_cmd="ffmpeg -r 1 -loop_input -shortest -y -i ".$userTempDir."/A-%03d.jpg -i ".$baseDir.$media_url." -acodec copy -vcodec mjpeg ".$userTempDir."/".$userRecording.".avi";
	echo("ffmpeg command to add images in audio-->".$ffmpeg_cmd)."\n";
	$ret_var	=	trim(exec($ffmpeg_cmd));
	var_dump($ret_var);

	$ffmpeg_cmd3="ffmpeg -i ".$userTempDir."/".$userRecording.".avi -s qcif -vcodec h263 -acodec aac -strict experimental -ac 1 -ar 8000 -ab 12.2k -y ".$userTempDir."/".$userRecording.$fb_supportFormat;
	echo("ffmpeg command to convert avi to 3gp-->".$ffmpeg_cmd3."\n");
	$ret_var	=	trim(exec($ffmpeg_cmd3));
	var_dump($ret_var);*/
}

function log_action($msg) {
	global $logDir;
	date_default_timezone_set('Asia/Calcutta');
	$today = date("Ymd");
		//$log_Dir=$logDir.$today;
	$log_Dir=$logDir;
	$cmd="mkdir -p ".$log_Dir;
	$ret_var	=	trim(exec($cmd));
	
	$filename = $log_Dir."/$today.txt";
	$fd = fopen($filename, "a");
	$str = "[" . date("d/m/Y H:i:s") . "] " . $msg;
//	echo $msg;
	fwrite($fd, $str . PHP_EOL);
	fclose($fd);
}

?>
