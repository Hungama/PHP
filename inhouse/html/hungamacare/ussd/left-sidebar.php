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
			<?php
			if($_SESSION["logedinuser"]=='wap_admin')
			{?>
<li><a href="uploadRingtone.php" <?php if($cpage=='uploadRingtone.php'){ echo $setstyle;}?>>Send Waplink</a></li>
			<?php
			}

else if($_SESSION["logedinuser"]=='ussdadmin')
			{
			$getcount = mysql_query("select count(*) from uninor_myringtone.tbl_ussd_mapping where ussd_string='*288#'");
			$result_count=mysql_fetch_array($getcount);
			
			if($result_count[0]>=1){
			?>
<li><a href="showuninor_ussd.php" <?php if($cpage=='showuninor_ussd.php'){ echo $setstyle;}?>>View USSD Data</a></li>
			<?php
			}
			else
			{?>
			<li><a href="uninor_ussd.php" <?php if($cpage=='uninor_ussd.php'){ echo $setstyle;}?>>Upload USSD Data</a></li>
			<?php
			}}
				else if($_SESSION["logedinuser"]=='admin_ussd'||$_SESSION["logedinuser"]=='arung.ussd'||$_SESSION["logedinuser"]=='arunsingh.ussd'||$_SESSION["logedinuser"]=='neha_ussd'||$_SESSION["logedinuser"]=='gadadhar.ussd'||$_SESSION["logedinuser"]=='anand.rao.ussd'||$_SESSION["logedinuser"]=='gagandeep.dhall')
			{?>
<li><a href="upload_ussdbase.php" <?php if($cpage=='upload_ussdbase.php'){ echo $setstyle;}?>>Upload Base</a></li>
			<?php
			}
			
			else {
			?>
<li><a href="uninor_ussd_myringtone.php" <?php if($cpage=='uninor_ussd_myringtone.php'){ echo $setstyle;}?>>Upload Mapping Data</a></li>
<li><a href="listmappingdata.php" <?php if($cpage=='listmappingdata.php'){ echo $setstyle;}?>>List Mapping Data</a></li>
<?php }?>
</ul>
<h3><a href="logout.php" style="color:#ffffff">Logout</a></h3>