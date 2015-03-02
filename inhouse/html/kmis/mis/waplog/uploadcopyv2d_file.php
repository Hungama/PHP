<?php
$databasehost = "192.168.100.224"; 
$databasename = "Hungama_HoneyBee"; 
$databasetable = "tbl_V2D_info"; 
$databaseusername="webcc"; 
$databasepassword = "webcc"; 
$fieldseparator = "#"; 
$lineseparator = "\n";
//$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$prevdate ='2014-10-19';
$txtfile = "/var/www/html/kmis/mis/waplog/core-device/detect-device/detect-process/logs/airceldevice_".$prevdate.".txt";

if(!file_exists($txtfile)) {
    die("File not found. Make sure you specified the correct path.");
}

try {
    $pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", 
        $databaseusername, $databasepassword,
        array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
} catch (PDOException $e) {
    die("database connection failed: ".$e->getMessage());
}

$affectedRows = $pdo->exec("
    LOAD DATA LOCAL INFILE ".$pdo->quote($txtfile)." INTO TABLE `$databasetable`
      FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
      LINES TERMINATED BY ".$pdo->quote($lineseparator));

echo "Loaded a total of $affectedRows records from this text file.\n";

?>