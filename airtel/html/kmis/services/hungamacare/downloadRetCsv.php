<?php	
	include("config/dbConnect.php");
	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
	
	$viewDate=$_REQUEST['date'];
	$start=$_REQUEST['start'];
	$max=$_REQUEST['max'];
	
	$excellFile=$viewDate.".csv";
	$excellFilePath=$excellDirPath.$excellFile;

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$excellFile");
	
	//echo "Report Date,Msisdn,DNIS,Duration In Sec,Circle,Status"."\r\n";
	echo "Retailer MDN,Date of Referral,Refered MDN,Mode,Price,Circle,Status,Timestamp,Amount(till date),Days(from activation)"."\r\n";
	
	$query="select distinct(friendANI),ANI,referDate from master_db.tbl_refer_ussdData where date(referDate)='".$viewDate."' and service_id='1517' and referfrom='Retailer' limit $start, $max";
	$result1 = mysql_query($query);
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
	$billingArray = array();
	$billingArray1 = array();

	while($row=mysql_fetch_array($result1)) {
		$billingArray[]=$row['friendANI'];
	}

	$query1= mysql_query("select sum(aa) 'chrg',m from ( select sum(chrg_amount) 'aa' ,msisdn 'm' from master_db.tbl_billing_success where msisdn in (".implode(',',$billingArray).") and service_id='1517' and mode='RET' group by msisdn union select sum(chrg_amount) 'aa',msisdn 'm' from master_db.tbl_billing_success_backup where msisdn in (".implode(',',$billingArray).") and service_id='1517' and mode='RET' group by msisdn)  a group by m");

	while($row1=mysql_fetch_array($query1)) {
		$ani=$row1['m'];
		$billingArray1[$ani]['chrg']=$row1['chrg'];
		$billingArray1[$ani]['status']=0;
	}
	//print_r($billingArray1);

if($num) { 
	while(list($referANI,$retailerANI,$datetime) = mysql_fetch_array($result)) { 
		$getCircle = "select master_db.getCircle(".trim($referANI).") as circle";
		$circle1=mysql_query($getCircle) or die( mysql_error() );
		while($row = mysql_fetch_array($circle1)) {
			$circle = $row['circle'];
		}
		if(!$circle) { $circle='UND'; }
		
		$subQuery = mysql_query("SELECT SUB_DATE,STATUS,MODE_OF_SUB,chrg_amount,circle,datediff(RENEW_DATE,SUB_DATE) as diff FROM airtel_SPKENG.tbl_spkeng_subscription WHERE date(SUB_DATE)>='".$viewDate."' and MODE_OF_SUB='RET' AND ANI='".$referANI."'");
		list($subDate,$status,$modeOfSub,$chrg_amount,$circle1,$diff)=mysql_fetch_array($subQuery);

		$chkStatus=1;
		if($status==1 || $status==11) { 
			$statusValue="Subscribed";
			$chkStatus=1;
		} else { 
			$statusValue="Not Subscribed";
			$chkStatus=0;
		}
		if(!$subDate) $statusUser=0;
		else $statusUser=1;		

		echo $retailerANI.",".$datetime.",".$referANI.",RET,5,".$circle.",".$statusValue.",";
		if($chkStatus==1) { 
			echo $subDate.",";
			if($billingArray1[$referANI]['status']==0 && $billingArray1[$referANI]['chrg']) {
				echo $billingArray1[$referANI]['chrg'].","; 
				$billingArray1[$referANI]['status']=1; 
			  } else {
				echo "NA,";
			  }
			echo $diff;
		} else { 
			echo "NA"; 
		} 
		echo "\n"; 
	}
}
//echo 'file create1d' ;
header("Pragma: no-cache");
header("Expires: 0");

?>
