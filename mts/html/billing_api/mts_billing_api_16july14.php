<?php
$reqName=strtoupper($_GET['rn']);
$msisdn=trim($_GET['msisdn']);
$test=trim($_GET['test']);
$RPid=trim($_GET['RPid']);
$serviceid=($_GET['serviceid']);
$serviceid1=($_GET['serviceid']);
$flag = $_GET['flag'];
$date=date("dmY H:i:s");
$tranx_id=date("YmdHis");
$logDir="/var/www/html/billing_api/log/";
$logFile=date('dmY')."_log";
$logFilePath=$logDir.$logFile.".txt";
$filePointer=fopen($logFilePath,'a+');

if($serviceid==1103)
  $serviceid=156;
elseif($serviceid==1101 || $serviceid==1124) 
{
	if($flag == 1)
	  { 
		$serviceid=171;
	 }
	 else { $serviceid=160;	}
}
elseif($serviceid==1102)
   $serviceid=155;
elseif($serviceid==1106)
   $serviceid=174;
elseif($serviceid==1111)
   $serviceid=169;
elseif($RPid==90103004 || $RPid==90203004 || $RPid==90303003)
   $serviceid=216;//updated as per bugify on 11 oct 13
elseif($serviceid==1110)
   $serviceid=173; 
elseif($serviceid==1116)
{
   if($flag == 1)
	  $serviceid=182;
else 
	 $serviceid=181;
}


switch($serviceid)
{
	case '1113':
		switch($RPid)
		{
			case '90502972':
				$serviceid=192;
			break;
			case '91002969':
				$serviceid=192;
			break;
			case '91502971':
				$serviceid=192;
			break;
			case '92002957':
				$serviceid=192;
			break;
			case '92502942':
				$serviceid=192;
			break;
			case '93002950':
				$serviceid=192;
			break;
			case '90502973':
				$serviceid=193;
			break;
			case '91002970':
				$serviceid=193;
			break;
			case '91502972':
				$serviceid=193;
			break;
			case '92002958':
				$serviceid=193;
			break;
			case '92502943':
				$serviceid=193;
			break;
			case '93002951':
				$serviceid=193;
			break;
			case '91002971':
				$serviceid=194;
			break;
			case '92002959':
				$serviceid=194;
			break;
			case '93002952':
				$serviceid=194;
			break;
		}
	break;
	case '1125':
	switch($RPid)
		{
			case '93003011':
				$serviceid=222;
			break;
			case '93003010':
				$serviceid=223;
			break;
			case '92503007':
				$serviceid=222;
			break;
			case '92503006':
				$serviceid=223;
			break;
			case '92003011':
				$serviceid=222;
			break;
			case '92003010':
				$serviceid=223;
			break;
			case '91503007':
				$serviceid=222;
			break;
			case '91503006':
				$serviceid=223;
			break;
			case '91003009':
				$serviceid=222;
			break;
			case '91003008':
				$serviceid=223;
			break;
			case '90503007':
				$serviceid=222;
			break;
			case '90503006':
				$serviceid=223;
			break;
			case '90303002':
				$serviceid=222;
			break;
			case '90303001':
				$serviceid=223;
			break;
			case '90203003':
				$serviceid=222;
			break;
			case '90203002':
				$serviceid=223;
			break;
			case '90103003':
				$serviceid=222;
			break;
			case '90103002':
				$serviceid=223;
			break;
			case '93003012':
				$serviceid=224;
			break;
			case '92003012':
				$serviceid=224;
			break;
			case '91003010':
				$serviceid=224;
			break;

		}
	break;
}

switch($serviceid1)
{
	case '1101':
	case '1124':
		switch($RPid)
		{
			case '90103000':
				$serviceid=215;
			break;
			case '90103001':
				$serviceid=215;
			break;
			case '91702906':
				$serviceid=255;
			break;
			case '91902906':
				$serviceid=255;
			break;

		}
	break;
}
$rpId54646Array=array(90102962,90202917,90302922,90402911,90502980,90602914,90702963,90802911,90902910,91002979,91102912,91202913,91302912,91402911,91502993,91602911,91702911,
91802913,91902911,92002967,92102912,92202911,92302910,92402911,92502950,92602911,92702910,92802911,92902910,93002974);
if(in_array($RPid,$rpId54646Array) && $serviceid1==1102)
{
	$serviceid=253;

}

$rpIddevoArray=array(90202913,90302918,90402907,90502976,90602910,90702959,90802907,90902906,91002975,91102908,91202909,91302908,91402907,
91502989,91602907,91702907,91802909,91902907,92002963,92102908,92202907,92302906,92402907,92502946,92602907,92702906,92802907,92902906,93002970);
if(in_array($RPid,$rpIddevoArray) && $serviceid1==1111)
{
	$serviceid=254;

}

