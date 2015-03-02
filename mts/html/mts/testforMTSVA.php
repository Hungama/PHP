<?php 
$aniArray = array();

echo "Conn: ".$conn = mysql_pconnect("10.130.14.106","billing","billing");

for($i=0;$i<count($aniArray);$i++) {
	$msisdn=trim($aniArray[$i]);

	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle) or die( mysql_error() );
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }

	if($circle=='KAR' || $circle='KER' || $circle='TNU' || $circle='APD' || $circle='RAJ' || $circle='WBL' || $circle='KOL') { 	
		$cat1="3";
		$cat2="7";
	} elseif($circle=='MAH' || $circle='MUM' || $circle='GUJ') { 	
		$cat1="7";
		$cat2="10";
	} elseif($circle=='DEL' || $circle='HAY' || $circle='HAR' || $circle='UPW' || $circle='UPE' ) { 	
		$cat1="4";
		$cat2="7";
	} elseif($circle=='BIH') { 	
		$cat1="3";
		$cat2="2";
	} else {
		$cat1="3";
		$cat2="2";
	}

	echo "<br/>".$insertQuery="insert into mts_voicealert.tbl_voice_category values ('".$msisdn."', NOW(), NOW(), '01', 0, 'IVR', '54444', 0, 0,'IVR-', '25','".$circle."','0','','','".$cat1."','0','')";
	mysql_query($insertQuery);
	echo "<br/>".$insertQuery1="insert into mts_voicealert.tbl_voice_category values ('".$msisdn."', NOW(),NOW(), '01', 0, 'IVR', '54444', 0, 0,'IVR-', '25','".$circle."','0','','','".$cat2."','0','')";
	mysql_query($insertQuery1);
}

?>