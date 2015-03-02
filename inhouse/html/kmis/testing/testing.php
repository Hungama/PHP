<script language="javascript" type="text/javascript">
<!--
function test(value)
{
	alert('athar');
	alert(value);
	
}

function popitup2(poly_id,true_id,mono_id) {
	newwindow2=window.open('','name','height=300,width=250');
	var tmp = newwindow2.document;
	tmp.write('<link rel="stylesheet" href="js.css">');
	tmp.write("<form name='frm'>");
	if(poly_id)
		tmp.write('<p><a href="sendSms.php?content_type=poly&id=poly_id">Poly Tones</a></p>');
	if(true_id)
		tmp.write('<p><a href="sendSms.php?content_type=true&id=true_id">True Tones</a></p>');
	if(mono_id)
		tmp.write('<p><a href="sendSms.php?content_type=mono&id=mono_id">Mono Length</a></p>');
	tmp.write("</form>");
	tmp.write('</body></html>');
	tmp.close();
}

// -->
</script>

<?php 

$poly='test';
$true='test';
$mono='test';
?>
<a href="#" onclick="return popitup2('<?php echo $poly;?>','<?php echo $true;?>','<?php echo $mono;?>')"><input type='button' value='Tones'></a> | 
<a href="#" onclick="return popitup2('<?php echo $poly;?>','<?php echo $true;?>','<?php echo $mono;?>')"><input type='button' value='FLA'></a> | 
<a href="#" onclick="return popitup2('<?php echo $poly;?>','<?php echo $true;?>','<?php echo $mono;?>')"><input type='button' value='Video'></a>