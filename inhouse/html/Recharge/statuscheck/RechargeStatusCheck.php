<?php
//include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$operator_circle_map=array('APD'=>'1','ASM'=>'2','BIH'=>'3','PUB'=>'18','KAR'=>'10','MAH'=>'13','TNU'=>'20','WBL'=>'23','DEL'=>'5','MPD'=>'14','CHN'=>'4','UPE'=>'21','GUJ'=>'6','HPD'=>'8','HAY'=>'7','JNK'=>'9','KER'=>'11','KOL'=>'12','MUM'=>'15','NES'=>'16','ORI'=>'17','RAJ'=>'19','UPW'=>'12','HAR'=>'7');
$operator_circle_map = array_flip($operator_circle_map);
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
function chargedMsisdn($transId)
{
//http://www.mobikwik.com/rechargeStatus.do?uid=<uid>&pwd=<pwd>&txId=<txid>
	$rechargeUrl="http://www.mobikwik.com/rechargeStatus.do?uid=kunalk.arora@hungama.com&pwd=hun@123&txId=".$transId;	
	$response=file_get_contents($rechargeUrl);
	return $response;
}
$reponseLog="mobikwik_StatusCheck_".date("Ymd").".txt";
$pathtofile='rechargeFail.txt';
 $lines = file($pathtofile);
 $alltrnx='';
             foreach ($lines as $line_num => $alltrnx) {
		  //echo $alltrnx."<br>";
		  $chrgedResponse12=chargedMsisdn($alltrnx);
		 $message=$alltrnx."#".trim($chrgedResponse12)."#".date("H:i:s")."\r\n";	
	error_log($message,3,$reponseLog);
		  
			    } 
echo "Done";
?>