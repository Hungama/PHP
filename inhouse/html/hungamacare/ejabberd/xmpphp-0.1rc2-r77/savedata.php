<?php
include('dbconfig.php');
$email=$_REQUEST['email'];
$keyword=$_REQUEST['keyword_search'];
$link_crbtid=mysql_real_escape_string($_REQUEST['search_result']);
$msisdn=$_REQUEST['msisdn'];
$sid=$_REQUEST['sid'];
$action=$_REQUEST['action'];
$search_result_menu=$_REQUEST['search_result_menu'];

//1- search  2-insert  3-update  4-delete/move
switch($action)
{
   case '1':
			//$sql_message_info=mysql_query("select status,search_result,search_result_menu from uninor_mu_chat where email='".$email."' and jabbersessionid='".$sid."'");
			$sql_message_info=mysql_query("select status,search_result,search_result_menu from uninor_mu_chat where email='".$email."'");
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
			$sql_message_info="INSERT INTO uninor_mu_chat (email,keyword_search,search_result,status,datetime,jabbersessionid,search_result_menu)
			VALUES ('".$email."','".$keyword."','".$link_crbtid."','1',now(),'".$sid."','".$search_result_menu."')";
			if(mysql_query($sql_message_info,$db_link))
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
		/*$sql_message_log=mysql_query("INSERT INTO uninor_mu_chat_log (id, email, jabbersessionid, keyword_search,search_result,search_response,msisdn,datetime,status,search_result_menu) 
SELECT id, email, jabbersessionid, keyword_search,search_result,search_response,msisdn,datetime,status,search_result_menu from uninor_mu_chat where email='".$email."' and jabbersessionid='".$sid."'");
*/
$sql_message_log=mysql_query("INSERT INTO uninor_mu_chat_log (id, email, jabbersessionid, keyword_search,search_result,search_response,msisdn,datetime,status,search_result_menu) 
SELECT id, email, jabbersessionid, keyword_search,search_result,search_response,msisdn,datetime,status,search_result_menu from uninor_mu_chat where email='".$email."'");
		
		//$sql_message_info="Update uninor_mu_chat set keyword_search='".$keyword."',search_result='".$link_crbtid."',status='1',search_response='',search_result_menu='".$search_result_menu."' where email='".$email."' and jabbersessionid='".$sid."'";
		$sql_message_info="Update uninor_mu_chat set keyword_search='".$keyword."',search_result='".$link_crbtid."',status='1',search_response='',search_result_menu='".$search_result_menu."' where email='".$email."'";
			if(mysql_query($sql_message_info,$db_link))
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
	//$sql_message_info="Update uninor_mu_chat set status='2',search_response='".$keyword."' where email='".$email."' and jabbersessionid='".$sid."'";
	$sql_message_info="Update uninor_mu_chat set status='2',search_response='".$keyword."' where email='".$email."'";
			if(mysql_query($sql_message_info,$db_link))
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
	//$sql_message_info="Update uninor_mu_chat set status='3',msisdn='".$msisdn."' where email='".$email."' and jabbersessionid='".$sid."'";
	$sql_message_info="Update uninor_mu_chat set status='3',msisdn='".$msisdn."' where email='".$email."'";
			if(mysql_query($sql_message_info,$db_link))
				{
				echo 'OK';
				//$sql_crbt_info=mysql_query("select search_result,search_response from uninor_mu_chat where email='".$email."' and jabbersessionid='".$sid."'");
			$sql_crbt_info=mysql_query("select search_result,search_response from uninor_mu_chat where email='".$email."'");
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
				 $logPath_crbt = "logs/crbt/subscription_".$curdate.".txt";
	$setcrbt="http://localhost/ejabberd/xmpphp-0.1rc2-r77/request_crbt_jabber.php?msisdn=$msisdn&Onmobile_CRBT=$contentid&CRBT_ID=$contentid1";
$final_crbt_response = file_get_contents($setcrbt);	
		$response_crbt="CRBTURL#".$setcrbt."#Response#".$final_crbt_response."\r\n";
		error_log($response_crbt,3,$logPath_crbt);	
			 }
			 
			 //move current log session to log table finish session here
$sql_move_session=mysql_query("INSERT INTO uninor_mu_chat_log (id, email, jabbersessionid, keyword_search,search_result,search_response,msisdn,datetime,status,search_result_menu) 
SELECT id, email, jabbersessionid, keyword_search,search_result,search_response,msisdn,datetime,status,search_result_menu from uninor_mu_chat where email='".$email."'");
$sql_delete_session=mysql_query("delete from uninor_mu_chat where email='".$email."'");
	}
				else
				{
				echo 'NOK';
				}
		break;
		
		  case '6':
		  //validate mobile number
			//$sql_message_info=mysql_query("select status from uninor_mu_chat where email='".$email."' and jabbersessionid='".$sid."'");
		$sql_message_info=mysql_query("select status,search_result_menu,search_response from uninor_mu_chat where email='".$email."'");
			$num=mysql_num_rows($sql_message_info);
			if($num>=1)
				{
				$row = mysql_fetch_array($sql_message_info);
$keyword=$row['search_response'];
$pieces = explode('*', $row['search_result_menu']);
$rtname_details = explode('-', $pieces[$keyword-1]);

				echo $row['status'].'|'.$rtname_details[1];
			//echo $row['status'];
				}
				else
				{
				echo 'NOK';
				}
		break;
		break;
}
		mysql_close($db_link);
?>