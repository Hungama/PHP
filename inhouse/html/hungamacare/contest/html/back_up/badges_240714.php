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
<!--            <div class="srch"><input name="" type="text" /> <img src="images/srchBtn.gif" width="38" height="31" alt="" class="vrtMid" /><br class="cl" /></div>-->
            <div class="confMessage fnt13">My Profile > Badges</div>
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
            <div class="BdgesArea">
                <div class="topUpNew" align="center">Badge</div>
                <?php
                $i = 0;
                $badge_array = array();
                $badgeQuery = "select badge_id from uninor_summer_contest.tbl_contest_begges_wapcontest  where ANI='" . $msisdn . "' order by date_time asc";
                $badgeResult = mysql_query($badgeQuery);
                while ($row = mysql_fetch_array($badgeResult)) {
                    $i++;
                    $badge_id = $row['badge_id'];
                    $badgeinfoQuery = "select badge_name,badge_image_name from uninor_summer_contest.tbl_badge_detail_wapcontest  where id='" . $badge_id . "' ";
                    $badgeinfoResult = mysql_query($badgeinfoQuery);
                    $badgeinfoDetails = mysql_fetch_array($badgeinfoResult);
                    $badge_name = $badgeinfoDetails['badge_name'];
                    $badge_image_name = $badgeinfoDetails['badge_image_name'];
                    $badge_array[$i]['badge_name'] = $badge_name;
                    $badge_array[$i]['badge_image_name'] = $badge_image_name;
                }
                for ($j = 1; $j <= $i;) {
                    ?>
                    <div class="pt10">
                        <div align="center">
                            <?php
                            $l = $j;
                            $m = $l + 1;
                            $n = $m + 1;
                            if ($l <= $i) {
                                $badge_name = $badge_array[$l]['badge_name'];
                                ?>
                                <div class="Bdges" align="center">
                                    <div><img src="images/<?php echo $badge_array[$l]['badge_image_name']; ?>" width="85" height="85" /></div>
                                    <div class="Bdge1 wtTxt mt7"><a href="#"><?php echo $badge_name; ?></a></div>
                                </div>
                                <?php
                            }if ($m <= $i) {
                                $badge_name = $badge_array[$m]['badge_name'];
                                ?>
                                <div class="Bdges" align="center">
                                    <div><img src="images/<?php echo $badge_array[$m]['badge_image_name']; ?>" width="85" height="85" /></div>
                                    <div class="Bdge1 wtTxt"><a href="#"><?php echo $badge_name; ?></a></div>
                                </div>
                                <?php
                            }if ($n <= $i) {
                                $badge_name = $badge_array[$n]['badge_name'];
                                ?>
                                <div class="Bdges" align="center">
                                    <div><img src="images/<?php echo $badge_array[$n]['badge_image_name']; ?>" width="85" height="85" /></div>
                                    <div class="Bdge1 wtTxt"><a href="#"><?php echo $badge_name; ?></a></div>
                                </div>
                            <?php } ?>
                            <div class="cl"></div>
                        </div>
                    </div>
                    <?php
                    $j = $j + 3;
                }
                ?>
            </div>
            <div class="badgeBanner" align="center">Your Current badge... <?php echo $badge_name ?></div>
            <div class="badgesArea">
                <div class="badges fnt14"><a href="badges.php">Badges</a></div>
                <div class="ldrBord fnt14"><a href="Leaderboard.php">Leaderboard</a></div>
                <div class="cl"></div>
            </div>
            <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
            <div class="mt25" align="center"><a href="#"><img src="images/banner.jpg" width="310" height="143" alt="" /></a></div>
            <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
        </div>
        <div class="footer">
            <div class="footerLnks">
                <div class="footerLnks"><a href="#">About Us</a> | <a href="#">T &amp;Cs</a> | <a href="#">FAQs</a> | <a href="#">Contact Us</a></div>
                <div class="poweredBy">Powered by Hungama</div>
            </div>
        </div>
    </body>
</html>
