<?php 
extract($_REQUEST);

if( ! isset( $filename )){
	echo "false\n Please Provide File Name! \n";
	exit();	
}
?>

<html>
<body>


<table border='1'> 
<tr>
<td>
<embed height="50px" width="100px" src="<?php echo $filename ?>"  autostart="false"></embed>
</td>
</tr>
</table>
</body>
</html>
 

