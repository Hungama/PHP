<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script>
	<style type="text/css">
a:link {color:#0000FF;}      /* unvisited link */
a:visited {color:#006400;}  /* visited link */
</style>
	</head>
<body>
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
	</div>
	<div id="middle">
		<div id="left-column">
		<?php include('left-sidebar.php');?>	
		</div>
		<div id="center-column">
			<div class="top-bar">
				<h1>List MSISDN </h1>
				</div>
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<table class="listing" cellpadding="0" cellspacing="0">
				<form action="listmsisdn.php" method="post">
				<tr class="bg">
						<td class="first"><strong>Select Date</strong>
						&nbsp;<input type="text" id="startdate" maxlength="25" size="25" name="form_startdate" <?php if($_POST['action'] == 1) {?> value="<?=date("Y-m-d",strtotime($_POST['form_startdate']))?>" <?php }?>>
						<a href="javascript:NewCal('startdate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date">
						</td>
						<td class="last">
						<textarea id="form_msisdn" name="form_msisdn" rows="4" cols="50"><?php if($_POST['action'] == 1) {echo $_POST['form_msisdn'];}?></textarea>
						&nbsp;&nbsp;
						<input type="hidden" name="action" value="1" />
						<input type="submit" name="submit" value="Go"/>
						&nbsp;&nbsp;
				<?php
				
if($_POST['action'] == 1) {
	
$date = date("Y-m-d",strtotime($_POST['form_startdate']));
$getmsisdns = $_POST['form_msisdn'];

//$msisdns = explode(",", $getmsisdns);
//8655668286,7417220144,8885149893,8090792127
$getMsisdnRecord= mysql_query("select msisdn,response,transactionId from master_db.tbl_recharged where date(request_time)='$date' and msisdn in($getmsisdns)");
$totalrecord=mysql_num_rows($getMsisdnRecord);


if($totalrecord>0)
{?>
				<a href="xls_listmsisdn.php?sdate=<?=$date?>&getmsisdns=<?=$getmsisdns?>" title="Click to download file.">
						<img src="img/download-icon.png" width="32" height="32" alt="" /></a>
<?php
} 
?>
						</td>
						</a>
	 
		</td>
					</tr>
					</form>
					

<?php

if($totalrecord>0)
{?>
	<tr><th colspan="2">Total no of <?= $totalrecord;?> records found of date <?= $date?>.</th></tr>
	<tr>
					<th class="first">Msisdn</th>
					<th>URL</th>
	</tr>
		<?php
	while($result_list = mysql_fetch_array($getMsisdnRecord))
				{
if(!empty($result_list['msisdn']))
{
	$pos = strrpos($result_list['response'],"Successful");

	if($pos)
		$status='Success';
	else
		$status='Failed';

	$decodeResponse=urldecode($response);
	$exploded=explode("|",$decodeResponse);
	
	$callBackUrl="http://192.168.100.218:81/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/Recharge.Notification.php";
	$callBackUrl .="?status=".$status."&response=".$exploded[2]."&tid=".$result_list['transactionId']."&responseText=".$result_list['response'];
	//echo $callBackUrl."<br>";



					?>
					<tr>
						<td><?=$result_list['msisdn']?></td>
						<!--td><?//= wordwrap($callBackUrl, 40, "<br>", true);?></td-->
						<td><a href="<?php echo $callBackUrl;?>" target="_blank"><?= wordwrap($callBackUrl, 40, "<br>", true);?></a></td>
					</tr>
				<?php
}
				}
}
else
{?>
<tr><th colspan="2">No records found.</th></tr>
<?php
}
		}			
?>
			
					</table>
				        <p>&nbsp;</p>
		  </div>
		</div>
		<div id="right-column">
<?php include('right-sidebar.php');
//close database connection
mysql_close($con);
?>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>