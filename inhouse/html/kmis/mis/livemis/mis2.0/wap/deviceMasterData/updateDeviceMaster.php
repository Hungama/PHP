<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbcon/db_218.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
//$view_date1='2014-11-20';
echo $view_date1;


$get_ldr_SubData = "select device_browser from mis_db.tbl_device_browser nolock where date(addedon)='" . $view_date1 . "' and servicename = 'UninorWAP' order by device_browser desc limit 2";
$query1 = mysql_query($get_ldr_SubData, $dbConn212) or die(mysql_error());
$numRows = mysql_num_rows($query1);

if ($numRows > 0)
{
	while ($useragent_data = mysql_fetch_array($query1))
	{ 
	    $useragent=trim($useragent_data['device_browser']);
		
		if($useragent)
		{	
         
          $ua=urlencode($useragent);
		  
          $getInfoUrl="http://192.168.100.212/kmis/mis/waplog/core-device/detect-device/detect-process/getdeviceinfo.php";
          $getInfoUrl.="?ua=$ua";
          $result=curl_init($getInfoUrl);
          curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
          $res= curl_exec($result);
          curl_close($result);
          $deviceinfo=explode("@@",$res);
		  
		  $device_screen = explode("*", $deviceinfo[3]);
		  $height = $device_screen[0];
		  $width = $device_screen[1];
		  $ds = $width.'*'.$height;
		  
		  $device_model = explode(" ", $deviceinfo[0]);
		  $dm= $device_model[0]." ";
		  $device_mod = ltrim($deviceinfo[0],$dm);
		 
		 
          //print_r($deviceinfo);
          //devicemodel@@deviceos@@devicebrowser@@devicescreen
		    $md_data = md5($useragent);
			
		   $get_device_SubData = "select md5_browser,device_browser from misdata.tbl_device_master nolock where md5_browser='".$md_data."'";
		   $query2 = mysql_query($get_device_SubData, $LivdbConn) or die(mysql_error());
		   $numRows_device = mysql_num_rows($query2);
		   
			if($numRows_device == 0)
			{    
			     
				//If md5_browser not exist in devicemaster Insert the data in devicemaster
				$insertquery = "insert into misdata.tbl_device_master(md5_browser,device_browser,device_model,device_os,device_screen,device_manufacturer) values('".$md_data."','".$useragent."','".$device_mod."','".trim($deviceinfo[1])."','".$ds."','".trim($deviceinfo[4])."')";
				$insert_result = mysql_query($insertquery, $LivdbConn) or die(mysql_error());
			    
			}
			elseif($numRows_device == 1)
			{
			    //if md5_browser exist with single entry update the data
				
				$updatequery = "update misdata.tbl_device_master set device_browser='".$useragent."', device_model='".$device_mod."',device_os='".trim($deviceinfo[1])."',device_screen='".$ds."',device_manufacturer='".trim($deviceinfo[4])."' where md5_browser='".$md_data."'";
						$update_result = mysql_query($updatequery, $LivdbConn) or die(mysql_error());
						
					
						
					
				
			}
			elseif($numRows_device>1)
			{
				//delete the old md5_browser & insert the new data
				
             $delete_md5_data ="delete from misdata.tbl_device_master where md5_browser='".$md_data."'";
              $deletequery = mysql_query($delete_md5_data, $LivdbConn) or die(mysql_error());
              $insertquery = "insert into misdata.tbl_device_master(md5_browser,device_browser,device_model,device_os,device_screen,device_manufacturer) values('".$md_data."','".$useragent."','".$device_mod."','".trim($deviceinfo[1])."','".$ds."','".trim($deviceinfo[4])."')";
				$insert_result = mysql_query($insertquery, $LivdbConn) or die(mysql_error());
				
				
			 
			}	
           
		}
	}
}

mysql_close($dbConn212);
mysql_close($LivdbConn);

?>