<?php
ob_start();
session_start();
require_once("../../db.php");
$type=$_REQUEST['type'];
$fromdate1=$_REQUEST['fromdate1'];
$todate1=$_REQUEST['todate1'];
$cpgid=$_REQUEST['cpgid'];
if(1)
{
$excellFile="CampgionId($cpgid)-".date("Ymd").".xls";
$query = "select msisdn as MSISDN,processed_at as ProcessedTime,cpgname as CampaignName ,cpgid as CampaignID ,sms as SMS from Inhouse_IVR.tbl_missedcall_smslist where cpgid='".$cpgid."' and date(processed_at) between '".$fromdate1."' and '".$todate1."' and status=1 order by processed_at desc";

$export = mysql_query ($query,$con ) or die ( "Sql error : " . mysql_error( ) );

$fields = mysql_num_fields ( $export );

for ( $i = 0; $i < $fields; $i++ )
{
    $header .= mysql_field_name( $export , $i ) . "\t";
}

while( $row = mysql_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
           $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\r\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}
header("Content-Type: text/csv");
header("Content-type: application/octet-stream");
header('Content-Disposition: attachment; filename="'.$excellFile.'"');
print "$header\r\n$data";

}
exit();

?>