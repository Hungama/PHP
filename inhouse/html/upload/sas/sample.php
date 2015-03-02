<?php
include("dbconfig.php");
$textvalue=$_REQUEST["textfield"];

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
			echo "Already Subscribed.......";
		}
		else
		{
			echo "You are not Subscribed";
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
   return (false);
}
if(isNaN(frm.textfield.value)) 
{
    alert('Please enter only numbers');
    return;
}
return (true);
}
</script>
</head>
<body leftmargin="0" topmargin="0">
    

<BR/><BR/>
<BR/>

<?php

$sql_query1="SELECT * FROM tunetalk_radio.tbl_tunetalk_subscription where ANI='0105070200'";
$query1 = mysql_query($sql_query1, $livecon);

echo "<table border='1'>
<tr><th>ANI</th>
<th>SUB_DATE</th>
<th>RENEW_DATE</th>
<th>DEF_LANG</th>
<th>STATUS</th>
<th>MODE_OF_SUB</th>
<th>DNIS</th>
<th>USER_BAL</th>
<th>movies</th>
<th>SUB_TYPE</th>
<th>plan_id</th>
<th>circle</th>
<th>chrg_amount</th>
<th>pre_post</th>
<th>trans_ID</th>
</tr>";

while($row = mysql_fetch_array($query1))
  {
echo "<tr>";
echo "<td>" . $row['ANI'] . "</td>";
echo "<td>" . $row['SUB_DATE'] . "</td>";
echo "<td>" . $row['RENEW_DATE'] . "</td>";
echo "<td>" . $row['DEF_LANG'] . "</td>";
echo "<td>" . $row['STATUS'] . "</td>";
echo "<td>" . $row['MODE_OF_SUB'] . "</td>";
echo "<td>" . $row['DNIS'] . "</td>";
echo "<td>" . $row['USER_BAL'] . "</td>";
echo "<td>" . $row['movies'] . "</td>";
echo "<td>" . $row['SUB_TYPE'] . "</td>";
echo "<td>" . $row['plan_id'] . "</td>";
echo "<td>" . $row['circle'] . "</td>";
echo "<td>" . $row['chrg_amount'] . "</td>";
echo "<td>" . $row['pre_post'] . "</td>";
echo "<td>" . $row['trans_ID'] . "</td>";
echo "</tr>";
  }
echo "</table>";

?>

<br><br>

</body>
</html>
<?php
//mysql_close($livecon);
?>