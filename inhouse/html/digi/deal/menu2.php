<?php
$cfile="menu2.xml";
if(file_exists($cfile)) 
{
	$xml = simplexml_load_file($cfile);
	
	echo "<font size='3'><b>Reply</b></font><br/><br/>";
	foreach($xml->Menu2 as $content)
	{
		echo "<font size='2'><b>".$content->attr[0]."</b>&nbsp;  For ". $content->attr[1]."</font><br/><br/>";

	}
}
?>

<br/><br/>
<form>
	  <input type="radio" name="btn" value="01" onclick="javascript:setsimulatortext1(this.value,3)"/>01
	  <input type="radio" name="btn" value="02" onclick="javascript:setsimulatortext1(this.value,3)"/>02
	  <input type="radio" name="btn" value="03" onclick="javascript:setsimulatortext1(this.value,3)"/>03
	  <input type="radio" name="btn" value="04" onclick="javascript:setsimulatortext(this.value)"/>04
	  <input type="radio" name="btn" value="#" onclick="javascript:setsimulatortext(this.value)"/>#
</form>   
