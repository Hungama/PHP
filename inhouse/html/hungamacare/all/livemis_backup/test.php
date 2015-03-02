<?php
$view_date1= date("Y-m-d H:i:s",mktime(date("H")-1,0,0,date("m"),date("d"),date("Y")));
$view_date2= date("Y-m-d H:i:s",mktime(date("H"),0,0,date("m"),date("d"),date("Y")));

echo $view_date1." - ".$view_date2;
?>