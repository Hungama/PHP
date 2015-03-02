<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$operator_circle_map=array('APD'=>'1','ASM'=>'2','BIH'=>'3','PUB'=>'18','KAR'=>'10','MAH'=>'13','TNU'=>'20','WBL'=>'23','DEL'=>'5','MPD'=>'14','CHN'=>'4','UPE'=>'21','GUJ'=>'6','HPD'=>'8','HAY'=>'7','JNK'=>'9','KER'=>'11','KOL'=>'12','MUM'=>'15','NES'=>'16','ORI'=>'17','RAJ'=>'19','UPW'=>'12','HAR'=>'7');
$operator_circle_map = array_flip($operator_circle_map);
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
function chargedMsisdn($msisdn,$amount,$oid,$cid,$transId)
{//12345
	$rechargeUrl="http://www.mobikwik.com/recharge.do?uid=kunalk.arora@hungama.com&pwd=hun@123&cn=".$msisdn."&amt=".$amount."&op=".$oid."&cir=".$cid."&regid=".$transId;
	//remove opid &cir for testing
	//$rechargeUrl="http://www.mobikwik.com/recharge.do?uid=kunalk.arora@hungama.com&pwd=12345&cn=".$msisdn."&amt=".$amount."&regid=".$transId;
/*	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$rechargeUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);
	*/
	$response=file_get_contents($rechargeUrl);
	return $response;
}
$getMsisdn="select Msisdn,amount,transactionid,id,operator_id,circle_id from master_db.tbl_recharged where status=0 limit 50";
$result=mysql_query($getMsisdn,$dbConn);
while(list($msisdn,$amount,$transactionid,$id,$operator_id,$circle_id)=mysql_fetch_array($result))
{
	$chrgedResponse12=chargedMsisdn($msisdn,$amount,$operator_id,$circle_id,$transactionid);

	$xml = simplexml_load_string($chrgedResponse12);
	$mobikiwi_status = $xml->status;
	$mobikiwi_txId = trim($xml->txId);
	$mobikiwi_AvilableBlance = $xml->balance;
	$mobikiwi_discountPrice = $xml->discountprice;
	
	if($mobikiwi_status=='FAILURE')
	{
	$mobikiwi_errormsg=$xml->errorMsg;
	$apiresponse=$mobikiwi_status.'#'.$mobikiwi_errormsg;
	}
	else if($mobikiwi_status=='SUCCESS')
	{
	$apiresponse=$mobikiwi_status.'#'.$mobikiwi_txId.'#'.$mobikiwi_AvilableBlance.'#'.$mobikiwi_discountPrice;
	}
	else
	{
	$apiresponse=$mobikiwi_status;
	}
	
	$message=$msisdn."|".date("H:i:s")."|";
	$reponseLog="/var/www/html/Recharge/log/mobikwik_Response_".date("Ymd").".txt";
	
	$transactionid=trim($transactionid);
	
	if($mobikiwi_status=='SUCCESS')
		$status='Success';
	else if($mobikiwi_status=='FAILURE')
		$status='FAILURE';
	else
		$status='FAILURE';

	$cir_code=$operator_circle_map[$circle_id];
	$cirname=$circle_info[$cir_code];
	$callBackUrl="http://192.168.100.218:81/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/Recharge.Notification.php";
//	$callBackUrl .="?status=".$status."&response=".$mobikiwi_txId."&tid=".$transactionid."&responseText=".trim($chrgedResponse12)."&amount=".$amount;
	$callBackUrl .="?status=".$status."&response=".$mobikiwi_txId."&tid=".$transactionid."&responseText=".urlencode(trim($apiresponse))."&Circle=".urlencode($cirname);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$callBackUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$CallBackResponse = curl_exec($ch);
	

	$message .=$responseTime."|".$msisdn."|".$operator_id."|".$circle_id."|".$amount."|".trim($apiresponse)."|".$callBackUrl."|".$CallBackResponse."\r\n";
	
	$updateRecord="update master_db.tbl_recharged set status=1,response_time=now(),response='".trim($apiresponse)."' where id=".$id;
	$updateResult=mysql_query($updateRecord,$dbConn);
	error_log($message,3,$reponseLog);
}
echo "Done";
//exit;
?>
