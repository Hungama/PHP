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

function checkfield(){
  if(document.getElementById('service').value==""){
		alert("Please select service.");
		document.getElementById('service').focus();
		return false;
   }
   if(document.getElementById('circle').value==""){
		alert("Please select a circle.");
		document.getElementById('circle').focus();
		return false;
   }
   if(document.getElementById('op').value==""){
		alert("Please select a option.");
		document.getElementById('op').focus();
		return false;
   }
   if(document.getElementById('subtype').value==""){
		alert("Please select a subscription for.");
		document.getElementById('subtype').focus();
		return false;
   }
   return true;
}

function setPlanIdData(sid) {
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("planData").innerHTML=xmlhttp.responseText;
	    }
	}
	xmlhttp.open("GET","autoRenPlanData.php?sid="+sid,true);
	xmlhttp.send();	
}
</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php 
include("header.php");

$circle_info=array('APD'=>'Andhra Pradesh','ASM'=>'Assam','BIH'=>'Bihar','CHN'=>'Chennai','DEL'=>'Delhi','GUJ'=>'Gujarat','HAY'=>'Haryana','HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','KAR'=>'Karnataka','KER'=>'Kerala','KOL'=>'Kolkata','MAH'=>'Maharashtra','MPD'=>'Madhya Pradesh','MUM'=>'Mumbai','NES'=>'NE','ORI'=>'Orissa','PUB'=>'Punjab','PUN'=>'Punjab','RAJ'=>'Rajasthan','TNU'=>'Tamil Nadu','UPE'=>'UP East','UPW'=>'UP West','WBL'=>'West Bengal');

if($_SERVER['REQUEST_METHOD']=="POST") {
	if($_REQUEST['service'] && $_REQUEST['circle'] && $_REQUEST['op'] && $_REQUEST['subtype']) {
		$service = $_REQUEST['service'];
		$circle = $_REQUEST['circle'];
		$option = $_REQUEST['op'];	
		$subtype = $_REQUEST['subtype'];
		
		if($service == 1511) {
			$table = "airtel_rasoi.tbl_rasoi_TnB"; 
			$subTable = "airtel_rasoi.tbl_rasoi_subscription";
		} elseif($service == 1507) { 
			$table = "airtel_vh1.tbl_JBOX_TnB";
			$subTable = "airtel_vh1.tbl_jbox_subscription";
		}

		if($option == 1) $arOption = "YES";
		elseif($option == 2) $arOption = "NO";
		
		$noList = array();

		if($circle == 'PAN') {
			$renew_data = mysql_query("SELECT ani FROM ".$subTable." WHERE DATEDIFF(RENEW_DATE,SUB_DATE)<=5 and MODE_OF_SUB IN ('TIVR','TOBD','TUSSD') and status=0");
		} else {
			$renew_data = mysql_query("SELECT ani FROM ".$subTable." WHERE DATEDIFF(RENEW_DATE,SUB_DATE)<=5 and MODE_OF_SUB IN ('TIVR','TOBD','TUSSD') and status=0 AND circle='".$circle."'");
		}
		while($row = mysql_fetch_array($renew_data)) {
			$noList[] = $row['ani'];
		} 

		if($arOption == "YES") {
			if($circle == 'PAN') {
				$delQuery = "DELETE FROM master_db.tbl_tnb_autorenewal WHERE service_id='".$service."'";
				mysql_query($delQuery);
				
				foreach($circle_info as $cir=>$value) {
					if($cir != 'PAN') {
						$query = "insert into master_db.tbl_tnb_autorenewal (service_id,renewal_status,sub_for,circle,date_time) values ('".$service."', '".$arOption."', '".$subtype."', '".$cir."', now())";
						mysql_query($query);
					}
				}
								
				if(is_array($noList)) {					 
					$update_data1 = "UPDATE ".$subTable." SET SUB_TYPE='NA' WHERE MODE_OF_SUB IN ('TIVR','TOBD','TUSSD') AND ANI NOT IN  ('".implode("','",$noList)."')";
					mysql_query($update_data1);
					$update_data = "UPDATE ".$subTable." SET plan_id='".$subtype."' WHERE MODE_OF_SUB IN ('TIVR','TOBD','TUSSD') AND ANI IN  ('".implode("','",$noList)."')";
					mysql_query($update_data);
				}
			} else {
				$query1 = "SELECT count(*) FROM master_db.tbl_tnb_autorenewal WHERE service_id='".$service."' and circle='".$circle."' and renewal_status='".$arOption."'";
				$chkQuery = mysql_query($query1);
				list($chkStatus) = mysql_fetch_row($chkQuery);

				if(!$chkStatus) {
					$query = "insert into master_db.tbl_tnb_autorenewal (service_id,renewal_status,sub_for,circle,date_time) values ('".$service."', '".$arOption."', '".$subtype."', '".$circle."', now())";
					mysql_query($query);
				} else {
					$query = "UPDATE master_db.tbl_tnb_autorenewal SET sub_for='".$subtype."', date_time=now() WHERE service_id='".$service."' and circle='".$circle."' ";
					mysql_query($query);
				}
		
				if(is_array($noList)) {
					$update_data1 = "UPDATE ".$subTable." SET SUB_TYPE='NA' WHERE MODE_OF_SUB IN ('TIVR','TOBD','TUSSD') AND ANI NOT IN  ('".implode("','",$noList)."') and circle != '".$circle."'";	
					mysql_query($update_data1);
					$update_data = "UPDATE ".$subTable." SET plan_id='".$subtype."' WHERE MODE_OF_SUB IN ('TIVR','TOBD','TUSSD') AND ANI IN  ('".implode("','",$noList)."')";
					mysql_query($update_data);
				}
			}			
		} elseif($arOption == "NO") {
			if($circle == 'PAN') {
				$delQuery = "DELETE FROM master_db.tbl_tnb_autorenewal WHERE service_id='".$service."'";				
			
				$update_data = "UPDATE ".$subTable." SET SUB_TYPE='NA' WHERE MODE_OF_SUB IN ('TIVR','TOBD','TUSSD') and ANI IN ('".implode("','",$noList)."')";
			} else {
				$delQuery = "DELETE FROM master_db.tbl_tnb_autorenewal WHERE service_id='".$service."' and circle='".$circle."'";				
							
				$update_data = "UPDATE ".$subTable." SET SUB_TYPE='NA' WHERE MODE_OF_SUB IN ('TIVR','TOBD','TUSSD') AND ANI IN ('".implode("','",$noList)."') AND circle='".$circle."'";
			}			
			mysql_query($delQuery);

			if(is_array($noList)) mysql_query($update_data);
		}
		$msg = "Done!"; 
	} else {
		$msg = "Invalid parameter, Please try again!";
	}	
}	 

