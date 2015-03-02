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
            <div class="welcUser mt47" align="right">Hi +91<?php echo $msisdn; ?> &nbsp;&nbsp; <a href="myProfile.php?navipage=Frequently Asked Questions"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; 
                <a href="index.php?navipage=Frequently Asked Questions"><img src="images/home-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; </div>
            <div class="cl"></div>
        </div>
        <div class="pt10"><div class="constName">Khelo India Jeeto India</div></div>
        <div class="cont">
<!--            <div class="srch"><input name="" type="text" /> <img src="images/srchBtn.gif" width="38" height="31" alt="" class="vrtMid" /><br class="cl" /></div>-->
            <div class="confMessage fnt13"></div>
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
                    ?>
                </div>
                <div class="cl"></div>
            </div>
            <div class="BdgesArea">
                <div class="topUpNew" align="center"><u>Frequently Asked Questions FAQs</u></div>

            </div>
            <div class="BdgesArea">
                <b> Objective</b>
                <br/><br/>
                This document discusses in detail about Uninor- Khelo India Jeeto India
            </div>
            <div class="BdgesArea">
                <b> How can a subscriber subscribe to the service?</b>
                <br/><br/>
                The subscriber can access XYZ.in
                Subscription Model: In this model, a Subscriber can subscribe to the service either through WAP link and after subscribing to the service, User can play the contest through any of the mode as per the fair usage policy. The subscription to portal is free, customer will be charged only once he chooses the particular contest on the portal

            </div>
            <div class="BdgesArea">
                <b> What are the subscription charges for this service?</b>
                <br/><br/>
                A user would be charged Rs.5 per contest day to use this service as per his/her discretion. After a subscriber has been charged the chosen amount, he/she can use this service accordingly & can play 7 question in a day. Once the questions are over user will be asked for top-up.
            </div>
            <div class="BdgesArea">
                <b> How would I know about the promotional schemes, if any, is there under this service? </b>
                <br/><br/>
                Subscribed user of this service would be updated on a regular basis about the promotional offers under this service through means of SMS/OBDs.
            </div>
            <div class="BdgesArea">
                <b> What are service features?</b>
                <br/><br/>
                Features of KHELO INDIA JEETO INDIA are mentioned as under;
                <br/>
                1. Play theme based contest round the year on your mobile by just dialing a simple short code
                <br/>
                2. 365 Days of exciting Prizes.
                <br/>
                3. Contest theme changes as per flavor of the month to add fun & excitement.
                <br/>
                4. Limited set of questions per day per contest to avoid boredom.
                <br/>
                5. Daily leader board on IVR, SMS to increase customer stickiness.
                <br/>
                6. Talk-time as Daily prizes to boost customer moral.
                <br/>
                7. Real time scoring makes it more thrilling for customers. 
                <br/>
                8. Daily packs with fallbacks make it affordable, keeping customers pocket happy.
                <br/>
                9. Instant top-up for keeping the momentum rolling.
                <br/>
                10. The voice of the portal is different from traditional IVRSs keeping it playful to give an extra edge with exciting background music.
                <br/>
                11. Customer can seamlessly move from one vector to another.
            </div>
            <div class="BdgesArea">
                <b> Will service work on Roaming?</b>
                <br/><br/>
                KHELO INDIA KHELO will not work on Roaming
            </div>
        </div>
        <div class="badgesArea">
            <div class="badges fnt14"><a href="badges.php?navipage=Frequently Asked Questions">Badges</a></div>
            <div class="ldrBord fnt14"><a href="Leaderboard.php?navipage=Frequently Asked Questions">Leaderboard</a></div>
            <div class="cl"></div>
        </div>
        <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
        <div class="mt25" align="center"><a href="#"><img src="images/banner.jpg" width="310" height="143" alt="" /></a></div>
        <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
        </div>
        <div class="footer">
            <div class="footerLnks">
                <div class="footerLnks"> <a href="termsncondition.php?navipage=Frequently Asked Questions">T &amp;Cs</a> | <a href="faqs.php?navipage=Frequently Asked Questions">FAQs</a></div>
                <div class="poweredBy">Powered by Hungama</div>
            </div>
        </div>
    </body>
</html>
