<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
//$con = mysql_connect("10.43.248.137","team_user","teamuser@voda#123");
$con = mysql_connect("10.43.248.137","php_promo","php@321");
	if(!$con)
	{
		die('could not connect1: ' . mysql_error());
	}

if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
	if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
	}
	
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	//$getCircle = "select circle from master_db.tbl_valid_series where series =$validseries";
	$circle=mysql_query($getCircle,$con) or die( mysql_error() );
	$circleRow = mysql_fetch_row($circle);
	$cid=$circleRow[0];
	echo trim($cid);
	/*$blockCircle=array('HAY','JNK','MAH','TNU');
	if(!in_array($cid,$blockCircle)) {
	echo "OK";
	}
	else
	{
	echo "NOK";
	
	}*/
mysql_close($con);
?> 