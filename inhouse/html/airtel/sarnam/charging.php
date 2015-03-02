<head>
	<link type="text/css" rel="stylesheet" href="style.css" />
	<meta name="viewport"  content=" initial-scale=1.0,user-scalable=no, maximum-scale=1.0">
</head>
<?php 
	include('/usr/local/apache/htdocs/hungamawap/new_functions.php3');
	
	if($browser_support_id != 172)
		header("location: http://202.87.41.147/hungamawap/uninor/161273/W_index2.php3");

	$zone_id = 161273;
	$zone_name = "Riya HomePage";
	$page_id = 68119;
	$page_name = "index2";
	$cl_fol = "uninor";

	$cid=$_REQUEST['cid'];

	visitor_log($msisdn,$model,$Remote_add,$zone_id,$client_id,$page_id,0,$page_id);
	$rdirecrUrl="http://202.87.41.147/waphung/common_download/".$cid."?znid=156064";
	header($rdirecrUrl);

exit;
	include('/usr/local/apache/htdocs/hungamawap/zone_exceptions.php3');
	include "/usr/local/apache/htdocs/vodafone/template/xhtml_head.php3";

	$logdate=date("Ymd");
	$logPath="/usr/local/apache/htdocs/hungamawap/uninor/164531/subsLog/".$logdate."_log1.log";
	
	//some handsets do not support 100% width for tables thereby leading to side scroll
	//array defined in template/xhtml_head.php3
	if(in_array($Hkey, $arr_hs_ns_100_width))
		$table_attrib = " cellpadding='0' cellspacing='0' border='0' ";
	else
		$table_attrib = " cellpadding='0' cellspacing='0' border='0' width='100%' ";
	
	$chargingUrl="http://119.82.69.210/billing/uninor_billing/UninorWap.php?msisdn=".$msisdn."&mode=RiyaWapP";
	//$chargingResponse=file_get_contents($chargingUrl);

	//$logString=$zone_id."|".date('d-m-Y h:i:s')."|".$msisdn."|".$Remote_add."|".$full_user_agent."|".$chargingUrl."|".$chargingResponse."\r\n";
	//error_log($logString,3,$logPath);

	if($chargingResponse=='charged')
	{
		$rdirecrUrl="http://202.87.41.147/waphung/common_download/".$cid."?znid=156064";
		header("location:".$rdirecrUrl);
		exit;
	}
	$arr_logo_wd=array(91=>110,110=>110,118=>120,120=>120,165=>165,166=>165,198=>210,180=>210,210=>210,230=>230,240=>240,250=>250,280=>280,295=>295,310=>320,320=>320,342=>360,360=>360,352=>480,480=>480,515=>515,630=>640,640=>640,800=>800);
if(!$logo_wd)
 $logo_wd=91; 
$logo_wd=$arr_logo_wd[$logo_wd];
if(!isset($logo_wd) || trim($logo_wd)=="") 
	$logo_wd=110; 

	$i=$_GET['i'];
	$type=$_GET['type'];
	if($type=='video')
	{
		$Vh1file="VideoContent.xml";
		$imagepath="http://202.87.41.147/wapsite/content/wappreview/video/th";
	}
	if($type=='wallpaper')
	{
		$Vh1file="WallpaperContent.xml";
		$imagepath="http://202.87.41.147/wapsite/content/wappreview/wp/all/thumb/th";
	}
	$contents2 = file_get_contents($Vh1file);//Get Content of XML File.
	$result2 = xml2array($contents2);
	$totalCount=count($result2[$type]['content']);
	$i=$_GET['i'];
?>
<body>
<body>
	<div id="wrapper">
    	<div id="header">
   	  		<div class="srch"><input name="" type="text" value="search" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue" /> <img src="images/pnkArw.gif" width="6" height="10" border="0" class="pl10 pt4" /></div>
            <div class="usrNam">Hi <?php echo $msisdn;?> &nbsp;<img src="images/homeIcon.gif" border="0" width="16" height="17" /></div>
        	<div class="cl"></div>
   		</div>
        <div id="cont">
            <div class="fl"><img src="images/topImg.jpg" width="160" height="119" border="0" /></div>
            <div class="fr"><img src="images/logo.jpg" width="160" height="119" border="0" /></div>
            <div class="cl"></div>
            <!--<div class="nav">
            	<a href="#">Images</a> <span>&nbsp;</span> <a href="#">Videos</a> <span>&nbsp;</span> <a href="#">Audio</a><div class="cl"></div>
            </div>-->
            <div class="errorMsg">
            	<div align="center" class="fnt13 lnHgt pt10 pb10">
                   <?php echo "Hey,You don't have enough balance to download it";?>
			 		<br /><br />
					<a href='index2.php3'>Click here to go on main page</a>
                </div>
            </div>
            
            <!--<div class="nav">
            	<a href="#" class="active">Follow Me</a> <span>&nbsp;</span> <a href="#">Things I Love</a> <span>&nbsp;</span> <a href="#">Tell a Friend</a><div class="cl"></div>
            </div>-->
            <div id="footer">
                <!--<div class="disclm"><a href="#">Disclaimer</a> | <a href="#">Privacy Policy</a></div>-->
                <div class="fr"><img src="images/hungamaLogo.jpg" border="0" /></div>
                <div class="cl"></div>
                <!--<div align="center" class="pt10">All Right Reserved. Copyrights 2011-2012 Hungama.org</div>-->
            </div>
		</div>
    </div>
</body>
</html>
