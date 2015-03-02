<?php
exit;
error_reporting(1);
//get all email list here
$dbConn_224 = mysql_connect("192.168.100.224","webcc","webcc");
if (!$dbConn_224)
 {
 echo '224- Could not connect';
 die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
 $emailVodaArray=array();
 $emailTataArray=array();
 $emailMTSArray=array();
 $emailUninorArray=array();
 $emailAirtelArray=array();
 $emailRelArray=array();
 //Voda

//Tata

$get_email_tata="select email from master_db.live_user_master where access_service like '%tata%' and ac_flag=1 and access_sec like '%revenue%' and alert_billing=1";
$email_list_tata = mysql_query($get_email_tata,$dbConn_224) or die(mysql_error());
while($row_email = mysql_fetch_array($email_list_tata))
{
if($row_email['email']!='anuj.bajpai@hungama.com' and $row_email['email']!='albert.almeida@hungama.com')
{
$emailTataArray[]= $row_email['email'];
}
}

//Uninor

$get_email_uninor="select email from master_db.live_user_master where access_service like '%Uninor%' and ac_flag=1 and access_sec like '%revenue%' and alert_billing=1";
$email_list_uninor = mysql_query($get_email_uninor,$dbConn_224) or die(mysql_error());
while($row_email = mysql_fetch_array($email_list_uninor))
{
if($row_email['email']!='anuj.bajpai@hungama.com' and $row_email['email']!='albert.almeida@hungama.com')
{
$emailUninorArray[]= $row_email['email'];
}
}

mysql_close($dbConn_224);
function getTotalHistory($operator,$emailArray)
 {
 $curdate = date("Y-m-d");
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
//begin of HTML message 
if($operator=='Uninor' || $operator=='TATA')
{
$message = '<html><body>';
		    $message .= '<table rules="all" style="border-color: #666;font-size:12px;width:100%" border="0" cellpadding="2">';
			$message .= "<tr style='background: #eee;'><td><strong>BatchId</strong> </td><td><strong>Added On</strong></td><td><strong>Added By</strong></td><td><strong>Uploaded For</strong></td><td><strong>Status</strong> </td><td><strong>Service Id</strong></td><td><strong>Total File Count</strong> </td><td><strong>BLOCK</strong> </td><td><strong>ALREADY_SUBSCRIBED </strong> </td><td><strong>IN_PROCESS</strong></td><td><strong>IN_SUCCESS</strong></td><td><strong>IN_FAILURE</strong></td><td><strong>GAP_PERCENTAGE</strong></td><td><strong>Alert For</strong></td></tr>";
}
else
{
$message = '<html><body>';
		    $message .= '<table rules="all" style="border-color: #666;font-size:12px;width:100%" border="0" cellpadding="2">';
			$message .= "<tr style='background: #eee;'><td><strong>BatchId</strong> </td><td><strong>Added On</strong></td><td><strong>Uploaded For</strong></td><td><strong>Status</strong> </td><td><strong>Service Id</strong></td><td><strong>Total File Count</strong> </td><td><strong>Success Count</strong> </td><td><strong>Failure Count</strong> </td><td><strong>InRequest</strong></td><td><strong>Alert For</strong></td></tr>";
}			
if($operator=='airtel')
{
$con = mysql_connect('10.2.73.160', 'team_user','Te@m_us@r987');
$getdatasql=mysql_query("select batch_id,added_on,status,service_id,total_file_count,success_count,failure_count,InRequest,upload_for from airtel_hungama.bulk_upload_history where date(added_on) =date(now()) or date(added_on)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY)) order by id desc",$con);
$noofrecords=mysql_num_rows($getdatasql);
mysql_close($con);
//close database connection here

while($result=mysql_fetch_array($getdatasql))
{

if(empty($result[total_file_count]))
{
$TC='TC_0';
$style='background: #ADD8E6;color:#000000';
}
else
{
$TC='TC_'.$result[total_file_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result[success_count]))
{
$SC='SC_0';
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$SC='SC_'.$result[success_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result[failure_count]))
{
$FC='FC_0';
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$FC='FC_'.$result[failure_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result[InRequest]))
{
$IR='IR_0';
}
else
{
$IR='IR_'.$result[InRequest];
}
if($result['upload_for']=='deactive')
{
$style='background: #ADD8E6;color:#000000';
}
else if(empty($result[success_count]) and  empty($result[failure_count]))
{
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$style='background: #ADD8E6;color:#000000';
}
$message .= "<tr style='".$style."'><td><strong>".$result['batch_id']."</strong> </td><td>" .$result['added_on']."</td><td>".$result['upload_for']."</td><td>".$result['status']."</td><td>".$result['service_id']."</td><td>".$TC."</td><td>".$SC."</td><td>".$FC."</td><td>".$IR."</td><td style='font-weight:bold'>Airtel</td></tr>";

}

}
else if($operator=='Voda')
{
//for vodafone bulk upload history start here
$dbConnVoda = mysql_connect('203.199.126.129', 'team_user','teamuser@voda#123');
$getdatasql_voda=mysql_query("select batch_id,added_on,status,service_id,total_file_count,upload_for,success_count,failure_count,InRequest from vodafone_hungama.bulk_upload_history where date(added_on) =date(now()) or date(added_on)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY)) order by id desc",$dbConnVoda);
$noofrecords=mysql_num_rows($getdatasql_voda);
//$getdatasql_voda=mysql_query("select batch_id,added_on,status,service_id,total_file_count,upload_for,success_count,failure_count,InRequest from vodafone_hungama.bulk_upload_history order by id desc limit 100",$dbConnVoda);
mysql_close($dbConnVoda);
//close database connection here
while($result_voda=mysql_fetch_array($getdatasql_voda))
{
//echo $result_voda['upload_for'].'**SC**'.$result_voda['success_count'].'***FC***'.$result_voda['failure_count'].'*****IR*****'.$result_voda['InRequest']."<br>";
if(empty($result_voda[total_file_count]))
{
$TC_voda='TC_0';
$style='background: #ADD8E6;color:#000000';
}
else
{
$TC_voda='TC_'.$result_voda[total_file_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result_voda[success_count]))
{
$SC_voda='SC_0';
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$SC_voda='SC_'.$result_voda[success_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result_voda[failure_count]))
{
$FC_voda='FC_0';
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$FC_voda='FC_'.$result_voda[failure_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result_voda[InRequest]))
{
$IR_voda='IR_0';
}
else
{
$IR_voda='IR_'.$result_voda[InRequest];
}
if($result_voda['upload_for']=='deactive')
{
$style='background: #ADD8E6;color:#000000';
}
else if(empty($result_voda[success_count]) and  empty($result_voda[failure_count]))
{
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$style='background: #ADD8E6;color:#000000';
}
if($result_voda['batch_id']=='499')
{
$style='background: #ADD8E6;color:#000000';
}
$message .= "<tr style='".$style."'><td><strong>".$result_voda['batch_id']."</strong> </td><td>" .$result_voda['added_on']."</td><td>".$result_voda['upload_for']."</td><td>".$result_voda['status']."</td><td>".$result_voda['service_id']."</td><td>".$TC_voda."</td><td>".$SC_voda."</td><td>".$FC_voda."</td><td>".$IR_voda."</td><td style='font-weight:bold'>Voda</td></tr>";

}
}
else if($operator=='MTS')
{
$con = mysql_connect('10.130.14.106', 'billing','billing');
$getdatasql=mysql_query("select batch_id,added_on,status,service_id,total_file_count,success_count,failure_count,InRequest,upload_for from billing_intermediate_db.bulk_upload_history where date(added_on) =date(now()) or date(added_on)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY)) order by id DESC",$con);
$noofrecords=mysql_num_rows($getdatasql);
mysql_close($con);
//close database connection here
while($result=mysql_fetch_array($getdatasql))
{

if(empty($result[total_file_count]))
{
$TC='TC_0';
$style='background: #ADD8E6;color:#000000';
}
else
{
$TC='TC_'.$result[total_file_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result[success_count]))
{
$SC='SC_0';
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$SC='SC_'.$result[success_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result[failure_count]))
{
$FC='FC_0';
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$FC='FC_'.$result[failure_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result[InRequest]))
{
$IR='IR_0';
}
else
{
$IR='IR_'.$result[InRequest];
}
if($result['upload_for']=='deactive')
{
$style='background: #ADD8E6;color:#000000';
}
else if(empty($result[success_count]) and  empty($result[failure_count]))
{
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$style='background: #ADD8E6;color:#000000';
}
$message .= "<tr style='".$style."'><td><strong>".$result['batch_id']."</strong> </td><td>" .$result['added_on']."</td><td>".$result['upload_for']."</td><td>".$result['status']."</td><td>".$result['service_id']."</td><td>".$TC."</td><td>".$SC."</td><td>".$FC."</td><td>".$IR."</td><td style='font-weight:bold'>MTS</td></tr>";

}
}

else if($operator=='Uninor')
{
$con = mysql_connect("192.168.100.224","webcc","webcc");
/*$getdatasql=mysql_query("select batch_id,added_on,added_by,status,service_id,total_file_count,success_count,failure_count,InRequest,upload_for,blocked ,Already_subscribed 
from master_db.bulk_upload_history where (date(added_on) =date(now()) or date(added_on)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and service_id like '14%' and upload_for in('active','deactive','topup')
union
select batch_id,date_time as added_on,username as added_by,status,serviceID as service_id,total_count as total_file_count,success_count,failure_count,InRequest,'content_charging','0' ,'0'
from master_db.tbl_content_history where (date(date_time) =date(now()) or date(date_time)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and serviceId like '14%' order by added_on desc",$con);
*/
$getdatasql=mysql_query("select batch_id,added_on,added_by,status,service_id,total_file_count,success_count,failure_count,InRequest,upload_for,blocked ,Already_subscribed from master_db.bulk_upload_history where (date(added_on) =date(now()) or date(added_on)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and service_id like '14%' and upload_for in('active','deactive','topup')
union
select batch_id,date_time as added_on,username as added_by,status,serviceID as service_id,total_count as total_file_count,success_count,failure_count,InRequest,'content_charging','0' ,'0'
from master_db.tbl_content_history where (date(date_time) =date(now()) or date(date_time)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and serviceId like '14%'
union
select batch_id,added_on,added_by,status,service_id,total_file_count,success_count,failure_count,InRequest,content_type,'0' ,'0'
from master_db.bulk_rbt_history where (date(added_on) =date(now()) or date(added_on)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and service_id like '14%' order by added_on desc",$con);
$noofrecords=mysql_num_rows($getdatasql);
mysql_close($con);
//close database connection here

while($result=mysql_fetch_array($getdatasql))
{
$totalgap = $result['total_file_count']-($result['Already_subscribed']+$result['block']+$result['success_count']+$result['failure_count']+$result['InRequest']);
$gap1=($totalgap*100)/$result['total_file_count'];
$gap=floor($gap1);

if($gap>10 and $result['InRequest']>0)
{
$style='background: #FF0000;color:#ffffff';
}
else
{
$style='background: #ADD8E6;color:#000000';
}
$message .= "<tr style='".$style."'><td><strong>".$result['batch_id']."</strong> </td><td>" .$result['added_on']."</td><td>" .$result['added_by']."</td><td>".$result['upload_for']."</td><td>".$result['status']."</td><td>".$result['service_id']."</td><td>".$result['total_file_count']."</td><td>".$result['block']."</td><td>".$result['Already_subscribed']."</td><td>".$result['InRequest']."</td><td>".$result['success_count']."</td><td>".$result['failure_count']."</td><td>".$gap."</td><td style='font-weight:bold'>Uninor</td></tr>";
}

}
else if($operator=='TATA')
{
$con = mysql_connect("192.168.100.224","webcc","webcc");
$getdatasql=mysql_query("select batch_id,added_on,added_by,status,service_id,total_file_count,success_count,failure_count,InRequest,upload_for,blocked,Already_subscribed from master_db.bulk_upload_history where (date(added_on) =date(now()) or date(added_on)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and service_id like '10%' or service_id like '18%' or service_id like '16%' and upload_for in('active','deactive','topup')",$con);
$noofrecords=mysql_num_rows($getdatasql);
mysql_close($con);
//close database connection here
while($result=mysql_fetch_array($getdatasql))
{
$totalgap = $result['total_file_count']-($result['Already_subscribed']+$result['blocked']+$result['success_count']+$result['failure_count']+$result['InRequest']);
$gap1=($totalgap*100)/$result['total_file_count'];
$gap=floor($gap1);

if($gap>10 and $result['InRequest']>0)
{
$style='background: #FF0000;color:#ffffff';
}
else
{
$style='background: #ADD8E6;color:#000000';
}
$message .= "<tr style='".$style."'><td><strong>".$result['batch_id']."</strong> </td><td>" .$result['added_on']."</td><td>" .$result['added_by']."</td><td>".$result['upload_for']."</td><td>".$result['status']."</td><td>".$result['service_id']."</td><td>".$result['total_file_count']."</td><td>".$result['blocked']."</td><td>".$result['Already_subscribed']."</td><td>".$result['InRequest']."</td><td>".$result['success_count']."</td><td>".$result['failure_count']."</td><td>".$gap."</td><td style='font-weight:bold'>Tata</td></tr>";
}
}

else if($operator=='Reliance')
{
$con = mysql_connect("192.168.100.224","webcc","webcc");
$getdatasql=mysql_query("select batch_id,added_on,status,service_id,total_file_count,success_count,failure_count,InRequest,upload_for 
from master_db.bulk_upload_history where (date(added_on) =date(now()) 
or date(added_on)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'), INTERVAL 1 DAY))) and service_id like '12%' order by batch_id desc
",$con);
$noofrecords=mysql_num_rows($getdatasql);
mysql_close($con);
//close database connection here

while($result=mysql_fetch_array($getdatasql))
{

if(empty($result[total_file_count]))
{
$TC='TC_0';
$style='background: #ADD8E6;color:#000000';
}
else
{
$TC='TC_'.$result[total_file_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result[success_count]))
{
$SC='SC_0';
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$SC='SC_'.$result[success_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result[failure_count]))
{
$FC='FC_0';
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$FC='FC_'.$result[failure_count];
$style='background: #ADD8E6;color:#000000';
}

if(empty($result[InRequest]))
{
$IR='IR_0';
}
else
{
$IR='IR_'.$result[InRequest];
}
if($result['upload_for']=='deactive')
{
$style='background: #ADD8E6;color:#000000';
}
else if(empty($result[success_count]) and  empty($result[failure_count]))
{
$style='background: #FF0000;color:#ffffff;font-weight:bold';
}
else
{
$style='background: #ADD8E6;color:#000000';
}
$message .= "<tr style='".$style."'><td><strong>".$result['batch_id']."</strong> </td><td>" .$result['added_on']."</td><td>".$result['upload_for']."</td><td>".$result['status']."</td><td>".$result['service_id']."</td><td>".$TC."</td><td>".$SC."</td><td>".$FC."</td><td>".$IR."</td><td style='font-weight:bold'>Reliance</td></tr>";


}

}
	
$message .= "</table>";
$message .= "</body></html>";
//end of message 
//mysql_close($con);
//close database connection here
$to = 'satay.tiwari@hungama.com';
//$bcc = 'athar.haider@hungama.com';
//$cc = 'vinod.chauhan@hungama.com';
$cc_ops = 'voice.ops@hungama.com';
$cc_noc = 'voice.noc@hungama.com';
$cc_voice = 'voice.bill@hungama.com';
$cc_sd = 'voice.sd@hungama.com';
$cc_dev = 'voice.dev@hungama.com';

			$from = 'voice.mis@hungama.com';
			$subject = $operator.' New BU History';
			$headers = "From: " . $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$curdate = date("Y_m_d");
$path_log='zipemail/logs/bulk/ALL_BULK_ALERT_'.$curdate.'.txt';
$logdata='Operator'."#".$operator.'#Time'."#".date("H:i:s")."\r\n";
	if($operator=='airtel')
	 {
	
	mail('dheeraj.goel@hungama.com', $subject, $message, $headers);
	mail('manu.sharma@hungama.com', $subject, $message, $headers);
   
			 foreach($emailArray as $email)
				{
				mail($email, $subject, $message, $headers);
			/*	if($email!='rajneesh.srivastava@hungama.com')
				{
				mail($email, $subject, $message, $headers);
				}				
				*/
				}
			//mail($to, $subject, $message, $headers);	
			//mail($cc, $subject, $message, $headers);
			mail($cc_ops, $subject, $message, $headers);
			mail($cc_noc, $subject, $message, $headers);
			mail($cc_voice, $subject, $message, $headers);
			//mail($bcc, $subject, $message, $headers);
			mail($cc_sd, $subject, $message, $headers);
			mail($cc_dev, $subject, $message, $headers);
			error_log($logdata,3,$path_log);
	    }
	 else if($operator=='Voda')
	 {
	
	 mail('nitin.kothare@hungama.com', $subject, $message, $headers);
	 mail('dheeraj.goel@hungama.com', $subject, $message, $headers);
	 mail('manu.sharma@hungama.com', $subject, $message, $headers);
	
	           foreach($emailArray as $email)
				{
				mail($email, $subject, $message, $headers);
				}
			//mail($to, $subject, $message, $headers);	
			//mail($cc, $subject, $message, $headers);
			mail($cc_ops, $subject, $message, $headers);
			mail($cc_noc, $subject, $message, $headers);
			mail($cc_voice, $subject, $message, $headers);
			//mail($bcc, $subject, $message, $headers);
			mail($cc_sd, $subject, $message, $headers);
			mail($cc_dev, $subject, $message, $headers);
			error_log($logdata,3,$path_log);
	 }
	 else if($operator=='MTS')
	 {
	mail('dheeraj.goel@hungama.com', $subject, $message, $headers);
	 		  foreach($emailArray as $email)
				{
				mail($email, $subject, $message, $headers);
				}
			//mail($to, $subject, $message, $headers);	
			//mail($cc, $subject, $message, $headers);
			mail($cc_ops, $subject, $message, $headers);
			mail($cc_noc, $subject, $message, $headers);
			mail($cc_voice, $subject, $message, $headers);
			//mail($bcc, $subject, $message, $headers);
			mail($cc_sd, $subject, $message, $headers);
			mail($cc_dev, $subject, $message, $headers);
			error_log($logdata,3,$path_log);
	 }
	      
	else if($operator=='Uninor')
	 {
		/* foreach($emailArray as $email)
				{
				mail($email, $subject, $message, $headers);
				}
			mail($cc_ops, $subject, $message, $headers);
			mail($cc_noc, $subject, $message, $headers);
			mail($cc_voice, $subject, $message, $headers);
			mail($cc_dev, $subject, $message, $headers);
			*/
			//echo $message;
			mail('satay.tiwari@hungama.com', $subject, $message, $headers);
			mail('athar.haider@hungama.com', $subject, $message, $headers);
			mail('vinod.chauhan@hungama.com', $subject, $message, $headers);
			//error_log($logdata,3,$path_log);
	    }
	 else if($operator=='TATA')
	 {
/*	           foreach($emailArray as $email)
				{
				mail($email, $subject, $message, $headers);
				}
				
			mail($cc_ops, $subject, $message, $headers);
			mail($cc_noc, $subject, $message, $headers);
			mail($cc_voice, $subject, $message, $headers);
			mail($cc_dev, $subject, $message, $headers);
			error_log($logdata,3,$path_log);
			*/
			mail('satay.tiwari@hungama.com', $subject, $message, $headers);
			mail('athar.haider@hungama.com', $subject, $message, $headers);
			mail('vinod.chauhan@hungama.com', $subject, $message, $headers);

	 }
 else if($operator=='Reliance')
	 {
	           foreach($emailArray as $email)
				{
				mail($email, $subject, $message, $headers);
				}
			//	mail('satay.tiwari@hungama.com', $subject, $message, $headers);
			//	mail('athar.haider@hungama.com', $subject, $message, $headers);
				//mail('vinod.chauhan@hungama.com', $subject, $message, $headers);
			mail($cc_ops, $subject, $message, $headers);
			mail($cc_noc, $subject, $message, $headers);
			mail($cc_voice, $subject, $message, $headers);
			mail($cc_dev, $subject, $message, $headers);
			
		error_log($logdata,3,$path_log);
	 }
//return $message;	 
	 }

$operator='airtel';
//getTotalHistory($operator,$emailAirtelArray);
$operator='MTS';
//getTotalHistory($operator,$emailMTSArray);
$operator='Voda';
//getTotalHistory($operator,$emailVodaArray);
$operator='Uninor';
getTotalHistory($operator,$emailUninorArray);
$operator='TATA';
getTotalHistory($operator,$emailTataArray);
$operator='Reliance';
//getTotalHistory($operator,$emailRelArray);
echo 'done';
?>