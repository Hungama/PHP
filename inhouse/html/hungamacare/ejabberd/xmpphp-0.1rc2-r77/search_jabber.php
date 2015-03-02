 <?php
error_reporting(0);
include('dbconfig.php');
$lang=$_REQUEST['lang'];
$category=trim($_REQUEST['category']);
$circle=$_REQUEST['circle'];
$service=$_REQUEST['service'];
$scategory=trim($lang.$category);
$scategory=str_replace(" ", '', $scategory);
$rpage=$_REQUEST['page'];

//echo $lang.'--'.$category.'--'.$circle.'--'.$service;
$search_text=urldecode($_REQUEST['stxt']);
switch($service)
{
				case 'mymusic': 
					//$tbContDetail='uninor_mm';
					$tbContDetail='mymusic';
					if(!empty($search_text))
					{					
					$condition="WHERE ContentName LIKE '%$search_text%' OR AlbumName LIKE '%$search_text%' ORDER BY AlbumName ASC";
					}
					else
					{
					$condition="WHERE Language='$lang' and BusinessCategory1='$scategory' ORDER BY AlbumName ASC";
					}
				break;
				case 'mu': 
					//$tbContDetail='uninor_mm';
					$tbContDetail='musicunlimited';
					if(!empty($search_text))
					{					
					$condition="WHERE ContentName LIKE '%$search_text%' OR AlbumName LIKE '%$search_text%' ORDER BY AlbumName ASC";
					}
					else
					{
					$condition="WHERE Language='$lang' and BusinessCategory1='$scategory' ORDER BY AlbumName ASC";
					}
				break;
				case 'myrt': 
					//$tbContDetail='uninor_mm';
					$tbContDetail='myringtone';
					if(!empty($search_text))
					{					
					$condition="WHERE ContentName LIKE '%$search_text%' OR AlbumName LIKE '%$search_text%' ORDER BY AlbumName ASC";
					}
					else
					{
					$condition="WHERE Language='$lang' and BusinessCategory1='$scategory' ORDER BY AlbumName ASC";
					}
				break;
	
}



$limit=5;
$query="SELECT * FROM $tbContDetail  $condition LIMIT $limit";
$rs_result = mysql_query ($query,$db_link); 
$noofrecords=mysql_num_rows($rs_result);

if($service=='mu')
{
$i=1;
if($noofrecords!=0)
{
$message;
$crbt_id_group;
while ($row = mysql_fetch_assoc($rs_result)) {
if(!empty($row["CRBT_ID"]) || !empty($row["Onmobile_CRBT"]))
{
if(!empty($row["ContentName"]))
{
$title=substr(ucwords(strtolower($row["ContentName"])), 0, 20);
}
else
{
$title='NA';
}
if(!empty($row["AlbumName"]))
{
$albumname= substr(ucwords(strtolower($row["AlbumName"])), 0, 20);
}
else
{
$albumname='NA';
} 
//$row["CRBT_ID"]; 
//$row["Onmobile_CRBT"];
$message.=$i." - ".$title.' ('.$albumname.' )'.'*'.PHP_EOL;
//echo $i." - ".$title.' ('.$albumname.' )'.PHP_EOL;
$crbt_id_group.=$row["CRBT_ID"].'-'.$row["Onmobile_CRBT"].'|';
$i++;
}
}
echo $message.'@'.$crbt_id_group;
}
else
{
//Sorry, No result found for your search. 
echo 'Ooops no record found';
}
}
else
{
//Sorry, No result found for your search.
echo 'Ooops no record found';
}