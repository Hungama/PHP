<?php
/*
 //if(isset($_POST['msisdn']))     $msisdn   = $_POST['msisdn'];
 //if(isset($_POST['src']))   $src   = $_POST['src'];
 $msisdn='8587800665';
 $src='WAP';
 //if(isset($_POST['Message']))   $Message= htmlentities($_POST['Message']);
 $posturl="http://124.153.75.198/fanpage/limitlessmusic/limitlessmusic.php";
 $Curl_Session = curl_init($posturl);
 curl_setopt ($Curl_Session, CURLOPT_POST, 1);
 curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, "msisdn=$msisdn&src=$src");
 curl_setopt ($Curl_Session, CURLOPT_FOLLOWLOCATION, 1);
 curl_exec ($Curl_Session);
 curl_close ($Curl_Session);
 header("Location:http://202.87.41.147/hungamawap/aircel/176796/index2.php3?vname=");
 */
 $posturl='http://202.87.41.147/hungamawap/aircel/181112/index2.php3';
?>
<?php $str = "<a href='".$posturl."' ><u> Click Here to subscribe @Rs.30 for 30 days with 100 mins FREE.</u><br/></a>"; 
echo $str;
?>