<?php

include("config/dbconfig.php");

$allowedExts = array("txt");
	if($_FILES["file"]["name"])
	{
		$extension = end(explode(".", $_FILES["file"]["name"]));
	}
	else if($_FILES["file1"]["name"])
	{
		$extension = end(explode(".", $_FILES["file1"]["name"]));
	}
if (in_array($extension, $allowedExts))
	{
		move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" ."del.txt");
		move_uploaded_file($_FILES["file1"]["tmp_name"],"upload/" ."text.txt");
		 
	}
else
	{
		 $redirect = "recWhitelist.php?logerr=notup";
	}
	
$lines = file('upload/text.txt');
//table
echo '<center><table border="1"><tr><td><b>You are Activated these ANI</b></td></tr>';
foreach ($lines as $line_num => $mobno) 
	{
	//read and insert line by line in database
	$mno=trim($mobno);
	if(!empty($mno))
		{
		$w=$mno;

		$ANIdetail="INSERT INTO reliance_hungama.tbl_reliance_disclaimer values('".$w."')";
		$ANItemp = mysql_query($ANIdetail, $con);
		echo "<tr><td>".$w."</td></tr>";
		$redirect = "recWhitelist.php?logerr=sec";
		}
	}
		echo '</table></center>';

echo "<br><br>";

$lines = file('upload/del.txt');
//table
echo '<center><table border="1"><tr><td><b>You are Deactivated these ANI</b></td></tr>';
foreach ($lines as $line_num => $mobno) 
	{
	//read and insert line by line in database
	$mno=trim($mobno);
	if(!empty($mno))
		{
		$w=$mno;

		$ANIdetail_del="delete from reliance_hungama.tbl_reliance_disclaimer where ANI='".$w."'";
		mysql_query($ANIdetail_del, $con);
		
		echo "<tr><td>".$w."</td></tr>";
		$redirect = "recWhitelist.php?logerr=sec";
		}
	}
		echo '</table></center>';

//$redirect = "recWhitelist.php";
	header("Location: $redirect");

?>