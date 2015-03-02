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
//print_r($headers );
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
		$pos_opera_mini = strpos(strtolower($full_user_agent), 'opera mini');
		if($pos_opera_mini>0)
		{
			$full_user_agent = $headers['X-OperaMini-Phone-UA'];
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
	//$header_log = "/var/www/html/hungamawap/logs/emptyMsisdn/empty_msisdn_headerlog_".$date.".txt";	
	//$empty_msisdn =$time_stamp."|".$header_str."&".$_SERVER['REQUEST_URI'];
    //error_log($empty_msisdn, 3, $header_log);// stopped beacuse of heavy logs
}
?>