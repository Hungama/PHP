<?php
include_once './dbconnect.php';
$msisdn=$_REQUEST['msisdn'];

$table=array('tbl_jbox_subscription'=>'reliance_hungama',
'tbl_mtv_subscription'=>'reliance_hungama','tbl_cricket_subscription'=>'reliance_cricket');
$k=0;
$serviceInfo=array();
foreach($table as $key=>$value)
{
		
	$query="select count(*) from $value.$key where ani='$msisdn'";
	$queryresult=mysql_query($query);
	$row = mysql_fetch_row($queryresult);
	$serviceInfo[$k]=$row[0];
	$k++;
	
}
	for($i=0;$i<3;$i++)
	{
		if($i==0)
		{
			if($serviceInfo[$i]==1)
			{
				$serviceStr .='54646';
				if($serviceInfo[$i+1]==1 ||$serviceInfo[$i+2]==1)
				$serviceStr .=',';
			}
		}
		if($i==1)
		{	
			if($serviceInfo[$i]==1)
			{
				$serviceStr .='MTV';
				if($serviceInfo[$i+1]==1)
				$serviceStr .=',';
			}
		}
		if($i==2)
		{
		
			
			if($serviceInfo[$i]==1)
			$serviceStr .='CricketMania';
		}
	
	}
	
	echo $serviceStr;

?>

