<?php
$cfile="menu1.xml";
if(file_exists($cfile)) 
{
	$xml = simplexml_load_file($cfile);
	
	echo "<font size='3'><b>Reply</b></font><br/><br/>";
	foreach($xml->Menu1 as $content)
	{
		echo "<font size='2'><b>".$content->attr[0]."</b>&nbsp;". $content->attr[1]."</font><br/><br/>";

	}
}
?>

<br/><br/>
<form>
<?php
foreach($xml->Menu1 as $content)
{
	echo "<input type='radio' name='btn' value=".$content->attr[0]." onclick='javascript:setsimulatortext1(this.value,3)'/>".$content->attr[0];
}
echo "<input type='radio' name='btn' value='4' onclick='javascript:setsimulatortext(this.value)'/>4";
echo "<input type='radio' name='btn' value='#' onclick='javascript:setsimulatortext(this.value)'/>#";
?>
</form>



	
   