?>
<div align='right' class="in"><a href='uploadtnbBase.php'><font color='red'>Upload Base</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><?php if(isset($msg)) { ?><FONT COLOR="#FF0000"><?php echo $msg; ?></FONT><?php } ?></TD>		
      </TR></TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Service</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='service' id='service' onchange="setPlanIdData(this.value)">
				<option value="">Select Service</option>
				<option value="1511">Airtel GoodLife</option>
				<option value="1507">Airtel VH1</option>
			</select>
		</TD>
      </TR>
	  <TR height="30">
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Circle</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="circle" id="circle">
				<option value=''>Select Circle</option>
				<option value='PAN'>All</option>
				<?php foreach($circle_info as $key=>$value) { ?>
					<option value='<?php echo $key ?>'><?php echo $circle_info[$key]  ?></option>
				<?php }?>
			</select>
		</TD>
      </TR>     	
      <TR height="30">
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Option</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='op' id="op">
				<option value="">Select Option</option>
				<option value="1">Auto Renewal</option>
				<option value="2">Non-Auto Renewal</option>
			</select>
		</TD>
      </TR>     
	  <TR height="30">
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Subscription For</B></TD>
        <TD bgcolor="#FFFFFF"><div id="planData">&nbsp;&nbsp;<select name='subtype' id='subtype'>
				<option value="">Select Subscription Type</option>				
			</select></div>
		</TD>
      </TR>
      <TR height="30">
        <td align="center" colspan="2" bgcolor="#FFFFFF">
			<input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/>			
       </td>
     </TR> 
  </TBODY>
  </TABLE>
  </form>
  
<br/><br/><br/><br/><br/><br/><br/><br/>
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