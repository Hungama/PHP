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
<?php
if($_SESSION["id"]=='275')
{?>
<li><a href="listmsisdn.php" <?php if($cpage=='digiobd.php') { echo $setstyle;}?>>List MSISDN</a></li>
<?php
}
?>

			</ul>
<h3><a href="logout.php" style="color:#ffffff">Logout</a></h3>