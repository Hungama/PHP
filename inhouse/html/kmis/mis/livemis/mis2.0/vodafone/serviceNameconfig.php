<?php
function getServiceName($service_id) {
    switch ($service_id) {
        case '1301':
            $service_name = 'VodafoneMU';
            break;
        case '1302':
            $service_name = 'Vodafone54646';
            break;
        case '1303':
            $service_name = 'VodafoneMTV';
            break;
        case '1307':
            $service_name = 'VH1Vodafone';
            break;
        case '1310':
            $service_name = 'REDFMVodafone';
            break;
        case '130202':
            $service_name = 'VodafonePoet';
            break;
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh');
?>