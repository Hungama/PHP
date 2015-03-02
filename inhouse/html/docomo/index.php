<?php
//ini_set('display_errors', '1');
Header("Cache-control: private, no-cache");
Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
Header("Pragma: no-cache");
if($_GET['page123']==1)
{
	header("location:http://apps.facebook.com/mtsmuzicunlimited/");
	exit;
}
include('config.php');
include('dbconfig.php');
require_once '/var/www/html/MTS/src/facebook.php';

$mode = isset($_REQUEST['mode'])?$_REQUEST['mode']:"";
if($mode=="") 
$mode = "main";

$facebook = new Facebook(array(
  'appId'  => $appid,
  'secret' => $appsecret,
  'cookie' => false,
));

$session = $facebook->getSession();

$me = null;
?>
<?php
// Session based API call.
if ($session) {
	try {

		$uid = $facebook->getUser();
		$stream_permission = $facebook->api(array('method'=>'users.hasAppPermission','uid'=>$uid,'ext_perm'=>'publish_stream'));
		if(!$stream_permission)
		{
			## ask to grant permissions
			$par = array(
						'canvas' => 1,
						'fbconnect' => 0,
						'req_perms' => 'publish_stream,offline_access,email,sms,user_activities,user_birthday,user_hometown,user_interests,user_likes,user_location,user_online_presence,user_photos,user_relationship_details',
						'cancel_url' => $APP_URL,
						'next' => $APP_URL 
				   );
		//	$loginUrl = $facebook->getLoginUrl($par);
				
$loginUrl="https://www.facebook.com/dialog/oauth/?client_id=309263392440214&redirect_uri=http://apps.facebook.com/mtsmuzic&scope=email,publish_stream,status_update,user_online_presence,user_birthday,user_status";
		/* <fb:redirect url="<?php echo $loginUrl;?>" />*/
			?>
			<script type="text/javascript">
				top.location.href = "<?php echo $loginUrl;?>";
			</script>
			<?php
			exit;
		}

	} catch (FacebookApiException $e) {
		error_log($e);
	}
}
else
{
	## if not logged in redirect to login page
	$par = array(
					'canvas' => 1,
					'fbconnect' => 0,
					'req_perms' => 'publish_stream,offline_access,email,sms,user_activities,user_birthday,user_hometown,user_interests,user_likes,user_location,user_online_presence,user_photos,user_relationship_details',
					'cancel_url' => $APP_URL,
					'next' => $APP_URL 
			   );
	$loginUrl = $facebook->getLoginUrl($par);
	
$loginUrl="https://www.facebook.com/dialog/oauth/?client_id=309263392440214&redirect_uri=http://apps.facebook.com/mtsmuzic&scope=email,publish_stream,status_update,user_online_presence,user_birthday,user_status";
//echo $loginUrl;
	?>
	<script type="text/javascript">
				top.location.href = "<?php echo $loginUrl;?>";
	</script>
	<?php
		exit;
} 

/*$user = null; //facebook user uid
$user = $facebook->getUser();
$loginUrl   = $facebook->getLoginUrl(
	array(
		'scope'  => 'publish_stream, email, user_location',
		'redirect_uri'  => FACEBOOK_CANVAS_URL
	)
);

if ($user) {
	try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		//you should use error_log($e); instead of printing the info on browser
		d($e);  // d is a debug function defined at the end of this file
		$user = null;
	}
}

if (!$user) {
	//echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
	echo '<fb:redirect url="'.$loginUrl.'" />';
	exit;
}*/

$access_token = $session['access_token'];
$me = $facebook->api('/me');
$user_id = $me['id'];
$user_id = $facebook->getUser();

$user_name = $me['name'];
$profile_url = $me['link'];
$email = $me['email'];
$birthday = $me['birthday'];
$user_pic = 'http://graph.facebook.com/'.$user_id.'/picture';
$user_gender = $me['gender'];

if($user_gender=="female")
	$user_gender= 'F';
else if($user_gender=="male")
	$user_gender= 'M';
else $user_gender= 'O';

