<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$activeDir="/var/www/html/kmis/mis/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

$view_date1='2013-10-06';
$fileDate='20131006';
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');


////////////////////////////////////////////////////Start Airtel SE //////////////////////////////////////////////////////////////////////////
/*
$airtelSEFile="1502/AirtelSE_".$fileDate.".txt";
$airtelSEFilePath=$activeDir.$airtelSEFile;

	//unlink($airtelSEFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelSE' and status='Active' ";
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelSE' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	$delquery = mysql_query($del1,$dbConnAirtel);
	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$airtelSEFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump16,$LivdbConn);
	
	$insertDump161= 'LOAD DATA LOCAL INFILE "'.$airtelSEFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump161,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel SE //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel MTV//////////////////////////////////////////////////////////////////////////

$airtelMTVFile="1503/MTVAirtel_".$fileDate.".txt";
$airtelMTVFilePath=$activeDir.$airtelMTVFile;


//	unlink($airtelMTVFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVAirtel' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='MTVAirtel' and status='Active' ";
$delquery = mysql_query($del1,$dbConnAirtel);


	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$airtelMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$LivdbConn);
	$insertDump71= 'LOAD DATA LOCAL INFILE "'.$airtelMTVFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump71,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel MTV//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Docomo 54646//////////////////////////////////////////////////////////////////////////

$airtel54646File="1502/Airtel54646_".$fileDate.".txt";
$airtel54646FilePath=$activeDir.$airtel54646File;


//	unlink($airtel54646FilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='Airtel54646' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='Airtel54646' and status='Active' ";
$delquery = mysql_query($del1,$dbConnAirtel);

	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$airtel54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump8,$LivdbConn);
	$insertDump81= 'LOAD DATA LOCAL INFILE "'.$airtel54646FilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump81,$dbConnAirtel);

//////////////////////////////////////////////////// End airtel 54646//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel Devotional//////////////////////////////////////////////////////////////////////////

$airtelDevoFile="1510/AirtelDevo_".$fileDate.".txt";
$airtelDevoFilePath=$activeDir.$airtelDevoFile;


//	unlink($airtelDevoFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelDevo' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelDevo' and status='Active' ";
$delquery = mysql_query($del1,$dbConnAirtel);


	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$airtelDevoFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);
	$insertDump91= 'LOAD DATA LOCAL INFILE "'.$airtelDevoFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump91,$dbConnAirtel);

//////////////////////////////////////////////////// End airtel Devo//////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Docomo Ria//////////////////////////////////////////////////////////////////////////

$airtelRIAFile="1509/RIAAirtel".$fileDate.".txt";
$airtelRIAFilePath=$activeDir.$airtelRIAFile;


//	unlink($airtelRIAFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RIAAirtel' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='RIAAirtel' and status='Active' ";
$delquery = mysql_query($del1,$dbConnAirtel);

	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$airtelRIAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump10,$LivdbConn);
	$insertDump101= 'LOAD DATA LOCAL INFILE "'.$airtelRIAFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump101,$dbConnAirtel);

//////////////////////////////////////////////////// End airtel Redfm//////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Airtel ENDLESS//////////////////////////////////////////////////////////////////////////
*/
$airtelEndFile="1502/AirtelEU_".$fileDate.".txt";
$airtelENDFilePath=$activeDir.$airtelEndFile;


//	unlink($airtelENDFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelEU' and status='Active' ";
	//$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelEU' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);
	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$airtelENDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		//mysql_query($insertDump11,$LivdbConn);
	$insertDump111= 'LOAD DATA LOCAL INFILE "'.$airtelENDFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump111,$dbConnAirtel);

//////////////////////////////////////////////////// End airtel ENDLESS//////////////////////////////////////////////////////////////////////////

