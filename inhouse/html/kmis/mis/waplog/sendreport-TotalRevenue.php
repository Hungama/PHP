<?php
error_reporting(1);
$con = mysql_connect("192.168.100.224","webcc","webcc");
if (!$con)
 {
  die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
$prevdate = date("Ymd", time() - 60 * 60 * 24);
$prevdate_email = date("Y-m-d", time() - 60 * 60 * 24);

//$prevdate_email='2012-12-25';
function getTotalRevenue($prevdate,$operator)
 {
//retrive data from database--- id,serviceName,service_id,fileRevenue,mainRevenu,added_on,status,operator
$getdatasql=mysql_query("select serviceName,service_id,fileRevenue,mainRevenu,date(added_on) as added_on,status,operator from master_db.tbl_revenueData where operator='$operator' and date(added_on)='$prevdate' and status=1");
//begin of HTML message 
$message = '<html><body>';
		    $message .= '<table rules="all" style="border-color: #666;" border="0" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td><strong>Service Name</strong> </td><td><strong>SDP Revenue</strong> </td><td><strong>Billing Revenu</strong> </td><td><strong>Added On</strong> </td><td><strong>Operator</strong> </td></tr>";
while($result=mysql_fetch_array($getdatasql))
{
$message .= "<tr style='background: #ADD8E6;'><td><strong>".$result['serviceName']."</strong> </td><td>" .number_format($result['fileRevenue'])."</td><td>".number_format($result['mainRevenu'])."</td><td>".$result['added_on']."</td><td>".$result['operator']."</td></tr>";
}
	
$message .= "</table>";
$message .="<p><Strong><img src='http://119.82.69.212/digi/digiobd/img/Hlogo.png'/><Strong><br><span style='font-size:9px'>PLEASE DO NOT REPLY TO THIS MAIL. THIS IS AN AUTO GENERATED MAIL AND REPLIES TO THIS EMAIL ID ARE NOT ATTENDED TO.</span></p>";
			$message .= "</body></html>";
   //end of message 
mysql_close($con);
//close database connection here

$to = 'satay.tiwari@hungama.com';
				$from = 'voice.mis@hungama.com';
			
			$subject = 'Revenue data of '.$prevdate." for ".$operator;
			
			$headers = "From: " . $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            if (mail($to, $subject, $message, $headers)) {
              return '1';
            } else {
              return '0';
            }	

//return $message;	 
	 }
//UNIM and TATM
$operator='UNIM';
$response_unim= getTotalRevenue($prevdate_email,$operator);
$operator='TATM';
$response_tatm= getTotalRevenue($prevdate_email,$operator);		             

if($response_unim=='1' || $response_tatm=='1')
{
echo "1";
}
else
{
echo "0";
}
?>
