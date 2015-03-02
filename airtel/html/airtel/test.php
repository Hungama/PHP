<?php 
$con = mysql_connect("10.2.73.160","team_user","Te@m_us@r987");
$msisdnArray=array(9612401565,9612401565,9612401565,9612401565,9935883622,9935883622,8420858167,8890966948,9952140173,9678423348,9678423348,9910400921,8756393998,8756393998,9894479478,8295170470,8295170470,9600182343,9600182343,9600182343,9600182343,9963807435,9680478313,9862274807,9622612994,9622612994,8756036824,9678028275,9890225445,9890225445,9902452826,9902452826);

$arraySize=count($msisdnArray);
for($i=0;$i<$arraySize;$i++)
{
	$getCircle = "select master_db.getCircle(".$msisdnArray[$i].") as circle";
	$circle1=mysql_query($getCircle) or die( mysql_error() );
	while($row = mysql_fetch_array($circle1)) 
	{
		echo $msisdnArray[$i]."#".$row['circle']."<br/>";
	}
}
?>