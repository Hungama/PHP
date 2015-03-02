<?php
$type=$_REQUEST[a];
if($type=='menu')
{
//e.g If you want to get the main menu detail of Delhi circle, then use below URL http://10.181.255.141:8080/MODCatagory/153.cir
echo file_get_contents('http://10.181.255.141:8080/MODCatagory/153.cir');
}
else if($type=='mz')
{
//. e.g to get the music zone detail of Hindi language, you can use URL as http://10.181.255.141:8080/MODCatagory/1.mzone
echo file_get_contents('http://10.181.255.141:8080/MODCatagory/1.mzone');
}
else if($type=='song')
{
//Find the Business category name and ID as attachment (Aircel Live Category 2013)
//BusinessCategoryID1:Altruistid1, Altruistid2, Altruistid3, Altruistid4, Altruistid5, Altruistid6, Altruistid7, Altruistid8
//content detail on the basis of AltruistID and BusinessCategoryID 
echo file_get_contents('http://10.181.255.141:8080/MODCatagory/SongDetail.txt');
}

?>

