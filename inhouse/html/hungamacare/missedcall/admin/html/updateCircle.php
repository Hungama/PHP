<?php
require_once("../../../db.php");
$getAllData=mysql_query("select ANI,circle from hul_hungama.tbl_hul_pushobd_sub nolock where circle is null",$con);

while($data= mysql_fetch_array($getAllData))
{
$ani=$data['ANI'];
$getCircle = "select master_db.getCircle(".trim($ani).") as circle";
					$circle1=mysql_query($getCircle,$con);
					list($circle)=mysql_fetch_array($circle1);
					if(!$circle)
					{ 
					$circle='UND';
					}
					$update="update hul_hungama.tbl_hul_pushobd_sub set circle='".$circle."' where ANI='".$ani."'";
					mysql_query($update,$con);
}
mysql_close($con);
?>