<?php
echo 'athar';
$wsdl_url = 'http://api.google.com/GoogleSearch.wsdl';
echo $WSDL = new SOAP_WSDL($wsdl_url);
$soap = $WSDL->getProxy( );

$hits = $soap->doGoogleSearch('your google key',$query,0,10,
                               true,'',false,'lang_en','','');

?>