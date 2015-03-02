<?php
$cfile="category.xml";
if(file_exists($cfile)) 
{
	$xml = simplexml_load_file($cfile);
	
	//echo "<pre>";	print_r($xml);	exit;
	echo "<font size='3'><b>Reply</b></font><br/><br/>";
	foreach($xml->category as $content)
	{
		echo "<font size='2'><b>".$content->attr[0]."</b>&nbsp;". $content->attr[3]."</font><br/><br/>";

	}
}
echo "<form>";
foreach($xml->category as $content)
{
	echo "<input type='radio' name='btn' value=".$content->attr[0]." onclick='javascript:setsimulatortext1(this.value,1)'/>".$content->attr[0];
}
echo "<input type='radio' name='btn' value='#' onclick='javascript:setsimulatortext(this.value)'/>#";
echo "</form>";
?>

