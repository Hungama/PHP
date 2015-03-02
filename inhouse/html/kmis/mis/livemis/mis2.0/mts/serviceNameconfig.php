<?php
function getServiceName($service_id) {
    switch ($service_id) {
        case '1101':
            $service_name = 'MTSMU';
            break;
        case '1102':
            $service_name = 'MTS54646';
            break;
        case '1126':
            $service_name = 'MTSReg';
            break;
        case '1125':
            $service_name = 'MTSJokes';
            break;
        case '1123':
            $service_name = 'MTSContest';
            break;
        case '1103':
            $service_name = 'MTVMTS';
            break;
        case '1106':
            $service_name = 'MTSFMJ';
            break;
        case '1111':
            $service_name = 'MTSDevo';
            break;
        case '1110':
            $service_name = 'RedFMMTS';
            break;
        case '1116':
            $service_name = 'MTSVA';
            break;
        case '11012':
            $service_name = 'MTSComedy';
            break;
        case '1113':
            $service_name = 'MTSMND';
            break;
        case '1124':
            $service_name = 'MTSAC';
            break;
		case '1108':
            $service_name = 'MTSSU';
            break;			
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh','OTH'=>'Others','UND' => 'Others',' ' => 'Others');
?>