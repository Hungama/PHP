<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="width=device-width,initial-scale=1.0,user-scalable=no, maximum-scale=1.0">
<script src="getContenttest.js"></script>
<title>Sarnam</title>
<link rel="stylesheet" type="text/css" href="css/style2.css"/>
</head>
<?php 
	$header=getallheaders(); 
	$cRId1=$_REQUEST['rDId'];
	$msisdn=$header[Msisdn];
	$cRId2=explode("-",$cRId1);
	
?>
<body>
<div id="wrapper">
	<div class="topImg"><img src="images1/top1.jpg" alt="" /></div>
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
          <div class="downlTxt">download hindi songs, ringtones, wallpapers @ rs 2</div>
	  <div class="contBox">
			<a href='http://119.82.69.212/airtel/sarnam/SaveAirtelReligion.php?msisdn=<?php echo $msisdn;?>&refer=relc&langId=<?php echo $cRId2[0];?>&act=up'>
			<img src="images/save-religion.jpg" alt="" /></a>
	  </div>
         <div class="titleCont">
           	   <h2><span id='deitiyName1'></span></h2>
         </div>          
           <div class="arltxt10 pl16">wallpaper</div>
           <div class="wallpaperCont">
              <div class="thumbAlbum">
			<img src="images/imgTop.gif" width="72" height="3" />
			<a id='hr1' href="#"><img id='img1' alt="" border="0" /></a>
               	 <a href="#"><span id='s1'></span></a>
               </div>
		<div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='hr2' href="#"><img id='img2' alt="" border="0" /></a>
               	 <a href="#"><span id='s2'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='hr3' href="#"><img id='img3' alt="" border="0" /></a>
               	 <a href="#"><span id='s3'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='hr4' href="#"><img id='img4' alt="" border="0" /></a>
               	 <a href="#"><span id='s4'></span></a>
               </div>
               <div class="cl"></div>
          </div>
           <div class="more" align="right"><span id='wallmore'></span></div>
           <div class="space6"></div>
           <div class="arltxt10 pl16">Animations</div>
           <div class="wallpaperCont">
		<div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='ahr1' href="#"><img id='aimg1' alt="" border="0" /></a>
               	 <a href="#"><span id='as1'></span></a>
               </div>
		<div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='ahr2' href="#"><img id='aimg2' alt="" border="0" /></a>
               	 <a href="#"><span id='as2'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='ahr3' href="#"><img id='aimg3' alt="" border="0" /></a>
               	 <a href="#"><span id='as3'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='ahr4' href="#"><img id='aimg4' alt="" border="0" /></a>
               	 <a href="#"><span id='as4'></span></a>
               </div>
	<div class="cl"></div>
          </div>
          <div class="more" align="right"><a href="#"><span id='animmore'></span></a></div>
       
<!--	
   <div class="space6"></div>

	<div class="arltxt10 pl16">Themes</div>
           <div class="wallpaperCont">
              <div class="thumbAlbum">
			<img src="images/imgTop.gif" width="72" height="3" />
			<a href="#"><img id='timg1' alt="" border="0" /></a>
               	 <a href="#"><span id='ts1'></span></a>
		</div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='vhr2' href="#"><img id='timg2' alt="" border="0" /></a>
               	 <a href="#"><span id='ts2'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='vhr3' href="#"><img id='timg3' alt="" border="0" /></a>
               	 <a href="#"><span id='ts3'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='vhr4' href="#"><img id='timg4' alt="" border="0" /></a>
               	 <a href="#"><span id='ts4'></span></a>
               </div>
			   <div class="cl"></div>
          </div>
          <div class="more" align="right"><a href="#">more themes...</a></div>
