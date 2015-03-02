<?
$fileExt=date("Ymdhis");
$fileDate=date("Ymd");
$imgPath="http://202.87.41.147/wapsite/admin/vodafone_cmt/images/hmlogo.gif";
$logFile="/var/www/html/kmis/mis/checklog/status_".$fileDate.".txt";
$filePointer=fopen($logFile,'a+');
chmod($logFile,0777);

$locateLocalImg="/var/www/html/kmis/mis/checklog/test_".$fileExt.".gif";
$locateLocalImgHttp="http://119.82.69.212/kmis/mis/checklog/test_".$fileExt.".gif";
$ch = curl_init($imgPath);
$fp = fopen($locateLocalImg, 'w+');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

$uploadImageFile=filesize($locateLocalImg);
if(file_exists($locateLocalImg))
{
	$fileStatus="filefound";
}
else
	$fileStatus="fileNotfound";

fwrite($filePointer,$fileStatus." of ". $uploadImageFile ." KB at ".$fileExt."\r\n");
fclose($filePointer);

?>