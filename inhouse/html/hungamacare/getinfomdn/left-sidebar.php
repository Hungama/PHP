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
<li><a href="home.php" <?php if($cpage=='home.php'){ echo $setstyle;}?>>Home</a></li>
</ul>
<h3><a href="logout.php" style="color:#ffffff">Logout</a></h3>