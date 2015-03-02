<?php
error_reporting(1);
//require_once("../../../../db.php");
require_once("/var/www/html/hungamacare/db.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
if(isset($_REQUEST['date'])) { 
	$view_date= $_REQUEST['date'];
} else {
	$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
//echo $view_date= '2014-12-08';
$del="delete from Hungama_Tatasky.tbl_dailymisMitrExcelReport where Date='".$view_date."'";
$delquery = mysql_query($del,$con);
$mainarray=array();
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
foreach( $circle_info as $key=>$value)
{

$data=mysql_query("select Value as total,type,date,circle from Hungama_Tatasky.tbl_dailymisMitr 
where date='".$view_date."' and type in('CALLS_TF','CALLS_OBD','CALLS_OBD_UU','CALLS_OBD_SUCCESS'
,'MOU_TF','SEC_TF','ben','hin','tam','NotSel','CALLS_NEW_UU')and circle='".$key."' and IsMitr=0 order by type",$con);
while($extract=mysql_fetch_array($data))
{
$mainarray[$key][$extract['type']]=$extract['total'];
}
}
foreach($mainarray as $key=>$val)
{
$TotalMissedCallsReceived=0;
$TotalOBDsMade=0;
$TotalOBDsSuccessfull=0;
$TotalUniqueOBDs=0;
$TotalNewUser=0;
$TotalMinutesConsumed=0;
$TotalSecConsumed=0;
$AverageDuration_OBD=0;
$PeakCallingHour=0;
$dbCircle='';
$totalLangCount=0;
$total_ben=0;
$total_hin=0;
$total_tam=0;
$total_notsel=0;

$Hindi=0;$Bengali=0;$Tamil=0;$IsMitr=0;$CapsuleName='';
$service='EnterpriseTiscon';
$TotalMissedCallsReceived=$val['CALLS_TF'];
$TotalOBDsMade=$val['CALLS_OBD'];
$TotalOBDsSuccessfull=$val['CALLS_OBD_SUCCESS'];
$TotalUniqueOBDs=$val['CALLS_OBD_UU'];
$TotalNewUser=$val['CALLS_NEW_UU'];
$TotalMinutesConsumed=$val['MOU_TF'];
$TotalSecConsumed=$val['SEC_TF'];
$AverageDuration_OBD=0;
$dbCircle=$key;
$AverageDuration_OBD=ceil($TotalSecConsumed/$TotalOBDsSuccessfull);
//Peak hour data
$getPeakHour_OBD=mysql_query("select count(ANI) as totalcall,hour(date_time) from Hungama_Tatasky.tbl_tata_pushobd nolock where date(date_time)='".$view_date."' and ANI!='' and status!=0 and circle='".$dbCircle."' and IsMitr=0 group by hour(date_time) order by totalcall desc limit 1 ",$con);
list($PeakCallingCount,$PeakCallingHour) = mysql_fetch_array($getPeakHour_OBD); 
$total_ben=$val['ben'];
$total_hin=$val['hin'];
$total_tam=$val['tam'];
$total_notsel=$val['NotSel'];
//$totalLangCount=$total_ben+$total_hin+$total_tam;
$hin_percentage=$total_hin;
$ben_percentage=$total_ben;
$tam_percentage=$total_tam;
$notsel_percentage=$total_notsel;
$insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitrExcelReport(Date,Service,Circle,CapsuleName,TotalMissedCallsReceived,TotalOBDsMade,TotalOBDsSuccessfull,TotalUniqueOBDs,TotalMinutesConsumed,AverageDuration_OBD,PeakCallingHour,Hindi,Bengali,Tamil,IsMitr,NotSel,TotalNewUsers)
	values('".$view_date."' ,'".$service."','".$dbCircle."','".$CapsuleName."','".$TotalMissedCallsReceived."','".$TotalOBDsMade."','".$TotalOBDsSuccessfull."','".$TotalUniqueOBDs."','".$TotalMinutesConsumed."','".$AverageDuration_OBD."','".$PeakCallingHour."','".$hin_percentage."','".$ben_percentage."','".$tam_percentage."','".$IsMitr."','".$notsel_percentage."','".$TotalNewUser."')";
    mysql_query($insert_data, $con);
}

/*******************************************************************************/
/////////////////////mitr datastart here
$mainarray='';
$mainarray=array();
foreach( $circle_info as $key=>$value)
{

$data=mysql_query("select Value as total,type,date,circle from Hungama_Tatasky.tbl_dailymisMitr 
where date='".$view_date."' and type in('CALLS_TF','CALLS_OBD','CALLS_OBD_UU','CALLS_OBD_SUCCESS'
,'MOU_TF','SEC_TF','ben','hin','tam','NotSel','CALLS_NEW_UU')and circle='".$key."' and IsMitr=1 order by type",$con);
while($extract=mysql_fetch_array($data))
{
$mainarray[$key][$extract['type']]=$extract['total'];
}
}
foreach($mainarray as $key=>$val)
{
$TotalMissedCallsReceived=0;
$TotalOBDsMade=0;
$TotalOBDsSuccessfull=0;
$TotalUniqueOBDs=0;
$TotalNewUser=0;
$TotalMinutesConsumed=0;
$TotalSecConsumed=0;
$AverageDuration_OBD=0;
$PeakCallingHour=0;
$dbCircle='';
$totalLangCount=0;
$total_ben=0;
$total_hin=0;
$total_tam=0;
$total_notsel=0;

$Hindi=0;$Bengali=0;$Tamil=0;$IsMitr=1;$CapsuleName='';
$service='EnterpriseTiscon';
$TotalMissedCallsReceived=$val['CALLS_TF'];
$TotalOBDsMade=$val['CALLS_OBD'];
$TotalOBDsSuccessfull=$val['CALLS_OBD_SUCCESS'];
$TotalUniqueOBDs=$val['CALLS_OBD_UU'];
$TotalNewUser=$val['CALLS_NEW_UU'];
$TotalMinutesConsumed=$val['MOU_TF'];
$TotalSecConsumed=$val['SEC_TF'];
$AverageDuration_OBD=0;
$dbCircle=$key;
$AverageDuration_OBD=ceil($TotalSecConsumed/$TotalOBDsSuccessfull);
//Peak hour data
$getPeakHour_OBD=mysql_query("select count(ANI) as totalcall,hour(date_time) from Hungama_Tatasky.tbl_tata_pushobd nolock where date(date_time)='".$view_date."' and ANI!='' and status!=0 and circle='".$dbCircle."' and IsMitr=1 group by hour(date_time) order by totalcall desc limit 1 ",$con);
list($PeakCallingCount,$PeakCallingHour) = mysql_fetch_array($getPeakHour_OBD); 
$total_ben=$val['ben'];
$total_hin=$val['hin'];
$total_tam=$val['tam'];
$total_notsel=$val['NotSel'];

$hin_percentage=$total_hin;
$ben_percentage=$total_ben;
$tam_percentage=$total_tam;
$notsel_percentage=$total_notsel;
$insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitrExcelReport(Date,Service,Circle,CapsuleName,TotalMissedCallsReceived,TotalOBDsMade,TotalOBDsSuccessfull,TotalUniqueOBDs,TotalMinutesConsumed,AverageDuration_OBD,PeakCallingHour,Hindi,Bengali,Tamil,IsMitr,NotSel,TotalNewUsers)
	values('".$view_date."' ,'".$service."','".$dbCircle."','".$CapsuleName."','".$TotalMissedCallsReceived."','".$TotalOBDsMade."','".$TotalOBDsSuccessfull."','".$TotalUniqueOBDs."','".$TotalMinutesConsumed."','".$AverageDuration_OBD."','".$PeakCallingHour."','".$hin_percentage."','".$ben_percentage."','".$tam_percentage."','".$IsMitr."','".$notsel_percentage."','".$TotalNewUser."')";
    mysql_query($insert_data, $con);
}
//end here
//Update campaign deatils
//update capsulename based on lang
$getCampaigName=mysql_query("SELECT campaignname,language
FROM Hungama_Tatasky.tbl_Campaigndetails where '".$view_date."' between date(startdate) and date(enddate)",$con);


//while(list($campaigname,$camplang) = mysql_fetch_array($getCampaigName))
while($campgData = mysql_fetch_array($getCampaigName))
{
$campaigname='';
$camplang='';
$campaigname=$campgData['campaignname'];
$camplang=$campgData['language'];

	if($camplang=='ban' || $camplang=='ben')
	$langCond=" Circle='WBL' ";
	else if($camplang=='tam')
	$langCond=" Circle='TNU' ";
	else if($camplang=='hin')
	$langCond=" Circle not in('WBL','TNU') ";

	$updateCampInfo="update Hungama_Tatasky.tbl_dailymisMitrExcelReport set CapsuleName='".$campaigname."' where Date='".$view_date."' and $langCond ";
	mysql_query($updateCampInfo,$con);
	
}
echo "Done";
mysql_close($con);
?>
