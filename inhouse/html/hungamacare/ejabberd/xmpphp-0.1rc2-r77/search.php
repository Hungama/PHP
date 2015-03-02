<?php
$keyword='dil';
$getmessagedata="http://uninor-vas.hungamavoice.com/uninor/web/html/search_jabber.php?stxt=".$keyword."&service=mu";
echo $message = file_get_contents($getmessagedata);
?>