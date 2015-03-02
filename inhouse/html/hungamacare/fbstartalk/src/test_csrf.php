<?php 
include("config/config.php");
include("dbquery.php");
include ("commonfn.php");
include("urlencode.php");
session_start();
$link           =       mysql_pconnect("$mysql_hostname","$mysql_user","$mysql_password") or die(mysql_error());
$select         =       mysql_select_db("$mysql_dbName") or die(mysql_error());

extract($_REQUEST);
$appid=$_SESSION['appid'];

$fb_appid=$_SESSION['fb_appid'];
$fb_appsecret=$_SESSION['fb_appsecret'];
$fb_pageid=$_SESSION['fb_pageid'];

$fb_appname=$_SESSION['fb_appname'];

log_action("!!!!!test_csrf!!!!!!---setting session variables ---appid---->$appid");
log_action("!!!!!test_csrf!!!!!!---fb_appid----->$fb_appid ----fb_appsecret--->$fb_appsecret----fb_pageid--->$fb_pageid----fb_appname----->$fb_appname");

$code = $_REQUEST["code"];
$permission		=	"user_about_me,user_photos,email,offline_access,publish_stream,read_stream";
//$permission		=	"user_about_me,user_photos,email,offline_access,publish_stream,read_stream,manage_pages";

if(empty($code)) {
	log_action("!!!!!test_csrf!!!!!!---found code---->$code");
	
	$_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
	log_action("!!!!!test_csrf!!!!!!---SESSION[state]---->".$_SESSION['state']);
	
	$dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
	. $fb_appid . "&redirect_uri=" . urlencode($callback_url) . "&state="
	. $_SESSION['state']."&scope=" . urlencode($permission);

	echo("<script> top.location.href='" . $dialog_url . "'</script>");
}

if($_REQUEST['state'] == $_SESSION['state']) {
	log_action("!!!!!test_csrf!!!!!!---REQUEST['state'] == _SESSION['state']");
	
	$token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $fb_appid . "&redirect_uri=" . urlencode($callback_url). "&client_secret=" . $fb_appsecret . "&code=" . $code;
	log_action("!!!!!test_csrf!!!!!!---calling token_url---->$token_url");
	
	$response = file_get_contents($token_url);
	$params = null;
	parse_str($response, $params);

	$status		=	0;
	if(isset($params['access_token']) && $params['access_token'] != '') {
		$status		=	1;
	}
	log_action("!!!!!test_csrf!!!!!!---access_token---->".$params['access_token']);
	$token=$params['access_token'];
	
	$graph_url 	= "https://graph.facebook.com/me?access_token=" . $params['access_token'];
	log_action("!!!!!test_csrf!!!!!!---calling graph url---->".$graph_url);
	
	$user 		= json_decode(file_get_contents($graph_url));
	$update_users	=	"UPDATE fp_user SET
	access_token 	= '". mysql_escape_string($params['access_token']) ."',
	status			=	$status  ,
	fb_userid 		= 	'". mysql_escape_string($user->id) ."' ,
	code 			= 	'". mysql_escape_string($code) ."' ,
	name			=	'". mysql_escape_string($user->name) ."' ,
	first_name		=	'". mysql_escape_string($user->first_name) ."' ,
	last_name		=	'". mysql_escape_string($user->last_name) ."' ,
	email			=	'". mysql_escape_string($user->email) ."'
	WHERE id = " . $_SESSION['id'];

	log_action("!!!!!test_csrf!!!!!!---update query for fp_user---->".$update_users);
	
	mysql_query($update_users) or die(mysql_error());
	if( $status	) {
		$_SESSION['MSG']	=	"Successfully updated..";
	}
	else {
		$_SESSION['MSG']	=	"Problem in update. Please try again.";
	}
	?>
<!--<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">-->
<html>
<head>
<title><?php echo $fb_appname; ?></title>
</head>
<body>
	<?php
	echo("Hello " . $user->name ." ! Welcome in ".$fb_appname);
      
	$mno	=	'';
	$fb_appid	=	'';

	$sql_get_mno	=	"SELECT * FROM fp_user WHERE id = " . $_SESSION['id'];
	$res_get_mno	=	mysql_query($sql_get_mno) or die(mysql_error());
	if( mysql_num_rows($res_get_mno) >=1  ) {
			
		$row_get_mno	=	mysql_fetch_array( $res_get_mno );
		$mno			=	$row_get_mno['mno'];
		$fb_appid		=   $row_get_mno['app_id'];
	}


	//$sql_get_appId	=	"SELECT appId FROM fb_appconfig WHERE fb_pageid=".$fb_pageid;

	//$res_get_appId	=	mysql_query($sql_get_appId) or die(mysql_error());
	if( $appid!=''  ) {			
		$sql_upadte_fp_request	=	"UPDATE fp_request SET
		verified = -1
		WHERE appId = ".$appid ."
		AND mobile_no ='". $mno ."'";
		
		log_action("!!!!!test_csrf!!!!!!---update query for fp_request---->".$sql_upadte_fp_request);
		
		mysql_query( $sql_upadte_fp_request ) or die(mysql_error());
		updateToken($mno, $token,$appid);
	}	
	
	header("Location: forwardtofb.php");       
	//print_r($params);

}
else {
	echo "<br>State ". $_REQUEST['state'] . " Session " . $_SESSION['state'] ."<br>";
	
	log_action("!!!!!test_csrf!!!!!!---<br>State ". $_REQUEST['state'] . " Session " . $_SESSION['state'] ."<br>");
	log_action("!!!!!test_csrf!!!!!!---The state does not match. You may be a victim of CSRF.");
	
	echo("The state does not match. You may be a victim of CSRF.");
	//session_destroy();
	//$_SESSION['MSG']	=	"Problem in update. Please try again.";
//	header("Location: forwardtofb.php");
}

?>
	<br>
	<p>
		<iframe src="https://www.facebook.com/me"
			scrolling="no" frameborder="0"
			style="border: none; width: 1250px; height: 800px"> </iframe>
	</p>
</body>
</html>

