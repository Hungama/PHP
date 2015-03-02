  <?php
function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$cpagename=curPageName();

?>
  <ul class="nav navbar-right usernav">
                   <li>
							<?php
							$imgurl="http://bugify.hungamavoice.com/assets/gravatar/32/".$_SESSION['email'];
							?>
							<!--img src="<?php echo $imgurl;?>" alt="" /-->		
				     <span class="label label-info"><?php echo 'Welcome, '.$_SESSION['loginId'];?></span>
				   </li>
				   <?php
				   if($cpagename=='dashboardGLC1.php' || $cpagename=='bulkUploadGLC.php' || $_SESSION['loginId']=='shreya.tyagi')
				   {?>
					<li><a href="dashboardGLC1.php"><span class="icon16 icomoon-icon-grid-3"></span><span class="txt"> Dashboard</span></a></li>
					<li><a href="bulkUploadGLC.php"><span class="icon16 icomoon-icon-upload-3"></span><span class="txt"> BulkUpload</span></a></li>
				<?php }
				
if($cpagename=='dashboardAd.php')
{?>
<li><a href="dashboardAd.php"><span class="icon16 icomoon-icon-grid-3"></span><span class="txt">Ad Dashboard</span></a></li>
<?php
}
if($cpagename=='dashboardTataTiscon.php' || $_SESSION['loginId']=='shreya.tyagi')
{?>
<li><a href="dashboardTataTiscon.php"><span class="icon16 icomoon-icon-grid-3"></span><span class="txt">TataTiscon Dashboard</span></a></li>
<?php
}
?>
				
                    <li><a href="logout.php?page=<?php echo $cpagename;?>"><span class="icon16 icomoon-icon-exit"></span><span class="txt"> Logout</span></a></li>
  </ul>