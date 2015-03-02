<?php
$cfile="subCategory.xml";

if(file_exists($cfile)) 
{
	$xml = simplexml_load_file($cfile);
	echo "<font size='3'><b>Reply</b></font><br/><br/>";
	foreach($xml->subcategory as $content)
	{
		if($optid==$content->attr[1])
			echo "<font size='2'><b>".$content->attr[0]."</b>&nbsp;". $content->attr[4]."</font><br/><br/>";
	}
}
echo "<font size='2'><b>#</b> to get back on main menu</font><br/><br/>";
echo "<form>";
foreach($xml->subcategory as $content)
{
	if($optid==$content->attr[1])
	{
		echo "<input type='radio' name='btn' value=".$content->attr[0]." onclick='javascript:setsimulatortext1(this.value,2)'/>".$content->attr[0];
	}
}
	echo "<input type='radio' name='btn' value='#' onclick='javascript:setsimulatortext(this.value)'/>#";
echo "</form>";
?>

