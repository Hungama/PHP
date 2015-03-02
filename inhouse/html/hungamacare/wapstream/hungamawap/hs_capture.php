<?
/*
	function to get the handset name from the UA Profile
	
	created by sandeep phansekar and surin bhawsar - 22 June 2008
*/
	
	//echo $full_user_agent;
	function hs_identifier($incoming_ua_prof)
	{	
	
		$mystring = " ".$incoming_ua_prof;
		$arr_hs_manu = array("Vodafone/1.0/","Nokia","nokia","SonyEricsson","Motorola","Mot","MOT","moto","SAMSUNG","SPICE","Spice","FLY","SEC","BlackBerry","SAGEM","HTC","Dopod","Haier","LG/","LG","Samsung","NEC","Amoi","KONKA","LENOVO","Fly","Panasonic","Palm","SHARP","Bleu","BLEU","Lenovo","BenQ","Sagem","X1","ASUS","i-mate","SGH","HP","SIE","O2","Bird","Alcatel","Toshiba","PANTECH","Huawei","Huayu","iPhone","SCH","CECT","HTIL","Philips","Karbonn","KARBONN","Micromax","MICROMAX","SANYO","LCT","Vodafone","Lava","Videocon","Android","Nexian","ZTE","TIANYU-KTOUCH/","Onida","ONIDA","Mozilla","T-Series","MVL","BIRD","Lemon","Wyncom","G-Fone","MicroMax","INQ","Opera","LAVA","MAXX","Maxx","iBall","Iball");
				
		for($i=0; $i<count($arr_hs_manu); $i++)
		{
			if(strpos($mystring, $arr_hs_manu[$i]) > 0)
			{
				$possition = strpos($mystring, $arr_hs_manu[$i]);
				$deviceName = substr($mystring,$possition);
				$deviceName = str_replace("\\","/",$deviceName);
				$possition =  strpos($deviceName, "/");
				
				$deviceName = str_replace(":","",$deviceName);
				
				if($arr_hs_manu[$i] == "LG/" || $arr_hs_manu[$i] == "LG" || $arr_hs_manu[$i] ==  "Samsung" || $arr_hs_manu[$i] ==  "Amoi" || $arr_hs_manu[$i] == "Vodafone/1.0/" || $arr_hs_manu[$i] == "TIANYU-KTOUCH/")
				{
					$possition =  strpos($deviceName, "/", (strlen($arr_hs_manu[$i])+1));
					$deviceName = substr($deviceName,0,$possition);
					$deviceName = str_replace("/","-",$deviceName);
				}
				elseif($arr_hs_manu[$i] == "iPhone")
				{
					$possition =  strpos($deviceName, ";", (strlen($arr_hs_manu[$i])-1));
					$deviceName = substr($deviceName,0,$possition);
					$deviceName = str_replace(" ","",$deviceName);
				}
				elseif($arr_hs_manu[$i] == "i-mate")
				{
					$possition =  strpos($deviceName, ";", (strlen($arr_hs_manu[$i])-1));
					$deviceName = substr($deviceName,0,$possition);
					$deviceName = str_replace(" ","",$deviceName);
				}
				elseif($arr_hs_manu[$i] == "LAVA")
				{ 
					if(preg_match_all('/\bLAVA.C43\b/i', $mystring, $arr, PREG_PATTERN_ORDER))
					{ 
						$deviceName='lava.c43'; 
					}
					else
					{	
						$possition =  strpos($deviceName, ";", (strlen($arr_hs_manu[$i])-1));
						$deviceName = substr($deviceName,0,$possition);
						$deviceName = str_replace(" ","",$deviceName);
						if(strpos($deviceName,"/")){
							$deviceName = explode("/",$deviceName);
							$deviceName = $deviceName[0];
						}
					}
				}
				else
				{
					$deviceName = substr($deviceName,0,$possition);
				}
			}
			if(strlen($deviceName)>0)
			{
				// addded by sandeep -- 05 jun 2010
				$deviceName = str_replace(":","",$deviceName);
				$deviceName = str_replace(";","",$deviceName);
				$deviceName = str_replace(")","",$deviceName);
				$deviceName = str_replace("(","",$deviceName);
				$deviceName = str_replace("]","",$deviceName);
				$deviceName = str_replace("[","",$deviceName);
				$deviceName = str_replace("*","",$deviceName);
				$deviceName = str_replace(" ","",$deviceName);

				//very special case added for android handsets where 
				//the language parameter changes and as a result the 
				//user agent changes - Surin - 29 June 2010
				$lang_pos =  strpos($deviceName, "en-");
				if($lang_pos)
				{
					$subs_var = substr($deviceName, $lang_pos, 5);
					$deviceName = str_replace($subs_var, 'en-xx', $deviceName);
				}
				
				return str_replace(" ","",$deviceName);
				break;
			}
		}
		
		//added by surin - 31 May 2010 - for devices with improper
		//ua profs and no user agents
		if(strlen($deviceName) == 0)
		{
			$deviceName = str_replace(" ","",$mystring);
			$deviceName = str_replace("/","-",$deviceName);
		}
		
		$deviceName = str_replace(":","",$deviceName);
		$deviceName = str_replace(";","",$deviceName);
		$deviceName = str_replace(")","",$deviceName);
		$deviceName = str_replace("(","",$deviceName);
		$deviceName = str_replace("]","",$deviceName);
		$deviceName = str_replace("[","",$deviceName);
		$deviceName = str_replace("*","",$deviceName);
		$deviceName = str_replace(" ","",$deviceName);
		
		return $deviceName;
	}
?>
