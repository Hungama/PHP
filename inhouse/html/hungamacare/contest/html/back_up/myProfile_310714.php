<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>Uninor</title>
    </head>
    <?php
    include ("/var/www/html/hungamacare/config/dbConnect.php");
    $navipage = $_REQUEST['navipage'];
    $msisdn = '9582596960';
    ?>
    <body>
        <div class="header">
            <div class="logo"><img src="images/logo.jpg" width="121" height="72" alt="" /></div>
            <div class="welcUser mt47" align="right">Hi +91<?php echo $msisdn; ?> &nbsp;&nbsp; <a href="myProfile.php?navipage=My Profile"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a>
                &nbsp;&nbsp; <a href="index.php?navipage=My Profile"><img src="images/home-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; </div>
            <div class="cl"></div>
        </div>
        <div class="pt10"><div class="constName">Khelo India Jeeto India</div></div>
        <div class="cont">
<!--            <div class="srch"><input name="" type="text" /> <img src="images/srchBtn.gif" width="38" height="31" alt="" class="vrtMid" /><br class="cl" /></div>-->
<!--            <div class="confMessage fnt13"><span class="redTxt">Sorry!</span> We are unable to top up your account right now. You will be informed about your top-up via SMS</div>-->
            <div class="confMessage fnt13"></div>
            <div class="topContDtls">
                <div class="cntstNo">
                    <?php
                    $scoreQuery = "select score,ques_played from uninor_summer_contest.tbl_contest_subscription_wapcontest  where ANI='" . $msisdn . "' ";
                    $scoreResult = mysql_query($scoreQuery);
                    $scoreDetails = mysql_fetch_array($scoreResult);
                    $score = $scoreDetails['score'];
                    if ($score == '') {
                        $score = 0;
                    }
                    echo "P - " . $score;
                    ?>
                </div>
                <div class="cntstNm">Jhankar Beats Contest</div>
                <div class="cntstQno">
                    <?php
                    $playedQues = $scoreDetails['ques_played'];
                    if ($playedQues == '') {
                        $playedQues = 0;
                    }
                    echo "Q - " . $playedQues;
                    ?>
                </div>
                <div class="cl"></div>
            </div>
            <?php
            $badgeQuery = "select badge_id from uninor_summer_contest.tbl_contest_begges_wapcontest  where ANI='" . $msisdn . "' order by date_time desc limit 1";
            $badgeResult = mysql_query($badgeQuery);
            $badgeDetails = mysql_fetch_array($badgeResult);
            $badge_id = $badgeDetails['badge_id'];
            $badgeinfoQuery = "select badge_name,badge_image_name from uninor_summer_contest.tbl_badge_detail_wapcontest  where id='" . $badge_id . "' ";
            $badgeinfoResult = mysql_query($badgeinfoQuery);
            $badgeinfoDetails = mysql_fetch_array($badgeinfoResult);
            $badge_name = $badgeinfoDetails['badge_name'];
            $badge_image_name = $badgeinfoDetails['badge_image_name'];
            $rankQuery = "SELECT t1.ANI, score,
                         (SELECT COUNT(*) FROM uninor_summer_contest.tbl_contest_subscription_wapcontest t2 WHERE t2.score > t1.score) +1
                          AS rank
                          FROM uninor_summer_contest.tbl_contest_subscription_wapcontest t1 where t1.ANI='" . $msisdn . "' order by score";
            $rankResult = mysql_query($rankQuery);
            $rankDetails = mysql_fetch_array($rankResult);
            $rank = $rankDetails['rank'];
            ///////////////////////////////// start code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////
            $textQuery = "select ques_played,ques_available from uninor_summer_contest.tbl_contest_subscription_wapcontest  where ANI='" . $msisdn . "' ";
            $textResult = mysql_query($textQuery);
            $textDetails = mysql_fetch_array($textResult);
            if ($textDetails['ques_played'] == 5 && $textDetails['ques_available'] == 0) {
                $msg = "To manage your profile enter the contest & know where you stand!<br/><a href='subscription.php?navipage=My Profile'> Click here to Subscribe</a></br> @ just Rs.5/day";
            } else if ($textDetails['ques_played'] != 5 && $textDetails['ques_available'] == 0) {
                $msg = "Your current Badge is" . $badge_name . " & Your Rank is " . $rank . " To continue playing the contest click on the home button & top-up your account.";
            } else {
                $msg = "Your current Badge is " . $badge_name . " & Your Rank is " . $rank;
            }

////////////////////////////////// end code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////
            ?>
            <div class="pt10">
                <div class="profBdge" align="center">
                    <div><img src="images/<?php echo $badge_image_name; ?>" width="150" height="144" /></div>
                    <div class="Bdge wtTxt"><a href="badges.php?navipage=My Profile">Badges</a></div>
                </div>
                <div class="ledrBord" align="center">
                    <div class="ledrBordLst">
                        <div align="left" class="lstNo mt20 ml10 mb10">
                            <?php
                            $highscoreQuery = "select score from uninor_summer_contest.tbl_contest_subscription_wapcontest order by score desc limit 3";
                            $highscoreResult = mysql_query($highscoreQuery);
                            $i = 1;
                            while ($highscoreDetails = mysql_fetch_array($highscoreResult)) {
                                ?>
                                <?php echo $i; ?> &nbsp; <?php echo $highscoreDetails[score]; ?> <br />
                                <?php
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="Bdge wtTxt"><a href="Leaderboard.php?navipage=My Profile">Leaderboard</a></div>
                </div>
                <div class="cl"></div>
            </div>
            <div class="bannerArea">
                <span class="fnt20"><?php echo $msg; ?></span>
            </div>
            <div align="center"><div class="back2Cont mt7"><a href="index.php?navipage=My Profile">Back to contest</a></div></div>
            <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
            <div class="mt25" align="center"><a href="subscription.php?navipage=My Profile"><img src="images/banner.jpg" width="310" height="143" alt="" /></a></div>
            <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
        </div>
        <div class="footer">
            <div class="footerLnks">
                <div class="footerLnks"> <a href="termsncondition.php?navipage=My Profile">T &amp;Cs</a> | <a href="faqs.php?navipage=My Profile">FAQs</a></div>
                <div class="poweredBy">Powered by Hungama</div>
            </div>
        </div>
    </body>
</html>