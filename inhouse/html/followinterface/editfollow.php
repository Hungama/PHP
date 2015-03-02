<?php 
include ("config/dbConnect.php");
$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','J'=>'Jammu-Kashmir');
$i=0;
$getCelebritryName='select Celeb_name,Celeb_id from follow_up.tbl_celebrity_manager order by Celeb_name';
$selectCeleb_execute=mysql_query($getCelebritryName);
while($row1=mysql_fetch_array($selectCeleb_execute))
{	
	$idArray[$i]=$row1[Celeb_id];
	$celebArray[$i]=$row1[Celeb_name];
	$i++;
}
$celebCnt=count($celebArray);
echo $idcount=count($idArray);
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<link rel="stylesheet" href="style.css" type="text/css">

<script language="javascript">
function validate()
{
var chks = document.getElementsByName('selcheckbox[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
break;
}
}
if (hasChecked == false)
{
alert("Please select at least one.");
return false;
}
return true;
}
</script></head>
<body leftmargin="0" topmargin="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr> 
  <?php $flag=1?>
    <td><?php include("header.php") ?></td>
  </tr>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table>
<br><br><br>
  
  <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="40%">
    <tbody><tr> 
      <td align="center" bgcolor="#ffffff"><table class="txt2" bgcolor="#e6e6e6" border="0" cellpadding="0" cellspacing="1" width="100%">
        <tbody>
          <tr bordercolor="#0099FF">
            <td colspan="3" align="center" bgcolor="#FFFFFF"  height="25"><div align="center"><strong>Admin 
              Login </strong></div><font color="#FF0000">* Please select checkbox to update </font> </td>
          </tr>
        <form name="frm" action="savedata.php" method="post" onSubmit="return validate()" >
		<?php
			
			/*for($y=0;$y<$idcount;$y++)
			{
			?>
			  <input type="hidden" name="idArray[]" value="<?php echo $idArray[$y];?>">
			  <?php
			  }*/
			  ?>
          <tr>
            <td width="10%" height="27" bgcolor="#FFFFFF" style="padding-left: 5px;"><div align="center"><strong>Select</strong></div></td>
            <td width="49%" height="27" bgcolor="#FFFFFF" style="padding-left: 5px;"><div align="center"><strong>Circle</strong></div></td>
            <td width="51%" height="27" bgcolor="#FFFFFF" style="padding-left: 5px;"><div align="center"><strong>Celebrity </strong></div></td>
          </tr>
          <input type="hidden" name="circle_info" value="<?php echo $circle_info?>">
		  <?php
		   
			for ($z=0;$z<$celebCnt;$z++)
			{
		  	?>
			
          <input type="hidden" name="circle_info[$z]" value="<?php echo $circle_info[$z]?>"
			<?php
			
			}
				$selectCircle="select Circle,Celeb from follow_up.follow_up_circle_manager order by Circle";
				$selectCircle_execute=mysql_query($selectCircle);
				$j=1;
				while($row1=mysql_fetch_array($selectCircle_execute))
				{?>
				
          <tr>
            <td bgcolor="#ffffff" height="27" align="center">
			
              <input type="checkbox" name="selcheckbox[]" id="selcheckbox[]" value="<?php echo $row1['Circle'];?>">
              </td>
            <td style="padding-left: 5px;" bgcolor="#ffffff" height="27" align="center"><?php echo $circle_info[$row1['Circle']];?> </td>
            <td bgcolor="#FFFFFF" align="center"><?php
						if ($j<=23)
						{
					?>
                <select name="name[]">
                  <?php 
					for($k=0;$k<$celebCnt;$k++)
					{
						if($row1['Celeb']==$celebArray[$k])
								$isSelected='selected';
						else
							$isSelected='';
							$myValue=$idArray[$k]."-".$row1['Circle']."-".$celebArray[$k];
						echo "<option value='".$myValue."' ".$isSelected.">".$celebArray[$k]."</option>";
					}
					
					?>
                </select>            </td>
          </tr>
          <?php
		  }
		  $j++;
				}
				
				mysql_close($dbConn);
		 ?>
        
      </table>
        <br>
		<div align="center"><input type="submit" value=" Save " name="edit"></div> 
		</form>      </td>
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