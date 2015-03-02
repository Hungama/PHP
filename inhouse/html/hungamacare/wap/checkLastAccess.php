<?php
error_reporting(0);
/*
$subdirPath="/DB/INHOUSE_CONTENT/109/";
$iterator = new DirectoryIterator($subdirPath);
foreach ($iterator as $fileinfo) {
    if ($fileinfo->isFile()) {
	   //    echo $fileinfo->getFilename() . " " . $fileinfo->getATime() . "<br>";
	    echo $fileinfo->getFilename() . " " . date ("F d Y H:i:s.", $fileinfo->getATime()) . "<br>";
    }
}
*/
?>

<?php
/*
echo $subdirPath="/DB/INHOUSE_CONTENT/109/";
if ($handle = opendir($subdirPath)) {
//if ($handle = opendir('.')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            echo "$entry"."#"."was last accessed: " . date("F d Y H:i:s.", fileatime($entry))."<br>";
        }
    }
    closedir($handle);
}

//$filename = 'testRequest_20150120.txt';
//if (file_exists($filename)) {
  //  echo "$filename was last accessed: " . date("F d Y H:i:s.", fileatime($filename));
//}
*/
?>
<?php
$logPath="/var/www/html/hungamacare/wap/lastaccessfileinfo.txt";
$Mydir = '/DB/INHOUSE_CONTENT/'; ### OR MAKE IT 'yourdirectory/';
$i=1;
foreach(glob($Mydir.'*', GLOB_ONLYDIR) as $dir) {
    $dir = str_replace($Mydir, '', $dir);
if(is_numeric($dir))
{
//echo $i."#".$dir."<br>";
	$subdirPath="/DB/INHOUSE_CONTENT/".$dir;
	$iterator = new DirectoryIterator($subdirPath);
	foreach ($iterator as $fileinfo) {
	$db_dirname='';
	$db_fileinfo='';
	$db_lastaccess='';
	$db_act_fileinfo='';
    if ($fileinfo->isFile()) {
	   //    echo $fileinfo->getFilename() . " " . $fileinfo->getATime() . "<br>";
	   $db_dirname=$dir;
	   $db_fileinfo=$fileinfo->getFilename();
	   $db_act_fileinfo=str_ireplace($db_dirname.'_',"",$db_fileinfo);
	   $db_lastaccess=date ("Y-m-d H:i:s.", $fileinfo->getATime());
	    //echo $fileinfo->getFilename() . " " . date ("Y-m-d H:i:s.", $fileinfo->getATime()) . "<br>";
		$logData=$db_dirname."#".$db_fileinfo."#".$db_act_fileinfo."#".$db_lastaccess."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
    }
}
	
$i++;
//exit;
}
}
echo "done";
?>