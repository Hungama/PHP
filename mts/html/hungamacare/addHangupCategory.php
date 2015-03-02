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
 
 function logout() {
 		window.parent.location.href = 'index.php?logerr=logout';
 }

 function checkfield(){  	 
   if(document.frm.language.value==""){
		alert("Please select language.");
		document.frm.language.focus();
		return false;
   }	
   if(document.frm.cat.value==""){
		alert("Please enter Category.");
		document.frm.cat.focus();
		return false;
   }
   if(document.frm.catId.value==""){
		alert("Please enter Category Id.");
		document.frm.catId.focus();
		return false;
   }
   return true;
}

</script>
</head>

<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php 
	$service_info=$_REQUEST['service_info'];
	$rest = substr($service_info,0,-2);
	if($rest==12)
		$logoPath='images/RelianceCricketMania.jpg';
	elseif($rest==14)
		$logoPath='images/uninor.jpg';
	else
		$logoPath='images/logo.png';

	include("header.php");
	$timeFrom = mktime(9,30,0);
	$timeTo = mktime(21,30,0);
	$currTime = mktime(date('H'),date('i'),date('s'));

	 if($_SERVER['REQUEST_METHOD']=="POST") {		 
		 $languageData = explode("-",$_REQUEST['language']);

		 $category = $_REQUEST['cat'];
		 $catId = $_REQUEST['catId'];
		 $langName = $languageData[0];
		 $langCode = $languageData[1];
		 
		 if($langCode!="" && $category!="" && $catId!="" && $langName!="") {
			 $hangupCode='hangup'.$langCode.$catId;
			 $result = mysql_query("SELECT count(*) FROM master_db.tbl_hangup_type WHERE category='".$category."' and hangup_type='".$hangupCode."'");
			 list($count) =	mysql_fetch_array($result);
			 if($count) {
				 $query="update master_db.tbl_hangup_type set category='".$category."' WHERE hangup_type='".$hangupCode."'";	
				 $msg = "Hangup type updated successfully."; 
			 } else {			 
				 $query="insert into master_db.tbl_hangup_type(category,catId,added_on,hangup_type,language) values('".$category."', '".$catId."', now(), '".$hangupCode."','".$langName."')";
				 $msg = "Hangup type added successfully."; 
			 }
			 $queryIns = mysql_query($query);			 		
		 } else {
			 $msg = "Invalid parameter, Please try again!";
		 }
	 }
?>
<TABLE width="80%" border="0" cellpadding="0" cellspacing="0" class="txt">      
	<TR height="30">
		<?php if(isset($msg)) { ?>
		<TD bgcolor="#FFFFFF" align='center'><FONT COLOR="#FF0000"><?php echo $msg;?></FONT></TD>
		<?php } ?>
	</TR>
	<TR height="30">		
		<TD bgcolor="#FFFFFF" align='right'><a href='hangupMessage.php'><FONT COLOR="#FF0000">Add/Update Message</FONT></a></TD>
	</TR>
</TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>      
		<?php
		// to Fetch the record for hangup type
		$getlang="select lang_name,langID from master_db.tbl_language_master order by lang_name";
		$lang_result=mysql_query($getlang,$dbConn);
		?>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Hangup Language</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='language' id='language'>
				<option value="">Select Language</option>
				<?php while($row = mysql_fetch_array($lang_result)) { ?>
					<option value="<?php echo $row['lang_name']."-".$row['langID']?>"><?php echo $row['lang_name']?></option>
				<?php }?>
			</select>
		</TD>
      </TR>
	  <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Category</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT TYPE="text" NAME="cat" id='cat' size='40'></TD>
      </TR>		
	  <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Category Id</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT TYPE="text" NAME="catId" id='catId' maxlength='3' size='40'></TD>
      </TR>
      <TR height="30">
        <TD align="center" colspan="2" bgcolor="#FFFFFF"><input name="Submit" type="submit" class="txtbtn" value="Submit" onSubmit="return checkfield();"/></TD>
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
} else {
	header("Location:index.php");
}
?>