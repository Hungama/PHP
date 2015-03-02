<?php
$msisdn =$_GET['msisdn'];
$flag =$_GET['flag'];
$servicename=trim($_REQUEST['servicename']);
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
$con = mysql_connect("database.master_mts","billing","billing");
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
				$dbname="mtv_starclub";
				$subscriptionTable="tbl_jbox_subscription";
				break;
			case 'MTVLive_Hungama':
				$dbname="mts_mtv";
				$subscriptionTable="tbl_mtv_subscription";
				break;
			case 'HungamaMedia_Hungama':
				$dbname="mtv_hungama";
				$subscriptionTable="tbl_jbox_subscription";
				break;
			case '':
				$servicename='EndlessMusic';
				$dbname="mtv_radio";
				$subscriptionTable="tbl_radio_subscription";
				break;
			case 'EndlessMusic':
				$dbname="mtv_radio";
				$subscriptionTable="tbl_radio_subscription";
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
	$servicesname="EndlessMusic,Bollywood_Merijaan_Hungama,MTVLive_Hungama,VH1_Hungama,HungamaMedia_Hungama,Voice Alert,My Private Diary";
	$services=explode(',',$servicesname);
	$tablename="mts_radio.tbl_radio_subscription,mts_starclub.tbl_jbox_subscription,mts_mtv.tbl_mtv_subscription,mts_vh.tbl_vh_subscription,mts_hungama.tbl_jbox_subscription,mts_voicealert.tbl_voice_subscription,mts_mnd.tbl_character_subscription1";
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