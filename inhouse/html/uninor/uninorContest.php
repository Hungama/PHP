<?php

$action = $_REQUEST['action'];
$msisdn = $_REQUEST['msisdn'];
$Qno = $_REQUEST['Qno'];
$Ans = $_REQUEST['Ans'];
$pid = $_REQUEST['pid'];
$amnt = $_REQUEST['amnt'];
$QDetails = $_REQUEST['QDetails'];

$dbname = 'uninor_summer_contest';
$subscriptionProcedure = 'Contest_SUB';

$mysqli = new mysqli("database.master", "weburl", "weburl");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if ($action == 'sub') {
    $call = "call " . $dbname . "." . $subscriptionProcedure . "($msisdn,'01','WAP','52201','5','5464627',181)";
    $qry1 = $mysqli->query($call);

    $insertBadgeDetail = "insert into uninor_summer_contest.tbl_user_winning_badges values('','Mansoon Contest',$msisdn,0,0,0,0,now(),'',now(),1) ";

    $InsertBadgeRecord = $mysqli->query($insertBadgeDetail);
    echo 'ok';
}
if ($action == 'getStatus') {
    $getStatusQuery = "select count(*) from uninor_summer_contest.tbl_contest_subscription where ani=" . $msisdn;
    $getQuestionResult = $mysqli->multi_query($getStatusQuery);
    if ($getQuestionResult) {
        $results = 0;
        do {
            if ($result = $mysqli->store_result()) {
                while ($row = $result->fetch_row()) {
                    foreach ($row as $cell)
                        echo $cell;
                }
                $result->close();
            }
        } while ($mysqli->next_result());
    }
}
if ($action == 'getQNO') {
    $res = $mysqli->multi_query("CALL uninor_summer_contest.Contest_QUESTIONSTATUSNew($msisdn,1,@id);SELECT @id");
    if ($res) {
       $results = 0;
        do {
            if ($result = $mysqli->store_result()) {
                while ($row = $result->fetch_row()) {
                    foreach ($row as $cell)
                        echo $cell;
                }
                $result->close();
            }
        } while ($mysqli->next_result());
    }
}
if ($action == 'getQDetail') {
    $getQuestionQuery = "select question,answer_key from uninor_summer_contest.question_bank where Qno=" . $Qno;
    $getQuestionResult = $mysqli->multi_query($getQuestionQuery);
    if ($getQuestionResult) {
        $results = 0;
        do {
            if ($result = $mysqli->store_result()) {
                while ($row = $result->fetch_row()) {
                    foreach ($row as $cell)
                        echo $cell . ",";
                }
                $result->close();
            }
        } while ($mysqli->next_result());
    }
}
if ($action == 'scoreUpdate') {

    $QdetialsValue = unserialize(urldecode($QDetails));
    $QdetialsValue1 = explode("#", $QdetialsValue);
    if (trim($QdetialsValue1[2]) == trim($Ans)) {
        $INflag = 1;
        $result = 'success';
    } else {
        $INflag = 0;
        $result = 'failed';
    }
    $res1 = "CALL uninor_summer_contest.Contest_QUESTIONSTATUSUPDATENew('SummerContest',$msisdn,$QdetialsValue1[1],$QdetialsValue1[2],$Ans,$INflag,1,01,'WAP',$QdetialsValue1[6],'','',$QdetialsValue1[5])";
    $qry2 = $mysqli->query($res1);

    $bUpdateResult = updateBadge($msisdn, $result, $mysqli);
    echo $result;
}
if ($action == 'topUp') {
    $Topres1 = "CALL uninor_summer_contest.CONTEST_TOPUP($msisdn,$amnt,'52201',$pid,'WAP')";
    $qry2 = $mysqli->query($Topres1);
    echo 'success';
}
if ($action == 'getLeaders') {
    $i = 0;
    $getLeaderQuery = "select ani from uninor_summer_contest.question_played a group by ani order by max(score) desc limit 5";
    $getLeaderResult = $mysqli->multi_query($getLeaderQuery);
    if ($getLeaderResult) {
        $results = 0;
        do {
            if ($result = $mysqli->store_result()) {
                while ($row = $result->fetch_row()) {
                    $leaderArray .= $row[0] . "->";
                }
                $result->close();
            }
        } while ($mysqli->next_result());
    }
    echo $leaderArray;
}

