<?php
$msisdn =$_GET['msisdn'];
	function checkmsisdn($msisdn)
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
		if(strlen($msisdn)==12)
		{
			if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
			else
			{
					exit;
			}
		}
	}
	elseif(strlen($msisdn)!=10)
	{
	
		exit;
	}
return $msisdn;
}
$msisdn=checkmsisdn($msisdn);
	$con = mysql_connect("database.master","weburl","weburl");
	if(!$con)
	{
		die('could not connect1: ' . mysql_error());
	}
	$check_query="select * from hungama_mtv_docomo.tbl_mtv_subscription where ANI='$msisdn' and STATUS='1'";
	$execute_query=mysql_query($check_query);
	if(mysql_num_rows($execute_query))
	{
		echo "MTV";
	}
	else
	{
		echo " ";
	}
?>