<?php 
include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

$srctxt=trim($_REQUEST['searchtxt']);

// to get the wall paper

$getSerchTextQueryWall="select id,content_id,SUBSTRING(description,1,10) as 'description',sub_category,category,content_type,circle from airtel_devo.tbl_devo_wapcontent where description like '%$srctxt%' and content_type='Wallpapers' limit 0,4";
$getSearchTextWall=mysql_query($getSerchTextQueryWall,$dbConnAirtel);
$wallRecords=mysql_num_rows($getSearchTextWall);

// End to get the wall paper

// to get the Aniation

$getSerchTextQueryAni="select id,content_id,SUBSTRING(description,1,10) as 'description',sub_category,category,content_type,circle from airtel_devo.tbl_devo_wapcontent where description like '%$srctxt%' and content_type='Animation' limit 0,4";
$getSearchTextAni=mysql_query($getSerchTextQueryAni,$dbConnAirtel);
$AniRecords=mysql_num_rows($getSearchTextAni);

// End to get the wall paper

// to get Video

$getSerchTextQueryVideo="select id,content_id,SUBSTRING(description,1,10) as 'description',sub_category,category,content_type,circle from airtel_devo.tbl_devo_wapcontent where description like '%$srctxt%' and content_type='Video' limit 0,4";
$getSearchTextVideo=mysql_query($getSerchTextQueryVideo,$dbConnAirtel);
$VideoRecords=mysql_num_rows($getSearchTextVideo);

// End to get the wall paper

// to get Full Length Audio

$getSerchTextQueryFla="select id,content_id,SUBSTRING(description,1,10) as 'description',sub_category,category,content_type,circle from airtel_devo.tbl_devo_wapcontent where description like '%$srctxt%' and content_type='FLA' limit 0,4";
$getSearchTextFla=mysql_query($getSerchTextQueryFla,$dbConnAirtel);
$FlaRecords=mysql_num_rows($getSearchTextFla);

// End to get the wall paper

// to get Ringtone

$getSerchTextQueryRing="select id,content_id,SUBSTRING(description,1,10) as 'description',sub_category,category,content_type,circle from airtel_devo.tbl_devo_wapcontent where description like '%$srctxt%' and content_type='MP3' limit 0,4";
$getSearchTextRing=mysql_query($getSerchTextQueryRing,$dbConnAirtel);
$RingRecords=mysql_num_rows($getSearchTextRing);

// End to get the wall paper


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
           	   <h2><span><?php echo "you search for <b> &nbsp;'".$srctxt."'</b>";?></span></h2>
           </div> 
		   <?php 
		   if($wallRecords){?>
           <div class="arltxt10 pl16">wallpaper</div>
           <div class="wallpaperCont">
		   <?php 
			while($Wallrow=mysql_fetch_array($getSearchTextWall))
			{
			?>
					<div class="thumbAlbum">
					<img src="images/imgTop.gif" width="72" height="3" />
					<a href="http://202.87.41.147/hungamawap/airtel/voiceT/charging.php?contId=<?php echo $Wallrow['content_id']; ?>&type=wall">
					<img src="http://202.87.41.147/wapsite/content/wappreview/wp/all/thumb/th<?php echo $Wallrow['content_id']; ?>.gif" height='50' width ='65' alt="" border="0" /></a>
					<a href="#"><span><?php echo $Wallrow['description']; ?></span></a>
            </div>
			<?php }

		   ?>
		   <!--<div class="cl"></div>
		  <div class="more" align="right"><span><a href='mresearch.php?searchtxt=<?php echo $srctxt;?>'><font color='black'>More Wall</font></a></span></div>-->
         <div class="cl"></div>
          </div>
			 <?php } ?>
           <div class="space6"></div>
			<?php if($AniRecords){ ?>
           <div class="arltxt10 pl16">Animations</div>
           <div class="wallpaperCont">
		<?php 
			while($Anirow=mysql_fetch_array($getSearchTextAni))
			{
			?>
					<div class="thumbAlbum">
					<img src="images/imgTop.gif" width="72" height="3" />
					<a href="http://202.87.41.147/hungamawap/airtel/voiceT/charging.php?contId=<?php echo $Anirow['content_id']; ?>&type=anim">
					<img src="http://202.87.41.147/wapsite/content/wappreview/animation/all/thumb/th<?php echo $Anirow['content_id']; ?>.gif" height='50' width ='65' alt="" border="0" /></a>
					<a href="#"><span><?php echo $Anirow['description']; ?></span></a>
            </div>
			<?php }?>
		
    <div class="cl"></div>
          </div>
          <div class="more" align="right"><a href="#"><span id='animmore'></span></a></div>
       
   <div class="space6"></div>
	   <?php }?>
	   <?php if($VideoRecords){?>
	  <div class="arltxt10 pl16">Videos</div>
           <div class="wallpaperCont">
		<?php 
			while($Videorow=mysql_fetch_array($getSearchTextVideo))
			{
			?>
					<div class="thumbAlbum">
					<img src="images/imgTop.gif" width="72" height="3" />
					<a href="http://202.87.41.147/waphung/common_download/<?php echo $Videorow['content_id']; ?>?znid=156064">
					<img src="http://202.87.41.147/wapsite/content/wappreview/video/th<?php echo $Videorow['content_id']; ?>.gif" height='50' width ='65' alt="" border="0" /></a>
					<a href="#"><span><?php echo $Videorow['description']; ?></span></a>
            </div>
			<?php }?>
          </div>
	<div class="cl"></div>
          <div class="space6"></div>
			  <?php }?>
			   <?php if($FlaRecords){?>
          <div class="arltxt10 pl16">Full Track</div>
          <div class="wallpaperCont">
          
		  <?php 
			while($Flarow=mysql_fetch_array($getSearchTextFla))
			{
			?>
					<div class="thumbAlbum">
					<img src="images/imgTop.gif" width="72" height="3" />
					<a href="http://202.87.41.147/waphung/common_download/<?php echo $Flarow['content_id']; ?>?znid=156064">
					<img src="http://119.82.69.212/airtel/sarnam/images1/fulltracks_thum1.gif" height='50' width ='65' alt="" border="0" /></a>
					<a href="#"><span><?php echo $Flarow['description']; ?></span></a>
            </div>
			<?php }?>

           <div class="cl"></div>
          </div>
          <div class="more" align="right"><a href="#"><span id='flamore'></span></a></div>
			  <?php }?>
          <div class="space6"></div>
          <div class="arltxt10 pl16"></div>
          <div class="wallpaperCont">
			<div class="cl"></div>
          </div>
          <div class="more" align="right"><a href="#"><span id='ringmore'></span></a></a></div>
          <!--<div class="titleContMore">
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
	<div class="moreDetites"><a href="http://119.82.69.212/airtel/sarnam/thanks.php?msisdn=$msisdn&refer=sub"><img src="images1/click-here-sml1.jpg" border="0" /></a></div>
	
            <div class="specialZone pa5"><img src="images1/special-zone1.jpg" alt="" /></div>
            <div class="regionalTxt">
			<a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=4-20">sikhism</a>
	          <a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=2-18">islam</a>         
		 	<a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=6-22">jainism</a>
	          <a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=5-21">buddhism</a>          
			<a href="http://119.82.69.212/airtel/sarnam/subCat.php?rDId=1-4">christianity</a>
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

