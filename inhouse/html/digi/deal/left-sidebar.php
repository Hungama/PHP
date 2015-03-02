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
				<li><a href="index.php" <?php if($cpage=='home.php') { echo $setstyle;}?>>Simulator Mode</a></li>
				<?php /*?><li><a href="list-all-configfiles.php" <?php if($cpage=='list-all-configfiles.php'){ echo $setstyle;}?>>List All Config Files</a></li>
				<li><a href="add-group.php" <?php if($cpage=='add-group.php') { echo $setstyle;}?>>Create New Group</a></li>
				<li><a href="list-group.php" <?php if($cpage=='list-group.php') { echo $setstyle;}?>>List All Groups</a></li>
				<li><a href="check-msisdn.php" <?php if($cpage=='check-msisdn.php') { echo $setstyle;}?>>Check MSISDN</a></li>
				<li><a href="list-all-msisdn.php" <?php if($cpage=='list-all-msisdn.php') { echo $setstyle;}?>>List MSISDN</a></li>
				<li><a href="pwd-change.php" <?php if($cpage=='pwd-change.php') { echo $setstyle;}?>>Password Change</a></li>
				<!--li><a href="logout.php">Logout</a></li--><?php */?>
			</ul>