function updateBadge($msisdn, $result1, $mysqli) {
    $getBadgeDetailQuery = "select total_ques,correct_ques,b2b_correct,badge_id from uninor_summer_contest.tbl_user_winning_badges where msisdn=" . $msisdn . " and status=0";
    $getBadgeDetailResult = $mysqli->multi_query($getBadgeDetailQuery);
    if ($getBadgeDetailResult) {
        $results = 0;
        do {
            if ($result = $mysqli->store_result()) {

                while ($row = $result->fetch_row()) {
                    switch (trim($result1)) {
                        case 'success':
                            if (getBadgeQuestion($row[3]) == ($row[0] + 1))
                                $status = 1;
                            $updatebadgeDetaile = "update uninor_summer_contest.tbl_user_winning_badges set total_ques=" . ($row[0] + 1);
                            $updatebadgeDetaile .= ",correct_ques=" . ( $row[1] + 1) . ",b2b_correct=" . ($row[2] + 1);
                            if ($status) {
                                $total_ques = ($row[0] + 1);
                                $correct_ques = ($row[1] + 1);
                                $b2b = ($row[2] + 1);
                                $updatebadgeDetaile .= ",status=1";
                            }
                            $updatebadgeDetaile .= " where msisdn=" . $msisdn . " and badge_id=" . $row[3];
                            break;
                        case 'failed':
                            if (getBadgeQuestion($row[3]) == ($row[0] + 1)) {
                                $status = 1;
                            }
                            $updatebadgeDetaile = "update uninor_summer_contest.tbl_user_winning_badges set total_ques=" . ($row[0] + 1);
                            $updatebadgeDetaile .= ",correct_ques=" . $row[1] . ",b2b_correct=" . ($row[2] - $row[2] % 3);
                            if ($status) {
                                $total_ques = ($row[0] + 1);
                                $correct_ques = $row[1];
                                $b2b = ($row[2] - $row[2] % 3);
                                $updatebadgeDetaile .= ",status=1";
                            }
                            $updatebadgeDetaile .= " where msisdn=" . $msisdn . " and badge_id=" . $row[3];
                            break;
                    }
                    //echo $updatebadgeDetaile;
                    $updatebadgeDetaile1 = $mysqli->query($updatebadgeDetaile);
                    if ($status) {
                        $insertBadgeDetail = "insert into uninor_summer_contest.tbl_user_winning_badges values(''";
                        $insertBadgeDetail .= ",'Mansoon Contest',$msisdn,$total_ques,$correct_ques,0,$b2b,'','',now(),$row[3]+1) ";
                        $InsertBadgeRecord = $mysqli->query($insertBadgeDetail);
                    }
                }
                $result->close();
            }
        } while ($mysqli->next_result());
    }
}

function getBadgeQuestion($badge_id) {
    switch ($badge_id) {
        case '1':
            $total_ques = 1;
            break;
        case '2':
            $total_ques = 5;
            break;
        case '3':
            $total_ques = 10;
            break;
        case '4':
            $total_ques = 20;
            break;
        case '5':
            $total_ques = 25;
            break;
        case '6':
            $total_ques = 30;
            break;
    }
    return $total_ques;
}

if($action=='getBagdelist')
{
    $badgeDetails=getBadges($msisdn, $mysqli);
    
}

function getBadges($msisdn, $mysqli) {
    $getBadgeDetailQuery = "select a.id,a.badge_name,a.badge_image_name from uninor_summer_contest.tbl_badge_detail a,uninor_summer_contest.tbl_user_winning_badges b";
    $getBadgeDetailQuery .= " where b.msisdn=".$msisdn." and b.status=1 and a.id=b.badge_id and b.user_status=1 order by id";
    $getBadgeDetailResult = $mysqli->multi_query($getBadgeDetailQuery);
    if ($getBadgeDetailResult) {
        $results = 0;
        do {
            if ($result = $mysqli->store_result()) {
                while ($row = $result->fetch_row()) {
                    echo $row[0].','.$row[1].','.$row[2]."->";
                }
                $result->close();
            }
        } while ($mysqli->next_result());
    }
}

?>