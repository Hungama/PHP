<?php
error_reporting(0);
$dbConn_224 = mysql_connect("192.168.100.224", "webcc", "webcc");
if (!$dbConn_224) {
    echo '224- Could not connect';
    die('Could not connect: ' . mysql_error("could not connect to Local"));
}
$get_top10Data = "select score,ani as SC from uninor_summer_contest.tbl_contest_subscription order by score desc limit 10";
$data_top10 = mysql_query($get_top10Data, $dbConn_224) or die(mysql_error());
?>
<div class="badgestbl clearfix">
	<div class="row clearfix">
		<div class="fl col1">MRP</div>
		<div class="fl colsep">&nbsp;</div>
		<div class="fl col2">SCORE</div>
		<div class="fl colsep">&nbsp;</div>
		<div class="fl col3">BADGE</div>
	</div>
<?php
$i = 1;
$badgeimageurl="http://119.82.69.212/hungamacare/summercontest/uninorKIJIWebsiteAPI/badges/";
while ($rows = mysql_fetch_array($data_top10)) {
   $ani = $rows['SC'];
   $badge_image_name='';
    $get_badge_id = "select distinct badge_id from uninor_summer_contest.tbl_contest_begges where ANI='" . $ani . "' limit 3";
    $data_badge_id = mysql_query($get_badge_id, $dbConn_224) or die(mysql_error());
	$imgidarray=array();
	$k=0;
    while($badge_id_data = mysql_fetch_array($data_badge_id))
	{
    $badge_id = $badge_id_data['badge_id'];
    $get_badge_details = "select id,badge_name,badge_image_name from uninor_summer_contest.tbl_badge_detail where badge_question='" . $badge_id . "'";
    $data_badge_details = mysql_query($get_badge_details, $dbConn_224) or die(mysql_error());
    $badge_details = mysql_fetch_array($data_badge_details);
	$imgidarray[$k]=$badge_details['id'];
	$k++;
}
?>
		<div class="bdrbtm clearfix">
		<div class="fl col1"><?php echo $i;?></div>
		<div class="fl colsep">&nbsp;</div>
		<div class="fl col2"><?php echo $rows['score'];?></div>
		<div class="fl colsep">&nbsp;</div>
		<div class="fl col3">
		<?php
		foreach($imgidarray as $imgid)
		{?>
		<img src="<?php echo $badgeimageurl.$imgid.'.png';?>" width="36" height="36" border="0" alt="">&nbsp;
		<?php
		}
		?>
	</div>
	</div>
<?php
$i++;
}
?>
</div>