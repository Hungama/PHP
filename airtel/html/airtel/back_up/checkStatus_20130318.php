<?php
error_reporting(0);

include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
if(!$dbConn) {
	die('We are facing some temporarily Problem , please try later : ');
}

$msisdn =$_GET['msisdn'];
$reqtype =$_GET['reqtype'];
$service =$_GET['sname'];

if($reqtype=='CHECK')
{	
	function checkmsisdn($msisdn,$flag)
	{
		if(strlen($msisdn)==12 || strlen($msisdn)==10 )
		{
			if(strlen($msisdn)==12)
			{
				if(substr($msisdn,0,2)==91)
				{
					$msisdn = substr($msisdn, -10);
				}
				else
				{
					if($flag==1)
					{
						echo "Failed";
					}
						exit;
				}
			}
		}
		elseif(strlen($msisdn)!=10)
		{
			if($flag==1)
			{
				echo "Failed";
			}
			exit;
		}
	return $msisdn;
	}

	$msisdn=checkmsisdn($msisdn,$flag);	

	if($service) {
		$serviceArray=array(1=>'airtel_SPKENG.tbl_spkeng_subscription');
	} else {
		$serviceArray=array(1=>'airtel_rasoi.tbl_rasoi_subscription',2=>'airtel_vh1.tbl_jbox_subscription',3=>'airtel_hungama.tbl_jbox_subscription', 4=>'airtel_hungama.tbl_mtv_subscription',5=>'airtel_manchala.tbl_riya_subscription',6=>'airtel_EDU.tbl_jbox_subscription', 7=>'airtel_rasoi.tbl_storeatone_subscription',8=>'airtel_mnd.tbl_character_subscription1',9=>'airtel_devo.tbl_devo_subscription', 10=>'airtel_hungama.tbl_comedyportal_subscription',11=>'airtel_SPKENG.tbl_spkeng_subscription',12=>'airtel_radio.tbl_radio_subscription', 13=>'airtel_hungama.tbl_pk_subscription',14=>'airtel_hungama.tbl_arm_subscription');

		$unsubServiceArray=array(1=>'airtel_rasoi.RASOI_UNSUB',2=>'airtel_vh1.JBOX_UNSUB',3=>'airtel_hungama.JBOX_UNSUB', 4=>'airtel_hungama.MTV_UNSUB', 5=>'airtel_manchala.RIYA_UNSUB',6=>'airtel_EDU.JBOX_UNSUB',7=>'airtel_rasoi.STOREATONE_UNSUB',8=>'airtel_mnd.MND_UNSUB',9=>'airtel_devo.devo_unsub', 10=>'airtel_hungama.COMEDY_UNSUB',11=>'airtel_SPKENG.JBOX_UNSUB',12=>'airtel_radio.RADIO_UNSUB',13=>'airtel_hungama.PK_UNSUB', 14=>'airtel_hungama.ARM_UNSUB');
	}
	$abc=count($serviceArray);	
	
	if($_GET['act'] == 'deact') {
		$path = "/var/www/html/airtel/logs/checkStatus/unsub_".date("Y-m-d").".txt";
		$id = $_REQUEST['service'];
		$callUnsub = "CALL ".$unsubServiceArray[$id]."('".$msisdn."','CC')";
		$logData = $msisdn."#".$callUnsub."#".date('Y-m-d H:i:s')."\n";
		mysql_query($callUnsub);
		error_log($logData,3,$path);		
	}
	$newFlag = 0;
	for($i=1;$i<=$abc;$i++)
	{
		switch($serviceArray[$i])
		{
			case "airtel_rasoi.tbl_rasoi_subscription":
				$serviceId='55001';
				$serviceName='Good Life (Hungama GL)';
				break;
			case "airtel_vh1.tbl_jbox_subscription":
				$serviceId='55841';
				$serviceName='Vh1 Radio GAGA Hungama';
				break;
			case "airtel_hungama.tbl_jbox_subscription":
				$serviceId='54646';
				$serviceName='Entertainment Portal 54646 (Hungama HM)';
				break;
			case "airtel_hungama.tbl_mtv_subscription":
				$serviceId='546461';
				$serviceName='Hungama MTV DJ DIAL';
				break;
			case "airtel_manchala.tbl_riya_subscription":
				$serviceId='5500169';
				$serviceName='Miss Riya (Hungama IVR)';
				break;
			case "airtel_EDU.tbl_jbox_subscription":
				$serviceId='53222345';
				$serviceName='Personality Development (Hungama IVR)';
				break;
			case 'airtel_rasoi.tbl_storeatone_subscription':
				$serviceId='5500101';
				$serviceName='Airtel Store@1 ';
				break;
			case 'airtel_mnd.tbl_character_subscription1':
				$serviceId='5500196';
				$serviceName='My Naughty Diary Character';
				break;
			case 'airtel_devo.tbl_devo_subscription':
				$serviceId='51050';
				$serviceName='Airtel Devotional';
				break;
			case 'airtel_hungama.tbl_comedyportal_subscription':
				$serviceId='5464612';
				$serviceName='Airtel Comedy';
				break;
			case 'airtel_SPKENG.tbl_spkeng_subscription':
				$serviceId='571811';
				$serviceName='Spoken English';
				break;
			case 'airtel_radio.tbl_radio_subscription':
				$serviceId='546469';
				$serviceName='Airtel Entertainment Unlimited';
				break;
			case 'airtel_hungama.tbl_pk_subscription':
				$serviceId='5464613';
				$serviceName='Airtel Palleturi Kathalu';
				break;
			case 'airtel_hungama.tbl_arm_subscription':
				$serviceId='5464614';
				$serviceName='Airtel Regional';
				break;
		}

		$queryOne="select ani from ".$serviceArray[$i]." where ani='".$msisdn."' and status=1";
		if($_GET['test']) echo "<br/>".$queryOne;
		$execute_queryOne=mysql_query($queryOne); //echo mysql_num_rows($execute_queryOne);		

		if(mysql_num_rows($execute_queryOne))
		{
			$newFlag++;
			if($newFlag == 1) { ?>
				<table width='50%'>
				<tr>
					<th align='center' width="30%">Service Name</th>
					<th align='center'>Deactivate Link</th>
				</tr>
			<?php }
			echo "<tr><td>".$serviceName."</td><td align='center'>"."<a href='checkStatus.php?msisdn=".$msisdn."&service=".$i."&act=deact&reqtype=CHECK'>Deactivate Service</a></td></tr>";
		}		
	}
	if($newFlag)  {
		echo "</table>";
	}
	if(!$newFlag) {
		echo "No service subscribed for <b>".$msisdn."</b> MDN";
	}
	mysql_close($dbConn);
}
else
{
	echo "Invalid reqtype";
}