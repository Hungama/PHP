<?php
$file = $_SERVER["SCRIPT_NAME"];
$break = explode('/', $file);
session_start();

$pfile = $break[count($break) - 1];
$serviceType=$_REQUEST['serviceType'];
$service_info=$_REQUEST['service_info'];
$serviceType=$_REQUEST['serviceType'];
$usrId=$_REQUEST['usrId'];
$usrId=$_SESSION['usrId'];

	if($serviceType=='TI' && $service_info=='1001')
	{
		$service_info=1601;
	}
	elseif($serviceType=='TI' && $service_info=='1002')
	{
		$service_info=1602;
	}
	elseif($serviceType=='TI' && $service_info=='1003')
	{
		$service_info=1603;
	}
	elseif($serviceType=='TI' && $service_info=='1005')
	{
		$service_info=1605;
	}
	elseif($serviceType=='TI' && $service_info=='1009')
	{
		$service_info=1609;
	}
	elseif($serviceType=='VMI' && $service_info=='1001')
	{
		$service_info=1801;
	}
	elseif($serviceType=='TI' && $service_info=='1010')
	{
		$service_info=1610;
	}
	elseif($serviceType=='VMI' && $service_info=='1009')
	{
		$service_info=1809;
	}
	elseif($serviceType=='VMI' && $service_info=='1007')
	{
		$service_info=1807;
	}
	elseif($serviceType=='TI' && $service_info=='1007')
	{
		$service_info=1607;
	}
	elseif($serviceType=='TI' && $service_info=='1007')
	{
		$service_info=1607;
	}
	elseif($serviceType=='VMI' && $service_info=='1010')
	{
		$service_info=1810;
	}
	elseif($serviceType=='TI' && $service_info=='1011')
	{
		$service_info=1611;
	}
	elseif($serviceType=='VMI' && $service_info=='1011')
	{
		$service_info=1811;
	}

//echo "<pre>";print_r($_REQUEST);
$arrPermissibleModule = array();
$get_option="select b.module_id,a.module_name from master_db.ivr_web_module_master a, master_db.ivr_web_user_module b where a.id=b.module_id and b.user_id='$usrId' and b.status=1";
$query = mysql_query($get_option, $dbConn);
while(list($moduleId, $moduleName) = mysql_fetch_array($query)) {
    $arrPermissibleModule[$moduleId] = $moduleName; 
}

?>
<head><title>Hungama Care</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<script language="javascript">
function logout()
{
window.parent.location.href ='index.php?logerr=logout';
}
</script>
<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td><img src="images/logo.png" alt="Hungama" align="left" border="0" hspace="0" vspace="15"><div style="margin-top: 20px; margin-right: 20px;" align="right"><b><font color="#0000cc">Welcome <?php echo ucwords(strtolower($_SESSION["usrName"])); ?> | </font><a href="javascript:void(0)" onClick="logout()"><font color="#0000cc">Logout</font></a> <br/> <?php if($_SESSION['lastLogin']!="0000-00-00 00:00:00") { ?>Last Login :: <?php echo $_SESSION['lastLogin']; } ?></b><br/><br/>
	<SELECT NAME="modules" class="in" onChange="window.open(this.options[this.selectedIndex].value,'_top')">
		<!-- <OPTION value="">Select Option</OPTION> -->
        <?php 
        if(in_array("Customer Care", $arrPermissibleModule)) { ?>
            <OPTION VALUE="main.php?service_info=<?php echo $service_info;?>&serviceType=<?php echo $serviceType;?>" <?php if($pfile=="main.php" || $pfile==""){ echo "selected"; }?>>Customer Care</OPTION>    
        <?php } 
			if(in_array("Bulk Upload", $arrPermissibleModule)) { 
				if($service_info == 1412) { ?>
					<OPTION VALUE="uploadRingtone.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="uploadRingtone.php" || $pfile==""){ echo "selected"; }?>>Bulk Upload</OPTION>
				<?php } else { ?>
				    <OPTION VALUE="bulk_upload.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="bulk_upload.php" || $pfile==""){ echo "selected"; }?>>Bulk Upload</OPTION>
				<?php } ?>
        <?php }
	if(in_array("FRC Admin", $arrPermissibleModule)) { ?>
            <OPTION VALUE="frcAdmin.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="frcAdmin.php" || $pfile==""){ echo "selected"; }?>>FRC Admin</OPTION>
        <?php }
	if(in_array("Upload 10 Min Base", $arrPermissibleModule)) { ?>
            <OPTION VALUE="uploadtenminbase.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="uploadtenminbase.php" || $pfile==""){ echo "selected"; }?>>Upload 10 Min Base</OPTION>
        <?php
}
	if(in_array("Single Upload", $arrPermissibleModule)) { ?>
            <OPTION VALUE="single_upload.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="single_upload.php" || $pfile==""){ echo "selected"; }?>>Single Upload</OPTION>
        <?php
}
			if(in_array("Single Upload Docomo", $arrPermissibleModule)) { ?>
            <OPTION VALUE="single_upload_docomo.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="single_upload_docomo.php" || $pfile==""){ echo "selected"; }?>>Single Upload Docomo</OPTION>
        <?php
}
	if(in_array("Try-n-Buy Uninor Upload", $arrPermissibleModule)) { ?>
            <OPTION VALUE="trynbuy_upload.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="trynbuy_upload.php" || $pfile==""){ echo "selected"; }?>>Try-n-Buy Uninor Upload</OPTION>
        <?php
}	

	if(in_array("SMS Bulk Upload", $arrPermissibleModule)) { ?>
            <OPTION VALUE="sms_bulk_upload.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="sms_bulk_upload.php" || $pfile==""){ echo "selected"; }?>>SMS Bulk Upload</OPTION>
        <?php
	} 
	if(in_array("IVR Reliance Wap Store", $arrPermissibleModule)) { ?>
		<OPTION VALUE="relianceInterface.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="relianceInterface.php" || $pfile==""){ echo "selected"; }?>>IVR Reliance Wap Store</OPTION>
	<?php
	}
	if(in_array("FollowUp Upload", $arrPermissibleModule)) { ?>
		<OPTION VALUE="followup_upload.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="followup_upload.php" || $pfile==""){ echo "selected"; }?>>Follow-Up Upload</OPTION>
	<?php
	}
	if(in_array("Event Bulk Upload", $arrPermissibleModule)) { ?>
		<OPTION VALUE="event_bulk_upload.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="event_bulk_upload.php" || $pfile==""){ echo "selected"; }?>>Event Bulk Upload</OPTION>
	<?php
	}
	if(in_array("Single Number Upload", $arrPermissibleModule)) { ?>
		<OPTION VALUE="single_number_upload.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="single_number_upload.php" || $pfile==""){ echo "selected"; }?>>Single Number Upload</OPTION>
	<?php
	} 
	if(in_array("Celebrity Deactivation", $arrPermissibleModule)) { ?>
		<OPTION VALUE="celebrityDeactivation.php?service_info=<?php echo $service_info;?>" <?php if($pfile=="celebrityDeactivation.php" || $pfile==""){ echo "selected"; }?>>Celebrity Deactivation</OPTION>
	<?php
	} 
 ?>
    </SELECT><br/>
	</div></td>
  </tr>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table><br/>
