<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>Uninor</title>
    </head>
    <?php
    session_start();
    include ("/var/www/html/hungamacare/config/dbConnect.php");
    $navipage = $_REQUEST['navipage'];
    $msisdn = '9582596960';
    ////////////////////////////////// start code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////

    $textQuery = "select ques_played from uninor_summer_contest.tbl_contest_subscription_wapcontest  where ANI='" . $msisdn . "' ";
    $textResult = mysql_query($textQuery);
    $textDetails = mysql_fetch_array($textResult);

    $msgQuery = "select msg from uninor_summer_contest.tbl_msg_detail_wapcontest  where type='topup' ORDER BY RAND() limit 1";
    $msgResult = mysql_query($msgQuery);
    $msgDetails = mysql_fetch_array($msgResult);

    $msg = $msgDetails['msg'];

////////////////////////////////// end code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////
    ?>
    <body>
        <div class="header">
            <div class="logo"><img src="images/logo.jpg" width="121" height="72" alt="" /></div>
            <div class="welcUser mt47" align="right">Hi +91<?php echo $msisdn; ?> &nbsp;&nbsp; <a href="myProfile.php?navipage=TopUp"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; 
                <a href="index.php?navipage=TopUp"><img src="images/home-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; </div>
            <div class="cl"></div>
        </div>
        <div class="pt10"><div class="constName">Khelo India Jeeto India</div></div>
        <div class="cont">
<!--        <div class="srch"><input name="" type="text" /> <img src="images/srchBtn.gif" width="38" height="31" alt="" class="vrtMid" /><br class="cl" /></div>-->
            <div class="confMessage fnt13">
                <?php
                echo $msg;
                ?>
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
                <div class="cntstNm">Monsoon Contest</div>
                <div class="cntstQno">
                    <?php
                    $playedQues = $scoreDetails['ques_played'];
                    if ($playedQues == '') {
                        $playedQues = 0;
                    }
                    echo "Ques:" . $playedQues;
                    ?>
                </div>
                <div class="cl"></div>
            </div>
            <div class="quesArea">
                <div class="topUp">Click below to top -up your account</div>
                <div class="pt10">
                    <div class="topUpPlnBtnNew" style="width:200px">Rs.5 for 7 questions</div><div class="topUpPlnBtnNew" style="width:200px">Rs.3 for 5 questions</div><div class="topUpPlnBtnNew" style="width:200px">Rs.2 for 3 questions</div>
<!--                    <div class="pt10"><a href="#"><img src="images/nxtBtn.jpg" width="54" height="22" alt="" /></a></div>-->
                </div>
            </div>
            <div class="badgesArea">
                <div class="badges fnt14"><a href="badges.php?navipage=TopUp">Badges</a></div>
                <div class="ldrBord fnt14"><a href="Leaderboard.php?navipage=TopUp">Leaderboard</a></div>
                <div class="cl"></div>
            </div>
            <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
            <div class="mt25" align="center"><a href="#"><img src="images/monsoon.jpg" width="310" height="143" alt="" /></a></div>
            <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
        </div>
        <div class="footer">
            <div class="footerLnks">
                <div class="footerLnks"><a href="termsncondition.php?navipage=TopUp">T &amp;Cs</a> | <a href="faqs.php?navipage=TopUp">FAQs</a></div>
                <div class="poweredBy">Powered by Hungama</div>
            </div>
        </div>
    </body>
</html>