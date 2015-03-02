<?php
$SKIP=1;
ini_set('display_errors','0');
//require_once("incs/database.php");
require_once("incs/db.php");
$flag=0;
$_SESSION['authid']='true';
//require_once("../incs/GraphColors-D.php");
//require_once("../../ContentBI/base.php");
//asort($AR_SList);
$service_info=$_REQUEST['service_info'];

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("main-header.php");
?>
<!-- include all required CSS & JS File end here -->
<script type="text/javascript" language="javascript">
function checkfield(){
  
  var radioValue;
  radioValue=getRadioValue();

  if((document.getElementById('channel').value=="") && (document.getElementById('channel_dec').value=="")){
		alert("Please select a channel.");
		return false;
   }
   if(document.getElementById('price').value=="" && radioValue=='active'){
		alert("Please select a price point.");
		document.getElementById('price').focus();
		return false;
   }
   if(document.frm.upfile.value==""){
		alert("Please select a file to upload.");
		document.frm.upfile.focus();
		return false;
   }
   return true;
}

function showTable(radioname)
{
	if(radioname=='a')
	{
		document.getElementById('price12').style.display = 'table-row';
		document.getElementById('chanel12').style.display = 'table-row';
		document.getElementById('chanel13').style.display = 'none';
	}
	if(radioname=='d')
	{
		document.getElementById('channel').value='';
		document.getElementById('chanel12').style.display = 'none';
		document.getElementById('price12').style.display = 'none';
		document.getElementById('chanel13').style.display = 'table-row';
	}
}
function getRadioValue()
{
	for (index=0; index < document.frm.upfor.length; index++)
	{
		if (document.frm.upfor[index].checked) 
		{
			var radioValue = document.frm.upfor[index].value;
			return radioValue;
			break;
		}
	}
}
function openWindow(sid)
{
	window.open("viewhistory.php?sid="+sid,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
	</script>
	
</head>
<?php
	 if($_SERVER['REQUEST_METHOD']=="POST" && isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
		$subservice=$_POST['subservice'];
		$channel=$_POST['channel'];

		if(trim($channel)=='')
		{
			$channel=$_POST['channel_dec'];
		}
		if($subservice)
		{
			$channel=$channel."-".$subservice;
		}

		$file = $_FILES['upfile'];
		$allowedExtensions = array("txt");
		
		function isAllowedExtension($fileName) {
			global $allowedExtensions;
			return in_array(end(explode(".", $fileName)), $allowedExtensions);
		}
		if(isAllowedExtension($file['name']) && $_REQUEST['service_info'] && $_REQUEST['upfor']) {
			/*if($_REQUEST['service_info'] == '14021') $serviceId='1402';
			else $serviceId=trim($_REQUEST['service_info']);*/
			
			$serviceId=trim($_REQUEST['service_info']);
			$planId=trim($_REQUEST['price']);
			//$channel=$_REQUEST['channel'];
			$uploadedFor=trim($_REQUEST['upfor']);
			$channelDec=trim($_REQUEST['channel_dec']);
			$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
			if(!$channelDec)
				$channelDec='NA';

			$afltId=0;

			if($uploadedFor == 'active') {
				$type1= 'SUB'; 
				$selaftId="select aftId from master_db.tbl_affiliate_detail where service_id='".$serviceId."' and status=1 and event_type='".$type1."' and mode='Bulk'";
				$qryAflt = mysql_query($selaftId);
				while($aftRow = mysql_fetch_array($qryAflt)) {
					$afltId = $aftRow['aftId'];
				}
			}
			//elseif($uploadedFor == 'deactive') $type1= 'UNSUB'; 
					
			$selMaxId="select max(batch_id)+1 from master_db.bulk_upload_history";
			$qryBatch = mysql_query($selMaxId);
			list($batchId) = mysql_fetch_array($qryBatch);
			
			$selAmount="select iAmount from master_db.tbl_plan_bank where plan_id=".$planId;
			$qryAmount = mysql_query($selAmount);
			list($getAmount) = mysql_fetch_array($qryAmount);
			
			if(strtolower($uploadedFor)=='topup' && $serviceId==1402)
				$getAmount=10;
			$SafeFile = explode(".", $_FILES['upfile']['name']);
			
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$planId."_".$getAmount."_".$channel."_".$channelDec."_".$uploadedFor.".".$SafeFile[1];
		
			$errorFileName = $batchId.".txt";

			$dbMakFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$planId."_".$getAmount."_".$channel."_".$channelDec."_".$uploadedFor;
			
			$makLckFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$planId."_".$getAmount."_".$channel."_".$channelDec."_".$uploadedFor.".lck";

			$uploaddir = "bulkuploads/".$serviceId."/";
			if(!is_dir($uploaddir))
			{
				mkdir($uploaddir);
				chmod($uploaddir,0777);
			}

			$uploadlogdir = "bulkuploads/".$serviceId."/log/";
			if(!is_dir($uploadlogdir))
			{
				mkdir($uploadlogdir);
				chmod($uploadlogdir,0777);
			}
			
			$errorlogdir = "bulkuploads/".$serviceId."/error/";
			if(!is_dir($errorlogdir))
			{
				mkdir($errorlogdir);
				chmod($errorlogdir,0777);
			}

			$path = $uploaddir.$makFileName;
			$lckpath = $uploaddir.$makLckFileName;
			$errorpath = $errorlogdir.$errorFileName;
			
			if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
				$file_to_read="http://192.168.100.212/kmis/services/hungamacare/bulkuploads/".$serviceId."/".$makFileName;
				
				if($_SESSION['usrId']==219 || $_SESSION['usrId']==221){
					$selectTotalCount="select sum(total_file_count) from master_db.bulk_upload_history where added_by='".$_SESSION['loginId']."' and date(added_on)=date(now())";
					$selectCounrResult = mysql_query($selectTotalCount,$userDbConn);
					list($totalCount1)=mysql_fetch_row($selectCounrResult);
				}
				$file_data=file($file_to_read);
				$file_size=sizeof($file_data);
				$totalFileCount12=$file_size+$totalCount1;
				
				if(($_SESSION['usrId']==219 || $_SESSION['usrId']==221) && $totalFileCount12>1000) {
					$msg = "File contain more than 1000 numbers/you have reached your today limit.<br/><br/>";
				} else {
					$msg = "File uploaded successfully.<br/><br/>";
					$fp = fopen($path, "r") or die("Couldn't open $filename");
					$succCount=0;
					$failCount=0;
					$thisTime = date("Y-m-d H:i:s");
					
					$fileData1=file($path);
					$sizeOfFile=count($fileData1);
					$filetowriteFp=fopen($path,'w+');
					$errrFiletowrite=fopen($errorpath,'w+');

					$fileCount=0;
					
					if(substr($serviceId,0,2) == 10) { 
						$tableName = "tbl_mobisur_tatm_ani";
					} elseif(substr($serviceId,0,2) == 16) {
						$tableName = "tbl_mobisur_tatc_ani";
					} elseif(substr($serviceId,0,2) == 12) {
						$tableName = "tbl_mobisur_relc_ani";
					} elseif(substr($serviceId,0,2) == 14) {
						$tableName = "tbl_mobisur_unim_ani";
					}

					if($afltId) $channel = $channel."|".$afltId;

					for($k=0;$k<$sizeOfFile;$k++)
					{	
						if($channel == 'OBD-MS' || $channel == 'IVR-MS' || $channel == 'USSD-MS' || $channel == 'Net-MS') {
							$number = $fileData1[$k];
							$query = "SELECT count(*) FROM master_db.".$tableName." WHERE msisdn='".$number."'";
							$result = mysql_query($query,$userDbConn);
							list($numberChk) = mysql_fetch_row($result);
							if(trim($fileData1[$k])!='' && (strlen($fileData1[$k])==12 || strlen($fileData1[$k])==10) && $numberChk==0) {
								fwrite($filetowriteFp,trim($fileData1[$k])."#".$batchId."#".$serviceId."#".$planId."#".$getAmount."#".$channel."#". $channelDec."#".$uploadedFor."\r\n");
								$fileCount++;
							} else {				
								fwrite($errrFiletowrite,$fileData1[$k]."#".$batchId."#".$serviceId."#".$planId."#".$getAmount."#".$channel."#".$channelDec ."#". $uploadedFor."\r\n");
							}
						} else {						
							if(trim($fileData1[$k])!='' && (strlen($fileData1[$k])==12 || strlen($fileData1[$k])==10)) {
								fwrite($filetowriteFp,trim($fileData1[$k])."#".$batchId."#".$serviceId."#".$planId."#".$getAmount."#".$channel."#". $channelDec."#".$uploadedFor."\r\n");
								$fileCount++;
							} else {				
								fwrite($errrFiletowrite,$fileData1[$k]."#".$batchId."#".$serviceId."#".$planId."#".$getAmount."#".$channel."#".$channelDec ."#". $uploadedFor."\r\n");
							}
						} 
					} 
					fclose($filetowriteFp);
					fclose($errrFiletowrite);
					
					$lckFile=fopen($lckpath,'w+');
					fclose($lckFile);

					$Uploadquery="insert into master_db.bulk_upload_history(batch_id, service_type, channel, price_point, file_name, added_by, added_on, upload_for,status,operator,total_file_count,service_id,ip) values('$batchId', '$_POST[ser_type]', '$channel', '$_POST[price]', '$dbMakFileName', '$_SESSION[loginId]', '$thisTime', '$_POST[upfor]',0,'$_SESSION[dbaccess]','$fileCount','$serviceId','$remoteAdd')";
					$queryIns = mysql_query($Uploadquery, $userDbConn);

					$msg = "File <b>$makFileName<b> uploaded successfully.<br/><a href=\"javascript:void(0);\" onclick=\"openWindow($serviceId)\" class=\"blue\">View Upload History</a>";
				}
			} else {
                $msg = "File cannot be uploaded successfully.";
			}
		} else {
			$msg = "Invalid file type/Parameter. Please try again!!.";
		}	 
	} 
	?>
<body onload="javascript:getModuleList(<?= $service_info?>)">

<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">

<div class="row">
<!-- include for direct login access -->
<?php 
require_once("sessioninfo.php");
?>
<!-- include for direct login access end here -->
		 <?php
$service_info=$_REQUEST['service_info'];
switch($service_info)
{
	case '1001':
		$modarray=array('TIVR','TUSSD','TOBD','TELECALLING');
		break;
	case '1601':
		$modarray= array('TIVR','TUSSD','TOBD','TELECALLING');
	    break;
	case '1005':
		$modarray=array('TIVR','TUSSD','TOBD','TELECALLING');
		break;
	case '1605':
		$modarray= array('TIVR','TUSSD','TOBD','TELECALLING');
		break;
	case '1809':
		$modarray= array('TIVR','TUSSD','TOBD','TELECALLING');
		break;
	case '1009':
		$modarray= array('TIVR','TOBD','TELECALLING');
		break;
	case '1609':
		$modarray= array('TIVR','TELECALLING');
		break;
	case '1202':
		$modarray= array('OBD-DON','OBD1','IVR2','OBD-MS','IVR-MS','USSD-MS','Net-MS','RMW');
		break;
	case '1602':
		$modarray= array('OBD-DON','OBD-MS','IVR-MS','USSD-MS','Net-MS','TELECALLING');
		break;
	case '1402':
		$modarray= array('OBD-Jokes','OBD-MS','IVR-MS','USSD-MS','Net-MS','OBD-LBR','IVR-LBR','TELECALLING');
		break;
	case '1002':
		$modarray= array('OBD-DON','OBD-MPMC','IVR-MPMC','OBD-MS','IVR-MS','USSD-MS','Net-MS','OBD-LBR','IVR-LBR','TELECALLING');
		break;
	case '1208':
		$modarray= array('OBD1','IVR2','RMW');
		break;
	case '1010':
		$modarray= array('TIVR5','TELECALLING');
		break;
	case '1203':
		$modarray= array('OBD1','IVR2');
		break;
}
	$rest = substr($service_info,0,-2);
	if($rest==12)
		$logoPath='images/RelianceCricketMania.jpg';
	elseif($rest==14)
		$logoPath='images/uninor.jpg';
	else
		$logoPath='images/logo.png';
		
		/*	$getservice_query="select service_name from master_db.tbl_service_master where service_id = '".$service_info."'";
$get_serviceinfo = mysql_query($getservice_query,$dbConn) or die(mysql_error());

$row_service_info = mysql_fetch_array($get_serviceinfo);
*/


$serviceArray=array('TataDoCoMoMX'=>'1001','RIAUninor'=>'1409','RIATataDoCoMo'=>'1009','RIATataDoCoMocdma'=>'1609','TataIndicom54646'=>'1602','TataDoCoMo54646'=>'1002','UninorAstro'=>'1416','UninorRT'=>'1412','TataDoCoMoMXcdma'=>'1601','RIATataDoCoMovmi'=>'1809','RedFMUninor'=>'1409','Uninor54646'=>'1402','Reliance54646'=>'1202','RedFMTataDoCoMo'=>'1010','TataDoCoMoFMJ'=>'1005','REDFMTataDoCoMocdma'=>'1610','REDFMTataDoCoMovmi'=>'1810','TataDoCoMoMXvmi'=>'1801','TataDoCoMoFMJcdma'=>'1605','MTVTataDoCoMocdma'=>'1603','MTVUninor'=>'1403','RelianceCM'=>'1208','MTVReliance'=>'1203','MTVTataDoCoMo'=>'1003');
foreach ($serviceArray as $k => $v)
                                  {
								  if($v==$service_info)
                                       {
$service_main_name="select value from misdata.base where service='$k' and type='Name'";
$service_main = mysql_query($service_main_name,$dbConn_218) or die(mysql_error());
$row_service_main = mysql_fetch_array($service_main);	
                             ?>
                      
						
                      <?php }

					  } 
			?>
<div class="page-header">
  	<h1>Bulk Upload- <?php echo $row_service_main['value'];?>&nbsp;&nbsp;
			<a href="javascript:void(0);" onclick="viewUploadhistory(<?php echo $service_info;?>)" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'><B><span class="label label-info">Click here to view Upload history</span></B></FONT></a>
				</h1>
</div>
<div class="tab-pane active" id="pills-basic">
			 <div class="tab-content">
			
			<div id="BillDump" class="tab-pane active">

	<?php
		if(!isset($_POST['Submit']))
	{
?>
<TABLE width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-condensed">
      <TBODY>
      <TR height="30">
       <TD bgcolor="" COLSPAN=2><B><font color='red' size='2'>
	<?php if($_SESSION['usrId']!=219 && $_SESSION['usrId']!=221)
		echo "(File should not contains more than 20,000, otherwise file would not process)";
	?>
	</font>
	</TD>
      </TR></TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="100%" align="center" bgcolor="#0369b3" border="0" cellpadding="4" cellspacing="1" class="table table-bordered table-condensed">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Upload For</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<INPUT TYPE="radio" NAME="upfor" id="upfor" value="active" class="in" checked onClick="showTable('a');"> <span class="label label-success">Activation&nbsp;</span>
		<?php if($_SESSION['usrId']!=48 && $_SESSION['usrId']!=69 && $_SESSION['usrId']!=219 && $_SESSION['usrId']!=221 && $_SESSION['usrId']!=245 && $_SESSION['usrId']!=283){?>
			<INPUT TYPE="radio" NAME="upfor" id="upfor" value="deactive" onClick="showTable('d');"> <span class="label label-important">Deactivation&nbsp;</span>
		<?php }?>
			<?php if($_SESSION['usrId']!=219 && $_SESSION['usrId']!=221 && $_SESSION['usrId']!=245 && $_SESSION['usrId']!=249 && $_SESSION['usrId']!=267 && $_SESSION['usrId']!=273 && $_SESSION['usrId']!=283 && $_REQUEST['service_info']!='14021') { ?>
			<INPUT TYPE="radio" NAME="upfor" id="upfor" value="topup" class="in"><span class="label label-info"> TopUp </span>
			<?php }?>
		</TD>
      </TR>
	<?php

	// to Fetch the record for the service Name
	
	$get_service_name="select servicename,serviceid from master_db.tbl_app_service_master where serviceid=".$_GET['service_info'];
	$result_query=mysql_query($get_service_name,$dbConn);
	
	// end codfe to fetch the record for Sevice name

	// to Fetch the record for the service Name
		
	$plan_record=array();
	$get_plan_info="select plan_id,iamount,iValidty,disc from master_db.tbl_plan_bank where sname=".$_GET['service_info'];
	$plan_result_query=mysql_query($get_plan_info,$dbConn);
	
	// end codfe to fetch the record for Sevice name
	?>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Service Type</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<?php
			$service_record=mysql_fetch_row($result_query);
			echo "<b>".$service_record[0]."</b>";
		?>
		<input type='hidden' name='service_info' value="<?php echo $_GET['service_info'];?>">
		</TD>
      </TR>
     
	 <TR height="30" id='chanel13' style="display:none; border='1px;'" width='100%' >
     <TD bgcolor="#FFFFFF"><B>Channel</B></TD>
     <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="channel_dec" id="channel_dec" class="in">
		<option value="">--select--</option>
		<?php if($_SESSION['usrId']==117)
		{
		?>
			<option value="TIVR">TIVR</option>
			<option value="TUSSD">TUSSD</option>
			<option value="TOBD">TOBD</option>
		<?php
		}
		elseif($_SESSION['usrId']==138 || $_SESSION['usrId']==261 || $_SESSION['usrId']==283)
			echo "<option value='TC'>TELECALLING</option>";
		else {
		?>
		<option value="CC">CCI</option>
		<option value="IVR">IVR</option>
		<?php if($_GET['service_info']==1203 && $_SESSION['usrId']==47){ ?>
			<option value="USSD">USSD</option>
		<?php } ?>
		<?php if($_GET['service_info']!=1202 && $_GET['service_info']!=1208 && $_GET['service_info']!=1203){?>
		<option value="TC">TELECALLING</option>
		<option value="USSD">USSD</option>
		<option value="OBD">OBD</option>
		<option value="IBD">IBD</option>
		<option value="Netb">Net</option>
	  <?php }
		}?>
		</select>
		</TD>
      </TR>
		
	  <TR height="30" id='chanel12'>
		<TD bgcolor="#FFFFFF"><B>Channel</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="channel" id="channel" class="in">
			<option value="">--select--</option>
			<?php if($_SESSION['usrId']==117)
				{
				?>
					<option value="TIVR">TIVR</option>
					<option value="TUSSD">TUSSD</option>
					<option value="TOBD">TOBD</option>
				<?php
			    }
				elseif($_SESSION['usrId']==138 || $_SESSION['usrId']==219 || $_SESSION['usrId']==221 || $_SESSION['usrId']==245 || $_SESSION['usrId']==261 || $_SESSION['usrId']==267 || $_SESSION['usrId']==271 || $_SESSION['usrId']==273 || $_SESSION['usrId']==283)
					echo "<option value='TC'>TELECALLING</option>";
				else
				{
					?>
			<option value="TC">TELECALLING</option>
			<?php if($_SESSION['usrId']!=69 &&  $_SESSION['usrId']!=199 )
			{?> 
			<option value="USSD">USSD</option>
			<option value="OBD">OBD</option>
			<option value="CC">CCI</option>
			<option value="IVR">IVR</option>
     		<option value="IBD">IBD</option>
			<option value="netb">Net</option>
			<!--<option value="TOBD">TOBD</option>-->
			<option value="OBD-FKS">TOPUP</option>
			<!--<option value="TIVR">TIVR</option>-->			
			<?php 
			
			$t_array=array(1001,1601,1005,1605,1809);
			if(in_array($_GET['service_info'],$t_array)) {?>
			<option value="TIVR">TIVR</option>
			<option value="TUSSD">TUSSD</option>
			<option value="TOBD">TOBD</option>
			<?php
			}
			$obd_array=array(1202,1602,1002); //,1402 // remove 1402 service from OBD-DON mode
			if(in_array($_GET['service_info'],$obd_array))
			{ ?>
			<option value="OBD-DON">OBD-DON</option>
			<?php }?>
			<?php $rel_array=array(1202,1203,1208); //add IVR1 & IVR2 mode for reliance only.
			if(in_array($_GET['service_info'],$rel_array)) { ?>
				<option value="OBD1">OBD1</option>
				<option value="IVR2">IVR2</option>
			<?php } // code end here ?> 
			<?php
			$obd_array=array(1402); //1202,1602,1002,1402 // remove 1402 service from OBD-DON mode
			if(in_array($_GET['service_info'],$obd_array)) { ?>
				<option value="OBD-Jokes">OBD-Jokes</option>
			<?php }
			$tivr5_array=array(1010); //1202,1602,1002,1402 // remove 1402 service from OBD-DON mode
			if(in_array($_GET['service_info'],$tivr5_array)) { ?>
				<option value="TIVR5">TIVR5</option>
			<?php  }
			$mpmc_array=array(1002); //1202,1602,1002,1402 // remove 1402 service from OBD-DON mode
			if(in_array($_GET['service_info'],$mpmc_array)) { ?>
				<option value="OBD-MPMC">OBD-MPMC</option>
				<option value="IVR-MPMC">IVR-MPMC</option>
			<?php  }
				$ms_array=array(1602,1402,1002,1202);  
				if(in_array($_GET['service_info'],$ms_array)) {?>
					<option value="OBD-MS">OBD-MS</option>
					<option value="IVR-MS">IVR-MS</option>
					<option value="USSD-MS">USSD-MS</option>
					<option value="Net-MS">Net-MS</option>
			<?php }
				$obdlbr_array=array(1402,1002);				
				if(in_array($_GET['service_info'],$obdlbr_array)) { ?>
					<option value="OBD-LBR">OBD-LBR</option>
					<option value="IVR-LBR">IVR-LBR</option>
				<?php }
				$relcm_array=array(1208,1202);
				if(in_array($_GET['service_info'],$relcm_array)) { ?>
					<option value="RMW">RMW</option>
				<?php }
				$tat_array=array(1009,1609);
				if(in_array($_GET['service_info'],$tat_array)) { ?>
					<option value="TIVR">TIVR</option>
				<?php }
				$tat_array1=array(1009);
				if(in_array($_GET['service_info'],$tat_array)) { ?>
					<option value="TOBD">TOBD</option>
				<?php }
				
			} 
				}?>			
		</select>
		</TD>
      </TR>
	<?php 
	if($_GET['service_info']==1402){?>
	<TR height="30" id='price12'>
		<TD bgcolor="#FFFFFF"><B>Sub Service</B></TD> 
		<TD bgcolor="#FFFFFF"><B>&nbsp;<input type='radio' name='subservice' value='xm9'>9xm</B></TD>
	</TR>
<?php }
?>
<TR height="30" id='price12'>
        <TD bgcolor="#FFFFFF"><B>Price Point</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<select name="price" id='price' class="in">
			<option value=''>--select--</option>
		<?php
			if($_SESSION['usrId']==117)
				echo "<option value=14>14</option>";
		elseif($_SESSION['usrId']==219)
			echo "<option value=18>Rs 30/30 days</option>";
		elseif($_SESSION['usrId']==221) {
			if($_GET['service_info']==1605)
				echo "<option value=28>Rs 30/30 days</option>";
			elseif($_GET['service_info']==1601)
				echo "<option value=27>Rs 60/30 days</option>";

		}
		elseif($_SESSION['usrId']==245)
			echo "<option value=46>Rs 45/60 days</option>";
		elseif($_SESSION['usrId']==271) {
			echo "<option value=25>Rs 2/1 days</option>";
			echo "<option value=26>Rs 14/7 days</option>";
		} elseif($_SESSION['usrId']==273) { 
			echo "<option value=3>Rs.60/30 days</option>";
			echo "<option value=14>Rs.30/15 days</option>";
		} elseif($_SESSION['usrId']==138) {
				echo "<option value='2'>Rs.14/7 dys</option>";
				echo "<option value='3'>Rs.60/30 dys</option>";
				echo "<option value='46'>Rs.45/60 dys</option>";
				echo "<option value='45'>Rs.60/75 dys</option>";
				echo "<option value='44'>Rs.75/90 dys</option>";
		} elseif($_SESSION['usrId']==283) {
				if($_GET['service_info'] == '1001') {
					echo "<option value='1'>Rs.2/1 days</option>";
					echo "<option value='2'>Rs.14/7 days</option>";
					echo "<option value='3'>Rs.60/30 days</option>";
				} elseif($_GET['service_info'] == '1601') {
					echo "<option value='25'>Rs.2/1 days</option>";
					echo "<option value='26'>Rs.14/7 days</option>";
					echo "<option value='27'>Rs.60/30 days</option>";
				}
		} else {
				while($plan_record=mysql_fetch_array($plan_result_query)) {					
					if(($_SESSION['usrId']==261 || $_SESSION['usrId']==267) && $plan_record[0]!=38)  
						echo "<option value=".$plan_record[0].">Rs ".$plan_record[1]."/".$plan_record[2]." days</option>";
					elseif($_SESSION['usrId']==295)
						echo "<option value=".$plan_record[0].">".$plan_record[3]." Rs ".$plan_record[1]."/".$plan_record[2]." days</option>";
					elseif($_SESSION['usrId']!=261 && $_SESSION['usrId']!=267)
						echo "<option value=".$plan_record[0].">Rs ".$plan_record[1]."/".$plan_record[2]." days</option>";
				}
				if($_GET['service_info']==1402)
				{
					echo "<option value='10'>10</option>";
					echo "<option value='10'>20</option>";
				}
			}
		?>	
		</select>
		</TD>
      </TR>
	  <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><br/>(text file must contain one 10 digit msisdn per line)</br><b>(PLEASE DON'T USE SPECIAL CHARACTERS IN FILE NAME)</b></FONT></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
      </TR>
      <TR height="30">
        <td align="right" colspan="2" bgcolor="#FFFFFF">
			<!--input name="Submit" type="submit" class="btn btn-primary" value="Upload" onSubmit="return checkfield();" align="right"/-->	
			<button class="btn btn-primary" id="submit-BillDump" type="button">Submit</button>
       </td>
     </TR>
  </TBODY>
  </TABLE>
  </form>
  
  <br/><br/>
<?php }?>
  
							</div>
								
								
							  </div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div>
<div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
						<div id="grid-view_upload_history"></div> 

</div>
<!-- Footer section start here-->
  <?php
 require_once("footer.php");
  ?>
<!-- Footer section end here-->
  <script>
$('#loading').hide();
	function viewUploadhistory(a) {
		$('#loading').show();
		$('#grid-view_upload_history').hide();
		$('#grid-view_upload_history').html('');
		$.fn.GetUploadHistory(a);
	};
	
$.fn.GetUploadHistory = function(sid) {
		$.ajax({
	     
					    url: 'viewhistory.php',
					    data: 'sid='+sid,
						//data: $('#form-'+act).serialize() + '&action=del&username=<?php echo $username;?>',
						type: 'get',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid-view_upload_history').html(abc);
     						$('#loading').hide();
						}
						
					});
						
					$('#grid-view_upload_history').show();
	
};
    $(".second").pageslide({ direction: "right", modal: true });
</script>
</body>
</html>