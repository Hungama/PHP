<?php
$msisdn =$_GET['msisdn'];
$flag =$_GET['flag'];
$servicename=trim($_REQUEST['servicename']);
$test=trim($_REQUEST['test']);
$celebrityArray=array(1=>'Salman Khan',2=>'Aamir Khan',3=>'Akshay Kumar',4=>'Ajay Devgan',5=>'Ranbir Kapoor',6=>'Hritik Roshan',7=>'Imran Khan',8=>'Emraan Hashmi',9=>'Amitabh Bachan',10=>'Sharukh Khan',11=>'Katrina Kaif',12=>'Sonakshi Sinha',13=>'Deepika Padukone',14=>'kareena Kapoor',15=>'Anuskha Sharma',16=>'Asin Thottumkal',17=>'Priyanka Chopra',18=>'Kangana Ranaut',19=>'Vidya Balan',20=>'Aishwariya Rai',21=>'Saif Ali Khan',22=>'Farhan Akhtar',23=>'John Abraham',24=>'Shahid Kapoor',25=>'Ranveer Singh',26=>'Sanjay Dutt',27=>'Irrfan Khan',28=>'Naseeruddin Shah',29=>'Arjun Rampal',30=>'Abhay Deol',31=>'R Madhavan',32=>'Ameesha Patel',33=>'Amrita Rao',34=>'Ayesha Takia',35=>'Bipasha Basu',36=>'Kajol',37=>'Lara Dutta',38=>'Minissha Lamba',39=>'Preity Zinta',40=>'Reemma Sen',41=>'Riya Sen',42=>'Soha Ali Khan',43=>'Sonam Kapoor',44=>'Sushmita Sen',61=>'Madhubala',62=>'Shatrughan');

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
$con = mysql_connect("database.master","weburl","weburl");
if(!$con)
{
	die('We are facing some temporarily Problem , please try later : ');
//	. mysql_error()
}
if(isset($servicename) && $servicename!='')
{
	$abc=explode(',',$servicename);
	$no_of_servicename=count($abc);
	for($i=0;$i<$no_of_servicename;$i++)
	{
		switch($abc[$i])
		{
			case 'FilmiMeriJaan':
				$dbname="docomo_starclub";
				$subscriptionTable="tbl_jbox_subscription";
				break;
			case 'MTVLive_Hungama':
				$dbname="docomo_hungama";
				$subscriptionTable="tbl_mtv_subscription";
				break;
			case 'HungamaMedia_Hungama':
				$dbname="docomo_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				break;
			case '':
				$servicename='EndlessMusic';
				$dbname="docomo_radio";
				$subscriptionTable="tbl_radio_subscription";
				break;
			case 'EndlessMusic':
				$dbname="docomo_radio";
				$subscriptionTable="tbl_radio_subscription";
				break;
			case 'FollowCeleb':
				$dbname="follow_up";
				$subscriptionTable="tbl_subscription";
				break;
			case 'Endless_VMI':
				$dbname="docomo_radio";
				$subscriptionTable="tbl_radio_subscription";
				break;
			case 'Riya':
				$dbname="docomo_manchala";
				$subscriptionTable="tbl_riya_subscription";
				break;
			case 'Prem':
				$dbname="docomo_manchala";
				$subscriptionTable="tbl_prem_subscription";
				break;
			case 'REDFM':
				$dbname="docomo_redfm";
				$subscriptionTable="tbl_jbox_subscription";
				break;
			case 'docomo_mylife':
				$dbname="docomo_rasoi";
				$subscriptionTable="tbl_rasoi_subscription";
				break;
			case 'vmi_mylife':
				$dbname="virgin_rasoi";
				$subscriptionTable="tbl_rasoi_subscription";
				break;
			case 'vmi_riya':
				$dbname="docomo_manchala";
				$subscriptionTable="tbl_riya_subscription";
				break;
			case 'vmi_REDFM':
				$dbname="virgin_redfm";
				$subscriptionTable="tbl_jbox_subscription";
				break;
			case 'docomo_vh1':
				$dbname="docomo_vh1";
				$subscriptionTable="tbl_jbox_subscription";
				break;
		}
	//	$check_query="select * from ".$dbname.".".$subscriptionTable." nolock where ANI='".$msisdn."' and STATUS='1'";
		$check_query="select * from ".$dbname.".".$subscriptionTable." nolock where ANI='".$msisdn."'";
		$execute_query=mysql_query($check_query);
		if(mysql_num_rows($execute_query)) {
			if($abc[$i]!='')
				$output.= "202"; //$output.= $abc[$i].",";
		} else {
			$output.="200";
		}
	}
	echo $output;
}
else
{
	$servicesname="EndlessMusic,Filmi Meri Jaan,MTVLive_Hungama,VH1_Hungama,HungamaMedia_Hungama,Riya,Prem,REDFM,Filmy MeriJaan Celebrity chat,vmi_REDFM,My Life,MyLife,docomo_vh1,Artist Aloud Voice";
	$services=explode(',',$servicesname);
	$tablename="docomo_radio.tbl_radio_subscription,docomo_starclub.tbl_jbox_subscription,docomo_hungama.tbl_mtv_subscription,docomo_vh.tbl_vh_subscription,docomo_hungama.tbl_jbox_subscription,docomo_manchala.tbl_riya_subscription,docomo_manchala.tbl_prem_subscription,docomo_redfm.tbl_jbox_subscription,docomo_starclub.tbl_celebrity_evt_ticket,virgin_redfm.tbl_jbox_subscription,docomo_rasoi.tbl_rasoi_subscription, virgin_rasoi.tbl_rasoi_subscription, docomo_vh1.tbl_jbox_subscription,docomo_hungama.tbl_jbox_subscription";
	$table=explode(',',$tablename);
	$output='';
	for ($i=0;$i<count($table);$i++)
	{		
		//$check_query ="select * from ".$table[$i]." nolock where ANI='".$msisdn."' and STATUS='1' ";
		$check_query ="select * from ".$table[$i]." nolock where ANI='".$msisdn."'";
		if($i==4) { $check_query .=" and DNIS!='5464639'"; }
		if($i==13) { $check_query .=" and DNIS='5464639'"; }
		if($test==1) {
			echo $check_query;
			echo "<br>";
		}

		$execute_query=mysql_query($check_query);
		if(mysql_num_rows($execute_query))
		{
			if($output) 
				$output.= ",".$services[$i];
			else 
				$output.= $services[$i];

			/*if($i==count($services)-1) {
				$output.=$services[$i];
				#echo $services[$i];
			} else {	
				$output.= $services[$i].",";
				#echo $services[$i].",";
			}*/
		}
		else
		{
			$output.="";
		}
	}

	//if($test==1)	{
		$k=0;
		$getFollwUpRecordQuery="select Celeb_id from follow_up.tbl_subscription where ani=".$msisdn." and status=1 and service_id=1005";
		$followUpResult=mysql_query($getFollwUpRecordQuery);
		$totalCount=mysql_num_rows($followUpResult);
		if(mysql_num_rows($followUpResult))
		{
			while($followUpResultSet=mysql_fetch_row($followUpResult))
			{
				if($output) 
					$output.= ",Follow ".$celebrityArray[$followUpResultSet[0]];
				else
					$output.= "Follow ".$celebrityArray[$followUpResultSet[0]];
				/*if($k==($totalCount-1))
					$output.= "Follow ".$celebrityArray[$followUpResultSet[0]];
				else
					$output.= ",Follow ".$celebrityArray[$followUpResultSet[0]];*/
				$k++;
			}
		}
	//}
	$flagoutput=explode(',',$output);
	if($flag==1)
	{
		if (in_array("EndlessMusic",$flagoutput))
			echo "Success";
		else
			echo "Failed";
		exit;
	}
	if(trim($output)=="")
		echo "The number entered ".$msisdn." is currently not subscribed";
	else
		echo "The number entered ".$msisdn." is currently subscribed to ".$output;
}

if($con)
	mysql_close($con);
?>