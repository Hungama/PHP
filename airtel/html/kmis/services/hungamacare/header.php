<?php
$file = $_SERVER["SCRIPT_NAME"];
$break = explode('/', $file);
$pfile = $break[count($break) - 1];
$serviceType=$_REQUEST['serviceType'];
if($serviceType=='TI')
{		$service_info=1602;
}
else
{
	if (!isset($service_info)) 
	{
	$service_info=$_REQUEST['service_info'];
	}
}		
$arrPermissibleModule = array();
$get_option="select b.module_id, a.module_name from master_db.ivr_web_module_master a, master_db.ivr_web_user_module b where a.id=b.module_id and status=1 and b.user_id='$_SESSION[usrId]'";
$query = mysql_query($get_option, $dbConn);
while(list($moduleId, $moduleName) = mysql_fetch_array($query)) {
    $arrPermissibleModule[$moduleId] = $moduleName; 
}
if(isset($_REQUEST['ch'])) $ch=trim($_REQUEST['ch']);
?>
<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td><img src="images/logo.png" alt="Hungama" align="left" border="0" hspace="0" vspace="15"><div style="margin-top: 20px; margin-right: 20px;" align="right"><b><font color="#0000cc">Welcome <?php echo ucwords(strtolower($_SESSION["usrName"])); ?> | </font><a href="javascript:void(0)" onClick="logout()"><font color="#0000cc">Logout</font></a> <br/> <?php if($_SESSION['lastLogin']!="0000-00-00 00:00:00") { ?>Last Login :: <?php echo $_SESSION['lastLogin']; } ?></b><br/><br/>
	<SELECT NAME="modules" class="in" onChange="window.open(this.options[this.selectedIndex].value,'_top')">
        <?php 
        if(in_array("Customer Care", $arrPermissibleModule)) { ?>
            <OPTION VALUE="main.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="main.php" || $pfile=="" || $pfile=="main_tc.php"){ echo "selected"; }?>>Customer Care</OPTION>    
        <?php } if(in_array("Bulk Upload", $arrPermissibleModule)) { ?>
            <OPTION VALUE="bulk_upload.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="bulk_upload.php" || $pfile=="" || $pfile=="bulk_upload_tc.php"){ echo "selected"; }?>>Bulk Upload</OPTION>
        <?php }
	      if(in_array("FRC Admin", $arrPermissibleModule)) { ?>
            <OPTION VALUE="frcAdmin.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="frcAdmin.php" || $pfile==""){ echo "selected"; }?>>FRC Admin</OPTION>
        <?php } 
	      if(in_array("SMS Bulk Upload", $arrPermissibleModule)) { ?>
            <OPTION VALUE="sms_bulk_upload.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="sms_bulk_upload.php" || $pfile==""){ echo "selected"; }?>>SMS Bulk Upload</OPTION>
        <?php }
        if(in_array("Single upload", $arrPermissibleModule)) { ?>
            <OPTION VALUE="single_upload_tc.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="single_upload_tc.php" || $pfile==""){ echo "selected"; }?>>Single Upload</OPTION>
        <?php } ?>
            <?php if($_SESSION[usrId] == 3 && $service_info == 1501){ ?>
            <OPTION VALUE="single_upload_tc.php?service_info=<?php echo $service_info;?>&user_id=<?php echo $_SESSION[usrId]?>"<?php if($pfile=="single_upload_tc.php" || $pfile==""){ echo "selected"; }?>>Single Upload</OPTION>
      <?php  } 
		  //if(in_array("Recharge Interface", $arrPermissibleModule)) { ?>
            <!-- <OPTION VALUE="rechangeInterface.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="rechangeInterface.php" || $pfile==""){ echo "selected"; }?>>SMS Bulk Upload</OPTION> -->
        <?php // } ?>
    </SELECT><br/>
	</div></td>
  </tr>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table><br/>