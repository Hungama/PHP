<?php
$cfile="mainMenu.xml";
if(file_exists($cfile)) 
{
	$xml = simplexml_load_file($cfile);

	//echo "<pre>";	print_r($xml);	exit;
	
	foreach($xml->mainMenu as $content)
	{
		
		echo $content->attr[0];
		echo $content->attr[1];
	}
}

/*
$rearr_cont_id = $content->attr[0];
		$contents_str.= $content->attr[0].",";
		$arr_short_dname.=$content->attr[5].",";
		$arr_disp_name.= $content->attr[4].",";
		$arr_desc_for_cont_str.= $content->attr[2].",";
		$game_price_str.= $content->attr[6].",";
		$support_group_arr = array();
		
		$groupid = 0;
		$supportGidStr = "";
		$supportValStr = "";
		foreach ($content->support as $support)
		{
			foreach($support->attributes() as $gid) {
				$groupid = $gid;
			}
			$supportGidStr.="$groupid,";
			$supportValStr.="".$support[0].",";
		}
		$supportGidArr = explode(",",substr($supportGidStr,0,-1));
		$supportValArr = explode(",",substr($supportValStr,0,-1));
		
		for($i=0;$i<count($supportGidArr);$i++)
		{
			$support_group_arr[$supportGidArr[$i]] = $supportValArr[$i];
			if($type_var=="theme")
			{
				$arr_cont_ids_for_groups[$supportGidArr[$i]][] = $rearr_cont_id;
			}
		}
		
		$var="show_ext_".$rearr_cont_id;
		$$var = str_replace(".","",$support_group_arr);
		
		$supportidchk = ${$support_arr[$type_var]};
		
		if(in_array($supportidchk,$supportGidArr))
		{
			$arr_new_cont_id_pos[] = trim($rearr_cont_id);
		}

*/	