$sql = "INSERT INTO ".$TBL_FB_USER_MASTER."
		VALUES(
			null,
			'".addslashes($user_id)."',
			'".addslashes($user_name)."',
			'".addslashes($user_gender)."',
			'".addslashes($profile_url)."',
			'".addslashes($birthday)."',
			NOW(),'MTS'),";

mysql_query($sql, $db_link);

if(mysql_errno()=="1062")
{
	$sql = "
		UPDATE
			$TBL_FB_USER_MASTER
		SET
			user_name = '".addslashes($user_name)."',
			user_gender = '".addslashes($user_gender)."',
			profile_url = '".addslashes($profile_url)."',
			birthday = '".addslashes($birthday)."'
		WHERE
			user_id = '".addslashes($user_id)."'
	";
	@mysql_query($sql, $db_link);
}

$sql_sub = "
	INSERT INTO
		$TBL_FB_USER_SUBSCRIPTION
	VALUES(
		'',
		'".addslashes($user_id)."',
		'".addslashes($session_key)."',
		'".addslashes($access_token)."',
		'".addslashes($expires)."',
		'','0',NOW(),'".addslashes($email)."','mu','mobile','MTS')";
mysql_query($sql_sub, $db_link);

if(mysql_errno()=="1062")
{
	$sql = "UPDATE $TBL_FB_USER_SUBSCRIPTION SET session_key = '".addslashes($session_key)."', access_token = '".addslashes($access_token)."',email = '".addslashes($email)."',linking_account='mu',user_account='mobile' WHERE user_id = '".addslashes($user_id)."'";

	@mysql_query($sql, $db_link);
}

## if mode is not invite then check if this is existing user and check his subscription status
if($mode != "invite" && $mode == "main")
{
	$sql_sub = "
		SELECT
			subscription_status,msisdn
		FROM
			$TBL_FB_USER_SUBSCRIPTION
		WHERE
			user_id = '".addslashes($user_id)."'
	";
	$result_sub = mysql_query($sql_sub, $db_link);
	$sub_status = 0;
	if(mysql_num_rows($result_sub) > 0)
	{
		$sub_status = mysql_result($result_sub, 0 ,0);

		$result_sub1 = mysql_query($sql_sub, $db_link);
		list($subsStatus,$subsMsisdn)=mysql_fetch_row($result_sub1);
		$subsMsisdn = substr($subsMsisdn, -10);
	}
	
	## status 0 - not registered /new user
	if($sub_status == "1")
	{
		$mode = "thnk";
	}
	else
	{
		if($sub_status == "2")
		{
			$display_msisdn = "none";
			$display_code = "block";
		}
		else
		{
			$display_msisdn = "block";
			$display_code = "none";
		}
		$mode = "main";
	}
}
?>
<?php
if($mode == "invite")
{
	if (isset($_REQUEST['ids']))
	{
			echo "<center>Thank you for inviting ".sizeof($_POST["ids"])." of your friends on <b><a href=\"".$APP_URL."\">".$APP_NAME."</a></b>.<br><br>\n";
	}
	else
	{
		$content =
				"<fb:name uid=\"".$user_id."\" firstnameonly=\"true\" shownetwork=\"false\"/> has started using <a href=\"".$APP_URL."\">".$APP_NAME."</a> and thought it's so cool even you should try it out!\n".
				"<fb:req-choice url=\"".$APP_URL."\" label=\"Add ".$APP_NAME." to your profile\"/>";

?>
	<!--<div id="FBInvite">
		<fb:fbml>
			<fb:request-form
				action=""
				target="_top"
				method="POST"
				invite="true"
				type="<?php echo $APP_NAME; ?>"
				content="<?php  echo htmlentities($content); ?>"
				>

				<fb:multi-friend-selector
				showborder="false"
				actiontext="Here are your friends who don't have <?php  echo $APP_NAME; ?> yet. Invite whoever you want - it's free!">
			</fb:request-form>
		</fb:fbml>
	</div>-->
<?php
	} // EOF Else
exit;
}##EO if($mode == "invite")
$myFacebookUrl="http://124.153.73.2/MTS/index.php";
?>
<iframe src="http://124.153.73.2/MTS/indexMTS.php?user_id=<?php echo $user_id;?>" id='mainframe' name='mainframe' scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:1060px;" height="820px;" allowTransparency="true">
</iframe>