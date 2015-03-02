<?php
error_reporting(-1);
ob_start();
session_start();
include("web_admin.js");
include("config/dbConnect.php");
include_once("main_header.php");

if($_SERVER['REQUEST_METHOD']=="POST") {
	//echo $_POST['service_info'].",".$_POST['tnbdays'].",".$_POST['mode'].",".$_POST['pricepoint1'];
	if($_POST['service_info'] && $_POST['tnbdays'] && $_POST['mode']) {
		if($_POST['service_info'] == '1111') {
			$tnbPlanId=$_POST['pricepoint1'];
		} elseif($_POST['service_info'] == '1116') {
			$tnbPlanId=$_POST['pricepoint2'];
		} 
		$serviceId= $_POST['service_info'];
		$tnbDays = $_POST['tnbdays'];
		$tnbMode = $_POST['mode'];						
		$selMaxId="select max(batch_id)+1 from master_db.bulk_tnb_history";
		$qryBatch = mysql_query($selMaxId,$dbConn);
		list($batchId) = mysql_fetch_array($qryBatch);
		
		if(!$batchId) $batchId=1;

		$uploadDir = "/var/www/html/hungamacare/tnbUpload/".$serviceId."/";			
		$filename = str_replace(" ","_",$_FILES['upfile']['name']);
		$filename1 = explode(".",$filename);
		
		$makFileName1 = $filename1[0]."_".$batchId."_".$serviceId;
		$makFileName = $filename1[0]."_".$batchId."_".$serviceId.".".$filename1[1];
		$path = $uploadDir.$makFileName;
		
		$file_to_read="http://10.130.14.107/hungamacare/tnbUpload/".$serviceId."/".$makFileName;				
		$file_data=file($file_to_read);
		$totalCount=sizeof($file_data);
		
		if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
			$insertQuery = "insert into master_db.bulk_tnb_history (batch_Id,file_name, added_by, added_on, tnbMode, tnbDays, status, planId, total_file_count, service_id, ipAddr) values (".$batchId.",'".$makFileName1."','$_SESSION[loginId]', NOW(), '".$tnbMode."', '".$tnbDays."', '0', '".$tnbPlanId."', '".$totalCount."', '".$serviceId."', '".trim($_SERVER['REMOTE_ADDR'])."')";
			mysql_query($insertQuery,$dbConn);
			$msg="File uploaded successfully.";
		} else {
			$msg="File not uploaded successfully. Please try again!";
		}
	} else {
		$msg="Request not inserted successfully. Please try again!";
	}
}
?>
<script language='javascript'>
	function checkfield() {
		if(document.getElementById('service_info').value=="") {
			alert("Please select service");
			document.getElementById('service_info').focus();
			return false;
		}
		if(document.getElementById('service_info').value=='1111') { 
			if(document.getElementById('pricepoint1').value=="") {
				alert("Please select Price Point");
				document.getElementById('pricepoint1').focus();
				return false;
			}
		} else if(document.getElementById('service_info').value=='1116') { 
			if(document.getElementById('pricepoint2').value=="") {
				alert("Please select Price Point");
				document.getElementById('pricepoint2').focus();
				return false;
			}
		}
		if(document.getElementById('tnbdays').value=="") {
			alert("Please select TnB days");
			document.getElementById('tnbdays').focus();
			return false;
		}
		if(document.getElementById('mode').value=="") {
			alert("Please select TnB subscription mode");
			document.getElementById('mode').focus();
			return false;
		}
		if(document.getElementById('upfile').value=="") {
			alert("Please upload file");
			document.getElementById('upfile').focus();
			return false;
		}
		if(document.getElementById('upfile').value) {
			var filename = document.getElementById('upfile').value;
			var ext = filename.split(".");
			if(ext[1] != 'txt') {
				alert("Please upload file text file only.");
				document.getElementById('upfile').focus();
				return false;
			}
		}
	}

	function setPlanData(sId) {
		if(sId == '1111') {
			document.getElementById('planDataDevo').style.display ='block';
			document.getElementById('planDataVA').style.display ='none';
		} else if(sId == '1116') {
			document.getElementById('planDataDevo').style.display ='none';
			document.getElementById('planDataVA').style.display ='block';
		}
		/*var xmlhttp;
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
		xmlhttp.open("GET","tnbPricePoint.php?sid="+sId,true);
		xmlhttp.send();	*/
	}
