<?php
include("config/config.php");
include("commonfn.php");
include("dbquery.php");
include("urlencode.php");

set_time_limit(0);
$link		=	mysql_pconnect("$mysql_hostname","$mysql_user","$mysql_password") or die(mysql_error());
$select		=	mysql_select_db("$mysql_dbName") or die(mysql_error());

global $celebName,$appid,$eventEndDate,$eventEndTime,$operator,$shortcode,$page_id,$fb_appname,$defaultImage;

$eventArr= getEventPromoInfo();

$eventRecord=split("#", $eventArr[0]);
$max = sizeof($eventRecord);

log_action("## Total Records = $max");

if ($eventArr[0]==-1 || $eventArr[0]==-2 || $eventArr[0]==-4 || $eventArr[0]==-98 || $eventArr[0]==-99 || $eventArr[0]=""){
	log_action("##ERROR!  URL Response = $eventArr[0]");
	exit();
}

if($max>=1){
	log_action("## Iterating URL Response.....");
	foreach ($eventRecord as $eventRow) {
		log_action("## Event Detail in Response = $eventRow");
		$eventcolumn=split(",", $eventRow);
		$celebName=$eventcolumn[0];
		$eventEndDate=$eventcolumn[1];
		$eventEndTime=$eventcolumn[2];
		$shortcode=$eventcolumn[3];
		$operator=$eventcolumn[4];

		log_action("## Inputs:: CelebName=$celebName, eventEndDate=$eventEndDate, eventEndTime=$eventEndTime, operator=$operator, shortcode=$shortcode");
		if($celebName=="" || $eventEndDate=="" || $eventEndTime=="" || $eventEndDate=="0000-00-00" || $eventEndTime=="00:00:00" || $shortcode=="" || $shortcode=='0' || $operator==""){
			log_action("##ERROR! URL Inputs Blanks");
		}else{
			$arrAppInfo	=	getTextConfigInfo($operator) ;

			log_action("## No. of records in fb_testconfig table = ".sizeof(($arrAppInfo)));

			$appid = $arrAppInfo['ROW']['appId'];
			$page_id = $arrAppInfo['ROW']['fb_pageid'];
			$fb_appname = $arrAppInfo['ROW']['fb_appname'];
			$defaultImage = $arrAppInfo['ROW']['post_img'];

			log_action("## FB DB Details: appid=$appid, pageid=$page_id, fb_appname=$fb_appname, defaultImage=$defaultImage");
			date_default_timezone_set('Asia/Calcutta');
			$today = date("Y-m-d");
			log_action("## Date Diff: ".(strtotime($eventEndDate)-strtotime($today))/( 60 * 60 * 24)."\n");

			$daysLeft=floor((strtotime($eventEndDate)-strtotime($today))/( 60 * 60 * 24));

			log_action("## Days Left = $daysLeft");
			if ($daysLeft<0){
				log_action("## Event Promo Time is lapsed!");
				sleep(5);
			}else{
				startTextPushing($appid,$fb_appname,$celebName,$fb_appname,$eventEndDate,$eventEndTime,$operator,$shortcode,$defaultImage,$page_id);
			}
		}
	}
}

function startTextPushing($appid,$fb_appname,$celebName,$fb_appname,$eventEndDate,$eventEndTime,$operator,$shortcode,$defaultImage,$page_id){

	$query	=	"SELECT appId,operator,timeslot1,timeslot2,text1,text2,text3,day_b4event FROM fb_textconfig WHERE operator='$operator'";
	log_action("## DB Query = $query");

	$result = mysql_query($query) or die(mysql_error());

	if( mysql_num_rows( $result ) >= 1 ) {

		while($row = mysql_fetch_array($result)){

			log_action("## DB Record: appId=".$row['appId'].", operator=".$row['operator']. ", timeslot1=". $row['timeslot1'].", timeslot2=". $row['timeslot2'].", text1=".$row['text1'].", text2=".$row['text1'].", text3=".$row['text3'].", day_b4event=".$row['day_b4event']);
			$appid=$row['appId'];
			$timeslot1= $row['timeslot1'];
			$timeslot2= $row['timeslot2'];
			$operator=$row['operator'];
			$text1=$row['text1'];
			$text2=$row['text2'];
			$text3=$row['text3'];
			$day_b4event=$row['day_b4event'];
			date_default_timezone_set('Asia/Calcutta');

			$today = date("Y-m-d");
			log_action("## Today date = $today");

			$daysLeft=floor((strtotime($eventEndDate)-strtotime($today))/( 60 * 60 * 24));
			log_action("## Date diff = $daysLeft");

			if ($daysLeft <= $day_b4event){
				if ($daysLeft>=$timeslot1){
					log_action("## Going for Text1.");
					$text1=replaceText($text1,$celebName,$operator,$fb_appname,$shortcode,$eventEndDate,$daysLeft,$eventEndTime);

					log_action("## Text After replace values = ".$text1);
					pushText($appid,$text1,$celebName,$fb_appname,$defaultImage,$page_id);
				}else if($daysLeft>=$timeslot2){
					log_action("## Going for Text2.");
					$text2=replaceText($text2,$celebName,$operator,$fb_appname,$shortcode,$eventEndDate,$daysLeft,$eventEndTime);

					log_action("## Text After replace values = ".$text2);
					pushText($appid,$text2,$celebName,$fb_appname,$defaultImage,$page_id);
				}else if($daysLeft==0){
					log_action("## Event on today!");
					$text3=replaceText($text3,$celebName,$operator,$fb_appname,$shortcode,$eventEndDate,$daysLeft,$eventEndTime);

					log_action("## Text After replace values = ".$text3);
					pushText($appid,$text3,$celebName,$fb_appname,$defaultImage,$page_id);
				}
			}
			else{
				log_action("## No Event Promo Time started yet.");
				sleep(5);
			}
		}
	}else {
		@mysql_free_result($result);
		log_action("## No pending request for Text post.");
		sleep(5);
	}
}

