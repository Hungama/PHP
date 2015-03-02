<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
$user_id=$_SESSION['loginId'];
$msgid=$_REQUEST['msg_id'];
$message=trim($_REQUEST['value']);
$logPath="logs/MsgChangeRequest_".date('Ymd').".txt";

$sql_message_log="INSERT INTO Inhouse_IVR.tbl_smskci_serviceMsgDetails_log (msg_id, S_id, msg_type, msg_desc,added_on,added_by,status,operator,circle,ip,lastModifyOn,kci_type,priority) 
SELECT msg_id, S_id, msg_type, msg_desc,added_on,added_by,status,operator,circle,ip,lastModifyOn,kci_type,priority from Inhouse_IVR.tbl_smskci_serviceMsgDetails where msg_id='".$msgid."'";
$logData=$user_id."#".$msgid."#".$message."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);
if(mysql_query($sql_message_log,$dbConn))
{
			$sql_message_info="Update Inhouse_IVR.tbl_smskci_serviceMsgDetails set msg_desc='".$message."',lastModifyOn=now() where msg_id='".$msgid."'";
			//$logData=$user_id."#".$msgid."#".$message."#".$sql_message_info."#".date("Y-m-d H:i:s")."\n";
			//error_log($logData,3,$logPath);
			if(mysql_query($sql_message_info,$dbConn))
			{
			echo 'OK';
			}
			else
			{
			echo 'NOK';
			}

}
else
{
echo 'NOK';
}

mysql_close($dbConn);
?>