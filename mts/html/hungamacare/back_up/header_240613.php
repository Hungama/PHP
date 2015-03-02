<?php
$file = $_SERVER["SCRIPT_NAME"];
$break = explode('/', $file);
$pfile = $break[count($break) - 1];
$arrPermissibleModule = array();
$get_option="select b.module_id, a.module_name from master_db.ivr_web_module_master a, master_db.ivr_web_user_module b where a.id=b.module_id and b.user_id='$_SESSION[usrId]' and b.status=1";
$query = mysql_query($get_option, $dbConn);
while(list($moduleId, $moduleName) = mysql_fetch_array($query)) {

	$arrPermissibleModule[$moduleId] = $moduleName; 
}
?>
<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td><img src="images/logo.png" alt="Hungama" align="left" border="0" hspace="0" vspace="15"><div style="margin-top: 20px; margin-right: 20px;" align="right"><b><font color="#0000cc">Welcome <?php echo ucwords(strtolower($_SESSION["usrName"])); ?> | </font><a href="javascript:void(0)" onClick="logout()"><font color="#0000cc">Logout</font></a> <br/> <?php if($_SESSION['lastLogin']!="0000-00-00 00:00:00") { ?>Last Login :: <?php echo $_SESSION['lastLogin']; } ?></b><br/><br/>
	<SELECT NAME="modules" class="in" onChange="window.open(this.options[this.selectedIndex].value,'_top')">
        <?php 
        if(in_array("Customer Care", $arrPermissibleModule)) { ?>
            <OPTION VALUE="main.php?service_info=<?=$_REQUEST['service_info'];?>" <?php if($pfile=="main.php" || $pfile==""){ echo "selected"; }?>>Customer Care</OPTION>    
        <? } if(in_array("Bulk Upload", $arrPermissibleModule)) { ?>
            <OPTION VALUE="bulk_upload.php?service_info=<?=$_REQUEST['service_info'];?>" <?php if($pfile=="bulk_upload.php" || $pfile==""){ echo "selected"; }?>>Bulk Upload</OPTION>
        <? }
		if(in_array("Activate/Deactivate", $arrPermissibleModule)) { ?>
            <OPTION VALUE="actDeactService.php?service_info=<?=$_REQUEST['service_info'];?>" <?php if($pfile=="actDeactService.php" || $pfile==""){ echo "selected"; }?>>Activate/Deactivate</OPTION>
        <? } 	
	if(in_array("bulkCrbt", $arrPermissibleModule)) { ?>
            <OPTION VALUE="uploadcrbt.php?service_info=<?=$_REQUEST['service_info'];?>" <?php if($pfile=="uploadcrbt.php" || $pfile==""){ echo "selected"; }?>>Bulk CRBT Upload</OPTION>
        <? } 
	if(in_array("SMS Bulk Upload", $arrPermissibleModule)) { ?>
            <OPTION VALUE="sms_bulk_upload.php?service_info=<?=$_REQUEST['service_info'];?>" <?php if($pfile=="sms_bulk_upload.php" || $pfile==""){ echo "selected"; }?>>SMS Bulk Upload</OPTION>
        <? }  ?>
    </SELECT><br/>
	</div></td>
  </tr>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table><br/>