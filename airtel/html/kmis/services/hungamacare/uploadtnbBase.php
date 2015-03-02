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
	if($_REQUEST['service'] && $_REQUEST['mode'] && $_REQUEST['subtype'] && $_FILES['upfile']) {
		$service = $_REQUEST['service'];		
		$mode = $_REQUEST['mode'];	
		$planId = $_REQUEST['subtype'];

		$file = explode(".", $_FILES['upfile']['name']);
		$fileName = str_replace(" ","_",$file[0]).".txt";
		
		if($service == 1511) {
			$table = "airtel_rasoi.tbl_rasoi_TnB"; 
			$subTable = "airtel_rasoi.tbl_rasoi_subscription";
			$subProcd = "airtel_rasoi.RASOI_SUB_Tnb_LIVE";
		} elseif($service == 1507) { 
			$table = "airtel_vh1.tbl_JBOX_TnB";
			$subTable = "airtel_vh1.tbl_jbox_subscription";
			$subProcd = "airtel_vh1.JBOX_SUB_TnB_LIVE";
		}

		if($option == 1) $arOption = "YES";
		elseif($option == 2) $arOption = "NO";
		
		$noList = array();
		$uploaddir = "tnbBulk/".$service."/";
		
		$path = $uploaddir.$fileName;
		$logFile = "/var/www/html/kmis/services/hungamacare/tnbBulk/log/".str_replace(" ","_",$file[0])."_log_".date("Y-m-d").".txt";
		$amountData = mysql_query("SELECT iAmount FROM master_db.tbl_plan_bank WHERE Plan_id='".$planId."'");
		list($amount) = mysql_fetch_array($amountData);

		if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)){
			$file_to_read="http://10.2.73.156/kmis/services/hungamacare/tnbBulk/".$service."/".$fileName;
			$file_data=file($file_to_read);
			$file_size=sizeof($file_data);
			
			for($i=0; $i<$file_size; $i++) {
				$msisdn = trim($file_data[$i]);
				$callProcedure = "CALL ".$subProcd."('".$msisdn."','01','".$mode."','55841','".$amount."','".$service."','".$planId."','')";
				//mysql_query($callProcedure);
				$logData = $msisdn."#".$callProcedure."#".date("Y-m-d H:i:s")."\n";
				error_log($logData,3,$logFile);
			}
		} else {
			$msg = "file not upload successfully";
		}
		$msg = "Done!"; 
	} else {
		$msg = "Invalid parameter, Please try again!";
	}	
}	 

?>
<div align='right' class="in"><a href='autorenewalInterface.php'><font color='red'>Back</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><?php if(isset($msg)) { ?><FONT COLOR="#FF0000"><?php echo $msg; ?></FONT><?php } ?></TD>		
      </TR></TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
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
      <!--<TR height="30">
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Option</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='op' id="op">
				<option value="">Select Option</option>
				<option value="1">Auto Renewal</option>
				<option value="2">Non-Auto Renewal</option>
			</select>
		</TD>
      </TR>-->	  
	  <TR height="30">
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Subscription For</B></TD>
        <TD bgcolor="#FFFFFF"><div id="planData">&nbsp;&nbsp;<select name='subtype' id='subtype'>
				<option value="">Select Subscription Type</option>				
			</select></div>
		</TD>
      </TR>
      <TR height="30">
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Mode</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='mode' id="mode">
				<option value="">Select Mode</option>
				<option value="TIVR">TIVR</option>
				<option value="TOBD">TOBD</option>
				<option value="TUSSD">TUSSD</option>
			</select>
		</TD>
      </TR>	
	  <TR height="30">
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><br/>(text file must contain one 10 digit msisdn per line)</FONT></TD>
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
} else {
	header("Location:index.php");
}
?>