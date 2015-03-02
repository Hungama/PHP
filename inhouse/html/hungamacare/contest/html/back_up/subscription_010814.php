<?php
session_start();
include ("/var/www/html/hungamacare/config/dbConnect.php");
$msisdn = $_REQUEST['msisdn'];
$txt = $_REQUEST['txt'];
$type = $_REQUEST['type'];
$navipage = $_REQUEST['navipage'];
//$msisdn = '8587800665';
$msisdn = '9582596960';
///////////////////////////////// start code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////
$textQuery = "select ques_played,ques_available from uninor_summer_contest.tbl_contest_subscription_wapcontest  where ANI='" . $msisdn . "' ";
$textResult = mysql_query($textQuery);
$textDetails = mysql_fetch_array($textResult);
if ($textDetails['ques_played'] == 5) {
    $msg = "Your free questions are over! Enter the contest now & be the Lucky one to win Exciting<b> <br/>COUPLE HOLIDAY TRIP.</br></b><a href='subscription.php?navipage=Subscription'>Click here to Subscribe</a> </br>@ just Rs.5/day";
}
if ($textDetails['ques_available'] > 0) {
    header("Location:index.php?navipage=Subscription");
}
////////////////////////////////// end code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>Uninor</title>
    </head>
    <body>
        <div class="header">
            <div class="logo"><img src="images/logo.jpg" width="121" height="72" alt="" /></div>
            <div class="welcUser mt47" align="right">Hi +91<?php echo $msisdn; ?> &nbsp;&nbsp; <a href="myProfile.php?navipage=Subscription"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; 
                <a href="index.php?navipage=Subscription"><img src="images/home-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; </div>
            <div class="cl"></div>
        </div>
        <div class="pt10"><div class="constName">Khelo India Jeeto India</div></div>
        <div class="cont">
<!--            <div class="srch"><input name="" type="text" /> <img src="images/srchBtn.gif" width="38" height="31" alt="" class="vrtMid" /><br class="cl" /></div>-->
            <div class="confMessage fnt13">
            <!--                <span class="blueTxt1">Superb!</span> -->
                <?php // echo $msg;    ?>   
            </div>
            <div class="topContDtls mb10">
                <div class="cntstNo">
                    <?php
                    $scoreQuery = "select score,ques_played from uninor_summer_contest.tbl_contest_subscription_wapcontest  where ANI='" . $msisdn . "' ";
                    $scoreResult = mysql_query($scoreQuery);
                    $scoreDetails = mysql_fetch_array($scoreResult);
                    $score = $scoreDetails['score'];
                    if ($score == '') {
                        $score = 0;
                    }
                    echo "Score:" . $score;
                    ?>
                </div>
                <div class="cntstNm">Jhankar Beats Contest</div>
                <div class="cntstQno">
                    <?php
                    $playedQues = $scoreDetails['ques_played'];
                    if ($playedQues == '') {
                        $playedQues = 0;
                    }
                    echo "Ques:" . $playedQues;
                    if (isset($_SESSION['CREATED'])) {
                        if ((time() - $_SESSION['CREATED'] > 1800) && $textDetails['ques_played'] == 5) {
                            // session started more than 30 minutes ago
                            $msg = "Welcome back to Khelo India Jeeto India! You have earned " . $score . " points, Enter the contest now & be the Lucky one to win Exciting <b><br/>COUPLE HOLIDAY TRIP </br>& DAILY RECHARGES.</b><br/> <a href='subscription.php?navipage=Subscription'>Click here to Subscribe </a></br>@ just Rs.5/day";
                            $_SESSION['CREATED'] = time();  // update creation time
                        }
                    } else {
                        if (!isset($_SESSION['CREATED'])) {
                            $_SESSION['CREATED'] = time();
                        }
                    }

                    $msg = '';
                    ?>
                </div>
                <div class="cl"></div>
            </div>
            <div class="pt" align="center">
                <?php echo $msg; ?>
            </div>

            <div class="badgesArea">
                <div class="badges fnt14"><a href="badges.php?navipage=Subscription">Badges</a></div>
                <div class="ldrBord fnt14"><a href="Leaderboard.php?navipage=Subscription">Leaderboard</a></div>
                <div class="cl"></div>
            </div>

            <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
            <div align="center"><a href="subscription.php?navipage=Subscription"><img src="images/banner.jpg" width="310" height="143" alt="" /></a></div>
            <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
        </div>
        <div class="footer">
            <div class="footerLnks">
                <div class="footerLnks"> <a href="termsncondition.php?navipage=Subscription">T &amp;Cs</a> | <a href="faqs.php?navipage=Subscription">FAQs</a></div>
                <div class="poweredBy">Powered by Hungama</div>
            </div>
        </div>

    </body>
</html>