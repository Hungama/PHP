<?php
//error_reporting(ALL);
//echo copy("/home/bulk_pending.txt",'/var/www/html/docomo/bulk_pending.txt');
$src="/home/219.64.175.251.txt";
$dest='/var/www/html/docomo/219.64.175.251.txt';

echo exec("cp -r $src $dest");
if(file_exists($src))
{
	echo "athar";
}
else
echo "no";
exit;
echo exec('pwd');
exit;
phpinfo();
?>