$rpIdMUArray=array(90102958,90202912,90402906,90602909,90802906,91002974,91202908,91402906,91602906,91802908,92002962,92202906,92402906,92602906,92802906,93002969);
if(in_array($RPid,$rpIdMUArray) && $serviceid1==1101)
{
	$serviceid=255;

}

//MPD-EventBased_My Private Diary _Hungama
$rpIdMPDArray=array(90102961,90202916,90302921,90402910,90502979,90602913,90702962,90802910,90902909,91002978,91102911,91202912,91302911,91402910,91502992,91602910,91702910,91802912,91902910,92002966,92102911,92202910,92302909,92402910,92502949,92602910,92702909,92802910,92902909,93002973);
if(in_array($RPid,$rpIdMPDArray) && $serviceid1==1113)
{
	$serviceid=256;

}

//EventBased_Red FM _Hungama
$rpIdEREDFMArray=array(90102959,90202914,90302919,90402908,90502977,90602911,90702960,90802908,90902907,91002976,91102909,91202910,91302909,91402908,91502990,91602908,91702908,91802910,91902908,92002964,92102909,92202908,92302907,92402908,92502947,92602908,92702907,92802908,92902907,93002971);
if(in_array($RPid,$rpIdEREDFMArray) && $serviceid1==1110)
{
	$serviceid=257;

}

//EventBased_Voice Alert _Hungama
$rpIdEVAArray=array(90102960,90202915,90302920,90402909,90502978,90602912,90702961,90802909,90902908,91002977,91102910,91202911,91302910,91402909,91502991,91602909,91702909,91802911,91902909,92002965,92102910,92202909,92302908,92402909,92502948,92602909,92702908,92802909,92902908,93002972);
if(in_array($RPid,$rpIdEVAArray) && $serviceid1==1116)
{
	$serviceid=258;

}

//new configured-> MTS Contesting Portal Subscription
$rpIdCPSArray=array(90103010,90203010,90303009,90503008,91003011,91503008,92003013,92503008,93003013);
if(in_array($RPid,$rpIdCPSArray) && $serviceid1==1123)
{
	$serviceid=229;

}
//MTS Contesting Portal Renewal
$rpIdCPRArray=array(90103011,90203011,90303010,90503009,91003012,91503009,92003014,92503009,93003014);
if(in_array($RPid,$rpIdCPRArray) && $serviceid1==1123)
{
	$serviceid=230;

}

//MTS Regional Portal Subscription
$rpIdRPSArray=array(90103012,90203012,90303011,90503010,91003013,91503010,92003015,92503010,93003015);
if(in_array($RPid,$rpIdRPSArray) && $serviceid1==1126)
{
	$serviceid=231;

}
//MTS Regional Portal Renewal
$rpIdRPRArray=array(90103013,90203013,90303012,90503011,91003014,91503011,92003016,92503011,93003016);
if(in_array($RPid,$rpIdRPRArray) && $serviceid1==1126)
{
	$serviceid=232;

}

//Event contest
$rpIdCPArray=array(93002501,92902500,92802500,92702500,92602500,92502500,92402500,92302500,92202500,9202500,92002501,91902500,91802500,91702500,91602500,91502501,91402500,91302500,91202500,91102500,91002501,90902500,90802500,90702501,90602500,90502501,90402500,90302501,90202501,90102501);
if(in_array($RPid,$rpIdCPArray) && $serviceid1==1123)
{
	$serviceid=302;

}
//Event reginoal
$rpIdRPArray=array(90102502,90202502,90302502,90402501,90502502,90602501,90702502,90802501,90902501,91002502,91102501,91202501,91302501,91402501,91502502,91602501,91702501,91802501,91902501,92002502,9202501,92202501,92302501,92402501,92502501,92602501,92702501,92802501,92902501,93002502);
if(in_array($RPid,$rpIdRPArray) && $serviceid1==1126)
{
	//$serviceid=303;
	$serviceid=231;

}
//Event jokes portal
$rpIdJPArray=array(90102503,90202503,90302503,90402502,90502503,90602502,90702503,90802502,90902502,91002503,91102502,91202502,91302502,91402502,91502503,91602502,91702502,91802502,91902502,92002503,9202502,92202502,92302502,92402502,92502502,92602502,92702502,92802502,92902502,93002503);
if(in_array($RPid,$rpIdJPArray) && $serviceid1==1125)
{
	$serviceid=304;

}
/********RedFM Renewal for 1,2,3************/
$rpIdEREDFMRENEWALArray=array(90103005,90203005,90303004);
if(in_array($RPid,$rpIdEREDFMRENEWALArray) && $serviceid1==1110)
{
	$serviceid=217;
}


