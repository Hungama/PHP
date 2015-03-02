<?php
$stype=$_REQUEST['stype'];
$to = 'satay.tiwari@hungama.com';
$cc = 'vinod.chauhan@hungama.com';
$cc_ops = 'ms.ops@hungama.com';
$cc_noc = 'ms.noc@hungama.com';
$cc_sd = 'ms.sd@hungama.com';
$cc_dev = 'ms.dev@hungama.com';

			$from = 'ms.mis@hungama.com';
			$headers = "From: " . $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		Switch($stype)
		{
		case 'UninorMyMusic':
					$subject = 'Live KPI- UninorMyMusic';
					$message="Hi Team,<br>Data not inserted for UninorMyMusic. Please check connectivity between 192.168.100.227 and Altrist Server(10.43.14.70:8181).";
		break;
		case 'UninorMU':
					$subject = 'Live KPI- UninorMU';
					$message="Hi Team,<br>Data not inserted for UninorMU. Please check connectivity between 192.168.100.227 and Altrist Server(10.43.14.70:8181).";
		break;
		case 'UninorDevo':
					$subject = 'Live KPI- UninorDevo';
					$message="Hi Team,<br>Data not inserted for UninorDevo. Please check connectivity between 192.168.100.227 and Altrist Server(10.43.14.70:8181).";
		break;
		case 'AircelMC':
					$subject = 'Live KPI- AircelMC';
					$message="Hi Team,<br>Data not inserted for AircelMC. Please check connectivity between 192.168.100.227 and Altrist Server(10.181.255.141:8080).";
		break;
		case 'AircelLM':
					$subject = 'Live KPI- AircelLM';
					$message="Hi Team,<br>Data not inserted for AircelLM. Please check connectivity between 192.168.100.227 and Altrist Server(10.181.255.141:8080).";
		break;
		case 'RechargeFail':
					$subject = 'Recharge Notification Issue';
					$message=$_REQUEST['msg'];;
		break;
		}
		
		if($stype=='RechargeFail')
		{
		mail($to, $subject, $message, $headers);
		mail($cc_noc, $subject, $message, $headers);
		}
		else
		{
		mail($to, $subject, $message, $headers);
		mail($cc, $subject, $message, $headers);
		mail($cc_ops, $subject, $message, $headers);
		mail($cc_noc, $subject, $message, $headers);
		mail($cc_sd, $subject, $message, $headers);
		}		
		echo "Email Sent";
?>