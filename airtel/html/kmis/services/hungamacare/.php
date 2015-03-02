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
		$channel=$_POST['channel'];
		if(trim($channel)=='')
		{
			$channel=$_POST['channel_dec'];
		}
		$file = $_FILES['upfile'];
		$allowedExtensions = array("txt");
		function isAllowedExtension($fileName) {
		global $allowedExtensions;
		 return in_array(end(explode(".", $fileName)), $allowedExtensions);
		}

		if(isAllowedExtension($file['name'])) {						
			
		//print_r($_REQUEST);
		
			if(trim($_REQUEST['service_info'])==1509) {
				$serviceId = 1511;
			} elseif(trim($_REQUEST['service_info'])==15071) {
				$serviceId = 1507;
			} else {
				$serviceId=trim($_REQUEST['service_info']);
			}
			
			$planId=trim($_REQUEST['price']);
			//$channel=$_REQUEST['channel'];
			$uploadedFor=trim($_REQUEST['upfor']);
			$channelDec=trim($_REQUEST['channel_dec']);
			$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
			if(!$channelDec)
				$channelDec='NA';

			$selMaxId="select max(batch_id)+1 from airtel_hungama.bulk_upload_history";
			$qryBatch = mysql_query($selMaxId);
			list($batchId) = mysql_fetch_array($qryBatch);
			
			$selAmount="select iAmount from master_db.tbl_plan_bank where plan_id=".$planId;
			$qryAmount = mysql_query($selAmount);
			list($getAmount) = mysql_fetch_array($qryAmount);

			$SafeFile = explode(".", $_FILES['upfile']['name']);
			
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".$serviceId."_".$planId."_".$getAmount."_".$channel."_".$channelDec."_".$uploadedFor.".".$SafeFile[1];

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

			$path = $uploaddir.$makFileName;
			$lckpath = $uploaddir.$makLckFileName;

			if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)){

			$file_to_read="http://10.2.73.156/kmis/services/hungamacare/bulkuploads/".$serviceId."/".$makFileName;
			
			$file_data=file($file_to_read);
			$file_size=sizeof($file_data);
			
			$msg = "File uploaded successfully.<br/><br/>";
			$fp = fopen($path, "r") or die("Couldn't open $filename");
			$succCount=0;
			$failCount=0;
			$thisTime = date("Y-m-d H:i:s");
			
			$Uploadquery="insert into airtel_hungama.bulk_upload_history(batch_id, service_type, channel, price_point, file_name, added_by, added_on, upload_for,status,operator,total_file_count,service_id) values('$batchId', '$_POST[ser_type]', '$channel', '$_POST[price]', '$dbMakFileName', '$_SESSION[loginId]', '$thisTime', '$_POST[upfor]',0,'$_SESSION[dbaccess]','$file_size','$serviceId')";

			$queryIns = mysql_query($Uploadquery, $userDbConn);
			
			$fileData1=file($path);
			$sizeOfFile=count($fileData1);

			$filetowriteFp=fopen($path,'w+');
			for($k=0;$k<$sizeOfFile;$k++)
			{
			if(trim($fileData1[$k])!='')		fwrite($filetowriteFp,trim($fileData1[$k])."#".$batchId."#".$serviceId."#".$planId."#".$getAmount."#".$channel."#".$channelDec."#".$uploadedFor."\r\n");
			}
			fclose($filetowriteFp);
			
			$lckFile=fopen($lckpath,'w+');
			fclose($lckFile);

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
        <TD bgcolor="#FFFFFF"><a href='selectservice.php'><B><FONT COLOR="#FF0000">Home</FONT></B></a>
		||
		<B><a href="viewhistory.php" onclick=\"openWindow()\" class=\"blue\">
			<FONT COLOR="#FF0000">View Upload History</font></a></B>
		</TD>
		<TD bgcolor="#FFFFFF" COLSPAN=2><B>Bulk Upload Utility</B></TD>
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
		</TD>
      </TR>
	<?php

	// to Fetch the record for the service Name
	
	$get_service_name="select servicename,serviceid from master_db.tbl_app_service_master where serviceid=".$_GET['service_info'];
	$result_query=mysql_query($get_service_name,$dbConn);
	
	// end codfe to fetch the record for Sevice name

	// to Fetch the record for the service Name
		
	$plan_record=array();
	$get_plan_info="select plan_id,iamount from master_db.tbl_plan_bank where ";
	$get_plan_info .= " sname='".$_GET['service_info']."' ";

	//echo $get_plan_info;
	$plan_result_query=mysql_query($get_plan_info,$dbConn);
	
	// end codfe to fetch the record for Sevice name
	?>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Service Type</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<?php
			$service_record=mysql_fetch_row($result_query);
			if($service_record[0]==54646)
				$service_record[0]="Entertainment Portal 54646";
			
			if($_GET['service_info'] == 1509){
				echo "<b>Miss Riya</b>";
			} else {
				echo "<b>".$service_record[0]."</b>";
			}
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
		else
		{
		?>
		<option value="CC">CCI</option>
		<option value="IVR">IVR</option>
		<?php if($_GET['service_info']!=1502 && $_GET['service_info']!=1503){?>
		<option value="TC">TELECALLING</option>
		<option value="USSD">USSD</option>
		<option value="OBD">OBD</option>
		 <option value="IBD">IBD</option>
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
			    }else
				{
					?>
			<option value="TC">TELECALLING</option>
			<?php if($_SESSION['usrId']!=69)
			{?>
			<option value="USSD">USSD</option>
			<option value="OBD">OBD</option>
			<option value="CC">CCI</option>
			<option value="IVR">IVR</option>
			<option value="IVR1">IVR1</option>
     		<option value="IBD">IBD</option>
			<?php 
			$t_array=array(1001,1601);
			if(in_array($_GET['service_info'],$t_array)) {?>
			<option value="TIVR">TIVR</option>
			<option value="TUSSD">TUSSD</option>
			<option value="TOBD">TOBD</option>
			<?php
			}
			$obd_array=array(1202,1402,1602,1002);
			if(in_array($_GET['service_info'],$obd_array))
			{
			?>
			<option value="OBD-DON">OBD-DON</option>
			<?php
				}
			} 
				}?>
		</select>
		</TD>
      </TR>
	<TR height="30" id='price12'>
        <TD bgcolor="#FFFFFF"><B>Price Point</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<select name="price" id='price' class="in">
			<option value=''>--select--</option>
		<?php
			if($_SESSION['usrId']==117)
			{
				echo "<option value=14>14</option>";
			}else
		{
				while($plan_record=mysql_fetch_array($plan_result_query))
				echo "<option value=".$plan_record[0].">".$plan_record[1]."</option>";
		}
		?>	
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