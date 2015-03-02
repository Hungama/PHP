<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="getCircleDeity.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="width=device-width,initial-scale=1.0,user-scalable=no, maximum-scale=1.0">

<title>Sarnam</title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<?php 
	$header=getallheaders(); 
	$cRId1=$_REQUEST['cRId'];
	$msisdn=$header[Msisdn];
	$cRId2=explode("-",$cRId1);
	
?>
<body>
<div id="wrapper">
	<div class="topImg">
		<img src="images/top1.jpg" alt="" />
	</div>
    	<div class="mainCont">
       	 	 <div class="homeIcon"><a href="http://119.82.69.212/airtel/sarnam"></a></div>
             	<div class="topSearchBox">
                	<div class="srchBox fl">
                    	<form action='search.php'>
			<input type="text" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue" value="type keyword to search" class="input" name="searchtxt">
                      <input type="submit" class="btn">
			</form>
                    </div>
                    <div class="cl"></div>                   
	  	  </div>
          <div class="downlTxt" id="downlTxt">download hindi songs, ringtones, wallpapers @ rs 2</div>
          <div class="contBox">
		<div>
				<a href='http://119.82.69.212/airtel/sarnam/SaveAirtelReligion.php?msisdn=<?php echo $msisdn;?>&refer=relc&langId=<?php echo $cRId2[1];?>&act=up'>
				<img src="images/save-religion.jpg" alt="" /></a>
		</div>
			<br/>
                <div class="fl pa2"><a id='a1'><img id='img1' alt="" border="0" /></a></div>
              	<div class="fl pa2"><a id='a2'><img id='img2' alt="" border="0" /></a></div>
              	<div class="fl pa2"><a id='a3'><img id='img3' alt="" border="0" /></a></div>
              	<div class="cl"></div>
              	<div class="fl pa2"><a id='a4'><img id='img4' alt="" border="0" /></a></div>
              	<div class="fl pa2"><a id='a5'><img id='img5' alt="" border="0" /></a></div>
              	<div class="fl pa2"><a id='a6'><img id='img6' alt="" border="0" /></a></div>
                <div class="moreTxt"><a href="#">more...</a></div>
              	<div class="cl"></div>
          </div>          
			<div><a href="http://119.82.69.212/airtel/sarnam/thanks.php?msisdn=$msisdn&refer=sub"><img src="images/click-here-sml.jpg" alt="" border="0" /></a></div>
            	<div class="pa12">
          		  <div><a id='a7' href="#"><img id='img7' alt="" border="0"/></a></div>
                       <div><a id='a8' href="#"><img id='img8' alt="" border="0"/></a></div>
                       <div><a id='a9' href="#"><img id='img9' alt="" border="0" /></a></div>
                  	  <div><a id='a10' href="#"><img id='img10' alt="" border="0" /></a></div>
                       <div><a id='a11' href="#"><img id='img11' alt="" border="0" /></a></div>
            </div>
            <div class="specialZone pa12"><img src="images/special-zone.jpg" alt="" /></div>
			<div class="regionalTxt">
			<a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=4-20">sikhism</a>
	          <a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=2-18">islam</a>         
		 	<a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=6-22">jainism</a>
	          <a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=5-21">buddhism</a>          
			<a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=1-4">christianity</a>
		</div><br />
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
