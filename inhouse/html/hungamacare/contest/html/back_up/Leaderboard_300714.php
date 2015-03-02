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
    $msisdn = '9582596960';
    ?>
    <body>
        <div class="header">
            <div class="logo"><img src="images/logo.jpg" width="121" height="72" alt="" /></div>
            <div class="welcUser mt47" align="right">Hi 91+<?php echo $msisdn; ?> &nbsp;&nbsp; <a href="myProfile.php"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; 
                <a href="index.php"><img src="images/home-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; </div>
            <div class="cl"></div>
        </div>
        <div class="pt10"><div class="constName">Khelo India Jeeto India</div></div>
        <div class="cont">
<!--        <div class="srch"><input name="" type="text" /> <img src="images/srchBtn.gif" width="38" height="31" alt="" class="vrtMid" /><br class="cl" /></div>-->
            <div class="confMessage fnt13">My Profile > Leaderboard</div>
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
            <div class="quesArea">
                <div class="topUpNew" align="center">Leaderboard</div>
                <div class="pt1">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="33%" height="28" align="left" valign="middle" bgcolor="#cecdcd" class="brdRght leadBoardTble">Score</td>
                            <td width="33%" height="28" align="left" valign="middle" bgcolor="#cecdcd" class="brdRght leadBoardTble">Rank</td>
                            <td width="33%" height="28" align="left" valign="middle" bgcolor="#cecdcd" class="leadBoardTble">Badge</td>
                        </tr>
                        <?php
                        $highscoreQuery = "select score,ANI from uninor_summer_contest.tbl_contest_subscription_wapcontest order by score desc limit 5";
                        $highscoreResult = mysql_query($highscoreQuery);
                        $i = 1;
                        while ($row = mysql_fetch_array($highscoreResult)) {
                            $badgeQuery = "select badge_id from uninor_summer_contest.tbl_contest_begges_wapcontest  where ANI='" . $row['ANI'] . "' order by date_time desc limit 1";
                            $badgeResult = mysql_query($badgeQuery);
                            $badgeDetails = mysql_fetch_array($badgeResult);
                            $badge_id = $badgeDetails['badge_id'];
                            $badgeinfoQuery = "select badge_name,badge_image_name from uninor_summer_contest.tbl_badge_detail_wapcontest  where id='" . $badge_id . "' ";
                            $badgeinfoResult = mysql_query($badgeinfoQuery);
                            $badgeinfoDetails = mysql_fetch_array($badgeinfoResult);
                            $badge_name = $badgeinfoDetails['badge_name'];
                            $badge_image_name = $badgeinfoDetails['badge_image_name'];
                            ?>
                            <tr>
                                <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble"><?php echo $row['score']; ?></td>
                                <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble"><?php echo $i; ?></td>
                                <td align="center" height="70" valign="middle" bgcolor="#f1f0f0"><img src="images/<?php echo $badge_image_name ?>" width="50" height="50" alt="" /></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>

                    </table>            
                </div>       
            </div>
            <?php
            $rankQuery = "SELECT t1.ANI, score,
                         (SELECT COUNT(*) FROM uninor_summer_contest.tbl_contest_subscription_wapcontest t2 WHERE t2.score > t1.score) +1
                          AS rank
                          FROM uninor_summer_contest.tbl_contest_subscription_wapcontest t1 where t1.ANI='" . $msisdn . "' order by score";
            $rankResult = mysql_query($rankQuery);
            $rankDetails = mysql_fetch_array($rankResult);
            $rank = $rankDetails['rank'];
            //////////////////////////////////////// start code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////
            $textQuery = "select ques_played,ques_available from uninor_summer_contest.tbl_contest_subscription_wapcontest  where ANI='" . $msisdn . "' ";
            $textResult = mysql_query($textQuery);
            $textDetails = mysql_fetch_array($textResult);
            if ($textDetails['ques_played'] == 5 && $textDetails['ques_available'] == 0) {
                $msg = "To know where you stand enter the contest now!<a href='subscription.php'> Click here to Subscribe</a> @ just Rs.5/day";
            } else {
                $msg = "You are standing on " . $rank . " Rank..";
            }
////////////////////////////////// end code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////
            ?>
            <div class="badgeBanner" align="center"><?php echo $msg; ?></div>
            <div class="badgesArea">
                <div class="badges fnt14"><a href="badges.php">Badges</a></div>
                <div class="ldrBord fnt14"><a href="Leaderboard.php">Leaderboard</a></div>
                <div class="cl"></div>
            </div>
            <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
            <div class="mt25" align="center"><a href="subscription.php"><img src="images/banner.jpg" width="310" height="143" alt="" /></a></div>
            <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
            <div class="footer">
                <div class="footerLnks">
                    <div class="footerLnks"><a href="#">About Us</a> | <a href="termsncondition.php">T &amp;Cs</a> | <a href="faqs.php">FAQs</a> | <a href="#">Contact Us</a></div>
                    <div class="poweredBy">Powered by Hungama</div>
                </div>
            </div>
    </body>
</html>
