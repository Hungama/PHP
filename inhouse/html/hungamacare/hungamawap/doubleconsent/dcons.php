<?php
error_reporting(0);
$logdate=date("Ymd");
$msisdn=8587800665;
		$CPPID='HUN0046028';
			$planid=266;

		$PMARKNAME=urlencode('Lifestyle Dressing Room');
		$PRICE=500; //500
		$SE='HUNGAMA';
		$PD=urlencode('Lifestyle Dressing Room');
		$SCODE='NA';
                    $PRODTYPE='sub';
                    $REQ_TYPE='Subcription';
		$succUrl=urlencode("http://117.239.178.108/hungamawap/uninorldr/doubleconsent/Successldr.php?afid=$afid&zoneid=$zoneid&circle=$circle&content_id=$contentID&");
		$failureUrl=urlencode("http://117.239.178.108/hungamawap/uninorldr/doubleconsent/Failldr.php?afid=$afid&zoneid=$zoneid&circle=$circle&content_id=$contentID&");
	        
$dUrl  ="http://180.178.28.63:7001/ConsentGateway?REQ_TYPE=".$REQ_TYPE."&CP=Hungama&MSISDN=".$msisdn;
$dUrl .="&CPPID=".$CPPID."&PRODTYPE=".$PRODTYPE."&PMARKNAME=".$PMARKNAME."&PRICE=".$PRICE."&SE=".$SE."&CPTID=".date('Ymdhis');
$dUrl .="&DT=".date('Y-m-d')."&PD=".$PD."&SUCCURL=".$succUrl;
$dUrl .="&FAILURL=".$failureUrl."&SCODE=".$SCODE."&RSV=&RSV2=";
echo $dUrl;
?>