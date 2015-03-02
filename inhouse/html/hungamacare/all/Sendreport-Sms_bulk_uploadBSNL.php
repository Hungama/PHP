<?php
error_reporting(1); 
include ("/var/www/html/hungamacare/config/dbConnect.php"); 
$service_array = array("2202" => "BSNL - 54646");
$StartDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));

$qry = "select count(1) as Total,batch_id from master_db.tbl_new_sms nolock where date(date_time)=date(now()) and batch_id!=0 group by batch_id ";
$exeQry = mysql_query($qry, $dbConn);
$noofrows = mysql_num_rows($exeQry);

if ($noofrows == 0) {
    $message = "No Record Found";
} else {
    $curdate = date("d-m-Y");
    $message = "BSNL SMS bulk upload file status( Total Count in SMS Table )<br/><br/>";
    $message .= '<table border="1" cellpadding="2" width:"70%">';
    $message .= "<tr bgcolor='#FFB6C1'><td style=width:10%>Batch Id</td><td style=width:10%>Total Count</td></tr>";
    while ($rows = mysql_fetch_array($exeQry)) {
        $message .= "<tr bgcolor='#F5DEB3'>";
        $message .="<td style=width:10%>" . $rows['batch_id'] . "</td>";
		$message .="<td style=width:10%>" . $rows['Total'] . "</td>";
        $message .= "</tr>";
    }
    $message .= "</table>";
}
//echo $message;
$from = 'voice.mis@hungama.com';
$subject = 'BSNL Total File Count in SMS Table';
$headers = "From: " . $from . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$curdate = date("Y_m_d");
mail("satay.tiwari@hungama.com", $subject, $message, $headers);
mail("ms.bill@hungama.com", $subject, $message, $headers);
//close database connection here
mysql_close($dbConn);
echo "done";
?>