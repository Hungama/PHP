<?php
session_start();
include ("/var/www/html/hungamacare/config/dbConnect.php");
$msisdn = $_REQUEST['msisdn'];
$txt = $_REQUEST['txt'];
$type = $_REQUEST['type'];
$msisdn = '8587800665';
//$msisdn = '1234567899';
//if (Modernizr . video) {
//    echo " let's play some video!";
//} else {
//    echo " no native video support available :(";
//}
if ($type == 'rply') {
    $current_time = strtotime(date(YmdHis));
    $rply_time = strtotime($_REQUEST['rply_time']);
    $time_consume = $current_time - $rply_time;
    if ($time_consume <= 15) {
        $bonuspoint = 'Y';
    } else {
        $bonuspoint = 'N';
    }
    $url = "http://192.168.100.212/hungamacare/contest/API/contestApi.php?msisdn=" . $msisdn . "&txt=" . $txt . "&bonuspoint=" . $bonuspoint;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    $badgeQuery = "select ques_played,correct_ques,back_to_back from uninor_summer_contest.tbl_contest_subscription_wapcontest  where ANI='" . $msisdn . "' ";
    $badgeResult = mysql_query($badgeQuery);
    $badgeDetails = mysql_fetch_array($badgeResult);
    $ques_played = $badgeDetails['ques_played'];
    $correct_ques = $badgeDetails['correct_ques'];
    $back_to_back = $badgeDetails['back_to_back'];
    $badge_flag = 0;
    if ($ques_played == 1) {
        $badgeid = 1;
        $badge_flag = 1;
    } else if ($ques_played == 5) {
        $badgeid = 2;
        $badge_flag = 1;
    } else if ($ques_played == 10) {
        $badgeid = 3;
        $badge_flag = 1;
    } else if ($correct_ques == 20) {
        $badgeid = 4;
        $badge_flag = 1;
    } else if ($correct_ques == 25) {
        $badgeid = 5;
        $badge_flag = 1;
    } else if ($correct_ques == 30) {
        $badgeid = 6;
        $badge_flag = 1;
    }
    if ($badge_flag == 1) {
        $insBadgeQuery = "insert into uninor_summer_contest.tbl_contest_begges_wapcontest (ANI,badge_id,date_time) values ('$msisdn','$badgeid',now())";
        $badgeResult = mysql_query($insBadgeQuery);
    }
    if ($ques_played == 50 || $ques_played == 100) {
        if ($ques_played == 50) {
            $badgeid = 8;
        } else {
            $badgeid = 9;
        }
        $checkbadgeQuery = "select badge_id from uninor_summer_contest.tbl_contest_begges_wapcontest  where badge_id='" . $badgeid . "' ";
        $checkbadgeResult = mysql_query($checkbadgeQuery);
        $checkbadgeDetails = mysql_fetch_array($checkbadgeResult);
        $bageExist = $checkbadgeDetails['badge_id'];
        if (!$bageExist) {
            $insBadgeQuery = "insert into uninor_summer_contest.tbl_contest_begges_wapcontest (ANI,badge_id,date_time) values ('$msisdn','$badgeid',now())";
            $badgeResult = mysql_query($insBadgeQuery);
        }
    }
    if ($back_to_back == 3) {
        $badgeid = 7;
        $updateQuery = "update uninor_summer_contest.tbl_contest_subscription_wapcontest set back_to_back= 0 where ANI='" . $msisdn . "'";
        $updateResult = mysql_query($updateQuery);
        $insBadgeQuery = "insert into uninor_summer_contest.tbl_contest_begges_wapcontest (ANI,badge_id,date_time) values ('$msisdn','$badgeid',now())";
        $badgeResult = mysql_query($insBadgeQuery);
    }
} else {
    $url = "http://192.168.100.212/hungamacare/contest/API/contestApi.php?msisdn=" . $msisdn;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
}

$allDetails = explode('#', $data);
$msg = $allDetails[0];
$quesAnsDeatils = $allDetails[1];
$video = $allDetails[2];
$image = $allDetails[3];
//$details = explode('Q.', $allDetails[1]);
//$quesAnsDeatils = $details[1];
$allData = explode('?', $quesAnsDeatils);
$quesData = $allData[0];
$optData = $allData[1];
$optDetails = explode(',', $optData);
$option1 = $optDetails[0];
$option2 = $optDetails[1];
$option3 = $optDetails[2];
$option4 = $optDetails[3];

if ($msg == 'NotOk') {
    header("Location:topup.php");
}
$_SESSION['time'] = date(YmdHis);
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
            <div class="welcUser mt47" align="right">Hi 91+9821325268 &nbsp;&nbsp; <a href="myProfile.php"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; 
                <a href="index.php"><img src="images/home-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; </div>
            <div class="cl"></div>
        </div>
        <div class="pt10"><div class="constName">Khelo India Jeeto India</div></div>
        <div class="cont">
<!--            <div class="srch"><input name="" type="text" /> <img src="images/srchBtn.gif" width="38" height="31" alt="" class="vrtMid" /><br class="cl" /></div>-->
            <div class="confMessage fnt13">
<!--                <span class="blueTxt1">Superb!</span> -->
                <?php echo $msg; ?>   
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
            <?php if (Modernizr . video) { ?>
                <div class="pt" align="center"><iframe width="310" height="233" src="<?php echo $video ?>" frameborder="0" allowfullscreen></iframe></div>
            <?php } else { ?>
                <div class="pt" align="center"><img src="<?php echo "images/" . $image ?>" width="310" height="233" alt="image" /></div>
            <?php } ?>
            <div class="quesArea fnt14">watch the video carefully to answer the question.</div>
            <div class="quesArea">
<!--                <div class="vdoNm"><strong>Video:</strong> Jai Ho...</div>-->
                <div class="mt7"><strong>Question:</strong> <?php echo $quesData; ?></div>
                <form id="rplyFrm" action="" method="POST">
                    <div class="mt7"><input name="txt" id="txt1" type="radio" value="1" /> &nbsp;<?php echo $option1; ?> </div>
                    <div class="mt7"><input name="txt" id="txt2" type="radio" value="2" /> &nbsp; <?php echo $option2; ?></div>
                    <div class="mt7"><input name="txt" id="txt3" type="radio" value="3" /> &nbsp; <?php echo $option3; ?></div>
                    <div class="mt7"><input name="txt" id="txt4" type="radio" value="4" /> &nbsp; <?php echo $option4; ?></div>
                    <input type="hidden" name="type" id="type" value="rply"/>
                    <input type="hidden" name="rply_time" id="rply_time" value="<?php echo $_SESSION['time'] ?>"/>
                    <div class="mt7"> 
    <!--                    <a href="#"><img src="images/bckBtn.jpg" width="54" height="22" alt="" /></a> -->
<!--                        &nbsp; <a href="#"><img src="images/nxtBtn.jpg" width="54" height="22" alt="" /></a>-->
<!--                        <input type="submit" name="submt_btn" id="submt_btn" value="Submit"/>-->
                        <input id="submt_btn" name="submt_btn" type="image" src="images/nxtBtn.jpg" value="Submit" alt="" />
                    </div>
                </form>
            </div>
            <div class="badgesArea">
                <div class="badges fnt14"><a href="badges.php">Badges</a></div>
                <div class="ldrBord fnt14"><a href="Leaderboard.php">Leaderboard</a></div>
                <div class="cl"></div>
            </div>

            <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
            <div align="center"><a href="#"><img src="images/banner.jpg" width="310" height="143" alt="" /></a></div>
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