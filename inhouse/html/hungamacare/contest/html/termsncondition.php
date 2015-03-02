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
    ?>
    <body>
        <div class="header">
            <div class="logo"><img src="images/logo.jpg" width="121" height="72" alt="" /></div>
            <div class="welcUser mt47" align="right">Hi +91<?php echo $msisdn; ?> &nbsp;&nbsp; <a href="myProfile.php?navipage=Terms And Conditions"><img src="images/user-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; 
                <a href="index.php?navipage=Terms And Conditions"><img src="images/home-icon.gif" width="21" height="23" alt="" /></a> &nbsp;&nbsp; </div>
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
            <div class="BdgesArea">
                <div class="topUpNew" align="center">Terms And Conditions</div>

            </div>
            <div class="BdgesArea">
                1.	The Contest is organized by Hungama Digital Media Entertainment Private Limited, a company incorporated under the Companies Act, 1956, having its registered Office at F-1, First Floor, Laxmi Woollen Mills Estate, Shakti Mills Lane, Off Dr. E. Moses Road, Mahalaxmi, Mumbai-400011, India (hereinafter referred to as the Organizer) in association with Telewings Communications Services Private   Limited, a company incorporated under the Companies Act, 1956, having its registered Office at A-38, Kailash Colony, New Delhi-110048 (Uninor).

            </div>
            <div class="BdgesArea">
                2.	The Contest is open for the valid prepaid subscribers of Uninor (Subscriber(s)) for the telecom circles of  Andhra Pradesh, Bihar  & Jharkhand, Gujarat Maharashtra, Uttar Pradesh (East) and  Uttar Pradesh- (West)
            </div>
            <div class="BdgesArea">
                3.	This Contest will be governed by these standard terms and conditions, and accompanying details (collectively the "Terms"). Each Subscriber agrees that he/she has read and understood these Terms and by their participation in the Contest and he/she agrees to be bound by the Terms.
            </div>
            <div class="BdgesArea">
                4.	This Contest is available for a limited period and commences from 17th July and will continue till 13th August 2014 (Contest Period). 
            </div>
            <div class="BdgesArea">
                5.	Participation in the Contest: i. To participate in the Contest, the Subscriber has to subscribe to Khelo India Jeeto India contest pack (KIJI Pack) at Rs 5 per day and answer a series of 7 multiple-choice questions through WAP. The Subscriber can subscribe the Pack through WAP ii. Option of subscribing a Pack of Rs 3 with 5 questions and of Rs 2 with 3 questions is also available. iii. After the last question the Subscriber shall be given an option to subscribe for more questions iv.  Each correct answer fetches the subscriber ten points. iv. Subscriber of a particular Uninor number answering maximum questions correctly in the shortest possible time during the Contest Period shall be eligible for prizes. v. 
            </div>
            <div class="BdgesArea">
                6.	Winner Selection & Prizes : <br/><br/>
                a.	<b>Daily Winners and Daily Prizes (Rs.100): </b>i During the Contest Period, 1 winner per circle will be declared as daily winners for that day. ii. Subscribers who score the maximum points in their respective circles in shortest time period shall be daily winners. iii. The Daily winners will be informed through SMS. iii. Daily winners will get a recharge worth of Rs 100 each. For this Contest a day shall commence from 00:00 AM and end at 23:59 PM.
                <br/><br/><b>Grand Prizes:</b> i. At the end of Contest Period winners of grand prizes from Pan India shall be declared as per below mentioned details:
                <br/><br/>
                1.<b>	Holiday Trip- Domestic for a couple (1st prize): </b> Top Subscriber from Pan India who scores the highest points during the entire Contest Period in the shortest time period shall be awarded <b>Domestic holiday trip for a couple</b>, provided the Subscriber scores a minimum of 3000 points during the Contest Period. 
            </div>
            <div class="BdgesArea">
                7.	The prizes have to be claimed by the winners in person from Uninors store/ franchise store or any other location, as notified by Uninor after submitting copy of his/her Identity proof & address proof, which will be first validated by Uninor and such identity proof should match with the identity records of the Subscriber in the records of Uninor. The winners shall also be required to complete the documentation as desired by Uninor, to claim the prizes.
            </div>
            <div class="BdgesArea">
                8.	No cash shall be given in exchange of the prize won.
            </div>
            <div class="BdgesArea">
                9.	Any failure on the part of the winner to comply with directions issued by Uninor, or in the event of any ambiguity / uncertainty / unavailability of the winner, Uninor, in its own discretion will be entitled to cancel the prize(s) for the said winner(s) and may proceed to select other winner through same process.
            </div>
            <div class="BdgesArea">
                10.	The decision of Uninor in respect of all transactions / award of prizes under this Contest shall be final and binding.
            </div>
            <div class="BdgesArea">
                11.	A  Subscriber shall mean the person in whose name the mobile phone number is registered as per the records maintained by Uninor 
            </div>
            <div class="BdgesArea">
                12.	Uninor reserves the right to extend, cancel, discontinue, change, alter, modify, and/or prematurely withdraw this Contest on its sole discretion at any time.
            </div>
            <div class="BdgesArea">
                13.	Shape & size of the prize may differ from its picture shown on the leaflets/ website or any other publicity material, communication. Uninor does not provide any warranty or guarantee (whether express or implied) including the warranty for the quality, fitness or merchantability of the prize.
            </div>
            <div class="BdgesArea">
                14.	Uninor or its directors/officers/affiliated companies will, in no manner whatsoever, be responsible for circumstances beyond its control, which hinder the completion of this Contest.
            </div>
            <div class="BdgesArea">
                15.	Uninor shall not responsible for any failure of SMS delivery. 
            </div>
            <div class="BdgesArea">
                16.	This Contest cannot be combined with any other offer or promotion currently being offered.
            </div>
            <div class="BdgesArea">
                17.	Acceptance of the Terms of this Contest shall constitute consent on the Subscribers part, to allow the use of the Subscribers entry, names, images, video footage, voices and/or likeness by the Uninor for editorial, advertising, promotional, marketing and/or other purposes, without further compensation to the Subscriber.  
            </div>
            <div class="BdgesArea">
                18.	Neither the employees of Uninor nor their family members or relatives are eligible to participate in this Contest. Any such entry, even if successful, would be deemed inadmissible.
            </div>
            <div class="BdgesArea">
                19.	This Contest does not grant to the Subscriber any right or interest or title to any of Uninor's intellectual properties. The winner shall be responsible for any additional, incidental expenses required to be incurred to avail of the prize. All taxes, insurances, transfers, spending money and other incidental and related expenses as the case may be, unless specifically stated, are the sole responsibility of the prize winner.
            </div>
            <div class="BdgesArea">   
                20.	The Subscriber shall indemnify Uninor, its offices, directors and affiliates against any claims including third party claims, disputes, actions, liabilities and damages that may arise as a result of act or omissions of the Subscriber, on account of Subscribers breach of the terms and conditions of this Contest  and /or Subscribers failure to comply with applicable laws.
            </div>  
            <div class="BdgesArea">   
                21.	Uninor reserves the sole right to assign, novate, transfer its rights and / or obligations under this Contest or emanating from this Contest at any point in time, in full or part, without seeking any consent or approval or providing any notice (prior or later) to Participant or any one else.
            </div>
            <div class="BdgesArea"> 
                22.	This Contest shall be governed by and construed in accordance with the laws of India. The Courts at Delhi shall have the exclusive jurisdiction to try any dispute arising out of this Contest. 
            </div>
            <div class="BdgesArea"> 
                23.	If in case participant takes refund on this service during the contest tenure he or she  will not be eligible for the gratification.
            </div>
            <div class="BdgesArea"> 
                24.	If in case the winner is not reachable or does not responds to our queries through Telecalling, SMS or Email for 7 days after completion of the contest, his/her prize shall be forfeited and will be offered to the next winner in the list as per the Points table
            </div>
        </div>
        <div class="badgesArea">
            <div class="badges fnt14"><a href="badges.php?navipage=Terms And Conditions">Badges</a></div>
            <div class="ldrBord fnt14"><a href="Leaderboard.php?navipage=Terms And Conditions">Leaderboard</a></div>
            <div class="cl"></div>
        </div>
        <div class="socialIcons" align="center"><a href="#"><img src="images/facebookIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/twitterIcon.jpg" width="41" height="35" alt="" /></a><img src="images/divider.gif" width="3" height="35" alt="" /><a href="#"><img src="images/googlePlusIcon.jpg" width="41" height="35" alt="" /></a></div>
        <div class="mt25" align="center"><a href="#"><img src="images/monsoon.jpg" width="310" height="143" alt="" /></a></div>
        <div class="mt25" align="center"><img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /> &nbsp; <a href="#" class="blueTxt">Back to Top</a> &nbsp; <img src="images/top-arrow.gif" width="8" height="4" class="vrtAlgnMid" alt="" /></div>
        </div>
        <div class="footer">
            <div class="footerLnks">
                <div class="footerLnks"> <a href="termsncondition.php?navipage=Terms And Conditions">T &amp;Cs</a> | <a href="faqs.php?navipage=Terms And Conditions">FAQs</a></div>
                <div class="poweredBy">Powered by Hungama</div>
            </div>
        </div>
    </body>
</html>
