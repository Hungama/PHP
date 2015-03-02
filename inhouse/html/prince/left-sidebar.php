<?php
/*
function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$cpage=curPageName();
//$setstyle="style='color:red'";
$setstyle="style='font-weight:bold'";
*/
?>
<h3>Menu</h3>
<ul class="nav">
<li><a href="listallCallLogs.php" <?php if($cpage=='listallCallLogs.php') { echo $setstyle;}?>>Call Log IVR</a></li>
<li><a href="listallCallLogs_OBD.php" <?php if($cpage=='listallCallLogs_OBD.php') { echo $setstyle;}?>>Call Log OBD</a></li>
</ul>
<h3><a href="logout.php" style="color:#ffffff">Logout</a></h3>