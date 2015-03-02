<?php

$filePath='/var/www/html/Headerinfo/header.txt';
$fp=fopen($filePath,'a+');
echo "<table align='center' border='1'>";
foreach (getallheaders() as $name => $value) 
{
	echo "<tr><td>".$name."</td><td>".$value."</td></tr>";
	fwrite($fp,$name."--".$value."\r\n");
}
fwrite($fp,"--------------------------------------------------------\r\n");
fclose($fp);
echo "</table>";

?>