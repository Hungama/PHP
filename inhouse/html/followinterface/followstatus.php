<?php
$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','J'=>'Jammu-Kashmir');

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="javascript">
function checkfield()
{
	ok=true
	if(frm.login.value=="")
	{
		alert("Please enter login name.")
		frm.login.focus();
		ok=false
	}
	else if(frm.pass.value == "")
	{
		alert("Please enter password");
		frm.pass.focus();
		ok=false
	}
	return ok
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php include ("config/dbConnect.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr> 
    <td><?php include("header.php") ?></td>
  </tr>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table>
<br><br><br>
  
  <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="40%">
    <tbody><tr> 
      <td align="center" bgcolor="#ffffff"> 
        <table class="txt2" bgcolor="#ffffff" border="0" bordercolor="#0099FF" cellpadding="0" cellspacing="1" width="100%">
          <tbody><tr bordercolor="#0099FF"> 
            <td colspan="2" align="center"  height="25"><strong>Admin 
              Login </strong> </td>
          </tr><form name="frm" action="editfollow.php" method="post" onSubmit="return checkfield()">
          <tr> 
		  
            <td width="49%" height="27"  bgcolor="#FFFFFF" style="padding-left: 5px;"><div align="center"><strong>Circle</strong></div></td>
            <td width="51%" height="27"  bgcolor="#FFFFFF" style="padding-left: 5px;"> <div align="center"><strong>Celebrity </strong></div></td>
          </tr>
          
		  <?php 
				
				$selectCircle="select Circle,Celeb from follow_up.follow_up_circle_manager order by Circle";
				$selectCircle_execute=mysql_query($selectCircle);
				//echo $row1=mysql_fatch_array($selectCircle_execute);
				while($row1=mysql_fetch_array($selectCircle_execute))
				{?>
				 <tr>
					<td style="padding-left: 5px;" bgcolor="#ffffff" height="27" align="center">
					<?php echo $circle_info[$row1['Circle']];?></td>
			        <td style="padding-left: 5px;" bgcolor="#ffffff" height="27" align="center">
					<?php echo $row1['Celeb'];?><input type="hidden" name="<?php echo $circle1;?>" value="<?php echo $row1['Celeb'];?>"</td>
		  			</tr>
				<?php
				}
				mysql_close($dbConn);
		  ?>
        </table>
		<br>
		<div align="center"><input type="submit" value=" Edit " name="edit"></div> 

		</form>
      </td>
    </tr>
  <td height="2"></tbody></table>
<br>

<br>
<br>
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