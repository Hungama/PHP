<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
$user_id=$_SESSION['loginId'];
$msg_id=$_REQUEST['msg_id'];
$logPath="logs/MsgdeleteRequest_".date('Ymd').".txt";
$sql_message_log="INSERT INTO Inhouse_IVR.tbl_smskci_serviceMsgDetails_log (msg_id, S_id, msg_type, msg_desc,added_on,added_by,status,operator,circle,ip,lastModifyOn,kci_type,priority) 
SELECT msg_id, S_id, msg_type, msg_desc,added_on,added_by,status,operator,circle,ip,lastModifyOn,kci_type,priority from Inhouse_IVR.tbl_smskci_serviceMsgDetails where msg_id='".$msg_id."'";
if(mysql_query($sql_message_log,$dbConn))
{
			$sql_message_delete="delete from Inhouse_IVR.tbl_smskci_serviceMsgDetails where msg_id='".$msg_id."'";
			if(mysql_query($sql_message_delete,$dbConn))
			{
		$sql_message_type=mysql_query("select kci_type from Inhouse_IVR.tbl_smskci_serviceMsgDetails_log where msg_id='".$msg_id."'",$dbConn);
		list($kcitype)=mysql_fetch_array($sql_message_type);
		
			$sql_message_info="Update Inhouse_IVR.tbl_smskci_serviceMsgDetails_log set lastModifyOn=now(),status=0 where msg_id='".$msg_id."'";
			if(mysql_query($sql_message_info,$dbConn))
			echo $kcitype;
			else
			echo 'NOK';
			}

}
else
{
echo 'NOK';
}
$logData=$user_id."#".$msg_id."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);
mysql_close($dbConn);
?>