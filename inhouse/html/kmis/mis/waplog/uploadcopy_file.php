<?php
$databasehost = "192.168.100.224"; 
$databasename = "Inhouse_tmp"; 
$databasetable = "tbl_browsing_match_record"; 
$databaseusername="webcc"; 
$databasepassword = "webcc"; 
$fieldseparator = ","; 
$lineseparator = "\n";
$csvfile = "/var/www/html/kmis/mis/waplog/T_NEW_DEVICE_DETAIL.csv";

if(!file_exists($csvfile)) {
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
    LOAD DATA LOCAL INFILE ".$pdo->quote($csvfile)." INTO TABLE `$databasetable`
      FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
      LINES TERMINATED BY ".$pdo->quote($lineseparator));

echo "Loaded a total of $affectedRows records from this csv file.\n";

?>