</script>
	<?php if($msg) { ?><div align='center' class='txt'><?php echo $msg;?></div><br/><?php } ?>
	<div align='center' class='txt'><b>Try-n-Buy</b></div><br/>
	<table width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
	<tbody>
	<form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
	<tr>
		<td height="20" bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Service</B></td>
		<td height="20" bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='service_info' id='service_info' onchange="setPlanData(this.value);" class='in'>
			<option value=''>Select Service</option>			
			<option value='1111'>MTS Devotional</option>			
			<!--<option value='1101'>MTS Music Unlimited</option>-->			
			<option value='1116'>MTS Voice Alert</option>			
			</select>
		</td>
	</tr>
	<tr>
		<td height="20" bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Price Point</B></td>
		<td height="20" bgcolor="#FFFFFF"><div id="planDataDevo" style="display:block;">&nbsp;&nbsp;
		<?php $priceQ = mysql_query("SELECT iAmount,Plan_id from master_db.tbl_plan_bank where S_id=1111 order by iAmount",$dbConn); ?>
			<select name="pricepoint1" id="pricepoint11" class='in'>
				<option value="">Select Price Point</option>
				<?php while($row = mysql_fetch_array($priceQ)) { ?>					
					<option value="<?php echo $row['Plan_id'];?>"><?php if($row['iAmount']==1) echo "Rs.1.25"; else echo "Rs.".$row['iAmount'];?></option>
				<?php } ?>
			</select></div>
			<div id="planDataVA" style="display:none;">&nbsp;&nbsp;
		<?php $priceQ = mysql_query("SELECT iAmount,Plan_id from master_db.tbl_plan_bank where S_id=1116 order by iAmount",$dbConn); ?>
			<select name="pricepoint2" id="pricepoint12" class='in'>
				<option value="">Select Price Point</option>
				<?php while($row = mysql_fetch_array($priceQ)) { ?>
					<option value="<?php echo $row['Plan_id'];?>"><?php echo "Rs.".$row['iAmount'];?></option>
				<?php } ?>
			</select></div>
		</td>
	</tr>
	<tr>
		<td height="20" bgcolor="#FFFFFF">&nbsp;&nbsp;<B>TNB Days</B></td>
		<td height="20" bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='tnbdays' id='tnbdays' class='in'>
				<option value="">Select Days</option>
				<option value="3">3 Days</option>
				<option value="5">5 Days</option>
			</select>
		</td>
	</tr>
	<tr>
		<td height="20" bgcolor="#FFFFFF">&nbsp;&nbsp;<B>TNB Mode</B></td>
		<td height="20" bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='mode' id='mode' class='in'>
				<option value="">Select Mode</option>
				<option value="TIVR">TIVR</option>
				<option value="TOBD">TOBD</option>
			</select>
		</td>
	</tr>
	<TR height="30" >
        <TD bgcolor="#FFFFFF" bgcolor="#FFFFFF">&nbsp;&nbsp;<B>Browse File To Upload <FONT COLOR="#FF0000">[.txt file]</B><br/>&nbsp;&nbsp;(text file must contain one 10 digit msisdn per line)</FONT></TD>
        <TD bgcolor="#FFFFFF" bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
    </TR>
	<tr align='center'>
		<td bgcolor="#FFFFFF" colspan="2"><input type='submit' name='submit' value='submit'></td>
	</tr> 
	</form>
	</tbody>
	</table>
	<br/>
	<br/><br/><br/><br/>			
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
<?php mysql_close($dbConn); ?>