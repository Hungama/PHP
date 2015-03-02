<?php
phpinfo();
$link = mysql_connect('localhost', 'cacti', 'cacti');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_close($link);
?>