-->
	  <div class="arltxt10 pl16">Videos</div>
           <div class="wallpaperCont">
               <div class="thumbAlbum">
               	<img src="images/imgTop.gif" width="72" height="3" />
			<a id='vhr1' href="#"><img id='vimg1' alt="" border="0" /></a>
               	 <a href="#"><span id='vs1'></span></a>
		</div>
               <div class="thumbAlbum">
                 <img src="images/imgTop.gif" width="72" height="3" />
			<a id='vhr2' href="#"><img id='vimg2' alt="" border="0" /></a>
               	 <a href="#"><span id='vs2'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
			<a id='vhr3' href="#"><img id='vimg3' alt="" border="0" /></a>
               	 <a href="#"><span id='vs3'></span></a>
               </div>
               <div class="thumbAlbum">
                 <img src="images/imgTop.gif" width="72" height="3" />
			<a id='vhr4' href="#"><img id='vimg4' alt="" border="0" /></a>
              	<a href="#"><span id='vs4'></span></a>
               </div>
			   <div class="cl"></div>
          </div>
          <div class="more" align="right"><a href="#"><span id='videomore'></span></a></div>

          <div class="space6"></div>
          <div class="arltxt10 pl16">Full Track</div>
          <div class="wallpaperCont">
               <div class="thumbAlbum">
			<img src="images/imgTop.gif" width="72" height="3" />
			<a id='fhr1' href="#"><img id='fimg1' alt="" border="0" /></a>
              	<a href="#"><span id='fs1'></span></a>
		</div>
		<div class="thumbAlbum">
               	 <img src="images/imgTop.gif" width="72" height="3" />
			<a id='fhr2' href="#"><img id='fimg2' alt="" border="0" /></a>
              	<a href="#"><span id='fs2'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
		    <a id='fhr3' href="#"><img id='fimg3' alt="" border="0" /></a>
                  <a href="#"><span id='fs3'></span></a>
               </div>
		<div class="thumbAlbum">
                 <img src="images/imgTop.gif" width="72" height="3" />
		   <a id='fhr4' href="#"><img id='fimg4' alt="" border="0" /></a>
                 <a href="#"><span id='fs4'></span></a>
               </div>
               <div class="cl"></div>
          </div>
          <div class="more" align="right"><a href="#"><span id='flamore'></span></a></div>
          <div class="space6"></div>
          <div class="arltxt10 pl16">ringtones</div>
          <div class="wallpaperCont">
               <div class="thumbAlbum">
               	 <img src="images/imgTop.gif" width="72" height="3" />
		   	<a id='rhr1' href="#"><img id='rimg1' alt="" border="0" /></a>
                 	<a href="#"><span id='rs1'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
		   <a id='rhr2' href="#"><img id='rimg2' alt="" border="0" /></a>
                 <a href="#"><span id='rs2'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
		   <a id='rhr3' href="#"><img id='rimg3' alt="" border="0" /></a>
                 <a href="#"><span id='rs3'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
		   <a id='rhr4' href="#"><img id='rimg4' alt="" border="0" /></a>
                 <a href="#"><span id='rs4'></span></a>
               </div>
               <div class="cl"></div>
          </div>
          <div class="more" align="right"><a href="#"><span id='ringmore'></span></a></a></div>
          <div class="titleContMore" id="titleContMore"></div> 
	<div class="wallpaperCont">
               <div class="thumbAlbum">
               	 <img src="images/imgTop.gif" width="72" height="3" />
		   	<a id='ah1'><img id='asscoimg1' alt="" border="0" /></a>
                 	<a href="#"><span id='assos1'></span></a>
               </div>
               <div class="thumbAlbum">
                   <img src="images/imgTop.gif" width="72" height="3" />
		     <a id='ah2'><img id='asscoimg2' alt="" border="0" /></a>
                   <a href="#"><span id='assos2'></span></a>
               </div>
               <div class="thumbAlbum">
                  <img src="images/imgTop.gif" width="72" height="3" />
		     <a id='ah3'><img id='asscoimg3' alt="" border="0" /></a>
                   <a href="#"><span id='assos3'></span></a>
               </div>
               <div class="thumbAlbum">
                 <img src="images/imgTop.gif" width="72" height="3" />
		     <a id='ah4'><img id='asscoimg4' alt="" border="0" /></a>
                   <a href="#"><span id='assos4'></span></a>
               </div>
               <div class="cl"></div>
          </div>
	<div class="moreDetites">
		<a href="http://119.82.69.212/airtel/sarnam/thanks.php?msisdn=$msisdn&refer=sub"><img src="images1/click-here-sml1.jpg" border="0" /></a>
	</div>
	<div class="pa9">
          	    <div id='aartidiv'><a id='aartihr' href="#"><img id='aartiimg' alt="" border="0" /></a></div>
                  <div id='bhajandiv'><a id='bhajanhr' href="#"><img id='bhajanimg' alt="" border="0" /></a></div>
                  <div id='yatradiv'><a id='yaatrahr' href="#"><img id='yaatraimg' alt="" border="0" /></a></div>
                  <div id='chalisadiv'><a id='chalisahr' href="#"><img id='chalisimg' alt="" border="0" /></a></div>
                  <div id='stutidiv'><a id='stutihr' href="#"><img id='stutiimg' alt="" border="0" /></a></div>
            </div>
            <div class="specialZone pa5"><img src="images1/special-zone1.jpg" alt="" /></div>
            <div class="regionalTxt" id='regionalTxt'>
		
		   <a id='sikhhr' href="#"><span id='sikhsp'></span></a>
                 <a id='islamhr' href="#"><span id='islamsp'></span></a>
		   <a id='jainhr' href="#"><span id='jainsp'></span></a>
			<a id='buddhhr' href="#"><span id='buddhsp'></span></a>
		<a id='chrishr' href="#"><span id='chrissp'></span></a>
		   <!--<a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=2-18">islam</a>  
		   <a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=6-22">jainism</a>
	          <a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=5-21">buddhism</a> 
		   <a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=1-4">christian</a>-->
</div>
            <div class="space9">&nbsp;</div>
            <div class="footerBg">
            	<div class="footerCont fl">
            		<a href="#">Disclaimer</a> <a href="#">&nbsp;|</a> <a href="#">&nbsp;Privacy Policy</a><br />
					<p>	All Right Reserved.<br />
					Copyrights2011-2012 Hungama.org</p>
                </div>
                <div class="fr" style="padding:34px 5px 0 0"><a href="#"><img src="images1/hungama-logo.png" alt="" border="0" /></a></div>
                <div class="cl"></div>
          </div>
        </div>
</div>
</body>
</html>
