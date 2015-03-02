<?php
error_reporting(0);
$con = mysql_connect("192.168.100.224","webcc","webcc");
$msisdn=$_REQUEST['msisdn'];
$reqtype=$_REQUEST['reqtype'];
$servicename=strtolower(trim($_REQUEST['operator']));
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
		
			$sub="select ANI,SUB_DATE,plan_id from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' $con_p";
			$qry1=mysql_query($sub);
			$rows=mysql_num_rows($qry1);
			$rows1 = mysql_fetch_array($qry1);
			$planData=$rows1['plan_id'];
			if($rows==0)
			{
				echo "New User";
			}
			else {
				
				
				//check for amount detect
		$select_query2_main = "select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success nolock where msisdn='$msisdn' and event_type !='Recharged' and ";
		$select_query2_main .=" plan_id=".$planData." and ";
		$select_query2_main .= " service_id=".$s_id."";
		
		$select_query3_bak = "select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_04_06_2013 nolock where msisdn='$msisdn' and event_type !='Recharged' and";
		$select_query3_bak .=" plan_id=".$planData." and ";
	    $select_query3_bak .= " service_id=".$s_id." ";

		$select_query2_bak = "select msisdn, date_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_backup nolock where msisdn='$msisdn' and event_type !='Recharged' and";
		$select_query2_bak .=" plan_id=".$planData." and ";
	    $select_query2_bak .= " service_id=".$s_id." ";
		
		$service_info_duration=2;
		
		if($service_info_duration==1)
		{
		$select_query2 = $select_query2_main." UNION ".$select_query2_bak." UNION ".$select_query3_bak." order by date_time desc limit 1 "; 		
		}
		else if($service_info_duration==2)
		{
		$select_query2 = $select_query2_main." UNION ".$select_query2_bak." order by date_time desc limit 1 "; 
		}
	//echo $select_query2;
		
		$query = mysql_query($select_query2);
		$numRows = mysql_num_rows($query);
		if($numRows)
		{
		$rows2 = mysql_fetch_array($query);
		echo "Charged Amount is- ".$rows2['chrg_amount'];
		}
		else
		{
		echo "No details found";
		}
		}

			
	}
	mysql_close($con);
?>   
