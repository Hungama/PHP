<?php
/*===============================================================================================================================


===============================================================================================================================*/

//================================================ Variable Declaration =================================================

global $msisdn;
global $accept_txt;
global $model;
global $wap_profile;
global $Hkey;
global $SingTelUid;
global $Remote_add; 
global $full_user_agent;
global $wap_profile_link;
global $header_str;

$Remote_add=$_SERVER["REMOTE_ADDR"];	
$date=date('Ymd');
$time_stamp=date('His');

//================================================ Variable Declaration =================================================

# In hw_data.php3 file each handset array is of length = total content Type
# TypeId of each content represents the index for its support id

$tata_indicom_flag=0; # Tata indicom MSISDN Capturing Value default value
$headers = getallheaders();

while(list($name, $value) = each ($headers))
{ 
	$name = strtolower(trim($name));
	$wap_profile = 'X';
	if( $name == "Accept" )
	{ 
		$acc_appln=$value;
	}
		
	/********************************** USER HANDSET DETECTION *********************************/
	
	if( $name == "user-agent" )
	{
		$full_user_agent = $value;
		/*--------------------------------------------------------------------------------------------------------
			exceptional case for opera mini users - added by surin bhawsar - 04 Nov 2010
			in this case the following headers are sent by the users browser
			*******************************************************************************************
			User-Agent : Opera/9.80 (J2ME/MIDP; Opera Mini/5.0.16823/21.529; U; en) Presto/2.5.25 Version/10.54
			X-OperaMini-Phone : Nokia # N97
			X-OperaMini-Phone-UA : Mozilla/5.0 (SymbianOS/9.4; U; Series60/5.0 NokiaN97/10.0.001; Profile/MIDP-2.1 Configuration/CLDC-1.1 ) AppleWebKit/525 (KHTML, like Gecko) Safari/525
			*******************************************************************************************
			so if we can figure out if it is opera mini and substitute the User-Agent with X-OperaMini-Phone-UA we
			can get our handset.
		-------------------------------------------------------------------------------------------------------- */

		$pos_opera_mini = strpos(strtolower($full_user_agent), 'opera mini');
		if($pos_opera_mini>0)
		{
			$full_user_agent = $headers['X-OperaMini-Phone-UA'];
		}

		include_once "/var/www/html/hungamacare/wapstream/hungamawap/hs_capture.php3"; // Handset Identification Mechanism 
		$model = hs_identifier($full_user_agent);
		$model_to_DB = $model;
		$model = strtolower(trim($model));
		// below lines added 
		$model = trim($model,"\\");
		$model = trim($model,"/");
		$model = str_replace("+","",$model);
		
		if(strlen(trim($model)) <= 0 || trim($model)=="")
		{
			$handset_missing_log="/usr/local/apache/logs/mobile/".date("Ymd")."_hs_not_found.txt"; // Missing Handset Details Log
			$handset_missing_str= date('His')."|".$full_user_agent."|".$wap_profile_link."\n";
			error_log($handset_missing_str,3,$handset_missing_log);
			chmod($handset_missing_log, 0777);
		}
		
		$nhandset=$value;
	}
	
	/****************************************************************************************************************/
	if (($name == "x-wap-profile") || ($name == "profile"))
	{
		$wap_profile = $value;
		$wap_profile_link = $value;
	}
	
	/****************************************************************************************************************/
	if(strtolower(trim($name)) == "x-nokia-prepaidind") //Idea User Plan Check -- Header //X-Nokia-prepaidind
	{
		$plan_val = $value;
		$plan_id_array =explode(":", $plan_val); # Plan Value check added by Sunil on 26-03-2012 to avoid '4: 1' error value 
		$plan_value=trim($plan_id_array[0]);
		
		if($plan_value==0400 || $plan_value==4 )
			$plan_value=4;
		elseif($plan_value==0800 || $plan_value==8)
			$plan_value=8;
		else
			$plan_value=8;	
	}

	/******************************************* User MSISDN Identification *******************************************/

	//Added by hrushikesh on 29-02-2008 for Idea Header
	if( strtolower($name) == "cookie") 
	{ 
		$ref= array();
		$ref=explode (";", $value);
		for($i=0; $i<count($ref); $i++)
		{
			$ref1= array();
			$ref1 = explode ("=", $ref[$i]);
			
			if($ref1[0]=='User-Identity-Forward-msisdn')
			{
				if($REMOTE_ADDR == '165.21.42.84')
					$SingTelUid = $ref1[1];
				else
					$msisdn = $ref1[1];
			}
					
			if($ref1[0]=='apn')
				$apn=$ref1[1];
                        
                         if($ref1[0]=='imsi')
                        {
                            $imsi = $ref1[1];
                            $resp = shell_exec("sh /usr/local/apache/htdocs/checkimsi.sh $msisdn $imsi");
                            $res_array =explode("|",$resp);
                            $operator_id = $res_array [2];
                            $area_id =$res_array[3];
                            $imsi_str = trim($resp)."|".trim($imsi)."|".date("YmdHis")."\n";
                            $imsi_logs = "/usr/local/apache/logs/".date('Ymd')."_aircel_imsi.txt";
                            error_log($imsi_str,3,$imsi_logs);
                            
                        }
		}		
	}	//	---------- End Of if($name == "cookie" ) 
	
	if($name == "x-msisdn"|| $name == "msisdn" || $name == "x-up-calling-line-id" || $name == "x-wsb-identity"||$name == "x-nokia-msisdn" ||$name == "x-wap-clientid"|| $name == "x-msisdn" || $name == "_rapmin" || $name == "msisdn" || $name == "x-up-calling-line-id" || $name == "xmsisdn" || $name == "x-mdn" || $name == "x-wap-network-client-msisdn" || $name == "user-identity-forward-msisdn" || $name == "mdn" || $name=="NBG-IMP-MSISDN" || $name == "MDN" )
	{
		if(strlen(trim($value)) > 0) # Condition to get the MSISDN from the Various Headers specified in the above If 
		{
			$msisdn = $value;	
		}
	}
		
	//============== Identification Header Value for the Tata Indicom User Added By Sunil on 11-07-2012  =================
		
	if((strtolower($name) == "x-up-bear-type" || strtolower($name) == "x-huawei-networktype") && (trim(strtolower($value))=='cdma' || trim(strtolower($value))=='cdma csd')) 
	{
		$tata_indicom_flag=1;		
	}
	//============== End of Identification Header Value for the Tata Indicom User Added By Sunil on 11-07-2012  ===========

	if(strtolower(trim($name)) == strtolower("x-mdn"))
	{
		$msisdn = $value;				//echo "no".$msisdn;		
		$tata_cdma_msisdn = $value;
	}
	//	Added by dhanraj on 9/9/2011 for MTS - Internet Profile
	if(strtolower(trim($name)) == "mdn")
	{
		$msisdn = $value;
	}
	
	if(strtolower(trim($name)) == strtolower("_rapmdn")) # Added By Sunil On 16-10-2012 for Reliance WAP Headers
	{
		if(strlen($value)==10)
			$msisdn = $value;
	}

	if(strlen($msisdn) == 10)
	{
		$msisdn = "91".$msisdn;
	}
	if(strlen($msisdn)<=0)
	{
		$query_string_captured=$_SERVER['QUERY_STRING'];

		parse_str($query_string_captured);
		
		$valid_msisdn=$msisdn;
		
		$check_valid=substr($valid_msisdn,0,2);
		
		if($check_valid==27)
		{
			$msisdn=$valid_msisdn;	
		}			
	}
		
	//mobile number in headers is coming in the foll format 919835140859, 97.253.26.143
	//from reliance wap gateway - so changes made accordingly by surin - 11 Sep 2009
	$pos = strpos($msisdn, ",");
	if($pos > 0)
	{
		$temp_arr = explode(",", $msisdn);
		$msisdn = trim($temp_arr[0]);
	}
		
	$msisdn = trim(str_replace('+','',$msisdn));
	
	/*************************************** End Of User MSISDN Identification ***************************************/

	if($name=="host")
	{
		$header_str .="\n";
	}
	$header_str .="$name|$value &";	
	
	# To capture the APN value
	if ($name == "apn") {
		$apn = $value;
	}
	
}

