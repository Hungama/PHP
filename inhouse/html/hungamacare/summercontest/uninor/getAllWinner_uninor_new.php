<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$allcircle=array();
$circle_uninor=array('APD','BIH','GUJ','MAH','UPE','UPW');
$getTopWinnerquery = "select ANI, total_question_play,score,date_time,circle,SOU,lastChargeAmount,pulses from uninor_summer_contest.tbl_contest_misdaily where date(date_time)='".$date."' and score>=1 and circle not in('null','','UPE') order by score desc limit 6";

$result_winner = mysql_query($getTopWinnerquery, $dbConn) or die(mysql_error());

$result_row = mysql_num_rows($result_winner);

if ($result_row > 0) {
$deletequery = "delete from uninor_summer_contest.tbl_contest_misdaily_recharged where date(date_time)='".$date."' ";
$result_delete = mysql_query($deletequery, $dbConn) or die(mysql_error());
		$j=1;
			while ($winner_details = mysql_fetch_array($result_winner))
				  {
		$insert_query = "insert into uninor_summer_contest.tbl_contest_misdaily_recharged (ANI,total_question_play,score,date_time,circle,status,level,SOU,lastChargeAmount,pulses) 
		values ('". $winner_details['ANI'] ."','".$winner_details['total_question_play']."','". $winner_details['score']."','" .$winner_details['date_time']. "','" .$winner_details['circle']. "',0,'".$j."','" .$winner_details['SOU']. "','" .$winner_details['lastChargeAmount']. "','" .$winner_details['pulses']. "')";
        mysql_query($insert_query, $dbConn);
				$j++;
				  }
		
		}
else
{
echo "exit";
}
echo 'done';
mysql_close($dbConn);
?>  