/********My Private Diary(Subscription)************/
$rpIdMPDNEWALArray=array(90103006,90303005,90203006);
if(in_array($RPid,$rpIdMPDNEWALArray) && $serviceid1==1113)
{
	$serviceid=218;
}
/********My Private Diary (Renewal)************/
$rpIdMPDRENWALNEWALArray=array(90103007,90203007,90303006);
if(in_array($RPid,$rpIdMPDRENWALNEWALArray) && $serviceid1==1113)
{
	$serviceid=219;
}
/********54646 Entertainment Portal(Subscription)************/
$rpId54646NEWALArray=array(90103008,90203008,90303007);
if(in_array($RPid,$rpId54646NEWALArray) && $serviceid1==1102)
{
	$serviceid=220;
}
/********54646 Entertainment Portal(Renewal)************/
$rpId54646RENEWALNEWALArray=array(90103009,90203009,90303008);
if(in_array($RPid,$rpId54646RENEWALNEWALArray) && $serviceid1==1102)
{
	$serviceid=221;
}


//AutoChurn/AutoRenewal RPID start here
if($RPid==90003000 && $serviceid1==1101) 
{
$serviceid=323;
}
elseif($RPid==90003002 && $serviceid1==1111) 
{
$serviceid=325;
}
elseif($RPid==90003004 && $serviceid1==1106) 
{
$serviceid=327;
}
elseif($RPid==90003006 && $serviceid1==1113) 
{
$serviceid=329;
}
elseif($RPid==90003008 && $serviceid1==1102) 
{
$serviceid=331;
}
elseif($RPid==90003012 && $serviceid1==1116) 
{
$serviceid=335;
}
elseif($RPid==90003014 && $serviceid1==1110) 
{
$serviceid=337;
}
elseif($RPid==90003016) 
{
$serviceid=339;
}
////////End here////////////////////////

$urltopost = "http://10.130.14.40:8080//cvp/chargingServlet";
switch($reqName)
{
	case 'QB':
		$data1="<RealTimeOperationRequest xmlns='xmltypes.cs.cvp.hp.com'>";
		$data1 .="<REQUEST_NAME>QB</REQUEST_NAME>";
		$data1 .="<MSISDN>$msisdn</MSISDN>";
		$data1 .="</RealTimeOperationRequest>";
	break;
	case 'TP':
		$data1="<RealTimeOperationRequest xmlns='xmltypes.cs.cvp.hp.com'>";
		$data1.="<SERVICE_ID>$serviceid</SERVICE_ID>";
		$data1.="<ISV_ID>4</ISV_ID>";
		$data1.="<REQUEST_NAME>EventSubscription</REQUEST_NAME>"; 
		$data1.="<REQUEST_TYPE>0</REQUEST_TYPE>";  
		$data1.="<MSISDN>$msisdn</MSISDN>";    
		$data1.="<RATE_PLAN_ID>$RPid</RATE_PLAN_ID>";
		$data1.="</RealTimeOperationRequest>";	
		break;
	default:
		$data1="<RealTimeOperationRequest xmlns='xmltypes.cs.cvp.hp.com'>";
		$data1.="<SERVICE_ID>$serviceid</SERVICE_ID>";
		$data1.="<ISV_ID>4</ISV_ID>";
		$data1.="<REQUEST_NAME>EventSubscription</REQUEST_NAME>"; 
		$data1.="<REQUEST_TYPE>0</REQUEST_TYPE>";  
		$data1.="<MSISDN>$msisdn</MSISDN>";    
		$data1.="<RATE_PLAN_ID>$RPid</RATE_PLAN_ID>";
		$data1.="</RealTimeOperationRequest>";
	break;
}


$resultData=postData($urltopost,$data1);

if($test==1)
{
	echo $urltopost."?".$data1;
	echo $resultData;
	exit;
}

$start_pos=strpos($resultData,"_CODE>");
$end_pos=strpos($resultData,"</RESULT_CODE>");
$response_code=substr($resultData,$start_pos+6,$end_pos-74);



$start_pos_desc=strpos($resultData,"<RESULT_DESC>");
$end_pos_desc=strpos($resultData,"</RESULT_DESC>");
$response_Desc=substr($resultData,$start_pos_decs+107,$end_pos_desc-107);


if($reqName=='QB' && $response_code==2001)
{
	$start_pos_qb=strpos($resultData,"<CUSTOMER_BALANCE>");
	$end_pos_qb=strpos($resultData,"</CUSTOMER_BALANCE>");
	$response_balance=substr($resultData,$start_pos_qb+18,$end_pos_qb-195);
}

if($response_code==2001)
	$response_str='OK';
else
	$response_str='NOK';


if($reqName=='QB' && $response_code==2001)
	$response_str='OK';

$response_str1=$response_str."#".$response_code."#".$response_Desc."#".$tranx_id;
		if($reqName=='QB')
		$response_str1 .="#".$response_balance;
		else
		$response_str1 .="#".$serviceid;

	echo $response_str1;

	fwrite($filePointer,$reqName."|".$data1."|".$response_str1."|".date("his")."\r\n");
	fclose($filePointer);


function postData($urltopost,$data1)
{
	$ch = curl_init ($urltopost);
	curl_setopt ($ch, CURLOPT_POST, true);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$returndata = curl_exec ($ch);
	return $returndata;
	exit;
}


?>
