<?php
ob_start();
session_start();
require_once("../2.0/incs/db.php");
require_once("../2.0/language.php");
require_once("../2.0/base.php");
//if ($_GET['action'] == 'download')
$f_array = array_flip($serviceArray);
if(1)
{
//header('Content-Disposition: attachment; filename="downloaded.csv"');
//header("Content-Type: text/csv");
//header("Content-type: application/octet-stream");
//header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
//header("Content-Transfer-Encoding: binary\n");
//header('Content-Disposition: attachment; filename="downloaded.csv"');
$excellFile="TSV-".date("Ymd").".xls";
$S_id=$_REQUEST['S_id'];
//$S_id=1402;
$query = "select S_id,msg_type,msg_desc,circle,kci_type,priority from Inhouse_IVR.tbl_smskci_serviceMsgDetails where S_id='".$S_id."'";

$export = mysql_query ($query,$dbConn ) or die ( "Sql error : " . mysql_error( ) );

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