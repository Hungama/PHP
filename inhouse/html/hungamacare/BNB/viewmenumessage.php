<?php
session_start();
require_once("db.php");
$menuid = $_GET['menuid'];
$ussdstr = $_GET['ussdstr'];
if(!empty($ussdstr))
{
$ussdstr=$ussdstr.'#';
$get_query="select menu_id,songname from USSD.tbl_songname where status=1 and ussd_string ='$ussdstr'";
}
else
{
$get_query="select menu_id,menu from USSD.tbl_ussd_config where level=0 and serialid=$menuid";
}
	$query = mysql_query($get_query,$con);
	$numofrows=mysql_num_rows($query);
if($numofrows==0)
{
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<?php// echo ALERT_NO_RECORD_FOUND;?>
<h4>Ooops!</h4>Hey, we couldn't seem to find any message  of current menu id.
</div>
</div>
<?php
}
else
{
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-info">
<?php
$summarydata = mysql_fetch_array($query);
if(!empty($ussdstr))
{
echo 'Message for USSD String- '.$ussdstr.'<br></br>';
}
else
{
echo 'Message for Menu Id- '.$summarydata['menu_id'].'<br></br>';
}
echo $summarydata[1];
?>
</div></div>
   
<?php
	}
mysql_close($dbConn);
?>