<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>Uninor</title>

    </head>
<?php
error_reporting(E_ALL ^E_NOTICE);
 include ("/var/www/html/hungamacare/config/dbConnect.php");
    $navipage = $_REQUEST['navipage'];
    $msisdn = '9582596960';
    $flag = 1; 
//code for insertion
 if($_POST['submit'])
{
$ani=$_POST['msisdn'];
$query = mysql_query("select * from uninor_summer_contest.tbl_otp_wap_detail where msisdn='".$ani."' ");
$noofrow=mysql_num_rows($query);
if($noofrow==0)
{
$digits = 4;
$otp= str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);  
 $insertquery = "insert into uninor_summer_contest.tbl_otp_wap_detail(msisdn,otp,status,added_on) 
values('$ani', '$otp','0', now() )";
$result = mysql_query($insertquery);
$message="your number inserted successfully,please enter your otp.";
}

else{
$message="msisdn already exist in db,please enter your otp.";
} 
}  
?>
    <body>
	<script type="text/javascript">
function validate()  
{  

var msisdn=document.getElementById ('msisdn').value;
if (msisdn=='') {
alert("please enter your mobile number.");
//msisdn.focus();
return false;
}
 if (/^\d{10}$/.test(msisdn)) {
return true;
} else {
    alert("Invalid number; must be ten digits");
	//msisdn.focus();
    return false;
}

}  

		</script>
        <div class="header">
            <div class="logo"><img src="images/logo.jpg" width="121" height="72" alt="" /></div>
            <div class="welcUser mt47" align="right">Hi +91<?php echo $msisdn; ?> &nbsp;&nbsp; <a href="myProfile.php?navipage=Badges"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; 
                <a href="index.php?navipage=Badges"><img src="images/home-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; </div>
            <div class="cl"></div>
        </div>
        <div class="pt10"><div class="constName">Khelo India Jeeto India</div></div>
        <div class="cont">
<!--            <div class="srch"><input name="" type="text" /> <img src="images/srchBtn.gif" width="38" height="31" alt="" class="vrtMid" /><br class="cl" /></div>-->
            <div class="confMessage fnt13"></div>
            
        
                <div class = "BdgesArea">
				<div align='center' >
				<span><?php echo $message; ?></span>
				
				
				</div>
             
				 
				 <form name="msisdn-form" id="msisdn-form" method="post" action="nomsisdn.php" onsubmit="return validate();" >
				 enter your Mobile Number:<input type="text" name="msisdn" id="msisdn"  placeholder="enter your mobile"/>
<input type="submit" name="submit" id="submit" value="submit" >				 
				 </form>
				 
                   
            </div>
            <div class="badgeBanner" align="center"></div>
            <div class="badgesArea">
                <div class="badges fnt14"><a href="badges.php?navipage=Badges">Badges</a></div>
                <div class="ldrBord fnt14"><a href="Leaderboard.php?navipage=Badges">Leaderboard</a></div>
                <div class="cl"></div>
            </div>
            <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
            <div class="mt25" align="center"><a href="subscription.php?navipage=Badges"><img src="images/monsoon.jpg" width="310" height="143" alt="" /></a></div>
            <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
        </div>
        <div class="footer">
            <div class="footerLnks">
                <div class="footerLnks"> <a href="termsncondition.php?navipage=Badges">T &amp;Cs</a> | <a href="faqs.php?navipage=Badges">FAQs</a> </div>
                <div class="poweredBy">Powered by Hungama</div>
            </div>
        </div>
    </body>
</html>
