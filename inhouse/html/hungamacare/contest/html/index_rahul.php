<?php
session_start();
include ("/var/www/html/hungamacare/config/dbConnect.php");
$msisdn = $_REQUEST['msisdn'];
$txt = $_REQUEST['txt'];
$type = $_REQUEST['type'];
$navipage = $_REQUEST['navipage'];
$msisdn = '8587800665'; 
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
        $checkbadgeQuery = "select badge_id from uninor_summer_contest.tbl_contest_begges_wapcontest  where badge_id='" . $badgeid . "' and ANI='" . $msisdn . "'";
        $checkbadgeResult = mysql_query($checkbadgeQuery);
        $checkbadgeDetails = mysql_fetch_array($checkbadgeResult);
        $bageExist = $checkbadgeDetails['badge_id'];
        if (!$bageExist) {
            $insBadgeQuery = "insert into uninor_summer_contest.tbl_contest_begges_wapcontest (ANI,badge_id,date_time) values ('$msisdn','$badgeid',now())";
            $badgeResult = mysql_query($insBadgeQuery);
        }
    }
    if ($ques_played == 50 || $ques_played == 100) {
        if ($ques_played == 50) {
            $badgeid = 8;
        } else {
            $badgeid = 9;
        }
        $checkbadgeQuery = "select badge_id from uninor_summer_contest.tbl_contest_begges_wapcontest  where badge_id='" . $badgeid . "'  and ANI='" . $msisdn . "'";
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
$content_id = $allDetails[2];
/*code  for read the video from json file by Rahul Tripathi*/
$demo_content_id='2588783';
$videourl = "http://192.168.100.212/hungamacare/contest/API/videoApi.php?contentid=" . $demo_content_id;
$ch1 = curl_init($videourl);
curl_setopt($ch1, CURLOPT_POST, true);
curl_setopt($ch1, CURLOPT_POSTFIELDS);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
$videodata = curl_exec($ch1);
/* end of the code for getting url*/
$image = $allDetails[3];
$image1 = $allDetails[4];
$image2 = $allDetails[5];
$image3 = $allDetails[6];
$details = explode('Q.', $allDetails[1]);

//$quesAnsDeatils = $details[1];

$allData = explode('?', $quesAnsDeatils);
$quesData = $allData[0];
$optData = $allData[1];
$optDetails = explode(',', $optData);
$option1 = $optDetails[0];
$option2 = $optDetails[1];
$option3 = $optDetails[2];
$option4 = $optDetails[3];

////////////////////////////////// start code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////
$textQuery = "select ques_played,ques_available from uninor_summer_contest.tbl_contest_subscription_wapcontest  where ANI='" . $msisdn . "' ";
$textResult = mysql_query($textQuery);
$textDetails = mysql_fetch_array($textResult);

if ($textDetails['ques_played'] == 0) {
    $msg = "Welcome to <b>Khelo  India Jeeto India!</b> Enjoy the splash of Monsoon with your loved ones on Monsoon Magic contest. Just play 5 free questions now & stand a chance to gives you a chance to win<b> <br/>COUPLE HOLIDAY TRIP</br>, DAILY RECHARGES</b> and much more.";
} else if (($textDetails['ques_available'] == '7' || $textDetails['ques_available'] == '5' || $textDetails['ques_available'] == '3') && $textDetails['ques_played'] == 5) {
    $msg = "<b>Congratulations!!!</B> You have entered the contest successfully, get " . $textDetails['ques_available'] . " questions Keep playing Monsoon Magic Contest & be the Lucky one to win Exciting <b><br/>COUPLE HOLIDAY TRIP <br/>& DAILY RECHARGES.</b> ";
}
 elseif($textDetails['ques_available'] == 0) {
        header("Location:topup.php?navipage=Home");
        echo "hi";
    }
////////////////////////////////// end code for text in contest site @jyoti.porwal ///////////////////////////////////////////////////////////
if ($msg == 'NotOk') {
    if ($textDetails['ques_played'] == 5) {
        header("Location:subscription.php?navipage=Home");
    }
   
    }
    
    else {
        header("Location:topup.php?navipage=Home");
    
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
            <div class="welcUser mt47" align="right">Hi +91<?php echo $msisdn; ?> &nbsp;&nbsp; <a href="myProfile.php?navipage=Home"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; 
                <a href="index.php?navipage=Home"><img src="images/home-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; </div>
            <div class="cl"></div>
        </div>
        <div class="pt10"><div class="constName">Khelo India Jeeto India</div></div>
        <div class="cont">
<!--            <div class="srch"><input name="" type="text" /> <img src="images/srchBtn.gif" width="38" height="31" alt="" class="vrtMid" /><br class="cl" /></div>-->
            <div class="confMessage fnt13">
<!--                <span class="blueTxt1">Superb!</span> -->
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
            <?php //if (Modernizr . video) 
            //
            if($videodata!=''){ ?>
                                                                                                                                        <!--                <div class="pt" align="center"><iframe width="310" height="233" src="http://aks3dlre.vodafonemusic.in/s3/r/ms2/2430482/5/815/Palat_-_Tera_Hero_Idhar_Hai.mp4?__gda__=1407317991_9cc4a13098d8aef34aa7ca6ddc284fad" frameborder="0" allowfullscreen></iframe></div>-->
                <div class="pt" align="center"> 
				
<a href="<?php echo $videodata; ?>"><img src="<?php echo $image1 ?>" width="150" height="150" alt="" /></a> 
				</div>
            <?php } else { ?>
                <div class="pt" align="center"><img src="<?php //echo "images/" . $image 
               echo $image1; ?>"width="150" height="150"  alt="image" /></div>
            <?php } ?><!--width="310" height="233"-->
            <div class="quesArea fnt14">Watch the video carefully to answer the question</div>
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
                <div class="badges fnt14"><a href="badges.php?navipage=Home">Badges</a></div>
                <div class="ldrBord fnt14"><a href="Leaderboard.php?navipage=Home">Leaderboard</a></div>
                <div class="cl"></div>
            </div>

            <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
            <div align="center"><a href="#"><img src="images/monsoon.jpg" width="310" height="143" alt="" /></a></div>
            <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
        </div>
        <div class="footer">
            <div class="footerLnks">
                <div class="footerLnks"><a href="termsncondition.php?navipage=Home">T &amp;Cs</a> | <a href="faqs.php?navipage=Home">FAQs</a></div>
                <div class="poweredBy">Powered by Hungama</div>
            </div>
        </div>

    </body>
</html>