<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
$today=date("Y-m-d");
$displaydate;
$dataarray=array();
$dwfilename='totalhulpromotional_content_'.$today.'.xls';
$dataheader[0]=array('Msisdn','Circle','Operator','CustomerName','Town','Verification','Mcard_dp','Mcard_rv','TalkTimeReceived','HUL_OBD_1','HUL_OBD_2','HUL_OBD_3','HUL_OBD_4','HUL_OBD_5','HUL_OBD_6','HUL_OBD_7','HUL_OBD_8','HUL_OBD_9','HUL_OBD_10','HUL_OBD_11','HUL_OBD_12','HUL_OBD_13','HUL_OBD_14','HUL_OBD_15','HUL_OBD_16','HUL_OBD_17','HUL_OBD_18','HUL_OBD_NEWYEAR','HUL_OBD_PONGAL','HUL_OBD_RAJNI');
$fp = fopen($dwfilename, 'w');
$sql_getmsisdnlist = mysql_query("select * from hul_hungama.tbl_hul_subdetails limit 970");
foreach ($dataheader as $fields_header) {
 fputcsv($fp, $fields_header, "\t", '"');
}
$m=1;
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
if(!empty($result_list['ANI']))
{

$cir = mysql_query("select master_db.getCircle('".$result_list['ANI']."') as circle");
$getcir = mysql_fetch_array($cir);

$optr = mysql_query("select master_db.getOperator('".$result_list['ANI']."') as operator");
$getoperator = mysql_fetch_array($optr);
$sql_getmdn_user_deatils = mysql_query("select b.customer_name as customer_name,b.town as town,b.verification_done as verification_done,b.memebership_card_dp as memebership_card_dp,b.memebership_card_rv as memebership_card_rv from newseleb_hungama.msdn_info as b where b.mobile_no='".$result_list['ANI']."'");
$result_mdn_user_deatils = mysql_fetch_array($sql_getmdn_user_deatils);
$sql_getmdn_recharge_deatils = mysql_query("select c.amount as amount from newseleb_hungama.tbl_mnd_recharge as c where c.mdn='".$result_list['ANI']."'");
$result_mdn_recharge_deatils = mysql_fetch_array($sql_getmdn_recharge_deatils);
//get obd deatils here for each msisdn 
  $fileData='';
$sql_getmsisdnobdlist = mysql_query("select count(*) as totalno, odb_name as odb_name,sum(duration) as duration,duration as obd_duration,date_time as obddate,error_code as error_code from hul_hungama.tbl_hulobd_success_fail_details where ANI='".$result_list['ANI']."' and service='HUL_PROMOTION' group by odb_name");

$totalobdrecord=mysql_num_rows($sql_getmsisdnobdlist);
	if($totalobdrecord>0)
{  
$i=0;
while($result_list_obd = mysql_fetch_array($sql_getmsisdnobdlist))
				{
				if(!empty($result_list_obd['duration'])) { $cmy='YES';} else {$cmy='NO';}
				if(!empty($result_list_obd['totalno'])) {$cmyF=$result_list_obd['totalno'];} else { $cmyF="--";}
				if(!empty($result_list_obd['duration'])) 
{

$avgvalue=$result_list_obd['duration']/$result_list_obd['totalno'];
$avgfrq=round($avgvalue, 0, PHP_ROUND_HALF_UP);
$atsc=$avgfrq;
} else {
$atsc="--";
}
    $sql_getlastheardobdlist = mysql_query("select duration as obd_duration,date_time as obddate from hul_hungama.tbl_hulobd_success_fail_details where ANI='".$result_list['ANI']."' and odb_name='".$result_list_obd['odb_name']."' and service='HUL_PROMOTION' and status IN(1,2) order by date_time desc limit 1");
	$result_list_obd_dur = mysql_fetch_array($sql_getlastheardobdlist);
	
        $fileData[$i]['odb_name'] = $result_list_obd['odb_name'];
		$fileData[$i]['cmy'] = $cmy;
		$fileData[$i]['cmyF'] = $cmyF;
		$fileData[$i]['atsc'] = $atsc;
		$fileData[$i]['obd_duration'] = $result_list_obd_dur['obd_duration'];
		$fileData[$i]['obddate'] = $result_list_obd_dur['obddate'];
		$fileData[$i]['error_code'] = $result_list_obd['error_code'];
		$i++;
}

}

$obd1=array();$obd2=array();$obd3=array();$obd4=array();$obd5=array();$obd6=array();$obd7=array();$obd8=array();$obd9=array();$obd10=array();
$obd11=array();$obd12=array();$obd13=array();$obd14=array();$obd15=array();$obd16=array();$obd17=array();$obd18=array();$obd19=array();$obd20=array();
$obd21=array();$obd22=array();$obd23=array();$HUL_OBD_NEWYEAR	=array();$HUL_OBD_PONGAL=array();$HUL_OBD_RAJNI=array();
foreach($fileData as $key=>$value) 
{
	switch($value['odb_name'])
{
	case 'HUL_OBD_1':
		$obd1[0] = $value['odb_name'];
		$obd1[1]=$value['cmy'];
		$obd1[2]=$value['cmyF'];
		$obd1[3]=$value['atsc'];
		$obd1[4]=$value['obd_duration'];
		$obd1[5]=$value['obddate'];
		$obd1[6]=$value['error_code'];
		break;
	case 'HUL_OBD_2':
		$obd2[0] = $value['odb_name'];
		$obd2[1]=$value['cmy'];
		$obd2[2]=$value['cmyF'];
		$obd2[3]=$value['atsc'];
		$obd2[4]=$value['obd_duration'];
		$obd2[5]=$value['obddate'];
		$obd2[6]=$value['error_code'];
		break;
		case 'HUL_OBD_3':
		$obd3[0] = $value['odb_name'];
		$obd3[1]=$value['cmy'];
		$obd3[2]=$value['cmyF'];
		$obd3[3]=$value['atsc'];
		$obd3[4]=$value['obd_duration'];
		$obd3[5]=$value['obddate'];
		$obd3[6]=$value['error_code'];
		break;
		case 'HUL_OBD_4':
		$obd4[0] = $value['odb_name'];
		$obd4[1]=$value['cmy'];
		$obd4[2]=$value['cmyF'];
		$obd4[3]=$value['atsc'];
		$obd4[4]=$value['obd_duration'];
		$obd4[5]=$value['obddate'];
		$obd4[6]=$value['error_code'];
		break;
		case 'HUL_OBD_5':
		$obd5[0] = $value['odb_name'];
		$obd5[1]=$value['cmy'];
		$obd5[2]=$value['cmyF'];
		$obd5[3]=$value['atsc'];
		$obd5[4]=$value['obd_duration'];
		$obd5[5]=$value['obddate'];
		$obd5[6]=$value['error_code'];
		break;
		case 'HUL_OBD_6':
		$obd6[0] = $value['odb_name'];
		$obd6[1]=$value['cmy'];
		$obd6[2]=$value['cmyF'];
		$obd6[3]=$value['atsc'];
		$obd6[4]=$value['obd_duration'];
		$obd6[5]=$value['obddate'];
		$obd6[6]=$value['error_code'];
		break;
		case 'HUL_OBD_7':
		$obd7[0] = $value['odb_name'];
		$obd7[1]=$value['cmy'];
		$obd7[2]=$value['cmyF'];
		$obd7[3]=$value['atsc'];
		$obd7[4]=$value['obd_duration'];
		$obd7[5]=$value['obddate'];
		$obd7[6]=$value['error_code'];
		break;
		case 'HUL_OBD_8':
		$obd8[0] = $value['odb_name'];
		$obd8[1]=$value['cmy'];
		$obd8[2]=$value['cmyF'];
		$obd8[3]=$value['atsc'];
		$obd8[4]=$value['obd_duration'];
		$obd8[5]=$value['obddate'];
		$obd8[6]=$value['error_code'];
		break;
		case 'HUL_OBD_9':
		$obd9[0] = $value['odb_name'];
		$obd9[1]=$value['cmy'];
		$obd9[2]=$value['cmyF'];
		$obd9[3]=$value['atsc'];
		$obd9[4]=$value['obd_duration'];
		$obd9[5]=$value['obddate'];
		$obd9[6]=$value['error_code'];
		break;
		case 'HUL_OBD_10':
		$obd10[0] = $value['odb_name'];
		$obd10[1]=$value['cmy'];
		$obd10[2]=$value['cmyF'];
		$obd10[3]=$value['atsc'];
		$obd10[4]=$value['obd_duration'];
		$obd10[5]=$value['obddate'];
		$obd10[6]=$value['error_code'];
		break;
		case 'HUL_OBD_11':
		$obd11[0] = $value['odb_name'];
		$obd11[1]=$value['cmy'];
		$obd11[2]=$value['cmyF'];
		$obd11[3]=$value['atsc'];
		$obd11[4]=$value['obd_duration'];
		$obd11[5]=$value['obddate'];
		$obd11[6]=$value['error_code'];
		break;
		case 'HUL_OBD_12':
		$obd12[0] = $value['odb_name'];
		$obd12[1]=$value['cmy'];
		$obd12[2]=$value['cmyF'];
		$obd12[3]=$value['atsc'];
		$obd12[4]=$value['obd_duration'];
		$obd12[5]=$value['obddate'];
		$obd12[6]=$value['error_code'];
		break;
		case 'HUL_OBD_13':
		$obd13[0] = $value['odb_name'];
		$obd13[1]=$value['cmy'];
		$obd13[2]=$value['cmyF'];
		$obd13[3]=$value['atsc'];
		$obd13[4]=$value['obd_duration'];
		$obd13[5]=$value['obddate'];
		$obd13[6]=$value['error_code'];
		break;
		case 'HUL_OBD_14':
		$obd14[0] = $value['odb_name'];
		$obd14[1]=$value['cmy'];
		$obd14[2]=$value['cmyF'];
		$obd14[3]=$value['atsc'];
		$obd14[4]=$value['obd_duration'];
		$obd14[5]=$value['obddate'];
		$obd14[6]=$value['error_code'];
		break;
		case 'HUL_OBD_15':
		$obd15[0] = $value['odb_name'];
		$obd15[1]=$value['cmy'];
		$obd15[2]=$value['cmyF'];
		$obd15[3]=$value['atsc'];
		$obd15[4]=$value['obd_duration'];
		$obd15[5]=$value['obddate'];
		$obd15[6]=$value['error_code'];
		break;
		case 'HUL_OBD_16':
		$obd16[0] = $value['odb_name'];
		$obd16[1]=$value['cmy'];
		$obd16[2]=$value['cmyF'];
		$obd16[3]=$value['atsc'];
		$obd16[4]=$value['obd_duration'];
		$obd16[5]=$value['obddate'];
		$obd16[6]=$value['error_code'];
		break;
		case 'HUL_OBD_17':
		$obd17[0] = $value['odb_name'];
		$obd17[1]=$value['cmy'];
		$obd17[2]=$value['cmyF'];
		$obd17[3]=$value['atsc'];
		$obd17[4]=$value['obd_duration'];
		$obd17[5]=$value['obddate'];
		$obd17[6]=$value['error_code'];
		break;
		case 'HUL_OBD_18':
		$obd18[0] = $value['odb_name'];
		$obd18[1]=$value['cmy'];
		$obd18[2]=$value['cmyF'];
		$obd18[3]=$value['atsc'];
		$obd18[4]=$value['obd_duration'];
		$obd18[5]=$value['obddate'];
		$obd18[6]=$value['error_code'];
		break;
		case 'HUL_OBD_NEWYEAR':
		$HUL_OBD_NEWYEAR[0] = $value['odb_name'];
		$HUL_OBD_NEWYEAR[1]=$value['cmy'];
		$HUL_OBD_NEWYEAR[2]=$value['cmyF'];
		$HUL_OBD_NEWYEAR[3]=$value['atsc'];
		$HUL_OBD_NEWYEAR[4]=$value['obd_duration'];
		$HUL_OBD_NEWYEAR[5]=$value['obddate'];
		$HUL_OBD_NEWYEAR[6]=$value['error_code'];
		break;
		case 'HUL_OBD_PONGAL':
		$HUL_OBD_PONGAL[0] = $value['odb_name'];
		$HUL_OBD_PONGAL[1]=$value['cmy'];
		$HUL_OBD_PONGAL[2]=$value['cmyF'];
		$HUL_OBD_PONGAL[3]=$value['atsc'];
		$HUL_OBD_PONGAL[4]=$value['obd_duration'];
		$HUL_OBD_PONGAL[5]=$value['obddate'];
		$HUL_OBD_PONGAL[6]=$value['error_code'];

		break;
		case 'HUL_OBD_RAJNI':
		$HUL_OBD_RAJNI[0] = $value['odb_name'];
		$HUL_OBD_RAJNI[1]=$value['cmy'];
		$HUL_OBD_RAJNI[2]=$value['cmyF'];
		$HUL_OBD_RAJNI[3]=$value['atsc'];
		$HUL_OBD_RAJNI[4]=$value['obd_duration'];
		$HUL_OBD_RAJNI[5]=$value['obddate'];
		$HUL_OBD_RAJNI[6]=$value['error_code'];
		break;
	
}
}
?>
<?php
//echo $m."**";
$ani=$result_list['ANI'];
if($getcir['circle']!='UND') {$operator_circle=$getcir['circle'];} else {$operator_circle= "--";};
if(!empty($result_list['operator'])) {$operator= $result_list['operator'];} else {$operator= "--";}
if(!empty($result_mdn_user_deatils['customer_name'])) {$customername=$result_mdn_user_deatils['customer_name'];} else {$customername ="--";} 
if(!empty($result_mdn_user_deatils['town'])) {$town=$result_mdn_user_deatils['town'];} else {$town="--";}
if(!empty($result_mdn_user_deatils['verification_done'])) {$verificationdone=$result_mdn_user_deatils['verification_done'];} 
else {$verificationdone="--";}
if(!empty($result_mdn_user_deatils['memebership_card_dp'])) {$membershipcard_dp=$result_mdn_user_deatils['memebership_card_dp'];} else {$membershipcard_dp="--";}
if(!empty($result_mdn_user_deatils['memebership_card_rv'])) {$membershipcard_rv=$result_mdn_user_deatils['memebership_card_rv'];} else {$membershipcard_rv="--";}
if(!empty($result_mdn_recharge_deatils['amount'])) { $amount='YES';} else {$amount='NO';}
if($obd1[0]=='HUL_OBD_1')
{
if($obd1[1]=='YES')
{
$ob1_data='CMA-'.$obd1[1].' Duration-'.$obd1[4].' Date & Time-'.$obd1[5];
}
else
{
$ob1_data=$obd1[6];
}
}
if($obd2[0]=='HUL_OBD_2')
{
if($obd2[1]=='YES')
{
$ob2_data='CMA-'.$obd2[1].' Duration-'.$obd2[4].' Date & Time-'.$obd2[5];
}
else
{
$ob2_data=$obd2[6];
}
}

if($obd3[0]=='HUL_OBD_3')
{

if($obd3[1]=='YES')
{
$ob3_data='CMA-'.$obd3[1].' Duration-'.$obd3[4].' Date & Time-'.$obd3[5];
}
else
{
$ob3_data=$obd3[6];
}
}
if($obd4[0]=='HUL_OBD_4')
{
if($obd4[1]=='YES')
{
$ob4_data='CMA-'.$obd4[1].' Duration-'.$obd4[4].' Date & Time-'.$obd4[5];
}
else
{
$ob4_data=$obd4[6];

}
}
if($obd5[0]=='HUL_OBD_5')
{
if($obd5[1]=='YES')
{
$ob5_data='CMA-'.$obd5[1].' Duration-'.$obd5[4].' Date & Time-'.$obd5[5];
}
else
{
$ob5_data=$obd5[6];
}
}
if($obd6[0]=='HUL_OBD_6')
{
if($obd6[1]=='YES')
{
$ob6_data='CMA-'.$obd6[1].' Duration-'.$obd6[4].' Date & Time-'.$obd6[5];
}
else
{
$ob6_data=$obd6[6];
}
}
if($obd7[0]=='HUL_OBD_7')
{
if($obd7[1]=='YES')
{
$ob7_data='CMA-'.$obd7[1].' Duration-'.$obd7[4].' Date & Time-'.$obd7[5];
}
else
{
$ob7_data=$obd7[6];
}
}
if($obd8[0]=='HUL_OBD_8')
{
if($obd8[1]=='YES')
{
$ob8_data='CMA-'.$obd8[1].' Duration-'.$obd8[4].' Date & Time-'.$obd8[5];
}
else
{
$ob8_data=$obd8[6];
}}
if($obd9[0]=='HUL_OBD_9')
{
if($ob9[1]=='YES')
{
$ob9_data='CMA-'.$obd9[1].' Duration-'.$obd9[4].' Date & Time-'.$obd9[5];
}
else
{
$ob9_data=$obd9[6];
}
}
if($obd10[0]=='HUL_OBD_10')
{
if($obd10[1]=='YES')
{
$ob10_data='CMA-'.$obd10[1].' Duration-'.$obd10[4].' Date & Time-'.$obd10[5];
}
else
{
$ob10_data=$obd10[6];
}
}
if($obd11[0]=='HUL_OBD_11')
{
if($obd11[1]=='YES')
{
$ob11_data='CMA-'.$obd11[1].' Duration-'.$obd11[4].' Date & Time-'.$obd11[5];
}
else
{
$ob11_data=$obd11[6];
}
}
if($obd12[0]=='HUL_OBD_12')
{
if($obd12[1]=='YES')
{
$ob12_data='CMA-'.$obd12[1].' Duration-'.$obd12[4].' Date & Time-'.$obd12[5];
}
else
{
$ob12_data=$obd12[6];
}
}

if($obd13[0]=='HUL_OBD_13')
{
if($obd13[1]=='YES')
{
$ob13_data='CMA-'.$obd13[1].' Duration-'.$obd13[4].' Date & Time-'.$obd13[5];
}
else
{
$ob13_data=$obd13[6];
}
}
if($obd14[0]=='HUL_OBD_14')
{
if($obd14[1]=='YES')
{
$ob14_data='CMA-'.$obd14[1].' Duration-'.$obd14[4].' Date & Time-'.$obd14[5];
}
else
{
$ob14_data=$obd14[6];
}
}
if($obd15[0]=='HUL_OBD_15')
{
if($obd15[1]=='YES')
{
$ob15_data='CMA-'.$obd15[1].' Duration-'.$obd15[4].' Date & Time-'.$obd15[5];
}
else
{
$ob15_data=$obd15[6];
}
}
if($obd16[0]=='HUL_OBD_16')
{
if($obd16[1]=='YES')
{
$ob16_data='CMA-'.$obd16[1].' Duration-'.$obd16[4].' Date & Time-'.$obd16[5];
}
else
{
$ob16_data=$obd16[6];
}
}
if($obd17[0]=='HUL_OBD_17')
{
if($obd17[1]=='YES')
{
$ob17_data='CMA-'.$obd17[1].' Duration-'.$obd17[4].' Date & Time-'.$obd17[5];
}
else
{
$ob17_data=$obd17[6];
}
}
if($obd18[0]=='HUL_OBD_18')
{
if($obd18[1]=='YES')
{
$ob18_data='CMA-'.$obd18[1].' Duration-'.$obd18[4].' Date & Time-'.$obd18[5];
}
else
{
$ob18_data=$obd18[6];
}
}
if($HUL_OBD_NEWYEAR[0]=='HUL_OBD_NEWYEAR')
{
if($HUL_OBD_NEWYEAR[1]=='YES')
{
$HUL_OBD_NEWYEAR_data='CMA-'.$HUL_OBD_NEWYEAR[1].' Duration-'.$HUL_OBD_NEWYEAR[4].' Date & Time-'.$HUL_OBD_NEWYEAR[5];
}
else
{
$HUL_OBD_NEWYEAR_data=$HUL_OBD_NEWYEAR[6];
}
}
if($HUL_OBD_PONGAL[0]=='HUL_OBD_PONGAL')
{
if($HUL_OBD_PONGAL[1]=='YES')
{
$HUL_OBD_PONGAL_data='CMA-'.$HUL_OBD_PONGAL[1].' Duration-'.$HUL_OBD_PONGAL[4].' Date & Time-'.$HUL_OBD_PONGAL[5];
}
else
{
$HUL_OBD_PONGAL_data=$HUL_OBD_PONGAL[6];
}
}
if($HUL_OBD_RAJNI[0]=='HUL_OBD_RAJNI')
{
if($HUL_OBD_RAJNI[1]=='YES')
{
$HUL_OBD_RAJNI_data='CMA-'.$HUL_OBD_RAJNI[1].' Duration-'.$HUL_OBD_RAJNI[4].' Date & Time-'.$HUL_OBD_RAJNI[5];
}
else
{
$HUL_OBD_RAJNI_data=$HUL_OBD_RAJNI[6];
}
}
$data[0]=array($ani,$operator_circle,$operator,$customername,$town,$verificationdone,$membershipcard_dp,$membershipcard_rv,$amount,$ob1_data,$ob2_data,$ob3_data,$ob4_data,$ob5_data,$ob6_data,$ob7_data,$ob8_data,$ob9_data,$ob10_data,$ob11_data,$ob12_data,$ob13_data,$ob14_data,$ob15_data,$ob16_data,$ob17_data,$ob18_data,$HUL_OBD_NEWYEAR_data,$HUL_OBD_PONGAL_data,$HUL_OBD_RAJNI_data);
//echo 'ANI'.$ani."**CIR**".$operator_circle."*OPE*".$operator."*NAme**".$customername."**twn".$town."*VerIDONE*".$verificationdone."*MEM_RV*".$membershipcard_rv."*AMOUT*".$amount."*OBD1*".$ob1_data."*OBD2*".$ob2_data."*OBD3*".$ob3_data."*OBD4*".$ob4_data."*OBD5*".$ob5_data."*OBD6*".$ob6_data."**".$ob7_data."**".$ob8_data."**".$ob9_data."**".$ob10_data."**".$ob11_data."**".$ob12_data."**".$ob13_data."**".$ob14_data."**".$ob15_data."**".$ob16_data."**".$ob17_data."**".$ob18_data."**".$HUL_OBD_NEWYEAR_data."**".$HUL_OBD_PONGAL_data."**".$HUL_OBD_RAJNI_data;
foreach ($data as $fields) {
  fputcsv($fp, $fields, "\t", '"');
}
}
$m++;
}
//close database connection
mysql_close($con);

fclose($fp);

$file = $dwfilename;
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: application/csv");
// tell file size
header('Content-length: '.filesize($file));
// set file name
header('Content-disposition: attachment; filename='.basename($file));
readfile($file);

?>