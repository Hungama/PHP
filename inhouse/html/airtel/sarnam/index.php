<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport"  content="width=device-width,initial-scale=1.0,user-scalable=no, maximum-scale=1.0">
<script src="modernizr-1.7.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="getCircle.js"></script>
<title>Sarnam</title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<?php 
	$header=getallheaders();
	$msisdn=$header[Msisdn];
	$pointUrl="http://192.168.100.212/airtel/sarnam/SaveAirtelReligion.php";
	$fields="msisdn=".$msisdn."&act=get";
	//echo $res=file_get_contents($pointUrl);
		
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $pointUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
	echo $result = curl_exec($ch);
	if(!isset($_SERVER['HTTP_REFERER']))
{
	switch(trim($result))
	{
	case 'muslim':
		header("location:http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=2-18");
		exit;
	break;
	case 'hindu':
		header("location:http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=1-1");
		exit;
	break;
	case 'sikhism':
		header("location:http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=3-20");
		exit;
	break;
	case 'christianity':
		header("location:http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=4-19");
		exit;
	break;
	case 'jainism':
		header("location:http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=6-22");
		exit;
	break;
	case 'buddhism':
		header("location:http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=5-21");
		exit;
	break;


	}
}
?>
<body>
<div id="wrapper">
	<div class="topImg"><img src="images/top1.jpg" alt="" /></div>
    	<div class="mainCont">
       	 	 <div class="homeIcon"><a href="#"></a></div>
             	<div class="topSearchBox">
                	<div class="srchBox fl">
                    	<form action='search.php'>
						<input type="text" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue" value="type keyword to search" class="input" name="searchtxt">
                        <input type="submit" class="btn">
						</form>
                    </div>
                    <div class="cl"></div>                   
	  	  </div>
          <div class="downlTxt" id="downlTxt"></div>
              <div class="fl pa5">
				<a id='a1'><img id='img1' alt="" border="0" /></a>
				</div>
              <div class="fl pa5">
				<a id='a2'><img id='img2' alt="" border="0" /></a>
				</div>
              <div class="fl pa5">
				<a id='a3'><img id='img3' alt="" border="0" /></a>
				</div>
              <div class="cl"></div>
              <div class="fl pa5">
			  <a id='a4'><img id='img4' alt="" border="0" /></a>
			  </div>
              <div class="fl pa5">
				<a id='a5'><img id='img5' alt="" border="0" /></a>
				</div>
              <div class="fl pa5">
			  <a id='a6'><img id='img6' alt="" border="0" /></a>
			  </div>
              <div class="cl"></div><br />
			<div><a href="http://119.82.69.212/airtel/sarnam/thanks.php?msisdn=$msisdn&refer=sub"><img src="images/click-here.jpg" border="0" /></a></div>
            <div class="space1">&nbsp;</div>
            <div class="footerBg">
            	<div class="footerCont fl">
            		<a href="#">Disclaimer</a> <a href="#">&nbsp;|</a> <a href="#">&nbsp;Privacy Policy</a><br />
					<p>	All Right Reserved.<br />
					Copyrights2011-2012 Hungama.org</p>
                </div>
                <div class="fr" style="padding:34px 5px 0 0"><a href="#"><img src="images/hungama-logo.png" alt="" border="0" /></a></div>
                <div class="cl"></div>
          </div>
</div>
</body>
</html>
