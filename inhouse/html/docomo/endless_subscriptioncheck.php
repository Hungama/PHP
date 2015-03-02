<?php
error_reporting(0);
$con = mysql_connect("192.168.100.224","webcc","webcc");
$msisdn=$_REQUEST['msisdn'];
$reqtype=$_REQUEST['reqtype'];
$servicename=strtolower(trim($_REQUEST['operator']));
/*
if(strlen($msisdn)==10)
	{
		$msisdn='91'.$msisdn;
	}
	else
	{
		$msisdn=$msisdn;
	}
	*/

	if (($msisdn == "") || ($servicename==""))
	{
		echo "Please provide the complete parameter";
	}
	else
	{
		switch($servicename)
		{
			
			case 'vmi':
				$s_id='1801';
				$dbname="docomo_radio";
				$con_p='and plan_id=40';
				$subscriptionTable="tbl_radio_subscription";
				$unSubscriptionTable="tbl_radio_unsub";
				$operator = "VIRM";
			break;
			case 'docomo':
				$s_id='1001';
				$dbname="docomo_radio";
				$subscriptionTable="tbl_radio_subscription";
				$unSubscriptionTable="tbl_radio_unsub";
				$operator = "TATM";
				break;
			case 'indicom':
				$s_id='1601';
				$dbname="indicom_radio";
				$subscriptionTable="tbl_radio_subscription";
				$unSubscriptionTable="tbl_radio_unsub";
				$operator = "TATC";
				break;
			}	
			
		if(!$con)
		{
			die('could not connect1: ' . mysql_error());
		}
		
			$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' $con_p";
			$qry1=mysql_query($sub);
			$rows1 = mysql_fetch_row($qry1);
			
			if($rows1[0] <=0)
			{
				$result=0;
				echo "NewUser";
			}
			else {
				$result=2;
				echo "Already Subscribed";
			}

			
	}
	mysql_close($con);
?>   
