<?php
include("config/config.php");
include("dbquery.php");
include("commonfn.php");

set_time_limit(0);
$link		=	mysql_pconnect("$mysql_hostname","$mysql_user","$mysql_password") or die(mysql_error());
$select		=	mysql_select_db("$mysql_dbName") or die(mysql_error());

$n = 0 ;

while(1) {

	$n++;
	if($n > 100) {
		log_action("### fb_StartTalk_process### !---counter>100 exiting the process......");
		mysql_query( "UPDATE fp_request SET pagesent = 0 WHERE pagesent = -1" ) ;
		mysql_query( "UPDATE fp_request SET usersent = 0 WHERE usersent = -1" ) ;
		log_action("### fb_StartTalk_process### !---update pagesent sent=0 where sent=-1");

		//exit();
	}
	$accessToken="False";
	//$sql_get_pending_req	=	"SELECT * FROM fp_request WHERE verified = 1 AND sent = 0 LIMIT 1";
	$sql_get_pending_req	=	"SELECT * FROM fp_request WHERE pagesent = 0 OR usersent=0 OR usersent=7 order by rand() limit 1";
	log_action("### fb_StartTalk_process### Getting pending request=$sql_get_pending_req");

	$res_get_pending_req	=	mysql_query( $sql_get_pending_req ) or die( mysql_error() );
	if( mysql_num_rows( $res_get_pending_req ) >= 1 ) {

		$row_pending_req	=	mysql_fetch_array( $res_get_pending_req ) ;
		log_action("### fb_StartTalk_process### !---record found as....");

		$media_url=$row_pending_req['media_url'];
		$appid=$row_pending_req['appId'];
		$celebName=$row_pending_req['celebname'];
		$user_msisdn=$row_pending_req['mobile_no'];
		$usersent=$row_pending_req['usersent'];
		$pagesent=$row_pending_req['pagesent'];

		log_action("### fb_StartTalk_process### fp_requset value### media_url=$media_url,appid=$appid,celebName=$celebName,user_msisdn=$user_msisdn,usersent=$usersent,pagesent=$pagesent");

		$short_url	=	getShortUrl($row_pending_req['media_url']);
		log_action("### fb_StartTalk_process### short_url got from media url is=$short_url");
		if ($pagesent!=9 && $pagesent!=1){
			$sql_update_fp_request	=	"UPDATE fp_request SET pagesent = -1, short_url = '". mysql_real_escape_string($short_url) ."' WHERE id = ". $row_pending_req['id'] ."";
			log_action("### fb_StartTalk_process### !---updating fp_request as request in process=$sql_update_fp_request");
 mysql_query( $sql_update_fp_request  ) or die(mysql_error()) ;

		}
//		mysql_query( $sql_update_fp_request  ) or die(mysql_error()) ;

		if ($user_msisdn!=''){

			$arrAppInfo	=	getAppConfigInfo($appid) ;
			$page_id = $arrAppInfo['ROW']['fb_pageid'];
			$fb_appname = $arrAppInfo['ROW']['fb_appname'];
			$operator = $arrAppInfo['ROW']['operator'];
			$fb_postStr= $arrAppInfo['ROW']['post_str'];

			$fb_postStr=str_replace("<celeb>",$celebName,$fb_postStr);
			$fb_postStr=str_replace("<operator>",$operator,$fb_postStr);
			$fb_postStr=str_replace("<appname>",$fb_appname,$fb_postStr);

			echo("##operator=$operator,celbname=$celebName,appame=$fb_appname");
			$fb_postStr=str_replace("<celeb>",$celebName,$fb_postStr);
			$fb_postStr=str_replace("<operator>",$operator,$fb_postStr);
			$fb_postStr=str_replace("<appname>",$fb_appname,$fb_postStr);
			echo("##fb_postStr=$fb_postStr");

			log_action("### fb_StartTalk_process### !---record found from appconfig###page_id-=$page_id,fb_appname=$fb_appname,fb_postStr=$fb_postStr");

			$retAccessToken	=	getAccessToken($user_msisdn,$appid);
			if($retAccessToken['FOUND'] ==  1){
				if ($retAccessToken['ROW']['access_token']!=''){
					if ($usersent!=9 && $usersent!=1){
						$accessToken="True";
						log_action("### fb_StartTalk_process### Access Token is blank in fp_user table ...");
						$sql_update_fp_request	=	"UPDATE fp_request SET usersent=-1 WHERE id = ". $row_pending_req['id'] ."";

						log_action("### fb_StartTalk_process### !---updating fp_request as request in process=$sql_update_fp_request");
						mysql_query( $sql_update_fp_request  ) or die(mysql_error()) ;
					}
				}else {
					if ($pagesent!='7' && $pagesent!=9 && $pagesent!=1){
						log_action("### fb_StartTalk_process### !---Access Token Not Found for user in fp_user table going for default...");
						$retAccessToken	=	getDefaultAccessToken($fb_appname,$appid);

						$sql_update_fp_request	=	"UPDATE fp_request SET usersent=7 WHERE id = ". $row_pending_req['id'] ."";
						mysql_query( $sql_update_fp_request  ) or die(mysql_error());
					}
				}
			}else{
				if ($pagesent!='7'&& $pagesent!=9 && $pagesent!=1){
					log_action("### fb_StartTalk_process### No Record Found in fp_user table going for default ...");
					echo("Access Token Not Found for_user going for default--\n");
					$retAccessToken =       getDefaultAccessToken($fb_appname,$appid);

					$sql_update_fp_request	=	"UPDATE fp_request SET usersent=7 WHERE id = ". $row_pending_req['id'] ."";
					mysql_query( $sql_update_fp_request  ) or die(mysql_error());
				}
			}
		}

		$self_access_token	=	'';

		if($retAccessToken['FOUND'] ==  1){
			$user_id = $retAccessToken['ROW']['fb_userid'];
			$access_token = $retAccessToken['ROW']['access_token'];
			log_action("### fb_StartTalk_process### !---Got Access Token=$access_token,user_id=$user_id");
			log_action("### fb_StartTalk_process### !---Token Found=".$row_pending_req['cnt_type']);

			if(trim(strtoupper($row_pending_req['cnt_type'])) == "VOICE" ) {

				echo("Found audio file to post");
				log_action("### fb_StartTalk_process### !---Found audio file to post for user=$user_id");

				$audio_cmd	=	"curl -F 'access_token=" .  $access_token ."' ";
				$audio_cmd	.=	"-F 'message=" . $fb_postStr ."' ";
				$audio_cmd	.=	"-F 'link=" . $media_url ."' " ;
				$audio_cmd	.=	"-F 'picture=" . $arrAppInfo['ROW']['post_img'] ."' " ;

				//=================== POST TO WALL =====================================================================================
				$cmd_user_wall	=$audio_cmd."https://graph.facebook.com/".$user_id."/feed";

				log_action("### fb_StartTalk_process### !---url to post audio on user wall=$cmd_user_wall");

				echo($cmd_user_wall);
				$ret_var	=	trim(exec($cmd_user_wall));
				$res		=	json_decode($ret_var);
				//log_action("### fb_StartTalk_process### !---response from url to post audio on page wall=$res");

				var_dump($res);

				//================= POST TO SELF WALL =====================================================================================

				$cmd_page_wall=$audio_cmd."https://graph.facebook.com/".$page_id."/feed";
				log_action("### fb_StartTalk_process### !---url to post audio on page wall=$cmd_page_wall");

				$ret_var	=	trim(exec($cmd_page_wall));
				$res		=	json_decode($ret_var);
				//	log_action("### fb_StartTalk_process### !---response from url to post audio on page wall=$res");

				var_dump($res);

				if($row_pending_req['post_to'] == 2) {
					$getAllFriensIds	=	"https://graph.facebook.com/me/friends?access_token=" . urlencode($retAccessToken['ROW']['access_token']);
					$restr				=	file_get_contents( $getAllFriensIds );
					$resFrnd			=	json_decode($restr);

					$arrFrnd	=	get_object_vars($resFrnd);
					//print_r($arrFrnd);
					echo "\n=================================================================================\n";
					//print "\n". $arrFrnd['data']['id'] .  " " . $arrFrnd['data']['name'];
					foreach( $arrFrnd['data'] as $obFrnd ) {
						echo "\n" . $obFrnd->id . " " . $obFrnd->name ;
						$cmd	=$audio_cmd."https://graph.facebook.com/".$obFrnd->id."/feed";
						log_action("### fb_StartTalk_process### !---url to post audio on friend's wall=$cmd");

						$ret_var	=	trim(exec($cmd));
						$res		=	json_decode($ret_var);

						var_dump($res);
					}
				}
				//================= POST TO SELF WALL =====================================================================================

				$sql_update_fp_request	=	"UPDATE fp_request SET usersent = 1,pagesent =1 WHERE id = ". $row_pending_req['id'] ."";
				mysql_query( $sql_update_fp_request ) or die(mysql_error()) ;
			}
			elseif(trim(strtoupper($row_pending_req['cnt_type'])) == "VIDEO") {

				log_action("### fb_StartTalk_process### in Video Section #####");

				$userBaseDir=$baseDir.$temp_ConvertPath;
				$userTempDir=$userBaseDir.$user_msisdn;
				log_action("### userTempDir=".$userTempDir."\n");

				$cmd="mkdir -p ".$userTempDir;
				$ret_var	=	trim(exec($cmd));

				if($accessToken=="True"){ // If Start Getting User Image from Facebook Profile and copying to temp location
					echo("### Calling url for album");
					log_action("### fb_StartTalk_process### !---Found video file to post for user=$user_id");

					$album_url="https://graph.facebook.com/".$user_id."/albums?access_token=$access_token";
					log_action("### fb_StartTalk_process### !---url to get all albums for user from facebook=$album_url");

					$input = file_get_contents($album_url);
					$params = null;

					$fb_response = json_decode($input);
					//log_action("### fb_StartTalk_process### !---response from album url=$fb_response");
					foreach($fb_response->data as $item){
						if("Profile Pictures" == $item->name){
							echo 'Name: ' . $item->name . "\n";
							echo 'cover_photo: ' . $item->cover_photo . "\n";
							$cover_photo=$item->cover_photo;
							log_action("### fb_StartTalk_process### !---got profile pictures from response----Name:->$item->name---cover_photo:->$item->cover_photo");
							break;
						}
					}
					$cover_photo_url="https://graph.facebook.com/".$cover_photo."?access_token=$access_token";
					log_action("### fb_StartTalk_process### !---url to get profile images from facebook=$cover_photo_url");

					$input = file_get_contents($cover_photo_url);
					$params = null;

					$fb_response = json_decode($input);
					//log_action("### fb_StartTalk_process### !---response from cover photo url=$fb_response");

					$user_images = $fb_response->images;
					log_action("### fb_StartTalk_process### !---images of user from facebook profile=$user_images");

					//echo("user_images=".$user_images);
					$cover_photo_source=$user_images[0]->source;
					log_action("### fb_StartTalk_process### !---profile picture of user is=$cover_photo_source");
					$user_photo_array=split("/", $cover_photo_source);

					foreach ($user_photo_array as $value) {
						if (strpos($value,'jpg') !== false) {
							echo "Value: $value<br />\n";
							$user_photo_name=$value;
							log_action("### fb_StartTalk_process###Extracted photo of user is=$user_photo_name");
						}
					}

					$cmd="wget --no-check-certificate $cover_photo_source";
					log_action("### fb_StartTalk_process### !---Downloading profile picture of user from facebook...");
					$ret_var	=	trim(exec($cmd));
					var_dump($ret_var);
					log_action("### fb_StartTalk_process### !---Downloading reponse$ret_var");

					$cmd="test -f ".$baseDir.$user_photo_name." && echo 'File Exists'|| echo 'File Not Exists'";
					$ret_var	=	trim(exec($cmd));
					log_action("### fb_StartTalk_process### !---User image exist =$ret_var");

					if ($ret_var=="File Exists") {
						$source=$baseDir.$user_photo_name;
						$dest=$userTempDir."/A-001.jpg";
						log_action("### fb_StartTalk_process###Copying user profle image from= $source to=$dest...");
							
						$cmd="cp ".$source." ".$dest;
						$ret_var	=	trim(exec($cmd));
							
						echo("### Going to delete user image from current dir=\n");
						log_action("### fb_StartTalk_process### !---After copied deleting profile image from current dir...");
						$cmd="rm -f ".$baseDir.$user_photo_name;
						$ret_var	=	trim(exec($cmd));
							
					} else {
						echo "User Image ".$baseDir.$user_photo_name." does not exist \n";
					}

				}// If Ends Getting User Image from Facebook Profile and copying to temp location

				$source=$baseDir."images/$fb_appname/".strtolower($celebName).".jpg";
				log_action("### fb_StartTalk_process### !---expected celeb image would be=$source");

				if (file_exists($source)) {
					log_action("### fb_StartTalk_process### Celebrity image found=$source");
				} else {
					log_action("### fb_StartTalk_process### !---Celebrity image not found=$source");
					$source=$baseDir."images/$fb_appname/".strtolower($fb_appname).".jpg";
				}
				$dest=$userTempDir."/A-002.jpg";
				log_action("### fb_StartTalk_process### Copying celeb image from= $source to=$dest...");
				copy($source, $dest);
				$user_rec_array=split("/", $media_url);

				$recTempPath="";
				foreach ($user_rec_array as $value) {
					if (strpos($value,'.') !== false) {
						echo "Value: $value<br />\n";
						$user_rec_file=$value;
						log_action("### fb_StartTalk_process### !---file name from url=$user_rec_file");

					}else{
						$recTempPath=$recTempPath.$value."/";
					}

				}
				list($tempVar1,$tempVar2) = split('[/.]',$user_rec_file);

				log_action("### fb_StartTalk_process### tempVar1=$tempVar1,tempVar2=$tempVar2,srecTempPath=$recTempPath");

				$userRecording=$tempVar1;
				$rec3g=$recTempPath.$tempVar1.$fb_supportFormat;
				log_action("### fb_StartTalk_process### 3GP File=$rec3g");

				if (file_exists($rec3g)) {
					log_action("### fb_StartTalk_process### 3GP File Found copying to temp location");
					copy($media_url,$userTempDir."/".$userRecording.$fb_supportFormat);
				}else{
					log_action("### fb_StartTalk_process### !---3GP File Not Found..Going to execute ffmpeg command...");
					copy($media_url,$userTempDir."/".$userRecording.$AppFormat);
					execute_ffmpeg($userTempDir,$userRecording,$media_url,$fb_supportFormat);
				}
				$media_url=$userTempDir."/".$userRecording.$fb_supportFormat;
					
				if($accessToken=="True"){
					//=================== POST TO User WALL =====================================================================================
					$video_cmd = "curl -F  'access_token=$access_token' -F  'batch=[{\"method\":\"POST\", \"relative_url\":\"$user_id/videos\",  \"body\":\"description=".$fb_postStr."\",  \"attached_files\":\"file1\" },]' -F  'file1=@$media_url' https://graph.facebook.com";

					log_action("### fb_StartTalk_process###Video to bo post on User's wall=$video_cmd");

					$ret_var	=	trim(exec($video_cmd));
					$res		=	json_decode($ret_var);
					log_action("### fb_StartTalk_process### Post Response on User's Wall=$ret_var");
					var_dump($res);

					if (strpos($ret_var,'error') !== false) {
						$sql_update_fp_request	=	"UPDATE fp_request SET usersent = 9 WHERE id = ". $row_pending_req['id'] ."";
					}else{
						$sql_update_fp_request	=	"UPDATE fp_request SET usersent = 1 WHERE id = ". $row_pending_req['id'] ."";
					}

					log_action("### fb_StartTalk_process### !---Update query to set user status=$sql_update_fp_request");
					mysql_query( $sql_update_fp_request ) or die(mysql_error()) ;
				}
				//=================== POST TO Page WALL =====================================================================================
				if($pagesent==0){
				 $video_cmd = "curl -F  'access_token=$access_token' -F  'batch=[{\"method\":\"POST\", \"relative_url\":\"$page_id/videos\",  \"body\":\"description=".$fb_postStr."\",  \"attached_files\":\"file1\" },]' -F  'file1=@$media_url' https://graph.facebook.com";
				 log_action("### fb_StartTalk_process###Video to bo post on Page wall=$video_cmd");

				 $ret_var	=	trim(exec($video_cmd));
				 $res		=	json_decode($ret_var);
				 log_action("### fb_StartTalk_process### Post Response on Page Wall=$ret_var");

				 var_dump($res);

				 if (strpos($ret_var,'error') !== false) {
						$sql_update_fp_request	=	"UPDATE fp_request SET pagesent = 9 WHERE id = ". $row_pending_req['id'] ."";
					}else{
						$sql_update_fp_request	=	"UPDATE fp_request SET pagesent = 1 WHERE id = ". $row_pending_req['id'] ."";
					}

					log_action("### fb_StartTalk_process### !---Update query to set page status=$sql_update_fp_request");
					mysql_query( $sql_update_fp_request ) or die(mysql_error()) ;
				}

				log_action("### Deleting temp folder=".$userTempDir."\n");
				$cmd="rm -r content/temp/".$user_msisdn;
				$ret_var	=	trim(exec($cmd));



			}
			elseif(trim(strtoupper($row_pending_req['cnt_type'])) == "IMAGE") {

				//=================== POST TO USER WALL =====================================================================================
				log_action("### fb_StartTalk_process### !---found image to post for user =$user_id");
				$fb_postStr= str_replace("\n", " ", trim($fb_postStr));

				$image_user_cmd = "curl -F  'access_token=$access_token' -F  'batch=[{\"method\":\"POST\", \"relative_url\":\"$user_id/photos\",  \"body\":\"message=". $fb_postStr ."\",  \"attached_files\":\"file1\" },]' -F  'file1=@$media_url' https://graph.facebook.com";

				log_action("### fb_StartTalk_process### !---url to post image on user's wall =$image_user_cmd");

				$ret_var	=	trim(exec($image_user_cmd));
				$res		=	json_decode($ret_var);
				//log_action("### fb_StartTalk_process### !---response from url to post iamge on user's facebook wall=$res");

				var_dump($res);

				//=================== POST TO Page WALL =====================================================================================

				$image_page_cmd = "curl -F  'access_token=$access_token' -F  'batch=[{\"method\":\"POST\", \"relative_url\":\"$page_id/photos\",  \"body\":\"message=". $fb_postStr ."\",  \"attached_files\":\"file1\" },]' -F  'file1=@$media_url' https://graph.facebook.com";

				log_action("### fb_StartTalk_process### !---url to post image on page wall =$image_page_cmd");

				$ret_var	=	trim(exec($image_page_cmd));
				$res		=	json_decode($ret_var);
				//log_action("### fb_StartTalk_process### !---response from url to post image on page wall=$res");

				var_dump($res);



				$sql_update_fp_request	=	"UPDATE fp_request SET usersent = 1,pagesent =1 WHERE id = ". $row_pending_req['id'] ."";
				mysql_query( $sql_update_fp_request ) or die(mysql_error()) ;
			}
			elseif(trim(strtoupper($row_pending_req['cnt_type'])) == "TEXT") {
				log_action("### fb_StartTalk_process### !---Found text to be post for user =$user_id");
				$postStr="";

				if($row_pending_req['name'] != '') {
					$postStr	=	$media_url;
				}
				else {
					$postStr	=	"";
				}
					
				$urlCmd	=	"";
				if( ($row_pending_req['short_url']) != '') {

					$urlCmd	=	"-F 'link=" . $short_url ."' " ;

				}

				$text_cmd	=	"curl -F 'access_token=" . $access_token ."' ";
				$text_cmd	.=	"-F 'message=" . $postStr ."' ";
				$text_cmd	.=	$urlCmd;
				$text_cmd	.=	"-F 'caption=" .  addslashes($row_pending_req['comments']) ."' " ;
				$text_cmd	.=	"-F 'picture=" . $arrAppInfo['ROW']['post_img'] ."' " ;

				$text_user_cmd	=	$text_cmd."https://graph.facebook.com/".$user_id."/feed";
				log_action("### fb_StartTalk_process### !---url to post text on user's wall =$text_user_cmd");
				echo("\n <--Posting Text on user wall= \n".$text_user_cmd);
					
				$ret_var	=	trim(exec($text_user_cmd));
				$res		=	json_decode($ret_var);
				//log_action("### fb_StartTalk_process### !---response from url to post text on user's wall=$res");

				var_dump($res);

				$text_page_cmd	=	$text_cmd."https://graph.facebook.com/".$page_id."/feed";
				log_action("### fb_StartTalk_process### !---url to post text on page wall =$text_page_cmd");
				echo("\n <--Posting Text on Page wall= \n".$text_page_cmd);

				$ret_var	=	trim(exec($text_page_cmd));
				$res		=	json_decode($ret_var);
				//log_action("### fb_StartTalk_process### !---response from url to post text on page wall=$res");

				var_dump($res);
					
				$sql_update_fp_request	=	"UPDATE fp_request SET usersent = 1,pagesent =1 WHERE id = ". $row_pending_req['id'] ."";
				mysql_query( $sql_update_fp_request ) or die(mysql_error()) ;
			}
			else {
				echo "\nFound invalid content type in table".$row_pending_req['cnt_type'] ;
				log_action("### fb_StartTalk_process### !---Found invalid content type in table=".$row_pending_req['cnt_type']);
			}
		}
		else {
			echo "\nAccess token not found for ". $row_pending_req['mobile_no'] ;
			log_action("### fb_StartTalk_process### !---Token Not Found for mobile=".$row_pending_req['mobile_no']."\n");
			echo("retAccessToken=".$retAccessToken['FOUND']."\n");

			//			$sql_update_fp_request	="UPDATE fp_request SET usersent=7 WHERE id = ". $row_pending_req['id'] ."";
			//			mysql_query( $sql_update_fp_request ) or die(mysql_error()) ;
		}
		sleep(10);
	}
	else {
		@mysql_free_result( $res_get_pending_req );
		echo "\nNo pending request for post.";
		log_action("### fb_StartTalk_process### !---No pending request=$n");
		sleep(10);
	}
}

function getShortUrl($longUrl) {
	//$longUrl = 'http://websms.one97.net/sendsms/push_sms_new.php';
	//$apiKey = 'AIzaSyA6odIB0b8wu75IhPX4b77n9rxiYZU417k';
	$apiKey="AIzaSyAG3ps4C7rlknmUbzRw4xYHTNoGDQGcM5w";
	//Get API key from : http://code.google.com/apis/console/

	$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
	$jsonData = json_encode($postData);

	$curlObj = curl_init();

	curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
	curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curlObj, CURLOPT_HEADER, 0);
	curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	curl_setopt($curlObj, CURLOPT_POST, 1);
	curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

	$response = curl_exec($curlObj);
	$json = json_decode($response);
	log_action("### fb_StartTalk_process=getShortUrl### short url=$json->id");
	curl_close($curlObj);
	return $json->id;
}
?>
