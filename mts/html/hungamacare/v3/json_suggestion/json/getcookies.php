<?php
$COOKIE_NAME = 'Hng_Voice_BI_ABC';
//$HOST = $_SERVER['HTTP_HOST'][0].$_SERVER['HTTP_HOST'][1].$_SERVER['HTTP_HOST'][2];

/*
if($HOST != 192) {
	echo "<font size=40>Access Denied</font>";exit;
}
*/


//echo 1;exit;
//if(!isset($_COOKIE[$COOKIE_NAME]) && !isset($_REQUEST[$COOKIE_NAME])) {
if(!isset($_COOKIE[$COOKIE_NAME])) {

		//&URL=".base64_encode(CurrentPageURL())
		echo "not found";
	//header("Location: /MIS/sHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/3/login.php?ERROR=998");exit;
} else{

	$value = ($_COOKIE[$Hng_Voice_BI_ABC])?$_COOKIE[$Hng_Voice_BI_ABC]:$_REQUEST[$COOKIE_NAME];
	list($SList,$PList,$CList,$fname,$lname,$username) = explode(":::",$value);
	$currentFile = $_SERVER["PHP_SELF"];
	$parts = Explode('/', $currentFile);
	$CURPAGE = str_replace(".php","",strtolower($parts[count($parts) - 1]));
	
	if($PAGE_TAG) {
		$CURPAGE_TAG = $PAGE_TAG;	
	} else{
		$CURPAGE_TAG = $CURPAGE;	
	}
	
	$AR_SList = explode(",",$SList);
	$AR_PList = explode(",",$PList);
	$AR_CList = explode(",",$CList);
	echo $username;
	//added by me }
	}
/*
	$UUU = mysql_query("select username,
password,
reportsto,
ac_flag,
fname,
lname,
email,
access_sec,
access_service,
access_circle,
notin,
mobile,
alert_mis,
alert_billing,
alert_obd,
alert_othercircle,
alert_content,
alert_base,
alert_hour,
alert_notif,
Designation,
EmployeeCode,
Department,
CostTo,
Location,
lmt from usermanager nolock where username='".$username."' limit 1") or die(mysql_error());	
	$III = mysql_fetch_array($UUU);
	$notin = $III["notin"];
	$notin = explode(",",$notin);
	
	foreach($notin as $v) {
	$NotIn .= "'".$v."',";	
	}
	$NotIn = trim($NotIn,",");
	//echo $NotIn;exit;
	
	if($SKIP != 1) {
	if(!in_array($CURPAGE_TAG,$AR_PList)) {
	header("Location: /MIS/sHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/3/login.php?ERROR=98");exit;		
	}
	}
	sort($AR_SList, SORT_STRING);
	sort($AR_CList, SORT_STRING);
	$SERVICE_DROPDOWN = '';
	$CIRCLE_DROPDOWN = '';
	
	foreach($AR_SList as $Service) {
		if(strcmp("all",$Service) == 0) {
		//$SERVICE_DROPDOWN .= '<option value="">All Services</option>';		
		} else{
		
		if($_POST['Service'] && is_array($_POST['Service'])) {
		$IK = (in_array($Service,$_POST['Service']) ? 'selected':'' );	
		}
		
		$SERVICE_DROPDOWN .= '<option value="'.$Service.'" class=".xoption" '.$IK.'>'.$Service_DESC[$Service]["Name"].'</option>
		';
		}
	}
	
	if(in_array("all",$AR_SList)) {
	//	$SERVICE_DROPDOWN = '<option value=""  class=".xoption" >All Services</option>'.$SERVICE_DROPDOWN;
	}
	
	foreach($AR_CList as $Circle) {
		if(strcmp("all",$Circle) == 0) {		
		} else{
			if($_POST['Circle']) {
			$IK = (in_array($Circle,$_POST['Circle']) ? 'selected':'' );	
			}
		//$CIRCLE_DROPDOWN .= '<option value="'.$Circle.'" class=".xoption" '.$IK.'></option>';
		$CIRCLE_DROPDOWN .= '<INPUT NAME="Circle[]" TYPE="CHECKBOX" VALUE="'.$Circle.'" class=".xoption" '.$IK.'>'.$Circle;
		}
	}
	
	if(in_array("all",$AR_CList)) {
		//$CIRCLE_DROPDOWN = '<option value=""  class=".xoption" >All Circles</option>'.$CIRCLE_DROPDOWN;
	}
	
	
	
}


$PIE_COLORS_A = array('FF33CC','33CCFF','FFCC33','2E8A5C','CC0033','004D99');
$ISO['andhra pradesh'] = 'Andhra Pradesh';
$ISO['assam'] = 'Assam';
$ISO['bihar'] = array('Bihar','Jharkhand');
$ISO['gujarat'] = 'Gujarat';
$ISO['gujarat	'] = 'Gujarat';
$ISO['haryana'] = 'Haryana';
$ISO['himachal pradesh'] = 'Himachal Pradesh';
$ISO['jammu-kashmir'] = 'Jammu and Kashmir';
$ISO['karnataka'] = 'Karnataka';
$ISO['kerala'] = 'Kerala';
$ISO['madhya pradesh'] = array('Madhya Pradesh','Chhattisgarh');
$ISO['maharashtra'] = array('Maharashtra','Goa');
$ISO['orissa'] = 'Orissa';
$ISO['punjab'] = 'Punjab';
$ISO['rajasthan'] = 'Rajasthan';
$ISO['tamil nadu'] = 'Tamil Nadu';
$ISO['up east'] = 'Uttar Pradesh';
$ISO['up west'] = 'Uttaranchal';
$ISO['westbengal'] = array('West Bengal','Sikkim');
$ISO['delhi'] = 'Delhi';
$ISO['chennai'] = 'Chennai';
$ISO['mumbai'] = 'Mumbai';
$ISO['kolkata'] = 'Kolkata';
$ISO['kolkatta'] = 'Kolkata';
$ISO['ne'] = array('Nagaland','Arunachal Pradesh','Manipur','Meghalaya','Mizoram');



function sec2hms ($sec, $padHours = false) {

    $hms = "";
    
    // there are 3600 seconds in an hour, so if we
    // divide total seconds by 3600 and throw away
    // the remainder, we've got the number of hours
    $hours = intval(intval($sec) / 3600); 

    // add to $hms, with a leading 0 if asked for
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
          : $hours. ':';
     
    // dividing the total seconds by 60 will give us
    // the number of minutes, but we're interested in 
    // minutes past the hour: to get that, we need to 
    // divide by 60 again and keep the remainder
    $minutes = intval(($sec / 60) % 60); 

    // then add to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';

    // seconds are simple - just divide the total
    // seconds by 60 and keep the remainder
    $seconds = intval($sec % 60); 

    // add to $hms, again with a leading 0 if needed
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

    return $hms;
}
function makePin($lenth =5) { 
    // makes a random alpha numeric string of a given lenth 
    $aZ09 = array_merge(range('A', 'Z'), range('a', 'z'),range(0, 9)); 
    $out =''; 
    for($c=0;$c < $lenth;$c++) { 
       $out .= $aZ09[mt_rand(0,count($aZ09)-1)]; 
    } 
    return $out; 
} 

function CurrentPageURL() 
{
return $_SERVER['REQUEST_URI'];

}

function Format($Num,$Decimal='0') {
return ($Num==0)?"-":number_format($Num,$Decimal);
}
*/
?>