/*
////////////////////////////////////////////////////Start Airtel Rasoi //////////////////////////////////////////////////////////////////////////

$airtelRasoiFile="1511/AirtelGL_".$fileDate.".txt";
$airtelRasoiFilePath=$activeDir.$airtelRasoiFile;


//	unlink($airtelRasoiFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelGL' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelGL' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);

	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$airtelRasoiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);
	$insertDump121= 'LOAD DATA LOCAL INFILE "'.$airtelRasoiFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump121,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel Rasoi //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel Comedy //////////////////////////////////////////////////////////////////////////

$airtelComedyFile="1502/AirtelComedy_".$fileDate.".txt";
$airtelComedyFilePath=$activeDir.$airtelComedyFile;


	//unlink($airtelComedyFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelComedy' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelComedy' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);


	$insertDump13= 'LOAD DATA LOCAL INFILE "'.$airtelComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump13,$LivdbConn);
	$insertDump131= 'LOAD DATA LOCAL INFILE "'.$airtelComedyFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump131,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel Comedy //////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Airtel MND //////////////////////////////////////////////////////////////////////////

$airtelMNDFile="1502/AirtelMND_".$fileDate.".txt";
$airtelMNDFilePath=$activeDir.$airtelMNDFile;


//	unlink($airtelMNDFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelMND' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelMND' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);



	$insertDump14= 'LOAD DATA LOCAL INFILE "'.$airtelMNDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump14,$LivdbConn);
	$insertDump141= 'LOAD DATA LOCAL INFILE "'.$airtelMNDFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump141,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel MND //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel PD //////////////////////////////////////////////////////////////////////////

$airtelPDFile="1502/AirtelPD_".$fileDate.".txt";
$airtelPDFilePath=$activeDir.$airtelPDFile;


//	unlink($airtelPDFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelPD' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelPD' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);


	$insertDump15= 'LOAD DATA LOCAL INFILE "'.$airtelPDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump15,$LivdbConn);
	$insertDump151= 'LOAD DATA LOCAL INFILE "'.$airtelPDFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump151,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel PD //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel VH1 //////////////////////////////////////////////////////////////////////////

$airtelVH1File="1502/VH1Airtel_".$fileDate.".txt";
$airtelVH1FilePath=$activeDir.$airtelVH1File;


//	unlink($airtelVH1FilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='VH1Airtel' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='VH1Airtel' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);


	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$airtelVH1FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump16,$LivdbConn);
	$insertDump161= 'LOAD DATA LOCAL INFILE "'.$airtelVH1FilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump161,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel VH1 //////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////Start Airtel VH1 //////////////////////////////////////////////////////////////////////////

$airtelVH1NightFile="1502/VH1AirtelNight_".$fileDate.".txt";
$airtelVH1NightFilePath=$activeDir.$airtelVH1NightFile;


//	unlink($airtelVH1NightFilePath);
	//echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='VH1Airtel' and status='Active' ";
	//$delquery = mysql_query($del,$LivdbConn);

	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$airtelVH1NightFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump16,$LivdbConn);
	$insertDump161= 'LOAD DATA LOCAL INFILE "'.$airtelVH1NightFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump161,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel VH1 //////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Airtel PK //////////////////////////////////////////////////////////////////////////

$airtelPKFile="1502/AirtelPK_".$fileDate.".txt";
$airtelPKFilePath=$activeDir.$airtelPKFile;


//	unlink($airtelPKFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelPK' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelPK' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);


	$insertDump17= 'LOAD DATA LOCAL INFILE "'.$airtelPKFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump17,$LivdbConn);
	$insertDump171= 'LOAD DATA LOCAL INFILE "'.$airtelPKFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump171,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel PK //////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start AirtelRegKK //////////////////////////////////////////////////////////////////////////

$airtelRegKKFile="1502/airtelRegKK_".$fileDate.".txt";
$airtelRegKKFilePath=$activeDir.$airtelRegKKFile;


	//unlink($airtelRegKKFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='airtelRegKK' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='airtelRegKK' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);

	$insertDump18= 'LOAD DATA LOCAL INFILE "'.$airtelRegKKFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump18,$LivdbConn);
	$insertDump181= 'LOAD DATA LOCAL INFILE "'.$airtelRegKKFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump181,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel AirtelRegKK //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start AirtelRegTN //////////////////////////////////////////////////////////////////////////

$airtelRegTNFile="1502/airtelRegTN_".$fileDate.".txt";
$airtelRegTNFilePath=$activeDir.$airtelRegTNFile;


//	unlink($airtelRegTNFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='airtelRegTN' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='airtelRegTN' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);


	$insertDump181= 'LOAD DATA LOCAL INFILE "'.$airtelRegTNFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump181,$LivdbConn);
	$insertDump1812= 'LOAD DATA LOCAL INFILE "'.$airtelRegTNFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1812,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel airtelRegTN //////////////////////////////////////////////////////////////////////////3/10/2013


////////////////////////////////////////////////////Start Airtel MNDKK //////////////////////////////////////////////////////////////////////////

$AirtelMNDKKFile="1513/AirtelMNDKK_".$fileDate.".txt";
$AirtelMNDKKFilePath=$activeDir.$AirtelMNDKKFile;


//	unlink($AirtelMNDKKFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelMNDKK' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelMNDKK' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);

	$insertDump14= 'LOAD DATA LOCAL INFILE "'.$AirtelMNDKKFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump14,$LivdbConn);
	$insertDump141= 'LOAD DATA LOCAL INFILE "'.$AirtelMNDKKFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump141,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel MNDKK //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start SMSAirtelSex//////////////////////////////////////////////////////////////////////////

$SMSAirtelSexFile="1521/SMSAirtelSex_".$fileDate.".txt";
$SMSAirtelSexFilePath=$activeDir.$SMSAirtelSexFile;


//	unlink($SMSAirtelSexFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='SMSAirtelSex' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='SMSAirtelSex' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);


	$insertDump142= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelSexFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump142,$LivdbConn);
	$insertDump1421= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelSexFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1421,$dbConnAirtel);

//////////////////////////////////////////////////// End SMSAirtelSex//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start SMSAirtelVastu//////////////////////////////////////////////////////////////////////////

$SMSAirtelVastuFile="1521/SMSAirtelVastu_".$fileDate.".txt";
$SMSAirtelVastuFilePath=$activeDir.$SMSAirtelVastuFile;


//	unlink($SMSAirtelVastuFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='SMSAirtelVastu' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='SMSAirtelVastu' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);

	$insertDump143= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelVastuFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump143,$LivdbConn);
	$insertDump1431= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelVastuFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1431,$dbConnAirtel);

//////////////////////////////////////////////////// End SMSAirtelVastu//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start SMSAirtelAstro//////////////////////////////////////////////////////////////////////////

$SMSAirtelAstroFile="1521/SMSAirtelAstro_".$fileDate.".txt";
$SMSAirtelAstroFilePath=$activeDir.$SMSAirtelAstroFile;


//	unlink($SMSAirtelAstroFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='SMSAirtelAstro' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='SMSAirtelAstro' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);

	$insertDump144= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelAstroFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump144,$LivdbConn);
	$insertDump1441= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelAstroFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1441,$dbConnAirtel);

//////////////////////////////////////////////////// End SMSAirtelAstro//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////
*/
echo "done";
mysql_close($dbConnAirtel);
mysql_close($LivdbConn);
?>
