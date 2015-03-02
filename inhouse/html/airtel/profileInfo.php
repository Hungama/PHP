<?php
include("/var/www/html/kmis/services/hungamacare/config/db_airtel.php");
$msisdn = trim($_REQUEST['msisdn']);
$dob = trim($_REQUEST['dob']);
$username = trim($_REQUEST['username']);
$imgname = trim($_REQUEST['imgname']);
$action = trim($_REQUEST['action']);
$logPath = "/var/www/html/airtel/log/notification/profileManagement_" . date("Y-m-d") . ".txt";
$logData = $msisdn . "#" . $username."#" . $dob ."#" . $imgname ."#" . $action. "#" . date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);

if ($msisdn == '') {
    echo $response = "Incomplete Parameter";
    $logData = $msisdn . "#" . $contentid . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
    exit;
}

function checkmsisdn($msisdn, $abc) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            }
        }
    } else {
        echo "Invalid Parameter";
        exit;
    }
    return $msisdn;
}

if (is_numeric($msisdn)) {
    $msisdn = checkmsisdn(trim($msisdn), $abc);
	
	
	if($action=='set')
	{
	//Save profile data 
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle);
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }
	
		$selectData = "select ANI,User_Name,DOB,IMAGE_NAME from airtel_devo.tbl_devo_ProfileWap nolock where ani='".$msisdn."' and status=1";
		$result = mysql_query($selectData);
		$totalCount=mysql_num_rows($result);
		if($totalCount>=1)
		{
		//Update data
			$updateQry = "update airtel_devo.tbl_devo_ProfileWap set User_Name='".$username."',DOB='".$dob."',IMAGE_NAME='".$imgname."',LAST_UPDATE=now() where ANI='".$msisdn."'";
			if(mysql_query($updateQry))
				$response = "success";
			else
				$response = "failure";
		}
		else
		{
		$insQry = "insert into airtel_devo.tbl_devo_ProfileWap (ANI,User_Name,DOB,IMAGE_NAME,ADDED_ON,LAST_UPDATE,circle)
                values ('".$msisdn."','".$username."','".$dob."','".$imgname."',now(),now(),'".$circle."')";
			if(mysql_query($insQry))
				$response = "success";
			else
				$response = "failure";		
		}
	

	 
	echo $response;
	
	}
	else if($action=='get')
	{
	//Get profile data
		$selectData = "select ANI,User_Name,DOB,IMAGE_NAME from airtel_devo.tbl_devo_ProfileWap nolock where ani='".$msisdn."' and status=1";
		$result = mysql_query($selectData);
		$totalCount=mysql_num_rows($result);
		if($totalCount>=1)
		{
		list($ANI,$User_Name,$DOB,$IMAGE_NAME) = mysql_fetch_array($result);
			
			$response=$ANI."#".$User_Name."#".$DOB."#".$IMAGE_NAME;
		}
		else
		{
		$response ="No Record Found";
		}
		
		echo $response;
	}
	else
	{
	echo $response = "Invalid Request";
	}
    
} else {
    echo $response = "Invalid Parameter";
    $logData = $msisdn . "#" . $contentid . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
}

mysql_close($dbAirtelConn);
?>