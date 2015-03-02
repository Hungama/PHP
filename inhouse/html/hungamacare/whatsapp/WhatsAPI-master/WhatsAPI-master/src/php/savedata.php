<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$ANI=$_REQUEST['ANI'];
$keyword=$_REQUEST['keyword_search'];
$link_crbtid=mysql_escape_string($_REQUEST['search_result']);
$action=$_REQUEST['action'];
$msisdn=$_REQUEST['msisdn'];
$search_result_menu=$_REQUEST['search_result_menu'];
$table1='Inhouse_tmp.whatsappchat';
$table2='Inhouse_tmp.whatsappchat_log';
//1- search  2-insert  3-update  4-delete/move
switch($action)
{
   case '1':
			$sql_message_info=mysql_query("select status,search_result,search_result_menu from $table1 where ANI='".$ANI."'",$dbConn);
			$num=mysql_num_rows($sql_message_info);
			if($num>=1)
				{
				$row = mysql_fetch_array($sql_message_info);
$pieces = explode('*', $row['search_result_menu']);
$rtname_details = explode('-', $pieces[$keyword-1]);
				echo 'OK'.'|'.$rtname_details[1];
				}
				else
				{
				echo 'NOK';
				}
		break;
	case '2':
			$sql_message_info="INSERT INTO $table1 (ANI,keyword_search,search_result,status,datetime,search_result_menu)
			VALUES ('".$ANI."','".$keyword."','".$link_crbtid."','1',now(),'".$search_result_menu."')";
			if(mysql_query($sql_message_info,$dbConn))
			{
			echo 'OK';
			}
			else
			{
			echo 'NOK';
			}
		break;
		case '3':
		//take back of old search data and then update it
	$sql_message_log=mysql_query("INSERT INTO $table2 (id, ANI,keyword_search,search_result,search_response,datetime,status,search_result_menu,msisdn) 
SELECT id, ANI, keyword_search,search_result,search_response,datetime,status,search_result_menu,msisdn from $table1 where ANI='".$ANI."'",$dbConn);
		
		$sql_message_info="Update $table1 set keyword_search='".$keyword."',search_result='".$link_crbtid."',status='1',search_response='',search_result_menu='".$search_result_menu."' where ANI='".$ANI."'";
			if(mysql_query($sql_message_info,$dbConn))
				{
				echo 'OK';
				}
				else
				{
				echo 'NOK';
				}
	break;
	case '4':
		//take back of old search data and then update it
		$sql_message_info="Update $table1 set status='2',search_response='".$keyword."' where ANI='".$ANI."'";
			if(mysql_query($sql_message_info,$dbConn))
				{
				echo 'OK';
				}
				else
				{
				echo 'NOK';
				}
		break;
		case '5':
		//take mobile no for crbt request
	$sql_message_info="Update $table1 set status='3' , msisdn='".$msisdn."' where ANI='".$ANI."'";
			if(mysql_query($sql_message_info,$dbConn))
				{
				echo 'OK';				
			$sql_crbt_info=mysql_query("select search_result,search_response from $table1 where ANI='".$ANI."'",$dbConn);
			$num=mysql_num_rows($sql_crbt_info);
			if($num>=1)
				{
				$row = mysql_fetch_array($sql_crbt_info);
				$cid=$row['search_response']-1;
				$crbtid_name=explode('|',$row['search_result']);
			
		$maincontentid=$crbtid_name[$cid];
			$crbtid_main=explode('-',$maincontentid);
				$contentid=$crbtid_main[0];
				$contentid1=$crbtid_main[1];
				//call api to set CRBT set
				 $curdate = date("Y-m-d");
				 $logPath_crbt = "/var/www/html/hungamacare/whatsapp/logs/crbt_subscription_".$curdate.".txt";
				 
	$setcrbt="http://localhost/ejabberd/xmpphp-0.1rc2-r77/request_crbt_jabber.php?msisdn=$msisdn&Onmobile_CRBT=$contentid&CRBT_ID=$contentid1";
//$final_crbt_response = file_get_contents($setcrbt);	
		$response_crbt="CRBTURL#".$setcrbt."#Response#".$final_crbt_response."\r\n";
		error_log($response_crbt,3,$logPath_crbt);	
			 }
			 
			 //move current log session to log table finish session here
$sql_move_session=mysql_query("INSERT INTO $table2 (id, ANI,keyword_search,search_result,search_response,datetime,status,search_result_menu,msisdn) 
SELECT id, ANI,keyword_search,search_result,search_response,datetime,status,search_result_menu,msisdn from $table1 where ANI='".$ANI."'",$dbConn);
$sql_delete_session=mysql_query("delete from $table1 where ANI='".$ANI."'",$dbConn);
	}
				else
				{
				echo 'NOK';
				}
		break;
		
		  case '6':
		  //validate mobile number			
		$sql_message_info=mysql_query("select status,search_result_menu,search_response from $table1 where ANI='".$ANI."'",$dbConn);
			$num=mysql_num_rows($sql_message_info);
			if($num>=1)
				{
				$row = mysql_fetch_array($sql_message_info);
$keyword=$row['search_response'];
$pieces = explode('*', $row['search_result_menu']);
$rtname_details = explode('-', $pieces[$keyword-1]);

				echo $row['status'].'|'.$rtname_details[1];
				}
				else
				{
				echo 'NOK';
				}
		break;
}
mysql_close($dbConn);
?>