<?php
//error_reporting(0);
$mode=$_REQUEST['mode']; //'net';
$reqtype=$_REQUEST['reqtype'];
$msisdn=$_REQUEST['msisdn'];
$planid=$_REQUEST['planid'];
$subchannel ='net';
if($mode=='')
	$mode='net';
$seviceId=$_REQUEST['serviceid'];
$ac=0;
$curdate = date("Y-m-d");
$msisdn = substr($msisdn, -10);
$log_file_path="/var/www/html/reliance/logs/reliance/subscription/".$seviceId."/Wap/subscription_".$curdate.".txt";
$log_file_path=str_replace("'","",$log_file_path); 
$file=fopen($log_file_path,"a+");
chmod($log_file_path,0777);
if($msisdn)
{
$con = mysql_connect("192.168.100.224","weburl","weburl") or die('we are facing some temporarily problem please try later');
switch($seviceId)
	{
		case '1203':
			$sc='546461';
			$s_id='1203';
			$subscriptionTable="reliance_hungama.tbl_mtv_subscription";
			$subscriptionProcedure="reliance_hungama.MTV_SUB";
			$unSubscriptionProcedure="reliance_hungama.MTV_UNSUB";
			$unSubscriptionTable="reliance_hungama.tbl_mtv_unsub";
			$lang='01';
			$displayMsg="Thank you for Subscribing MTV DJ Dial. Listen your favorite songs which we are carrying from past till latest one. So just dial 546461!!";
			break;
		case '1202':
			$sc='54646';
			$s_id='1202';
			$subscriptionTable="reliance_hungama.tbl_jbox_subscription";
			$subscriptionProcedure="reliance_hungama.JBOX_EVENT_ACT_BULK";
			$unSubscriptionProcedure="reliance_hungama.JBOX_UNSUB";
			$unSubscriptionTable="reliance_hungama.tbl_jbox_unsub";
			$lang='01';
			//$displayMsg="Thank you for Subscribing Hungama Media Portal. Just Dial 546460 and get fully loaded Entertainment service from Bollywood latest songs & Gossips to answers of your love related query from our love guru.";
			echo $displayMsg="Thanks for Subscribing to Reliance Mobisur Service. Dial 5464630  to be the next musical star , win 5lacs cash and get a chance to sing with Shankar Mahadevan";
			break;
		case '1208':
			$sc='54433';
			$s_id='1208';
			$subscriptionTable="reliance_cricket.tbl_cricket_subscription";
			$subscriptionProcedure="reliance_cricket.JBOX_EVENT_ACT_BULK";
			$unSubscriptionProcedure="reliance_cricket.CRICKET_UNSUB";
			$unSubscriptionTable="reliance_cricket.tbl_cricket_unsub";
			$lang='01';
			$planid='192';
			$displayMsg="Thank you for subscribing Cricket Mania Service. Predict and Win exiting prices!!! Dial 54433";
			break;
			case 'MM';
			$Url="http://115.248.233.131/SubVoice/SubService.aspx";
			$data ="Mobileno=91".$msisdn."&Channel=".strtoupper($mode)."&planid=14018&clientid=511&requestType=20";
			$data .="&SubscriptionMode=".strtoupper($mode)."&ShortcodeId=33&isbill=1&OperatorId=12&BillAmt=20";
			$final_url=$Url."?".$data;
			$ch = curl_init();
            		curl_setopt($ch, CURLOPT_URL,$final_url);
            		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            		$altrustResponse = curl_exec($ch);
			if($altrustResponse=='SUCCESS')
			{
				fwrite($file,$msisdn . "#" . $final_url . "#" . $altrustResponse . "#" . date('H:i:s') ."\r\n" );
				fclose($file);
				echo $displayMsg="Thank you for subscribing Reliance Music Mania Service.";
			}
			else
			{
				fwrite($file,$msisdn . "#" . $final_url . "#" . $altrustResponse . "#" . date('H:i:s') ."\r\n" );
				fclose($file);
				echo "please try later";
			}
			exit;
			break;
			case 'AMC';
			$Url="http://10.181.255.141/SubscriptionMC/SubVoice.aspx";
			$data ="MSISDN=".$msisdn."&requestType=1&ShortcodeId=20&planid=715&clientid=305&Channel=WAP&SubscriptionMode=WAP&isbill=1";
			$final_url=$Url."?".$data;
			$altrustResponse=file_get_contents($final_url);
			if($altrustResponse=='SUCCESS')
			{
				fwrite($file,$msisdn . "#" . $final_url . "#" . $altrustResponse . "#" . date('H:i:s') ."\r\n" );
				fclose($file);
				$displayMsg="SUCCESS";
			}
			else
			{
				fwrite($file,$msisdn . "#" . $final_url . "#" . $altrustResponse . "#" . date('H:i:s') ."\r\n" );
				fclose($file);
				$displayMsg="FAILURE";
			}
			exit;
			break;
		}	
	if($reqtype==1)
	{
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$seviceId";
		$amt = mysql_query($amtquery);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;
		$actionQry="call ". $subscriptionProcedure." ('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid;
		if($seviceId==1208 || $seviceId==1202)
			$actionQry .=",0)";
		else
			$actionQry .= ")";
	}
	if($reqtype == 2)
	{
		$actionQry="call ".$unSubscriptionProcedure." ('$msisdn','$mode')";
	}
	$qry1=mysql_query($actionQry) or die( mysql_error());
	
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $mode . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
	echo "Success";
}
else
{
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $mode . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
	echo "Msisdn Not found";
}
	fclose($file);
	mysql_close($con);
?>   
