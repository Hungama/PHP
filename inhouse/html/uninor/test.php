<?php
$lines = file('rianoresponse1.txt');

//echo "<pre>";print_r($lines);
$fileSize=sizeof($lines);
for($i=1;$i<$fileSize;$i++)
{
	echo $lines[$i];
	echo "<br>";
}

exit;




$allani= array();
$i=0;
foreach ($lines as $line_num => $mobno)
 {
//read line of file
$mno=trim($mobno);
 $allani[$line_num]=$mno;
echo $mobno."<br><br><br>";
/* if($i%2==0)
 {
 //echo $mobno."<br><br><br>";
 $firstline=$mobno;
 //$mm=explode("|", $mobno);
 //echo  $mm[0]."|".$mm[1]."<br><br><br>";
 }
 else
 {
 $mm=explode("|", $mobno);
 //echo  $mm[0]."|".$mm[1]."<br><br><br>";
 $lastline="**".$mm[0]."|".$mm[1];
 }
 //$finalstring=$firstline.$lastline;
 echo "<br><br>";
 
 */
 if($i==2000)
 {
 exit;
 }
	  $i++;        
}
?>