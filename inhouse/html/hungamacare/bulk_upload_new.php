<?php
include("session.php");
error_reporting(E_ALL);
$flag=0;
$_SESSION['authid']='true';
include ("config/dbConnect.php");
$service_info=$_REQUEST['service_info'];
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Hungama Customer Care</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
<script type="text/javascript" language="javascript">
function getModuleList(serviceid)
{
var xmlhttp;    
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
document.getElementById("modulelist").style.display='inline';
document.getElementById("listmodule").innerHTML=xmlhttp.responseText;
//alert(xmlhttp.responseText);
    }
  }
xmlhttp.open("GET","listmoduleinfo.php?serviceid="+serviceid,true);
xmlhttp.send();

}
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
<body onload="javascript:getModuleList(<?= $service_info?>)">
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
	</div>
	<div id="middle">
		<div id="left-column">
		<?php include('left-sidebar.php');?>	
		</div>
		<div id="center-column">
			<div class="top-bar">
			<?php
				$service_info=$_REQUEST['service_info'];
	$rest = substr($service_info,0,-2);
	if($rest==12)
		$logoPath='images/RelianceCricketMania.jpg';
	elseif($rest==14)
		$logoPath='images/uninor.jpg';
	else
		$logoPath='images/logo.png';
		
			$getservice_query="select service_name from master_db.tbl_service_master where service_id = '".$service_info."'";
$get_serviceinfo = mysql_query($getservice_query,$dbConn) or die(mysql_error());

$row_service_info = mysql_fetch_array($get_serviceinfo);
			?>
				<h1>Bulk Upload- &nbsp;&nbsp;<?php echo $row_service_info['service_name'];?>
				<B><a href="viewhistory.php?sid=<?php echo $_GET['service_info'];?>" onclick=\"openWindow(<?php echo $_GET['service_info'];?>)\" class=\"blue\">
			<FONT COLOR="#FF0000" size="2">&nbsp;&nbsp;&nbsp;&nbsp;View Upload History</font></a></B>
				</h1>
				
				</div>
		  <div class="select-bar">
		   
			</div>
			<!--- Middle section start here -->
			 
			 		

			 <div class="table">
				<!--img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" /-->
		<!--form name="frm" method="POST" action="" onSubmit="return checkfield()">
       <table class="listing" cellpadding="0" cellspacing="0">		
		<tr class="bg">
						<td class="first"><strong>Enter Mobile No:&nbsp;&nbsp;&nbsp;</strong>
						<INPUT name="msisdn" type="text" class="in" value="<?php echo $_REQUEST['msisdn']; ?>">
		<input type='hidden' name='service_info' value=<?php echo $service_info;?>>
		<input type='hidden' name='usrId' value=<?php echo $_REQUEST['usrId'];?>>
						
						</td>
					</tr>
					<tr class="bg">
						<td class="first">
						  <input name="Submit" type="submit" class="txtbtn" value="Submit"/>			
						</td>
					</tr>
		</table>
		</form-->
		<?php
		if(!isset($_POST['Submit']))
	{
?>
<TABLE width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
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
    <TABLE width="100%" align="center" bgcolor="#0369b3" border="0" cellpadding="4" cellspacing="1" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Upload For</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<INPUT TYPE="radio" NAME="upfor" id="upfor" value="active" class="in" checked onClick="showTable('a');"> Activation 
		<?php if($_SESSION['usrId']!=48 && $_SESSION['usrId']!=69 && $_SESSION['usrId']!=219 && $_SESSION['usrId']!=221 && $_SESSION['usrId']!=245 && $_SESSION['usrId']!=283){?>
			<INPUT TYPE="radio" NAME="upfor" id="upfor" value="deactive" onClick="showTable('d');"> Deactivation
		<?php }?>
			<?php if($_SESSION['usrId']!=219 && $_SESSION['usrId']!=221 && $_SESSION['usrId']!=245 && $_SESSION['usrId']!=249 && $_SESSION['usrId']!=267 && $_SESSION['usrId']!=273 && $_SESSION['usrId']!=283 && $_REQUEST['service_info']!='14021') { ?>
			<INPUT TYPE="radio" NAME="upfor" id="upfor" value="topup" class="in"> TopUp 
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
        <td align="center" colspan="2" bgcolor="#FFFFFF">
			<!--input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/-->			
       </td>
     </TR>
  </TBODY>
  </TABLE>
  </form>
  
  <br/><br/>
<?php }?>
		
		
		
		<!--Logic will start here -->
		
<?php
	$include_cc_page=substr($service_info, 0, 2);
			if($include_cc_page=='10')
			{
			echo "Tata Docomo";
		//	include('customer_care_tatadocomo.php');
			}
			else if($include_cc_page=='12')
			{
	echo "Reliance";
	//		include('customer_care_reliance.php');
			}
			else if($include_cc_page=='14')
			{
		echo "Uninor";
		//	include('customer_care_uninor.php');
			}
            else if($include_cc_page=='16')
			{
			echo "Tata Indicom";
		//	include('customer_care_tataindicom.php');
			}
			else if($include_cc_page=='18')
			{
			echo "VMI";
			//include('customer_care_vmi.php');
			}
			else if($include_cc_page=='21')
			{
			echo "Etisalat";
 //include('customer_care_etisalat.php');
			}
			else
			{
			echo "Invalid request";
			}
			
 ?>
		<!--Logic will end here -->
				        <p>&nbsp;</p>
		  </div>
		  
		  <!--- Middle section end here -->
		  
		</div>
		<div id="right-column">
<?php include('right-sidebar.php');
//close database connection
mysql_close($con);
?>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>