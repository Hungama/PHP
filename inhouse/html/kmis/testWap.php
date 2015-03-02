<?php 
$encoding="gzip, deflate";
$header['lang']="en-us,en;q=0.5";
$header['charset']="ISO-8859-1,utf-8;q=0.7,*;q=0.7";
$header['conn']="keep-alive";
$header['keep-alive']=115;
$userAgent="Mozilla/5.0 (Windows NT 5.1; rv:2.0)Gecko/20100101 Firefox/4.0";

echo $url = "http://119.82.69.212/kmis/green_apple_logo.jpg";
$ch=curl_init();
curl_setopt($ch,CURLOPT_USERAGENT,$userAgent);
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_ENCODING,$encoding);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch,CURLOPT_AUTOREFERER,1);
$content=curl_exec($ch);
curl_close($ch);
echo $content;


/* gets the data from a URL */
function get_data($url)
{
  $ch = curl_init();
  $timeout = 5;
  $file = fopen($url, "w");
  curl_setopt($ch, CURLOPT_FILE, $file);
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
echo $tempUrl = "http://119.82.69.212/kmis/green_apple_logo.jpg";

if($_GET['test']) {
	echo "here ".$data = get_data($tempUrl);
}

?>
<html>
<div>Hello 
<a href='testWap.php?test=1'>Download</a>
</div>
</html>