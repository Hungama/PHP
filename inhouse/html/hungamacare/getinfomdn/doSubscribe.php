<?php
//include("db.php");
$msisdn=trim($_REQUEST['msisdn']);
$servicename=$_REQUEST['obd_form_service'];
$planid=$_REQUEST['obd_form_pricepoint'];
$amount=$_REQUEST['obd_form_amount'];
$sub_mode=$_REQUEST['sub_mode'];
$servicetype=$_REQUEST['servicetype'];
$reqtype=1;
//Bollywood_Merijaan_Hungama>>1005
if($servicetype=='sub')
{
//echo $msisdn."@SID@".$servicename."@PP@".$planid."@PAMT@".$amount."@MODE@".$sub_mode."\r\n";
}
//exit;
$operator_url='';
	$include_operator=substr($servicename, 0, 2);
	switch($include_operator)
{
	case '10':
	//	$operator_url = "docomo";
	$serviceid_name_array=array('1001'=>'EndlessMusic','1002'=>'HungamaMedia_Hungama','1003'=>'MTVLive_Hungama','1005'=>'Bollywood_Merijaan_Hungama','1007'=>'docomo_vh1','1009'=>'docomo_Riya','1010'=>'docomo_REDFM','1011'=>'docomo_mylife');
if (array_key_exists($servicename, $serviceid_name_array)) {
    $servicename=$serviceid_name_array[$servicename];
	}
else
{
$servicename='INVALID';
}
		$operator_url = "http://192.168.100.212/docomo/endlessmusic.php";
		$parameter="?msisdn=".$msisdn."&mode=".$sub_mode."&reqtype=1&planid=".$planid."&subchannel=".$sub_mode."&servicename=".$servicename;
		break;
	case '12':
	//reliance
		$operator_url = "http://192.168.100.212/reliance/reliance.php";
		$parameter="?msisdn=".$msisdn."&mode=".$sub_mode."&reqtype=1&planid=".$planid."&subchannel=".$sub_mode."&serviceid=".$servicename."&ac=0";
	    break;
	case '14':
		//$operator_url = "uninor";  12/6 NA
		$serviceid_name_array=array('1402'=>'uninor_54646','1403'=>'uninor_MTV','1410'=>'uninor_RED','1409'=>'uninor_RIYA','1416'=>'uninor_jyotish','1408'=>'uninor_sportsUnlimited');
		if (array_key_exists($servicename, $serviceid_name_array)) {
    $servicename=$serviceid_name_array[$servicename];
	}
else
{
$servicename='INVALID';
}
		$operator_url = "http://192.168.100.212/Uninor/uninor.php";
		$parameter="?msisdn=".$msisdn."&mode=".$sub_mode."&reqtype=1&planid=".$planid."&subchannel=".$sub_mode."&servicename=".$servicename;
		break;
case '16':
$serviceid_name_array=array('1609'=>'indicom_Riya','1607'=>'indicom_vh1','1611'=>'indicom_mylife','1602'=>'HungamaMedia_Hungama','1601'=>'EndlessMusic','1603'=>'MTVLive_Hungama','1610'=>'indicom_Redfm','1605'=>'Bollywood_Merijaan_Hungama');
if (array_key_exists($servicename, $serviceid_name_array)) {
    $servicename=$serviceid_name_array[$servicename];
	}
else
{
$servicename='INVALID';
}
		$operator_url = "http://192.168.100.211/indicom/tataIndicom.php";
		$parameter="?msisdn=".$msisdn."&mode=".$sub_mode."&reqtype=1&planid=".$planid."&subchannel=".$sub_mode."&servicename=".$servicename;
		break;

}



//msisdn,mode, reqtype=1,planid, subchannel=mod,rcode='',serviceid,ac=0,param,aftid
if($servicename=='INVALID')
{
echo "Currently unavailable";
exit;
}
else
{
$hiturl=$operator_url.$parameter;
}
//curl call for this request start here
if($include_operator=='10' || $include_operator=='12' || $include_operator=='14' || $include_operator=='16')
//if(1)
{
//echo $hiturl;
//$response=file_get_contents($hiturl);
//echo $response;

  $api_call= curl_init($hiturl);
	curl_setopt($api_call,CURLOPT_RETURNTRANSFER,TRUE);
	$api_exec= curl_exec($api_call);
	curl_close($api_call);
	echo $crl_resp=trim($api_exec);
}
else
{
echo "Currently unavailable";
}
exit;
?>