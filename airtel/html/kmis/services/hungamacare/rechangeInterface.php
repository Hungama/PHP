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

function checkfield() { 
	if(document.frm.time.value  == "") {
		alert("Please Select Time.");
		document.frm.time.focus();
		return false;
	}
	if(document.frm.service.value  == "") {
		alert("Please Select Service.");
		document.frm.service.focus();
		return false;
	}
	return true;
}

</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php   $logoPath='images/logo.png';
        
		include("header.php");		

		if($_SERVER['REQUEST_METHOD']=="POST" && $_REQUEST['service']) {
			$fileName="/var/www/html/kmis/mis/log/dailyMIS_log_".date("Ymd").".txt";
			$service = $_REQUEST['service'];
			$date = $_REQUEST['date'];
			if($service == 'reliance') {
				//header("location:http://192.168.100.212/kmis/mis/insertDailyReportReliance.php?date=".$date);
				$url_response=file_get_contents("http://192.168.100.212/kmis/mis/insertDailyReportReliance.php?date=".$date); 
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$logdata=$_SERVER['REMOTE_ADDR']."#RELIANCE#Create:".$date."#Generate:".date('Y-m-d H:i:s');
			} else if($service == 'docomo') {
				$url_response=file_get_contents("http://192.168.100.212/kmis/mis/insert_daily_report.php?date=".$date);
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$logdata=$_SERVER['REMOTE_ADDR']."#DOCOMO#Create:".$date."#Generate:".date('Y-m-d H:i:s');
			} else if($service == 'indicom') {
				//header("location:http://192.168.100.212/kmis/mis/insertDailyReportTataCdma.php?date=".$date);
				$url_response=file_get_contents("http://192.168.100.212/kmis/mis/insertDailyReportIndicom.php?date=".$date);
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$msg=1;
				$logdata=$_SERVER['REMOTE_ADDR']."#TATA INDICOM#Create:".$date."#Generate:".date('Y-m-d H:i:s');
			} else if($service == 'uninor') {
				$url_response=file_get_contents("http://192.168.100.212/kmis/mis/insertDailyReportUninor.php?date=".$date);
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$logdata=$_SERVER['REMOTE_ADDR']."#UNINOR#Create:".$date."#Generate:".date('Y-m-d H:i:s');
			} else if($service == 'virgin') {
				$url_response=file_get_contents("http://192.168.100.212/kmis/mis/insertDailyReportVirm.php?date=".$date);				
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$logdata=$_SERVER['REMOTE_ADDR']."#VIRGIN#Create:".$date."#Generate:".date('Y-m-d H:i:s');
			} elseif($service == 'mts') {	
				$mtsUrl="http://10.130.14.107/hungamacare/insertDailyReport.php?date=".$date;
				$url_response=file_get_contents($mtsUrl);				
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$logdata=$_SERVER['REMOTE_ADDR']."#MTS#".$mtsUrl."#Create:".$date."#Generate:".date('Y-m-d H:i:s');			
			}  elseif($service == 'airtel') {			
				$airtelUrl="http://10.2.73.156/kmis/services/hungamacare/insert_daily_report.php?date=".$date;
				$url_response=file_get_contents($airtelUrl);				
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$logdata=$_SERVER['REMOTE_ADDR']."#AIRTEL#".$airtelUrl."#Create:".$date."#Generate:".date('Y-m-d H:i:s');			
			} elseif($service == 'vodafone') {	
				$vodafoneUrl="http://203.199.126.129/hungamacare/insertDailyReportVoda.php?date=".$date;
				$url_response=file_get_contents($vodafoneUrl);				
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$logdata=$_SERVER['REMOTE_ADDR']."#VODAFONE#".$vodafoneUrl."#Create:".$date."#Generate:".date('Y-m-d H:i:s');			
			} elseif($service == 'digi') {	
				$digiUrl="http://172.16.56.42/MIS/insertDailyReportDigi.php?date=".$date;
				$url_response=file_get_contents($digiUrl);				
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$logdata=$_SERVER['REMOTE_ADDR']."#DIGI#".$digiUrl."#Create:".$date."#Generate:".date('Y-m-d H:i:s');			
			} elseif($service == 'mahxuv') {	
				$mahUrl="http://192.168.100.212/kmis/mis/mahindraMIS.php?date=".$date;
				$url_response=file_get_contents($mahUrl);				
				if($url_response == "done") { $msg=1;} 
				else { $msg=2; }
				$logdata=$_SERVER['REMOTE_ADDR']."#MXUV500#".$mahUrl."#Create:".$date."#Generate:".date('Y-m-d H:i:s');			
			}
			error_log($logdata."\n",3,$fileName);
		}
?>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <?php  if($msg==1 && $service) { ?>
        <TR height="30" width="100%">
			<TD colspan="4" bgcolor="#FFFFFF" align="center">
				<?php echo ucwords($service)." Daily MIS created successfully."; ?>
			</TD>
        </TR>
      <?php } else if($msg==2 && $service){ ?>
		<TR height="30" width="100%">
			<TD colspan="4" bgcolor="#FFFFFF" align="center">
				<?php echo ucwords($service)." Daily MIS Created Successfully."; ?>
			</TD>
        </TR>
	  <?php }  ?>
      </TBODY>
</TABLE>
<div align='center' style="font-size:17px;" class='txt'><b>Recharge Interface</b><br/></div><br/>
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="25%" align="center"  bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" style="font-size:15px;" class='txt'>
      <TBODY>		  
		  <TR>
			<td bgcolor="#ffffff" align='center'><b>Date</b></td>
			<td bgcolor="#ffffff" align='center'>
				<select name='date'>
					<option value="">Select Date</option>
					<?php for($i=7; $i>=1; $i--) { 
						$date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-$i,date("Y")));
						$view_date1= date("d-M-Y",mktime(0,0,0,date("m"),date("d")-$i,date("Y"))); ?>
						<option value="<?php echo $date1;?>" <?php if($date == $date1) echo "SELECTED";?>><?php echo $view_date1;?></option>
					<?php }?>
				</select>
			</td>
		  </TR>
		  <TR>
			<td bgcolor="#ffffff" align='center'><b>Mobile Number(s)</b> [please enter mobile number with comma(,) seperated]</td>
			<td bgcolor="#ffffff" align='center' valign="top"><TEXTAREA NAME="mnumber" ROWS="4" COLS="30"></TEXTAREA></td>
		  </TR>
		  <TR>
			<TD colspan="2" align='center' bgcolor="#ffffff">
				<input name="Submit" type="submit" class="txtbtn" value="Submit" onSubmit="return checkfield();">
			</TD>
		  </TR>
      </TBODY>
    </TABLE>
</form>
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