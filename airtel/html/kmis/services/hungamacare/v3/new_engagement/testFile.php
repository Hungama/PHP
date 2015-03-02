<?php

$smsRecord[0] = '7838551197';
$msg = "Shri Ganesha! Get the best lord ganesha puja's, aarti's & prayers only on Airtel sarnam every Friday.Dial 510168";
$sms_cli = 'HMDEVO';
echo $procedureCall = "CALL master_db.SENDSMS(" . $smsRecord[0] . ",\"$msg\",'" . $sms_cli . "',2,'51050','promo')";
//\"$_POST[Name]\"
?>