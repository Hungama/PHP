<?php
$cvspath="epl_20121218-spt.csv";
$fGetContents = file_get_contents($cvspath);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 1; $i < $totalcount; $i++) {
$data = explode(",", $e[$i]);
if($totalcount!=$i+1)
{
//$datetime=date("Y-m-d",strtotime($data[0]));
$smsmessage=trim($data[1]);
//$time=date("H:i:s",strtotime($data[2]));
$smstime=$data[0]." ".$data[2];
echo $mytime=date("Y-m-d H:i:s",strtotime($smstime));
echo "<br>";
$logData_csv=$datetime.'#'.$smsmessage.'#'.$mytime."\r\n";
echo $logData_csv."<br>";
}}
?>