if($tata_indicom_flag==1) # Variale used for the Tata CDMA MSISDN Capturing 12-07-2012
{
	$msisdn = $tata_cdma_msisdn;
	
	# added By Sandip on 10-Dec-2013 for correct indicom 12 digit msisdn 
	if(strlen($msisdn) < 11)	$msisdn = '91'.$msisdn;
}

if(strlen($msisdn)<=0)
{
	$header_log = "/usr/local/apache/logs/empty_msisdn_headerlog_".$date.".txt";	
	$empty_msisdn =$time_stamp."|".$header_str."&".$_SERVER['REQUEST_URI'];
	error_log($empty_msisdn, 3, $header_log);
}





############################### Condition Added By Siddharth and Sunil on 26-03-2012 ###############################

/*$hungama_blocked_msisdn_arr = array(919831076976,919897001695,919163460367,919007081453,919840329385,919821546363,918855056795,918855056794,919175623904,919771446061,919894015750,919771446061,918018222202,918097260303,919028532080,919840531632,919894101373,919840531632,919431618405);

if(in_array(trim($msisdn),$hungama_blocked_msisdn_arr)) #Hungama Blocked MSISDN
{
	echo "You are not Autherised.";
	exit;
}*/
/*
#####################################################################################################################


######################## Condition Added By Kavita on 06-05-2014 as per Jira PD-5560####################

$msisdn_mnp = $msisdn;
if(!is_numeric($msisdn) || $msisdn == '' || $msisdn == 0) {
        $msisdn_mnp = 1;
}

$operator_mnp = "/usr/local/apache/htdocs/operator_log.sh";
$operator_mnp_id = shell_exec("sh $operator_mnp $msisdn_mnp $Remote_add");
########################################################################################################


$op_check_flag = 0;

if($msisdn)
{
	$res = shell_exec("sh /usr/local/apache/htdocs/op/operator.sh $msisdn");
    $response = explode("|",$res);
    //$operator=$response[3];  
	$operator_id=$response[4];
}

if($operator_id == 1 or $operator_id == 19)
{
	$op_check_flag = 1;	
}

$msisdn_block_chk = exec('sh /usr/local/apache/htdocs/msisdn_blacklist.sh ' . $msisdn);

if($msisdn_block_chk == 1  && $op_check_flag == 0)
{
        header("Location: http://202.87.41.147/hungamawap/hungama/156295/index.php3");
        exit;
}

# Added by Kiran Wagh on 18-Mar-2014 # PD-5411
if(trim($msisdn) == '919831282723') #Airtel Blocked MSISDN
{
        header("Location: http://202.87.41.147/hungamawap/airtel/155061/index.php3");
        exit;
}

## Added By Kiran Wagh on 13-MAY-2014
$blacklist_msisdn_path = "/usr/local/apache/htdocs/hungamawap/airtel/plugins/blacklist.txt";
$bl_cnt = exec("grep $msisdn $blacklist_msisdn_path | wc -l");

if($bl_cnt > 0) {
	header("Location:http://202.87.41.147/hungamawap/airtel/155061/index.php3");
	exit();
}

#####################################################################################################################

// this Provision is made to Show another link to HTC USER to download HungamaMyPlay.
if($allow_htc = strstr($full_user_agent, 'HTC'))
{
	$htc_player= 1;
	error_log("HTC|$time_stamp|$full_user_agent|$htc_player|$allow_htc \n\n", 3, "/usr/local/apache/logs/apps/htc_allow_$date.txt");
}

#####################################################################################################################

$download_path = "http://202.87.41.147/waphung/new_download/";
$content_download_path = "http://202.87.41.147/waphung/content_download/";
$maxis_download_path = "http://202.87.41.147/waphung/maxis_confirm/";
$maxis_preview_path = "http://202.87.41.147/waphung/maxis_download/";
#This path is made for testing purpose
$maxis_preview_path_test = "http://202.87.41.147/waphung/maxis_download_test/";

$singtel_download_path = "http://202.87.41.147/waphung/singtel_confirm/";
$m1_download_path = "http://202.87.41.147/waphung/m1_confirm/";
$rogers_download_path = "http://202.87.41.147/hungamawap/rogers/confirm.php3?";
$fido_download_path = "http://202.87.41.147/hungamawap/fido/confirm.php3?";#added by manju for fido on 17-feb-06
$rc_download_path="http://202.87.41.147/waphung/free_download/";//added by manju on 30-mar-07 for radiocity wapsite-free download beta version

//$hungama_confirm_path = "http://202.87.41.147/hungamawap/hungama/template/zone_pg/template_confirm.php3?";
//hungama confirmation path changed by manju on 3-jan-07 for bango
$hungama_confirm_path = "http://202.87.41.147/hungamawap/hungama/template/zone_pg/template_confirm_v1.php3?";
// Added by dhanraj for Hungama Confirmation Page on 25-Feb-2006
$indiafm_confirm_path = "http://202.87.41.147/hungamawap/indiafm/template/zone_pg/template_confirm.php3?";
// Added by dhanraj for IndiaFM Confirmation Page on 1-Mar-2006
$airtel_confirm_path = "http://202.87.41.147/hungamawap/airtel/template/zone_pg/template_confirm.php3?";
//$airtel_confirm_path_150 = "http://202.87.41.150/hungamawap/airtel/template/zone_pg/template_confirm.php3?";
//Changes Done by Amruta As Airtel Shifted again to 147 from 150
$airtel_confirm_path_150 = "http://202.87.41.147/hungamawap/airtel/template/zone_pg/template_confirm.php3?";
// Added by surin for Airtel Confirmation Page on 20-Sep-2006
$du_confirm_path="http://202.87.41.147/hungamawap/du/template/zone_pg/template_confirm.php3?";
//du confirm path added by manju on 20-Apr-07
$du_confirm_path_ar="http://202.87.41.147/hungamawap/du/template/zone_pg/template_confirm_ar.php3?";
//du confirm path added by manju on 26-Apr-07
$astute_confirm_path = "http://202.87.41.147/hungamawap/astute/template/zone_pg/template_confirm_v1.php3?";
//astute confirmation path added by surin on 23-feb-08 for astute
$tata_download_path = "http://202.87.41.147/waphung/tata_download/";
//tata download path added by surin on 1-dec-08 for tata
$airtel_xhtml_confirm_path = "http://202.87.41.147/hungamawap/airtel/template/zone_pg/template_confirm_xhtml.php3?";
//$airtel_xhtml_confirm_path_150 = "http://202.87.41.150/hungamawap/airtel/template/zone_pg/template_confirm_xhtml.php3?";
//Changes Done by Amruta As Airtel Shifted again to 147 from 150.
$airtel_xhtml_confirm_path_150 = "http://202.87.41.147/hungamawap/airtel/template/zone_pg/template_confirm_xhtml.php3?";
// Added by surin for Airtel XHTML Confirmation Page on 3 Dec 2008

// Added by Anis for 3 Australia WML Confirmation Page on 17th June 2009
$three_confirm_path_wml="http://202.87.41.147/hungamawap/three/template/zone_pg/template_confirm_wml.php3?";

//////////////////////////CHANGES DONE BY VAMAN FOR NEW CMT HTTP://202.87.41.147/CMT/ -- START
//ADDED BY VAMAN R 1/12/2010
$bsnl_xhtml_confirm_path = "http://".$_SERVER['SERVER_NAME']."/hungamawap/bsnl/template/template_confirm_xhtml.php3?";
//$bsnl_xhtml_confirm_path = "http://202.87.41.147/hungamawap/bsnl/template/template_confirm_xhtml.php3?";
//$bsnl_xhtml_confirm_path = "http://wap.hungama.com/bsnl/template/template_confirm_xhtml.php3?";
//$bsnl_xhtml_confirm_path = "http://wap.hungama.com/bsnl/template/template_confirm_xhtml.php3?";
$aircel_xhtml_confirm_path = "http://202.87.41.147/hungamawap/aircel/template/template_confirm_xhtml.php3?";
$loop_xhtml_confirm_path = "http://202.87.41.147/loop/template/template_confirm_xhtml.php3?";
$reliance_xhtml_confirm_path = "http://202.87.41.147/hungamawap/reliance/template/template_confirm_xhtml.php3?";
$mtnl_xhtml_confirm_path = "http://202.87.41.147/hungamawap/mtnl/template/template_confirm_xhtml.php3?";
$mtnld_xhtml_confirm_path = "http://202.87.41.147/hungamawap/mtnld/template/template_confirm_xhtml.php3?";
$hungama_xhtml_confirm_path = "http://202.87.41.147/hungamawap/hungama/template/template_confirm_xhtml.php3?";
$nokia_xhtml_confirm_path = "http://202.87.41.147/hungamawap/nokia/template/template_confirm_xhtml.php3?";
$tatasky_xhtml_confirm_path = "http://202.87.41.147/tatasky/template/template_confirm_xhtml.php3?";
$iamshe_xhtml_confirm_path ="http://202.87.41.147/iamshe/template/template_confirm_v1.php3?";
$vlive_xhtml_confirm_path = "http://202.87.41.147/vlive/template/template_confirm_xhtml.php3?";
$docomo3g_xhtml_confirm_path = "http://202.87.41.147/docomo3g/template/template_confirm_xhtml.php3?";
$indicom_xhtml_confirm_path = "http://202.87.41.147/indicom/template/template_confirm_xhtml.php3?";
$rworld_xhtml_confirm_path = "http://202.87.41.147/hungamawap/rworld/template/template_confirm_xhtml.php3?";
//////////////////////////CHANGES DONE BY VAMAN FOR NEW CMT HTTP://202.87.41.147/CMT/ -- END
////////////////////////////////CHANGES by  parikshit////////////////////
$airteldth_xhtml_confirm_path = "http://202.87.41.147/airteldth/template/template_confirm_xhtml.php3?";
///////////////////////End/////////////////////////////////////////////////////////

$model_key = strtolower($model);

$edge_handset = array('nokia3220', 'nokia6230', 'nokia6230i', 'nokia6630', 'nokia6220', 'nokia3230', 'nokia6680', 'nokia6681', 'lg-ke970', 'nokia6300', 'nokia8800', 'nokia5300', 'sec-sghd840', 'nokia6280', 'sec-sghe490', 'nokia6270', 'nokia5500d', 'nokia6070' , 'nokia6233', 'nokia6708', 'lg-ke820 mic', 'nokiae65-1', 'nokiae60-1', 'nokiae61-1', 'nokian70', 'nokian70-1', 'nokian71-1', 'nokian72', 'nokian73','nokian73-1', 'nokian80-1', 'nokian90', 'nokian91-1', 'nokian93-1', 'nokia3250', 'nokiae50-1', 'nokiae70-1', 'nokia9500', 'nokia9300');

//new feature to read handset details from XML instead of array data file
//added by surin - 20th jan 2009
//if else added by aatif since du will have handset models read from different folder viz. du_xml. will check for msisdn and 97155 at the start to confirm if its du user
$du_identifier = substr($msisdn,0,5);

if($du_identifier == "97155")
{
	include "/usr/local/apache/htdocs/handset_support/handset_xml_reader.php3";
}
else
{
	include "/usr/local/apache/htdocs/handset_support/handset_xml_reader.php3";
	
	//Surin - 3rd June 2009
	//implemented code below to incorporate new handset configuration on the fly. once implemented
	//successfully need to stop inclusion handset_xml_reader.php3 and include handset_xml_reader_v2.php3
	
	$myFile_v2 = "/usr/local/apache/htdocs/handset_support/xml_v2/".$model.".xml";
	if(file_exists($myFile_v2))
	{
		//include "/usr/local/apache/htdocs/handset_support/handset_xml_reader_v2.php3";
	}
	else
	{
		$wap_profile_req = str_replace("\"","",$wap_profile_link);
		$pos_extn_end =  strpos($wap_profile_req, ".xml");
		if(!$pos_extn_end)
			$pos_extn_end =  strpos($wap_profile_req, ".rdf");
		$pos_extn_end = $pos_extn_end + 4;
		$wap_profile_req = substr($wap_profile_req, 0, $pos_extn_end);
	}
}

if(in_array($model_key, $edge_handset)) 
	$htype="edge";
else
	$htype="gprs";

$fst_chr_model = trim(strtolower(substr($model, 0, 1)));
$model_key = strtolower($model);

if(!$Hkey)
{
	//NEW LOG FOR NEW HANDSETS AS PER NEW FUNCTION - ADDED BY SURIN - 23 JUNE 2008
	$logString="$time_stamp|$model_to_DB|$full_user_agent|$wap_profile_link|$fst_chr_model|$model_key|$Hkey|$client_group \n";
	$fname = "/usr/local/apache/logs/apps/all_new_hs_log_$date.txt";
	error_log($logString,3,$fname);
}

 $three_Hkey =1;

if($browser_support_id==173 || $browser_support_id==175) // Added by dhanraj on 13th April 2009 CHTML and HTML to XHTML
{
	$browser_support_id=172; 
}

if($Hkey == 0) // Added by Anis as per the request by Tejas to serve default browser support as XHTML on 14 May 2010 
{
	$browser_support_id=172; 
}

//default content setting for wp, ani and poly and logo width
if($logo_wd==0) $logo_wd = 166;					//default 166x20 banner
if($wp_support_id == 0) $wp_support_id = 190;	//default wallpaper size changed to 320x320 requested by Tejas instead of 176x176.
if($poly_support_id == 0) $poly_support_id = 30;//default polytone 4 channel midi
if($ani_support_id == 0) $ani_support_id = 15;	//default animation 176x176
if($sms_poly_support_id == 0) $sms_poly_support_id = 78;	//default sms polytone 4 channel midi

/// FUNCTION TO CAPTURE USER INFORMATION ---HUTCH Added by manju on 2 mar 06
function visitor_log($msisdn,$model,$Remote_add,$zid, $client_id,$type,$level, $pg_no)
{
	global $full_user_agent;
	global $wap_profile_link;
	global $imsi;
	global $apn;
	
	//substr($full_user_agent,0,150) modified by Swapnil on 21-Sep-2009
	$date=date("dmy");
	$pdate=date("dmyHis");
	$conString="$msisdn|".substr($model,0,150)."|".substr($Remote_add,0,30)."|$zid|$client_id|$type|$level|$pg_no|$pdate|$imsi|$apn|".substr($full_user_agent,0,150)."|$wap_profile_link \n";

	$fname = "/usr/local/apache/logs/apps/visitor_log_".$date.".txt";	
	error_log($conString,3,$fname);
	
	//hourly log was written here - removed by surin - 20th Jan 09
	//write new log having only UA Prof and User Agent - added by surin - 18th Apr 2009 - request by sandeep
	
	$conString_ua = $time_stamp."|".substr($full_user_agent,0,150)."|$wap_profile_link \n\n";
	$fname_ua = "/usr/local/apache/logs/apps/visitor_log_UA_Prof_$date.txt";
	error_log($conString_ua,3,$fname_ua);
}
/// FUNCTION TO CAPTURE USER INFORMATION -- END 


// Added by Anis for providing Area ID,Area Name of a particular Msisdn through their respective XML generated via CMT
if($msisdn)
{
	$res = shell_exec("sh /usr/local/apache/htdocs/op/operator.sh $msisdn");
    $response = explode("|",$res);
    $circle_name=$response[2];
    $circle_id=$response[5];		//$operator=$response[3];  //$operator_id=$response[4];
}

if($area_id != '')
    $circle_id=$area_id;

//new functions created by surin on 21st July 2010 for assistance in download files
include "/usr/local/apache/htdocs/hungamawap/functions_for_download_assistance.php3";

if(!$msisdn)
{
	$arrIdeaIPs = array("115.184.131.242","115.184.164.83","115.184.189.163","115.184.197.9","115.184.199.210","115.184.202.118","115.184.212.236","115.184.230.224","115.184.232.71","115.184.236.105","115.69.159.213","115.69.128.0","115.69.128.1","115.69.128.2","115.69.128.3","115.69.128.4","115.69.128.5","115.69.128.6","115.69.128.7","115.69.128.8","115.69.128.9","115.69.128.10","115.69.128.11","115.69.128.12","115.69.128.13","115.69.128.14","115.69.128.15","115.69.128.16","115.69.128.17","115.69.128.18","115.69.128.19","115.69.128.20","115.69.144.0","115.69.144.1","115.69.144.2","115.69.144.3","115.69.144.4","115.69.144.5","115.69.144.6","115.69.144.7","115.69.144.8","115.69.144.9","115.69.144.10","115.69.144.11","115.69.144.12","115.69.144.13","115.69.144.14","115.69.144.15","115.69.144.16","115.69.144.17","115.69.144.18","115.69.144.19","115.69.144.20","115.69.144.21","115.69.152.0","115.69.152.1","115.69.152.2","115.69.152.3","115.69.152.4","115.69.152.5","115.69.152.6","115.69.152.7","115.69.152.8","115.69.152.9","115.69.152.10","115.69.152.11","115.69.152.12","115.69.152.13","115.69.152.14","115.69.152.15","115.69.152.16","115.69.152.17","115.69.152.18","115.69.152.19","115.69.152.20","115.69.152.21","115.69.152.22","112.110.0.0","112.110.0.1","112.110.0.2","112.110.0.3","112.110.0.4","112.110.0.5","112.110.0.6","112.110.0.7","112.110.0.8","112.110.0.9","112.110.0.10","112.110.0.11","112.110.0.12","112.110.0.13","112.110.0.14","112.110.0.15","112.110.0.16","112.110.0.17","112.110.0.18","112.110.0.19","112.110.96.0","112.110.96.1","112.110.96.2","112.110.96.3","112.110.96.4","112.110.96.5","112.110.96.6","112.110.96.7","112.110.96.8","112.110.96.9","112.110.96.10","112.110.96.11","112.110.96.12","112.110.96.13","112.110.96.14","112.110.96.15","112.110.96.16","112.110.96.17","112.110.96.18","112.110.96.19","112.110.40.0","112.110.40.1","112.110.40.2","112.110.40.3","112.110.40.4","112.110.40.5","112.110.40.6","112.110.40.7","112.110.40.8","112.110.40.9","112.110.40.10","112.110.40.11","112.110.40.12","112.110.40.13","112.110.40.14","112.110.40.15","112.110.40.16","112.110.40.17","112.110.40.18","112.110.40.19","112.110.40.20","112.110.40.21","112.110.52.0","112.110.52.1","112.110.52.2","112.110.52.3","112.110.52.4","112.110.52.5","112.110.52.6","112.110.52.7","112.110.52.8","112.110.52.9","112.110.52.10","112.110.52.11","112.110.52.12","112.110.52.13","112.110.52.14","112.110.52.15","112.110.52.16","112.110.52.17","112.110.52.18","112.110.52.19","112.110.52.20","112.110.52.21","112.110.52.22","112.110.56.0","112.110.56.1","112.110.56.2","112.110.56.3","112.110.56.4","112.110.56.5","112.110.56.6","112.110.56.7","112.110.56.8","112.110.56.9","112.110.56.10","112.110.56.11","112.110.56.12","112.110.56.13","112.110.56.14","112.110.56.15","112.110.56.16","112.110.56.17","112.110.56.18","112.110.56.19","112.110.56.20","112.110.56.21","112.110.128.0","112.110.128.1","112.110.128.2","112.110.128.3","112.110.128.4","112.110.128.5","112.110.128.6","112.110.128.7","112.110.128.8","112.110.128.9","112.110.128.10","112.110.128.11","112.110.128.12","112.110.128.13","112.110.128.14","112.110.128.15","112.110.128.16","112.110.128.17","112.110.128.18","112.110.128.19","115.69.157.224","115.69.157.225","115.69.157.226","115.69.157.227","112.110.160.0","112.110.160.1","112.110.160.2","112.110.160.3","112.110.160.4","112.110.160.5","112.110.160.6","112.110.160.7","112.110.160.8","112.110.160.9","112.110.160.10","112.110.160.11","112.110.160.12","112.110.160.13","112.110.160.14","112.110.160.15","112.110.160.16","112.110.160.17","112.110.160.18","112.110.160.19","112.110.160.20","112.110.176.0","112.110.176.1","112.110.176.2","112.110.176.3","112.110.176.4","112.110.176.5","112.110.176.6","112.110.176.7","112.110.176.8","112.110.176.9","112.110.176.10","112.110.176.11","112.110.176.12","112.110.176.13","112.110.176.14","112.110.176.15","112.110.176.16","112.110.176.17","112.110.176.18","112.110.176.19","112.110.176.20","112.110.192.0","112.110.192.1","112.110.192.2","112.110.192.3","112.110.192.4","112.110.192.5","112.110.192.6","112.110.192.7","112.110.192.8","112.110.192.9","112.110.192.10","112.110.192.11","112.110.192.12","112.110.192.13","112.110.192.14","112.110.192.15","112.110.192.16","112.110.192.17","112.110.192.18","112.110.192.19","10.9.59.123");

	if(in_array($Remote_add, $arrIdeaIPs))
	{
		 header("location: http://202.87.41.147/hungamawap/idea/7606/apn.php3?logo_wd=166");
	}
}


## ------------------- The following Code is Added to get the Logs of every request received from the Docomo End User -------- ##

## Added By Sunil on 16-08-2011 

$docomo_check = trim(strtolower($_SERVER['REQUEST_URI']));
if((substr_count($docomo_check,'/hungamawap/docomo/promo') > 0)|| (substr_count($docomo_check,'/hungamawap/docomo/index') > 0) || (substr_count($docomo_check,'/docomo3g/') > 0) )
{
	$docomo_fname_log = "/usr/local/apache/logs/apps/docomo_visitore_log_$date.txt";
	if(trim(strlen($msisdn))==0)
		$msisdn_str='NA';	
	else
		$msisdn_str=$msisdn;
	
	$docomo_log=$time_stamp."|".$REMOTE_ADDR."|".$docomo_check."|".date("H")."|".$msisdn_str."\n";
	error_log($docomo_log,3,$docomo_fname_log);
}

## ------------------- The following Code is Added to get the Logs of every request received from the Docomo End User -------- ##

############# Added By Sandip on 16 Dec 2011 for bsnl requst ############################
$bsnl_log_check = trim(strtolower($_SERVER['REQUEST_URI']));
if((substr_count($bsnl_log_check,'/hungamawap/bsnl/promo') > 0)|| (substr_count($bsnl_log_check,'/hungamawap/bsnl/index') > 0) || (substr_count($bsnl_log_check,'/bsnl/') > 0) )
{
	if(trim(strlen($msisdn))==0){
		$msisdn_str='NA';	
	}
	else
	{
		$msisdn_str=$msisdn;

		################## To Check if Product is subscribed on BSNL Re1 Product OR Not ############
		#################################### Kiran Wagh 16/10/2012 #################################

		$retstat = exec('sh /usr/local/apache/htdocs/blacklist/bsnl_blacklist.sh ' . $msisdn_str);

		if($retstat == 0)
		{
			//$bsnl_sub_url = "http://202.87.41.148/wap/bsnl/bsnl_re1_activation.php?msisdn=$msisdn_str&model=$model";
			//$response_bsnl = file_get_contents($bsnl_sub_url);

			$bsnl_sublog_path = "/usr/local/apache/logs/apps/bsnl_sub_log_$date.txt";
			$bsnl_sub_log = trim($time_stamp)."|".trim($REMOTE_ADDR)."|".trim($msisdn_str)."|".trim($model)."\n";
			$cnt_bsnl = shell_exec("grep -c $msisdn_str $bsnl_sublog_path");
			if($cnt_bsnl == 0)
			{
				error_log($bsnl_sub_log,3,$bsnl_sublog_path);	
			}
		}

		#############################################################################################
	}

	$bsnl_log = "/usr/local/apache/logs/apps/bsnl_visitore_log_$date.txt";
	$bsnl_log_str = $time_stamp."|".$REMOTE_ADDR."|".$bsnl_log_check."|".$msisdn_str."\n";
	error_log($bsnl_log_str,3,$bsnl_log);
}
*/
########################################################################
// Added by Sandip on 16th Jul 2012 for manual msisdn set
session_start();
if(isset($_SESSION['x-manual-msisdn']) && is_numeric($_SESSION['x-manual-msisdn']) && $_SESSION['HTTP_USER_AGENT'] == md5($_SERVER['HTTP_USER_AGENT'])) {
	$msisdn = $_SESSION['x-manual-msisdn'];
}

?>