<?php
function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$cpage=curPageName();
//$setstyle="style='color:red'";
$setstyle="style='font-weight:bold'";
?>
<h3>Menu</h3>
			<ul class="nav">
		
				<!--li><a href="digiobd.php" <?php if($cpage=='digiobd.php') { echo $setstyle;}?>>Add DIGI OBD</a></li>
				<li><a href="hulobd.php" <?php if($cpage=='hulobd.php'){ echo $setstyle;}?>>Add HUL OBD</a></li-->

<?php
if($_SESSION["id"]=='277')
{?>
<li><a href="hulobd.php" <?php if($cpage=='hulobd.php'){ echo $setstyle;}?>>Add HUL OBD</a></li>
<li><a href="hulobd_promotion.php" <?php if($cpage=='hulobd_promotion.php'){ echo $setstyle;}?>>Add HUL OBD-Promotional</a></li>
<li><a href="listallpushedobd.php" <?php if($cpage=='listallpushedobd.php'){ echo $setstyle;}?>>Pushed HUL OBD</a></li>
<li><a href="listallmissed.php" <?php if($cpage=='listallmissed.php') { echo $setstyle;}?>>List All Missed</a></li>
<li><a href="check-msisdn.php" <?php if($cpage=='check-msisdn.php'){ echo $setstyle;}?>>Missed call of user</a></li>
<li><a href="check-contentusage.php" <?php if($cpage=='check-contentusage.php'){ echo $setstyle;}?>>Content Usages</a></li>
<li><a href="listalluploadobd.php" <?php if($cpage=='listalluploadobd.php'){ echo $setstyle;}?>>List all uploaded file</a></li>
<li><a href="listallpushedobdbyodbname.php" <?php if($cpage=='listallpushedobdbyodbname.php'){ echo $setstyle;}?>>Pushed OBD Info</a></li>

<?php
}
else if($_SESSION["id"]=='275')
{?>

<li><a href="digiobd.php" <?php if($cpage=='digiobd.php') { echo $setstyle;}?>>Add DIGI OBD</a></li>
<li><a href="dwnOBDdata.php" <?php if($cpage=='dwnOBDdata.php') { echo $setstyle;}?>>Download DIGI OBD Data</a></li>
<li><a href="dwnDayWiseData.php" <?php if($cpage=='dwndatadaywise.php') { echo $setstyle;}?>>Day Wise Data</a></li>
<li><a href="viewPrompt.php" <?php if($cpage=='viewPrompt.php') { echo $setstyle;}?>>Uploaded Prompt</a></li>
<li><a href="digiSuccessFailCount.php" <?php if($cpage=='digiSuccessFailCount.php') { echo $setstyle;}?>>DIGI OBD Success/Failure/KeyPress</a></li>
<?php
}
else if($_SESSION["id"]=='279')
{?>
<!--li><a href="listallmissed_test.php" <?php if($cpage=='listallmissed.php' || $cpage=='listallmissed_new.php') { echo $setstyle;}?>>List All Missed</a></li>
<li><a href="listall_usedcontent.php" <?php if($cpage=='listall_usedcontent.php') { echo $setstyle;}?>>List Usages Content</a></li-->

<li><a href="listall_usedcontent1.php" <?php if($cpage=='listall_usedcontent1..php') { echo $setstyle;}?>>List All Missed</a></li>
<li><a href="listallhulpromotion.php" <?php if($cpage=='listallhulpromotion.php') { echo $setstyle;}?>>Promotional OBD</a></li>

<?php
}
else if($_SESSION["id"]=='384')
{?>
<li><a href="digiobd.php" <?php if($cpage=='digiobd.php') { echo $setstyle;}?>>Add DIGI OBD</a></li>
<?php
}
else if($_SESSION["id"]=='391')
{?>
<li><a href="listallCallLogs.php" <?php if($cpage=='listallCallLogs.php') { echo $setstyle;}?>>Call Log IVR</a></li>
<li><a href="listallCallLogs_OBD.php" <?php if($cpage=='listallCallLogs_OBD.php') { echo $setstyle;}?>>Call Log OBD</a></li>
<?php
}
else
{?>
<li><a href="digiobd.php" <?php if($cpage=='digiobd.php') { echo $setstyle;}?>>Add DIGI OBD</a></li>
<li><a href="dwnOBDdata.php" <?php if($cpage=='dwnOBDdata.php') { echo $setstyle;}?>>Download DIGI OBD Data</a></li>
<?php
}
?>

			</ul>
<h3><a href="logout.php" style="color:#ffffff">Logout</a></h3>
<div id="tooltip" style="visibility:hidden;border:0px solid black;font-size:12px;layer-background-color:lightyellow;background-color:#9097A9;padding:4px;color:#ffffff;width:150px;height:auto;margin-top:10px"></div>