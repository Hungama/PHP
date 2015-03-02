<?php
include("config/config.php");
//include ("commonfn.php");

$link           =       mysql_pconnect("$mysql_hostname","$mysql_user","$mysql_password") or die(mysql_error());
$select         =       mysql_select_db("$mysql_dbName") or die(mysql_error());

function getAppConfigInfo($appid) {
	global $appid;
	$ret			=	array();

	$ret['FOUND']	=	0;
	//$qry	=	"SELECT * FROM fb_appconfig WHERE appId = $fb_appid LIMIT 1";
	$qry	=	"SELECT * FROM fb_appconfig where appid='".$appid."' LIMIT 1";	
	//echo("!!!!!dbquery-->getAppConfigInfo!!!!!!---Select query to get appconfig detail --->$qry");
	
	$res	=	mysql_query( $qry );
	if( mysql_num_rows( $res ) >= 1) {

		$row	=	mysql_fetch_array( $res );

		$ret['FOUND']	=	1;
		$ret['ROW']		=	$row;
	}
	@mysql_free_result($res);
	return $ret;
}

function getTextConfigInfo($operator) {
	global $operator;
	$ret			=	array();
	$ret['FOUND']	=	0;
	$qry	=	"SELECT * FROM fb_appconfig where operator='".$operator."' LIMIT 1";
	$res	=	mysql_query( $qry );
	if( mysql_num_rows( $res ) >= 1) {
		$row	=	mysql_fetch_array( $res );
		$ret['FOUND']	=	1;
		$ret['ROW']		=	$row;
	}
	@mysql_free_result($res);
	return $ret;
}


function getDefaultAccessToken($fb_appname,$appid){
	global $fb_appname,$appid;
	$ret			=	array();
	$ret['FOUND']	=	0;
	if ($fb_appname == "Talk2Me"){
		$qry	=	"SELECT * FROM fp_user WHERE status = 1 AND appid='".$appid."' AND name = 'Ttm Airtel' ORDER BY id DESC LIMIT 1";
//		$qry	=	"SELECT * FROM fp_user WHERE status = 1 AND appid='".$appid."' AND name = 'Ashok Singh' ORDER BY id DESC LIMIT 1";
	}else if ($fb_appname == "StarTalkQA"){
		$qry	=	"SELECT * FROM fp_user WHERE status = 1 AND appid='".$appid."' AND name = 'Ashok Singh' ORDER BY id DESC LIMIT 1";
	}else{
		$qry	=	"SELECT * FROM fp_user WHERE status = 1 AND appid='".$appid."' AND name = 'StarTalk' ORDER BY id DESC LIMIT 1";
	}
	log_action("!!!!!dbquery-->getDefaultAccessToken!!!!!!---Select query to get default access token --->$qry");
	//echo("getAccessToken query-->".$qry."\n");
	$res	=	mysql_query( $qry );
	if( mysql_num_rows( $res ) >= 1) {

		$row	=	mysql_fetch_array( $res );

		$ret['FOUND']	=	1;
		$ret['ROW']		=	$row;
	}
	@mysql_free_result($res);
	return $ret;
}

function getAccessToken( $user_msisdn,$appid ) {
	global $appid,$user_msisdn;
	$ret			=	array();
	$ret['FOUND']	=	0;

	$qry	=	"SELECT * FROM fp_user WHERE status = 1 AND appid='".$appid."' AND mno = '". $user_msisdn ."' ORDER BY id DESC LIMIT 1";
	//echo("getAccessToken query-->".$qry."\n");
	log_action("!!!!!dbquery-->getAccessToken!!!!!!---Select query to get access token --->$qry");
	$res	=	mysql_query( $qry );
	if( mysql_num_rows( $res ) >= 1) {

		$row	=	mysql_fetch_array( $res );

		$ret['FOUND']	=	1;
		$ret['ROW']		=	$row;
	}
	@mysql_free_result($res);
	return $ret;
}

?>
