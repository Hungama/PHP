<?php
include("dbconfig.php");
$textvalue=$_REQUEST["textfield"];
$Anivalue=$_REQUEST["ANI"];

if($_REQUEST['textfield']=="")
{
}
else
{
$sql_query="SELECT count(1) FROM tunetalk_radio.tbl_tunetalk_subscription where ANI='$textvalue'";
$query = mysql_query($sql_query, $livecon);// or die(mysql_error());
list($count)=mysql_fetch_array($query);
		if($count)
		{ 
		$valid="Already Subscribed.......";
		$tmp_value="0";
		}
		else
		{
		$valid="You are not Subscribed";
		$tmp_value="1";
		}
}		
?>

<html>
<head>
<title>TUNE TALK CALL CENTER</title>

<script Language="JavaScript">
<!-- 
function textcheck()
{
if (frm.textfield.value == "")
{
   alert("Please fill in the text field.");
   frm.textfield.focus();
   tbl.reset();
   return false;
}
if(isNaN(frm.textfield.value)) 
{
    alert('Please enter only numbers');
	tbl.reset();
    return false;
}
return true;
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<BR/><BR/>
<BR/>
  <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="40%">
    <tbody><tr> 
      <td align="center" bgcolor="#ffffff"> 
        <table class="txt2" bgcolor="#e6e6e6" border="0" cellpadding="0" cellspacing="1" width="100%">
          <tbody><tr> 
            <td colspan="2" align="center" bgcolor="#ffffff" height="25">&nbsp;</td>
          </tr><form name="frm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return textcheck()" >
          <tr> 
            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>Select ANI</strong>  
              : </td>
            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
			<label>
				<input name="textfield" type="text" maxlength="10" />
			</label>
			</td>
          </tr>
          <tr align="center"> 
            <td style="padding-left: 5px;" colspan="2" bgcolor="#ffffff" height="35"> 
              <input name="submit" class="submit" value="Submit" type="submit" src="images/submit.jpg">
             &nbsp;&nbsp;&nbsp;</td>
          </tr></form>
        </tbody></table>
      </td>
    </tr>
  </tbody></table>

<?php
$sql_query1="SELECT * FROM tunetalk_radio.tbl_tunetalk_subscription where ANI='$textvalue'";
$query1 = mysql_query($sql_query1, $livecon);

?>

<br>
<div align="center">
<?php echo $valid; ?>
</div>
<br>
<?php
if(($_REQUEST['textfield']=="") || ($tmp_value=="1") || (!is_numeric($_REQUEST['textfield'])))
{
}
else
{
?>
<table name="tbl" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="70%">
<tbody>
<table align="center" class="txt2" bgcolor="#e6e6e6" border="0.2" cellpadding="0" cellspacing="1" width="70%">
<tbody>
<tr>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>ANI</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>SUB_DATE</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>RENEW_DATE</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>DEF_LANG</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>STATUS</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>MODE_OF_SUB</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>DNIS</th>
<!--
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>USER_BAL</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>movies</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>SUB_TYPE</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>plan_id</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>circle</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>chrg_amount</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>pre_post</th>
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>trans_ID</th>
-->
<th style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>ACTION</th>
</tr>

<?php
while($row = mysql_fetch_array($query1))
  {
	if (($row['STATUS']=="1") || ($row['STATUS']=="11"))
	  {
		if($row['STATUS']=="1")
		  {
			  $status="<a href='callcenter.php?ANI=". $tmp_ani=$row['ANI'] ."'>Deactivate</a>";
		  }
		  else
		  {
			  $status="<a href='callcenter.php?ANI=". $tmp_ani=$row['ANI'] ."'>Deactivate(Pending)</a>";
		  }
	  }
	  else
	  {
		$status="<a href='#'>Not Active</a>";
	  }
echo "<tr>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['ANI'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['SUB_DATE'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['RENEW_DATE'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['DEF_LANG'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['STATUS'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['MODE_OF_SUB'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['DNIS'] . "</td>";
/*
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['USER_BAL'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['movies'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['SUB_TYPE'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['plan_id'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['circle'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['chrg_amount'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['pre_post'] . "</td>";
echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $row['trans_ID'] . "</td>";
*/

echo "<td style='padding-left: 5px;' bgcolor='#ffffff' height='35'>" . $status . "</td>";
echo "</tr>";
  }
echo "</table></tbody></table>";
}
	if($Anivalue != "")
        {
			$sql_query2 = "CALL tunetalk_radio.TT_UNSUB('$Anivalue', 'CC')";
			$result2 = mysql_query($sql_query2);
            echo "<center>Deactivated Number</center>";
        }

?>
<br><br>
</div>

</body>
</html>
<?php
//mysql_close($livecon);
?>