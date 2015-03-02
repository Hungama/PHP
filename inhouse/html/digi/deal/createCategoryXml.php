<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$fileName="Category.xml";
$dirPath="/var/www/html/digi/deal/xml/";
$filePath=$dirPath.$fileName;
$fp=fopen($filePath,'w+');
$selectCategoryQuery="select distinct category from alloperator_mydala.tbl_deal where date(dateofdeal)='2012-12-02'";
$QueryResult=mysql_query($selectCategoryQuery);
$i=1;
$string="<deal>\r\n";
while($CategoryRecord=mysql_fetch_array($QueryResult))
{
	//print_r($CategoryRecord['category']);
		
	$string.="<category>\r\n";
	$string.="<attr name='catId'>".$i."</attr>\r\n";
	$string.="<attr name='type'>cat</attr>\r\n";
	$string.="<attr name='getType'>subcat</attr>\r\n";
	$string.="<attr name='catName'>".$CategoryRecord['category']."</attr>\r\n";	
	$string.="</category>";
	fwrite($fp,$string."\r\n");
	$string='';
	$i++;
}
$closeString="</deal>";
fwrite($fp,$closeString);
fclose($fp);
echo $string;

?>