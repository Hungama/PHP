<?php
$type=$_REQUEST[a];
$circleid=$_REQUEST[c];
$langid=$_REQUEST[l];
$url='http://124.153.75.198/fanpage/contentlive/menuorder.php?a='.$type.'&c='.$circleid.'&l='.$langid;
//$url='http://aircelmusicconnect.com/fanpage/contentlive/menuorder.php?a='.$type.'&c='.$circleid.'&l='.$langid;
echo file_get_contents($url);
exit;
if($type=='menu')
{
//e.g If you want to get the main menu detail of Delhi circle, then use below URL http://10.181.255.141:8080/MODCatagory/153.cir
//echo file_get_contents('http://10.181.255.141:8080/MODCatagory/153.cir');
echo file_get_contents('http://aircelmusicconnect.com/fanpage/contentlive/menuorder.php?a=menu&c='.$circleid.'&l='.$langid);
}
else if($type=='mz')
{
//. e.g to get the music zone detail of Hindi language, you can use URL as http://10.181.255.141:8080/MODCatagory/1.mzone
//echo file_get_contents('http://10.181.255.141:8080/MODCatagory/1.mzone');
echo file_get_contents('http://aircelmusicconnect.com/fanpage/contentlive/menuorder.php?a=mz&c=153&l=1');
}
else if($type=='song')
{
//Find the Business category name and ID as attachment (Aircel Live Category 2013)
//BusinessCategoryID1:Altruistid1, Altruistid2, Altruistid3, Altruistid4, Altruistid5, Altruistid6, Altruistid7, Altruistid8
//content detail on the basis of AltruistID and BusinessCategoryID 
//echo file_get_contents('http://10.181.255.141:8080/MODCatagory/SongDetail.txt');
echo file_get_contents('http://aircelmusicconnect.com/fanpage/contentlive/menuorder.php?a=song');
}
?>

