<?php
error_reporting(0);

include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
if(!$dbConn) {
	die('We are facing some temporarily Problem , please try later : ');
}

$msisdn =$_GET['msisdn'];
$flag =$_GET['flag'];
$reqtype =$_GET['reqtype'];
$service =$_GET['sname'];

if ($reqtype=='CHECK')
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
		$serviceArray=array(1=>'airtel_rasoi.tbl_rasoi_subscription',2=>'airtel_vh1.tbl_jbox_subscription',3=>'airtel_hungama.tbl_jbox_subscription', 4=>'airtel_hungama.tbl_mtv_subscription',5=>'airtel_manchala.tbl_riya_subscription',6=>'airtel_EDU.tbl_jbox_subscription',7=>'airtel_rasoi.tbl_storeatone_subscription',8=>'airtel_mnd.tbl_character_subscription1',9=>'airtel_devo.tbl_devo_subscription',10=>'airtel_hungama.tbl_comedyportal_subscription',11=>'airtel_SPKENG.tbl_spkeng_subscription',12=>'airtel_radio.tbl_radio_subscription',13=>'airtel_hungama.tbl_pk_subscription',14=>'airtel_hungama.tbl_arm_subscription');
	}
	$abc=count($serviceArray);		
	header("Content-type: text/xml");
	echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
	echo "<ROOT>\n";
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
				$serviceName='Store@1 ';
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

		$queryOne="select * from ".$serviceArray[$i]." where ani='".$msisdn."' and status=1";
		if($_GET['test']) echo $queryOne;
		$execute_queryOne=mysql_query($queryOne);
		if(mysql_num_rows($execute_queryOne))
		{
			echo "<SERVICE>\n";
			echo "<SVCID>".$serviceId."</SVCID>\n";
			echo "<SVCDESC>".$serviceName."</SVCDESC>\n";
			echo "<STATUS>ACTIVE</STATUS>\n";
			echo "</SERVICE>\n";
		}
	}
	echo "</ROOT>\n";
	mysql_close($dbConn);
}
else
{
	echo "Invalid reqtype";
}