<?php

$cfile="mainMenu.xml";
if(file_exists($cfile)) 
{
	$xml = simplexml_load_file($cfile);

	echo "<font size='3'>Welcome to Deals on Mobile </font><br/><br/>";
	echo "<b>Reply</b><br/>";
	foreach($xml->mainMenu as $content)
	{
		echo "<font size='2'><b>".$content->attr[0]."</b>&nbsp;  For ". $content->attr[1]."</font><br/>";

	}
}
?>
<br/><br/>
<form>
	  <input type="radio" name="btn" value="01" onclick="javascript:setsimulatortext(this.value)"/>01
	  <input type="radio" name="btn" value="02" onclick="javascript:setsimulatortext(this.value)"/>02
	  <input type="radio" name="btn" value="03" onclick="javascript:setsimulatortext(this.value)"/>03
	  <input type="radio" name="btn" value="04" onclick="javascript:setsimulatortext(this.value)"/>04
	  <input type="radio" name="btn" value="#" onclick="javascript:setsimulatortext(this.value)"/>#
</form>   