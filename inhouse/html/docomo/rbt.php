<?php
$msisdn=$_GET['MSISDN'];
$clipid=$_GET['clipId'];

$hitUrl="http://59.161.254.4:8085/rbt/rbt_promotion.jsp?";
$hitUrl .="MSISDN=".$msisdn."&REQUEST=SELECTION&SUB_TYPE=PREPAID&TONE_ID=".$clipid."&SELECTED_BY=59090IVR&CATEGORY_ID=23&ISACTIVATE=TRUE&SUBSCRIPTION_CLASS=EAUC5FREM";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$hitUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
echo $response = curl_exec($ch); 
$log_file_path="logs/docomo/subscription/rbt.txt";
$LogString=$msisdn."#".$clipid."#".$response."#".date('d:m:yh:i:s')."#"."\r\n";
error_log($LogString,3,$log_file_path);

?>