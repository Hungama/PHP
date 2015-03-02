<?php 
if($_GET['ani']) { $ani = trim($_GET['ani']); }
if($_GET['msg']) { $message = trim($_GET['msg']); }
if($_GET['value']) { $value = trim($_GET['value']); }
if($_GET['sc'])
	$sc=$_GET['sc'];
else
	$sc='543219';
$message = str_replace(" ","%20",$message);		

$filePath = "/var/www/html/SMS/log/Aircel/aircel_log_".date("Y-m-d").".txt";

if((strlen($ani) == 10 || strlen($ani) == 12) && is_numeric($ani)) {
	if($message) {
		if($value == 2) {
		//	$aircelUrl="http://www.myvaluefirst.com/smpp/sendsms?username=hungamahttp&password=hdmeltd1&to=".$ani."&text=".$message."&from=mobisur";
			$aircelUrl="http://10.181.255.141:8080/MusicOnDemandApp/MODServlet?action=43&ANI=$ani&DNIS=$sc&MSG=$message&SERVICE=Alert&PRIORITY=1&FLAG=1";
			//$url_response=file_get_contents($aircelUrl); 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$aircelUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$url_response = curl_exec($ch);
			
			if(trim($url_response) == 'SUCCESS') { 
				$filedata = $ani."#VALUE:1#SUCCESS#".$url_response."#".$aircelUrl."#".date("d-m-Y H:i:s")."\n";
				echo "Sent SMS!"; 
			} else { 
				$filedata = $ani."#VALUE:1#FAILURE#".$url_response."#".$aircelUrl."#".date("d-m-Y H:i:s")."\n";
				echo "Sending Fail!"; 
			}
		} elseif($value == 1){
			echo "Not configured yet!";
			/*$aircelUrl1="http://tempurl.php?ani=".$ani."&msg=".$message;
			//$url_response=file_get_contents($aircelUrl1); 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$aircelUrl1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$url_response1 = curl_exec($ch);
			
			if($url_response1 == 'Sent.') { 
				$filedata = $ani."#VALUE:2#SUCCESS#".$url_response."#".$aircelUrl1."#".date("d-m-Y H:i:s")."\n";
				echo "Sent SMS!"; 
			} else { 
				$filedata = $ani."#VALUE:2#FAILURE#".$url_response."#".$aircelUrl1."#".date("d-m-Y H:i:s")."\n";
				echo "Sending Fail!"; 
			}*/
		}
	} else {
		$filedata = $ani."#VALUE:".$value."#FAILURE:Blank message!#".date("d-m-Y H:i:s")."\n";
		echo "Blank message!"; 
	}
} else {
	$filedata = $ani."#VALUE:".$value."#FAILURE:Invalid Number#".$message."#".date("d-m-Y H:i:s")."\n";	
	echo "Invalid number!"; 
}
error_log($filedata,3,$filePath);

?>