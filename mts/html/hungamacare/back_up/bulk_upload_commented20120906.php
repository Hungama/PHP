<?php
session_start();
if(isset($_SESSION['authid']))
{
	include("config/dbConnect.php");
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
<!--
.style3 {font-family: "Times New Roman", Times, serif}
-->
</style>
<script language="javascript">
function logout()
{
	window.parent.location.href = 'index.php?logerr=logout';
}
</script>
<script language="javascript">

 function checkfield(){
  
  var radioValue;
  radioValue=getRadioValue();

  if((document.getElementById('channel').value=="") && (document.getElementById('channel_dec').value=="") && (document.getElementById('channeltop123').value=="")){
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
		document.getElementById('chaneltopup').style.display = 'none';
		document.getElementById('pricetopup').style.display = 'none';
	}
	if(radioname=='d')
	{
		document.getElementById('channel').value='';
		document.getElementById('chanel12').style.display = 'none';
		document.getElementById('price12').style.display = 'none';
		document.getElementById('chaneltopup').style.display = 'none';
		document.getElementById('chanel13').style.display = 'table-row';
		document.getElementById('pricetopup').style.display = 'none';
	}
	if(radioname=='t')
	{
		document.getElementById('channel').value='';
		document.getElementById('chanel12').style.display = 'none';
		document.getElementById('price12').style.display = 'none';
		document.getElementById('chanel13').style.display = 'none';
		document.getElementById('chaneltopup').style.display = 'table-row';
		document.getElementById('pricetopup').style.display = 'table-row';
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
function openWindow()
{
	window.open("viewhistory.php","mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
}
</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php 
	include("header.php");
	 if($_SERVER['REQUEST_METHOD']=="POST" && isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) 
	{
		//echo "<pre>";		 print_r($_REQUEST);		 exit;
		$channel=$_POST['channel'];
		$price=$_POST['price'];
		if(trim($channel)=='')
			$channel=$_POST['channel_dec'];
		if(trim($_REQUEST['upfor'])=='topup')
		{
			$channel=$_POST['channeltop123'];
			$price=$_POST['pricetop123'];
		}
		
		$file = $_FILES['upfile'];
		$allowedExtensions = array("txt");
		function isAllowedExtension($fileName) {
		  global $allowedExtensions;
		  return in_array(end(explode(".", $fileName)), $allowedExtensions);
		}

		if(isAllowedExtension($file['name'])) {

			mysql_select_db($$userDbName, $userDbConn);
			
			$qryBatch = mysql_query("select max(batch_id) from billing_intermediate_db.bulk_upload_history", $userDbConn);
			list($batchId) = mysql_fetch_array($qryBatch);
			if($batchId)
				$batchId = $batchId + 1;
			else
				$batchId = 1;

			$SafeFile = explode(".", $_FILES['upfile']['name']);
			//echo "<pre>";print_r($SafeFile);exit;
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".date("YmdHis").".".$SafeFile[1];
			//$uploaddir = "bulkuploads/";
			$uploaddir = "bulkuploads/".$_REQUEST['service_info']."/";
			$path = $uploaddir.$makFileName;
			if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)){
				
			//$file_to_read="http://119.82.69.212/kmis/services/hungamacare/bulkuploads/".$makFileName;
			$file_to_read="http://10.130.14.107/hungamacare/bulkuploads/".$_POST['service_info']."/".$makFileName;
		
			$file_data=file($file_to_read);
			$file_size=sizeof($file_data);


                $msg = "File uploaded successfully.<br/><br/>";
				$fp = fopen($path, "r") or die("Couldn't open $filename");
				$succCount=0;
				$failCount=0;
				$thisTime = date("Y-m-d H:i:s");
			
				$Uploadquery="insert into billing_intermediate_db.bulk_upload_history(batch_id, service_type, channel, price_point, file_name, added_by, added_on, upload_for,status,operator,total_file_count,service_id) values('$batchId', '$_POST[ser_type]', '$channel', '$price', '$makFileName', '$_SESSION[loginId]', '$thisTime', '$_POST[upfor]',0,'$_SESSION[dbaccess]','$file_size','$_POST[service_info]')";
				$queryIns = mysql_query($Uploadquery, $userDbConn);
				$msg = "File <b>$makFileName<b> uploaded successfully.<br/><a href=\"javascript:void(0);\" onclick=\"openWindow()\" class=\"blue\">View Upload History</a>";
			} else {
                $msg = "File cannot be uploaded successfully.";
			}
		} else {
			$msg = "Invalid file type. Please upload text file only.";
		}
	}
if(!isset($_POST['Submit']))
	{
?>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B><FONT COLOR="#FF0000">Bulk Upload Utility</FONT></B></TD>
		<TD bgcolor="#FFFFFF" COLSPAN=2><B><FONT COLOR="#FF0000"><a href="viewhistory.php" onclick=\"openWindow()\" class=\"blue\">View Upload History</a></TD>
      </TR></TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Upload For</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<INPUT TYPE="radio" NAME="upfor" id="upfor" value="active" class="in" checked onClick="showTable('a');"> Activation 
		<?php if($_SESSION['usrId']!=48 && $_SESSION['usrId']!=69){?>
			<INPUT TYPE="radio" NAME="upfor" id="upfor" value="deactive" onClick="showTable('d');"> Deactivation
		<?php }?>
		<?php if($_SESSION['usrId']==39 ){?>
			<INPUT TYPE="radio" NAME="upfor" id="upfor" value="topup" onClick="showTable('t');"> Top up
		<?php }?>
		<!--<INPUT TYPE="radio" NAME="upfor" id="upfor" value="renewal" class="in" onClick="showTable('a');"> Renewal -->
		</TD>
      </TR>
	<?php

	// to Fetch the record for the service Name
	
	$get_service_name="select servicename,serviceid from master_db.tbl_app_service_master where serviceid=".$_GET['service_info'];
	$result_query=mysql_query($get_service_name,$dbConn);
	
	// end codfe to fetch the record for Sevice name

	// to Fetch the record for the service Name
		
	$plan_record=array();
	$get_plan_info="select plan_id,iamount,ivalidty from master_db.tbl_plan_bank where s_id=".$_GET['service_info'];
	if($_GET['service_info'] == 1105) { 
		$get_plan_info .=" and iTalkMin != 0";
	}
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
     <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
	 <select name="channel_dec" id="channel_dec" class="in">
		<option value="">--select--</option>
		<option value="CC">CCI</option>
		<option value="IVR">IVR</option>
		<option value="TC">TELECALLING</option>
		<option value="USSD">USSD</option>
		<option value="OBD">OBD</option>
		<option value="IBD">IBD</option>
		<option value="push">Push</option>
	</select>
		</TD>
      </TR>
	  <?php $service_array=array(1101,1102,1111,1106);
		$service_array1=array(1101,1102,1111,1106,1110);
	?>
	  <TR height="30" id='chanel12'>
		<TD bgcolor="#FFFFFF"><B>Channel</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="channel" id="channel" class="in">
			<option value="">--select--</option>
			<option value="TC">TELECALLING</option>
			<option value="USSD">USSD</option>
			<option value="OBD">OBD</option>
			<?php if($_GET['service_info'] != 1101) {?><option value="CC">CCI</option> <?php } ?>
			<option value="IVR">IVR</option>
     		<option value="IBD">IBD</option>
			<?php	if(in_array($_REQUEST['service_info'],$service_array1)) { ?>
				<option value="push">Push</option>
			<?php } ?>
		    <?php	if(in_array($_REQUEST['service_info'],$service_array)) { ?>
				<option value="TRCV">TRCV</option>				
		    <?php } ?>			
		</select>
		</TD>
      </TR>

	<TR height="30" id='chaneltopup' style="display:none">
		<TD bgcolor="#FFFFFF"><B>Channel</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="channeltop123" id="channeltop123" class="in">
			<option value="">--select--</option>
			<option value="OBD-MS">Mobisur</option>
			
		</select>
		</TD>
    </TR>
	<TR height="30" id='pricetopup' style="display:none">
		<TD bgcolor="#FFFFFF"><B>Price</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="pricetop123" id="pricetop123" class="in">
			<option value="">--select--</option>
			<option value="10">10</option>
			
		</select>
		</TD>
    </TR>

	<TR height="30" id='price12'>
        <TD bgcolor="#FFFFFF"><B>Price Point</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<select name="price" id='price' class="in">
			<option value=''>--select--</option>
		<?php
			
				while($plan_record=mysql_fetch_array($plan_result_query))
				{
					if($plan_record[0]==11 || $plan_record[0]==12 || $plan_record[0]==13 || $plan_record[0]==19)
						$Validity=' ticket';
					else
						$Validity=" / ".$plan_record[2] ." days";
					echo "<option value=".$plan_record[0]."> Rs ".$plan_record[1]. $Validity." </option>";
				}
		?>	
			 <?php if($_REQUEST['service_info']==1101) {?>
			<option value="4">0</option>
		  <?php } ?>

		</select>
		</TD>
      </TR>
	  <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><br/>(text file must contain one 10 digit msisdn per line)</FONT></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
      </TR>
      <TR height="30">
        <td align="center" colspan="2" bgcolor="#FFFFFF">
			<input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/>			
       </td>
     </TR>
  </TBODY>
  </TABLE>
  </form>
  
  <br/><br/>
<?php }?>
<?php echo "<div align='center' class='txt'><B>".$msg."</B></div>"; ?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
  <tr> 
    <td class="footer" align="right" bgcolor="#ffffff"><b>Powered by Hungama</b></td>
  </tr><tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table>
</body>
</html>
<?php
	mysql_close($dbConn);
}
else
{
	header("Location:index.php");
}
?>
