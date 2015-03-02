<?php
$AircelMCfilePath = "http://cmis.hungamavoice.com/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/2.0/Conent.Live_Aircel_Menu.php?a=song";
$getsongdata = file_get_contents($AircelMCfilePath);
$circlefile='aircel-cache/song/song.txt';
				
if (file_exists($circlefile)) {
    //echo "Local Call";
} else {
    //echo "Aircel Server Call";
	error_log($getsongdata,3,$circlefile);
}
exit;
?>