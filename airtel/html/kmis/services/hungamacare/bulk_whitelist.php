<?php
session_start();
//if(isset($_SESSION['authid']))
if(1)
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
function showdiv(a)
{
if((a=="1")){
		document.getElementById('showcircle').style.display='table-row';
		  }
   else
   {
   document.getElementById('showcircle').style.display='none';
   }
}
 function checkfield(){
  
  if((document.getElementById('whitelist').value=="")){
		alert("Please select a whitelist.");
		document.getElementById('whitelist').focus();
		return false;
   }
   else if((document.getElementById('service_info').value=="")){
		alert("Please select a service.");
		document.getElementById('service_info').focus();
		return false;
   }
 /* else if(document.getElementById('circle_dec').value==""){
		alert("Please select a circle.");
		document.getElementById('circle_dec').focus();
		return false;
   }
*/
   else if(document.frm.upfile.value==""){
		alert("Please select a file to upload.");
		document.frm.upfile.focus();
		return false;
   }
   return true;
}

</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td><img src="images/logo.png" alt="Hungama" align="left" border="0" hspace="0" vspace="15"><div style="margin-top: 20px; margin-right: 20px;" align="right"><b><font color="#0000cc">Welcome <?php echo ucwords(strtolower($_SESSION["usrName"])); ?> | </font><a href="javascript:void(0)" onClick="logout()"><font color="#0000cc">Logout</font></a> <br/> <?php if($_SESSION['lastLogin']!="0000-00-00 00:00:00") { ?>Last Login :: <?php echo $_SESSION['lastLogin']; } ?></b><br/><br/>
	</div></td>
  </tr>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table><br/>
<?php 

	//include("header.php");
	 if($_SERVER['REQUEST_METHOD']=="POST" && isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) 
	{
		$serviceid=$_POST['service_info'];
		$circle_dec=$_POST['circle_dec'];
		$whitelist=$_POST['whitelist'];
		
		$file = $_FILES['upfile'];
		$allowedExtensions = array("txt");
		function isAllowedExtension($fileName) {
		global $allowedExtensions;
		 return in_array(end(explode(".", $fileName)), $allowedExtensions);
		}

		if(isAllowedExtension($file['name'])) {						
			$remoteAdd=trim($_SERVER['REMOTE_ADDR']);

		$SafeFile = explode(".", $_FILES['upfile']['name']);
			$curdate = date("Y_m_d-H_i_s");
			if($whitelist==2)
			{
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$serviceid."_whitelist_".$curdate.".".$SafeFile[1];
			}
			else
			{
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$circle_dec."_".$serviceid."_whitelist_".$curdate.".".$SafeFile[1];
			}
			$uploaddir = "bulkuploads/whitelist/";
			if(!is_dir($uploaddir))
			{
				mkdir($uploaddir);
				chmod($uploaddir,0777);
			}
			echo $path = $uploaddir.$makFileName;

			//check for valid file content start here 
$lines = file($_FILES['upfile']['tmp_name']);
$isok;
$count=0;
foreach ($lines as $line_num => $mobno) 
{
echo $mno=trim($mobno);
if(!empty($mno))
{
if(is_numeric($mno) && strlen($mno)==10) {
$isok=1;
$count++;
if($whitelist==2)
			{
 echo $mnd_whitelist=$mno."#".$serviceid."\r\n";;
 }
 else
 {
 echo $mnd_whitelist=$mno."#".$serviceid. "#".$circle_dec."\r\n";;
 }
	error_log($mnd_whitelist,3,$path);
	
    } else {
$isok=2;
break;
  }
}
  }
if($isok==2)
{
echo "There seem to be error in the contents of the file. Please check the file you selected for upload"; ?>
<?php
exit;
}
else if($count>50000)
{
echo "Please upload file of less than 20,000 numbers otherwise it will not process.";
exit;
}
$file_to_read="http://10.2.73.156/kmis/services/hungamacare/bulkuploads/whitelist"."/".$makFileName;
$file_data=file($file_to_read);
			$file_size=sizeof($file_data);
			
			
			if($file_size<50000){

$loadfilepath="/var/www/html/kmis/services/hungamacare/bulkuploads/whitelist"."/".$makFileName;

if($whitelist==2)
			{
$insertDump= 'LOAD DATA LOCAL INFILE "'.$loadfilepath.'"
INTO TABLE airtel_mnd.tbl_ussdMND_whitelist
FIELDS TERMINATED BY "#"
LINES TERMINATED BY "\n"
(ANI,serviceId)';
}
else
{
$insertDump= 'LOAD DATA LOCAL INFILE "'.$loadfilepath.'"
INTO TABLE master_db.tbl_refer_ussdMDN
FIELDS TERMINATED BY "#"
LINES TERMINATED BY "\n"
(ANI,service_id,circle)';
}
//echo $insertDump;

if(mysql_query($insertDump,$dbConn))
{
$msg = "File uploaded successfully.<br/><br/>";
}
else
{
$msg=mysql_error();
}
			
			echo "<a href='bulk_whitelist.php'><B><FONT COLOR='#FF0000'>Home</FONT></B></a>";
fclose($file_to_read);
				} else {
                $msg = "There seem to be error in the contents of the file. Please check the file you selected for upload.";
			}
		} else {
			$msg = "Please check the filename of the selected file. There seems to be some naming issue. Only upload Filename.txt files";
		}
	}
if(!isset($_POST['Submit']))
	{
?>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF">
			<a href='#'><B><FONT COLOR="#FF0000">Home</FONT></B></a>
		</TD>
		<TD bgcolor="#FFFFFF" COLSPAN=2 style="text-align:center"><B>MDN WhiteList Utility</B></TD>
      </TR></TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>
	  <TR height="30" width='100%' >
     <TD bgcolor="#FFFFFF"><B>WhiteList Type</B></TD>
     <TD bgcolor="#FFFFFF"><select name="whitelist" id="whitelist" class="in" onchange="javascript:showdiv(this.value)">
		<option value="">--select--</option>
		<option value="1">Retailer</option>
		<option value="2">USSD</option>
		</select>
		</TD>
      </TR>
  	<?php

	// to Fetch the record for the service Name
	
	$get_service_name="select servicename,serviceid from master_db.tbl_app_service_master";
	$result_query=mysql_query($get_service_name,$dbConn);
	// end codfe to fetch the record for Sevice name
	?>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Service Type</B></TD>
        <TD bgcolor="#FFFFFF">
		<select name="service_info" id='service_info' class="in">
			<option value=''>--select--</option>
			<?php
			while($service_record=mysql_fetch_array($result_query)) {
			echo "<option value=".$service_record['serviceid'].">".$service_record['servicename']."</option>";
		}
		?>
		</select>
		</TD>
      </TR>
     
	 <TR height="30" width='100%' id="showcircle" >
     <TD bgcolor="#FFFFFF"><B>Circle</B></TD>
     <TD bgcolor="#FFFFFF"><select name="circle_dec" id="circle_dec" class="in">
		<option value="">--select--</option>
		<option value="UPE">UPE</option>
		<option value="UPW">UPW</option>
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