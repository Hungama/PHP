<?php
//echo 'fine';

//echo "<pre>";
//print_r($_REQUEST);

$servlet="http://10.2.73.156:8080/hungama/Encryptor?msisdn=".$_REQUEST['msisdn']."&srvkey=".$_REQUEST['srvkey']."&ChannelName=".$_REQUEST['ChannelName']."&SourceChannel=".$_REQUEST['SourceChannel'];

echo $servletResponse=file_get_contents($servlet);
//echo "SUCCESS";

?>