function pushText($appid,$text,$celebName,$fb_appname,$defaultImage,$page_id){
	global $baseDir,$server_url,$defaultProfileName;
	//$qry="SELECT fb_userid,mno,access_token,name FROM fp_user_text WHERE status = 1 AND appid='".$appid."' ORDER BY id DESC";
	$qry="SELECT fb_userid,mno,access_token,name FROM fp_user WHERE status = 1 AND appid='".$appid."' ORDER BY id DESC";
	log_action("## DB Query = $qry");
	$res_allow = mysql_query($qry) or die(mysql_error());
	if( mysql_num_rows( $res_allow ) >= 1 ) {
		while($row = mysql_fetch_array($res_allow)){
			$user_id = $row['fb_userid'];
			$access_token = $row['access_token'];
			$msisdn = $row['mno'];
			$name = $row['name'];
			log_action("## DB Record: user_id=$user_id, access_token=$access_token, msisdn=$msisdn, name=$name");

			$source=$baseDir."images/".$fb_appname."/".strtolower($celebName).".jpg";
			log_action("## Image Source=".$source);
			if (file_exists($source)) {
				$post_img=$baseDir."images/".$fb_appname."/".strtolower($celebName).".jpg";
				$post_img_url=$server_url."images/".$fb_appname."/".strtolower($celebName).".jpg";
				log_action("## Image Found Locaion=".$post_img);
				log_action("## Image Found URL=".$post_img_url);
			} else {
				$post_img = $baseDir."images/".$fb_appname."/".strtolower($fb_appname).".jpg";
				$post_img_url =$server_url."images/".$fb_appname."/".strtolower($fb_appname).".jpg";
				log_action("## Image NOT Found default Locaion=".$post_img);
				log_action("## Image NOT Found default URL=".$post_img_url);
			}
			$postStr="";
			if($name != '') {
				$postStr	=	$text;
			}
			else {
				$postStr	=	"";
			}

			$postStr= str_replace("\n", " ", trim($postStr));

			log_action("######################## Start Facbook Activity #####################################");

			$text_user_cmd = "curl -F  'access_token=$access_token' -F 'caption=".  addslashes($fb_appname) ."\' -F  'batch=[{\"method\":\"POST\", \"relative_url\":\"$user_id/photos\",  \"body\":\"message=". $postStr ."\",  \"attached_files\":\"file1\" },]' -F  'file1=@$post_img' https://graph.facebook.com";
			log_action("## FB URL for USER = $text_user_cmd");

			$ret_var	=	trim(exec($text_user_cmd));
			$res		=	json_decode($ret_var);

			log_action("## FB User Posting Response = ".$ret_var);

			log_action("## UserProfileName = ".$name." , Default PageName=".$defaultProfileName);

			if($name==$defaultProfileName){
				log_action("## Found appname is equal to default profile");

				$text_cmd       =       "curl -F 'access_token=" . $access_token ."' ";
				$text_cmd       .=      "-F 'message=" . $postStr ."' ";
				$text_cmd       .=      "-F 'caption=" . addslashes($fb_appname)  ."' " ;
				$text_cmd       .=      "-F 'picture=" . $post_img_url ."' " ;
				$text_page_cmd  =       $text_cmd."https://graph.facebook.com/".$page_id."/feed";

				log_action("## FB URL for default PAGE = $text_page_cmd");

				$ret_var	=	trim(exec($text_page_cmd));
				$res		=	json_decode($ret_var);
				log_action("## FB Page Posting Response = ".$ret_var);
			}
			log_action("######################## End Facbook Activity #####################################");

		}
	}
	else {
		log_action("## Facebook Registerd User not found.");
	}
	@mysql_free_result($res_allow);
}


function replaceText($text,$celebName,$operator,$fb_appname,$shortcode,$eventEndDate,$daysLeft,$eventEndTime){

	$newdate = date ("l jS F",strtotime($eventEndDate));
	$newtime = date ("g:i A",strtotime($eventEndTime));

	echo("new date=$newdate,newtime=$newtime");
	$text=str_replace("<celeb>",$celebName,$text);
	$text=str_replace("<operator>",$operator,$text);
	$text=str_replace("<appname>",$fb_appname,$text);
	$text=str_replace("<shortcode>",$shortcode,$text);
	$text=str_replace("<date>",$newdate,$text);
	$text=str_replace("<day>",$daysLeft,$text);
	$text=str_replace("<time>",$newtime,$text);

	if ($daysLeft==1){
		$text=str_replace("days","day",$text);
	}
	return $text;
}
?>
