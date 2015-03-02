<?php
$isSorted=$_REQUEST['sorted'];
$rowNo=$_REQUEST['row'];
$songs =  array(
		'1' => array('711','112','613','514'),
		'2' => array('721','122','523','224'),
		'3' => array('231','132','330','534'),
		'4' => array('541','742','434','144')
	);


if($isSorted!=1)
{
	echo "<table border='1'>";
	echo "<tr>";
	for($i=1;$i<5;$i++)
	{
		for($j=0;$j<5;$j++)
		{
			echo "<td>";
				echo "<a href='test.php?row=$i&sorted=1'>".$songs[$i][$j];
			echo "</td>";
			if($j==4)
			echo "</tr><tr>";	
		}
	}
	echo "</table>";
}
else
{
	
	sortArray($songs,$rowNo);
	function sortArray($songs1,$rowNo1)
	{

		echo "athar<pre>";
		print_r($songs1);
	}
}

?>