<?php
error_reporting(0);
ob_start();
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
$logFile=date('dmY')."_qalog";
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
			case '90003019':
				$serviceid=412;
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
$rpIdCPSArray=array(90103010,90203010,90303009,90503008,91003011,91503008,92003013,92503008,93003013,90003018);
if(in_array($RPid,$rpIdCPSArray) && $serviceid1==1123)
{
	if($RPid=='90003018')
		$serviceid=411;
	else
		$serviceid=229;

}
//MTS Contesting Portal Renewal
$rpIdCPRArray=array(90103011,90203011,90303010,90503009,91003012,91503009,92003014,92503009,93003014);
if(in_array($RPid,$rpIdCPRArray) && $serviceid1==1123)
{
	$serviceid=230;

}

//MTS Regional Portal Subscription
$rpIdRPSArray=array(90103012,90203012,90303011,90503010,91003013,91503010,92003015,92503010,93003015,90003020);
if(in_array($RPid,$rpIdRPSArray) && $serviceid1==1126)
{
	//$serviceid=231;
	if($RPid=='90003020')
		$serviceid=413;
	else
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
$rpIdMPDRENWALNEWALArray=array(90103007,90203007,90303006,90003030);
if(in_array($RPid,$rpIdMPDRENWALNEWALArray) && $serviceid1==1113)
{
	//$serviceid=219;
	if($RPid=='90003030')
		$serviceid=423;
	else
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

//new RPID added on 4 aug2014
$rpIdMU_SUB_REVENUEArray=array(96002500,96002501,95802500,95802501,95602500,95602501,95402500,95402501,95202500,95202501,95002500,95002501,94802500,94802501,94602500,94602501,94402500,94402501,94202500,94202501,94002500,94002501,93802500,93802501,93602500,93602501,93402500,93402501,93202500,93202501);
if(in_array($RPid,$rpIdMU_SUB_REVENUEArray) && $serviceid1==1101)
{
	$serviceid=396;

}

$rpIdMU_SUB_ActivationArray=array(93002510,93002511,92902509,92902510,92802509,92802510,92702509,92702510,92602509,92602510,92502509,92502510,92402509,92402510,92302509,92302510,92202509,92202510,92102506,92102507,92002510,92002511,91902509,91902510,91802509,91802510,91702509,91702510,91602509,91602510,91502510,91502511,91402509,91402510,91302509,91302510,91202509,91202510,91102509,91102510,91002510,91002511,90902509,90902510,90802509,90802510,90702510,90702511,90602509,90602510,90502512,90502513,90402511,90402512,90302512,90302513,90202512,90202513,90102512,90102513);
if(in_array($RPid,$rpIdMU_SUB_ActivationArray) && $serviceid1==1101)
{
	$serviceid=395;

}

$rpIdBS_REVENUEArray=array(93002512,93002513,92502511,92502512,92002512,92002513,91502512,91502513,91102511,91102512,90702512,90702513,90502514,90502515,90122500,90122501,90002501,90002502);
if(in_array($RPid,$rpIdBS_REVENUEArray) && $serviceid1==1111)
{
	$serviceid=396;

}

$rpIdContestZone_REVENUEArray=array(93002506,93002507,92902505,92902506,92802505,92802506,92702505,92702506,92602505,92602506,92502505,92502506,92402505,92402506,92302505,92302506,92202505,92202506,92102502,92102503,92002506,92002507,91902505,91902506,91802505,91802506,91702505,91702506,91602505,91602506,91502506,91502507,91402505,91402506,91302505,91302506,91202505,91202506,91102505,91102506,91002506,91002507,90902505,90902506,90802505,90802506,90702506,90702507,90602505,90602506,90502508,90502509,90402507,90402508,90302508,90302509,90202508,90202509,90102508,90102509);
if(in_array($RPid,$rpIdContestZone_REVENUEArray) && $serviceid1==1123)
{
	$serviceid=393;

}

$rpIdRegionalPortal_REVENUEArray=array(90102510,90102511,90202510,90202511,90302510,90302511,90402509,90402510,90502510,90502511,90602507,90602508,90702508,90702509,90802507,90802508,90902507,90902508,91002508,91002509,91102507,91102508,91202507,91202508,91302507,91302508,91402507,91402508,91502508,91502509,91602507,91602508,91702507,91702508,91802507,91802508,91902507,91902508,92002508,92002509,92102504,92102505,92202507,92202508,92302507,92302508,92402507,92402508,92502507,92502508,92602507,92602508,92702507,92702508,92802507,92802508,92902507,92902508,93002508,93002509);
if(in_array($RPid,$rpIdRegionalPortal_REVENUEArray) && $serviceid1==1126)
{
	$serviceid=394;

}
////////End here////////////////////////
//////Telecalling START HERE///////////////
//Telecalling-Combo of Muzic Unlimited, Voice Alert & MPD
$rpIdMU_VA_MPD_TELECALLING_Array=array(90302519,90602511,90902511,91202511,91502514,91802511,92102508,92402511,92702511,93002514,93302500,93602502,93902500,94202502,94502500,94802502,95102500,95402502,95702500,96002502,96302500,96602500,96902500,97202500,97502500,97802500,98102500,98402500,98702500,99002500,90003021);
if(in_array($RPid,$rpIdMU_VA_MPD_TELECALLING_Array) && $serviceid1==1101)
{
	$serviceid=397;

}
////Telecalling-Combo of Bhakti Sagar, Regional portal & 54646 services
$rpIdBS_RP_54646_TELECALLING_Array=array(90302520,90602512,90902512,91202512,91502515,91802512,92102509,92402512,92702512,93002515,93302501,93602503,93902501,94202503,94502501,94802503,95102501,95402503,95702501,96002503,96302501,96602501,96902501,97202501,97502501,97802501,98102501,98402501,98702501,99002501,90003022);
if(in_array($RPid,$rpIdBS_RP_54646_TELECALLING_Array) && $serviceid1==1111)
{
	$serviceid=398;

}
////Telecalling-Contest Zone, Naughty Jokes & Celebrity Chat 
$rpIdCP_NJ_CELBCHAT_TELECALLING_Array=array(90302521,90602513,90902513,91202513,91502516,91802513,92102510,92402513,92702513,93002516,93302502,93602504,93902502,94202504,94502502,94802504,95102502,95402504,95702502,96002504,96302502,96602502,96902502,97202502,97502502,97802502,98102502,98402502,98702502,99002502,90003023);
if(in_array($RPid,$rpIdCP_NJ_CELBCHAT_TELECALLING_Array) && $serviceid1==1123)
{
	$serviceid=399;

}
/////Telecalling-Combo of Unlimited Muzic & MPD
$rpIdMU_MPD_TELECALLING_Array=array(90202514,90402513,90602514,90802511,91002512,91202514,91402511,91602511,91802514,92002514,92202511,92402514,92602511,92802511,93002517,93202502,93402502,93602505,93802502,94002502,94202505,94402502,94602502,94802505,95002502,95202502,95402505,95602502,95802502,96002505,90003024);
if(in_array($RPid,$rpIdMU_MPD_TELECALLING_Array) && $serviceid1==1101)
{
	$serviceid=400;
}
/////Telecalling-Combo of Contest Zone & Bhakti Sagar
$rpIdCZ_BS_TELECALLING_Array=array(90202515,90402514,90602515,90802512,91002513,91202515,91402512,91602512,91802515,92002515,92202512,92402515,92602512,92802512,93002518,93202503,93402503,93602506,93802503,94002503,94202506,94402503,94602503,94802506,95002503,95202503,95402506,95602503,95802503,96002506,90003026);
if(in_array($RPid,$rpIdCZ_BS_TELECALLING_Array) && $serviceid1==1123)
{
	$serviceid=401;

}
////Telecalling-Unlimited Muzic 
$rpIdMU60_TELECALLING_Array=array(90102514,90202516,90302522,90402515,90502516,90602516,90702514,90802513,90902514,91002514,91102513,91202516,91302511,91402513,91502517,91602513,91702511,91802516,91902511,92002516,92102511,92202513,92302511,92402516,92502513,92602513,92702514,92802513,92902511,93002519,93102500,93202504,93302503,93402504,93502500,93602507,93702500,93802504,93902503,94002504,94102500,94202507,94302500,94402504,94502503,94602504,94702500,94802507,94902500,95002504,95102503,95202504,95302500,95402507,95502500,95602504,95702503,95802504,95902500,96002507,90003027);
if(in_array($RPid,$rpIdMU60_TELECALLING_Array) && $serviceid1==1101)
{
	//$serviceid=402;
	if($RPid=='90003027')
		$serviceid=420;
	else
		$serviceid=402;

}
/////Telecalling-Contest Zone
$rpIdCP_TELECALLING_Array=array(90102515,90202517,90302523,90402516,90502517,90602517,90702515,90802514,90902515,91002515,91102514,91202517,91302512,91402514,91502518,91602514,91702512,91802517,91902512,92002517,92102512,92202514,92302512,92402517,92502514,92602514,92702515,92802514,92902512,93002520,93102501,93202505,93302504,93402505,93502501,93602508,93702501,93802505,93902504,94002505,94102501,94202508,94302501,94402505,94502504,94602505,94702501,94802508,94902501,95002505,95102504,95202505,95302501,95402508,95502501,95602505,95702504,95802505,95902501,96002508,90003028);
if(in_array($RPid,$rpIdCP_TELECALLING_Array) && $serviceid1==1123)
{
	//$serviceid=403;
	if($RPid=='90003028')
		$serviceid=421;
	else
		$serviceid=403;

}
////Telecalling-Bhakti Sagar
$rpIdBS_TELECALLING_Array=array(90102516,90202518,90302524,90402517,90502518,90602518,90702516,90802515,90902516,91002516,91102515,91202518,91302513,91402515,91502519,91602515,91702513,91802518,91902513,92002518,92102513,92202515,92302513,92402518,92502515,92602515,92702516,92802515,92902513,93002521,93102502,93202506,93302505,93402506,93502502,93602509,93702502,93802506,93902505,94002506,94102502,94202509,94302502,94402506,94502505,94602506,94702502,94802509,94902502,95002506,95102505,95202506,95302502,95402509,95502502,95602506,95702505,95802506,95902502,96002509,90003029);
if(in_array($RPid,$rpIdBS_TELECALLING_Array) && $serviceid1==1111)
{
	//$serviceid=404;
	if($RPid=='90003029')
		$serviceid=422;
	else
		$serviceid=404;

}
///////Telecalling END HERE///////////////////////////

//MTS new Rating IDs for Zero Price Point start

//MTS new Rating IDs for Zero Price Point end

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


if($reqName=='QB' && ($response_code==2001 || $response_code==5030))
{
	$start_pos_qb=strpos($resultData,"<CUSTOMER_BALANCE>");
	$end_pos_qb=strpos($resultData,"</CUSTOMER_BALANCE>");
	$response_balance=substr($resultData,$start_pos_qb+18,$end_pos_qb-195);
}

if($response_code==2001 || $response_code==5030)
	$response_str='OK';
else
	$response_str='NOK';


if($reqName=='QB' && ($response_code==2001 || $response_code==5030))
	$response_str='OK';

$response_str1=$response_str."#".$response_code."#".$response_Desc."#".$tranx_id;
		if($reqName=='QB')
		$response_str1 .="#".$response_balance;
		else
		$response_str1 .="#".$serviceid;

	echo $response_str1;

	fwrite($filePointer,$reqName."|".$data1."|".$response_str1."|".$resultData."|".date("his")."\r\n");
	fclose($filePointer);


function postData($urltopost,$data1)
{
	$ch = curl_init ($urltopost);
	curl_setopt ($ch, CURLOPT_POST, true);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$returndata = curl_exec ($ch);
	return $returndata;
	//exit;
}
//unset all variable to reduce memory leak
unset($response_str1);
unset($reqName);
unset($msisdn);
unset($test);
unset($RPid);
unset($serviceid);
unset($serviceid1);
unset($flag);
unset($date);
unset($tranx_id);
unset($resultData);
unset($urltopost);
unset($data1);
unset($data1);
//free memory using by an array
 $myArray = null;
$rpIdMUArray= null;
$rpIdMPDArray= null;
$rpIdEREDFMArray= null;
$rpIdEVAArray= null;
$rpIdCPSArray= null;
$rpIdCPRArray= null;
$rpIdRPSArray= null;
$rpIdRPRArray= null;
$rpIdCPArray= null;
$rpIdRPArray= null;
$rpIdJPArray= null;
$rpIdEREDFMRENEWALArray= null;
$rpIdMPDNEWALArray= null;
$rpIdMPDRENWALNEWALArray= null;
$rpId54646NEWALArray= null;
$rpId54646RENEWALNEWALArray= null;
$rpIdMU_SUB_REVENUEArray= null;
$rpIdMU_SUB_ActivationArray= null;
$rpIdBS_REVENUEArray= null;
$rpIdContestZone_REVENUEArray= null;
$rpIdRegionalPortal_REVENUEArray= null;
$rpIdMU_VA_MPD_TELECALLING_Array= null;
$rpIdBS_RP_54646_TELECALLING_Array= null;
$rpIdCP_NJ_CELBCHAT_TELECALLING_Array= null;
$rpIdMU_MPD_TELECALLING_Array= null;
$rpIdCZ_BS_TELECALLING_Array= null;
$rpIdMU60_TELECALLING_Array= null;
$rpIdCP_TELECALLING_Array= null;
$rpIdBS_TELECALLING_Array= null;
?>