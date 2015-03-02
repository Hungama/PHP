<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr> 
   <!-- <td style="padding-left:20px"><img src="images/logo.png" alt="Hungama" align="left" border="0" hspace="0" vspace="15"></td>-->
   <td><?php $flag=2; include("header.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table>
<?php
//echo "<pre>";print_r($_REQUEST);
include ("config/dbConnect.php");
$cnt=count($_REQUEST['name']);
$cntcheck=count($_REQUEST['selcheckbox']);
for ($i=0;$i<$cnt;$i++)
{
	$circlename=explode('-',$_REQUEST['name'][$i]);
	for ($j=0;$j<$cnt;$j++)
	{
		if ($circlename[1]==$_REQUEST['selcheckbox'][$j])
		{
			$updateQuery="update follow_up.follow_up_circle_manager set celeb='".$circlename[2]."',celebid='".$circlename[0]."' where Circle='".$circlename[1]."'";
			mysql_query($updateQuery);
		}
	}
}
mysql_close($dbConn);
?><style type="text/css">
<!--
body,td,th {
	color: #FF0000;
}
-->
</style>
<br><br><br>
<br><br><br>
<br><br><br>

<div align="center"><strong>Data Updated</strong> </div> 
<?php
//include("include.php");
//header("Location: http://119.82.69.212/followinterface/followstatus.php");
?>