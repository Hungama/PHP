<?php 
//include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

$refer=trim($_REQUEST['refer']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content=" initial-scale=1.0,user-scalable=no, maximum-scale=1.0">

<script src="getContenttest.js"></script>
<title>Sarnam</title>
<link rel="stylesheet" type="text/css" href="css/style2.css"/>
</head>

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
           <div class="space14"></div>
	
           <div class="titleCont">
           	<h2><span>
			<?php if($refer=='relc')
			{
				echo "Religion Change Request";
			}
			elseif($refer=='sub')
			{
				echo "Subscription Request";
			}
			?>
			</span></h2>
           </div> 

		  
           <div class="space6"></div>
			
	      <div class="arltxt10 pl16">
		<?php 
		if($refer=='relc')
			echo "Religion has been saved";
		elseif($refer=='sub')
			echo "We Have received your subscription request for Airtel Sarnam.. ";
	?>
		</div>
          <div class="wallpaperCont">
		  <div class="cl"></div>
          </div>
          <div class="more" align="right"><a href="#"><span id='ringmore'></span></a></a></div>
        <!--  <div class="titleContMore">
           	 <h2>Assosiated deities...</h2>
           </div> -->
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
<div class="moreDetites"><a href="#"><img src="images1/click-here-sml1.jpg" border="0" /></a></div>
	<!--<div class="pa9">
          	    <div><a href="#"><img src="images1/songlist_img08.jpg" alt="" border="0" /></a></div>
                  <div><a href="#"><img src="images1/songlist_img09.jpg" alt="" border="0" /></a></div>
                  <div><a href="#"><img src="images1/songlist_img10.jpg" alt="" border="0" /></a></div>
                  <div><a href="#"><img src="images1/songlist_img11.jpg" alt="" border="0" /></a></div>
                  <div><a href="#"><img src="images1/songlist_img12.jpg" alt="" border="0" /></a></div>
            </div>-->
            <div class="specialZone pa5"><img src="images1/special-zone1.jpg" alt="" /></div>
            <!--<div class="regionalTxt">
			<a href="#">sikhism</a> 
			<a href="#">islam</a>
			<a href="#">jainism</a>  
			<a href="#">buddhism</a>
			<a href="#">christianity</a>
			</div>-->
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

