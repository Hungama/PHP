<?php
$msisdn =$_GET['msisdn'];
$flag =$_GET['flag'];
$test=trim($_REQUEST['test']);
$servicename=trim($_REQUEST['servicename']);
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
$con = mysql_connect("192.168.100.224","weburl","weburl");
if(!$con)
{
	die('We are facing some temporarily Problem , please try later : ');
//	. mysql_error()
}
if(isset($servicename) && $servicename!='')
{
	$abc=explode(',',$servicename);
	$no_of_servicename=count($abc);
	for($i=0;$i<=$no_of_servicename;$i++)
	{
		switch($abc[$i])
		{
			case 'Bollywood_Merijaan_Hungama':
				$dbname="indicom_starclub";
				$subscriptionTable="tbl_jbox_subscription";
				break;
			case 'MTVLive_Hungama':
				$dbname="indicom_hungama";
				$subscriptionTable="tbl_mtv_subscription";
				break;
			case 'HungamaMedia_Hungama':
				$dbname="indicom_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				break;
			case '':
				$servicename='EndlessMusic';
				$dbname="indicom_radio";
				$subscriptionTable="tbl_radio_subscription";
				break;
			case 'FollowCeleb':
				$dbname="follow_up";
				$subscriptionTable="tbl_subscription";
				break;
		}
		$check_query="select * from ".$dbname.".".$subscriptionTable." nolock where ANI='".$msisdn."' and STATUS='1'";
		$execute_query=mysql_query($check_query);
		if(mysql_num_rows($execute_query))
		{
			if($abc[$i]!='')
				echo $abc[$i].",";
			else
				echo $abc[$i];
		}
		else
		{

		}
	}
}
else
{
	$servicesname="EndlessMusic,Bollywood_Merijaan_Hungama,MTVLive_Hungama,VH1_Hungama,HungamaMedia_Hungama";
	$services=explode(',',$servicesname);
	$tablename="indicom_radio.tbl_radio_subscription,indicom_starclub.tbl_jbox_subscription,indicom_hungama.tbl_mtv_subscription,indicom_vh.tbl_vh_subscription,indicom_hungama.tbl_jbox_subscription";
	$table=explode(',',$tablename);
	$output='';
	for ($i=0;$i<count($services);$i++)
	{
		$check_query="select * from ".$table[$i]." nolock where ANI='".$msisdn."' and STATUS='1'";
		$execute_query=mysql_query($check_query);
		if(mysql_num_rows($execute_query))
		{
			if($i==count($services)-1){
				$output.=$services[$i];
				#echo $services[$i];
			}
			else
			{	
				$output.= $services[$i].",";
				#echo $services[$i].",";
			}
		}
		else
		{
			$output.="";
		}
	}
	//if($test==1)	{
		$k=1;
		$getFollwUpRecordQuery="select Celeb_id from follow_up.tbl_subscription where ani=".$msisdn." and status=1 and service_id=1605";
		$followUpResult=mysql_query($getFollwUpRecordQuery);
		$totalCount=mysql_num_rows($followUpResult);
		if(mysql_num_rows($followUpResult))
		{
			while($followUpResultSet=mysql_fetch_row($followUpResult))
			{
				if($k==($totalCount-1))
					$output.= ",Follow	".$celebrityArray[$followUpResultSet[0]].",";
				else
					$output.= "Follow	".$celebrityArray[$followUpResultSet[0]];
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
//	echo $output;
	if(trim($output)=="")
		echo "The number entered ".$msisdn." is currently not subscribed";
	else
		echo "The number entered ".$msisdn." is currently subscribed to ".$output;
}
if($con)
	mysql_close($con);
?>