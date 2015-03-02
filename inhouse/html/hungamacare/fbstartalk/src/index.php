<?php
include("dbquery.php");

session_start();
extract($_REQUEST);

if(isset($msisdn) && trim($msisdn) != '' && trim($msisdn) != 'null' && is_numeric($msisdn)) {
	//$msisdn		=	substr($msisdn , 2,10);
}
else {
	$msisdn	=	'';
}

global $appid ;

$appid = $_GET['appid'];

//echo("appid=$appid");
$msisdn = $_GET['msisdn'];
$moblen=sizeof($msisdn);
//echo("mobileno=".sizeof($msisdn));
//die;
$arrAppConfigInfo	=	getAppConfigInfo($appid);
$title=$arrAppConfigInfo['ROW']['fb_appname'];
$fb_appid=$arrAppConfigInfo['ROW']['fb_appid'];
$fb_appsecret=$arrAppConfigInfo['ROW']['fb_appsecret'];
$fb_pageid=$arrAppConfigInfo['ROW']['fb_pageid'];


$_SESSION['appid'] = $appid;
$_SESSION['mno'] = $msisdn;
$_SESSION['fb_appname'] = $title;
$_SESSION['fb_appid'] = $fb_appid;
$_SESSION['fb_appsecret'] = $fb_appsecret;
$_SESSION['fb_pageid'] = $fb_pageid;
//print_r($_SESSION);
if($moblen!='0' && $msisdn!='' && $msisdn!='null'){
header("Location: getAuth.php");
exit();
}

//$title="Talk2Me";
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title ?>
</title>
<script language="javascript">
function Validate()
{
	var x = document.form1.phone_no.value;
    if(isNaN(x)|| x.indexOf(" ")!=-1){
          alert("Kinldy Enter Numeric Value!");return false; }
    if (x.length < 10 || x.length > 10 ){
            alert("Kinldy Enter 10 Digits of Your Mobile No!"); return false;
       }
	if (x.charAt(0) =='9' || x.charAt(0)=='8' || x.charAt(0)=='7')
		{}
    else{
		alert("Kinldy Enter Mob No Starting From 9 or 8 or 7!"); return false;
	}
   
}
</script>
<link href="customTemplate.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<form id="form1" name="form1" method="post" action="getAuth.php">
		<table border="0" cellspacing="1" cellpadding="1" width="90%">
			<tr>
				<td><img src="images/Hlogo.png" width="101" height="40" />
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="dlgTitle"><? $title ?>
				</td>
			</tr>
			<? if( isset($_SESSION['MSG']) && $_SESSION['MSG'] != ''  ) { ?>
			<tr>
				<td align="center" class="tr1"><?=$_SESSION['MSG']?>
				</td>
			</tr>
			<?
			$_SESSION['MSG']	=	null;
			session_destroy();
}
?>
			<? if($msisdn != '') { ?>
			<tr>
				<!-- <td class="tr2">Your mobile is:&nbsp;<b><?=$msisdn?> </b>
				</td>-->
			</tr>
			<tr>
				<td><input type="hidden" name="mno" value="<?=$msisdn?>" />&nbsp;</td>

			</tr>
			<? }else { ?>
			<tr>
				<!-- <td class="tr2">Enter Mobile No&nbsp;<input type="text"
					name="mno" maxlength="10" id="mno">	-->
				<td class="tr2">Enter Mobile No&nbsp;<input name="phone_no"
					type="text" id="phone_no" maxlength="10" />
			
			</tr>
			<? } ?>
			<tr>
				<td align="left"><input type="submit"
					value="Go to Facebook <?php echo $title ?> app" onclick="return Validate()" />
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
