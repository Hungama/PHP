<?php
include("config/config.php");
include ("commonfn.php");
$link		=	mysql_pconnect("$mysql_hostname","$mysql_user","$mysql_password") or die(mysql_error());
$select		=	mysql_select_db("$mysql_dbName") or die(mysql_error());
extract($_REQUEST);

if( ! isset( $media_url ) || 
	! isset( $mobile_no ) ||
	! isset( $celebname ) ||
	! isset( $comments ) ||
	! isset( $cnt_type ) ||
	! isset( $appId ) ) {
	
	echo "false\n Please Enter all information \n";
	log_action("!!!!!get_url_req!!!!!!---parameters are not correct kindly check all the parameters---false");
	exit();
}
log_action("!!!!!get_url_req!!!!!!---parameters got---media_url---->$media_url ---mobile_no---->$mobile_no----celebname--->$celebname----comments---->$comments----cnt_type---->$cnt_type---appId---->$appId");

$DATA['POST_TO']	=	0; // 1 Self wall and App page, 2 friends wall and App page
$DATA['FB_APPID']	=	0;
$DATA['FB_APPNAME']	=	0;
$DATA['APPID']		=	0;

$sql_get_app	=	"SELECT * FROM fb_appconfig WHERE appId = '". mysql_escape_string( $appId ) ."' AND active_date <= NOW() LIMIT 1";

log_action("!!!!!get_url_req!!!!!!---select query for fb_appconfig--->$sql_get_app");

$res_get_app	=	mysql_query( $sql_get_app ) or die(mysql_error());

if( mysql_num_rows( $res_get_app ) ) {
	$row				=	mysql_fetch_array( $res_get_app );
	$DATA['POST_TO']	=	$row['post_to'];
	$DATA['FB_APPID']	=	$row['fb_appid'];
	$DATA['FB_APPNAME']	=	$row['fb_appname'];
	$DATA['APPID']		=	$row['appId'];
}


$sql_make_req	=	"INSERT INTO fp_request	(
					mobile_no, appId, req_time , 
					media_url,  
					cnt_type, 
					celebname, 
					comments,
					post_to 
					) VALUES (
					'". $mobile_no ."', 
					'". $DATA['APPID'] ."', 
					NOW(), 
					'". mysql_escape_string($media_url) ."', 
					'".$cnt_type."', 
					'".$celebname."', 
					'".$comments."', 
					". $DATA['POST_TO'] ." )";
log_action("!!!!!get_url_req!!!!!!---insert query for fp_request--->$sql_make_req");

mysql_query( $sql_make_req ) or die(mysql_error());
echo "true";				

?>