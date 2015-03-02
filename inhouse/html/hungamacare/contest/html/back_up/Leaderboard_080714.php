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
    $msisdn = '8587800665';
    ?>
    <body>
        <div class="header">
            <div class="logo"><img src="images/logo.jpg" width="121" height="72" alt="" /></div>
            <div class="welcUser mt47" align="right">Hi 91+9821325268 &nbsp;&nbsp; <a href="myProfile.php"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; 
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
                        $highscoreQuery = "select score from uninor_summer_contest.tbl_contest_subscription_wapcontest order by score desc limit 4";
                        $highscoreResult = mysql_query($highscoreQuery);
                        $i = 1;
                        $j = 1;
                        while ($highscoreDetails = mysql_fetch_array($highscoreResult)) {
//                            $leaderimg1 = "images/badge1.gif";
//                            $leaderimg2 = "images/badge2.gif";
//                            $leaderimg3 = "images/badge3.gif";
//                            $leaderimg4 = "images/badge4.gif";
//                            $imgname =  $leaderimg . $i;
                            //$leaderimg5 = "images/badge4.gif";
                            ?>
                            <tr>
                                <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble"><?php echo $highscoreDetails[score]; ?></td>
                                <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble"><?php echo $i; ?></td>
                                <?php if ($i == 1) { ?>
                                    <td align="center" height="70" valign="middle" bgcolor="#f1f0f0"><img src="images/badge1.gif" width="50" height="50" alt="" /></td>
                                <?php } else if ($i == 2) { ?>
                                    <td align="center" height="70" valign="middle" bgcolor="#f1f0f0"><img src="images/badge2.gif" width="50" height="50" alt="" /></td>
                                <?php } else if ($i == 3) {
                                    ?>
                                    <td align="center" height="70" valign="middle" bgcolor="#f1f0f0"><img src="images/badge3.gif" width="50" height="50" alt="" /></td>
                                <?php } else if ($i == 4) {
                                    ?>
                                    <td align="center" height="70" valign="middle" bgcolor="#f1f0f0"><img src="images/badge4.gif" width="50" height="50" alt="" /></td>
                                <?php } else if ($i == 5) {
                                    ?>
                                    <td align="center" height="70" valign="middle" bgcolor="#f1f0f0"><img src="images/badge5.gif" width="50" height="50" alt="" /></td>
                                <?php } ?>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
<!--                        <tr>
    <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble">12345</td>
    <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble">01</td>
    <td align="center" height="70" valign="middle" bgcolor="#f1f0f0"><img src="images/badge1.gif" width="50" height="50" alt="" /></td>
</tr>
<tr>
    <td align="left" height="70" valign="middle" bgcolor="#eaeaea" class="brdRght leadBoardTble">12345</td>
    <td align="left" height="70" valign="middle" bgcolor="#eaeaea" class="brdRght leadBoardTble">01</td>
    <td align="center" valign="middle" bgcolor="#eaeaea"><img src="images/badge2.gif" width="50" height="50" alt="" /></td>
</tr>
<tr>
    <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble">12345</td>
    <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble">01</td>
    <td align="center" height="70" valign="middle" bgcolor="#f1f0f0"><img src="images/badge3.gif" width="50" height="50" alt="" /></td>
</tr>
<tr>
    <td align="left" height="70" valign="middle" bgcolor="#eaeaea" class="brdRght leadBoardTble">12345</td>
    <td align="left" height="70" valign="middle" bgcolor="#eaeaea" class="brdRght leadBoardTble">01</td>
    <td align="center" valign="middle" bgcolor="#eaeaea"><img src="images/badge4.gif" width="50" height="50" alt="" /></td>
</tr>
<tr>
    <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble">12345</td>
    <td align="left" height="70" valign="middle" bgcolor="#f1f0f0" class="brdRght leadBoardTble">01</td>
    <td align="center" height="70" valign="middle" bgcolor="#f1f0f0"><img src="images/badge3.gif" width="50" height="50" alt="" /></td>
</tr>-->
                    </table>            
                </div>       
            </div>
            <div class="badgeBanner" align="center">Your Current badge... banner</div>
            <div class="badgesArea">
                <div class="badges fnt14"><a href="badges.php">Badges</a></div>
                <div class="ldrBord fnt14"><a href="Leaderboard.php">Leaderboard</a></div>
                <div class="cl"></div>
            </div>
            <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
            <div class="mt25" align="center"><a href="#"><img src="images/banner.jpg" width="310" height="143" alt="" /></a></div>
            <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
            <div class="footer">
                <div class="footerLnks">
                    <div class="footerLnks"><a href="#">About Us</a> | <a href="#">T &amp;Cs</a> | <a href="#">FAQs</a> | <a href="#">Contact Us</a></div>
                    <div class="poweredBy">Powered by Hungama</div>
                </div>
            </div>
    </body>
</html>
