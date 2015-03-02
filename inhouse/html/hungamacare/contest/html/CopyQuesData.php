<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");
// Read from file
$lines = file("/var/www/html/hungamacare/contest/html/quesans.txt");
foreach ($lines as $line) {
    // Check if the line contains the string we're looking for, and print if it does
    $details = explode("#", $line);
    $content_id = $details[0];
    $content_type = $details[1];
    $lang = $details[2];
    $difficulty_level = $details[3];
    $question = $details[4];
    $answer_key = $details[5];
    $insQry = "insert into uninor_summer_contest.question_bank_wapcontest (content_id,content_type,lang,difficulty_level,question,answer_key,prompt_name,addon,video,image)
        values ('" . $content_id . "','" . $content_type . "','" . $lang . "','" . $difficulty_level . "','" . $question . "','" . $answer_key . "','" . $content_id . "',now(),'//www.youtube.com/embed/ivZ3JmecdyE','banner.jpg')";
    $result = mysql_query($insQry);
}
///////////////////////////// code end for take msisdn from file n if found then copy into a new file @jyoti.porwal////////////////////////////////////// 
echo "done";
?>

