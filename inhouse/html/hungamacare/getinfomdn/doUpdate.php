<?php
include("db.php");
$msisdn=$_REQUEST['msisdn'];
$service_info=$_REQUEST['obd_form_service'];
$obd_form_pricepoint=$_REQUEST['obd_form_pricepoint'];
$obd_form_amount=$_REQUEST['obd_form_amount'];
$usersubmode=$_REQUEST['usersubmode'];
$userblance=$_REQUEST['userblance'];
$userstatus=$_REQUEST['userstatus'];
$renewdate=$_REQUEST['renewdate'];
$subdate=$_REQUEST['subdate'];
$userplanid=$_REQUEST['userplanid'];
$servicetype=$_REQUEST['servicetype'];
$channel=$_REQUEST['channel'];
if($servicetype=='sub')
{
echo $msisdn."@SID@".$service_info."@PP@".$obd_form_pricepoint."@PAMT@".$obd_form_amount."@MODE@".$channel;
}
else
{
$dbfound=1;
$new_renewdate = date("Y-m-d",strtotime($renewdate));
if($userstatus!=1 && $new_renewdate>$subdate)
{
echo "Can not update renew date."."\n\r";
exit;
}
else
{
//database selection code start here
if($service_info == '14021') $service_info='1402';
		else $service_info=$service_info;
		//$select_query1="select ANI,MODE_OF_SUB,chrg_amount,USER_BAL,plan_id,STATUS,date(SUB_DATE),date(RENEW_DATE) from ";
		
		$select_query1="UPDATE ";
			switch($service_info)
			{
				case '1001': if($_SESSION['usrId']=='269') { 
									$select_query1.= "docomo_radio.tbl_radio_smspack_sub";
								} else {
									$select_query1.= "docomo_radio.tbl_radio_subscription";
								}
				break;
				case '1801':
					$select_query1.= "docomo_radio.tbl_radio_subscription";
				break;
				case '1601':
					$select_query1.= "indicom_radio.tbl_radio_subscription";
				break;
				case '1602':
					$select_query1.= "indicom_hungama.tbl_jbox_subscription";
				break;
				case '1002':
					$select_query1.= "docomo_hungama.tbl_jbox_subscription";
				break;
				case '1003':
					$select_query1.= "docomo_hungama.tbl_mtv_subscription";
				break;
				case '1005':
					$select_query1.= "docomo_starclub.tbl_jbox_subscription";
				break;
				case '1208':
					$select_query1.= "reliance_cricket.tbl_cricket_subscription";
				break;
				case '1202':
					$select_query1.= "reliance_hungama.tbl_jbox_subscription";
				break;
				case '1402':
				case '14021':
					$select_query1.= "uninor_hungama.tbl_jbox_subscription";
				break;
				case '1203':
					$select_query1.= "reliance_hungama.tbl_mtv_subscription";
				break;
				case '1403':
					$select_query1.= "uninor_hungama.tbl_mtv_subscription";
				break;
				case '1603':
					$select_query1.= "indicom_hungama.tbl_mtv_subscription";
				break;
				case '1410':
					$select_query1.= "uninor_redfm.tbl_jbox_subscription";
				break;
				case '1009':
					$select_query1.= "docomo_manchala.tbl_riya_subscription ";
				break;
				case '1609':
					$select_query1.= "indicom_manchala.tbl_riya_subscription ";
				break;
				case '1006':
					$select_query1.= "uninor_starclub.tbl_jbox_subscription ";
				break;
				case '1606':
					$select_query1.= "indicom_starclub.tbl_jbox_subscription ";
				break;
				case '1206':
					$select_query1.= "reliance_starclub.tbl_jbox_subscription ";
				break;
				case '1406':
					$select_query1.= "uninor_starclub.tbl_jbox_subscription ";
				break;
				case '1409':
					$select_query1.= "uninor_hungama.tbl_jbox_subscription ";	
				break;
				case '1010':
					$select_query1.= "docomo_redfm.tbl_jbox_subscription ";	
				break;
				case '1412':
					$select_query1.= " uninor_myringtone.tbl_radio_ringtonesubscription ";	
				break;
				case '1605':
					$select_query1.= "indicom_starclub.tbl_jbox_subscription ";	
				break;
				case '1809':
					$select_query1.= "docomo_manchala.tbl_riya_subscription ";	
				break;
				case '1007':
					$select_query1.= "docomo_vh1.tbl_jbox_subscription ";	
				break;
				case '1607':
					$select_query1.= "indicom_vh1.tbl_jbox_subscription ";	
				break;
				case '1807':
					$select_query1.= "docomo_vh1.tbl_jbox_subscription ";	
				break;
				case '1810':
					$select_query1.= "docomo_redfm.tbl_jbox_subscription ";	
				break;
				case '1610':
					$select_query1.= "indicom_redfm.tbl_jbox_subscription ";	
				break;
				case '1611':
					$select_query1.= "indicom_rasoi.tbl_rasoi_subscription ";	
				break;
				case '1811':
					$select_query1.= "docomo_rasoi.tbl_rasoi_subscription ";	
				break;
				case '1011':
					$select_query1.= "docomo_rasoi.tbl_rasoi_subscription ";	
				break;
				case '1416':
					$select_query1.= "uninor_jyotish.tbl_jyotish_subscription ";	
				break;
				case '1408':
					$select_query1.= "uninor_cricket.tbl_cricket_subscription ";	
				break;
				default:
				$dbfound=0;
				break;
			}
			
$select_query1.= " set MODE_OF_SUB='$usersubmode', status='$userstatus',USER_BAL='$userblance',RENEW_DATE='$new_renewdate' where ANI='".$msisdn."' and plan_id=$userplanid";
//echo $select_query1;//die;
			
		if($dbfound)
			{
			$queryUpdateSubscription = mysql_query($select_query1,$con) or die(mysql_error());
//$num=1;
echo "Successfully updated.";		
		}
			else
			{
//			$num=0;
echo "Error in updating data.";
			}
			}
//end here
exit;
}
?>