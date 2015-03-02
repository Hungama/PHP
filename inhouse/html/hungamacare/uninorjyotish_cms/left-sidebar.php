<?php
function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$cpage=curPageName();
//$setstyle="style='color:red'";
$setstyle="style='font-weight:bold'";
?>
<h3>Logged In As</h3>
<ul class="nav">
<li>
 <?php echo '<b>'.$_SESSION["logedinuser"].'</b>';?>
</li>
</ul>
<h3>Menu</h3>
			<ul class="nav">
		
				<!--li><a href="digiobd.php" <?php if($cpage=='digiobd.php') { echo $setstyle;}?>>Add DIGI OBD</a></li>
				<li><a href="hulobd.php" <?php if($cpage=='hulobd.php'){ echo $setstyle;}?>>Add HUL OBD</a></li-->

<?php
if($_SESSION["id"]=='293')
{?>
<li><a href="uninor_jyotish_bulk.php" <?php if($cpage=='uninor_jyotish_bulk.php'){ echo $setstyle;}?>>Uninor Jyotish data</a></li>
<?php
}
?>
</ul>
<h3><a href="logout.php" style="color:#ffffff">Logout</a></h3>